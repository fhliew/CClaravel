</div>
</div>
<div class="col-sm-12" style="height: 41px; background-color:white; padding-bottom: 370px; padding-top: 6px; margin-top:-70px;">
    <div class="container px-0 py-4">
        <div class="row gy-0">
            <div class="col-12">
                <div class="form-group">
                    <label for="name" id="input_details">  Name  </label>
                    <input type="text" name="name" id="input_form" value=<?=1?> class="form-control border-top-0" placeholder="Users_Name"></input>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="phone" id="input_details">  Phone  </label>
                    <input type="text" name="phone" id="input_form" class="form-control border-top-0" placeholder="Phone"> </input>
                </div>
            </div>
            <div class="col-12">
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="company"id="input_details">  Company  </label>
                    <input type="text" name="company" id="input_form" value=<?= $company_id ?> class="form-control border-top-0" placeholder="Company"></input>
                </div>
            </div>  
            <div class="col-12">
                <div class="form-group">
                    <label for="reimburse_limit" id="input_details">  Reimburse Limit </label>
                    <input type="text" name="reimburse_limit" id="input_form" value=<?= $limit_reimburse ?> class="form-control border-top-0" placeholder="Reimburse Limit">
                </div>
            </div>
        <div>
    </div>
    <div class="container px-3">
        <div class="row gy-0">
            <div class="col-6">
                <div class="form-group">
                    <label for="advance_limit" id="input_details">  Advance Limit </label>
                    <input type="text" name="advance_limit" id="input_form" value=<?= $limit_advance ?> class="form-control border-top-0" placeholder="Advance Limit">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="advance_due_days" id="input_details">  Advance Due Days </label>
                    <input type="text" name="advance_due_days" id="input_form" class="form-control border-top-0" placeholder="Advance Due Days">
                </div>
            </div>             
        </div>
