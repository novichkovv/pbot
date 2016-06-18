<h3 class="page-title"> <?php echo isset($_GET['id']) ? 'Edit' : 'Create'; ?> Campaign
    <small></small>
</h3>
<div class="row">
    <div class="col-md-6">
        <form id="campaign_form" action="" method="post" class="form-horizontal">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-docs font-dark"></i>
                        <span class="caption-subject bold uppercase"> Campaign Form</span>
                    </div>
                    <div class="actions">

                    </div>
                </div>
                <div class="portlet-body">
                    <div class="form-group">
                        <label class="control-label col-md-5">Campaign Name *</label>
                        <div class="col-md-7">
                            <input type="text" name="campaign_name" autocomplete="off" class="form-control"  data-require="1" value="<?php echo $campaign['campaign_name']; ?>">

                            <div class="error-require validate-message">
                                Required Field
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="phones_group">
                        <label class="control-label col-md-5">Campaign Virtual Numbers *</label>
                        <?php if ($phones): ?>
                            <?php foreach ($phones as $i => $number): ?>
                                <div class="phone-form col-md-7<?php if($i) echo ' col-md-offset-5'; ?>">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <input type="text" name="phones[]" class="form-control" value="<?php echo $number['phone']; ?>">
                                        </div>
                                        <div class="col-md-3">
                                            <button type="button" class="btn btn-icon red btn-outline delete_phone"><i class="fa fa-trash"></i> </button>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <div class="col-md-7 col-md-offset-5">
                            <div class="row">
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="add_phone" value="" placeholder="Add new number" name="phones[]">
                                </div>
                                <div class="col-md-3">
                                    <button class="btn-default btn add_phone btn-outline blue" type="button"><i class="fa fa-plus"></i> Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-info" name="save_campaign_btn" value="Submit">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $ = jQuery.noConflict();
    $(document).ready(function () {
        $("#campaign_form").submit(function() {
            return validate('campaign_form');
        });
        $("body").on("click", ".add_phone", function () {
            var val = $("#add_phone").val();
            $("#phones_group").append('' +
            '<div class="col-md-7 col-md-offset-5 phone-form">' +
            '   <div class="row">' +
            '       <div class="col-md-9">' +
            '           <input type="text" name="phones[]" class="form-control" value="' + val + '">' +
            '       </div>' +
            '       <div class="col-md-3">' +
            '           <button type="button" class="btn btn-icon red btn-outline delete_phone"><i class="fa fa-trash"></i> </button>' +
            '       </div>' +
            '   </div>' +
            '   <br>   ' +
            '</div>' +
            '');
            $("#add_phone").val('');
        });
        $("body").on("click", ".delete_phone", function () {
            $(this).closest('.phone-form').remove();
        });
    });
</script>