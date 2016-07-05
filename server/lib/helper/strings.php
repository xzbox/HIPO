<?php
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
namespace lib\helper;

/**
 * Class strings
 * @package lib\helper
 */
class strings{
    /**
     * addslashes_dq:Special addslashes for double quote strings.
     * @param $string
     * @return string
     */
    public static function addslashes_dq($string){
        return addcslashes($string,'"\\');
    }

    /**
     * addslashes_sq:special addslashes for double single strings.
     * @param $string
     * @return string
     */
    public static function addslashes_sq($string){
        return addcslashes($string,'\'\\');
    }

    /**
     * Convert strings to binary
     * @param $str
     *
     * @return string
     */
    public static function str2bin($str){
        $len    = strlen($str);
        $re     = '';
        for($i  = 0;$i < $len;$i++){
            $re.= str_pad(decbin(ord($str[$i])),8,'0',STR_PAD_LEFT);
        }
        return $re;
    }

    /**
     * Convert binary to string
     * @param $bin
     *
     * @return string
     */
    public static function bin2str($bin){
        $bin    = str_split($bin,8);
        $count  = count($bin);
        $re     = '';
        for($i  = 0;$i < $count;$i++){
            $re.= chr(bindec($bin[$i]));
        }
        return $re;
    }
}