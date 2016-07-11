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
    open.onupgradeneeded    = function(){
        var db      = open.result;
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
    };
    publicFunctions.set     = function(key,value){

    };
    publicFunctions.get     = function(key){

    };
    publicFunctions.del     = function(key){

    };
    publicFunctions.isset   = function (key) {

    };
    publicFunctions.incr    = function(key){

    };
    publicFunctions.incrBy  = function(key,value){

    };
    return publicFunctions;
})(document,window);