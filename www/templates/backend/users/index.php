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
                        <span class="caption-subject bold uppercase"> Users List</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided">
                            <button class="btn green btn-outline" name="download_btn" type="submit">
                                <i class="fa fa-download"></i> Download XLS
                            </button>
                        </div>
                    </div>
                </div>
                <div class="portlet-body custom-datatable">
                    <table class="table table-bordered" id="users_table">
                        <thead>
                        <tr>
                            <td>
                                <input type="text" data-id="users_table" name="u.phone" data-sign="=" class="filter-field form-control" placeholder="Search">
                            </td>
                            <td colspan="2">
                                <div class="row date-range">
                                    <div class="col-md-6">
                                        <input type="text" data-id="users_table" class="filter-range range-input-1 form-control" value="" placeholder="Date From">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" data-id="users_table" class="filter-range range-input-2 form-control" value="" placeholder="Date To">
                                    </div>
                                    <input type="hidden" data-id="users_table" name="u.create_date" data-sign="between" class="filter-field range-hidden-input">
                                </div>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>User Name</th>
                            <th>Date</th>
                            <th>SMS sent</th>
                            <th>Last Sms Date</th>
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
<div class="modal fade" id="blacklist_modal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Blacklist</h4>
            </div>
            <div class="modal-body with-padding">
                Are You Sure?
            </div>
            <div class="modal-footer">
                <button type="button" class="blacklist_btn btn btn-primary">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $ = jQuery.noConflict();
    $(document).ready(function () {
        ajax_datatable('users_table');
        var $filter_form = $("#filter-form");
        $filter_form.keydown(function(e) {
            if(e.keyCode == 13) {
                e.preventDefault();
                $(e.target).change();
            }
        });
        $("body").on("click", ".whitelist", function () {
            var id = $(this).attr('data-id');
            $(".whitelist_btn").attr('data-id', id);
        });
        $("body").on("click", ".blacklist", function () {
            var id = $(this).attr('data-id');
            $(".blacklist_btn").attr('data-id', id);
        });

        $("body").on("click", ".whitelist_btn", function () {
            var id = $(this).attr('data-id');
            var params = {
                'action': 'whitelist',
                'values': {id: id},
                'callback': function (msg) {
                    ajax_datatable('users_table');
                    $("#whitelist_modal").modal('hide');
                }
            };
            ajax(params);

        });
        $("body").on("click", ".blacklist_btn", function () {
            var id = $(this).attr('data-id');
            var params = {
                'action': 'blacklist',
                'values': {id: id},
                'callback': function (msg) {
                    ajax_datatable('users_table');
                    $("#blacklist_modal").modal('hide');
                }
            };
            ajax(params);
        });

        $filter_form.submit(function() {
            var $form = $(this);
            var $table = $('#users_table');
            var id = $table.attr('id');
            $("#" + id + ' .filter-field, .filter-field[data-id="' + id + '"]').each(function(){
                if($(this).val()) {
                    $("#" + $(this).attr('name') + "_sign").remove();
                    $("#" + $(this).attr('name') + "_value").remove();
                    $form.append('<input type="hidden" id="' + $(this).attr('name') + '_sign" name="params[' + $(this).attr('name') + '][sign]" value="' + $(this).attr('data-sign') + '">');
                    $form.append('<input type="hidden" id="' + $(this).attr('name') + '_value" name="params[' + $(this).attr('name') + '][value]" value="' + $(this).val() + '">');
                }
            });
        });
    });
</script>