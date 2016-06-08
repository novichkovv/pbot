<h3 class="page-title"> Users
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
                                        <a href="#delete_user_modal" class="btn btn-default btn-icon text-warning" data-toggle="modal" data-id="<?php echo $user['id']; ?>">
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


