<br>
<div class="row">
    <div class="col-md-6">

    </div>
</div>
<br>
<div class="row">
    <div class="col-md-6">
        <form class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-md-3">Campaign</label>
                <div class="col-md-9">
                    <select id="campaign_id" class="form-control" name="campaign">
                        <?php if ($campaigns): ?>
                            <?php foreach ($campaigns as $v): ?>
                                <option value="<?php echo $v['id']; ?>"
                                    <?php if ($v['id'] == $campaign['id']): ?>
                                        selected
                                    <?php endif; ?>>
                                    <?php echo $v['campaign_name']; ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Virtual Number</label>
                <div class="col-md-9">
                    <select name="number_id" id="number_id" class="form-control">
                        <?php if ($phones): ?>
                            <?php foreach ($phones as $phone): ?>
                                <option value="<?php echo $phone['phone']; ?>"
                                    <?php if ($phone['phone'] == $number_id): ?>
                                        selected
                                    <?php endif; ?>>
                                    <?php echo $phone['phone']; ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">User</label>
                <div class="col-md-9">
                    <select id="user_id" class="form-control" name="user_id">
                        <?php if ($users): ?>
                            <?php foreach ($users as $v): ?>
                                <option value="<?php echo $v['id']; ?>"
                                    <?php if ($v['id'] == $_GET['user_id']): ?>
                                        selected
                                    <?php endif; ?>>
                                    <?php echo $v['phone']; ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
        </form>
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="fa fa-envelope font-dark"></i>
                    <span class="caption-subject bold uppercase"> Message</span>
                </div>
                <div class="actions">

<!--                    <div class="btn-group btn-group-devided">-->
<!--
<!--                        <a class="btn red btn-outline btn-circle delete_phrases" href="#delete_modal" data-toggle="modal">-->
<!--                            <i class="fa fa-trash-o"></i>-->
<!--                        </a>-->
<!--                    </div>-->
                </div>
            </div>
            <div class="portlet-body">
                <form method="post" action="" id="form">
                    <div class="form-group hidden">
                        <label>Type</label>
                        <select class="form-control" name="type">
                            <option value="text">Text</option>
                            <option value="unicode">Unicode</option>
                            <option value="binary">Binary</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="msisdn" class="form-control" value="<?php echo $user['phone']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Text</label>
                        <textarea rows="5" name="text" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-info" name="send">
                    </div>
                    <div class="form-group hidden ">
                        <label>To</label>
                        <input type="text" name="to" value="<?php echo $number_id; ?>" class="form-control">
                    </div>
                    <div class="form-group hidden ">
                        <label>To</label>
                        <input type="text" name="campaign_id" value="<?php echo $current_campaign['id']; ?>" class="form-control">
                    </div>
                    <div class="form-group hidden">
                        <label>Message Id</label>
                        <input type="text" name="messageId" value="<?php echo (time() - 37488); ?>" class="form-control">
                    </div>
                    <div class="form-group hidden">
                        <label>Timestamp</label>
                        <input type="text" id="timestamp" name="message-timestamp" value="<?php echo date('Y-m-d H:i:s'); ?>" class="form-control">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
<!--        <div class="portlet light bordered">-->
<!--            <div class="portlet-title">-->
<!--                <div class="caption caption-md">-->
<!--                    <i class="icon-bar-chart theme-font hide"></i>-->
<!--                    <span class="caption-subject font-blue-madison bold uppercase">Latest Incoming Message</span>-->
<!--                </div>-->
<!--                <div class="actions">-->
<!--                    <a href="--><?php //echo SITE_DIR; ?><!--emulator/?campaign=--><?php //echo $latest['campaign_id']; ?><!--&user_id=--><?php //echo $latest['user_id']; ?><!--&number_id=--><?php //echo $latest['recipient']; ?><!--#override"-->
<!--                       class="btn blue btn-outline">-->
<!--                        <i class="fa fa-pencil"></i> Override-->
<!--                    </a>-->
<!--                    <a href="--><?php //echo SITE_DIR; ?><!--emulator/?campaign=--><?php //echo $latest['campaign_id']; ?><!--&user_id=--><?php //echo $latest['user_id']; ?><!--&number_id=--><?php //echo $latest['recipient']; ?><!--"-->
<!--                       class="btn btn-outline green">-->
<!--                        <i class="fa fa-link"></i> Go to Chat-->
<!--                    </a>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="portlet-body">-->
<!--                <div class="general-item-list" id="last_container">-->
<!--                    --><?php //require_once(TEMPLATE_DIR . 'index' . DS . 'ajax' . DS . 'last_message.php'); ?>
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-bubbles font-dark"></i>
                    <span class="caption-subject bold uppercase"> Chat</span>
                </div>
                <div class="actions">
<!--                    <button class="btn blue btn-outline" id="override_btn">-->
<!--                        <i class="fa fa-pencil"></i> Override-->
<!--                    </button>-->
                    <a class="btn red btn-outline" data-toggle="modal" href="#clear_chat_modal" id="clear_chat">
                        <i class="fa fa-refresh"></i> Clear Chat
                    </a>

                </div>
            </div>
            <div class="portlet-body" id="chats">
                <form class="row" id="override_form" style="display: none;" method="post">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Override bot message:</label>
                            <textarea class="form-control" name="override[sms]" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="override[campaign_id]" value="<?php echo $current_campaign['id']; ?>">
                            <input type="hidden" name="override[user_id]" value="<?php echo $user['id']; ?>">
                            <input type="hidden" name="override[recipient]" value="<?php echo $number_id; ?>">
                            <button class="btn btn-success"><i class="fa fa-envelope"></i> Send</button>
                        </div>
                    </div>
                </form>
                <div class="scroll" style="height: 400px; overflow: auto;" data-always-visible="1" data-rail-visible1="1">
                    <?php require_once(TEMPLATE_DIR . 'index' . DS . 'ajax' . DS . 'chats.php'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="clear_chat_modal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Clear Chat</h4>
            </div>
            <div class="modal-body with-padding">
                <p>Are you sure you want to delete this chat?</p>
            </div>
            <div class="modal-footer">
                <button type="button" id="clear_chat_btn" class="btn btn-primary">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $ = jQuery.noConflict();
    $(document).ready(function () {
//        console.log(window.location.hash);
        if(window.location.hash == '#override') {
            var values = {};
            values.user_id = $('#user_id').val();
            values.campaign_id = $("#campaign_id").val();
            values.recipient = $("#number_id").val();
            $("#override_form").slideDown();
            $('[name="override[sms]"]').focus();
            var params = {
                'action': 'prevent_override',
                'values': values,
                'callback': function (msg) {

                }
            };
            ajax(params);
            window.location.hash = '';
//            history.pushState('', document.title, window.location.pathname);
        }

        $("body").on("click", "#override_btn", function () {
            var values = {};
            values.user_id = $('#user_id').val();
            values.campaign_id = $("#campaign_id").val();
            values.recipient = $("#number_id").val();
            $("#override_form").slideDown();
            $('[name="override[sms]"]').focus();
            var params = {
                'action': 'prevent_override',
                'values': values,
                'callback': function (msg) {

                }
            };
            ajax(params);

        });

        $("body").on("submit", "#override_form", function () {
            var params = {
                'action': 'override',
                'get_from_form': 'override_form',
                'callback': function (msg) {
                    $("#override_form").slideUp();
                    $('[name="override[sms]"]').val('');
                    update_messages();
                }
            };
            ajax(params);
            return false;
        });
        $("body").on("click", "#clear_chat_btn", function () {
            var user_id = $('#user_id').val();
            var campaign_id = $("#campaign_id").val();
            var number = $("#number_id").val();
            var params = {
                'action': 'clear_chat',
                'values': {user_id: user_id, campaign_id: campaign_id, 'number': number},
                'callback': function (msg) {
                    $(".scroll").html('');
                    $("#clear_chat_modal").modal('hide');
                }
            };
            ajax(params);
        });
        if($('.message').length) {
            $(".scroll").scrollTop($('.message').last().offset().top);
        }
//        $("#clear_chat").click(function() {
//            var user_id = $("#user_id").val();
//            var phone = $("#user_id option[value='" + user_id + "']").html();
//            $("#phone_no").html(phone);
//            $("#clear_chat_btn").attr('data-id', user_id);
//        });
        $('#user_id, #campaign_id, #number_id').change(function() {
            $(this).closest('form').submit();
        });
        setInterval(function() {
            update_messages();
            update_last_message();
        }, 5000);
        $("#form").submit(function(e) {
            e.preventDefault();
            var campaign_id = $("#campaign_id").val();
            var message = get_from_form('#form');
            var phone = $("#number_id").val();
            var reload = false;
            if($('[name="user_id"]').val() == message['msisdn']) {
                reload = false;
            } else {
                $('[name="user_id"] option').each(function()
                {
                    if($(this).html() ==  message['msisdn']) {
                        reload = true;
                        $('[name="user_id"]').val($(this).attr('value'));
                    }
                });

            }

            message.send = null;
            if(message.text.length > 100) {
                var tmp = rec([], message.text, 0);
                var messages = [];
                for(var i in tmp) {
                    messages.push(tmp[i]);
                }
                var ref = Math.floor(Math.random() * 100000);
                var count = 0;
                console.log(messages);
                for (var i in messages) {
                    console.log(messages[i]);
                    message.text = messages[i];
                    message['concat-ref'] = ref;
                    message['concat-total'] = messages.length;
                    message['concat-part'] = parseInt(i) + 1;
                    message['concat'] = true;
                    var parts = [];
                    for(var key in message) {
                        parts.push(key + '=' + message[key]);
                    }
                    var uri = encodeURI(parts.join('&'));
                    var params = {
                        'action': '',
                        'url': '<?php echo SITE_DIR; ?>api/?' + uri,
                        'callback': function (msg) {
                            var user_id = $("#user_id").val();
                            var params = {
                                'action': 'update_messages',
                                'values': {user_id: user_id, campaign_id: campaign_id, phone: phone},
                                'callback': function (msg) {
                                    ajax_respond(msg,
                                        function (respond) { //success
                                            $(".scroll").html(respond.template);
                                            $('[name="message-timestamp"]').val(respond.time);
                                            if($('.message').length) {
                                                $(".scroll").scrollTop($('.message').last().offset().top + 2000);
                                            }
                                        },
                                        function (respond) { //fail
                                        }
                                    );
                                }
                            };
                            ajax(params);
                            $('[name="text"]').val('');
                        }
                    };
                    ajax(params);
                    count ++;
                }
            } else {
                var parts = [];
                for(var key in message) {
                    parts.push(key + '=' + message[key]);
                }
                var uri = encodeURI(parts.join('&'));
                var params = {
                    'action': '',
                    'url': '<?php echo SITE_DIR; ?>api/?' + uri,
                    'callback': function (msg) {
                        var user_id = $("#user_id").val();
                        var params = {
                            'action': 'update_messages',
                            'values': {user_id: user_id,  campaign_id: campaign_id, phone: phone},
                            'callback': function (msg) {
                                ajax_respond(msg,
                                    function (respond) { //success
                                        $(".scroll").html(respond.template);
                                        $('[name="message-timestamp"]').val(respond.time);
                                        if($('.message').length) {
                                            $(".scroll").scrollTop($('.message').last().offset().top + 2000);
                                        }
                                    },
                                    function (respond) { //fail
                                    }
                                );
                            }
                        };
                        ajax(params);
                        $('[name="text"]').val('');

                    }
                };
                ajax(params);
            }
            if(reload) {
                $('#user_id').closest('from').submit();
            }
            return false;
        })
    });
    function rec(res, string, start) {
        res[res.length + 1] = string.substr(start, 100);
        start += 100;
        if(string.length > start) {
            var items = rec(res, string, start);
            res.concat(items);
        }
        return res;
    }
    function update_messages()
    {
        var user_id = $("#user_id").val();
        var campaign_id = $("#campaign_id").val();
        var phone = $("#number_id").val();
        var params = {
            'action': 'update_messages',
            'values': {user_id: user_id, campaign_id: campaign_id, phone: phone},
            'callback': function (msg) {
                ajax_respond(msg,
                    function (respond) { //success
                        $(".scroll").html(respond.template);
                        if($('.message').length) {
                            $(".scroll").scrollTop($('.message').last().offset().top + 2000);
                        }
                        $('#timestamp').val(respond.time);
                    },
                    function (respond) { //fail
                    }
                );
            }
        };
        ajax(params);
    }

    function update_last_message()
    {
        var params = {
            'action': 'update_last_message',
            'callback': function (msg) {
                ajax_respond(msg,
                    function (respond) { //success
                        $("#last_container").html(respond.template);
                    },
                    function (respond) { //fail
                    }
                );
            }
        };
        ajax(params);
    }
</script>