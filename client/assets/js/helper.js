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

var helper = Object();
helper.pad_left     = function(str,pad){
    return pad.substring(0,pad.length-str.length)+str;
};
helper.pad_right    = function(str,pad){
    return str+pad.substring(0,pad.length-str.length);
};
helper.str2bin      = function(str){
    var len = str.length,re = '';
    for(var i = 0;i < len;i++){
        re += helper.pad_left(str[i].charCodeAt(0).toString(2),'00000000');
    }
    return re;
};
helper.bin2str      = function(bin){
    var len = bin.length,re = '';
    for(var i = 0;i < len;i += 8){
        re += String.fromCharCode(parseInt(bin.substr(i,8),2));
    }
    return re;
};
helper.str2hex      = function(str){
    var len = str.length,re = '';
    for(var i = 0;i < len;i++){
        re += helper.pad_left(str[i].charCodeAt(0).toString(16),'00')+' ';
    }
    return re;
};