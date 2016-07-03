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
    var r           = /(\w*)\/*([\w]*)/;
    page            = r.exec(page);
    api.urlInput    = page[2];
    page            = page[1];
    if(debug){
        console.log("Request Page:"+page);
    }
    var key = 'template_page_pages\\'+page;
    if(iDb.keys(key).length == 0){
        /**
         * Handel 404 error
         */
        if(iDb.keys('template_page_pages\\er404').length == 0){
            api.pageName    = '404';
            template.load("<h1>404!</h1>")
        }else{
            api.pageName    = "template_page_pages\\er404";
            template.load(iDb.get("template_page_pages\\err404"));
        }
    }else{
        api.send('#closed:pages\\'+api.pageName);
        api.send('#open:pages\\'+page);
        api.pageName    = page;
        template.load(template.make(page));
    }
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
    el.text(value);
    if(time !== undefined){
        setTimeout(function(){
            el.text('');
        },time);
    }
};
api.show404 = function(){
    api.requestPage('er404');
};
window.onhashchange = function(){
    api.requestPage(location.hash.substr(1));
};
var ws_hash         = 'main';
function ws_connect(){
    api.status('Connecting...');
    /**
     * TODO: Remove this 4 lines after fix iDb;
     */
    var sessionId = localStorage.sessionId;
    localStorage.clear();
    localStorage.sessionId  = sessionId;
    location.hash           = '';

    var url = "ws://"+host+":"+port+"/sessionId="+localStorage.sessionId+"&lang="+localStorage.lang+"&md5="+localStorage.getItem('templateHash');
    ws = new WebSocket(url);
    ws.onclose  = function(){
        ws_hash                 = location.hash;
        api.status('Connection closed!',1000);
        var time = 2;
        setInterval(function(){
            if(time > 0){
                api.status('Reconnecting in '+time+'s');
                time--;
            }
        },1000);
        ws  = null;
        setTimeout('ws_connect()',3000);
    };
    ws.onerror  = function(){
        ws  = null;
    };
    ws.onopen = function(){
        api.status('CONNECTED!',1000);
        if(debug){
            console.log("CONNECTED TO:"+url)
        }
        ws = encryptionSocket(ws);
        //Controller
        ws.onmessage = function(msg){
            eval(msg);
        };
        if(location.hash == ''){
            location.hash = ws_hash;
        }else {
            window.onhashchange();
        }
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