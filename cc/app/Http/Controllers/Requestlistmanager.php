<?php 
    $amounttxt = 'Total';
    $barcolor = '#07A4EA';
    $balance = 0;
    $company_id=1;
    $user_id=1;//$_SESSION['user_id'];
    if($request_type === "advance") {
        $amounttxt = 'Balance';
        $barcolor = '#12B533';
        $balance = get_current_balance($user_id,$company_id,'advance');
    }
    else if($request_type === 'reimburse') $balance =  get_sum_from_column($user_id,$company_id,'reimburse', 'cash_out' , 'accept');
    $histories = get_cash_request($user_id,$company_id,$request_type);
?>
<div class="row" style="height: 45px; width:90%; margin-top:0px; margin-left:auto; margin-right:auto; margin-bottom:21px; background: white; border-radius: 5px; color: black; font-weight: bold; font-size: 15px;">
    <div class="col-4" style="text-align: left;">
        <label style="padding-left: 5px;padding-top:10px;"><?php echo $amounttxt;?></label>
    </div>  
    <div class="col-8" style="text-align: right; padding-right: 15px;padding-top:10px;">
        <?php echo "IDR ".number_format($balance,0,",",".");?>
    </div>         
</div>           
<div class="container px-0 py-0 request_list">
<?php
    $link="";
    $tablecontents="";
    if($histories != null) {
        for ($i =count($histories)-1; $i>=0; $i--) {
            $color = 'red';
            $status = 'Request - '.$histories[$i]['status'];;
            $link = 'CCrequest_details.php';
            $amount= $histories[$i]['cash_out'];
            $amounttxt = "-IDR ".number_format($amount,0,",",".");
            $action_type = "cash_out";
            $act = 'returndetails';
            if($histories[$i]['status']=='record'){
                $link = 'CCrecord_edit.php';
                $status = 'Record - '.$histories[$i]['note'];
                $act = 'recorddetails';
            }
            else if($amount > 0) {
                $link = 'CCreturn_edit.php';
                $status = 'Return - '.$histories[$i]['note']." - " .$histories[$i]['status'];
            }
            else {
                $color='green';
                $amount=$histories[$i]['cash_in'];
                $amounttxt = "IDR ".number_format($amount,0,",",".");
                $action_type = "cash_in";
                $act = 'requestdetails';
            }
            if($i == count($histories)-1 || (int)datetimeconverter($histories[$i]['created_at'],'Y') - (int)datetimeconverter($histories[$i+1]['created_at'],'Y') < 0 || (int)datetimeconverter($histories[$i]['created_at'],'m') - (int)datetimeconverter($histories[$i+1]['created_at'],'m') < 0) {
            $tablecontents .="<div class=\"row\"id=\"mytablecontent\" style=\"width: 100%; margin: 0 auto; height: 30px;\"><label style=\"background-color: #E2E2E2; height: 100%; font-size: 15px;font-weight: bold; padding-left: 8px; padding-top: 4px;\">". datetimeconverter($histories[$i]['created_at'],'M')." ".datetimeconverter($histories[$i]['created_at'],'Y')."</label></div>";
            }
            $admins_note = ($histories[$i]['admins_note'] === '')? 'a': $histories[$i]['admins_note'];
            $note = ($histories[$i]['note'] === '')? 'a': $histories[$i]['note'];
            $receipt_number = ($histories[$i]['receipt_number'] === '')? 'a': $histories[$i]['receipt_number'];
            
            $tablecontents .= "
            <a href= /details/$act/".$amount."/".$histories[$i]['request_id']."/".$action_type."/".$company_id."/".$request_type."/".$histories[$i]['status']."/".$histories[$i]['created_at']."/".$admins_note."/".$note."/".$receipt_number." class=\"row\" style=\"margin: 0 auto; background-color: white; padding-top: 3px; padding-bottom: 3px;\">
                <div class=\"col-4\" style=\"font-size: 14px; color:black; height:1px;font-weight: bold; font-family: Arial, Helvetica, sans-serif;\">".datetimeconverter($histories[$i]['created_at'],'d')." ".datetimeconverter($histories[$i]['created_at'],'M') .
                "</div> 
                <div class=\"col-8\" style=\"font-size: 16px; color:".$color."; font-weight: normal;font-weight: bold; font-family: Arial, Helvetica, sans-serif;text-align: right;\">".$amounttxt. 
                "</div>
                <div class=\"col-12\" style=\"font-size: 11px;color:black; font-weight: normal;font-weight: normal; font-family: Arial, Helvetica, sans-serif;\">".$status.
                "</div>
            </a> 
            <hr style=\"margin: 0px\">";
            popupmessage(" /details/".$amount."/".$histories[$i]['request_id']."/".$action_type."/".$company_id."/".$request_type."/".$histories[$i]['status']."/".$histories[$i]['created_at']."/".$admins_note."/".$note."/".$receipt_number);
        }
    }
    echo $tablecontents;
?>      
</div>
</div>
</div>
<div style="height:100px;"></div>
<div style=" width: 100%; height: 101px; padding-top: 0px; background:white; position: fixed; bottom: 0; ">
    <div class="container px-5 py-4">
        <div class="row gx-5 gy-3">
            <div class="col-6">
                <a href="?act=request&company_id=<?php echo $company_id;?>&request_type=<?php echo $request_type;?>" name="advance_request" style="width: 100%;
                height: 30px; padding-top: 7px; background:  white; border-radius: 5px; text-align: center;
                font-size: 10px; border: 1px solid #12B533; color:#12B533; font-weight: bold;display:block;">
                    Request  
                </a>   
            </div>
            <?php
                if($request_type==='advance') echo "
                    <div class=\"col-6\">
                        <a href=\"?act=return&company_id=".$company_id."&request_type=advance\" name=\"return_request\" style=\"width: 100%;
                        height: 30px; padding-top: 7px; background:  white; border-radius: 5px; text-align: center;
                        font-size: 10px; border: 1px solid #12B533; color:#12B533; font-weight: bold; display:block;\">
                            Return
                        </a>
                    </div>
                    <div class=\"col-12\">
                        <a href=\"?act=addrecord&company_id=".$company_id."&request_type=advance\" name=\"add_record\" value =\"add record\" style=\"width: 100%; height: 30px; padding-top: 7px; background: #12B533; border-radius: 5px; text-align: center; font-size: 10px;  border: 0; color:white;  font-weight: bold;display:block;\">
                            Add Record
                        </a>
                    </div>";
            ?> 
        </div>
    </div>
</div>

