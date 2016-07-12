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
var xdb = (function(document,window){
    var publicFunctions     = Object();
    var indexDb             = window.indexedDB || window.mozIndexedDB || window.webkitIndexedDB || window.msIndexedDB || window.shimIndexedDB;
    var dbName              = 'WebSocket_'+appName;
    var open                = indexDb.open(dbName,1);
    var db                  = null;
    var usersTx,usersStore,usersIndex,
        contestsTx,contestsStore,contestsIndex,
        questionsTx,questionsStore,questionsIndex,
        logTx,logStore,logIndex,
        messagesTx,messagesStore,messagesIndex,
        langsTx,langsStore,langsIndex;
    open.onupgradeneeded    = function(){
        db      = open.result;
        var store;
        var index;
        store       = db.createObjectStore('users',{keyPath: "id"});
        store.createIndex("email", "email", { unique: false });
        store.createIndex("age", "age", { unique: false });
        store.createIndex("fname", "fname", { unique: false });
        store.createIndex("lname", "lname", { unique: false });
        store.createIndex("score", "score", { unique: false });
        store.createIndex("tSends", "tSends", { unique: false });
        store.createIndex("wSends", "wSends", { unique: false });
        store.createIndex("bio", "bio", { unique: false });
        store.createIndex("username", "username", { unique: true });

        store       = db.createObjectStore('contests',{keyPath: "id"});
        store.createIndex("name", "name", { unique: true });
        store.createIndex("level", "level", { unique: false });
        store.createIndex("start", "start", { unique: false });
        store.createIndex("end", "end", { unique: false });

        store       = db.createObjectStore('questions',{keyPath: "id"});
        store.createIndex("name", "name", { unique: false });
        store.createIndex("level", "level", { unique: false });
        store.createIndex("content", "content", { unique: false });
        store.createIndex("si", "si", { unique: false });
        store.createIndex("so", "so", { unique: false });
        store.createIndex("contest", "contest", { unique: false });

        store       = db.createObjectStore('log',{keyPath: "id"});
        store.createIndex("time", "time", { unique: false });
        store.createIndex("question", "question", { unique: false });
        store.createIndex("user", "user", { unique: false });
        store.createIndex("tof", "tof", { unique: false });
        store.createIndex("lang", "lang", { unique: false });

        store       = db.createObjectStore('messages',{keyPath: "id"});
        store.createIndex("title", "title", { unique: false });
        store.createIndex("tag", "tag", { unique: false });
        store.createIndex("message", "message", { unique: false });
        store.createIndex("contest", "contest", { unique: false });
        store.createIndex("question", "question", { unique: false });

        store       = db.createObjectStore('langs',{keyPath: "id"});
        store.createIndex('key','key',{unique:true});
        store.createIndex('value','value',{unique:false});

        if(debug){
            console.log('Database upgraded successfully.')
        }
    };
    open.onsuccess          = function(){
        db          = open.result;
        usersTx     = db.transaction('users','readwrite');
        contestsTx  = db.transaction('contests','readwrite');
        questionsTx = db.transaction('questions','readwrite');
        logTx       = db.transaction('log','readwrite');
        messagesTx  = db.transaction('messages','readwrite');
        langsTx     = db.transaction('langs','readwrite');

        usersStore      = usersTx.objectStore('users');
        contestsStore   = contestsTx.objectStore('contests');
        questionsStore  = questionsTx.objectStotre('questions');
        logStore        = logTx.objectStore('log');
        messagesStore   = messagesTx.objectStore('messages');
        langsStore      = langsTx.objectStore('langs');

        usersIndex      = usersStore.index('username');
        contestsIndex   = contestsIndex.index('name');
        questionsIndex  = questionsStore;
        logIndex        = logStore;
        messagesStore   = messagesIndex;
        langsStore      = langsIndex.index('key');

        if(debug){
            console.log('Database opened successfully.');
        }
    };
    publicFunctions.users           = Object();
    publicFunctions.users.new       = function(username,email,age,fname,lname,score,tSends,wSends,bio){
        var event = usersStore.put({
            'username':username,
            'email':email,
            'age':age,
            'fname':fname,
            'lname':lname,
            'score':score,
            'tSends':tSends,
            'wSends':wSends,
            'bio':bio
        });
        var re   = Object();
        re.onEnd = function (func) {
            event.onsuccess(func);
        };
        return re;
    };
    publicFunctions.users.set       = function(username,key,value){
        var event = usersStore.put({
            'username':username,
            key:value
        });
        var re   = Object();
        re.onEnd = function (func) {
            event.onsuccess(func);
        };
        return re;
    };
    publicFunctions.users.get       = function(username){

    };
    publicFunctions.users.getById   = function(id){

    };
    publicFunctions.users.list      = function(){

    };
    publicFunctions.users.del       = function(usernaem){

    };
    publicFunctions.users.delById   = function(id){

    };

    publicFunctions.contests        = Object();
    publicFunctions.contests.new    = function(){

    };
    publicFunctions.contests.set    = function(key,value){

    };
    publicFunctions.contests.get    = function(name){

    };
    publicFunctions.contests.getById= function(id){

    };
    publicFunctions.contests.list   = function(){

    };
    publicFunctions.contests.del    = function(name){

    };
    publicFunctions.contests.delById= function(id){

    };

    publicFunctions.questions       = Object();
    publicFunctions.questions.new   = function(){

    };
    publicFunctions.questions.set   = function(key,value){

    };
    publicFunctions.questions.get   = function(id){

    };
    publicFunctions.questions.del   = function(id){

    };

    publicFunctions.log             = Object();
    publicFunctions.log.new         = function(){

    };
    publicFunctions.log.set         = function(key,vlaue){

    };
    publicFunctions.log.get         = function(id){

    };
    publicFunctions.log.del         = function(id){

    };
    publicFunctions.log.list        = function(){

    };

    publicFunctions.message         = Object();
    publicFunctions.message.new     = function(){

    };
    publicFunctions.message.set     = function(key,value){

    };
    publicFunctions.message.get     = function(id){

    };
    publicFunctions.message.del     = function(id){

    };
    publicFunctions.message.list    = function(){

    };

    publicFunctions.langs           = Object();
    publicFunctions.langs.set       = function(key,value){

    };
    publicFunctions.langs.get       = function(key) {

    };
    publicFunctions.langs.del       = function(key){

    };
    return publicFunctions;
})(document,window);