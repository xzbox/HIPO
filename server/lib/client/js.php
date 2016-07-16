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
namespace lib\client;
use lib\helper\strings;
use lib\network\Socket;

/**
 * Class js
 * @package lib\client
 */
class js{
    /**
     * @var Socket
     */
    private static $socket;

    /**
     * @param Socket $socket
     */
    public static function load($socket){
        self::$socket = $socket;
    }

    //TODO:Array args
    /**
     * @param       $name
     * @param array $args
     *
     * @return string
     */
    public static function jsFunc($name,$args = []){
        $count   = count($args);
        $argStr  = '';
        for($i = 0;$i < $count;$i++){
            $argStr .= ',"'.strings::addslashes_dq($args[$i]).'"';
        }
        $code    = $name.'('.substr($argStr,1,strlen($argStr)).');';
        return '$'.$code;
    }

    /**
     * @param       $user
     * @param       $name
     * @param array $args
     *
     * @return int
     */
    public static function doFunc($user,$name,$args = []){
        sender::ByUser($user,self::jsFunc($name,$args));
        return 1;
    }

    /**
     * @param $name
     * @param $value
     *
     * @return string
     */
    public static function equal($name,$value){
        return '$'.$name.' = "'.strings::addslashes_dq($value).'";';
    }

    /**
     * Remove language strings from localStorage
     * @param $user
     *
     * @return void
     */
    public static function removeLang($user){
        sender::ByUser($user,'r');
    }

/*    public static function console(){
        $re = new \stdClass();
        $re->assert = function(){
            return self::jsFunc('console.assert',func_get_args());
        };
        $re->clear  = function(){
            return self::jsFunc('console.clear',func_get_args());
        };
        $re->constructor = function(){
            return self::jsFunc('console.constructor',func_get_args());
        };
        $re->count  = function(){
            return self::jsFunc('console.count',func_get_args());
        };
        $re->debug  = function(){
            return self::jsFunc('console.debug',func_get_args());
        };
        $re->dir  = function(){
            return self::jsFunc('console.dir',func_get_args());
        };
        $re->dirxml  = function(){
            return self::jsFunc('console.dirxml',func_get_args());
        };
        $re->error  = function(){
            return self::jsFunc('console.error',func_get_args());
        };
        $re->group  = function(){
            return self::jsFunc('console.group',func_get_args());
        };
        $re->groupCollapsed  = function(){
            return self::jsFunc('console.groupCollapsed',func_get_args());
        };
        $re->groupEnd  = function(){
            return self::jsFunc('console.groupEnd',func_get_args());
        };
        $re->hasOwnProperty  = function(){
            return self::jsFunc('console.hasOwnProperty',func_get_args());
        };
        $re->info  = function(){
            return self::jsFunc('console.info',func_get_args());
        };
        $re->isPropertyOf  = function(){
            return self::jsFunc('console.isPropertyOf',func_get_args());
        };
        $re->log  = function(){
            return self::jsFunc('console.log',func_get_args());
        };
        $re->markTimeline  = function(){
            return self::jsFunc('console.markTimeline',func_get_args());
        };
        $re->memory  = function(){
            return 'console.memory';
        };
        $re->profile  = function(){
            return self::jsFunc('console.profile',func_get_args());
        };
        $re->profileEnd  = function(){
            return self::jsFunc('console.profileEnd',func_get_args());
        };
        $re->propertyIsEnumerable  = function(){
            return self::jsFunc('console.propertyIsEnumerable',func_get_args());
        };
        $re->table  = function(){
            return self::jsFunc('console.table',func_get_args());
        };
        $re->time  = function(){
            return self::jsFunc('console.time',func_get_args());
        };
        $re->rimeEnd  = function(){
            return self::jsFunc('console.timeEnd',func_get_args());
        };
        $re->timeStamp  = function(){
            return self::jsFunc('console.timeStamp',func_get_args());
        };
        $re->timeline  = function(){
            return self::jsFunc('console.timeline',func_get_args());
        };
        $re->timelineEnd  = function(){
            return self::jsFunc('console.timelineEnd',func_get_args());
        };
        $re->toLocaleString  = function(){
            return self::jsFunc('console.toLocaleString',func_get_args());
        };
        $re->toString  = function(){
            return self::jsFunc('console.toString',func_get_args());
        };
        $re->trace  = function(){
            return self::jsFunc('console.trace',func_get_args());
        };
        $re->valueOf  = function(){
            return self::jsFunc('console.valueOf',func_get_args());
        };
        $re->warm  = function(){
            return self::jsFunc('console.warm',func_get_args());
        };
        return $re;
    }*/
}