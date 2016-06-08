<h3 class="page-title"> Edit Phrases
    <small></small>
</h3>
<div class="row">
    <div class="col-md-12">
        <form id="filter-form" action="" method="post">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-list font-dark"></i>
                        <span class="caption-subject bold uppercase"> Phrases Table</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided">
                            <button class="btn green btn-outline btn-circle" type="button" id="add_phrase">
                                <i class="fa fa-plus"></i>
                            </button>
                            <button class="btn red btn-outline btn-circle" type="submit" name="download">
                                <i class="fa fa-trash-o"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="max-width: 32px;"><input type="checkbox"></th>
                            <th style="width: 120px;">Status</th>
                            <th style="width: 70px;">Order</th>
                            <th style="width: 70px;">Delay</th>
                            <th>Mask</th>
                            <th>Reply</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="phrase_form" id="add_form" style="display: none;">
                            <th></th>
                            <td>
                                <select class="form-control" name="phrase[phrase_status]">
                                    <?php if ($statuses): ?>
                                        <?php foreach ($statuses as $status): ?>
                                            <option value="<?php echo $status['id']; ?>">
                                                <?php echo $status['status_name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="phrase[sort_order]" class="form-control">
                            </td>
                            <td>
                                <input type="text" name="phrase[delay]" class="form-control">
                            </td>
                            <td>
                                <textarea class="form-control" name="phrase[mask]"></textarea>
                            </td>
                            <td>
                                <textarea class="form-control" name="phrase[reply]"></textarea>
                            </td>
                            <td>
                                <button type="button" class="btn btn-info">Save</button>
                                <button type="button" class="btn btn-warning cancel">Cancel</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $ = jQuery.noConflict();
    $(document).ready(function () {
        $("#add_phrase").click(function() {
            $("#add_form").show();
        });
        $("body").on("click", ".cancel", function () {
            $(this).closest(".phrase_form").hide();
        });
    });
</script>