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
                            <a class="btn red btn-outline btn-circle delete_phrases" href="#delete_modal" data-toggle="modal">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 32px;"></th>
                            <th style="width: 150px;">Status</th>
                            <th style="width: 70px;">Order</th>
                            <th style="width: 70px;">Delay</th>
                            <th style="width: 310px;">Mask</th>
                            <th>Reply</th>
                            <th style="width: 158px;">Action</th>
                        </tr>
                        </thead>
                        <tbody id="table_body">
                        <?php require_once(TEMPLATE_DIR . 'index' . DS . 'ajax' . DS . 'phrase_form.php'); ?>
                        <?php if ($phrases): ?>
                            <?php foreach ($phrases as $phrase): ?>
                                <?php require(TEMPLATE_DIR . 'index' . DS . 'ajax' . DS . 'phrase.php'); ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="delete_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Delete Phrase</h4>
                </div>
                <div class="modal-body with-padding">
                    Are You Sure?
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="phrases_to_delete" value="">
                    <button type="submit" class="btn btn-primary" name="delete_phrase_btn">Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $ = jQuery.noConflict();
    $(document).ready(function () {
        $("#add_phrase").click(function() {
            $(".phrase_form").hide();
            $('tr').show();
            $("#add_form").show();
        });
        $("body").on("click", ".cancel", function () {
            var $tr = $(this).closest(".phrase_form");
            $tr.hide();
            if($tr.attr('data-tr')) {
                $("tr[data-id='" + $tr.attr('data-tr') + "']").show();
                $tr.remove();
            }
        });
        $("body").on("click", ".delete_phrase", function () {

        });

        $("body").on("click", ".save_phrase_btn", function () {
            var form = $(this).closest('.phrase_form');
            var data = get_from_form('.phrase_form');
            var params = {
                'action': 'save_phrase',
                'values': data,
                'callback': function (msg) {
                    ajax_respond(msg,
                        function (respond) { //success
                            if(respond.edited) {
                                var $tr = $("[data-id='" + respond.edited + "']");
                                $tr.after(respond.template);
                                $tr.remove();
                                $("tr[data-tr='" + respond.edited + "']").remove();
                            } else {
                                $("#table_body").append(respond.template);
                            }
                            $(".phrase_form").hide();
                            Metronic.init();
                        },
                        function (respond) { //fail
                        }
                    );
                }
            };
            ajax(params);
        });

        $("body").on("click", ".clone_phrase", function () {
            var id = $(this).closest('tr').attr('data-id');
            var params = {
                'action': 'clone_phrase',
                'values': {id: id},
                'callback': function (msg) {
                    ajax_respond(msg,
                        function (respond) { //success
                            $("#table_body").append(respond.template);
                            $(".phrase_form").hide();
                            Metronic.init();
                        },
                        function (respond) { //fail
                        }
                    );
                }
            };
            ajax(params);
        });

        $("body").on("click", ".edit_phrase", function () {
            $(".phrase_form").hide();
            var id = $(this).closest('tr').attr('data-id');
            var params = {
                'action': 'edit_phrase',
                'values': {id: id},
                'callback': function (msg) {
                    ajax_respond(msg,
                        function (respond) { //success
                            $("#phrase_form").hide();
                            var $tr = $("tr[data-id='" + id + "']");
                            $tr.after(respond.template);
                            $tr.hide();
                            //Metronic.init();
                        },
                        function (respond) { //fail
                        }
                    );
                }
            };
            ajax(params);
        });

        $(".delete_phrases").click(function() {
            var values = [];
            $(".phrase_check").each(function() {
                if($(this).prop('checked')) {
                    values.push($(this).val());
                }
            });
            $('[name="phrases_to_delete"]').val(values.join(','));
        });

        $(".delete_phrase").click(function() {
            var values = [];
            values[0] = $(this).closest('tr').attr('data-id');
            $('[name="phrases_to_delete"]').val(values);
        });
    });
</script>