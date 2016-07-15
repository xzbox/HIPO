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
var iDb    = (function(){
    var iDb_DB  = Object();
    var numberRegex = new RegExp('^[0-9]+$');
    return {
        /**
         *
         * @param filter
         * @param n
         * @param replace
         * @returns {Array}
         */
        keys: function(filter,n,replace){
            if(n === undefined){
                n = 0;
            }
            if(replace === undefined){
                replace = true;
            }
            if(replace){
                filter  = filter.replace('\\','\\\\');
            }
            var len     = iDb_DB.length,
                keys    = Object.keys(iDb_DB),
                regex   = new RegExp('^'+filter+'$'),
                re      = [],
                k       = 0,
                tmp     = '';
            for(var i = 0;i < len;i++){
                if(regex.test(iDb_DB[keys[i]])){
                    tmp     = regex.exec(iDb_DB[keys[i]]);
                    re[k++] = tmp[n];
                }
            }
            return re;
        },
        /**
         *
         * @param key
         * @returns {*}
         */
        get: function(key){
            return iDb_DB[key];
        },
        /**
         *
         * @param key
         * @param value
         * @returns {*}
         */
        set: function(key,value){
            if(numberRegex.test(value)){
                value = parseInt(value);
            }
            template.set(key,value);
            return iDb_DB[key]  = value;
        },
        /**
         *
         * @returns {*}
         */
        length: function(){
            return iDb_DB.length;
        },
        /**
         *
         * @param key
         * @returns {boolean}
         */
        isset: function(key){
            return iDb_DB[key] !== undefined;
        },
        /**
         *
         * @param key
         * @returns {number}
         */
        incr: function(key){
            if(iDb_DB[key] === undefined || !numberRegex.test(iDb_DB[key])){
                iDb_DB[key] = 1;
                return 1;
            }
            return (++iDb_DB[key]);
        },
        /**
         *
         * @param key
         * @param number
         * @returns {*}
         */
        incrBy: function(key,number){
            if(iDb_DB[key] === undefined || !numberRegex.test(iDb_DB[key])){
                iDb_DB[key] = number;
                return number;
            }
            iDb_DB[key] += number;
            return iDb_DB[key];
        },
        /**
         *
         * @param obj
         * @param prefix
         */
        set_object: function(obj,prefix){
            if(prefix === undefined){
                prefix = '';
            }
            for(var key in obj){
                var val = obj[key];
                if(typeof(val) == 'object'){
                    iDb.set_object(val,prefix+key+'.');
                }else {
                    iDb.set(prefix+key,val);
                }
            }
        },
        /**
         *
         * @param json
         */
        set_json: function(json){
            iDb.set_object(JSON.parse(json));
        },
        /**
         *
         * @param i
         * @returns {*}
         */
        key: function(i){
            var keys = Object.keys(iDb_DB);
            return keys[i];
        },
        /**
         *
         * @returns {*}
         */
        array: function(){
            return iDb_DB;
        },
        /**
         * Send fields to vue.js (template library)
         */
        vue: function(){
            var keys = Object.keys(iDb_DB);
            for(var key in keys){
                template.set(key,iDb_DB[key]);
            }
        },
        /**
         * Remove special key
         * @param key
         */
        unset: function(key){
            delete iDb_DB[key];
        },
        /**
         * Same as unset
         * @see iDb.unset
         * @param key
         */
        del: function(key){
            delete iDb_DB[key];
        },
        /**
         * Reset database
         */
        reset: function(){
            iDb_DB  = Object();
        }
    };
})();