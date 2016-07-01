<h3 class="page-title"> Blacklist
    <small></small>
</h3>
<div class="row">
    <div class="col-md-6">
        <form id="filter-form" action="" method="post">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-list font-dark"></i>
                        <span class="caption-subject bold uppercase"> Users List</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided">
<!--                            <button class="btn green btn-outline" name="download_btn" type="submit">-->
<!--                                <i class="fa fa-download"></i> Download XLS-->
<!--                            </button>-->
                        </div>
                    </div>
                </div>
                <div class="portlet-body custom-datatable">
                    <table class="table table-bordered" id="get_blacklist">
                        <thead>
                        <tr>
                            <td>
                                <input type="text" name="u.phone" data-sign="=" class="filter-field form-control" placeholder="Search">
                            </td>
                            <td>
                                <input type="text" name="b.phone" data-sign="=" class="filter-field form-control" placeholder="Search">
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>User Number</th>
                            <th>Bot Number</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="whitelist_modal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Whitelist</h4>
            </div>
            <div class="modal-body with-padding">
                Are You Sure?
            </div>
            <div class="modal-footer">
                <button type="button" class="whitelist_btn btn btn-primary">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $ = jQuery.noConflict();
    $(document).ready(function () {
        ajax_datatable('get_blacklist');

        $("body").on("click", ".whitelist", function () {
            var id = $(this).attr('data-id');
            $(".whitelist_btn").attr('data-id', id);
        });

        $("body").on("click", ".whitelist_btn", function () {
            var id = $(this).attr('data-id');
            var params = {
                'action': 'whitelist',
                'values': {id: id},
                'callback': function (msg) {
                    ajax_datatable('get_blacklist');
                    $("#whitelist_modal").modal('hide');
                }
            };
            ajax(params);

        });
    });
</script>