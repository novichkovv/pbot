<h3 class="page-title"> <?php echo isset($_GET['id']) ? 'Edit' : 'Create'; ?> User
    <small></small>
</h3>
<div class="row">
    <div class="col-md-4">
        <form id="user_form" action="" method="post">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-list font-dark"></i>
                        <span class="caption-subject bold uppercase"> User Form</span>
                    </div>
                    <div class="actions">

                    </div>
                </div>
                <div class="portlet-body">
                    <div class="form-group">
                        <label>User Name (login) *</label>
                        <input type="text" name="user_name" autocomplete="off" class="form-control"  data-require="1" value="<?php echo $user['user_name']; ?>">

                        <div class="error-require validate-message">
                            Required Field
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Password *</label>
                        <input type="password" name="user_password" autocomplete="off" class="form-control" value="<?php echo $password; ?>"
                            <?php if (!$_GET['id']): ?>
                                data-require="1"
                            <?php else: ?>
                                placeholder="Leave Empty if don't change"
                            <?php endif; ?>>
                        <div class="error-require validate-message">
                            Required Field
                        </div>
                        <div class="validate-message" style="display: block;">
                            <?php echo $user_name_error; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-info" name="save_user_btn" value="Submit">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $ = jQuery.noConflict();
    $(document).ready(function () {
        $("#user_form").submit(function() {
            return validate('user_form');
        })
    });
</script>