<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\Dossier;
use App\Models\Membres;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class LoginController extends Controller
{
    public function login(Request $request)
    {


        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {

            // Authentication successful, redirect to a protected route
            $user = Auth::user();
            $userID = $user->id;
            $member = Membres::where('user_id', $userID)->first();

            session(['user_id' => $userID]);
            session(['user_email' => $user->email]);
            session(['user_fullname' => $user->name . " " .$user->lastname]);
            if ($user->type == "membres") {
                session(['membre_id' => $member->id]);
                session(['cabinet_id' => $member->cabinet_id]);


            }else{
                return redirect()->route('admin',);
            }
            return redirect()->route('dashboard',);
        }

        // Authentication failed, redirect back to the login page
        return redirect('/login')->withErrors(['error' => 'Invalid credentials']);
    }

    function index(){
        $cabinetId = session()->get('cabinet_id');
        $count=Dossier::where('status', 2)
            ->whereHas('client', function ($query) use ($cabinetId) {
                $query->where('cabinet_id', $cabinetId);
            })->count();

        $Client =Clients::where('cabinet_id',session()->get('cabinet_id'))->count();

        $count1=Dossier::where('status', 0)
            ->whereHas('client', function ($query) use ($cabinetId) {
                $query->where('cabinet_id', $cabinetId);
            })->count();
        $count2=Dossier::where('status', 1)
            ->whereHas('client', function ($query) use ($cabinetId) {
                $query->where('cabinet_id', $cabinetId);
            })->count();
        $counTotal=Dossier::whereHas('client', function ($query) use ($cabinetId) {
            $query->where('cabinet_id', $cabinetId);
        })->count();
//        dd($counTotal);
        $dossiers = Dossier::where('status', 0)
            ->whereHas('client', function ($query) use ($cabinetId) {
                $query->where('cabinet_id', $cabinetId);
            })
            ->get();
//        dd($dossiers);
        return view('dashboard1',compact('count','count1','count2','counTotal'));
    }


    /**
     * @return Application|Factory|View
     */
    public  function  showLoginForm(){
        return view('pages.auth.login');
    }

    /**
     * @return JsonResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getUsersCount()



    {
        $cabinetId = session()->get('cabinet_id');


        $data = "";
        $totalCase=Dossier::whereHas('client', function ($query) use ($cabinetId) {
            $query->where('cabinet_id', $cabinetId);
        })->count();
        $closedCase=Dossier::where('status', 1)
            ->whereHas('client', function ($query) use ($cabinetId) {
                $query->where('cabinet_id', $cabinetId);
            })->count();
        $data= (100 * $closedCase )/ $totalCase;
        $formattedPercentage = number_format($data, 1);
        $data=$data??"0";
        return response()->json($formattedPercentage);
    }

    /**
     * @return JsonResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getUsersCount1()
    {
        $cabinetId = session()->get('cabinet_id');

        $closedCase  = Dossier::where('status', 1)->count();
        $totalCase= Dossier::count();

        $percentage = $totalCase > 0 ? (100 * $closedCase) / $totalCase : 0;
        $formattedPercentage = number_format($percentage, 1);
        return response()->json($formattedPercentage);
    }

}
