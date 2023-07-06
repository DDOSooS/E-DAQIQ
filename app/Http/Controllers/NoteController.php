<?php

namespace App\Http\Controllers;

use App\Models\Cabinet;
use App\Models\Dossier;
use App\Models\Frais;
use App\Models\Honoraire;
use App\Models\NatureFrais;
use App\Models\Note;
use App\Models\Transition;
use App\Models\Type;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Dompdf\Options;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Storage;

class NoteController extends Controller
{


    //get all invoices for a case
    /**
     * @param $dossier_id
     * @return Application|Factory|View
     */
    function getInvoicesByCase($dossier_id): View|Factory|Application
    {

        $notes =Note::where('dossier_id',$dossier_id)->get();
        foreach ($notes as $note) {
            $client = $note->dossier->client;
            if ($client->type == "ClientsSociete") {
                $ClientData = $client->ClientsSociete->nomSte;
            } else {
                $ClientData = $client->ClientsPhysique->nom ." ". $client->ClientsPhysique->prenom;
            }
            $note->setAttribute('nom', $ClientData);
        }

        return view('pages.tables.invoices-table',compact('notes','dossier_id'));

    }

    //get all invoices function

    /**
     * @return Application|Factory|View
     */
    function invoicesListe(){

            $cabinetId = session()->get('cabinet_id');

            $invoices = Note::join('dossier', 'notes.dossier_id', '=', 'dossier.id')
                ->join('clients', 'dossier.client_id', '=', 'clients.id')
                ->where('clients.cabinet_id', $cabinetId)
                ->get();

            foreach ($invoices as $invoice) {
                $client = $invoice->dossier->client;

                if ($client->type == "ClientsSociete") {
                    $ClientData = $client->ClientsSociete->nomSte;
                } else {
                    $ClientData = $client->ClientsPhysique->nom;
                }

                $invoice->setAttribute('nom', $ClientData);
            }

            return view('pages.tables.invoices', compact('invoices'));
        }



    // add cost form

    /**
     * @param $dossier_id
     * @return Application|Factory|View
     */
    function addCostForm($dossier_id){

        $natures = NatureFrais::pluck('titleFrais')->toArray();
        return view('pages.forms.add-cost', compact('dossier_id','natures'));

    }

    // store costs

    /**
     * @param Request $request
     * @param $dossier_id
     * @return RedirectResponse
     */
    function addCost(Request $request,$dossier_id){

        $validatedData = $request->validate([
            'montantC.*' => 'required|numeric',
            'montantL.*' => 'required|string',
            'typeFrais.*' => 'required',
            'detail.*' => 'nullable|string',
        ]);

        $montantCArray = $request->input('montantC');
        $montantLArray = $request->input('montantL');
        $typeFraisArray = $request->input('typeFrais');
        $detailArray = $request->input('detail');

        $currentMonth = Carbon::now()->format('m'); // Get the current month

        $note = Note::where('dossier_id', $dossier_id)->first();
        if ($note) {
            $noteId=$note->id;
        }
        else{

            $maxId= Note::max('id');
            if ($maxId === null){
                $maxId=1;
            }else{
                $maxId+=1;
            }

            $month = Carbon::now()->locale('fr_FR')->monthName;
            $currentYear = Carbon::now()->format('Y');

            $numNote=$maxId."/".$month."/".$currentYear;

            $newNote = new Note();
            $newNote->dossier_id=$dossier_id;
            $newNote->numNote=$numNote;
            $newNote->month=$currentMonth;
            $newNote->save();

            $notes = Note::where('dossier_id', $dossier_id)
                ->first();

            if ($notes) {
                $noteId = $notes->id;
            } else {
                // Handle the case when no matching record is found
                $noteId = null; // or any other default value you prefer
            }

        }

            foreach ($montantCArray as $key => $montantC) {

               $montantL = $montantLArray[$key];
                $typeFrais = $typeFraisArray[$key];
                $detail = $detailArray[$key];

                $natureId=NatureFrais::where('titleFrais',$typeFrais)->pluck('id');

                $member = new Frais();
                $member->nature_id = $natureId[0];
                $member->note_id  = $noteId;
                $member->amountInFigure = $montantC;
                $member->amountInWorld = $montantL;
                $member->detail = $detail;
                $member->save();

                $note=Note::find($noteId);

                if ($note) {
                    $totalAmount = $note->totalAmount ?? 0; // If totalAmount is null or empty, set it to 0
                    $note->totalAmount = $totalAmount + $montantC;
                    $note->save();
                }
            }
            return redirect()->route('invoicesCase',$dossier_id);
    }

    //show fees form

    /**
     * @param $dossier_id
     * @return Application|Factory|View
     */
    function addFeesForm($dossier_id){

        $types = Type::pluck('typeHonoraire')->toArray();
        return view('pages.forms.add-fees', compact('dossier_id','types'));

    }

    // add fees for a case

    /**
     * @param Request $request
     * @param $dossier_id
     * @return RedirectResponse
     */
     function addFees(Request $request,$dossier_id){
         $validatedData = $request->validate([
             'montantC.*' => 'required|numeric',
             'montantL.*' => 'required|string',
             'typeHonoraire.*' => 'required',
             'natureHonoraire.*' => 'nullable|string',
         ]);

         $montantCArray = $request->input('montantC');
         $montantLArray = $request->input('montantL');
         $typeHonoraireArray = $request->input('typeHonoraire');
         $natureHonoraireArray = $request->input('natureHonoraire');

         $currentMonth = Carbon::now()->format('m'); // Get the current month

         $note = Note::where('dossier_id', $dossier_id)
             ->first();
         if ($note) {
             $noteId=$note->id;
         }
         else{

             $maxId= Note::max('id');
             if ($maxId === null){
                 $maxId=1;
             }else{
                 $maxId+=1;
             }

             $month = Carbon::now()->locale('fr_FR')->monthName;
             $currentYear = Carbon::now()->format('Y');

             $numNote=$maxId."/".$month."/".$currentYear;

             $newNote = new Note();
             $newNote->dossier_id=$dossier_id;
             $newNote->numNote=$numNote;
             $newNote->month=$currentMonth;
             $newNote->save();

             $notes = Note::where('dossier_id', $dossier_id)
                 ->first();

             if ($notes) {
                 $noteId = $notes->id;
             } else {
                 // Handle the case when no matching record is found
                 $noteId = null; // or any other default value you prefer
             }

         }

         foreach ($montantCArray as $key => $montantC) {

             $montantL = $montantLArray[$key];
             $typeHonoraire = $typeHonoraireArray[$key];
             $natureHonoraire = $natureHonoraireArray[$key];

             $natureId=Type::where('typeHonoraire',$typeHonoraire)->pluck('id');

             $member = new Honoraire();
             $member->type_id = $natureId[0];
             $member->note_id  = $noteId;
             $member->amounInFigure = $montantC  ;
             $member->amounInWords = $montantL;
             $member->nature = $natureHonoraire;
             $member->save();

             $note=Note::find($noteId);

             if ($note) {
                 $totalAmount = $note->totalAmount ?? 0; // If totalAmount is null or empty, set it to 0
                 $note->totalAmount = $totalAmount + $montantC *0.2+ $montantC;
                 $note->save();
             }
         }
         return redirect()->route('invoicesCase',$dossier_id);
     }


     //transition form function

    /**
     * @param $dossier_id
     * @return Application|Factory|View
     */
    function transitionForm($dossier_id){
        $currentMonth = Carbon::now()->format('m');
        $note = Note::where('dossier_id', $dossier_id)
            ->value('id');
        return view('pages.forms.add-transition',compact('note'));

    }


    //add a transitioin

    /**
     * @param Request $request
     * @param $dossier_id
     * @return RedirectResponse
     */
    function addTransition(Request $request,$note_id){

        $rules = [
            'montantC' => 'required|numeric',
            'typePaiment' => 'required',
        ];

        $validatedData = $request->validate($rules);

        $note = Note::find($note_id);
        $oldGivenAmount = $note->givenAmount ?? 0;
        $note->givenAmount=$oldGivenAmount + $validatedData['montantC'];
        $note->save();

        $transition = new Transition();
        $transition->note_id=$note_id;
        $transition->type=$validatedData['typePaiment'];
        $transition->amount=$validatedData['montantC'];
        $transition->save();



        return redirect()->route('invoicesCase',['id'=>$note->dossier_id]);

    }



    function translateToArabicLetters($number) {
        $arabicLetters = [
            'صفر', 'واحد', 'اثنان', 'ثلاثة', 'أربعة', 'خمسة',
            'ستة', 'سبعة', 'ثمانية', 'تسعة', 'عشرة',
            'أحد عشر', 'اثنا عشر', 'ثلاثة عشر', 'أربعة عشر', 'خمسة عشر',
            'ستة عشر', 'سبعة عشر', 'ثمانية عشر', 'تسعة عشر', 'عشرون',
            'ثلاثون', 'أربعون', 'خمسون', 'ستون', 'سبعون',
            'ثمانون', 'تسعون', 'مائة', 'مائتان', 'ثلاثمائة',
            'أربعمائة', 'خمسمائة', 'ستمائة', 'سبعمائة', 'ثمانمائة',
            'تسعمائة', 'ألف', 'ألفان', 'آلاف', 'مليون', 'مليونان',
            'ملايين', 'مليار', 'ملياران', 'مليارات'
        ];

        $digits = str_split(strrev((string)$number));
        $digitsCount = count($digits);

        if ($digitsCount === 1) {
            return $arabicLetters[$number];
        } elseif ($digitsCount === 2) {
            if ($number <= 20) {
                return $arabicLetters[$number];
            } else {
                $ones = $digits[0];
                $tens = $digits[1] * 10;
                return $arabicLetters[$tens] . ' و' . $arabicLetters[$ones];
            }
        } elseif ($digitsCount === 3) {
            $ones = $digits[0];
            $tens = $digits[1] * 10;
            $hundreds = $digits[2] * 100;
            return $arabicLetters[$hundreds] . ' و' . $arabicLetters[$tens] . ' و' . $arabicLetters[$ones];
        } elseif ($digitsCount === 4) {
            $ones = $digits[0];
            $tens = $digits[1] * 10;
            $hundreds = $digits[2] * 100;
            $thousands = $digits[3] * 1000;
            if ($number % 1000 === 0) {
                return $arabicLetters[$thousands] . ' ' . $arabicLetters[36];
            } else {
                return $arabicLetters[$thousands] . ' ' . $arabicLetters[36] . ' و' . $arabicLetters[$hundreds] . ' و' . $arabicLetters[$tens] . ' و' . $arabicLetters[$ones];
            }
        } else {
            return 'غير مدعوم';
        }
    }

    //view an invoice function

    /**
     * @param $dossier_id
     * @return Application|Factory|View
     */
    function viewInvoice($dossier_id){
        $note = Note::where('dossier_id', $dossier_id)->first();
        $transitions = $note->transition;
        $dossier = $note->dossier;
        $client = $note->dossier->client;
        $adversaire = $client->adversaires;
        $nomC = '';
        $adresse = '';
        $type = '';

        if ($client->type == "ClientsSociete") {
            $nomC = $client->ClientsSociete->nomSte;
            $adresse = $client->ClientsSociete->sige;
            $type = 1;
        } else {
            $nomC = $client->ClientsPhysique->nom . ' ' . $client->ClientsPhysique->prenom;
            $adresse = $client->ClientsPhysique->adresse1;
            $type = 0;
        }

        $frais = $note->frais;
        $honoraires = $note->honoraires;

        $nom = ''; // Initialize $nom variable here

        foreach ($adversaire as $adversair) {
            $nom = $adversair->nom;
        }

        $date = Carbon::now()->locale('fr_FR');
        $currentDate = $date->format('d/m/Y');

        $totalHonoraires = 0;
        foreach ($honoraires as $honoraire) {
            $totalHonoraires += $honoraire->amounInFigure;
        }

        $totalFrais = 0;
        foreach ($frais as $frai) {
            $totalFrais += $frai->amountInFigure;
        }

        $tva = $totalHonoraires * 0.2;
        $totalAmount = $totalHonoraires + $tva + $totalFrais;

        $cabinet = Cabinet::find(session()->get('cabinet_id'));
//dd($nom);
        return view('pages.tables.invoice-table2', compact('note', 'tva', 'transitions', 'honoraires', 'dossier', 'client', 'adversaire', 'frais', 'currentDate', 'type', 'nom', 'nomC', 'adresse', 'totalAmount', 'cabinet'));
    }


    //download invoice function

    /**
     * @param Request $request
     * @return JsonResponse
     */
//    function generate(Request $request){
//
//        $dossier_id =  $request->query('param');
//
//        $note=Note::where('dossier_id',$dossier_id)->first();
//        $transitions = $note->transition;
//        $dossier = $note->dossier;
//        $client=$note->dossier->client;
//        $adversaire=$client->adversaires;
//        $nomC='';
//        $adresse='';
//        $type='';
//
//        if($client->type == "ClientsSociete"){
//            $nomC=$client->ClientsSociete->nomSte;
//            $adresse=$client->ClientsSociete->sige;
//            $type=1;
//        }else{
//            $nomC=$client->ClientsPhysique->nom .''.$client->ClientsPhysique->prenom;
//            $adresse=$client->ClientsPhysique->adresse1;
//            $type=0;
//
//        }
//        $frais = $note->frais;
//        $honoraires = $note->honoraires;
//
//
//        foreach ($adversaire as $adversair) {
//            $nom =$adversair->nom;
//        }
//        $date = Carbon::now()->locale('fr_FR');
//        $currentDate = $date->format('d/m/Y');
//        // Output: 11/06/2023
//
//        // dd($note->numNote);
//        $totalHonoarire=0;
//        foreach($honoraires as $honoraire){
//
//            $totalHonoarire+=$honoraire->amounInFigure;
//        }
//        $totalFrais=0;
//
//        foreach($frais as $frai){
//
//            $totalFrais+=$frai->amountInFigure;
//        }
//        $tva=$totalHonoarire*0.2;
//        $totalAmount=$totalHonoarire+$tva+$totalFrais;
//
//        // Load the HTML content from the view and pass the data
//dd($nom)
//        $htmlContent = view('pages.tables.invoice-table1',compact('note','tva','transitions','honoraires','dossier','client','adversaire','frais','currentDate','type','nom','nomC','adresse','totalAmount'))->render();
//
//        return response()->json(['htmlContent' => $htmlContent]);
//    }

    //costs list function

    /**
     * @param $note
     * @return Application|Factory|View
     */
    function costList($note){

            $costs=Frais::where('note_id',$note)->get();

            foreach ($costs as $cost){
                $cost->setAttribute('nature',$cost->natureFrais->titleFrais);
            }

        return view('pages.tables.frais',compact('costs'));
    }


    //edit a cost form
    function editCostForm($id){
        $frais =Frais::find($id);

        $natures = NatureFrais::all('id','titleFrais');

        return view('pages.forms.edit-cost',compact('frais','natures'));
    }


    //edit const

    /**
     * @param Request $request
     * @param $frais_id
     * @return Application|RedirectResponse|Redirector
     */
    function editCost(Request $request,$frais_id){

        $validatedData = $request->validate([
            'montantC' => 'required|numeric',
            'montantL' => 'required|string',
            'typeFrais' => 'required',
            'detail' => 'nullable|string',
        ]);

        $montantC = $request->input('montantC');
        $montantL = $request->input('montantL');
        $typeFrais = $request->input('typeFrais');
        $detail = $request->input('detail');

        $frais=Frais::find($frais_id);
        $oldFrais=$frais->amountInFigure;
        $frais->amountInFigure=$montantC;
        $frais->amountInWorld=$montantL;
        $frais->nature_id=$typeFrais;
        $frais->detail=$detail;
        $frais->save();
        $note = Note::find($frais->note_id);
        $note->totalAmount= $note->totalAmount + $validatedData['montantC'] - $oldFrais;
        $note->save();


        return redirect(url('/view-frais',$frais->note_id));

    }

    //delete a cost

    /**
     * @param $cost
     * @return Application|RedirectResponse|Redirector
     */
    function deleteCost($cost){
        $frais =Frais::find($cost);
        $note=Note::find($frais->note_id);
        $note->totalAmount=$note->totalAmount-$frais->amountInFigure;
        $note->save();
        $frais->delete();

        return redirect(url('/view-frais',$note->id));
    }

    // invoice fees list
    function feesList($note){
        $fees=Honoraire::where('note_id',$note)->get();

        foreach ($fees as $fee){
            $fee->setAttribute('type',$fee->type->typeHonoraire);
        }

        return view('pages.tables.honoraires',compact('fees'));
    }


    //edit fees Form
    /**
     * @param $fees_id
     * @return Application|Factory|View
     */
    function editFeesForm($fees_id){

        $Honoraires = Honoraire::find($fees_id);
        $types = Type::all('id','typeHonoraire');

        return view('pages.forms.edit-fees', compact('Honoraires','types'));
    }

    //edit a fees

    /**
     * @param Request $request
     * @param $fees_id
     * @return Application|RedirectResponse|Redirector
     */
    function editFees(Request $request,$fees_id){
        $validatedData = $request->validate([
            'montantC' => 'required|numeric',
            'montantL' => 'required|string',
            'typeHonoraire' => 'required',
            'natureHonoraire' => 'nullable|string',
        ]);

        $montantC = $request->input('montantC');
        $montantL = $request->input('montantL');
        $typeHonorair = $request->input('typeHonoraire');
        $natureHonorair = $request->input('natureHonoraire');

        $Honoraires = Honoraire::find($fees_id);
        $Honoraires->type_id =$typeHonorair ;
        $oldHonoraire= $Honoraires->amounInFigure ;
        $Honoraires->amounInFigure = $montantC;
        $Honoraires->amounInWords = $montantL;
        $Honoraires->nature = $natureHonorair;
        $Honoraires->save();

        $note = Note::find($Honoraires->note_id);
        $note->totalAmount= $note->totalAmount + $validatedData['montantC'] *0.2 + $validatedData['montantC'] - $oldHonoraire*0.2 -$oldHonoraire ;
        $note->save();


        return redirect(url('/view-honoraire',$Honoraires->note_id));
    }

    // delete fees

    /**
     * @param $fees_id
     * @return Application|RedirectResponse|Redirector
     */
    function deleteFees($fees_id){

        $honoraires = Honoraire::find($fees_id);
        $note=Note::find($honoraires->note_id);
        $note->totalAmount=$note->totalAmount-$honoraires->amounInFigure-$honoraires->amounInFigure*0.2;
        $note->save();
        $honoraires->delete();
        return redirect(url('/view-honoraire',$note->id));
    }

    //transitions list

    /**
     * @param $note
     * @return Application|Factory|View
     */
    function transitionList($note){

        $transitions=Transition::where('note_id',$note)->get();
        return view('pages.tables.transition',compact('transitions'));
    }

    //edit a transition form

    /**
     * @param $transition_id
     * @return Application|Factory|View
     */
    function editTransitionForm($transition_id){
        $transition =Transition::find($transition_id);
        return view('pages.forms.edit-transition',compact('transition'));
    }

    //EDIT A TRANSITION
    function editTransition(Request $request,$transition_id){
        $rules = [
            'montantC' => 'required|numeric',
            'typePaiment' => 'required',
        ];

        $validatedData = $request->validate($rules);

        $transition =  Transition::find($transition_id);
        $oldTransition=$transition->amount;
        $transition->type=$validatedData['typePaiment'];
        $transition->amount=$validatedData['montantC'];
        $transition->save();

        $note = Note::find($transition->note_id);
        $note->givenAmount=$note->givenAmount + $validatedData['montantC'] - $oldTransition;
        $note->save();

        return  redirect(url('/view-transition',$note->id));

    }
    /**
     * @param Request $request
     * @return JsonResponse
     */
    function translateToArabic(Request $request){
        $data =$request->input('number');
        $number= $this->translateToArabicLetters($data);
        return Response()->json(['translation' => $number]);
    }

}
