<?php

use App\User as User;
use App\Models\WorkflowSequence;
## TEMP IMPORTS
use Spatie\Permission\Models\Role as Role;
use Illuminate\Support\Facades\Mail;


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

/*Route::get('/', function () {
    return view('welcome');
});*/


Route::get('/', 'HomeController@index');
Route::resource('quee', 'QueeController');
Auth::routes();


Route::group(['middleware' => 'auth'], function () {


	Route::get('text/sms_preview', 'TextController@sms_preview');
	Route::get('text/approvetext/{status}/{id}', 'TextController@approvetext');
	Route::get('text/check_selected_contact_type', 'TextController@check_selected_contact_type');
	//Route::post('text/store_text','TextController@store_text');
	Route::get('text/action_text/{id}/{status}', 'TextController@action_text');
	Route::get('text/{id}/{status}/status', 'TextController@status');

	Route::any('profile/edit', 'ProfileController@edit');
	Route::any('profile/first_time_reset', 'ProfileController@first_time_reset');

	Route::get('on_form_bal', 'HomeController@fetchOnFornBal');

	Route::any('reports/by_campaign', 'ReportsController@by_campaign');
	Route::any('reports/generate_excel/{id}/{status}', 'ReportsController@generate_excel');
	Route::any('reports/filtered_generate_excel/', 'ReportsController@filtered_generate_excel');
	Route::any('reports/generate_advanced_excel/', 'ReportsController@generate_advanced_excel');
	Route::any('reports/all_sms/', 'ReportsController@all_sms');
	Route::any('reports/advanced_report/', 'ReportsController@advanced_reports');
	Route::any('reports/summary_report/', 'ReportsController@summary_reports');
	Route::any('reports/daily_summary_report/', 'ReportsController@summary_reports');
	Route::any('reports/show_summary_report/', 'ReportsController@show_summary_report');
	Route::any('reports/summary_report/generate_excel', 'ReportsController@generate_summary_reports');

	Route::any('reports/summary_test/', 'ReportsController@summary_report_test');



	Route::resource('text', 'TextController');
	Route::resource('contact', 'ContactController');

	Route::post('text/upload_csv', 'TextController@upload_csv');
	Route::post('contact/create_ajax', 'ContactController@create_ajax');
	Route::post('contact/update_ajax', 'ContactController@create_ajax');


	//Route::resource('admin','Admin\UserController');

	Route::resource('admin/user', 'Admin\\UserController');
	//Route::resource('user','UserController');

	//Route::get('ROE/view_roes_by_role/{status}','ROEController@view_roes_by_role');
});



//Route::get('/home', 'HomeController@index')->name('home');