<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

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

Route::get('/details/{act}/{amount}/{request_id}/{action_type}/{company_id}/{request_type}/{status}/{created_at}/{admins_note?}/{note?}/{receipt_number?}', [Pagecontroller::class,'showrequestdetails']);

Route::get('/{page?}/{value?}', [Pagecontroller::class,'gotopage']);
Route::get('/accountdetails/{company_id}/{limit_reimburse}/{limit_advance}',
    function($company_id, $limit_reimburse, $limit_advance){
        return view('cclayout',[
            'title' => "Account Details",
            'url' => "Accountdetails.php",
            'company_id'=> $company_id,
            'limit_reimburse'=>$limit_reimburse,
            'limit_advance'=> $limit_advance,
            'return_to'=> ''
        ]);
});




