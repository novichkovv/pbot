<h3 class="page-title"> System Users
    <small></small>
</h3>
<div class="row">
    <div class="col-md-12">
        <form id="filter-form" action="" method="post">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-list font-dark"></i>
                        <span class="caption-subject bold uppercase"> System Users List</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided">
                            <a href="<?php echo SITE_DIR; ?>system_users/add/" class="btn green btn-outline">
                                <i class="fa fa-plus"></i> Add user
                            </a>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>User Name</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($users): ?>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td>
                                        <?php echo $user['user_name']; ?>
                                    </td>
                                    <td>
                                        <?php echo date('Y-m-d', strtotime($user['create_date'])); ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo SITE_DIR; ?>system_users/add/?id=<?php echo $user['id']; ?>" class="btn btn-default btn-icon">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="#delete_user_modal" class="btn btn-default btn-icon text-warning delete_user" data-toggle="modal" data-id="<?php echo $user['id']; ?>">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="delete_user_modal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Delete user</h4>
            </div>
            <div class="modal-body with-padding">
                Are you sure you want to delete this user?
            </div>
            <div class="modal-footer">
                <form method="post" action="">
                    <input type="hidden" name="user_id" value="">
                    <button type="submit" name="delete_user_btn" class="btn btn-primary">Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $ = jQuery.noConflict();
    $(document).ready(function () {
        $("body").on("click", ".delete_user", function () {
            var user_id = $(this).attr('data-id');
            $('[name="user_id"]').val(user_id);
        });
    });
</script>

