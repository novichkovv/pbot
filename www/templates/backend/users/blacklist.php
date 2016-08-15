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
                            <a href="#blacklist_modal" class="btn green btn-outline" data-toggle="modal">
                                <i class="fa fa-plus"></i> Add To Blacklist
                            </a>
                        </div>
                    </div>
                </div>
                <div class="portlet-body custom-datatable">
                    <table class="table table-bordered" id="get_blacklist">
                        <thead>
                        <tr>
                            <td>
                                <select name="u.phone" data-sign="=" class="filter-field form-control filter-select user_search" placeholder="Search">
                                </select>
                            </td>
                            <td>
                                <select name="b.phone" data-sign="=" class="filter-field form-control filter-select number_search" placeholder="Search">
                                </select>
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
<div class="modal fade" id="blacklist_modal" role="dialog" aria-hidden="true">
    <div class="page-loading page-loading-boxed">
        <img src="<?php echo SITE_DIR; ?>assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
        <span> &nbsp;&nbsp;Chargement... </span>
    </div>
    <div class="modal-dialog">
        <div class="row">
            <div class="col-md-12">
                <form method="post" id="blacklist_form" class="form-horizontal">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption"><i class="fa fa-cogs"></i> Add to blacklist</div>
                            <div class="actions">
                                <button type="submit" class="btn btn-circle  btn-default btn-sm">
                                    <i class="fa fa-plus"></i> Add
                                </button>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="form-group">
                                <label class="control-label col-md-4">User Number</label>
                                <div class="col-md-6">
                                    <select name="user_number" class="form-control user_search">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Virtual Number(s)</label>
                                <div class="col-md-6">
                                    <select name="numbers" class="form-control user_search" multiple>
                                    </select>
<!--                                    <select class="form-control select2" name="" multiple>-->
<!--                                        --><?php //foreach ($numbers as $number): ?>
<!--                                            <option value="--><?php //echo $number['phone']; ?><!--">-->
<!--                                                --><?php //echo $number['phone']; ?>
<!--                                            </option>-->
<!--                                        --><?php //endforeach; ?>
<!--                                    </select>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
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
        ajax_select2('.user_search', 'search_user');
        ajax_select2('.number_search', 'search_number');
        $("body").on("submit", "#blacklist_form", function () {
            if(validate('blacklist_form')) {
                var params = {
                    'action': 'blacklist',
                    'get_from_form': 'blacklist_form',
                    'callback': function (msg) {
                        ajax_datatable('get_blacklist');
                        $("#blacklist_modal").modal('hide');
                    }
                };
                ajax(params);
            }
            return false;
        });
        ajax_datatable('get_blacklist');

        $(".select2").select2();
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