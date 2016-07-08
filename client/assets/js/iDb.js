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
 *                       Created by AliReza Ghadimi                          *
 *     <http://AliRezaGhadimi.ir>    LO-VE    <AliRezaGhadimy@Gmail.com>     *
 *****************************************************************************/
/**
 * iDb.js
 *  Very simple javascript library to work with localStorage as an indexedDB (key-value store)
 */
var iDb = Object();
/**
 *
 * @param filter
 * @param n
 * @param replace
 * @returns {Array}
 */
iDb.keys = function (filter,n,replace){
    if(n === undefined){
        n = 0;
    }
    if(replace === undefined){
        replace = true;
    }
    if(replace){
        filter  = filter.replace('\\','\\\\');
    }
    var len     = localStorage.length;
    var regex   = new RegExp('^'+filter+'$');
    var re      = [];
    var k       = 0;
    var tmp     = '';
    for(var i = 0;i < len;i++){
        if(regex.test(localStorage.key(i))){
            tmp     = regex.exec(localStorage.key(i));
            re[k++] = tmp[n];
        }
    }
    return re;
};
/**
 *
 * @param name
 */
iDb.get = function (name){
    return localStorage.getItem(name);
};
/**
 *
 * @param name
 * @param value
 */
iDb.set = function (name,value){
    if(iDb.numberRegex.test(value)){
        value = parseInt(value);
    }
    template.set(name,value);
    return localStorage.setItem(name,value);
};
/**
 *
 * @returns {number}
 */
iDb.length = function(){
    return localStorage.length;
};
iDb.isset   = function(name){
    return iDb.keys(name).length !== 0;
};
/**
 *
 * @param name
 */
iDb.incr = function(name){
    if(!iDb.isset(name)){
        iDb.set(name,0);
    }
    return iDb.set(name,parseInt(iDb.get(name))+1);
};
/**
 *
 * @param name
 * @param value
 */
iDb.incrby = function(name,value){
    if(!iDb.isset(name)){
        iDb.set(name,0);
    }
    return iDb.set(name,parseInt(iDb.get(name))+value);
};
/**
 *
 * @param object
 * @param prefix
 */
iDb.set_object = function(object,prefix){
    if(prefix === undefined){
        prefix = '';
    }
    for(var key in object){
        var val = object[key];
        if(typeof(val) == 'object'){
            iDb.set_object(val,prefix+key+'.');
        }else {
            iDb.set(prefix+key,val);
        }
    }
};
/**
 *
 * @param json
 * @constructor
 */
iDb.SET_JSON = function(json){
    var object = JSON.parse(json);
    iDb.set_object(object);
};
/**
 *
 * @param number
 * @returns {string}
 */
iDb.key     = function(number){
    return localStorage.key(number);
};
/**
 *
 * @returns {Storage}
 */
iDb.array   = function(){
    return localStorage;
};
iDb.numberRegex = new RegExp('^[0-9]+$');
iDb.vue     = function(){
    var keys = iDb.keys('.+');
    var val;
    for(var key in keys){
        key = iDb.key(key);
        val = iDb.get(key);
        if(iDb.numberRegex.test(val)){
            val = parseInt(val);
        }
        template.set(key,val);
    }
};
/**
 * Remove special key from local storage
 * @param key
 */
iDb.unset   = function(key){
    localStorage.removeItem(key);
};
/**
 * Alias for iDb.unset
 * @type {iDb.unset|*}
 */
iDb.del     = function(key){
    iDb.unset(key);
};