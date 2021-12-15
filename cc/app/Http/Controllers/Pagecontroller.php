<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Pagecontroller;
use Illuminate\Http\Request;
class Pagecontroller extends Controller{

    public static function gotopage($page=null){
        $pagedata = Pagecontroller::getpage($page);
        return view($pagedata['url'],[
            'title' => $pagedata['title'],
        ]);
    }

    public static function getpage($page=null){
        $pagedata = [];
        $title = 'Corporate Cash';
        $url = 'ccaccountlist';
        switch($page){
            default:
                //include "Accountlistmanager.php";
                break;
            case 'reimburselist':
                $title = 'Reimburse';
                $url = 'ccrequestlist';
                break;
            case 'advancelist':
                $title = 'Advance';
                $url = 'ccrequestlist';
                break;
            case 'request':
                $title = 'Request';
                include "Requestmanager.php";
                break;
            case 'return':
                $title = 'Return';
                $url = 'ccrequest';
                break;
            case 'addrecord':
                $title = 'Add Record';
                $url = 'ccrequest';
                break;
        }
        $pagedata=[
            'title' => $title,
            'url' => $url,
        ];
        return $pagedata;
    }
}
?>