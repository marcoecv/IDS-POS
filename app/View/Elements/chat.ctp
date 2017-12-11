<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
        <script>
            var _IMG_CHAT_AVATAR = '<?php echo $this->Html->image('avatar_chat.png', array("class" => "avatar-logged-user"));?>';  
        </script>
        <script src='/js/jquery-1.11.2.min.js'></script>
        <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="/bootstrap/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="/css/jquery-ui.css">
        <script src='/js/jquery-ui.js'></script>
        <script src='/bootstrap/js/bootstrap.js'></script>
        <link rel="stylesheet" href="/css/admin/chat.css">
        <script src='/js/interact-1.2.5.min.js'></script>
        <script src='/js/admin/chat.js'></script>
        <script src='/js/stomp.js'></script>
    </head>
    <body>
        <input type="hidden" id="baseurl" name="baseurl" value="<?= ($this->Html->url('/')) ? $this->Html->url('/') : '/'; ?>"/>
        <div id="chat_window_container" class="chat-window-container">
            <div class="row row-chat container-row">
                <div class="col-md-4 logged-users-container">
                    <div class="row row-chat" id="logged_users_container">
                        <div class="loading-pane-logged-users">
                            <?php echo $this->Html->image('chat-loading.gif', array("class" => ""));?>  
                            <strong><?php echo __('LOADING. . .');?></strong>
                        </div>
                    </div>
                </div>
                <span class="logged-user-container-nav-button" onclick="toggleLoggedUsersContainer()"><i class="glyphicon glyphicon-circle-arrow-right"></i></span>

                <div class="col-md-8 current-chat-container">
                    <div class="chat-messages-container-modal" id="chat_messages_container_modal">
                        <?php echo __('Select An User');?><br> <i class="glyphicon glyphicon-user"></i>
                    </div>
                    <div class="row row-chat">
                        <div class="col-xs-12 header-chat-messages-container" id="header_chat_messages_container">

                        </div>
                    </div>
                    <div class="row row-chat">
                        <div class="col-xs-12 show-more-messages-button" onclick="loadMoreMessages()"><i class="glyphicon glyphicon-download"></i> Show More</div>
                    </div>
                    <div class="row row-chat">
                        <div class="col-xs-12 chat-messages-container" id="chat_messages_container">
                        </div>
                    </div>
                    <div class="row row-chat">
                        <div class="col-xs-12 input-text-chat-container">
                            <div class="no-logged-user-alert" id="no_logged_user_alert"><?php echo __('User Is Not Logged');?></div>
                            <input type="text" id="input_text_chat" class="input-text-chat" placeholder="Write your message. . ." onclick="resetUserUnreadMsgs(_CURRENT_USER_SELECTED)"/>
                            <div class="message-sender-chat"><i class="glyphicon glyphicon-send" title="Send" onclick='sendMessage()'></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>