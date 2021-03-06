/**
 * Created by asus1 on 01.06.2016.
 */
/**
 * Created by novichkov on 10.03.15.
 */
$ = jQuery.noConflict();
var $body = $("body");
$(document).ready(function()
{
    $.datepicker.setDefaults({
        numberOfMonths: 2,
        dateFormat: "yy-mm-dd"
    });
    $("#logout_button").click(function(e)
    {
        e.preventDefault();
        $("#log_out").submit();
    });
    $("#log-button").click(function()
    {
        $("#log").slideToggle();
    });
    $("#log").dblclick(function()
    {
        $(this).slideUp();
    });

    $(".datepicker").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });

    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core componets
        Layout.init(); // init layout
        QuickSidebar.init() // init quick sidebar
        Index.init();
        Index.initDashboardDaterange();
        Index.initJQVMAP(); // init index page's custom scripts
        Index.initCalendar(); // init index page's custom scripts
        Index.initCharts(); // init index page's custom scripts
        Index.initChat();
        Index.initMiniCharts();
//        Index.initIntro();
        Tasks.initDashboardWidget();
    });

});


/**
 *
 * @param params
 */

var ajax = function ajax(params)
{
    var $preloader;
    if(params.nopreloader === undefined && params.header_preloader === undefined) {
        $preloader = $("#preloader-bg");
        $preloader.show();
    }
    if(params.header_preloader !== undefined) {
        $preloader = $("#header_preloader");
        $preloader.show();
    }

    if(!params.values) params.values = {};
    params.values.ajax = true;
    params.values.action = params.action;
    params.values.common = params.common;
    if(params.get_from_form)
    {
        var val;
        $("#" + params.get_from_form + " input, #" + params.get_from_form + " textarea, #" + params.get_from_form + " select").each(function()
        {
            if($(this).attr('type') == 'radio' || $(this).attr('type') == 'checkbox') {
                val = $("[name='" + $(this).attr('name') + "']:checked").val();
            } else {
                val = $(this).val();
            }
            params.values[$(this).attr('name')] = val;
        });
        $("#" + params.get_from_form + " .summernote").each(function()
        {
            val = $(this).code();
            params.values[$(this).attr('data-name')] = val;
        });
    }
    var res;
    $.ajax(
        {

            url: params.url ? params.url : '',
            type: 'post',
            data: params.values,
            success: function(result)
            {
                if(params.nopreloader === undefined) {
                    $preloader.hide();
                }
                params.callback(result);
                $(".datepicker").datepicker();
            }
        }
    );
};

/**
 *
 * @param form_id
 * @returns {boolean}
 */

var validate = function validate(form_id)
{
    var form = $("#" + form_id);
    var validate = true;
    $('.error-require, .error-validate, .error-min, .error-max, .error-one_ten, .error-numeric').each(function()
    {
        $(this).slideUp();
    });

    $(form).find('[data-require="1"], select.data-required').each(function()
    {
        if(!$(this).val() || $(this).val() == '' || $(this).val() == null)
        {
            $(this).parent().find('.error-require').slideDown();
            validate = false;
        }
    });

    $(form).find('[data-validate="email"]').each(function()
    {
        var regexp = /^[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}$/;
        if($(this).val() && !regexp.test($(this).val())) {
            if(!$(this).attr('.error-require') || $(this).parent().find('.error-require').css('display') == 'none')
                $(this).parent().find('.error-validate').slideDown();
            validate = false;
        }
    });

    $(form).find('[data-validate="password"]').each(function()
    {
        if($(this).val() != $(form).find('[data-validate="rpassword"]').val())
        {
            if(!$(this).parent().find('.error-require').length || $(this).parent().find('.error-require').css('display') == 'none') {
                $(this).parent().find('.error-validate').slideDown();
            }
            validate = false;
        }
    });

    $(form).find('[data-min]').each(function()
    {
        var min = $(this).attr('data-min');
        if($(this).val().length < min && $(this).parent().find('.error-require').css('display') == 'none') {
            $(this).parent().find('.error-min').slideDown();
            validate = false;
        }
    });

    $(form).find('[data-max]').each(function()
    {
        var min = $(this).attr('data-max');
        if($(this).val().length < min && $(this).parent().find('.error-require').css('display') == 'none') {
            $(this).parent().find('.error-max').slideDown();
            validate = false;
        }
    });

    $(form).find('[data-one_ten="1"]').each(function()
    {
        var val = $(this).val();
        if((isNaN(parseInt(val)) || parseInt(val) < 0 || parseInt(val) > 10)) {
            $(this).parent().find('.error-one_ten').slideDown();
            validate = false;
        }
    });

    $(form).find('[data-validate="numeric"]').each(function()
    {
        var val = $(this).val();
        if(val && typeof val != 'undefined' && val != null && isNaN(parseInt(val))) {
            $(this).parent().find('.error-validate').slideDown();
            validate = false;
        }
    });

    $(form).find('[data-validate="emails"]').each(function()
    {
        var val = $(this).val();
        if(val) {
            var regexp = /^[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}$/;
            var arr = val.split(';');
            for(var i in arr) {
                if(arr[i] != '' && !regexp.test(arr[i])) {
                    $(this).parent().find('.error-validate').slideDown();
                    validate = false;
                }
            }
        }
    });

    return(validate);

};


/**
 *
 * @param id
 */

function ajax_datatable(id, display_records, options)
{
    if(display_records === undefined) {
        display_records = 10;
    }
    var params = {
        "destroy": $.fn.dataTable.isDataTable("#" + id),
        "bJQueryUI": false,
        "bAutoWidth": false,
        "iDisplayLength": display_records,
        //"sPaginationType": "full_numbers",
        "sDom": '<"datatable-header"Tfl><"datatable-scroll"t><"datatable-footer"ip>',
        "sAjaxSource": '?',
        "bServerSide": true,
        "fnServerParams": function ( aoData ) {
            aoData.push(
                { "name": "ajax", "value": true },
                { "name": "action", "value": id }
            );
            var params = Object();
            $("#" + id + ' .filter-field, .filter-field[data-id="' + id + '"]').each(function(){
                if($(this).val())
                    params[$(this).attr('name')] = {"value" : $(this).val(), "sign" : $(this).attr('data-sign')};
            });
            aoData.push({"name" : "params", "value" : JSON.stringify(params)});
        },
        "oLanguage": {
            "sLengthMenu": "<span></span> _MENU_",
            "oPaginate": { "sFirst": "First", "sLast": "Last", "sNext": "<i class=\"fa fa-angle-right\"></i>", "sPrevious": "<i class=\"fa fa-angle-left\"></i>" }
        },
        "oTableTools": {
            "sRowSelect": "single",
            "sSwfPath": "/media/swf/copy_csv_xls_pdf.swf",
            "aButtons": [
                {
                    "sExtends": "copy",
                    "sButtonText": "Copy",
                    "sButtonClass": "btn"
                },
                {
                    "sExtends": "print",
                    "sButtonText": "Print",
                    "sButtonClass": "btn"
                },
                {
                    "sExtends": "collection",
                    "sButtonText": "Save <span class='caret'></span>",
                    "sButtonClass": "btn btn-primary",
                    "aButtons": [ "csv", "xls", "pdf" ]
                }
            ]
        }
    };
    if(undefined !== options) {
        for(var key in options) {
            params[key] = options[key];
        }
    }
    var oTable = $("#" + id).dataTable(params);

    $('#' + id + ' .filter-field, .filter-field[data-id="' + id + '"]').change(function(){
        oTable.fnFilter();
    });

    $(".range-input-1, .range-input-2").datepicker({
        format: 'yyyy-mm-dd'
    });

    $('#' + id + ' .filter-range, .filter-range[data-id="' + id + '"]').change(function() {
        var $cont = $(this).closest('.date-range');
        var input1 = $cont.find('.range-input-1');
        var input2 = $cont.find('.range-input-2');
        var input1_val = input1.val() ? input1.val() : '2010-01-01';
        var input2_val = input2.val() ? input2.val() : '2030-01-01';
        var $hidden_input = $cont.find('.range-hidden-input');
        var value = input1_val + ' - ' + input2_val;
        $hidden_input.val(value);
        oTable.fnFilter();
    });

    return oTable;
}

/**
 *
 * @param selector
 * @param action
 */

function ajax_select2(selector, action)
{
    $(selector).select2({
        ajax: {
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params,
                    action: action,
                    ajax: 'true'
                };
            },
            results: function(data) {
                return {  results: data };

            },
            cache: true
        },
        minimumInputLength: 2
    });
}


/**
 *
 * @param params
 */

function ajax_file_upload(params)
{
    var btnUpload = $('#'+ (params.button ? params.button : 'upload_btn'));
    var status = $('#' + (params.status ? params.status : 'upload_status'));
    new AjaxUpload(btnUpload, {
        action: params.action ? params.action : '',
        name: params.name ? params.name : 'file',
        data: params.data,
        onSubmit: function(file, ext){
            if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext)) && typeof params.check != 'function'){
                status.text('Only JPG, PNG or GIF files are allowed');
                return false;
            } else if(typeof params.check == 'function') {
                if(!params.check(file, ext)) {
                    return false;
                }
            }
            status.html(params.status_upload ? params.status_upload : '<img src="../../assets/global/img/loading-spinner-grey.gif" />');
        },
        onComplete: function(file, msg){
            console.log(msg);
            status.html('');
            try {
                var respond = JSON.parse(msg);
            }
            catch (e) {
                console.log(e);
                params.error();
            }
            console.log(respond);

            params.success(respond);
        }
    });
}

/**
 *
 * @param function_name
 * @returns {boolean}
 */

function function_exists( function_name ) {
    if (typeof function_name == 'string'){
        return (typeof window[function_name] == 'function');
    } else{
        return (function_name instanceof Function);
    }
}

/**
 *
 * @param needle
 * @param haystack
 * @returns {boolean}
 */

function in_array(needle, haystack) {
    var found = false, key;

    for (key in haystack) {
        if (haystack[key] == needle) {
            found = true;
            break;
        }
    }
    return found;
}

function ajax_respond(msg, success, unsuccess, ret) {

    try {
        var respond = JSON.parse(msg);
    }
    catch (e) {
        if(ret) {
            return e;
        } else {
            toastr.error('Unexpexted error!');
        }
    }
    if(respond.status == 1) {
        success(respond);
        return false;
    } else {
        if(ret) {
            return respond.error;
        } else {
            for(var i in respond.error) {
                for(var j in respond.error[i]) {
                    for(var type in respond.error[i][j]) {
                        toastr.error(respond.error[i][j][type]['text']);
                    }
                }
            }
        }
        if(typeof unsuccess == 'function') {
            unsuccess(respond);
        }
    }
}

/**
 *
 * @param selector
 * @returns {{}}
 */

function get_from_form(selector)
{
    var val;
    var res = {};
    $(selector + " input, " + selector + " textarea, " + selector + " select").each(function()
    {
        if($(this).attr('type') == 'radio' || $(this).attr('type') == 'checkbox') {
            val = $("[name='" + $(this).attr('name') + "']:checked").val();
        } else {
            val = $(this).val();
        }
        res[$(this).attr('name')] = val;
    });
    $(selector + " .summernote").each(function()
    {
        val = $(this).code();
        res[$(this).attr('data-name')] = val;
    });

    return res;
}


function round(x)
{
    if(isNaN(x)) {
        throw 'Round function expexts argument 1 to be a number';
    }
    return Math.round(parseFloat(x) * 100) / 100;
}