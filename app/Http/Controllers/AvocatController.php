<?php

namespace App\Http\Controllers;

use App\Models\Membres;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class AvocatController extends Controller
{

    // get all assistant
    /**
     * @return Application|Factory|View
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
       function getAssistants(){

           $members = User::where('type', 'membres')
               ->whereHas('member', function ($query) {
                   $query->where('typeMembre', 0)
                       ->where('cabinet_id', session()->get('cabinet_id'));
               })
               ->get();

                return view('pages.tables.membres-table',compact('members'));
          }

      //show member registration form
        /**
         * @return Application|Factory|View
         */
        function addMembre(){
               return view('pages.forms.add-membre');
        }


        //add assistant account

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
        function addAssistant(Request $request){

                // Validate the form data
                $validatedData = $request->validate([
                    'prenom' => 'required|string',
                    'nom' => 'required|string',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|min:8',
                    'adresse' => 'nullable|string',
                    'telephone' => 'nullable|numeric|digits:10',
                    'permissions' => 'required|array',
                    'permissions.*' => 'in:Clients,addClient,editClient,deleteClient,Cases,addCase,editCase,deleteCase,Invoices,addInvoice,editInvoice,deleteInvoice',
                ]);

                $user = new User;
                $user->name = $validatedData['prenom'];
                $user->lastname = $validatedData['nom'];
                $user->email = $validatedData['email'];
                $user->password = Hash::make($validatedData['password']);
                $user->adresse = $validatedData['adresse'];
                $user->phone = $validatedData['telephone'];
                $user->type = 'membres';
                $user->original_password = $validatedData['password'];
                $user->save();

                //save the member to the database
                $member = new Membres();
                $member->cabinet_id=session()->get('cabinet_id');
                $member->user_id=$user->id;
                $member->save();

             $User = User::find($user->id);

            // Convert the permissions array to a comma-separated string
            $permissionsString = implode(',', $validatedData['permissions']);

            // Update the permissions field in the member's table
            $assistant=$User->member->permissions= $permissionsString;

            $User->member->save();

                // Redirect to a success page or any other desired action
                return redirect()->route('assistant')->with('success', 'User created successfully');
            }

            //show edit assistant form

            /**
             * @param $id
             * @return Application|Factory|View
             */
            function editAssistantForm($id){
            $member =User::find($id);
            return view('pages.forms.edit-membre',compact('member'));
            }



    //edit an assistant

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    function editAssistant(Request $request,$id){

        // Validate the form data
        $validatedData = $request->validate([
            'prenom' => 'required|string',
            'nom' => 'required|string',
            'email' => [
                'required',
                'email',
            ],
            'password' => 'required|min:8',
            'adresse' => 'nullable|string',
            'telephone' => 'nullable|numeric|digits:10',
            'permissions' => 'required|array',
            'permissions.*' => 'in:Clients,addClient,editClient,deleteClient,Cases,addCase,editCase,deleteCase,Invoices,addInvoice,editInvoice,deleteInvoice',
        ]);
        //dd($validatedData['email']);
        $user = User::find($id);
        $user->name = $validatedData['prenom'];
        $user->lastname = $validatedData['nom'];
        $user->email = $validatedData['email'];
        $user->password = Hash::make($validatedData['password']);
        $user->adresse = $validatedData['adresse'];
        $user->phone = $validatedData['telephone'];
        $user->original_password = $validatedData['password'];
        $user->save();
        // Convert the permissions array to a comma-separated string
        $permissionsString = implode(',', $validatedData['permissions']);

        // Update the permissions field in the member's table
        $assistant=$user->member->permissions= $permissionsString;

        $user->member->save();


        // Redirect to a success page or any other desired action
        return redirect()->route('assistant')->with('success', 'User created successfully');
    }

    //delet an assisatant function

    /**
     * @param $id
     * @return RedirectResponse
     */
    function deleteAssistant($id){

        $user = User::find($id);

        if ($user) {
            $member =Membres::where('user_id',$id);
            $member->delete();
            $user->delete();
        }
        return redirect()->route('assistant');
    }

   }


