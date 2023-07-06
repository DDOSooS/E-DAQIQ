<?php

namespace App\Http\Controllers;

use App\Exports\CasesExport;
use App\Exports\TableExport;
use App\Models\Clients;
use App\Models\Dossier;
use App\Models\DossierHistorique;
use App\Models\NatureDossier;
use App\Models\Piece;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use function PHPUnit\Framework\isEmpty;

class DossierController extends Controller
{


    //show all  cases
    /**
     * @return Application|Factory|View
     */
    function index()
    {
        $cabinetId = session()->get('cabinet_id');

        $dossiers = Dossier::whereHas('client', function ($query) use ($cabinetId) {
            $query->where('cabinet_id', $cabinetId);
        })->get();
//    dd($cabinetId);
        return view('pages.tables.cases', compact('dossiers'));
    }


    //show case form

    /**
     * @return Application|Factory|View
     */
    function showCaseForm(){

        $villes =[
            'الرباط','مراكش','إفران','مكناس','فاس','الرشيدية','أكادير','كلميم','العيون','الداخلة','سلا','القنيطرة','بني ملال','طنجة','تطوان','وجدة','بركان','الناظور','المحمدية','الدار البيضاء','الجديدة'
        ];

        return view('pages.forms.add-case',compact('villes'));

    }


    // add a case function

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    function storeCase(Request $request): RedirectResponse
    {


        //validate data
        $validationRule =[
            'vref' => 'required',
            'nref' => 'required',
            'ice' => 'required|min:15|max:15',
            'typeJuridiction' => 'required',
            'sectionJuridiction' => 'required',
            'villeJuridiction' => 'required',
            'numberCase' => 'nullable',
            'codeCase' => 'nullable',
            'yearCase' => 'nullable|min:4|max:4',
            'etatProcedurale' => 'required',
            'dateEtatProcedurale' => 'required|date',
        ];

        $validatedData = $request->validate($validationRule);

        // foreign keys
        $membre=session()->get('membre_id');
        $client=Clients::where('nReference','=',$validatedData['nref'])
            ->where('cabinet_id',session()->get('cabinet_id'))
            ->first();


        // add Case data
        $numJuridiction=$validatedData['numberCase']."/".$validatedData['codeCase']."/".$validatedData['yearCase'];
        $dossier = new Dossier();

        $dossier->typeJuridiction = $validatedData['typeJuridiction'];
        $dossier->sectionJuridiction = $validatedData['sectionJuridiction'];
        $dossier->villeJuridiction = $validatedData['villeJuridiction'];
        $dossier->votreReference = $validatedData['vref'];
        $dossier->numJuridiction = $numJuridiction;
        $dossier->etatProcedurale = $validatedData['etatProcedurale'];
        $dossier->dateEtatProcedurale = $validatedData['dateEtatProcedurale'];

        $dossier->member_id = $membre;
        $dossier->client_id = $client->id;
        $dossier ->save();
        return redirect()->route('cases');

    }

    // edite case form

    /**
     * @param $id
     * @return Application|Factory|View
     */
    function  editCaseForm($id){
        $villes =[
            'الرباط','مراكش','إفران','مكناس','فاس','الرشيدية','أكادير','كلميم','العيون','الداخلة','سلا','القنيطرة','بني ملال','طنجة','تطوان','وجدة','بركان','الناظور','المحمدية','الدار البيضاء','الجديدة'
        ];
        $dossier= Dossier::findOrFail($id);
        $client= Clients::findOrFail($dossier->client_id);
        $numJuridiction = explode('/',$dossier->numJuridiction);
        $nature="";

        $nature = NatureDossier::find($dossier->nature_id);


        return view('pages.forms.edit-case',compact('dossier','numJuridiction','nature','villes','client'));
    }

    //handle editCase

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    function editCase(Request $request,$dossierId){

        //validate data

        $validationRule =[
            'vref' => 'required',
            'nref' => 'required',
            'ice' => 'required|min:15|max:15',
            'typeJuridiction' => 'required',
            'sectionJuridiction' => 'required',
            'villeJuridiction' => 'required',
            'numberCase' => 'nullable',
            'codeCase' => 'nullable',
            'yearCase' => 'nullable|min:4|max:4',
            'etatProcedurale' => 'required',
            'dateEtatProcedurale' => 'required|date',
        ];

        $validatedData = $request->validate($validationRule);

        // foreign keys

        $membre=session()->get('membre_id');
        $cid=session()->get('user_id');
        $client=Clients::where('nReference','=',$validatedData['nref'])->first();

        // add Case data

        $numJuridiction=$validatedData['numberCase']."/".$validatedData['codeCase']."/".$validatedData['yearCase'];

        $updatedFields = [];

        $dossier= Dossier::find($dossierId);
        $dossier->typeJuridiction = $validatedData['typeJuridiction'];
        $dossier->sectionJuridiction = $validatedData['sectionJuridiction'];
        $dossier->villeJuridiction = $validatedData['villeJuridiction'];
        $dossier->votreReference = $validatedData['vref'];
        $dossier->numJuridiction = $numJuridiction;
        $dossier->etatProcedurale = $validatedData['etatProcedurale'];
        $dossier->dateEtatProcedurale = $validatedData['dateEtatProcedurale'];
        $dossier->client_id = $client->id;

        foreach ($dossier->getDirty() as $field => $value) {
            $updatedFields[] = $field;
        }
        $dossier->save();

     //   add a case history
            $decription = "";

            if (!empty($updatedFields)) {
                $User = User::find($cid);

                foreach ($updatedFields as $index => $field) {

                    if ($index == array_key_last($updatedFields)) {
                        $decription .= "  تم تحديث $field , ";
                    }
                    if ($index !== array_key_last($updatedFields)) {
                        $decription .= "   تم تحديث  $field   ,و   ";
                    }
                    if ($index == array_key_last($updatedFields)) {
                        $decription .= " بواسطة   $User->name  $User->lastname ";
                    }
                }
                $dossierHitoriques = new DossierHistorique();
                $dossierHitoriques->dossier_id=$dossier->id;
                $dossierHitoriques->member_id=$membre;
                $dossierHitoriques->description=$decription;
                $dossierHitoriques->save();
            }

        return redirect()->route('cases');
    }


    //edit case stautus form function
    function editCaseStatusForm($dossier){
        $villes =[
            'الرباط','مراكش','إفران','مكناس','فاس','الرشيدية','أكادير','كلميم','العيون','الداخلة','سلا','القنيطرة','بني ملال','طنجة','تطوان','وجدة','بركان','الناظور','المحمدية','الدار البيضاء','الجديدة'
        ];
        $dossier= Dossier::findOrFail($dossier);
        $client= Clients::findOrFail($dossier->client_id);
        $numJuridiction = explode('/',$dossier->numJuridiction);
        $nature="";

        $nature = NatureDossier::find($dossier->nature_id);


        return view('pages.forms.edit-case-status',compact('dossier','numJuridiction','nature','villes','client'));
    }


    //edit case status function

    /**
     * @param Request $request
     * @param $dossierId
     * @return RedirectResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    function editCaseStatus(Request $request,$dossierId){

        //validate data

        $validationRule =[
            'vref' => 'required',
            'nref' => 'required',
            'ice' => 'required|min:15|max:15',
            'typeJuridiction' => 'required',
            'sectionJuridiction' => 'required',
            'villeJuridiction' => 'required',
            'numberCase' => 'nullable',
            'codeCase' => 'nullable',
            'yearCase' => 'nullable|min:4|max:4',
            'etatProcedurale' => 'required',
            'dateEtatProcedurale' => 'required|date',
            'numberDecision' => 'required',
            'yearDecision' => 'required|min:4|max:4',
            'tinymce' => 'nullable',
            'terme' => 'required|string',
        ];

        $validatedData = $request->validate($validationRule);

        // foreign keys

        $membre=session()->get('membre_id');
        $cid=session()->get('user_id');
        $client=Clients::where('nReference','=',$validatedData['nref'])->first();

        $nature=NatureDossier::where('typeDossier','=',$validatedData['terme'])->first();

        // add Case data

        $numJuridiction=$validatedData['numberCase']."/".$validatedData['codeCase']."/".$validatedData['yearCase'];

        $updatedFields = [];

        $dossier= Dossier::find($dossierId);
        $dossier->typeJuridiction = $validatedData['typeJuridiction'];
        $dossier->sectionJuridiction = $validatedData['sectionJuridiction'];
        $dossier->villeJuridiction = $validatedData['villeJuridiction'];
        $dossier->votreReference = $validatedData['vref'];
        $dossier->numJuridiction = $numJuridiction;
        $dossier->etatProcedurale = $validatedData['etatProcedurale'];
        $dossier->dateEtatProcedurale = $validatedData['dateEtatProcedurale'];
        $dossier->numDecision = $validatedData['numberDecision'];
        $dossier->dateDecision = $validatedData['yearDecision'];
        $dossier->jugeRapporteur = $validatedData['tinymce'];
        $dossier->status = 1;
        $dossier->nature_id = $nature->id;
        $dossier->client_id = $client->id;

        foreach ($dossier->getDirty() as $field => $value) {
            $updatedFields[] = $field;
        }
        $dossier->save();

        //   add a case history
        $decription = "";

        if (!empty($updatedFields)) {
            $User = User::find($cid);

            foreach ($updatedFields as $index => $field) {

                if ($index == array_key_last($updatedFields)) {
                    $decription .= "  تم تحديث $field , ";
                }
                if ($index !== array_key_last($updatedFields)) {
                    $decription .= "   تم تحديث  $field   ,و   ";
                }
                if ($index == array_key_last($updatedFields)) {
                    $decription .= " بواسطة   $User->name  $User->lastname ";
                }
            }
            $dossierHitoriques = new DossierHistorique();
            $dossierHitoriques->dossier_id=$dossier->id;
            $dossierHitoriques->member_id=$membre;
            $dossierHitoriques->description=$decription;
            $dossierHitoriques->save();
        }




        return redirect()->route('cases');
    }

    // cases history

    /**
     * @param $caseId
     * @return Application|Factory|View
     */
    function casesHistory($caseId){

        $dossierHistorique=DossierHistorique::where('dossier_id','=',$caseId)->get();

        return view('pages.tables.cases-history',compact('dossierHistorique'));

    }


    //get the case type live search

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getResults(Request $request)
    {
        $term = $request->input('term');
        $results = NatureDossier::where('typeDossier', 'LIKE', "%$term%")->pluck('typeDossier');

        return response()->json($results);
    }

    //get the client data live search public
    // sear for the oppenent  by last name
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function searchClient(Request $request)
    {
        $ref = $request->input('name');

        // Perform the search query based on the name
        $client = Clients::where('nReference', 'like', "%$ref%")
            ->first();

        return response()->json($client);
    }

    //delete a case

    /**
     * @param $dossierID
     * @return RedirectResponse
     */
    function deleteCase($dossierID): RedirectResponse
    {
        $dossier= Dossier::find($dossierID);
        $dossier->Pieces()->delete();
        $dossier->Note()->delete();
        $dossier->delete();
        return redirect()->back()->with('success', 'Client deleted successfully');
    }


    // export option

    /**
     * @return BinaryFileResponse
     */
    public function exportCase()
    {
        $cases = Dossier::all();

        foreach ($cases as $case) {

            $client = $case->client;

            if ($client->type == "ClientsSociete") {

                $ClientData = $client->ClientsSociete->nomSte;

            } else {

                $ClientData = $client->ClientsPhysique->nom ." ". $client->ClientsPhysique->prenom;

            }

            $adversaires=$client->adversaires;

            foreach ($adversaires as $adversaire) {
                $adversaireName = $adversaire->nom .' ' .$adversaire->prenom;

            }

            $case->setAttribute('client', $ClientData);
            $case->setAttribute('adversaire', $adversaireName);

        }
        return Excel::download(new CasesExport($cases), 'cases.xlsx');
    }

    //upload files function

    /**
     * @param $id
     * @return Application|Factory|View
     */
    function uploadFiles($id){
        $dossier_id=$id;
        $files=Piece::where('dossier_id','=',$id)->get();
        return view('pages.tables.cases-files',compact('files','dossier_id'));
    }

    // show upload form

    /**
     * @param $dossier_id
     * @return Application|Factory|View
     */
    function showUploadForm($dossier_id){
        $dossier=$dossier_id;
        return view('pages.forms.upload-case-file',compact('dossier'));
    }

    public function uploadFile(Request $request,$dossierId)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required',
            'file' => 'nullable', // Adjust the file types and size limit as needed
        ]);

        if ($request->hasFile('file')) {
            $file = $validatedData['file'];
            $timestamp = time();
            $logoName = $timestamp . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/img', $logoName);
        } else {
            $path = ''; // Assign a default  value here
        }

// Create a new "Piece" record in the database
        $piece = new Piece();
        $piece->title = $validatedData['title'];
        $piece->path = $path;
        $piece->dossier_id = $dossierId;
        $piece->save();

// Redirect back or to another page
        return redirect()->route('files', ['id' => $dossierId]);

    }

    //change staus of case

    /**
     * @param Request $request
     * @param $dossier
     * @param $status
     * @return RedirectResponse
     */
    public function changeStatus(Request $request, $dossier, $status)
    {
        // Retrieve the dossier based on the $dossier parameter
        $dossier = Dossier::findOrFail($dossier);

        // Update the status of the dossier
        $dossier->status = $status;
        $dossier->save();

        return redirect()->route('cases')->with('success', 'Status updated successfully');
    }



    public function download($file)
    {
        $path = storage_path('app/' . $file);

        if (file_exists($path)) {
            return response()->download($path);
        }

        abort(404);
    }


    // CASES COUNT BY MONTH function

    /**
     * @return JsonResponse
     */
    public function monthlyCases()
    {
        try {
            $cabinetId = session()->get('cabinet_id'); // Specify the desired cabinet ID

            $monthlyCases = Dossier::selectRaw('COUNT(*) as case_count, DATE_FORMAT(created_at, "%Y-%m") as month')
                ->whereHas('client', function ($query) use ($cabinetId) {
                    $query->where('cabinet_id', $cabinetId);
                })
                ->groupBy('month')
                ->orderBy('month')
                ->get();


            return response()->json($monthlyCases);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error in monthlyCases method: ' . $e->getMessage());
            // Return an error response
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }





    //admin chart data

    /**
     * @return JsonResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function monthlyCases1()
    {
        try {
            $cabinetId = session()->get('cabinet_id'); // Specify the desired cabinet ID

            $monthlyCases = Dossier::selectRaw('COUNT(*) as case_count, DATE_FORMAT(created_at, "%Y-%m") as month')

                ->groupBy('month')
                ->orderBy('month')
                ->get();


            return response()->json($monthlyCases);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error in monthlyCases method: ' . $e->getMessage());
            // Return an error response
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }



    //delete a file function

    function deleteFile($id){

        $file=Piece::find($id);
        $file->delete();

        return redirect()->back();
    }



}
