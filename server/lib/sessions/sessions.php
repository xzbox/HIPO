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
namespace lib\sessions;

use lib\helper\validation;
use lib\network\WebSocketUser;

/**
 * Class sessions
 * @package lib\sessions
 */
final class sessions{
    /**
     * @var
     */
    public static $tmp_address;
    /**
     * @var
     */
    public static $sessions;

    /**
     * Load data,something like __constructor
     */
    public static function load(){
        $sessions = glob(self::$tmp_address.'/ses_*');
        $count    = count($sessions);
        $regexPattern = '/ses_(.+)/';
        for($i = 0;$i < $count;$i++){
            preg_match_all($regexPattern,basename($sessions[$i]),$name);
            if(isset($name[1][0])){
                self::$sessions[$name[1][0]] = self::decode(file_get_contents($sessions[$i]));
            }
        }
    }

    /**
     * @param WebSocketUser $user
     * @return mixed
     */
    public static function getByUser($user){
        return self::getById($user->sessionId);
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getById($id){
        return self::$sessions[$id];
    }

    /**
     * @param $id
     * @return sessionObject
     */
    public static function objById($id){
        return new sessionObject($id);
    }

    /**
     * @param $user
     *
     * @return sessionObject
     */
    public static function objByUser($user){
        return self::objById($user->sessionId);
    }

    /**
     * @param $string
     * @return mixed
     */
    private static function decode($string){
        return json_decode($string,true);
    }

    /**
     * @param $object
     * @return string
     */
    private static function encode($object){
        return json_encode($object);
    }

    /**
     * @param WebSocketUser $user
     * @return string
     */
    public static function create($user){
        $sessionId = sha1(sha1($user->headers['sec-websocket-key'].rand(1000,10000)).rand(10001,100000));
        file_put_contents(self::$tmp_address.'/ses_'.$sessionId,self::encode([]));
        self::$sessions[$sessionId] = array();
        return $sessionId;
    }

    /**
     * @param $id
     */
    public static function saveById($id){
        $file = fopen(self::$tmp_address.'/ses_'.$id,'w+');
        fwrite($file,self::encode(self::$sessions[$id]));
        fclose($file);
    }

    /**
     * @param WebSocketUser $user
     */
    public static function saveByUser($user){
        self::saveById($user->sessionId);
    }

    /**
     * @param WebSocketUser $user
     * @param $session
     */
    public static function setByUser($user,$session){
        self::setById($user->sessionId,$session);
    }

    /**
     * @param $id
     * @param $session
     */
    public static function setById($id,$session){
        self::$sessions[$id] = $session;
        self::saveById($id);
    }

    /**
     * @param $id
     */
    public static function unsetById($id){
        unset(self::$sessions[$id]);
    }

    /**
     * @param WebSocketUser $user
     */
    public static function unsetByUser($user){
        self::unsetById($user->sessionId);
    }

    /**
     * @param $id
     * @return bool
     */
    public static function issetId($id){
        return isset(self::$sessions[$id]);
    }

    /**
     * @param WebSocketUser $user
     * @return bool
     */
    public static function issetUser($user){
        return self::issetId($user->sessionId);
    }
}