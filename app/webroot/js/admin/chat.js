var _LOGGED_USERS_CONTAINER = null; //Logged Users Container DOM element
var _CURRENT_USER_SELECTED = ""; //Store the selected user's ID
var _ACTIVE_RESPONSIVE = ""; //Controls if javascript has change the responsive controls
var _QUEUE_USERS_INFO = null; //Store all users queue's hash
var _CHAT_WEBSOCKET_URL = "ws://10.0.66.21:61614/stomp"; //ACTIVEMQ websocket url
var _CHAT_WEBSOCKET_USER = ""; //ACTIVEMQ user
var _CHAT_WEBSOCKET_PASS = ""; //ACTIVEMQ pass
var _SUCCESSFULL_WEBSOCKET_CONNECTION = false; //Controls if websocket was successfully opened
var _SUCCESS_WEBSOCKET_CONNECTION_INTERVAL = setInterval(checkWebsocketSuccessfullConnection, 1000); //Check each second if a success connection was reached
var _CURRENT_USER = ""; //The current logged user
var _LOGGED_USERS = []; //Stores all current logged users
var _STOMP_CLIENT = null; //STOMP client object
var _USERS_DATA_CHAT = []; //Stores all recent chat history for each user
var _DASHBOARD_CONTAINER_FLAG = false; //Stores a flag if dashboard conatiner is available to load
var _LOADING_MORE_MESSAGES = false; //Flag to prevent user to call several times the ajax call for retrieve msgs
var _AMOUNT_MESSAGES_LOAD_MORE = 10; //Amount of messages to load when user wants to load more messages in history

/**
 * Initialize some properties and actions on window ready
 * @param {type} param
 */
$(window).ready(function(){
    //Toggle chat window on double click over header
    $("#chat_header").dblclick(function() {
        toggleChatWindow();
    }); 
    
    //Logged Users Container DOM element
    _LOGGED_USERS_CONTAINER = $("#logged_users_container");
    
    //Adding event listener for text input to send messages when enter key pressed
    $("#input_text_chat").keypress(function(e) {
        if(e.which === 13) {
            sendMessage();
        }
    });
    
    //Check cookie to autoload chat
    if(GetCookie("chat_autoload") !== null && GetCookie ("chat_autoload") === '1'){
        toggleChatWindow();
    }
    
    //Apply responsive patterns
    $(window).on('resize', changeChatResponsiveness);
    changeChatResponsiveness();
    
    //Load queue information
    loadQueueUsersInfo();
        
    //Set onbeforeunload event
    onbeforeunload = logoutUser;
    
    //Set refresh method
    setInterval(refreshLoggedUsers, 60000); //Refresh logged users each minute
    
    //Set flag for chat container on dashboard
    _DASHBOARD_CONTAINER_FLAG = $("#dashboard_logged_users_container").length > 0 ? true : false;    
});

/**
 * Toggle the chat window (Open/Close)
 * @returns {undefined}
 */
function toggleChatWindow(){
    var style = $("#chat_window_container").css('display');
    if(style.trim() === 'none'){
        $( "#chat_window_container" ).css('display','block');
        document.cookie = "chat_autoload=1";
    }else{
        $( "#chat_window_container" ).css('display','none');
        document.cookie = "chat_autoload=0";
    }
    //Somes times the interact.js override the html's cursor
    //so we change it againg to auto
    $("html").css('cursor','auto');
}

/**
 * Supports GetCookie() to parse value's data
 * @param {type} offset
 * @returns {unresolved}
 */
function getCookieVal (offset) {
    var endstr = document.cookie.indexOf (";", offset);
    if (endstr == -1) { endstr = document.cookie.length; }
    return unescape(document.cookie.substring(offset, endstr));
}

/**
 * Return the value of some index within the cookie
 * @param {type} name
 * @returns {unresolved}
 */
function GetCookie (name) {
    var arg = name + "=";
    var alen = arg.length;
    var clen = document.cookie.length;
    var i = 0;
    while (i < clen) {
        var j = i + alen;
        if (document.cookie.substring(i, j) == arg) {
            return getCookieVal (j);
        }
        i = document.cookie.indexOf(" ", i) + 1;
        if (i === 0) break; 
    }
    return null;
}

/**
 * Load an user's chat history and enable chat window for chatting
 * @param {type} user
 * @returns {undefined}
 */
function loadAccountChat(user, noOpenedAtStart){
    //User id cannot be empty and cannot be equal to current selected user
    if(user.trim() !== '' && _CURRENT_USER_SELECTED !== user){
        //Set global variable
        _CURRENT_USER_SELECTED = user;
        //Change chat's header
        $("#header_chat_messages_container").html(user+"'s Chat");
        
        //Repaint chat history      
        rePaintChatHistory(user);
        
        //Hide modal
        var display = $("#chat_messages_container_modal").css('display');
        if(display === 'block'){
            $("#chat_messages_container_modal").effect( 'fade', {}, 200 );
        }
        
        if(noOpenedAtStart){
            resetUserUnreadMsgs(user);
        }else{
            $("#chat_messages_container_modal").css('display','none');
        }
        
    }
    //If it's on responsive design, close the logged users container
    var width = $(window).width();
    if(width<570 && noOpenedAtStart){
        toggleLoggedUsersContainer();
    }
}

/**
 * Scroll all the way down the messages window
 * @returns {undefined}
 */
function scrollDownChat(){
    $("#chat_messages_container").animate({ scrollTop: $("#chat_messages_container")[0].scrollHeight});
}

/**
 * Takes the typed input and appends it into chat and then sends it to server
 * @returns {undefined}
 */
function sendMessage(){
    var message = $("#input_text_chat").val();
    var index = getSendQueueHashByUserID(_CURRENT_USER_SELECTED).index; 
    var logged = _QUEUE_USERS_INFO[index].logged;
    //Message cannot be empty
    if(message.trim() !== ''){
        if(logged === 'Y'){ //If user is logged so send message
            doAJAX("POST", "Chat/sendMessage", true, false, 'JSON', {receiver: _CURRENT_USER_SELECTED, message:message}, function(data){
                if(data.status === 'success'){
                    $("#chat_messages_container").append(msgToHTML(message, 'receiver'));
                    //Store the msg into the user array
                    _QUEUE_USERS_INFO[index].chat.push({type:'receiver',msg:message});
                    scrollDownChat();
                }else{
                    //THERE WAS A MYSTICAL MISTAKE
                }
            });
        }else{ //User no logged
            displayNoLoggedUserAlert();
        }
    }
    //Clean input
    $("#input_text_chat").val("");
}

/**
 * Creates a chat bubble from a message
 * @param {type} message
 * @param {type} type
 * @returns {String}
 */
function msgToHTML(message, type){
    return "<div class='col-md-12 chat-bubble "+type+"-bubble'>"+message+"</div>";
}

/**
 * Manage all css and actions to control the responsive layout
 * @returns {undefined}
 */
function changeChatResponsiveness(){
    var width = $(window).width();
    var height = $(window).height();
    //Less than 992 pixels width 
    if(width<992 && _ACTIVE_RESPONSIVE !== '992'){
        _ACTIVE_RESPONSIVE = '992';
        $(".logged-users-container").removeClass("col-md-4");
        $(".logged-users-container").addClass("col-xs-4");
        $(".current-chat-container").removeClass("col-md-8");
        $(".current-chat-container").addClass("col-xs-8");
        $("#chat_header").addClass("responsive-margin-cols");
        $("#header_chat_messages_container").addClass("responsive-margin-cols");
        $("#chat_messages_container").addClass("responsive-margin-cols");
        if(width>570){
            $(".logged-users-container").css("left", "0px");    
        }
    }else if(width>991 && _ACTIVE_RESPONSIVE !== '991'){
        _ACTIVE_RESPONSIVE = '991';
        $(".logged-users-container").removeClass("col-xs-4");
        $(".logged-users-container").addClass("col-md-4");
        $(".current-chat-container").removeClass("col-xs-8");
        $(".current-chat-container").addClass("col-md-8");
        $("#chat_header").removeClass("responsive-margin-cols");
        $("#header_chat_messages_container").removeClass("responsive-margin-cols");
        $("#chat_messages_container").removeClass("responsive-margin-cols");        
    }  
    if(width>570){
        $(".logged-users-container").css("left", "0px");    
    }
    height -= 65; //Header, chat title and input heights
    $("#chat_messages_container").css("height",height);
    $(".chat-messages-container-modal").css("height",height+65);    
}

/**
 * Toggle the pane container of connected users when is on mobile layout
 * @returns {undefined}
 */
function toggleLoggedUsersContainer(){
    $(".logged-user-container-nav-button i").toggleClass("glyphicon-circle-arrow-left");
    leftPos = $(".logged-user-container-nav-button").css("left");
    if(leftPos.trim() === '0px'){
        $(".logged-user-container-nav-button").css("left", "200px");
        $(".logged-users-container").css("left", "0px");
    }else{
        $(".logged-user-container-nav-button").css("left", "0px");
        $(".logged-users-container").css("left", "-200px");
    }
}

/**
 * Generic function to make AJAX calls
 * @param  method
 * @param  url
 * @param  async
 * @param  cache
 * @param  dataType
 * @param  parameters
 * @param  callback
 * @returns void
 */
function doAJAX(method, url, async, cache, dataType, parameters, callback){
    $.ajax({
        type: method,
        url: $('#baseurl').val()+url,
        async: async,
        cache: cache,
        dataType: dataType,
        data: parameters,
        success: function(data) {
            callback(data);
        }
    });
}

/**
 * Load all queue hash to connect to each user queue on ACTIVEMQ
 * @returns {undefined}
 */
function loadQueueUsersInfo(){
    //Load data in normal way
    doAJAX("POST", "Chat/getQueueUsersInfo", true, false, "JSON", {}, function(data){
        _QUEUE_USERS_INFO = data.users;
        _CURRENT_USER = data.current_user.trim();
        
        //Before connection lets check if there's data in sessionStorage
        var session_data_stored = null; 
        //First check if sessionStorage is available
        if (window.sessionStorage) {
            //Retrieve queue users info data
            var queue_users_info = sessionStorage.getItem("queue_users_info");
            //If there's data stored
            if(queue_users_info !== null && queue_users_info.trim() !== ''){
                try{
                    session_data_stored = JSON.parse(queue_users_info);
                }catch(e){}
            }
        }
        //Check if session data is no empty
        var user_selected = "";
        var no_initialize_fields = true;
        if(session_data_stored !== null){
            var users = session_data_stored.users;
            var current_user = session_data_stored.current_user.trim();
            //If users data is not null or undefined 
            //And validate that current user is the same as before unload
            //because the user can logout and then login with another user
            //but the sessionStorage still has the previous user's information
            if(users !== null && current_user !== '' && current_user === _CURRENT_USER){
                //Set global variables with local stored data
                _QUEUE_USERS_INFO = users;
                user_selected = session_data_stored.selected_user.trim();
                no_initialize_fields = false;
            }
        }
        createConnectionWithUsersQueue(no_initialize_fields);
        if(user_selected !== ''){ //If a user was selected, we must load that chat 
            loadAccountChat(user_selected, false);
        }
    });
}

/**
 * Creates STOMP client and creates all subscriptions
 * @param {bool} initializeExtraFields 
 * @returns {undefined}
 */
function createConnectionWithUsersQueue(initializeExtraFields){
    if(window.WebSocket){
        if(_QUEUE_USERS_INFO !== null){
            //Create client
            _STOMP_CLIENT = Stomp.client(_CHAT_WEBSOCKET_URL);
            _STOMP_CLIENT.heartbeat.outgoing = 0; 
            _STOMP_CLIENT.heartbeat.incoming = 0;
            //Debug
            _STOMP_CLIENT.debug = function (str) {
            };
            //Connects to ACTIVEMQ
            _STOMP_CLIENT.connect(_CHAT_WEBSOCKET_USER, _CHAT_WEBSOCKET_PASS, function (frame) {
                _SUCCESSFULL_WEBSOCKET_CONNECTION = true; //Reach connection
                $.each(_QUEUE_USERS_INFO, function(index,value){
                    //Connect to each topic
                    connectToUserQueue(value);
                    //If data is retrieve from local storage, so dont initialize this fields
                    if(initializeExtraFields){
                        //This fields doesnt come in the object retrieve from server
                        //so we add them for each user
                        _QUEUE_USERS_INFO[index].unreadmsgs = 0; //Store unread messages counter
                        _QUEUE_USERS_INFO[index].logged = 'N'; //Store if user is or not logged in
                        _QUEUE_USERS_INFO[index].chat = []; //Store user's chat history
                    }
                });
            });            
        }else{
            console.log("------------------- QUEUE LIST NULL ------------------------");
        }
    }else{
        console.log("------------------- NO WEBSOCKET COMPATIBLE ------------------------");
    }
}

/**
 * Subscribe each user with its topic and set the processin messaging function
 * @param {type} value
 * @returns {undefined}
 */
function connectToUserQueue(value){
    var queueHashDestination = "/topic/"+value.QueueName;
    //Subscribe to topic
    _STOMP_CLIENT.subscribe(queueHashDestination, function (menssage) {
        //This function manages all incoming messages
        processMenssage(JSON.parse(menssage.body));
    });
}

/**
 * Returns an object with topic/queue hash and index
 * @param {type} user
 * @returns {object}
 */
function getSendQueueHashByUserID(user){
    var hash = "";
    var indexToSend = "";
    if(_QUEUE_USERS_INFO !== null && user.trim() !== ""){
        $.each(_QUEUE_USERS_INFO, function(index, value){
            if(value.CustomerID2 === user || value.CustomerID1 === user){
                hash = value.QueueName;
                indexToSend = index;
            }
        });
    }
    return {hash:hash, index:indexToSend};
}

/**
 * Takes all incoming messages and proccess them acording to Action field
 * @param {type} menssage
 * @returns {undefined}
 */
function processMenssage(menssage){ 
    menssage = menssage.results["row1"];
    switch(menssage.Action){
        //An user has log in
        case 'logInCustomer':
            var user = menssage.CustomerID.trim();
            if(user !== _CURRENT_USER){
                addLoggedUser(user);
                //Send message reply, telling that current user is logged in too
                setTimeout(function(){ 
                    var hash = getSendQueueHashByUserID(user).hash;
                    _STOMP_CLIENT.send("/topic/"+hash, {}, JSON.stringify({ "results":{ "row1":{ "Action": "logInCustomerReply","CustomerID": _CURRENT_USER}}}));
                }, 2000);
            }
        break;
        //An user send a login reply
        //Login reply is when a user is notified that "someone" has login, so the user
        //reply a message to "someone" telling that user is login too
        case 'logInCustomerReply':
            //LOGIN USER
            var user = menssage.CustomerID.trim();
            if(user !== _CURRENT_USER){
                addLoggedUser(user);
            }
        break;
        //An user has log out
        case 'logOutCustomer':
            //LOGOUT USER
            var user = menssage.CustomerID.trim();
            if(user !== _CURRENT_USER){
                deleteLoggedUser(user);
            }
           
        break;
        //Receive a normal message for chat
        case 'createNewMessage':
            var user = menssage.TransmitterID.trim();
            if(user !== _CURRENT_USER){
                var index = getSendQueueHashByUserID(user).index;   
                //Store the msg into the user array
                _QUEUE_USERS_INFO[index].chat.push({type:'sender',msg:menssage.Message});
                //Increase amount of unread msgs
                _QUEUE_USERS_INFO[index].unreadmsgs++; 
                
                //If message is for current selected user
                if(_CURRENT_USER_SELECTED === user){
                    rePaintChatHistory(user);
                }
                
                //Refresh unread msgs alert
                refreshUnreadMsgsAlerts();
            }
        break;
    }
}

/**
 * Creates the html for a logged user
 * @param {type} user
 * @returns {String}
 */
function getUserLoggedHTML(user, status){
    var escapedUser = user.replace("/","\\/");
    //_IMG_CHAT_AVATAR is declared in chat.ctp
    return "<div class='row row-chat user-logged-row' onclick='loadAccountChat(\""+user+"\", true)'>"
        +"<div class='col-xs-3'>"
             +_IMG_CHAT_AVATAR
        +"</div>"
        +"<div class='col-xs-9'>"
            +"<div class='row row-chat'>"
                +"<div class='col-xs-12'>"
                     +user
                +"</div>"
            +"</div>"
            +"<div class='row row-chat'>" 
                +"<div class='col-xs-12'>"
                    +getConecctionStatusHTML(status)
                    +"<span id='unread_msgs_alert_user_"+escapedUser+"_container'>"
                        +"<small id='unread_msgs_alert_user_"+escapedUser+"' class='unread-msgs-alert unread-msgs-alert-user'>2</small>"
                    +"</span>"
                +"</div>"
            +"</div>"
        +"</div>"
    +"</div>";
}

/**
 * Creates the html for a logged user that is shown on Dashboard
 * @param {type} user
 * @returns {String}
 */
function getUserLoggedHTMLDashboard(user, status){
    var escapedUser = user.replace("/","\\/");
    //_IMG_CHAT_AVATAR is declared in chat.ctp
    return "<div class='row row-chat user-logged-row' onclick='loadAccountChatDashboard(\""+user+"\", true)'>"
        +"<div class='col-xs-3'>"
             +_IMG_CHAT_AVATAR
        +"</div>"
        +"<div class='col-xs-9'>"
            +"<div class='row row-chat'>"
                +"<div class='col-xs-12'>"
                     +user
                +"</div>"
            +"</div>"
            +"<div class='row row-chat'>" 
                +"<div class='col-xs-12'>"
                    +getConecctionStatusHTML(status)
                    +"<span id='unread_msgs_alert_user_dash_"+escapedUser+"_container'>"
                        +"<small id='unread_msgs_alert_user_dash_"+escapedUser+"' class='unread-msgs-alert unread-msgs-alert-user'>2</small>"
                    +"</span>"
                +"</div>"
            +"</div>"
        +"</div>"
    +"</div>";
}

function getConecctionStatusHTML(status){
    if(status){
        return "<div class='user-logged-status-circle' style='background-color: #1CCA1C;'></div>"
                +"<small class='user-logged-status-text'>ONLINE</small>";
    }else{
        return  "<div class='user-logged-status-circle'></div>"
                +"<small class='user-logged-status-text'>OFFLINE</small>";
    }
}

/**
 * Check if connection with websocket was successfull and remove the 'LOADING' leyend in logged user pane
 * @returns {undefined}
 */
function checkWebsocketSuccessfullConnection(){
    if(_SUCCESSFULL_WEBSOCKET_CONNECTION){   
        refreshLoggedUsersPane();
        clearInterval(_SUCCESS_WEBSOCKET_CONNECTION_INTERVAL);
    }
}

/**
 * Add an user as logged
 * @param {type} user
 * @returns {undefined}
 */
function addLoggedUser(user){
    if($.inArray(user,_LOGGED_USERS) === -1){
        _LOGGED_USERS.push(user);
        
        var index = getSendQueueHashByUserID(user).index;   
        //Set user as logged
        _QUEUE_USERS_INFO[index].logged = 'Y';
        refreshLoggedUsersPane(); 
        refreshUnreadMsgsAlerts();
    }
}

/**
 * Remove an user as logged
 * @param {type} user
 * @returns {undefined}
 */
function deleteLoggedUser(user){
    if($.inArray(user,_LOGGED_USERS) !== -1){
        _LOGGED_USERS = $.grep(_LOGGED_USERS, function(value) {
                            return value !== user;
                        });
        var index = getSendQueueHashByUserID(user).index;   
        //Set user as no logged
        _QUEUE_USERS_INFO[index].logged = 'N';
        refreshLoggedUsersPane();
    }
}

/**
 * Refresh all logged users after an update
 * @returns {undefined}
 */
function refreshLoggedUsersPane(){
    $("#logged_users_container").html("");
    //Check if we're on dashboard
    if(_DASHBOARD_CONTAINER_FLAG){$("#dashboard_logged_users_container").html("");}
    $.each(_QUEUE_USERS_INFO, function(index, value){
        //Retrieve log status
        var status = value.logged.trim() === 'Y' ? true : false;
        //Check user name
        //Due to topics queues, the user can be CustomerID1 or CustomerID2
        var user = value.CustomerID2.trim() === _CURRENT_USER ? value.CustomerID1.trim() : value.CustomerID2.trim();
        //Get html
        var html = getUserLoggedHTML(user, status);
        if(status){
            //If logged send top chat
            $("#logged_users_container").prepend(html);
        }else{
            //If no logged send bottom chat
            $("#logged_users_container").append(html);
        }

        //Check if we're on dashboard and user is logged
        if(_DASHBOARD_CONTAINER_FLAG && status){
            var htmlDash = getUserLoggedHTMLDashboard(user, status);
            $("#dashboard_logged_users_container").append(htmlDash);
        }                
    });
}

/**
 * Send a logout signal to all subscriptions
 * @returns {undefined}
 */
function logoutUser(){
    if(_LOGGED_USERS.length > 0){
        $.each(_LOGGED_USERS, function(index, value){
            var hash = getSendQueueHashByUserID(value).hash;
            _STOMP_CLIENT.send("/topic/"+hash, {}, JSON.stringify({ "results":{ "row1":{ "Action": "logOutCustomer","CustomerID": _CURRENT_USER}}}));
        });
    }
    //Save data
    sessionStorage.setItem("queue_users_info", JSON.stringify({users:_QUEUE_USERS_INFO,current_user:_CURRENT_USER,selected_user:_CURRENT_USER_SELECTED}));
}

/**
 * Send a login signal to all subscriptions
 * @returns {undefined}
 */
function refreshLoggedUsers(){
    if(_LOGGED_USERS.length > 0){
        $.each(_LOGGED_USERS, function(index, value){
            var hash = getSendQueueHashByUserID(value).hash;
            _STOMP_CLIENT.send("/topic/"+hash, {}, JSON.stringify({ "results":{ "row1":{ "Action": "logInCustomer","CustomerID": _CURRENT_USER}}}));
        });
    }
}

/**
 * Re paint all user chat history store in each user chat object in _QUEUE_USERS_INFO
 * @param {type} user
 * @returns {undefined}
 */
function rePaintChatHistory(user){
    //Prints chat on window
    var index = getSendQueueHashByUserID(user).index;   
    var msgs = _QUEUE_USERS_INFO[index].chat;
    $("#chat_messages_container").html(""); //Reset container
    $.each(msgs, function(index,value){
        $("#chat_messages_container").append(msgToHTML(value.msg, value.type));
    }); 
    scrollDownChat();
}

/**
 * Refresh all unread messages alerts, menu, each user and dashboard
 * @returns {undefined}
 */
function refreshUnreadMsgsAlerts(){
    var totalUnreadMsgs = 0;
    $.each(_QUEUE_USERS_INFO, function(index, value){
        var unreadMsgs = value.unreadmsgs;
        var user = value.CustomerID2.trim() === _CURRENT_USER ? value.CustomerID1.trim() : value.CustomerID2.trim();
        var escapedUser = user.replace("/","\\/");
        if(unreadMsgs > 0){ //There're unread msgs
            $("#unread_msgs_alert_user_"+escapedUser).html(unreadMsgs);
            $("#unread_msgs_alert_user_"+escapedUser).css('display','block');
            if(_DASHBOARD_CONTAINER_FLAG){
                $("#unread_msgs_alert_user_dash_"+escapedUser).html(unreadMsgs);
                $("#unread_msgs_alert_user_dash_"+escapedUser).css('display','block');
            }
        }else{ //No unread msgs
            $("#unread_msgs_alert_user_"+escapedUser).html("0");
            $("#unread_msgs_alert_user_"+escapedUser).css('display','none');
            if(_DASHBOARD_CONTAINER_FLAG){
                $("#unread_msgs_alert_user_dash_"+escapedUser).html("0");
                $("#unread_msgs_alert_user_dash_"+escapedUser).css('display','none');
            }
        }       
        totalUnreadMsgs += unreadMsgs;
    });
    //Update no read msgs alert on left menu chat's button
    if(totalUnreadMsgs>0){
        $("#unread_msgs_alert").html(totalUnreadMsgs);
        $("#unread_msgs_alert").css('display','inline');
        $("#unread_msgs_alert_container").css('display','inline');
        if(_DASHBOARD_CONTAINER_FLAG){
            $("#unread_msgs_alert_dash").html(totalUnreadMsgs);
            $("#unread_msgs_alert_dash").css('display','inline');
            $("#unread_msgs_alert_container_dash").css('display','inline');
        }
    }else{
        $("#unread_msgs_alert").html(0);
        $("#unread_msgs_alert").css('display','none');
        $("#unread_msgs_alert_container").css('display','none');
        if(_DASHBOARD_CONTAINER_FLAG){
            $("#unread_msgs_alert_dash").html(0);
            $("#unread_msgs_alert_dash").css('display','none');
            $("#unread_msgs_alert_container_dash").css('display','none');
        }
    }
}

/**
 * Reset to zero all unread messages from one user
 * @param {type} user
 * @returns {undefined}
 */
function resetUserUnreadMsgs(user){
    //Refresh unread msgs
    var index = getSendQueueHashByUserID(user).index;   
    //Delete amount of unread msgs
    _QUEUE_USERS_INFO[index].unreadmsgs = 0; 
    refreshUnreadMsgsAlerts();
}

/**
 * Display an alert in chat cointainer that user is no logged in
 * @returns {undefined}
 */
function displayNoLoggedUserAlert(){
    //Animate no logged user alert
    $("#no_logged_user_alert").effect( 'fade', {}, 1000 );
    $("#no_logged_user_alert").animate({ opacity: 0.2 }, 1200, 'linear')
            .animate({ opacity: 1 }, 1200, 'linear')
    .animate({ opacity: 0.2 }, 1200, 'linear')
            .animate({ opacity: 1 }, 1200, 'linear');
    setTimeout(function(){$("#no_logged_user_alert").effect( 'fade', {}, 1000 );},5000); 
}

/**
 * Open the chat's windows with the user selected from dashboard window
 * @param {type} user
 * @param {type} noOpenedAtStart
 * @returns {undefined}
 */
function loadAccountChatDashboard(user, noOpenedAtStart){
    //Open chat window
    $( "#chat_window_container" ).css('display','block');
    document.cookie = "chat_autoload=1";
    //Somes times the interact.js override the html's cursor
    //so we change it againg to auto
    $("html").css('cursor','auto');
    //Load users chat
    loadAccountChat(user, noOpenedAtStart);
}

/**
 * Load more messages in chat history
 * @returns {undefined}
 */
function loadMoreMessages(){
    //User cannot be empty
    if(_CURRENT_USER_SELECTED.trim() !== ''){
        //Avoid to call ajax several times, wait until new messages has been loaded
        if(!_LOADING_MORE_MESSAGES){
            _LOADING_MORE_MESSAGES = true;
            //Get index of user in _QUEUE_USERS_INFO
            var index = getSendQueueHashByUserID(_CURRENT_USER_SELECTED).index;   
            //Retrieve _CURRENT_USER_SELECTED's chat
            var chat = _QUEUE_USERS_INFO[index].chat; 
            //Get the number where start to retrieve message
            var start = chat.length;
            //Get the number of last message to retrieve
            var end = start + _AMOUNT_MESSAGES_LOAD_MORE;
            //Create object with params to be sent via AJAX
            var parameters = {receiver:_CURRENT_USER_SELECTED,since:start,until:end};
            //Do AJAX
            doAJAX("POST", "chat/getChatHistory", true, false, "JSON", parameters, function(data){
                //If it was successfully retrieved 
                if(data.status.trim() === 'success'){
                    var msgs = data.response;
                    //Take each message and add it to _CURRENT_USER_SELECTED's chat
                    $.each(msgs, function(key,value){
                        var msgType = value.ChatTransmitter.trim() === _CURRENT_USER ? 'receiver' : 'sender';
                        //Store the msg (At beggining) into the user array
                        _QUEUE_USERS_INFO[index].chat.unshift({type:msgType,msg:value.Message.trim()});
                    });
                    //Refresh chat window
                    rePaintChatHistory(_CURRENT_USER_SELECTED);
                }
                //When finish set this to false, so user can continue load more messages
                _LOADING_MORE_MESSAGES = false;
            });
        }
    }
}

