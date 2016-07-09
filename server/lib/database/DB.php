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
namespace lib\database;

use lib\client\iDb;
use lib\client\iDbToAll;
use lib\client\js;
use lib\client\sender;

/**
 * Class DB
 *  # at first of keys means it's a secret key (like user's password) and don't send them to clients
 */
class DB{
	/**
	 * @var null|Credis_Client
	 */
	public static $DB = null;
	/**
	 * @var array
	 */
	private static $d   =   array();
	/**
	 * This is an array for secret keys that we don't
	 *  wan't to send them to client like passwords and etc...
	 * @var array
	 */
	private static $a   =   array();
	/**
	 * @var string
	 */
	private static $json= '';

	/**
	 * @var bool
	 */
	private static $mkJson = true;

	/**
	 * @param $name
	 *
	 * @return void
	 */
	private static function loadHash($name){
		$db     = self::hgetall($name);
		$count  = count($db);
		$keys   = array_keys($db);
		for($i  = 0;$i < $count;$i++){
			$key= $keys[$i];
			if($key[0] == '#'){
				self::$a[$name][$key]   = $db[$key];
			}else{
				self::$d[$name][$key]   = $db[$key];
			}
		}
	}

	/**
	 * @return void
	 */
	public static function load(){
		self::loadHash('users');
//		self::loadHash('contests');
//		self::loadHash('questions');
		self::loadHash('logs');
		self::loadHash('sessions');
	}

	/**
	 * @param $name
	 * @param $value
	 *
	 * @return array|bool|int|string
	 */
	public static function SET($name,$value){
		if($name[0] == '#'){
			self::$a[$name] = $value;
		}else{
			iDbToAll::set($name,$value);
			self::$d[$name] = $value;
			self::$mkJson = true;
		}
		return self::$DB->SET($name,$value);
	}

	/**
	 * @param $name
	 *
	 * @return array|bool|int|string
	 */
	public static function INCR($name){
		if($name[0] == '#'){
			if(isset(self::$a[$name])){
				self::$a[$name]++;
			}else{
				self::$a[$name] = 1;
			}
		}else{
			if(isset(self::$d[$name])){
				self::$d[$name]++;
			}else{
				self::$d[$name] = 1;
			}
			iDbToAll::incr($name);
			self::$mkJson = true;
		}
		return self::$DB->INCR($name);
	}

	/**
	 * @param $name
	 * @param $value
	 *
	 * @return array|bool|int|string
	 */
	public static function INCRBY($name,$value){
		if($name[0] == '#'){
			if(isset(self::$a[$name])){
				self::$a[$name] += $value;
			}else{
				self::$a[$name] = $value;
			}
		}else{
			if(isset(self::$d[$name])){
				self::$d[$name] += $value;
			}else{
				self::$d[$name] = $value;
			}
			iDbToAll::incrBy($name,$value);
			self::$mkJson = true;
		}
		return self::$DB->INCRBY($name,$value);
	}

	/**
	 * @param $name
	 *
	 * @return array|bool|int|string
	 */
	public static function GET($name){
		if($name[0] == '#'){
			return @self::$a[$name];
		}else{
			return @self::$d[$name];
		}
	}

	/**
	 * @param string $pattern
	 *
	 * @return mixed
	 */
	public static function KEYS($pattern = '*'){
		return self::$DB->KEYS($pattern);
	}

	/**
	 * @param $key
	 *
	 * @return array|bool|int|string
	 */
	public static function DEL($key){
		if($key[0] == '#'){
			unset(self::$a[$key]);
		}else{
			unset(self::$d[$key]);
			iDbToAll::del($key);
			self::$mkJson = true;
		}
		return self::$DB->DEL($key);
	}

	/**
	 * Make json string for new users to keep them update.
	 * @return string
	 */
	public static function GET_JSON(){
		if(self::$mkJson){
			self::$json     = json_encode(self::$d);
			self::$mkJson   = false;
		}
		return self::$json;
	}

	/**
	 * @param $hash
	 * @param $field
	 * @param $value
	 *
	 * @return mixed
	 */
	public static function hset($hash,$field,$value){
		if($field[0] == '#'){
			self::$a[$hash][$field] = $value;
		}else{
			self::$d[$hash][$field] = $value;
			iDbToAll::set($hash.'.'.$field,$value);
			self::$mkJson = true;
		}
		return self::$DB->hset($hash,$field,$value);
	}

	/**
	 * @param $hash
	 * @param $field
	 *
	 * @return mixed
	 */
	public static function hget($hash,$field){
		if($field[0] == '#'){
			return @self::$a[$hash][$field];
		}else{
			return @self::$d[$hash][$field];
		}
	}

	/**
	 * @param $hash
	 *
	 * @return mixed
	 */
	public static function hgetall($hash){
		return self::$DB->hgetall($hash);
	}

	/**
	 * @param $hash
	 * @param $field
	 *
	 * @return mixed
	 */
	public static function hdel($hash,$field){
		if(is_array($field)){
			$count  = count($field);
			$keys   = array_keys($field);
			for($i  = 0;$i < $count;$i++){
				self::hdel($hash,$field[$keys[$i]]);
			}
			return true;
		}
		if($field[0] == '#'){
			unset(self::$a[$hash][$field]);
		}else{
			unset(self::$d[$hash][$field]);
			iDbToAll::del($hash.'.'.$field);
			self::$mkJson = true;
		}
		return self::$DB->hdel($hash,$field);
	}

	/**
	 * @param        $hash
	 * @param string $match
	 *
	 * @return bool | array
	 */
	public static function hscan($hash,$match = ''){
		return self::$DB->hscan($a,$hash,$match);
	}

	/**
	 * @param $hash
	 * @param $values
	 *
	 * @return array|bool|mixed|null|string
	 * @throws CredisException
	 */
	public static function hmset($hash,$values){
		$out    = array();
		$keys   = array_keys($values);
		$count  = count($values);
		for($i  = 0;$i < $count;$i++){
			$key    = $keys[$i];
			$val    = $values[$key];
			if($key[0] == '#'){
				self::$a[$hash][$key] = $val;
			}else{
				self::$d[$hash][$key] = $val;
				iDbToAll::set($hash.'.'.$key,$val);
				self::$mkJson = true;
			}
			$out[]  = $key;
			$out[]  = $val;
		}
		unset($values,$count,$i,$keys,$key,$val);
		return self::$DB->__call('hmset',$out);
	}
}