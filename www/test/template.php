<!DOCTYPE html>
<html>
<head>
    <title>
        Excel Parser
    </title>
    <link type="text/css" rel="stylesheet" href="<?php echo SITE_DIR; ?>css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel panel-heading">
                    <h3 class="panel-title">Upload an Excel File</h3>
                </div>

                <div class="panel-body">
                    <form action="<?php echo SITE_DIR; ?>" class="dropzone" id="source">
                    </form>
                    <!--                        <div class="form-group">-->
                    <!--                            <!--                        <label>Upload an Excel file</label>-->-->
                    <!--                            <input type="file" name="file">-->
                    <!--                        </div>-->
                    <!--                        <div class="form-group">-->
                    <!--                            <input type="submit" class="btn btn-default" name="submit">-->
                    <!--                        </div>-->
                </div>
            </div>
        </div>
        <form enctype="multipart/form-data" action="" method="post">
            <br>

        </form>
    </div>
</div>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/dropzone.min.js"></script>
<script type="text/javascript">
    $ = jQuery.noConflict();
    $(document).ready(function () {
        Dropzone.options['source'] = {
            uploadMultiple: false,
            addRemoveLinks: false
        };

    });
</script>
</body>
</html>