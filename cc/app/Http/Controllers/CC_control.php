<?php
$connection = new mysqli('localhost','root','','pettycash');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(!$connection) die(mysqli_error($connection));
$GLOBALS['connection'] = $connection;

//------------------------------------------------------------------
//----------------------------logs---------------------------------
//------------------------------------------------------------------
function input_into_main($IDuser , $ID_perusahaan , $ID_bagian, $dana_masuk, $dana_keluar, $ket, $file) {
    date_default_timezone_set('Asia/Jakarta');
    $datetime = date("Y-m-d G:i:s");
    echo $datetime;
    switch($ID_bagian){
        case 'advance' : $ID_bagian = 1; break;
        case 'reimburse' : $ID_bagian = 2; break;
    }
    $query = "insert into `petty_cash_pengajuan` (IDuser, ID_perusahaan, ID_bagian, dana_masuk, dana_keluar, ket, file, tanggal, status) values ($IDuser, $ID_perusahaan, $ID_bagian, $dana_masuk, $dana_keluar, '$ket', '$file','$datetime','accept')";
    $result = mysqli_query($GLOBALS['connection'],$query);
    if(!$result || mysqli_affected_rows($GLOBALS['connection']) <= 0) { 
        popupmessage("fail to insert into petty_cash_pengajuan"); return;}
}
function input_into_log_status($request_id, $response, $action){
    if(mysqli_query($GLOBALS['connection'],"insert into `log_status` (request_id, status, action) values ($request_id, '$response','$action')")){
        popupmessage("request logged!!");
    }
    else popupmessage("request not successfully logged!!");
}
function input_into_activity_log($user_id, $company_id, $request_type, $details, $status){
    $details = '\'' . $details . '\'';
    $query = "insert into `log_activity` (user_id, company_id, request_type, details, status) values ($user_id, $company_id, $request_type,'$details', '$status')";
    if($query = mysqli_query($GLOBALS['connection'], $query) && mysqli_affected_rows($GLOBALS['connection'])){
        popupmessage('users activity logged !!');
    }
    else popupmessage('problem when try to log users activity');
}

//------------------------------------------------------------------
//----------------------------Admin---------------------------------
//------------------------------------------------------------------

function handle_response_accept($request_id_data ,$note){
    $request_type = $request_id_data['request_type'];
    $request_id = $request_id_data['request_id'];
    $user_id = $request_id_data['user_id'];
    $company_id = $request_id_data['company_id'];
    $new_balance = 0;
    if($request_type === 'advance'){
        $new_balance = get_current_balance($user_id, $company_id, $request_type) + $request_id_data['cash_in'] - $request_id_data['cash_out'];
    }
    else{
        $limit = get_request_limit($user_id,$company_id,'reimburse');
        if(get_sum_from_column($user_id, $company_id,'reimburse','cash_out','accept') + $request_id_data['cash_out'] > $limit){
            input_into_activity_log($user_id, $company_id, 'reimburse', 'Reimburse request exceeds reimburse limit', 'rejected');
            popupmessage("exceeds limit reimburse"); 
            return null;
        }       
    }
    $query = "update `petty_cash_request` set balance = $new_balance , status = 'accept' , admins_note = '$note' where request_id = $request_id and status = 'pending'";
    input_into_main($user_id , $company_id , $request_id_data['request_type'], $request_id_data['cash_in'], $request_id_data['cash_out'], $request_id_data['note'], $request_id_data['file']);
    input_into_activity_log($user_id, $company_id, $request_id_data['request_type'], 'Request approved by admin', 'accept');     
    return $query;
}

function handle_request($request_id, $response , $note){
    $request_id_data = mysqli_query($GLOBALS['connection'],"select * from `petty_cash_request` where request_id = $request_id and status = 'pending' limit 1");
    if(!$request_id_data || mysqli_num_rows($request_id_data) <= 0){ 
        input_into_activity_log(null, null, null, 'Request with id '.$request_id.' not found', 'rejected');
        popupmessage("request id not exist / not pending"); return; }
    $request_id_data = mysqli_fetch_assoc($request_id_data);
    $user_id = $request_id_data['user_id'];
    $user = mysqli_query($GLOBALS['connection'],"select user_id from `petty_cash_user` where user_id = $user_id and status = 'active' limit 1");
    if(!$user || mysqli_num_rows($user) <= 0){
        input_into_activity_log($request_id_data['user_id'], $request_id_data['company_id'], $request_id_data['request_type'], 'User not active', 'rejected');
        popupmessage("no active user with this id exist!!"); return;
    }
    $query = null;
    if($response === 'accept') $query = handle_response_accept($request_id_data,$note);
    else { 
        $query = "update `petty_cash_request` set status = '$response', admins_note = '$note' where request_id = $request_id and status = 'pending'";
        input_into_activity_log($user_id, $request_id_data['company_id'], $request_id_data['request_type'], $note, $response);
    }
    if(mysqli_query($GLOBALS['connection'], $query)) {
        $action = ($request_id_data['cash_in'] > 0)? 'cash_in':'cash_out';
        input_into_log_status($request_id,$response,$action);
    }
}

//-----------------------------------------------------------------------------------------------------
//-----------------------------------------User---------------------------------------------------------
//-----------------------------------------------------------------------------------------------------
//add new account
function addusercc($user_id, $company_id, $limit_advance, $limit_reimburse, $note, $status){
    $checkexist = "select user_id from `petty_cash_user` where user_id = $user_id and company_id = $company_id";
    if($user = mysqli_query($GLOBALS['connection'],$checkexist)){
        if(mysqli_num_rows($user) > 0) {
            //input_into_activity_log($user_id, $company_id,'add_account', "Selected account already exist or is pending!!", 'reject');
            popupmessage("Selected account already exist or is pending!!");return false;
        } // user already exist
        if(mysqli_query($GLOBALS['connection'],"insert into `petty_cash_user` (user_id,company_id, limit_advance, limit_reimburse,note,status) values($user_id,$company_id, $limit_advance, $limit_reimburse,'$note','$status')") && mysqli_affected_rows($GLOBALS['connection']) > 0) {
            //input_into_activity_log($user_id, $company_id,'add_account', "Add account was successful!!", 'accept');
            popupmessage("success!!"); 
            return true;}
        else  echo mysqli_error($GLOBALS['connection']);
    }
    return false;
}

//cancel request
function cancel_request($request_id,$user_id,$company_id,$datetime,$request_type){
    popupmessage("cancel request");
    $user = user_check($user_id, $company_id);
    $query = "update `petty_cash_request` set status ='canceled' where request_id = $request_id and user_id = $user_id and company_id=$company_id and created_at = '$datetime' and status ='pending' limit 1";
    $request = mysqli_query($GLOBALS['connection'],$query);
    input_into_log_status($request_id,'accept','cancel');
}

//edit pending request
function edit($request_id,$user_id,$company_id, $amount, $currency, $format, $destination_number,$note,$request_type, $action_type){
    $cash_out = $cash_in = 0;
    if($action_type==="cash_out") {
        $cash_out = $amount;
    }
    else $cash_in = $amount;
    if(checkeditinput($request_id,$user_id,$company_id,$amount) !=='ok') {
        input_into_activity_log($user_id, $company_id, $request_type, "Incorrect Input", 'reject');
        popupmessage("Incorrect Input");        
        return false;
    }
    $query = "update `petty_cash_request` set cash_in=$cash_in , cash_out=$cash_out, note='$note' where request_id=$request_id and status='pending' limit 1";
    $query = mysqli_query($GLOBALS['connection'],$query);
    if(mysqli_affected_rows($GLOBALS['connection'])<=0){
        input_into_activity_log($user_id, $company_id, $request_type, "Edit was not successful", 'reject');
        popupmessage("Edit was not successful");
        return false;
    }
    $action =($cash_in > 0)?'edit_cash_in':'edit_cash_out';
    input_into_log_status($request_id,'pending',$action);
    input_into_activity_log($user_id, $company_id, $request_type, "Edit was successful", 'accept');
    popupmessage("Edit was successful");
    return true;
}

//add record (only for advance)
function add_record($user_id, $company_id, $request_type, $amount, $note, $file,$receipt_number){
    $note = '\'' . $note . '\'';
    $file = '\'' . $file . '\'';
    $balance = check_request($user_id,$company_id,$request_type,0,$amount)-$amount;//get_current_balance($user_id, $company_id, $request_type) - $amount;
    if($balance > 0){
        $query = "insert into `petty_cash_request` (user_id, company_id, request_type, cash_in, cash_out, balance, note, file, status,receipt_number) values ($user_id, $company_id, '$request_type', 0, $amount, $balance, $note, $file,'record',$receipt_number)";
        if($request_id_data = mysqli_query($GLOBALS['connection'], $query)) {
            input_into_log_status(mysqli_insert_id($GLOBALS['connection']),'record','cash_out');
            input_into_activity_log($user_id, $company_id, $request_type, "Record was successfully created", 'accept');
            popupmessage("Record was successfully created!!");
            input_into_main($user_id , $company_id , $request_type, 0, $amount, $note, $file);
            return true;
        }
    }
    input_into_activity_log($user_id, $company_id, $request_type, "Record was not successfully created", 'reject');
    popupmessage("Record was not successfully crated!!");
    return false;
}

function check_request($user_id,$company_id,$request_type,$cash_in,$cash_out){
    if(!user_check($user_id,$company_id)) {
        popupmessage("Users Account not found or not active!");
        return -1;
    } 
    $balance = get_current_balance($user_id, $company_id, $request_type);
    if($request_type ==='advance'){
        if($cash_out >0){
            if(($cash_out + get_sum_from_column($user_id, $company_id, 'advance', 'cash_out', 'pending')) > $balance) {
                popupmessage("Return value is higher than current balance");
                return -1;
            }
        }
        else if($cash_in > 0){
            $limit = get_request_limit($user_id,$company_id,$request_type);
            if($balance +get_sum_from_column($user_id, $company_id, 'advance', 'cash_in', 'pending') + $cash_in > $limit) {
                popupmessage("Request Amount exceeds Limit");
                return -1;
            }
        }
    }
    return $balance;
}
//input users cash_request
function cash_request($user_id, $company_id, $request_type, $cash_in ,$cash_out, $note){
    $balance = check_request($user_id,$company_id,$request_type,$cash_in,$cash_out);
    popupmessage("balance ".$balance);
    if($balance >= 0){
        $query = "insert into `petty_cash_request` (user_id, company_id, request_type, cash_in, cash_out, balance, note, status) values ($user_id,$company_id, '$request_type', $cash_in, $cash_out, $balance, '$note','pending')";
        //cash request return langsung kurangin cash_out request sblm di approve

        if(mysqli_query($GLOBALS['connection'], $query) && mysqli_affected_rows($GLOBALS['connection']) > 0) { 
            $action = ($cash_out>0)?'cash_out': 'cash_in';
            input_into_log_status(mysqli_insert_id($GLOBALS['connection']),'pending',$action);
            input_into_activity_log($user_id, $company_id, $request_type, "Request was successful", 'pending');
            popupmessage("cash_request was successful !!");
            return true;
        }
    }
    input_into_activity_log($user_id, $company_id, $request_type, "Request was not successful", 'reject');
    popupmessage("Cash Request failed !!");
    return false;
}

//-----------------------------------------helper------------------------------------
//butu table/kolom untuk liat limit pengajuan
function get_request_limit($user_id,$company_id,$request_type){
    $limit_type = 'limit_advance';
    if($request_type === 'reimburse') $limit_type = 'limit_reimburse';
    $request_id_data = mysqli_query($GLOBALS['connection'],"select $limit_type from `petty_cash_user` where user_id = $user_id and company_id = $company_id and status = 'active'");
    if($request_id_data){
        $request_id_data = mysqli_fetch_assoc($request_id_data);
        if($request_id_data !== null){
            return $request_id_data[$limit_type];
        }
    }
    return 0;
}

function get_sum_from_column($user_id, $company_id, $request_type, $column_name , $status){
    date_default_timezone_set('Asia/Jakarta');
    $daterange = date_between('created_at',date("Y-m-01 00:00:00") ,date("Y-m-d G:i:s"),false);
    $dana = mysqli_query($GLOBALS['connection'] , "select sum($column_name) as total from `petty_cash_request` where user_id = $user_id and company_id = $company_id and request_type = '$request_type' and status = '$status' and $daterange");
    $request_id_data = mysqli_fetch_assoc($dana);
    return (!$dana || $request_id_data['total'] == null ) ? 0 : $request_id_data['total'];
}   

function get_current_balance($user_id, $company_id, $request_type){
    date_default_timezone_set('Asia/Jakarta');
    $daterange = date_between('created_at',date("Y-m-01 00:00:00") ,date("Y-m-d G:i:s"),false);
   
    $query = mysqli_query($GLOBALS['connection'] , "select balance from `petty_cash_request` where user_id = $user_id and company_id = $company_id and request_type = '$request_type' and (status = 'accept' or status = 'record') and $daterange order by last_update_at desc limit 1");
    $balance = 0;
    if($query){  
        $request_id_data = mysqli_fetch_assoc($query);
        if($request_id_data!=null)$balance = $request_id_data['balance'];
    }

    return $balance;
}

function date_between($datecolumn ,$fromdatetime,$untildatetime,$desc){
    $query = " $datecolumn BETWEEN '$fromdatetime' AND '$untildatetime'";
    if($desc) $query .= ' ORDER BY '.$datecolumn.' DESC';
    return $query;
}

// to check if user with company id $company_id is exist and active 
function user_check($user_id, $company_id){ 
    if($request_id_data = mysqli_query($GLOBALS['connection'],"select user_id from `petty_cash_user` where user_id = $user_id and company_id = $company_id and status = 'active'")){
        $request_id_data = mysqli_fetch_assoc($request_id_data);
        if($request_id_data !== null)  return true;
    }
    return false;
}

function popupmessage($message){
    echo "<script>alert('$message');</script>";
}

function datetimeconverter($datetime, $format){
    return date($format,strtotime($datetime));
}

//-------- -----------Front-----------------
function get_cash_request($user_id, $company_id, $request_type){
    $result = mysqli_query($GLOBALS['connection'],"select * from `petty_cash_request` where user_id='$user_id' and company_id='$company_id' and request_type='$request_type'");
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $result;
}


function getallusersaccounts($user_id){
    $result = mysqli_query($GLOBALS['connection'],"select * from `petty_cash_user` where user_id='$user_id'");
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $result;
}

function getallactiveusersaccounts($user_id){
    $result = mysqli_query($GLOBALS['connection'],"select * from `petty_cash_user` where user_id='$user_id' and status='active'");
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $result;
}

function user_exist($user_id){
    $result = mysqli_query($GLOBALS['connection'],"select * from `petty_cash_user` where user_id='$user_id' limit 1");
    return mysqli_num_rows($result) > 0;
}

function getallcompanies(){
    $result = mysqli_query($GLOBALS['connection'],"select * from `company`");
    $result =  mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $result;
}
function getallactiveuserscompanies($user_id){
    $result = mysqli_query($GLOBALS['connection'],"select company_id from `petty_cash_user` where user_id = $user_id and status = 'active'");
    if(mysqli_num_rows($result) > 0) $result =  mysqli_fetch_all($result, MYSQLI_ASSOC);
    else $result = null;
    return $result;
}
function getcompany_name($company_id){
    $result = mysqli_query($GLOBALS['connection'],"select * from `company` where company_id = $company_id limit 1");
    $result =  mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $result[0]['name'];
}

function getallcurrencies(){
    $result = mysqli_query($GLOBALS['connection'],"select * from `petty_cash_currency` where status ='accept'");
    $result =  mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $result;
}

function getcurrency_name($currency_id){
    $result = mysqli_query($GLOBALS['connection'],"select * from `petty_cash_currency` where currency_id = $currency_id limit 1");
    $result =  mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $result[0]['name'];
}


function getallformats(){
    $result = mysqli_query($GLOBALS['connection'],"select * from `petty_cash_format` where status ='accept'");
    $result =  mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $result;
}

function getformat_name($format_id){
    $result = mysqli_query($GLOBALS['connection'],"select * from `petty_cash_format` where format_id = $format_id limit 1");
    $result =  mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $result[0]['name'];
}

function checkeditinput($request_id,$user_id,$company_id,$amount){
    $query = "select cash_in,cash_out from `petty_cash_request` where request_id = $request_id and status='pending' and user_id=$user_id and company_id=$company_id  limit 1";
    $query = mysqli_query($GLOBALS['connection'],$query);
    $result = mysqli_fetch_assoc($query);
    if(!$query || $result == null){ 
        return "Request not found";
    }
    if($result['cash_in'] > 0) {
        $sum = $amount + get_current_balance($user_id, $company_id, 'advance') +get_sum_from_column($user_id, $company_id, 'advance', 'cash_in' , 'pending') - $result['cash_in'];
        if($sum > get_request_limit($user_id,$company_id,'advance')) return "Request Amount exceeds Limit";
    }
    else {
        $sum = $amount + get_sum_from_column($user_id, $company_id, 'advance', 'cash_out' , 'pending') - $result['cash_out'];
        if($sum > get_current_balance($user_id, $company_id, 'advance')) return "Return value is higher than current balance";
    }
    return "ok";
}
?>
