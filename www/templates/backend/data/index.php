<h3 class="page-title"> Data
    <small></small>
</h3>
<div class="row">
    <div class="col-md-12">
        <form id="filter-form" action="" method="post">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-list font-dark"></i>
                        <span class="caption-subject bold uppercase"> Uploaded Data Table</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided">
                            <button class="btn green btn-outline" type="submit" name="download">
                                <i class="fa fa-download"></i> Download CSV
                            </button>
                        </div>
                    </div>
                </div>
                <div class="portlet-body custom-datatable">
                    <table class="table table-bordered filtered-table" id="get_prices">
                        <thead>
                        <tr>
                            <th><input type="text" class="filter-field form-control" data-sign="=" name="production_year" placeholder="Filter"></th>
                            <th><input type="text" class="filter-field form-control" data-sign="=" name="brand" placeholder="Filter"></th>
                            <th><input type="text" class="filter-field form-control" data-sign="=" name="model" placeholder="Filter"></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>
                                <select name="upload_date" class="filter-field filter-select form-control" data-sign="=">
                                    <option value="">Any</option>
                                    <?php if ($dates): ?>
                                        <?php foreach ($dates as $date): ?>
                                            <option value="<?php echo $date['upload_date']; ?>">
                                                <?php echo $date['upload_date']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </th>
                        </tr>
                        <tr>
                            <th>Year</th>
                            <th>Make</th>
                            <th>Model</th>
                            <th>MSRP</th>
                            <th>Sale Price</th>
                            <th>Savings off MSRP</th>
                            <th>% Savings</th>
                            <th>Upload Date</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $ = jQuery.noConflict();
    $(document).ready(function () {
        ajax_datatable('get_prices', 25);
        $("#filter-form").keydown(function(e) {
            if(e.keyCode == 13) {
                e.preventDefault();
                $(e.target).change();
            }
        });

        $("#filter-form").submit(function() {
            var $form = $(this);
            var $table = $(this).find('.filtered-table');
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