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
<div class="row">
    <div class="col-md-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="fa fa-graph font-dark"></i>
                    <span class="caption-subject bold uppercase">Inbound Messages By Campaign </span>
                </div>
                <div class="actions">
                </div>
            </div>
            <div class="portlet-body">
                <div class="demo-container">
                    <div id="messages_by_campaign" class="demo-placeholder" style="height: 300px;">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="fa fa-graph font-dark"></i>
                    <span class="caption-subject bold uppercase">Outbound Messages By Campaign </span>
                </div>
                <div class="actions">
                </div>
            </div>
            <div class="portlet-body">
                <div class="demo-container">
                    <div id="queues_by_campaign" class="demo-placeholder" style="height: 300px;">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="fa fa-graph font-dark"></i>
                    <span class="caption-subject bold uppercase">Outbound Messages By Campaign </span>
                </div>
                <div class="actions">
                </div>
            </div>
            <div class="portlet-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Campaign Name</th>
                        <th>Number</th>
                        <th>Link To Dialogue</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($user_switches as $switch): ?>
                        <tr>
                            <td><?php echo $switch['campaign_id']; ?></td>
                            <td><?php echo $switch['recipient']; ?></td>
                            <td><a href="<?php echo SITE_DIR; ?>emulator/?campaign=<?php echo $switch['campaign_id']; ?>&user_id=<?php echo $switch['user_id']; ?>&number_id=<?php echo $switch['recipient']; ?>"><i class="fa fa-envelope"></i> </a></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
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
            var arr = <?php echo $graph[0]; ?>;
            var n = 0;
            var d2 = [];
            for(var i in arr)
            {
                d2.push([new Date(i).getTime(), arr[i]]);
                if(n == 0)var date_start = new Date(i).getTime();
                n ++;
            }
            var date_end = new Date(i).getTime();

            var arr2 = <?php echo $graph[1]; ?>;
            var d1 = [];
            for(var i in arr)
            {
                d1.push([new Date(i).getTime(), arr2[i] ? arr2[i] : 0]);
            }

            // A null signifies separate line segments



            $.plot("#placeholder", [{  data: d2, label: 'AVG SMS per User'}, {  data: d1, label: 'AVG Reply per User'} ]  ,{
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
        });

        $(function () {
            var data = [];
            <?php foreach($messages_by_campaign as $k => $campaign): ?>
                data[<?php echo $k; ?>] = { label: "<?php echo $campaign['campaign_name']; ?>", data: <?php echo $campaign['count']; ?> }
            <?php endforeach; ?>
            $.plot($("#messages_by_campaign"), data,
                {
                    series: {
                        pie: {
                            show: true,
                            radius: 1,
                            label: {
                                show: true,
                                radius: 2/3,
                                formatter: function(label, series){
                                    return '<div style="font-size:8pt;text-align:center;padding:2px;color:white;">'+label+'<br/>'+Math.round(series.data[0][1])+'<br>(' + Math.round(series.percent) + '%)</div>';
                                },
                                threshold: 0.1
                            }
                        }
                    },
                    legend: {
                        show: true
                    },
                    colors: ["#ee7951", "#6db6ee", "#95c832", "#993eb7", "#3ba3aa"],
                    grid: {
                        hoverable: true,
                        clickable: true
                    }
                });

            $("#messages_by_campaign").bind("plotclick", function(e, pos, item) {
                showTooltip(pos.pageX, pos.pageY, item.datapoint[1][0][1] + '<br>(' + Math.round(item.datapoint[0]) + ')%');
            });



        });

        $(function () {
            var data = [];
            <?php foreach($queues_by_campaign as $k => $campaign): ?>
            data[<?php echo $k; ?>] = { label: "<?php echo $campaign['campaign_name']; ?>", data: <?php echo $campaign['count']; ?> }
            <?php endforeach; ?>
            $.plot($("#queues_by_campaign"), data,
                {
                    series: {
                        pie: {
                            show: true,
                            radius: 1,
                            label: {
                                show: true,
                                radius: 2/3,
                                formatter: function(label, series){
                                    console.log(series);
                                    return '<div style="font-size:8pt;text-align:center;padding:2px;color:white;">'+label+'<br/>'+Math.round(series.data[0][1])+'<br>(' + Math.round(series.percent) + '%)</div>';
                                },
//                                threshold: 0.1
                            }
                        }
                    },
                    legend: {
                        show: true
                    },
                    colors: ["#ee7951", "#6db6ee", "#95c832", "#993eb7", "#3ba3aa"],
                    grid: {
                        hoverable: true,
                        clickable: true
                    }
                });

            $("#queues_by_campaign").bind("plotclick", function(e, pos, item) {
                showTooltip(pos.pageX, pos.pageY, item.datapoint[1][0][1] + '<br>(' + Math.round(item.datapoint[0]) + ')%');
            });
        })
    });
    (function($){var REDRAW_ATTEMPTS=10;var REDRAW_SHRINK=.95;function init(plot){var canvas=null,target=null,options=null,maxRadius=null,centerLeft=null,centerTop=null,processed=false,ctx=null;var highlights=[];plot.hooks.processOptions.push(function(plot,options){if(options.series.pie.show){options.grid.show=false;if(options.series.pie.label.show=="auto"){if(options.legend.show){options.series.pie.label.show=false}else{options.series.pie.label.show=true}}if(options.series.pie.radius=="auto"){if(options.series.pie.label.show){options.series.pie.radius=3/4}else{options.series.pie.radius=1}}if(options.series.pie.tilt>1){options.series.pie.tilt=1}else if(options.series.pie.tilt<0){options.series.pie.tilt=0}}});plot.hooks.bindEvents.push(function(plot,eventHolder){var options=plot.getOptions();if(options.series.pie.show){if(options.grid.hoverable){eventHolder.unbind("mousemove").mousemove(onMouseMove)}if(options.grid.clickable){eventHolder.unbind("click").click(onClick)}}});plot.hooks.processDatapoints.push(function(plot,series,data,datapoints){var options=plot.getOptions();if(options.series.pie.show){processDatapoints(plot,series,data,datapoints)}});plot.hooks.drawOverlay.push(function(plot,octx){var options=plot.getOptions();if(options.series.pie.show){drawOverlay(plot,octx)}});plot.hooks.draw.push(function(plot,newCtx){var options=plot.getOptions();if(options.series.pie.show){draw(plot,newCtx)}});function processDatapoints(plot,series,datapoints){if(!processed){processed=true;canvas=plot.getCanvas();target=$(canvas).parent();options=plot.getOptions();plot.setData(combine(plot.getData()))}}function combine(data){var total=0,combined=0,numCombined=0,color=options.series.pie.combine.color,newdata=[];for(var i=0;i<data.length;++i){var value=data[i].data;if($.isArray(value)&&value.length==1){value=value[0]}if($.isArray(value)){if(!isNaN(parseFloat(value[1]))&&isFinite(value[1])){value[1]=+value[1]}else{value[1]=0}}else if(!isNaN(parseFloat(value))&&isFinite(value)){value=[1,+value]}else{value=[1,0]}data[i].data=[value]}for(var i=0;i<data.length;++i){total+=data[i].data[0][1]}for(var i=0;i<data.length;++i){var value=data[i].data[0][1];if(value/total<=options.series.pie.combine.threshold){combined+=value;numCombined++;if(!color){color=data[i].color}}}for(var i=0;i<data.length;++i){var value=data[i].data[0][1];if(numCombined<2||value/total>options.series.pie.combine.threshold){newdata.push({data:[[1,value]],color:data[i].color,label:data[i].label,angle:value*Math.PI*2/total,percent:value/(total/100)})}}if(numCombined>1){newdata.push({data:[[1,combined]],color:color,label:options.series.pie.combine.label,angle:combined*Math.PI*2/total,percent:combined/(total/100)})}return newdata}function draw(plot,newCtx){if(!target){return}var canvasWidth=plot.getPlaceholder().width(),canvasHeight=plot.getPlaceholder().height(),legendWidth=target.children().filter(".legend").children().width()||0;ctx=newCtx;processed=false;maxRadius=Math.min(canvasWidth,canvasHeight/options.series.pie.tilt)/2;centerTop=canvasHeight/2+options.series.pie.offset.top;centerLeft=canvasWidth/2;if(options.series.pie.offset.left=="auto"){if(options.legend.position.match("w")){centerLeft+=legendWidth/2}else{centerLeft-=legendWidth/2}if(centerLeft<maxRadius){centerLeft=maxRadius}else if(centerLeft>canvasWidth-maxRadius){centerLeft=canvasWidth-maxRadius}}else{centerLeft+=options.series.pie.offset.left}var slices=plot.getData(),attempts=0;do{if(attempts>0){maxRadius*=REDRAW_SHRINK}attempts+=1;clear();if(options.series.pie.tilt<=.8){drawShadow()}}while(!drawPie()&&attempts<REDRAW_ATTEMPTS);if(attempts>=REDRAW_ATTEMPTS){clear();target.prepend("<div class='error'>Could not draw pie with labels contained inside canvas</div>")}if(plot.setSeries&&plot.insertLegend){plot.setSeries(slices);plot.insertLegend()}function clear(){ctx.clearRect(0,0,canvasWidth,canvasHeight);target.children().filter(".pieLabel, .pieLabelBackground").remove()}function drawShadow(){var shadowLeft=options.series.pie.shadow.left;var shadowTop=options.series.pie.shadow.top;var edge=10;var alpha=options.series.pie.shadow.alpha;var radius=options.series.pie.radius>1?options.series.pie.radius:maxRadius*options.series.pie.radius;if(radius>=canvasWidth/2-shadowLeft||radius*options.series.pie.tilt>=canvasHeight/2-shadowTop||radius<=edge){return}ctx.save();ctx.translate(shadowLeft,shadowTop);ctx.globalAlpha=alpha;ctx.fillStyle="#000";ctx.translate(centerLeft,centerTop);ctx.scale(1,options.series.pie.tilt);for(var i=1;i<=edge;i++){ctx.beginPath();ctx.arc(0,0,radius,0,Math.PI*2,false);ctx.fill();radius-=i}ctx.restore()}function drawPie(){var startAngle=Math.PI*options.series.pie.startAngle;var radius=options.series.pie.radius>1?options.series.pie.radius:maxRadius*options.series.pie.radius;ctx.save();ctx.translate(centerLeft,centerTop);ctx.scale(1,options.series.pie.tilt);ctx.save();var currentAngle=startAngle;for(var i=0;i<slices.length;++i){slices[i].startAngle=currentAngle;drawSlice(slices[i].angle,slices[i].color,true)}ctx.restore();if(options.series.pie.stroke.width>0){ctx.save();ctx.lineWidth=options.series.pie.stroke.width;currentAngle=startAngle;for(var i=0;i<slices.length;++i){drawSlice(slices[i].angle,options.series.pie.stroke.color,false)}ctx.restore()}drawDonutHole(ctx);ctx.restore();if(options.series.pie.label.show){return drawLabels()}else return true;function drawSlice(angle,color,fill){if(angle<=0||isNaN(angle)){return}if(fill){ctx.fillStyle=color}else{ctx.strokeStyle=color;ctx.lineJoin="round"}ctx.beginPath();if(Math.abs(angle-Math.PI*2)>1e-9){ctx.moveTo(0,0)}ctx.arc(0,0,radius,currentAngle,currentAngle+angle/2,false);ctx.arc(0,0,radius,currentAngle+angle/2,currentAngle+angle,false);ctx.closePath();currentAngle+=angle;if(fill){ctx.fill()}else{ctx.stroke()}}function drawLabels(){var currentAngle=startAngle;var radius=options.series.pie.label.radius>1?options.series.pie.label.radius:maxRadius*options.series.pie.label.radius;for(var i=0;i<slices.length;++i){if(slices[i].percent>=options.series.pie.label.threshold*100){if(!drawLabel(slices[i],currentAngle,i)){return false}}currentAngle+=slices[i].angle}return true;function drawLabel(slice,startAngle,index){if(slice.data[0][1]==0){return true}var lf=options.legend.labelFormatter,text,plf=options.series.pie.label.formatter;if(lf){text=lf(slice.label,slice)}else{text=slice.label}if(plf){text=plf(text,slice)}var halfAngle=(startAngle+slice.angle+startAngle)/2;var x=centerLeft+Math.round(Math.cos(halfAngle)*radius);var y=centerTop+Math.round(Math.sin(halfAngle)*radius)*options.series.pie.tilt;var html="<span class='pieLabel' id='pieLabel"+index+"' style='position:absolute;top:"+y+"px;left:"+x+"px;'>"+text+"</span>";target.append(html);var label=target.children("#pieLabel"+index);var labelTop=y-label.height()/2;var labelLeft=x-label.width()/2;label.css("top",labelTop);label.css("left",labelLeft);if(0-labelTop>0||0-labelLeft>0||canvasHeight-(labelTop+label.height())<0||canvasWidth-(labelLeft+label.width())<0){return false}if(options.series.pie.label.background.opacity!=0){var c=options.series.pie.label.background.color;if(c==null){c=slice.color}var pos="top:"+labelTop+"px;left:"+labelLeft+"px;";$("<div class='pieLabelBackground' style='position:absolute;width:"+label.width()+"px;height:"+label.height()+"px;"+pos+"background-color:"+c+";'></div>").css("opacity",options.series.pie.label.background.opacity).insertBefore(label)}return true}}}}function drawDonutHole(layer){if(options.series.pie.innerRadius>0){layer.save();var innerRadius=options.series.pie.innerRadius>1?options.series.pie.innerRadius:maxRadius*options.series.pie.innerRadius;layer.globalCompositeOperation="destination-out";layer.beginPath();layer.fillStyle=options.series.pie.stroke.color;layer.arc(0,0,innerRadius,0,Math.PI*2,false);layer.fill();layer.closePath();layer.restore();layer.save();layer.beginPath();layer.strokeStyle=options.series.pie.stroke.color;layer.arc(0,0,innerRadius,0,Math.PI*2,false);layer.stroke();layer.closePath();layer.restore()}}function isPointInPoly(poly,pt){for(var c=false,i=-1,l=poly.length,j=l-1;++i<l;j=i)(poly[i][1]<=pt[1]&&pt[1]<poly[j][1]||poly[j][1]<=pt[1]&&pt[1]<poly[i][1])&&pt[0]<(poly[j][0]-poly[i][0])*(pt[1]-poly[i][1])/(poly[j][1]-poly[i][1])+poly[i][0]&&(c=!c);return c}function findNearbySlice(mouseX,mouseY){var slices=plot.getData(),options=plot.getOptions(),radius=options.series.pie.radius>1?options.series.pie.radius:maxRadius*options.series.pie.radius,x,y;for(var i=0;i<slices.length;++i){var s=slices[i];if(s.pie.show){ctx.save();ctx.beginPath();ctx.moveTo(0,0);ctx.arc(0,0,radius,s.startAngle,s.startAngle+s.angle/2,false);ctx.arc(0,0,radius,s.startAngle+s.angle/2,s.startAngle+s.angle,false);ctx.closePath();x=mouseX-centerLeft;y=mouseY-centerTop;if(ctx.isPointInPath){if(ctx.isPointInPath(mouseX-centerLeft,mouseY-centerTop)){ctx.restore();return{datapoint:[s.percent,s.data],dataIndex:0,series:s,seriesIndex:i}}}else{var p1X=radius*Math.cos(s.startAngle),p1Y=radius*Math.sin(s.startAngle),p2X=radius*Math.cos(s.startAngle+s.angle/4),p2Y=radius*Math.sin(s.startAngle+s.angle/4),p3X=radius*Math.cos(s.startAngle+s.angle/2),p3Y=radius*Math.sin(s.startAngle+s.angle/2),p4X=radius*Math.cos(s.startAngle+s.angle/1.5),p4Y=radius*Math.sin(s.startAngle+s.angle/1.5),p5X=radius*Math.cos(s.startAngle+s.angle),p5Y=radius*Math.sin(s.startAngle+s.angle),arrPoly=[[0,0],[p1X,p1Y],[p2X,p2Y],[p3X,p3Y],[p4X,p4Y],[p5X,p5Y]],arrPoint=[x,y];if(isPointInPoly(arrPoly,arrPoint)){ctx.restore();return{datapoint:[s.percent,s.data],dataIndex:0,series:s,seriesIndex:i}}}ctx.restore()}}return null}function onMouseMove(e){triggerClickHoverEvent("plothover",e)}function onClick(e){triggerClickHoverEvent("plotclick",e)}function triggerClickHoverEvent(eventname,e){var offset=plot.offset();var canvasX=parseInt(e.pageX-offset.left);var canvasY=parseInt(e.pageY-offset.top);var item=findNearbySlice(canvasX,canvasY);if(options.grid.autoHighlight){for(var i=0;i<highlights.length;++i){var h=highlights[i];if(h.auto==eventname&&!(item&&h.series==item.series)){unhighlight(h.series)}}}if(item){highlight(item.series,eventname)}var pos={pageX:e.pageX,pageY:e.pageY};target.trigger(eventname,[pos,item])}function highlight(s,auto){var i=indexOfHighlight(s);if(i==-1){highlights.push({series:s,auto:auto});plot.triggerRedrawOverlay()}else if(!auto){highlights[i].auto=false}}function unhighlight(s){if(s==null){highlights=[];plot.triggerRedrawOverlay()}var i=indexOfHighlight(s);if(i!=-1){highlights.splice(i,1);plot.triggerRedrawOverlay()}}function indexOfHighlight(s){for(var i=0;i<highlights.length;++i){var h=highlights[i];if(h.series==s)return i}return-1}function drawOverlay(plot,octx){var options=plot.getOptions();var radius=options.series.pie.radius>1?options.series.pie.radius:maxRadius*options.series.pie.radius;octx.save();octx.translate(centerLeft,centerTop);octx.scale(1,options.series.pie.tilt);for(var i=0;i<highlights.length;++i){drawHighlight(highlights[i].series)}drawDonutHole(octx);octx.restore();function drawHighlight(series){if(series.angle<=0||isNaN(series.angle)){return}octx.fillStyle="rgba(255, 255, 255, "+options.series.pie.highlight.opacity+")";octx.beginPath();if(Math.abs(series.angle-Math.PI*2)>1e-9){octx.moveTo(0,0)}octx.arc(0,0,radius,series.startAngle,series.startAngle+series.angle/2,false);octx.arc(0,0,radius,series.startAngle+series.angle/2,series.startAngle+series.angle,false);octx.closePath();octx.fill()}}}var options={series:{pie:{show:false,radius:"auto",innerRadius:0,startAngle:3/2,tilt:1,shadow:{left:5,top:15,alpha:.02},offset:{top:0,left:"auto"},stroke:{color:"#fff",width:1},label:{show:"auto",formatter:function(label,slice){return"<div style='font-size:x-small;text-align:center;padding:2px;color:"+slice.color+";'>"+label+"<br/>"+Math.round(slice.percent)+"%</div>"},radius:1,background:{color:null,opacity:0},threshold:0},combine:{threshold:-1,color:null,label:"Other"},highlight:{opacity:.5}}}};$.plot.plugins.push({init:init,options:options,name:"pie",version:"1.1"})})(jQuery);
    function showTooltip(x, y, contents, areAbsoluteXY) {
        var rootElt = 'body';
        $("#tooltip").remove();
        $('<div id="tooltip" class="chart-tooltip">' + contents + '</div>').css( {
            top: y - 50,
            left: x - 9,
            opacity: 0.9,
            position: 'absolute',
            'background-color':"#eee",
            padding: "10px 3px"
        }).prependTo(rootElt).show();
    };
</script>
<style>
</style>