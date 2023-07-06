<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;



//login route
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);

//logout
Route::get('/logout', function () {
    Session::flush();
    Auth::logout();
    return redirect('/login');
})->name('logout');


//------------------------------------------------------------- Avocat and assistant operations -----------------------------------------//


Route::middleware(['auth'])->group(function () {

    // Protected routes go here
    Route::get('/','LoginController@index')->name('dashboard');
    Route::get('admin','AdminController@index')->name('admin');

    // dashboard statistics they well be handled with ajax
    Route::get('/users/count', 'LoginController@getUsersCount');
    Route::get('/users/count1', 'LoginController@getUsersCount1');

    //clints route
    Route::get('users','ClientController@index')->name("clients");

    //handle a client actions
    Route::get('/addClient','ClientController@addClinet');
    Route::get('/edit-client/{id}','ClientController@editClient');
    Route::put('/edit-client/{id}','ClientController@editClients');
    Route::get('/history-client/{id}','ClientController@historyClients');
    Route::get('/show-client/{id}','ClientController@showClient');
    Route::post('/store-client','ClientController@storeClient');

    //delete a clinet route
    Route::get('/delete-client/{id}','ClientController@deleteClient');

    //download clinets data
    Route::get('/clients/export', 'ClientController@exportClients')->name('clients.export');

    //get the opponent  by last name
    Route::get('/search-adversaire', 'ClientController@search')->name('adversaire.search');
    Route::post('/search', 'ClientController@search');

    //search for a client detail
    Route::get('/searchClient','ClientController@getClient');
    //get the Defendant detail
    Route::get('/searchAdversaire','ClientController@getDefendant');

    // add a case
    Route::get('/cases','DossierController@index')->name('cases');
    Route::get('/add-case','DossierController@showCaseForm');

    //nature type search input
    Route::get('/search', 'DossierController@getResults');

    //search client search input
    Route::get('/search-client', 'DossierController@searchClient')->name('client.search');

    //store a case
    Route::post('/store-case','DossierController@storeCase');
    Route::put('/edit-caseStatus/{id}','DossierController@editCaseStatus');
    Route::put('/edit-case/{id}','DossierController@editCase');
    Route::get('/edit-case/{id}','DossierController@editCaseForm');
    Route::get('/history-case/{id}','DossierController@casesHistory');
    Route::get('/upload-case/{id}','DossierController@uploadFiles')->name('files');
    Route::get('/delete-case/{id}','DossierController@deleteCase');

    //edit case status
    Route::get('/edit-case-status/{id}','DossierController@editCaseStatusForm');
    Route::put('/edit-case-status/{id}','DossierController@editCaseStatus');

    //download clinets data
    Route::get('/case/export', 'DossierController@exportCase')->name('cases.export');
    Route::get('/add-case-file/{id}', 'DossierController@showUploadForm');

    //Route::post('/uploade-file/{id}', 'DossierController@uploadFile');
    Route::post('/upload-file/{dossier}', 'DossierController@uploadFile')->name('upload.file');

    //download
    Route::get('/download/{file}', 'DossierController@download')->name('file.download');

    // assistant list
    Route::get('/membres','AvocatController@getAssistants')->name('assistant');
    //add assistant
    Route::get('/add-member','AvocatController@addMembre');
    Route::post('/add-member','AvocatController@addAssistant');
    Route::put('edit-member/{id}','AvocatController@editAssistant');
    Route::get('/edit-membre/{id}','AvocatController@editAssistantForm');
    Route::get('/delete-membre/{id}','AvocatController@deleteAssistant');

    //invoice management (note management)

    //GET All invoices for a case
    Route::get('/invoice-case/{id}','NoteController@getInvoicesByCase')->name('invoicesCase');

    //add a cost for a case form
    Route::get('/addFrais/{id}','NoteController@addCostForm');

    //add a fees for a case form
    Route::get('/addHonoraire/{id}','NoteController@addFeesForm');

    //add a cost
    Route::post('/add-cost/{id}','NoteController@addCost');

    //add a fees
    Route::post('/add-fees/{id}','NoteController@addFees');

    //add a transition form
    Route::get('/transition/{id}','NoteController@transitionForm');

    //add transition
    Route::post('/add-transition/{id}','NoteController@addTransition');

    // translate to arabic
    Route::get('/translate-to-arabic', 'NoteController@translateToArabic')->name('translate.to.arabic');

    // invoice data
    Route::get('/view-invoice/{id}','NoteController@viewInvoice');

    // downloadInvoice data
    Route::get('/download-invoice/{id}','NoteController@downloadInvoice');

    Route::get('/generate-pdf', 'NoteController@generate')->name('generate.pdf');

    //list all invoices
    Route::get('/invoices','NoteController@invoicesListe');

    //invoices cots list
    Route::get('/view-frais/{id}','NoteController@costList');

    // edit a cost
    Route::get('/edit-cost/{id}','NoteController@editCostForm');
    Route::put('/edit-cost/{id}','NoteController@editCost');

    //delete a cost
    Route::get('/delete-cost/{id}','NoteController@deleteCost');

    // invoice fees list
    Route::get('/view-honoraire/{id}','NoteController@feesList');

    //edit a fees
    Route::get('/edit-fees/{id}','NoteController@editFeesForm');
    Route::put('/edit-fees/{id}','NoteController@editFees');

    //delete a fees
    Route::get('/delete-fees/{id}','NoteController@deleteFees');

    // transitions list
    Route::get('/view-transition/{id}','NoteController@transitionList');
    //update the status of case
    Route::get('/update-status/{dossier}/{status}','DossierController@changeStatus');
    // assistant permesion
    Route::get('/permissions/{id}','AvocatController@permessionForm');

    //update assistantes permessions
    Route::put('permessionUpdate/{id}','AvocatController@updatePermessions')->name('permession.update');

    //get the number of cases by month
    Route::get('/monthly-cases', 'DossierController@monthlyCases')->name('monthly.cases');
    Route::get('/monthly-cases1', 'DossierController@monthlyCases1')->name('monthly.cases1');

    // edit transition form
    Route::get('/edit-transition/{id}','NoteController@editTransitionForm');

    //edit a transition
    Route::put('/edit-transition/{id}','NoteController@editTransition');

    //add an assistant permission's
    Route::post('/add-permission/{id}','AvocatController@addPermisssion');


    //-------------------------------------------------------------------handle Advocat operation-----------------------------------------//

    //add a law firm
    Route::get('/add-cabinet','AdminController@addCabinetForm');
    Route::post('/add-cabinet','AdminController@addCabinet');

    // law firms list
    Route::get('/firms','AdminController@firms')->name('firms');

    // edit a law
    Route::get('/edit-cabinet/{id}','AdminController@editCabinetForm');
    Route::put('/edit-cabinet/{id}','AdminController@editCabinet');
    Route::get('/delete-cabinet/{id}','AdminController@deleteCabinet');

    //natureJudicial
    Route::get('natureJudiciare','AdminController@listNatureJudiciare')->name('list.nature');
    Route::get('add-nature','AdminController@addNatureForm');
    Route::post('add-nature','AdminController@addNature');
    Route::get('/edit-nature/{id}','AdminController@editNatureForm');
    Route::put('/edit-nature/{id}','AdminController@editNature');
    Route::get('delete-nature/{id}','AdminController@deleteNature');

    //delete a file

    Route::get('delete_file/{id}','DossierController@deleteFile');
































    Route::group(['prefix' => 'apps'], function(){
        Route::get('chat', function () { return view('pages.apps.chat'); });
        Route::get('calendar', function () { return view('pages.apps.calendar'); });
    });

    Route::group(['prefix' => 'ui-components'], function(){Route::get('/', function () {
        return view('dashboard');
    });
        Route::get('accordion', function () { return view('pages.ui-components.accordion'); });
        Route::get('alerts', function () { return view('pages.ui-components.alerts'); });
        Route::get('badges', function () { return view('pages.ui-components.badges'); });
        Route::get('breadcrumbs', function () { return view('pages.ui-components.breadcrumbs'); });
        Route::get('buttons', function () { return view('pages.ui-components.buttons'); });
        Route::get('button-group', function () { return view('pages.ui-components.button-group'); });
        Route::get('cards', function () { return view('pages.ui-components.cards'); });
        Route::get('carousel', function () { return view('pages.ui-components.carousel'); });
        Route::get('collapse', function () { return view('pages.ui-components.collapse'); });
        Route::get('dropdowns', function () { return view('pages.ui-components.dropdowns'); });
        Route::get('list-group', function () { return view('pages.ui-components.list-group'); });
        Route::get('media-object', function () { return view('pages.ui-components.media-object'); });
        Route::get('modal', function () { return view('pages.ui-components.modal'); });
        Route::get('navs', function () { return view('pages.ui-components.navs'); });
        Route::get('navbar', function () { return view('pages.ui-components.navbar'); });
        Route::get('pagination', function () { return view('pages.ui-components.pagination'); });
        Route::get('popovers', function () { return view('pages.ui-components.popovers'); });
        Route::get('progress', function () { return view('pages.ui-components.progress'); });
        Route::get('scrollbar', function () { return view('pages.ui-components.scrollbar'); });
        Route::get('scrollspy', function () { return view('pages.ui-components.scrollspy'); });
        Route::get('spinners', function () { return view('pages.ui-components.spinners'); });
        Route::get('tabs', function () { return view('pages.ui-components.tabs'); });
        Route::get('tooltips', function () { return view('pages.ui-components.tooltips'); });
    });

    Route::group(['prefix' => 'advanced-ui'], function(){
        Route::get('cropper', function () { return view('pages.advanced-ui.cropper'); });
        Route::get('owl-carousel', function () { return view('pages.advanced-ui.owl-carousel'); });
        Route::get('sortablejs', function () { return view('pages.advanced-ui.sortablejs'); });
        Route::get('sweet-alert', function () { return view('pages.advanced-ui.sweet-alert'); });
    });

    Route::group(['prefix' => 'forms'], function(){
        Route::get('basic-elements', function () { return view('pages.forms.basic-elements'); });
        Route::get('advanced-elements', function () { return view('pages.forms.advanced-elements'); });
        Route::get('editors', function () { return view('pages.forms.editors'); });
        Route::get('wizard', function () { return view('pages.forms.wizard'); });
    });

    Route::group(['prefix' => 'charts'], function(){
        Route::get('apex', function () { return view('pages.charts.apex'); });
        Route::get('chartjs', function () { return view('pages.charts.chartjs'); });
        Route::get('flot', function () { return view('pages.charts.flot'); });
        Route::get('morrisjs', function () { return view('pages.charts.morrisjs'); });
        Route::get('peity', function () { return view('pages.charts.peity'); });
        Route::get('sparkline', function () { return view('pages.charts.sparkline'); });
    });

    Route::group(['prefix' => 'tables'], function(){
        Route::get('basic-tables', function () { return view('pages.tables.basic-tables'); });
        Route::get('data-table', function () { return view('pages.tables.data-table'); });
    });

    Route::group(['prefix' => 'icons'], function(){
        Route::get('feather-icons', function () { return view('pages.icons.feather-icons'); });
        Route::get('flag-icons', function () { return view('pages.icons.flag-icons'); });
        Route::get('mdi-icons', function () { return view('pages.icons.mdi-icons'); });
    });

    Route::group(['prefix' => 'general'], function(){
        Route::get('blank-page', function () { return view('pages.general.blank-page'); });
        Route::get('faq', function () { return view('pages.general.faq'); });
        Route::get('invoice', function () { return view('pages.general.invoice'); });
        Route::get('profile', function () { return view('pages.general.profile'); });
        Route::get('pricing', function () { return view('pages.general.pricing'); });
        Route::get('timeline', function () { return view('pages.general.timeline'); });
    });

    Route::group(['prefix' => 'auth'], function(){
        Route::get('login', function () { return view('pages.auth.login'); });
        Route::get('register', function () { return view('pages.auth.register'); });
    });

    Route::group(['prefix' => 'error'], function(){
        Route::get('404', function () { return view('pages.error.404'); });
        Route::get('500', function () { return view('pages.error.500'); });
    });

    Route::get('/clear-cache', function() {
        Artisan::call('cache:clear');
        return "Cache is cleared";
    });

// 404 for undefined routes
    Route::any('/{page?}',function(){
        return View::make('pages.error.404');
    })->where('page','.*');

});


