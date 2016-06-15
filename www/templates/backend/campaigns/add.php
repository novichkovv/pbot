<h3 class="page-title"> <?php echo isset($_GET['id']) ? 'Edit' : 'Create'; ?> Campaign
    <small></small>
</h3>
<div class="row">
    <div class="col-md-4">
        <form id="campaign_form" action="" method="post">
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
                        <label>Campaign Name *</label>
                        <input type="text" name="campaign_name" autocomplete="off" class="form-control"  data-require="1" value="<?php echo $campaign['campaign_name']; ?>">

                        <div class="error-require validate-message">
                            Required Field
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Campaign Virtual Number *</label>
                        <input type="text" name="phone" autocomplete="off" class="form-control"  data-require="1" value="<?php echo $campaign['phone']; ?>">

                        <div class="error-require validate-message">
                            Required Field
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
        })
    });
</script>