<h3 class="page-title"> Campaigns
    <small></small>
</h3>
<div class="row">
    <div class="col-md-12">
        <form id="filter-form" action="" method="post">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-docs font-dark"></i>
                        <span class="caption-subject bold uppercase"> Your Campaigns List</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided">
                            <a href="<?php echo SITE_DIR; ?>campaigns/add/" class="btn green btn-outline">
                                <i class="fa fa-plus"></i> Add campaign
                            </a>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Campaign Name</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($campaigns): ?>
                            <?php foreach ($campaigns as $campaign): ?>
                                <tr>
                                    <td>
                                        <?php echo $campaign['campaign_name']; ?>
                                    </td>
                                    <td>
                                        <?php echo date('Y-m-d', strtotime($campaign['create_date'])); ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo SITE_DIR; ?>campaigns/add/?id=<?php echo $campaign['id']; ?>" class="btn btn-default btn-icon">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="#delete_campaign_modal" class="btn btn-default btn-icon text-warning delete_campaign" data-toggle="modal" data-id="<?php echo $campaign['id']; ?>">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <a href="<?php echo SITE_DIR; ?>?campaign_id=<?php echo $campaign['id']; ?>" class="btn btn-default btn-icon">
                                            <i class="fa fa-gear"></i>
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
<div class="modal fade" id="delete_campaign_modal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Delete campaign</h4>
            </div>
            <div class="modal-body with-padding">
                Are you sure you want to delete this campaign?
            </div>
            <div class="modal-footer">
                <form method="post" action="">
                    <input type="hidden" name="campaign_id" value="">
                    <button type="submit" name="delete_campaign_btn" class="btn btn-primary">Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $ = jQuery.noConflict();
    $(document).ready(function () {
        $("body").on("click", ".delete_campaign", function () {
            var campaign_id = $(this).attr('data-id');
            $('[name="campaign_id"]').val(campaign_id);
        });
    });
</script>

