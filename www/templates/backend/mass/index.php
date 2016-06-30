<h3 class="page-title"> Mass SMS
    <small></small>
</h3>
<div class="row">
    <div class="col-md-6">
        <form action="" id="mass_form" method="post">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-list font-dark"></i>
                        <span class="caption-subject bold uppercase"> Send Mass SMS</span>
                    </div>
<!--                    <div class="actions">-->
<!--                        <div class="btn-group btn-group-devided">-->
<!--                            <button class="btn green btn-outline" name="download_btn" type="submit">-->
<!--                                <i class="fa fa-download"></i> Download XLS-->
<!--</button>-->
<!--                        </div>-->
<!--                    </div>-->
                </div>
                <div class="portlet-body">
                    <div class="form-group">
                        <label>From *</label>
                        <select style="width: 100%;" class="select2" name="sms[from]" data-require="1">
                            <?php if ($numbers): ?>
                                <?php foreach ($numbers as $number): ?>
                                    <option value="<?php echo $number['phone']; ?>"><?php echo $number['phone']; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <div class="validate-message error-require">Required Field</div>
                    </div>
                    <div class="form-group">
                        <label>To (divided by comma) *</label>
                        <textarea class="form-control" name="sms[to]" rows="6" data-require="1"></textarea>
                        <div class="validate-message error-require">Required Field</div>
                    </div>
                    <div class="form-group">
                        <label>Delay (in secs)</label>
                        <input type="text" class="form-control" name="sms[delay]" value="30">
                        <div class="validate-message error-require">Required Field</div>
                    </div>
                    <div class="form-group">
                        <label>Message *</label>
                        <textarea class="form-control" name="sms[sms]" rows="6" data-require="1"></textarea>
                        <div class="validate-message error-require">Required Field</div>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="send_sms_btn" class="btn btn-outline btn-lg blue">
                            <i class="fa fa-envelope"></i> Send
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="<?php echo SITE_DIR; ?>assets/global/plugins/select2/select2.min.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo SITE_DIR; ?>assets/global/plugins/select2/select2.css">
<script type="text/javascript">
    $ = jQuery.noConflict();
    $(document).ready(function () {
        $('.select2').select2();
        $("body").on("submit", "#mass_form", function () {
            if(validate('mass_form')) {
                var params = {
                    'action': 'send_mass',
                    'get_from_form': 'mass_form',
                    'callback': function (msg) {
                        ajax_respond(msg,
                            function (respond) { //success
                                toastr.success('Messages have been put in queue!')
                            },
                            function (respond) { //fail
                            }
                        );
                    }
                };
                ajax(params);
            }
            return false;
        });
    });
</script>