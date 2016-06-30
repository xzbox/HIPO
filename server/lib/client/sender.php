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
use lib\network\Socket;

/**
 * Class sender
 * @package lib\client
 */
class sender{
    /**
     * @param $user
     * @param $msg
     * @return int
     */
    public static function ByUser($user,$msg){
        Socket::$socket->send($user,$msg);
        return 1;
    }

    /**
     * @param $page
     * @param $msg
     * @return int
     */
    public static function ByPage($page,$msg){
        $count  = count(Socket::$socket->users);
        $keys   = array_keys(Socket::$socket->users);
        $r      = 0;
        for($i  = 0;$i < $count;$i++){
            $key= $keys[$i];
            if(Socket::$socket->users[$key]->page == $page){
                $r++;
                Socket::$socket->send(Socket::$socket->users[$key],$msg);
            }
        }
        return $r;
    }

    /**
     * @param $msg
     *
     * @return void
     */
    public static function ToAll($msg){
        $count  = count(Socket::$socket->users);
        $keys   = array_keys(Socket::$socket->users);
        for($i  = 0;$i < $count;$i++){
            @Socket::$socket->send(Socket::$socket->users[$keys[$i]],$msg);
        }
    }

    /**
     * @param $lang
     * @param $msg
     * @return int
     */
    public static function ByLang($lang,$msg){
        $count  = count(Socket::$socket->users);
        $keys   = array_keys(Socket::$socket->users);
        $r      = 0;
        for($i  = 0;$i < $count;$i++){
            $key    = $keys[$i];
            if(Socket::$socket->users[$key]->lang == $lang){
                $r++;
                Socket::$socket->send(Socket::$socket->users[$key],$msg);
            }
        }
        return $r;
    }

    /**
     * @param $socket
     * @param $msg
     * @return int
     */
    public static function BySocket($socket,$msg){
        $count  = count(Socket::$socket->users);
        $keys   = array_keys(Socket::$socket->users);
        $r      = 0;
        for($i  = 0;$i < $count;$i++){
            $key= $keys[$i];
            if(Socket::$socket->users[$key]->socket == $socket){
                $r++;
                Socket::$socket->send(Socket::$socket->users[$key],$msg);
            }
        }
        return $r;
    }

    /**
     * @param $sessionId
     * @param $msg
     * @return int
     */
    public static function BySessionId($sessionId,$msg){
        $count  = count(Socket::$socket->users);
        $keys   = array_keys(Socket::$socket->users);
        $r      = 0;
        for($i  = 0;$i < $count;$i++){
            $key= $keys[$i];
            if(Socket::$socket->users[$key]->sessionId == $sessionId){
                $r++;
                Socket::$socket->send(Socket::$socket->users[$key],$msg);
            }
        }
        return $r;
    }

    /**
     * @param $information
     * @param $msg
     * @return int
     */
    public static function ByInformation($information,$msg){
        $count  = count(Socket::$socket->users);
        $keys   = array_keys(Socket::$socket->users);
        $r      = 0;
        for($i  = 0;$i < $count;$i++){
            $key= $keys[$i];
            if(Socket::$socket->users[$key]->information == $information){
                $r++;
                Socket::$socket->send(Socket::$socket->users[$key],$msg);
            }
        }
        return $r;
    }

    /**
     * @param $key
     * @param $value
     * @param $msg
     * @return int
     */
    public static function ByInformationKey($key,$value,$msg){
        $count  = count(Socket::$socket->users);
        $keys   = array_keys(Socket::$socket->users);
        $r      = 0;
        for($i  = 0;$i < $count;$i++){
            $k  = $keys[$i];
            if(isset(Socket::$socket->users[$k]->information[$key])){
                if(Socket::$socket->users[$k]->information[$key] == $value){
                    $r++;
                    Socket::$socket->send(Socket::$socket->users[$k],$msg);
                }
            }
        }
        return $r;
    }

    /**
     * @param $lastMsg
     * @param $msg
     * @return int
     */
    public static function ByLastMsg($lastMsg,$msg){
        $count  = count(Socket::$socket->users);
        $keys   = array_keys(Socket::$socket->users);
        $r      = 0;
        for($i  = 0;$i < $count;$i++){
            $key= $keys[$i];
            if(Socket::$socket->users[$key]->lastMsg == $lastMsg){
                $r++;
                Socket::$socket->send(Socket::$socket->users[$key],$msg);
            }
        }
        return $r;
    }

    /**
     * @param $header
     * @param $msg
     * @return int
     */
    public static function ByHeaders($header,$msg){
        $count  = count(Socket::$socket->users);
        $keys   = array_keys(Socket::$socket->users);
        $r      = 0;
        for($i  = 0;$i < $count;$i++){
            $key= $keys[$i];
            if(Socket::$socket->users[$key]->headers == $header){
                $r++;
                Socket::$socket->send(Socket::$socket->users[$key],$msg);
            }
        }
        return $r;
    }

    /**
     * @param $key
     * @param $value
     * @param $msg
     * @return int
     */
    public static function ByHeadersKey($key,$value,$msg){
        $count  = count(Socket::$socket->users);
        $keys   = array_keys(Socket::$socket->users);
        $r      = 0;
        for($i  = 0;$i < $count;$i++){
            $k  = $keys[$i];
            if(isset(Socket::$socket->users[$k]->headers[$key])){
                if(Socket::$socket->users[$k]->headers[$key] == $value){
                    $r++;
                    Socket::$socket->send(Socket::$socket->users[$k],$msg);
                }
            }
        }
        return $r;
    }
}