/*****************************************************************************
 *         In the name of God the Most Beneficent the Most Merciful          *
 *___________________________________________________________________________*
 *   This program is free software: you can redistribute it and/or modify    *
 *   it under the terms of the GNU General Public License as published by    *
 *   the Free Software Foundation, either version 3 of the License, or       *
 *   (at your option) any later version.                                     *
 *___________________________________________________________________________*
 *   This program is distributed in the hope that it will be useful,         *
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of          *
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           *
 *   GNU General Public License for more details.                            *
 *___________________________________________________________________________*
 *   You should have received a copy of the GNU General Public License       *
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.   *
 *___________________________________________________________________________*
 *                             Created by  Qti3e                             *
 *        <http://Qti3e.Github.io>    LO-VE    <Qti3eQti3e@Gmail.com>        *
 *****************************************************************************/

var _title = document.createElement('title');
_title.text = appName;
document.getElementsByTagName('head')[0].appendChild(_title);
var ws;
var encryptionSocket = function(webSocket){
    var obj = Object();
    obj.onmessage = webSocket.onmessage;
    obj.send = function(msg){
        //TODO:Encrypt Data to send with RSA
        webSocket.send(msg);
        if(debug){
            console.log("SEND:"+msg);
        }
    };
    webSocket.onmessage = function(msg){
        //TODO:Decrypt Received Message with RSA
        msg = msg.data;
        if(debug){
            console.log("RECEIVED:"+msg);
        }
        obj.onmessage(msg);
    };
    return obj;
};
/**
 * As you saw in line 'eval(msg);' we run all commands that
 *  server sent for us.
 *  This object helps to manage the page more easily.
 *  For example when a PHP page want's to change the title
 *  it can send a short message like api.ChangeTitle('Hello World!')
 */
var api = Object();
/**
 * Change the page title
 * @param newTitle
 * @constructor
 */
api.ChangeTitle = function(newTitle){
    document.title = newTitle;
};
/**
 * This function has to set user's session id
 * @param newSessionId
 */
api.setSessionId = function(newSessionId){
    localStorage.sessionId = newSessionId;
};
/**
 * name of page
 * @type {string}
 */
api.pageName     = '';
/**
 *
 * @type {string}
 */
api.urlInput     = '';
/**
 * This is the main urls controller function that request pages from the server
 * Note:All of the templates are loaded in the first and this function only insert
 *      pages into the body ☺
 * @param page
 * Lik name
 */
api.requestPage = function(page){
    if(debug){
        console.log("Request Page:"+page);
        console.log("caller is " + arguments.callee.caller.toString());
    }
    api.send('#closed:'+api.pageName);
    api.send('#open:'+page);
    api.pageName    = page;
    template.make(page,true);
    sidebar.$set('page_name',api.pageName);
};
/**
 * Use this function for request pages in your templates like:
 * Wrong:
 * <a href='http://apppach/app.html#pages\test'>Click me to open another page</a>
 * Right:
 * <a href='#pages\test'>Click me to open another page</a>
 * <a onclick='api.open("test")'>Click me to open another page</a>
 * @param name
 * name is related to page's name
 */
api.open        = function(name){
    location.hash = name;
};
/**
 * @param message
 * @returns {*}
 */
api.send        = function(message){
    return ws.send(message);
};
/**
 * Send some command to server in JSON format
 * $ in the first of each message means message
 * is in JSON format
 * @param name
 * @param data
 */
api.sendCommand = function(name,data){
    return api.send("$"+JSON.stringify({
        command:name,
        data:data
    }));
};
/**
 *
 * @param value
 * @param time
 * @returns {*}
 */
api.status  = function(value,time){
    var el  = $("#status");
    if(value === undefined){
        return el.text();
    }
    el.show().html(value);
    if(time !== undefined){
        setTimeout(function(){
            el.hide();
        },time);
    }
};
/**
 *
 * @returns {boolean}
 */
api.isConnected = function () {
    return api.status() == 'CONNECTED!';
};
api.show404 = function(){
    api.requestPage('er404');
};
window.onhashchange = function(){
    var _p = location.hash.substr(1);
    if(api.isConnected() && iDb.isset('role') && api.pageName !== _p){
        api.requestPage(_p);
    }
};
var percent = Object();
percent.el  = $('.percent');
percent.set = function (p) {
    if(p > 100){
        p = 100;
    }
    if(0 < p && p <= 1){
        p *= 100;
    }
    percent.el.stop().animate({width:p+'%'},1000);
    if(p == 100){
        setTimeout(function(){
            percent.el.stop().css('width',0);
        },1000);
    }
};
percent.hide    = function(){
    percent.el.css('width',0);
};
var reconnect_time  = 0;
var ws_hash         = (location.hash == '' || location.hash == '#') ? '#main' : location.hash;
var _time;
api.tryNow        = function(){
    _time = -1;
    reconnect_time = 0;
};
function ws_connect(){
    api.status('Connecting...');
    /**
     * TODO: Remove this 4 lines after fix iDb;
     */
    var sessionId = localStorage.sessionId;
    localStorage.clear();
    localStorage.sessionId  = sessionId;
    location.hash           = '';

    var url = "ws://"+host+":"+port+"/sessionId="+localStorage.sessionId;
    ws = new WebSocket(url);
    ws.onclose  = function(){
        api.status('Connection closed!',1000);
        reconnect_time += reconnect_after;
        _time = reconnect_time;
        var timerId = setInterval(function(){
            if(_time > -1){
                api.status('Reconnecting in '+_time+'s <a href="javascript:api.tryNow();">Try now...</a>');
                percent.set((reconnect_time - _time) / reconnect_time);
                _time--;
            }
            if(_time == -1){
                ws_connect();
                clearInterval(timerId);
            }
        },1000);
        ws  = null;
    };
    ws.onerror  = function(){
        ws  = null;
    };
    ws.onopen = function(){
        percent.set(100);
        api.status('CONNECTED!',1000);
        if(debug){
            console.log("CONNECTED TO:"+url)
        }
        ws = encryptionSocket(ws);
        //Controller
        ws.onmessage = function(msg){
            var controller  = msg.substr(0,1);
            var body        = msg.substr(1);
            switch (controller){
                case '$':
                    eval(body);
                    break;
                case 'i':
                    hipo.parse(body);
                    break;
                default:
                    /**
                     * When message is not in a correct format so it's a bug and
                     * here we log them to see this bugs and then debug the code
                     * Log them for see bugs
                     */
                    console.log(msg+': hex :'+helper.str2hex(msg));
            }
        };
        location.hash = ws_hash;
        window.onhashchange();
    };
}
$(document).ready(function(){
    ws_connect();
});

/**
 * Didn't understand any thing?
 * I'm so sorry because I'm a dirty coder
 * but you can only read it again and one
 * more thing, read it again with LOVE♥
 */