<?php

namespace App\Providers;

use App\Models\Membres;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();


        // Admin gate
        Gate::define('admin',function ($user){
             return $user->type == "admin" ;
        });

        //  manage client permission
        Gate::define('manage-assistant', function ($user) {

            $member = Membres::where('user_id', $user->id)->first();

            return $member && $this->hasPermission($member, 'manage-assistant');
        });

        //all permission
        Gate::define('all', function ($user) {

            $member = Membres::where('user_id', $user->id)->first();

            return $member && $this->hasPermission($member, 'all');
        });

        // access for client list permission
        Gate::define('Clients', function ($user) {

            $member = Membres::where('user_id', $user->id)->first();

            return $member && $this->hasPermission($member, 'Clients');
        });


        //add client permission
        Gate::define('addClient', function ($user) {

            $member = Membres::where('user_id', $user->id)->first();

            return $member && $this->hasPermission($member, 'addClient');
        });

        //edit client permission
        Gate::define('editClient', function ($user) {

            $member = Membres::where('user_id', $user->id)->first();

            return $member && $this->hasPermission($member, 'editClient');
        });

        //delete client permission
        Gate::define('deleteClient', function ($user) {

            $member = Membres::where('user_id', $user->id)->first();

            return $member && $this->hasPermission($member, 'deleteClient') ;
        });

        //cases list permission
        Gate::define('Cases', function ($user) {

            $member = Membres::where('user_id', $user->id)->first();

            return $member && $this->hasPermission($member, 'addCase');
        });

        //add case permission
        Gate::define('addCase', function ($user) {

            $member = Membres::where('user_id', $user->id)->first();

            return $member && $this->hasPermission($member, 'Cases');
        });

        //edit Case permission
        Gate::define('editCase', function ($user) {

            $member = Membres::where('user_id', $user->id)->first();

            return $member && $this->hasPermission($member, 'editCase');
        });

        // delete a case permission
        Gate::define('deleteCase', function ($user) {

            $member = Membres::where('user_id', $user->id)->first();

            return $member && $this->hasPermission($member, 'deleteCase');
        });

        // invoices list
        Gate::define('Invoices', function ($user) {

            $member = Membres::where('user_id', $user->id)->first();

            return $member && $this->hasPermission($member, 'Invoices');
        });

        // add an invoice
        Gate::define('addInvoice', function ($user) {

            $member = Membres::where('user_id', $user->id)->first();

            return $member && $this->hasPermission($member, 'addInvoice');
        });

        //edit an Invoice
        Gate::define('editInvoice', function ($user) {

            $member = Membres::where('user_id', $user->id)->first();

            return $member && $this->hasPermission($member, 'editInvoice');
        });

        //delete an Invoice

        Gate::define('deleteInvoice', function ($user) {

            $member = Membres::where('user_id', $user->id)->first();

            return $member && $this->hasPermission($member, 'deleteInvoice');
        });
    }
    private function hasPermission($member, $permission)
    {
        $permissions = explode(',', $member->permissions);

        return in_array($permission, $permissions);

    }

}
