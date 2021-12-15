<?php
    //include_once "CC_control.php";
    /*$accountlist = getallactiveusersaccounts($_SESSION['user_id']);
    $tablecontents ="";
    for ($i = 0; $i < count($accountlist); $i++) {
        $reimburse_balance =  get_sum_from_column($_SESSION['user_id'],$accountlist[$i]['company_id'],'reimburse','cash_out','accept');
        $advance_balance = get_current_balance($_SESSION['user_id'],$accountlist[$i]['company_id'],'advance');
        $limit_reimburse = $accountlist[$i]['limit_reimburse'];
        $limit_advance = $accountlist[$i]['limit_advance'];
        $_POST['user_id'] = $_SESSION['user_id'];
        $tablecontents.= "
        <div class=\"row gx-4\" id=\"account_card\">
            <a href=\"?act=accountdetails&company_id=".$accountlist[$i]['company_id']."&limit_reimburse=".$limit_reimburse."&limit_advance=".$limit_advance."\">
                <div class=\"col-12\" style=\"font-size: 15px; color:white; height:1px; font-weight: bold; font-family: Arial, Helvetica, sans-serif;text-align:right;\">
                    <label>".getcompany_name($accountlist[$i]['company_id'])."</label>
                </div>
                <div class=\"col-12\" style=\" margin-top:25px;padding-left: 0px; font-size: 13px; color: white; font-weight: bold; font-family: Arial, Helvetica, sans-serif;text-align: left;\">
                    <label>".$accountlist[$i]['user_id']."</label>
                    <hr style=\"margin-top: 1px;border: 1px solid #FFFFFF; opacity:1;\">
                </div>
            </a>
            <div class=\"col-6\" style=\"padding-left: 15px; font-size: 13px;color: white; font-weight: normal; font-family: Arial, Helvetica, sans-serif;\">
                Advance
            </div>
            <div class=\"col-6\" style=\"padding-right: 15px;font-size: 13px;color: white;font-weight: normal; font-family: Arial, Helvetica, sans-serif; text-align: right;\"> 
                Reimburse 
            </div>
            <div class=\"col-6\">
                <a href=\"?act=requestlist&company_id=".$accountlist[$i]['company_id']."&requesttype=advance\" id=\"accountdetails_left\">
                    <label style=\"font-size: 15px; color:#3F3F3F; font-weight: bolder;\">".$advance_balance."</label> 
                </a>
            </div>
            <div class=\"col-6\">
                <a href=\"?act=requestlist&company_id=".$accountlist[$i]['company_id']."&requesttype=reimburse\"id=\"accountdetails_right\">
                    <label style=\"font-size: 15px; color:#3F3F3F;; font-weight: bolder;\">".$reimburse_balance."</label>
                </a>
            </div>
        </div>";
    }
    echo $tablecontents;*/
    echo "<div class= \"col-12\"><label style=\"margin-top:0px;margin-left:0px;\">LIST MANAGER</label></div>";
?>