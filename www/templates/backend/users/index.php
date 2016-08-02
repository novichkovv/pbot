<script type="text/javascript" src="<?php echo SITE_DIR; ?>js/flot.js"></script>
<script type="text/javascript" src="<?php echo SITE_DIR; ?>js/flot.time.js"></script>
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
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="fa fa-graph font-dark"></i>
                    <span class="caption-subject bold uppercase"> Daily Average Messages By User</span>
                </div>
                <div class="actions">
<!--                    <div class="btn-group btn-group-devided">-->
<!--                        <button class="btn green btn-outline" name="download_btn" type="submit">-->
<!--                            <i class="fa fa-download"></i> Download XLS-->
<!--                        </button>-->
<!--                    </div>-->
                </div>
            </div>
            <div class="portlet-body">
                <div class="demo-container">
                    <div id="placeholder" class="demo-placeholder" style="height: 300px;">

                    </div>
                </div>
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

        $(function() {
//            var arr = {"2016, 07,18":"23","2016, 07,19":"37","2016, 07,20":"13","2016, 07,21":"24","2016, 07,22":"20","2016, 07,23":"5","2016, 07,24":"8","2016, 07,25":"13","2016, 07,26":"17","2016, 07,27":"20","2016, 07,28":"18","2016, 07,29":"5","2016, 07,30":"19","2016, 07,31":"12","2016, 08,01":"21","2016, 08,02":"6"};
            var arr = <?php echo $graph; ?>;
            var n = 0;
            var d2 = [];
            for(var i in arr)
            {
                d2.push([new Date(i).getTime(), arr[i]]);
                if(n == 0)var date_start = new Date(i).getTime();
                n ++;
            }
            var date_end = new Date(i).getTime();

//            var arr2 = <?php //echo $unsigned; ?>//;
//            var d1 = [];
//            for(var i in arr)
//            {
//                d1.push([new Date(i).getTime(), arr2[i] ? arr2[i] : 0]);
//            }

            // A null signifies separate line segments



            $.plot("#placeholder", [{  data: d2, label: 'AVG SMS per User'} ]  ,{
                    xaxis: {
                        min: date_start,
                        max: date_end,
                        mode: "time",
                        tickSize: [1,"day"],
                        monthNames: [ "jan", "feb","mar","apr","may","jun","jul","aug","sen","oct","nov","dec"],
                        tickLength: 0,
                        axisLabel: 'Day',
                        axisLabelUseCanvas: true,
                        axisLabelFontSizePixels: 11,
                        axisLabelPadding: 5
                    },
                    colors: [ "#6db6ee",
                        "red",
                        "#993eb7",
                        "#3ba3aa"],
                    series: {
                        lines: {
                            show: true,
                            fill: true,
                            fillColor: { colors: [ { opacity: 0.2 }, { opacity: 0.2 } ] },
                            lineWidth: 1.5 },
                        points: {
                            show: true,
                            radius: 2.5,
                            fill: true,
                            fillColor: "#ffffff",
                            symbol: "circle",
                            lineWidth: 1.1 }
                    },
                    grid: { hoverable: true, clickable: true },
                    legend: {
                        show: true
                    }
                }
            );
            function showTooltip(x, y, contents, areAbsoluteXY) {
                var rootElt = 'body';

                $('<div id="tooltip" class="chart-tooltip">' + contents + '</div>').css( {
                    top: y - 50,
                    left: x - 9,
                    opacity: 0.9,
                    position: 'absolute',
                    'background-color':"#eee",
                    padding: "10px 3px"
                }).prependTo(rootElt).show();
            };

            var previousPoint = null;
            $("#placeholder").bind("plothover", function (event, pos, item) {
                $("#x").text(pos.x.toFixed(2));
                $("#y").text(pos.y.toFixed(2));

                if ($("#placeholder").length > 0) {
                    if (item) {
                        if (previousPoint != item.dataIndex) {
                            previousPoint = item.dataIndex;

                            $("#tooltip").remove();
                            var x = item.datapoint[0].toFixed(2),
                                y = item.datapoint[1].toFixed(2);
                            var date = new Date(parseInt(x));
                            var day = date.getDate();
                            var month = [];
                            month[0] = "January";
                            month[1] = "February";
                            month[2] = "March";
                            month[3] = "April";
                            month[4] = "May";
                            month[5] = "June";
                            month[6] = "July";
                            month[7] = "August";
                            month[8] = "September";
                            month[9] = "October";
                            month[10] = "November";
                            month[11] = "December";
                            var m = month[date.getMonth()];
                            showTooltip(item.pageX, item.pageY,
                                item.series.label + " on " + (parseInt(day)<10 ? '0' + day : day) + ', ' + m + ": <b>" + y + "</b>", false);
                        }
                    }
                    else {
                        $("#tooltip").remove();
                        previousPoint = null;
                    }
                }
            });
            // Add the Flot version string to the footer

            //$("#footer").prepend("Flot " + $.plot.version + " &ndash; ");
        })
    });
</script>