<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Pagecontroller;
use Illuminate\Http\Request;
class Pagecontroller extends Controller{

    public static function showrequestdetails($act,$amount,$request_id,$action_type,$company_id,$request_type,$status,$created_at,$admins_note='',$note='',$receipt_number=''){
        $title = "Advance";
        if($request_type === "reimburse") $title = "Reimburse";
       
        return view('cclayout',[
            'title' => $title,
            'act'=> $act,
            'url' => "Requestdetails.php",
            'amount' => $amount,
            'request_id' => $request_id,
            'action_type' => $action_type,
            'company_id'=> $company_id,
            'request_type' => $request_type,
            'status' => $status,
            'datetime' => $created_at,
            'admins_note'=> $admins_note,
            'note' => $note,
            'receipt_number' => $receipt_number
        ]);
    }

    public static function gotopage($page=null){
        $pagedata = Pagecontroller::getpage($page);
        return view('cclayout',[
            'title' => $pagedata['title'],
            'url' => $pagedata['url'],
            'request_type' => $pagedata['request_type'],
            'return_to'=> $pagedata['return_to']
        ]);
    }

    public static function getpage($page=null){
        $pagedata = [];
        $title = 'Corporate Cash';
        $url = 'Accountlistmanager.php';
        $request_type = '';
        $return_to='';
        switch($page){
            default:
                //include "Accountlistmanager.php";
                break;
            case 'reimburse_list':
                $title = 'Reimburse';
                $url = 'Requestlistmanager.php';
                $request_type = 'reimburse';
                $return_to='';
                break;
            case 'advance_list':
                $title = 'Advance';
                $url = 'Requestlistmanager.php';
                $request_type = 'advance';
                $return_to='';
                break;
            case 'request_advance':
                $title = 'Request Advance';
                $url = 'Requestmanager.php';
                $request_type = 'advance';
                $return_to='Requestlistmanager.php';
                break;
            case 'request_reimburse':
                $title = 'Request Reimburse';
                $url = 'Requestmanager.php';
                $request_type = 'reimburse';
                $return_to='Requestlistmanager.php';
                break;
            case 'return':
                $title = 'Return';
                $url = 'ccrequest';
                $request_type = 'advance';
                $return_to='Requestlistmanager.php';
                break;
            case 'add_record':
                $title = 'Add Record';
                $url = 'ccrequest';
                $request_type = 'advance';
                $return_to='Requestlistmanager.php';
                break;
        }
        $pagedata=[
            'title' => $title,
            'url' => $url,
            'request_type' => $request_type,
            'return_to'=> $return_to

        ];
        return $pagedata;
    }
}
?>