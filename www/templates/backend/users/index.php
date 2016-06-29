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
                            <td>
                                <select class="form-control filter-field filter-select" data-sign="=" name="u.blocked">
                                    <option value=""></option>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>User Name</th>
                            <th>Date</th>
                            <th>SMS sent</th>
                            <th>Blocked</th>
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
<script type="text/javascript">
    $ = jQuery.noConflict();
    $(document).ready(function () {
        ajax_datatable('users_table');
        var $filter_form = $("#filter-form");
        $filter_form.keydown(function(e) {
            console.log(e);
            if(e.keyCode == 13) {
                e.preventDefault();
                $(e.target).change();
            }
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