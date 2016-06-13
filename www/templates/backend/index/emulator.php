<br>
<div class="row">
    <div class="col-md-6">
        <form>
            <label class="control-label col-md-3">Change User</label>
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
        </form>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-6">
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
                        <input type="text" name="to" value="79263335708" class="form-control">
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
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-bubbles font-dark"></i>
                    <span class="caption-subject bold uppercase"> Chat</span>
                </div>
                <div class="actions">
                    <a class="btn blue btn-outline" data-toggle="modal" href="#clear_chat_modal" id="clear_chat">
                        <i class="fa fa-refresh"></i> Clear Chat
                    </a>
                </div>
            </div>
            <div class="portlet-body" id="chats">
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
                <p>Are you sure you want to delete all chat messages for <br>user with phone #<span id="phone_no"></span></p>
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
        $("body").on("click", "#clear_chat_btn", function () {
            var user_id = $(this).attr('data-id');
            var params = {
                'action': 'clear_chat',
                'values': {user_id: user_id},
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
        $("#clear_chat").click(function() {
            var user_id = $("#user_id").val();
            var phone = $("#user_id option[value='" + user_id + "']").html();
            $("#phone_no").html(phone);
            $("#clear_chat_btn").attr('data-id', user_id);
        });
//        console.log($('#chats').last().offset().top);
        $('#user_id').change(function() {
            $(this).closest('form').submit();
//            var user_id = $("#user_id").val();
//            var params = {
//                'action': 'update_messages',
//                'values': {user_id: user_id},
//                'callback': function (msg) {
//                    ajax_respond(msg,
//                        function (respond) { //success
//                            $(".scroll").html(respond.template);
//                            $('#timestamp').val(respond.time);
//                        },
//                        function (respond) { //fail
//                        }
//                    );
//                }
//            };
//            ajax(params);
        });
        setInterval(function() {
            var user_id = $("#user_id").val();
            var params = {
                'action': 'update_messages',
                'values': {user_id: user_id},
                'callback': function (msg) {
                    ajax_respond(msg,
                        function (respond) { //success
                            $(".scroll").html(respond.template);
                            if($('.message').length) {
                                $(".scroll").scrollTop($('.message').last().offset().top + 2000);
                            }
//                            /console.log($('#timestamp'));
                            $('#timestamp').val(respond.time);
                        },
                        function (respond) { //fail
                        }
                    );
                }
            };
            ajax(params);
        }, 5000);
        $("#form").submit(function(e) {
            e.preventDefault();
            var message = get_from_form('#form');
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

//            $('[name="user_id"]').val($('[name="user_id"] option[name="' + message['msisdn'] + '"]').val());
            message.send = null;
//            console.log(message);
            if(message.text.length > 10) {
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
                                'values': {user_id: user_id},
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
//                            toastr.success('sent');
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
                            'values': {user_id: user_id},
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
//                        toastr.success('sent');
                        $('[name="text"]').val('');

                    }
                };
                ajax(params);
            }
//            if(params.text) {
//
//            }
//            var params = {
//                'action': 'send_message',
//                'get_from_form': 'form',
//                'callback': function (msg) {
//                    toastr.success('Sent');
//                }
//            };
//            ajax(params);
            if(reload) {
                $('#user_id').closest('from').submit();
            }
            return false;
        })
    });
    function rec(res, string, start) {
        res[res.length + 1] = string.substr(start, 10);
        start += 10;
        if(string.length > start) {
            var items = rec(res, string, start);
            res.concat(items);
        }
        return res;
    }
</script>