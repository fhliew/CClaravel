<?php 
    $user_id = 1;//$_SESSION['user_id'];
    //getrequest details
?>
<div class="col-sm-12" style="height: 41px; background-color:white; padding-bottom: 142px; width:100%; margin:0;">
    <form method="POST">
        <div class="container py-4">
            <div class="row gy-0">
                <div class="col-12">
                    <div class="form-group">
                        <label for="amount" id="input_details">  Account  </label>
                        <input type="text" name='account' id="input_form" class="form-control border-top-0" value="<?php echo getcompany_name($company_id);?>" readonly>
                        </input>
                        <hr id="line">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="amount"id="input_details">  Amount  </label>
                        <input type="text" name='amount' style = "outline: 0px !important;
                        box-shadow: none !important; border: 0; padding-left: 0px;
                        height: 18px; width: 100%; font-style: normal; font-weight: normal;
                        background: transparent; font-size: 15px;"
                        id="input_amount" class="form-control border-top-0" value="<?php 
                        if($status!= 'pending') echo number_format((float)$amount,0,",",".");
                        else {
                            if(!isset($amount))echo $amount;
                            else echo $amount;
                        }
                        ?>" <?php if($status!= 'pending') echo "readonly";?>>
                        </input>
                        <hr id="line">
                    </div>
                </div>  
                <div class="col-6">
                    <div class="form-group">
                        <label for="currency"id="input_details"> Currency </label>
                        <input type="text" name ='currency' id="input_form" class="form-control border-top-0" placeholder="Currency" <?php if($status!= 'pending') echo "readonly";?>>
                        </input>
                        <hr id="line"> 
                    </div>
                </div>   
                <?php
                    if($status ==='record'){
                        $moredetails = " 
                        </div>
                        </div>
                        </div>
                        </div>
                        <div class=\"col-sm-12\"  id=\"addrecordmoredetailsspadding\">
                            <div style=\"font-weight: normal; width:100%; height:28px;
                            text-align: left; color: black; font-family:Arial, Helvetica, sans-serif; font-size: 14px;\"> More Details
                            </div>             
                        </div>
                        <div style=\"background-color:white;width:100%;\">
                            <div class=\"container py-5 px-4\">
                                <div class=\"row gy-0\" id =\"record_titlecontentpadding\">"
                        ;
                        echo $moredetails;
                    }
                    else{
                        $readonly = '';
                        if($status!= 'pending') $readonly = 'readonly';
                        $details = 
                            "<div class=\"col-6\">
                                <div class=\"form-group\">
                                    <label for=\"format\"id=\"input_details\"> Format  </label>
                                    <input type=\"text\" name='format' id=\"input_form\" class=\"form-control border-top-0\" placeholder=\"format\"
                                    $readonly>
                                    </input>
                                    <hr id=\"line\"> 
                                </div>
                            </div>  
                            <div class=\"col-6\">
                                <div class=\"form-group\">
                                    <label for=\"destination_number\" id=\"input_details\"> Destination Number </label>
                                    <input type=\"text\" name='dest_number' id=\"input_form\" class=\"form-control border-top-0\" placeholder=\"Destination Number\" $readonly>
                                    </input>
                                    <hr id=\"line\"> 
                                </div>
                            </div>";
                        echo $details;
                    }
                ?>

                <div class="col-12">
                    <div class="form-group">
                        <label for="note" id="input_details">  Note </label>
                        <input type="text" name='note' id="input_form" class="form-control border-top-0" 
                        value="<?php 
                            if(isset($note)) echo $note;else echo $note;?>" <?php if($status!= 'pending') echo "readonly";?>></input>
                        <hr id="line">     
                    </div>
                </div>
                <?php
                    if($act === 'recorddetails')
                    echo "<div class=\"col-12\">
                            <label for=\"receipt_number\" id=\"input_details\">  <br>Receipt Number </label>
                        </div>
                        <div class=\"col-5\">
                            <input type=\"text\" name=\"receipt_number\" id=\"input_formA\" 
                            value=\"".$receipt_number."\"placeholder= \"Receipt Number\" class=\"form-control border-top-0\" readonly> </input>
                        </div>
                        <div class=\"col-7\">
                            <label style=\"padding-left : 0px; padding-top: 10px;font-size: 12px; font-weight: normal; color:red;\"> *Write this Number in your Receipt </label>
                        </div>
                        <div class=\"col-12\">
                            <label for=\"attachment\" id=\"input_details\"> <br>Attachment </label>
                        </div>
                        <div class=\"col-12\">
                            <input type=\"file\" class=\"form_control_file\" name=\"attachment\" style =\" outline: 0px !important;
                            box-shadow: none !important; padding-top:11px;
                            border: none; \";  box-shadow: none !important; placeholder= \"Receipt image\" class=\"form-control border-top-0\"> </input>
                        </div> ";
                ?>
                <div class="col-12">
                    <div class="form-group">
                        <label for="date" id="input_details">  <br>Date </label>
                        <input type="text" name="datetime" id="input_formA" class="form-control border-top-0" value="<?php echo "".$datetime;?>" readonly></input>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="status" id="status_show" style ="width: 100%;height: 14px;left: 27px;top: 131px;font-style: normal;font-weight: normal; font-size: 12px;line-height: 14px;display: flex;align-items: center;">  
                        <br>Status </label>
                        <input type="text"name = "status" id="input_formA" class="form-control border-top-0" 
                        value="<?php if(isset($_POST['submit_cancel'])) echo "canceled"; else echo $status;?>" readonly></input>
                    </div>
                </div>
                <?php
                    $admins_note="
                    <div class=\"col-12\">
                        <div class=\"form-group\">
                            <label for=\"note\" id=\"input_details\">  <br>Note </label>
                            <input type=\"text\" id=\"input_formA\"  class=\"form-control border-top-0\" name=\admins_note\" 
                            value=\"".$admins_note."\" readonly></input>
                        </div>
                    </div>";
                    if($act === 'requestdetails') echo $admins_note;
                    if($status ==='record') echo "</div>";
                ?>
                </div>
            </div>
            <div style="height:100px;"></div>
            <div style=" width: 100%; height: 101px; padding-top: 0px; background:white; position: fixed; left:0; bottom: 0;">
                <div class="container py-0">
                    <div class="row gy-0">
                        <div class="col-12" id ="error_message"></div>  
                        <?php
                        $buttons = "
                        <div class=\"row mx-auto\">
                            <div class=\"col-12\">
                                <label>  </label>
                            </div>
                            <div class=\"col-6\">
                                <input type=\"submit\" name=\"submit_cancel\" value=\"Cancel\" style=\"width: 100%;
                                height: 30px; padding-top: 0px; background:  #FF000F; border-radius: 5px; text-align: center;
                                font-size: 10px; margin-top: 6px; color: white; border: transparent;
                                font-weight: bold;\">
                                </input>   
                            </div> 
                            <div class=\"col-6\">
                                <input disabled type=\"submit\" name=\"submit_edit\" id=\"submit_button\" value=\"Edit\" style=\"width: 100%;
                                height: 30px; padding-top: 0px; background: transparent; border-radius: 5px; text-align: center;
                                font-size: 10px; margin-top: 6px; color: transparent; border: transparent;
                                font-weight: bold;\">
                                </input>   
                            </div> 
                        </div>";            
                        if($status === 'pending') echo $buttons;
                        ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    var input_amount = document.getElementById('input_amount');
    var error_message = document.getElementById('error_message');
   
    input_amount.addEventListener('keyup',function(){
        var xhr = new XMLHttpRequest();
        let url = "Errormessage.php?amount="+input_amount.value+"&user_id="+<?php echo $user_id;?>+"&company_id="+<?php echo $company_id;?>+"&requesttype=<?php echo $request_type;?>&op=edit&requestid="+<?php echo $request_id;?>;
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
    if(isset($_POST['submit_cancel'])){
        $cid = $company_id;
        $req = $request_type;  
        cancel_request($requestid,$user_id,$company_id,$_POST['datetime'],$request_type);
        $status ='canceled';
    }else if(isset($_POST['submit_edit'])){
        $cid = $company_id;
        if(!isset($_POST['account'])) $cid = $_POST['account'];
        if(edit($requestid,$user_id,$cid,$amount,$_POST['currency'],$_POST['format'],$_POST['dest_number'],$note,$request_type,$_GET['action'])){
            $amount = $amount;
        }
    }
?>