<?php
    session_start();
    include "CCa.php";
    $useraccount = getallusersaccounts($_SESSION['user_id']);
    if (isset($_POST['submit_add-user'])) {
        popupmessage('Try to add user with name '.$_POST['name']);
        if(addusercc($_SESSION['user_id'],$_POST['account'],6,7,$_POST['note'],'active')) {
           
        } 
    }
    $companies = getallcompanies();
?>

    <form  method="POST">
        <div class="row gy-1">
            <div class="col-12">
                <div class="form-group">
                    <label for="name" id="input_details">  Name  </label>
                    <input type="text" name="name" id="input_form" class="form-control border-top-0" placeholder="Users_Name">
                    <hr id="line">         
                </div>
            </div>
            <div class="col-12">
            <select name="account" id="input_formA" class="form-control border-top-0">
                <option disabled selected value> -- select an Account -- </option>
                <?php
                    $options = "";
                    for($i=0; $i< count($companies); $i++){
                        $options .= "<option value=".($i+1).">".$companies[$i]['name']."</option>";
                    }
                    echo $options;
                ?>
            </select>
            <hr id="line">
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="phone" id="input_details">  Phone  </label>
                    <input type="text" name="phone" id="input_form" class="form-control border-top-0" placeholder="Phone">
                    <hr id="line">                 
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="note" id="input_details">  Note </label>
                    <input type="text" name="note" id="input_form" class="form-control border-top-0" placeholder="Note"></input>
                    <hr id="line">  
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="date" id="input_details">  Date </label>
                    <input type="text" name="date" value= <?php echo date("M"),date("d,Y");?> id="input_form" class="form-control border-top-0" placeholder="Date" readonly>
                </div>
            </div>
            <div class="col-6"><label></label></div>
            <div class="col-6">              
                <input type="submit" name="submit_add-user" value="submit" style="width: 95%;
                    height: 40px; padding-top: 0px; background:  #12B533; border-radius: 5px; text-align: center;
                    font-size: 15px; margin-top: 6px; color: white; border: transparent;
                    font-weight: bold;">
                </input>   
            </div>
            <br>
        </div>
    </form>
    <div class="col-sm-12" id="addaccounthistory">
        <div style="font-weight: normal; width:100%; height:28px; text-align: left; color: black; font-family:Arial, Helvetica, sans-serif; font-size: 14px;"> History</div>
    </div> 
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Note</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="mytablecontent">
                <?php
                    $table="";                                                                                                                 
                    for($i=0; $i<count($useraccount); $i++){
                    $table .="<tr><td>".$useraccount[$i]['last_update_at']."</td><td>".$useraccount[$i]['note']."</td><td>".$useraccount[$i]['status']."</td><td>Edit</td></tr>";
                    }
                echo $table;
                ?>
            </tbody>
        </table>
    </div> 
<script>
    function refreshtable(){
        var input = document.getElementById('mytablecontent');
        $table ="<tr><td>".$useraccount[$i]['last_update_at']."</td><td>".$useraccount[$i]['note']."</td><td>".$useraccount[$i]['status']."</td><td>Edit</td></tr>";
        input.appendChild(table);
    }
    });
</script>