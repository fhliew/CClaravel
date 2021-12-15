<?php
   /* session_start();
    include_once "CC_control.php";
    date_default_timezone_set('Asia/Jakarta');
    $companies = getallactiveuserscompanies($_SESSION['user_id']);*/
?>

<form  method="POST">
    <div class="col-sm-12" style="height: 41px; background-color:white; padding-bottom: <?php if($_GET['act'] !="request") echo "153"; else echo"281";?>px; padding-top: 15px;">
        <div class="row gy-1 container">
            <div class="col-12">
                <div class="form-group">
                    <label for="amount" id="input_details">  Account  </label>
                    <select name="account" id="input_account" style="outline: 0px !important;
                            -webkit-appearance: none; box-shadow: none !important; border: none; 
                            padding-left: 0px; margin-bottom: -6px; font-size: 15px;
                            width: 100%; font-style: normal;font-weight: normal;
                            line-height: 2;height: 32px;" class="form-control border-top-0">                    
                            <option selected value = <?php 
                                $cid = $_GET['company_id'];
                                if(isset($_POST['account'])) $cid= $_POST['account'];
                                echo $cid;
                            ?>> 
                                <?php echo getcompany_name($cid);?> 
                            </option>
                            <?php
                                $options = "";
                                for($i=0; $i< count($companies); $i++){
                                    if($companies[$i]['company_id'] != $_GET['company_id']) {
                                        $options .= "<option value=".$companies[$i]['company_id'].">".getcompany_name($companies[$i]['company_id'])."</option>";
                                    }
                                }
                                echo $options;
                            ?>
                    </select>
                    <hr id="line">
                </div>
            </div>
            
            <div class="col-6">
                <div class="form-group">
                    <label for="amount"id="input_details"> Amount </label>
                    <input type="text" name="amount" id="input_amount" style="outline: 0px !important;
                            box-shadow: none !important; border: none; 
                            padding-left: 0px; margin-bottom: -6px;
                            font-size: 15px; width: 100%; font-style: normal;
                            font-weight: normal; line-height: 2;
                            height: 32px;"class="form-control border-top-0" placeholder="Amount">  
                    </input>   
                    <hr id="line">
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="currency"id="input_details"> Currency </label>
                    <select name="currency" id="input_formA" class="form-control border-top-0">
                        <option disabled selected value> Select Currency </option>
                        <option value="IDR">IDR</option>
                        <option value="USD">USD</option>
                    </select>
                    <hr id="line">     
                </div>                           
            </div> 
            <?php
                $addrecord = "
                    </div>
                    </div>
                    <div class=\"col-sm-12\"  id=\"addrecordmoredetailsspadding\">
                        <div style=\"font-weight: normal; width:100%; height:28px;
                        text-align: left; color: black; font-family:Arial, Helvetica, sans-serif; font-size: 14px;\"> More Details
                        </div>             
                    </div>
                    <div style=\"background-color:white;width:100%;\">
                        <div class=\"container px-4 py-3\" id = \"request_margin\">
                            <div class=\"row gy-1\" id =\"request_moredetails\">
                                <div class=\"col-12\">
                                    <div class=\"form-group\">
                                        <label for=\"date\" id=\"input_details\">  <br>Date </label>
                                        <input type=\"text\" name=\"date\" id=\"input_formA\" class=\"form-control border-top-0\" 
                                        value=\"".date("M,d,Y")."\"placeholder=\"Date\" readonly>
                                    </div>
                                </div>
                                <div class=\"col-12\">
                                    <div class=\"form-group\">
                                        <label for=\"note\" id=\"input_details\">  <br>Note </label>
                                        <input type=\"text\" name=\"note\" id=\"input_formA\" placeholder= \"Note\" class=\"form-control border-top-0\"> </input>
                                        <hr id=\"line\"> 
                                    </div>   
                                </div>
                                <div class=\"col-12\">
                                    <label for=\"receipt_number\" id=\"input_details\">  <br>Receipt Number </label>
                                </div>
                                <div class=\"col-5\">
                                    <input type=\"text\" name=\"receipt_number\" id=\"input_formA\" 
                                    value=\"".date("ymdHis")."".$_SESSION['user_id']."\"placeholder= \"Recipt Number\" class=\"form-control border-top-0\" readonly> </input>
                                </div>
                                <div class=\"col-7\">
                                    <label style=\"padding-left : 0px; padding-top: 10px;font-size: 12px; font-weight: normal; color:red;\"> *Write this Number in your Receipt </label>
                                </div>
                                <div class=\"col-12\">
                                    <label for=\"attachment\" id=\"input_details\"> <br>Attachment </label>
                                </div>
                                <div class=\"col-12\">
                                    <input type=\"file\" class=\"form_control_file\" name=\"attachment\" style =\" outline: 0px !important;
                                    -webkit-appearance: none;
                                    box-shadow: none !important;
                                    border: none; \";  box-shadow: none !important; placeholder= \"Receipt image\" class=\"form-control border-top-0\"> </input>
                                </div> 
                                <div class=\"col-12\">
                                    <div class=\"form-group\" style=\"padding-top: 16px;\">
                                        <label for=\"note\" id=\"input_details\">  Note </label>
                                        <input type=\"text\" name=\"adminsnote\" id=\"input_form\" class=\"form-control border-top-0\" placeholder=\"Admins Note\" readonly></input>
                                        <hr id=\"line\">     
                                    </div>  
                                </div>
                            </div>
                        </div>
                    </div>";

                $request = "
                    <div class=\"col-6\">
                        <div class=\"form-group\">
                            <label for=\"format\"id=\"input_details\"> Format  </label>
                            <select name=\"currency\" id=\"input_formA\" class=\"form-control border-top-0\">
                                <option disabled selected value> Select Format </option>
                                <option value=\"Cash\">Cash</option>
                                <option value=\"OVO\">OVO</option>
                            </select>  
                            <hr id=\"line\">              
                        </div> 
                    </div>
                    
                    <div class=\"col-6\">
                        <div class=\"form-group\">
                            <label for=\"destination_number\" id=\"input_details\">  Destination Number </label>
                            <input type=\"text\" name=\"destination_number\"style=\"height:37px;margin-bottom:-11px;\" id=\"input_formA\"  class=\"form-control border-top-0\" placeholder=\"Destination Number\"></input>
                            <hr id=\"line\">                 
                        </div>
                    </div>
                    <div class=\"col-12\">
                        <div class=\"form-group\">
                            <label for=\"note\" id=\"input_details\">  Note </label>
                            <input type=\"text\" name=\"note\" id=\"input_form\" class=\"form-control border-top-0\" placeholder=\"Note\"></input>
                            <hr id=\"line\">     
                        </div>  
                    </div>
                    ";
                if($_GET['act'] === 'request') echo $request;
                else if($_GET['act']==='addrecord') echo $addrecord;
            ?>
        </div>
    </div>
    <div style="height:100px;"></div>
    <div style=" width: 100%; height: 101px; padding-top: 0px; background:white; position: fixed; bottom: 0;">
        <div class="container px-2 py-4">
            <div class="row gy-2">
                <div class="col-12">
                </div>
                <div class="col-12" id ="error_message">
                </div>  
                <div class="col-12">
                    <input disabled type ='submit' name="submit_request" id = 'submit_button' style="width: 100%;
                    height: 30px; padding-top: 3px; background:  transparent; border-radius: 5px; text-align: center;
                    font-size: 10px; margin-top: 6px; color: transparent; border: transparent;
                    font-weight: bold;" value = "Submit Request">
                    </input>   
                </div> 
            </div> 
        </div>
    </div>
</form>
<script>
    var input_amount = document.getElementById('input_amount');
    var error_message = document.getElementById('error_message');
    var input_account = document.getElementById('input_account');

    input_account.addEventListener("change", function() {
        var xhr = new XMLHttpRequest();
        let url = "Errormessage.php?amount="+input_amount.value+"&user_id="+<?php echo $_SESSION['user_id'];?>+"&company_id="+input_account.value+
        "&requesttype=<?php echo $_GET['requesttype'];?>&op=<?php echo $_GET['act'];?>";
        xhr.onreadystatechange = function(){
            if(xhr.readyState == 4 &&  xhr.status == 200){
                error_message.innerHTML = xhr.responseText;
                if(xhr.responseText[0] =='<') {  
                    document.getElementById('submit_button').disabled = true;
                    document.getElementById("submit_button").style.color = document.getElementById("submit_button").style.backgroundColor = 'transparent';
                }
                else {
                    document.getElementById('submit_button').disabled = false;
                    document.getElementById("submit_button").style.backgroundColor = '#12B533';
                    document.getElementById("submit_button").style.color = 'white';
                }
            }
        }
        xhr.open('GET',url,true);
        xhr.send();
        return;
    });                                       
    input_amount.addEventListener('keyup',function(){
        var xhr = new XMLHttpRequest();
        let url = "Errormessage.php?amount="+input_amount.value+"&user_id="+<?php echo $_SESSION['user_id'];?>+"&company_id="+input_account.value+
        "&requesttype=<?php echo $_GET['requesttype'];?>&op=<?php echo $_GET['act'];?>";
        xhr.onreadystatechange = function(){
            if(xhr.readyState == 4 &&  xhr.status == 200){
                error_message.innerHTML = xhr.responseText;
                if(xhr.responseText[0] =='<') {  
                    document.getElementById('submit_button').disabled = true;
                    document.getElementById("submit_button").style.color = document.getElementById("submit_button").style.backgroundColor = 'transparent';
                }
                else {
                    document.getElementById('submit_button').disabled = false;
                    document.getElementById("submit_button").style.backgroundColor = '#12B533';
                    document.getElementById("submit_button").style.color = 'white';
                }
            }
        }
        xhr.open('GET',url,true);
        xhr.send();
    });
</script>
<?php
    if (isset($_POST['submit_request'])) {
        $cid = $_GET['company_id'];
        if(isset($_POST['account'])){
            $cid = $_POST['account'];
            $_GET['company_id'] = $cid;
        }
        if($_GET['act'] ==='addrecord'){
            if(add_record($_SESSION['user_id'], $cid, 'advance', $_POST['amount'], $_POST['note'], $_POST['attachment'], $_POST['receipt_number'])){
                popupmessage($_POST['receipt_number']);
                $_GET['company_id'] = $_POST['account'];
                return;
            }
        }
        $cash_in = $cash_out = $_POST['amount'];
        if($_GET['requesttype'] === 'reimburse' || $_GET['act'] === 'return')  $cash_in = 0;
        else $cash_out = 0; 
        $note='';
        if($_GET['act']!='return') $note = $_POST['note'];
        if(cash_request($_SESSION['user_id'], $cid, $_GET['requesttype'], $cash_in ,$cash_out, $note)){
            $_GET['company_id'] = $_POST['account'];
        }
    }
?>