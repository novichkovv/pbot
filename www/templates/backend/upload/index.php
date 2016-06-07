<h3 class="page-title"> Upload Excel
    <small></small>
</h3>
<div class="row">
    <div class="col-md-6">
        <!-- BEGIN Portlet PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-green-sharp">
                    <i class="icon-cloud-upload font-green-sharp"></i>
                    <span class="caption-subject bold uppercase"> Upload</span>
                </div>
                <div class="actions">
                    <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title=""> </a>
                </div>
            </div>
            <div class="portlet-body">
                <form id="upload_form" enctype="multipart/form-data" method="post" action="" class="form-horizontal">
                    <div class="form-group">
                        <label for="file_input" class="col-md-3 control-label" id="file_input">File input</label>
                        <div class="col-md-9">
                            <input type="file" name="file" data-require="1">
                            <div class="error-require validate-message">
                                Browse an Excel file
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="date_input" class="col-md-3 control-label">Date input</label>
                        <div class="col-md-9">
                            <input name="date" data-require="1" type="text" class="datepicker form-control" id="date_input" value="<?php echo date('Y-m-d'); ?>">
                            <div class="error-require validate-message">
                                Select a date
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="validate-message" style="display: block">
                                <?php echo $error; ?>
                            </div>
                            <button type="submit" name="submit" class="btn btn-info">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- END Portlet PORTLET-->
    </div>
</div>
<script type="text/javascript">
    $ = jQuery.noConflict();
    $(document).ready(function () {
        $("#upload_form").submit(function() {
            return validate('upload_form');
        })
    });
</script>