<?php

namespace App\Http\Controllers;

use App\Exports\TableExport;
use App\Models\Adversaire;
use App\Models\Cabinet;
use App\Models\ClientAdversaire;
use App\Models\Clients;
use App\Models\ClientsHistorique;
use App\Models\ClientsPhysique;
use App\Models\ClientsSociete;
use App\Models\Dossier;
use App\Models\Note;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\NoReturn;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;


class ClientController extends Controller
{

    // function that redirect user to client list
    /**
     *
     * @return Application|Factory|View
     */
    function index (){

        $clients= Clients::where('cabinet_id',session()->get('cabinet_id'))->get();

        return view('pages.tables.data-table',compact('clients'));

    }
    // add a client form

    /**
     * @return Application|Factory|View
     */
    function addClinet(){
        $cabinet=Cabinet::find(session()->get('cabinet_id'));
        $nreference=$cabinet->nReference;
        return view('pages.forms.client',compact('nreference'));
    }

    // registration of a client

    /**
     * @param Request $request
     * @return RedirectResponse
     */
     function storeClient (Request $request): RedirectResponse
     {

        $validatedRule = [
            'vref' => ['required','regex:/^\d+\/\d{4}$/'],
            'ice' => ['required','regex:/\d{15}$/'],
            'nref' => 'required',
            'telephone' => 'required',
            'adresse' => 'required',
            'typeClient' => 'required|in:1,2',
            'cin' => 'nullable|required_if:typeClient,1',
            'nom' => 'nullable|required_if:typeClient,1',
            'prenom' => 'nullable|required_if:typeClient,1',
            'rc' => 'nullable|required_if:typeClient,2',
            'ste' => 'nullable|required_if:typeClient,2',
            'gerant' => 'nullable|required_if:typeClient,2',
            'siege' => 'nullable|required_if:typeClient,2',
            'terme'=>'nullable',
        ];
         if ($request->has('submit')) {

             $validatedRule['nomadv'] = 'required';
             $validatedRule['prenomadv'] = 'required';
             $validatedRule['adresse1'] = 'required';
             $validatedRule['adresse2'] = '';
             $validatedRule['adresse3'] = '';

         }
         $adversaire = null;

         $oldValues = $request->all();

         if ($request->validate($validatedRule)) {

             $validatedData = $request->validate($validatedRule);

         } else {

             return view('pages.forms.client', compact('adversaire'))->withErrors($request->errors())->withInput();

         }
         if($request->input('terme')){

             $adversaire = Adversaire::where('nom', '=', $request->input('terme'))
                                     ->where('prenom',$validatedData['prenomadv'])
                                      ->first()  ;

         }


         $membre=session()->get('membre_id');
        $cabinet=session()->get('cabinet_id');

        // Create a new client instance and fill it with the validated data

         $cabinet = Cabinet::find($cabinet);

         $nref = $cabinet->nReference;

         $newNref = $nref + 1;

         $cabinet->nReference = $newNref;
         $cabinet->update();

        $client = new Clients();
        $client->vReference = $validatedData['vref'];
        $client->nReference =$nref;
        $client->ice = $validatedData['ice'];
        $client->adresse = $validatedData['adresse'];
        $client->telephone=$validatedData['telephone'];
        $client->member_id=$membre;
        $client->cabinet_id=$cabinet->id;




        // Store the client based on the client type


        if ($validatedData['typeClient'] == 1) {

            $client->type = "ClientsPhysique" ;
//            dd($client);

            $client->save();
            $clientP= new ClientsPhysique();
            $clientP->cin = $validatedData['cin'];
            $clientP->nom = $validatedData['nom'];
            $clientP->prenom = $validatedData['prenom'];
            $clientP->client_id = Clients::max('id');
            try {
                if (!$clientP->save()) {
                    throw new Exception('Failed to save clientP');
                }
            } catch (Exception $e) {
                abort(500, 'the client already exist try again ' . $e->getMessage());
            }

        } else if ($validatedData['typeClient'] == 2) {

            $client->type = "ClientsSociete" ;
            $client->save();
            $clientS=new ClientsSociete();
            $clientS->rc = $validatedData['rc'];
            $clientS->nomSte = $validatedData['ste'];
            $clientS->gerant = $validatedData['gerant'];
            $clientS->siege = $validatedData['siege'];
            $clientS->client_id =Clients::max('id');
            $clientS->save();

        }

        // register the adversaire
         if (!$adversaire=== null){
                dd(isNull($adversaire)== null);
         }else{

             $adversairE = new Adversaire();
             $adversairE->nom = $validatedData['nomadv'];
             $adversairE->prenom = $validatedData['prenomadv'];
             $adversairE->adresse1 = $validatedData['adresse1'];
             $adversairE->adresse2 = $validatedData['adresse2'];
             $adversairE->adresse3 = $validatedData['adresse3'];
             $adversairE->save();
             $adversaireId=$adversairE->id;
         }


        // register the record in client Adversaire pivote tabel

            $cliAdv= new ClientAdversaire();
            $cliAdv->clients_id=$client->id;
            $cliAdv->adversaire_id=$adversaireId;
            $cliAdv->save();

        // Redirect to a success page or perform any other desired action
        return redirect()->route('clients');
    }


    //show a client data for editing

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    function editClient($userId){
        $client = Clients::find($userId);
        $type = $client->type;

        $cliente = Clients::with($type)->find($userId);

        $clientDetails = $cliente->{$type};

        $client = Clients::find($userId);
        $adversaire=[];
        if ($client) {

            $adversaire = $client->adversaires;
        }

        return view('pages.forms.client-edit',compact('client','clientDetails','adversaire'));

    }

    //edit a client and register a client history record

    /**
     * @param Request $request
     * @return RedirectResponse
     */
     function editClients (Request $request, $clientID): RedirectResponse
    {
        $membre=session()->get('membre_id');
        $cabinet=session()->get('cabinet_id');
        $cid=session()->get('user_id');

        $validatedRule = [
            'vref' => ['required','regex:/^\d+\/\d{4}$/'],
            'ice' => ['required','regex:/^\d{15}$/'],
            'nref' => 'required',
            'telephone' => 'required',
            'adresse' => 'required',
            'typeClient' => 'required|in:1,2',
            'cin' => 'nullable|required_if:typeClient,1',
            'nom' => 'nullable|required_if:typeClient,1',
            'prenom' => 'nullable|required_if:typeClient,1',
            'rc' => 'nullable|required_if:typeClient,2',
            'ste' => 'nullable|required_if:typeClient,2',
            'gerant' => 'nullable|required_if:typeClient,2',
            'siege' => 'nullable|required_if:typeClient,2',
            'condition'=>'nullable',
        ];

        $validatedRule['nomadv'] = 'required';
        $validatedRule['prenomadv'] = 'required';
        $validatedRule['adresse1'] = '';
        $validatedRule['adresse2'] = '';
        $validatedRule['adresse3'] = '';

        $oldValues = $request->all();

        $validatedData=$request->validate($validatedRule);

        // Create a new client instance and fill it with the validated data

        $updatedFields = [];

        $client = Clients::find($clientID)->first();
        $client->vReference = $validatedData['vref'];
        $client->nReference = $validatedData['nref'];
        $client->ice = $validatedData['ice'];
        $client->adresse = $validatedData['adresse'];
        $client->telephone=$validatedData['telephone'];
        $client->member_id=$membre;
        $client->cabinet_id=$cabinet;

        foreach ($client->getDirty() as $field => $value) {
            $updatedFields[] = $field;
        }
//        dd($client);
        $client->update();

        // register the adversaire
        $use = ClientAdversaire::where('clients_id','=',$clientID)->get();

        $adversaire = Adversaire::find($use[0]->adversaire_id);
        $adversaire->nom = $validatedData['nomadv'];
        $adversaire->prenom = $validatedData['prenomadv'];
        $adversaire->adresse1 = $validatedData['adresse1'];
        $adversaire->adresse2 = $validatedData['adresse2'];
        $adversaire->adresse3 = $validatedData['adresse3'];

        foreach ($adversaire->getDirty() as $field => $value) {
            $updatedFields[] = $field;
        }
        $adversaire->update();

        // Store the client based on the client type
        if ($validatedData['typeClient'] == 1) {

            $clientP= ClientsPhysique::where('client_id','=',$client->id)->first();
            if($clientP) {
                $clientP->cin = $validatedData['cin'];
                $clientP->nom = $validatedData['nom'];
                $clientP->prenom = $validatedData['prenom'];

                foreach ($clientP->getDirty() as $field => $value) {
                    $updatedFields[] = $field;
                }
                try {
                    if (!$clientP->update()) {
                        throw new Exception('Failed to save clientP');
                    }
                } catch (Exception $e) {
                    abort(500, 'the client already exist try again ' . $e->getMessage());
                }

            }

        } else if ($validatedData['typeClient'] == 2) {

            $clientS= ClientsSociete::where('client_id','=',$client->id)->first();
            if($clientS){
                $clientS->rc = $validatedData['rc'];
                $clientS->nomSte = $validatedData['ste'];
                $clientS->gerant = $validatedData['gerant'];
                $clientS->siege = $validatedData['siege'];

                foreach ($clientS->getDirty() as $field => $value) {
                    $updatedFields[] = $field;
                }

                try {
                    if (!$clientS->update()) {
                        throw new Exception('Failed to save clientS');
                    }
                } catch (Exception $e) {
                    abort(500, 'the client already exist try again ' . $e->getMessage());
                }
            }

        }

        //add a client history
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
                        $decription .=" بواسطة   $User->name  $User->lastname "  ;
                    }
                }

                $clientHistory = new ClientsHistorique();
                $clientHistory->client_id = $client->id;
                $clientHistory->memberId = $membre;
                $clientHistory->description = $decription;
                $clientHistory->save();
            }

        return redirect()->route('clients');


    }

    //display client history

    /**
     * @param $id
     * @return Application|Factory|View
     */
    function  historyClients($id): View|Factory|Application
    {

        $history = ClientsHistorique::where('client_id','=',$id)->get();

        return view('pages.tables.data-client-history',compact('history'));

    }


    //show a client detail

    /**
     * @param $userId
     * @return Application|Factory|View
     */
    function showClient($userId): View|Factory|Application
    {

        $client = Clients::find($userId);

        $adversaire=[];
        if ($client) {

            $adversaire = $client->adversaires;


        }

        $client = Clients::find($userId);

        $type = $client->type;

        $cliente = Clients::with($type)->find($userId);

        $clientDetails = $cliente->{$type};
        return view('pages.forms.client-show',compact('client','clientDetails','adversaire'));

    }

    //delete a client

    /**
     * @param $id
     * @return RedirectResponse
     */
    function deleteClient($id)
    {
        $client = Clients::find($id);
        $dossier = Dossier::where('client_id', $client->id)->first();
        if ($dossier) {
            $dossier->delete();
        }

        $client->adversaires()->detach();

        $client->delete();

        return redirect()->route('clients')->with('success', 'Client deleted successfully');

    }


    // sear for the oppenent  by last nmae

    public function search(Request $request)
    {
        $name = $request->input('name');

        // Perform the search query based on the name
        $adversaire = Adversaire::where('nom', 'like', "%$name%")
            ->orWhere('prenom', 'like', "%$name%")
            ->first();

        return response()->json($adversaire);
    }


    //get the client detail

    /**
     * @param Request $request
     * @return JsonResponse
     */
    function getClient(Request $request){

        $nref = $request->input('term');

        $result= Clients::where('nReference','LIKE',"%$nref%")
            ->where('cabinet_id',session()->get('cabinet_id'))
            ->select('nReference','vReference','ice')->get();

        return response()->json($result);

    }

    //get the defendant detail

    /**
     * @param Request $request
     * @return JsonResponse
     */
    function getDefendant(Request $request){

        $term = $request->input('term');
        $result= Adversaire::where('nom','LIKE',"%$term%")->select('nom','prenom','adresse1','adresse2','adresse3')->get();

        return response()->json($result);
    }

    //export clients list

    /**
     * @return BinaryFileResponse
     */
    public function exportClients()
    {

        $clients= Clients::where('cabinet_id',session()->get('cabinet_id'))->get();

//        dd($clients);
        return Excel::download(new TableExport($clients), 'clients.xlsx');
      }

}
