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
var xzdb  = function(){
    var database= Object();
    var _return = Object();
    var manager = function(db){
        if(database[db] === undefined){
            database[db]    = Object();
        }
        var r   = Object;
        r.mkFiled   = function(filed){
            database[db][filed] = Object();
        };
        r.set   = function(field,key,value){
            database[db][field][key]    = value;
        };
        r.get   = function(key,value){
            var fields  = Object.keys(database[db]),
                len     = keys.length,
                re      = Object,
                field,
                i;
            if(value === undefined){
                if(typeof(key) == 'function'){
                    for(i = 0;i < len;i++){
                        field = fields[i];
                        if(key(database[db][field]) === true){
                            re[i]   = database[db][field];
                        }
                    }
                }else {
                    if(database[db][key] !== undefined){
                        return database[db][key];
                    }
                }
                return re;
            }else{
                for(i = 0;i < len;i++){
                    field = fields[i];
                    if(database[db][field][key] === value){
                        re[i]   = database[db][field];
                    }
                }
                return re;
            }
        };
        r.del   = function(key,value){
            var fields  = Object.keys(database[db]),
                len     = fields.length,
                field,
                i,re    = 0;
            if(value === undefined){
                if(typeof(key) == 'function'){
                    for(i = 0;i < len;i++){
                        field = fields[i];
                        if(key(database[db][field]) === true){
                            delete database[db][field];
                            re++;
                        }
                    }
                }else {
                    if(database[db][key] !== undefined){
                        delete database[db][key];
                        re++;
                    }
                }
                return re;
            }else{
                for(i = 0;i < len;i++){
                    field = fields[i];
                    if(database[db][field][key] === value){
                        delete database[db][field];
                        re++;
                    }
                }
                return re;
            }
        };
        r.where     = function(expression){
            var keys    = Object.keys(database[db]),
                len     = keys.length,
                d       = [],
                re      = Object(),
                i;
            for(i = 0;i < len;i++){
                if(expression(database[db][keys[i]]) === true){
                    d.push(keys[i]);
                }
            }
            re.delete   = function(){
                len = d.length;
                for(i = 0;i < len;i++){
                    delete database[db][d[i]];
                    delete d[i];
                }
                return re;
            };
            re.set      = function(key,value){
                len = d.length;
                for(i = 0;i < len;i++){
                    database[db][d[i]][key] = value;
                }
                return re;
            };
            re.get      = function(){
                var s = Object();
                len = d.length;
                for(i = 0;i < len;i++){
                    s[i] = database[db][d[i]];
                }
                return s;
            };
            return re;
        };
        return r;
    };
    _return.create   = function(name){
        return manager(name);
    };
    _return.delete   = function(name){
        delete db[name];
    };
    _return.toObj   = function () {
        return database;
    };
    return _return;
};