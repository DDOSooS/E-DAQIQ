<?php

namespace App\Http\Controllers;

use App\Models\Cabinet;
use App\Models\Clients;
use App\Models\Dossier;
use App\Models\Membres;
use App\Models\NatureJudicaire;
use App\Models\Note;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{


    //indes page
    function index(){
        $cabinetId = session()->get('cabinet_id');
        $count2=Dossier::where('status', 2)->count();
        $Client =Clients::where('cabinet_id',session()->get('cabinet_id'))->count();
        $count=Dossier::where('status', 0)->count();
        $count1=Dossier::where('status', 1)->count();
        $counTotal=Dossier::count();
        return view('dashboard',compact('count','count1','count2','counTotal'));
    }

    // law firms list
    /**
     * @return Application|Factory|View
     */
    function firms(){
        $cabinets = Cabinet::all();

        foreach ($cabinets as $cabinet) {
            foreach ($cabinet->membres as $membre) {
                if ($membre->typeMembre == 1) {
                    $cabinet->setAttribute('name', $membre->user->name);
                    $cabinet->setAttribute('lastname', $membre->user->lastname);
                    $cabinet->setAttribute('email', $membre->user->email);
                    $cabinet->setAttribute('phone', $membre->user->phone);
                }
            }
        }

        return view('pages.tables.firms',compact('cabinets'));

    }


    // add a law firm form
    /**
     * @return Application|Factory|View
     */
    function addCabinetForm(){

        return view('pages.forms.add-cabinet');

    }

    // add law firm and lawyer data function

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    function addCabinet(Request $request){

        $validatedData = $request->validate([
            'firmName' => 'required|string',
            'siege' => 'required|string',
            'dateCreation' => 'required|string',
            'logo' => 'required',
            'prenom' => 'required|string',
            'nom' => 'required|string',
            'email' => [
                'required',
                'email',
            ],
            'password' => 'required|min:8',
            'adresse' => 'nullable|string',
            'telephone' => 'nullable|numeric|digits:10',
        ]);

        DB::beginTransaction();

        try {

            // Handle file upload

            if ($request->hasfile('logo')) {
                $file = $validatedData['logo'];
                $timestamp = time();
                $logoName = $timestamp . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('public/img', $logoName);
            } else {
                $path = null;
            }

            // Create a new User instance and save it
            $user = new User();
            $user->name = $validatedData['prenom'];
            $user->lastname = $validatedData['nom'];
            $user->adresse = $validatedData['adresse'];
            $user->phone = $validatedData['telephone'];
            $user->email =  $validatedData['email'];
            $user->password = bcrypt($validatedData['password']);
            $user->original_password = $validatedData['password'];
            $user->type = "membres";
            $user->save();

            // Create a new Cabinet instance and save it
            $cabinet = new Cabinet();
            $cabinet->nom = $validatedData['firmName'];
            $cabinet->dateCreation = $validatedData['dateCreation'];
            $cabinet->logo = $path;
            $cabinet->siege = $validatedData['siege'];
            $cabinet->save();

            // Create a new Membres instance
            $member = new Membres();
            $member->user_id = $user->id;
            $member->typeMembre = "1";
            $member->cabinet_id = $cabinet->id;
            $member->save();


            DB::commit();

            return redirect()->route('firms');

        } catch (Exception $e) {

            DB::rollback();

            return redirect()->back()->with('error', 'حدث خطأ أثناء إدخال البيانات. حاول مرة اخرى.');
        }

    }

    //edit a law firm form

    /**
     * @param $cabinet_id
     * @return Application|Factory|View
     */
    function editCabinetForm( $cabinet_id)
    {
        $cabinet=Cabinet::find($cabinet_id);
        $membre = $cabinet->membres->where('typeMembre', 1)->first();

        if ($membre){
                $cabinet->setAttribute('name',$membre->user->name);
                $cabinet->setAttribute('lastname', $membre->user->lastname);
                $cabinet->setAttribute('email', $membre->user->email);
                $cabinet->setAttribute('phone', $membre->user->phone);
                $cabinet->setAttribute('adresse', $membre->user->adresse);
                $cabinet->setAttribute('original_password', $membre->user->original_password);

        }
        return view('pages.forms.edit-cabinet',compact('cabinet'));
    }



    // edit a law firm function

    /**
     * @param Request $request
     * @param $cabinet_id
     * @return RedirectResponse
     */
    function editCabinet(Request $request,$cabinet_id)
    {
        $validatedData = $request->validate([
            'firmName' => 'required|string',
            'siege' => 'required|string',
            'dateCreation' => 'required|string',
            'logo' => 'nullable',
            'default_logo',
            'prenom' => 'required|string',
            'nom' => 'required|string',
            'email' => [
                'required',
                'email',
            ],
            'password' => 'required|min:8',
            'adresse' => 'nullable|string',
            'telephone' => 'nullable|numeric|digits:10',
        ]);
        if (empty($validatedData['logo'])) {
            // Assign the value of default_logo to logo
            $validatedData['logo'] = $request->input('default_logo');
        }
        DB::beginTransaction();

        try {

           // edit Cabinet

            $cabinet = Cabinet::find($cabinet_id);
            $member = $cabinet->membres->where('typeMembre', 1)->first();

            if ($member){
                $user_id= $member->user->id;
            }
            $cabinet->nom = $validatedData['firmName'];
            $cabinet->dateCreation = $validatedData['dateCreation'];
            if ($request->hasfile('logo') ) {
                $file = $validatedData['logo'];
                $timestamp = time();
                $logoName = $timestamp . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('public/img', $logoName);
                $cabinet->logo = $path;
            }
            $cabinet->siege = $validatedData['siege'];
            $cabinet->save();


            // Create a new User instance and save it
            $user = User::find($user_id);
            $user->name = $validatedData['prenom'];
            $user->lastname = $validatedData['nom'];
            $user->adresse = $validatedData['adresse'];
            $user->phone = $validatedData['telephone'];
            $user->email =  $validatedData['email'];
            $user->password = bcrypt($validatedData['password']);
            $user->original_password = $validatedData['password'];
            $user->save();

            DB::commit();

            return redirect()->route('firms');

        } catch (Exception $e) {

            DB::rollback();

            return redirect()->back()->with('error', 'حدث خطأ أثناء إدخال البيانات. حاول مرة اخرى.');
        }

    }

    // delete a law firm function

    /**
     * @param $cabinet_id
     * @return RedirectResponse
     */
    function deleteCabinet($cabinet_id) {
        $cabinet = Cabinet::findOrFail($cabinet_id);

        // Delete related notes


        // Detach all related client_adversaire records
        foreach ($cabinet->clients as $client) {
            $client->adversaires()->detach();
            $dossier = $client->dossier->first();
            if ($dossier) {
                $dossierId = $dossier->id;

                $note=Note::find($dossier->id);
                if ($note) {
                    $note->delete();
                }
                $dossier->delete();
            }
        }

        // Delete members and associated users
        foreach ($cabinet->membres as $membre) {
            $membre->user->delete();
        }

        // Delete the cabinet
        $cabinet->delete();

        return redirect()->route('firms');
    }





    // list of nature judicial

    /**
     * @return Application|Factory|View
     */
    function  listNatureJudiciare(){

        $natures=NatureJudicaire::all();

        return view('pages.tables.lawCodes',compact('natures'));

    }

    //show add nature form

    /**
     * @return Application|Factory|View
     */
    function addNatureForm()
    {
        return view('pages.forms.add-nature');
    }


    // add a nature judicial

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    function addNature(Request $request)
    {
        $validateData =$request->validate([
            'code.*' => 'required|numeric',
            'typeDossier.*' => 'required|string',
            'typeTibunale.*' => 'required|string',
        ]);
        $codeArray = $request->input('code');
        $typeDossierArray = $request->input('typeDossier');
        $typeTibunaleArray = $request->input('typeTibunale');


        foreach ($codeArray as $key => $code) {
            NatureJudicaire::create([
                'codeTypeDossier' => $code,
                'typeDossier' => $typeDossierArray[$key],
                'typeTtribunal' => $typeTibunaleArray[$key],
            ]);

        }

        return redirect()->route('list.nature');
    }


    //edit nature Form

    /**
     * @param $nature_id
     * @return Application|Factory|View
     */
    function editNatureForm($nature_id){

        $nature=NatureJudicaire::find($nature_id);

        return view('pages.forms.edit-nature',compact('nature'));
    }


    // edit a nature
    function editNature(Request $request,$nature_id){

        $validateData =$request->validate([
            'code' => 'required|numeric',
            'typeDossier' => 'required|string',
            'typeTibunale' => 'required|string',
        ]);

        $nature=NatureJudicaire::find($nature_id);
        $nature->codeTypeDossier=$validateData['code'];
        $nature->typeDossier=$validateData['typeDossier'];
        $nature->typeTtribunal=$validateData['typeTibunale'];
        $nature->save();

        return redirect()->route('list.nature');

    }



    // delete a nature

    /**
     * @param $id
     * @return RedirectResponse
     */
    function deleteNature($id){

        $nature=NatureJudicaire::find($id);

        $nature->delete();

        return redirect()->route('list.nature');
    }
}
