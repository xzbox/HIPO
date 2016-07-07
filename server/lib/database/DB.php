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
	 * @var string
	 */
	private static $json= '';

	/**
	 * @return void
	 */
	public static function load(){
		self::$d['users']       = self::hgetall('users');
		self::$d['contests']    = self::hgetall('contests');
		self::$d['questions']   = self::hgetall('questions');
		self::$d['logs']        = self::hgetall('logs');
		self::$json = json_encode(self::$d);
	}

	/**
	 * @param $name
	 * @param $value
	 *
	 * @return array|bool|int|string
	 */
	public static function SET($name,$value){
		if($name[0] != '#'){
			//sender::ToAll(js::jsFunc("iDb.set", [$name,$value]));
			self::$d[$name] = $value;
			self::$json     = json_encode(self::$d);
		}
		return self::$DB->SET($name,$value);
	}

	/**
	 * @param $name
	 *
	 * @return array|bool|int|string
	 */
	public static function INCR($name){
		if($name[0] != '#'){
			//sender::ToAll(js::jsFunc("iDb.incr",[$name]));
			if(isset(self::$d[$name])){
				self::$d[$name]++;
			}else{
				self::$d[$name] = 1;
			}
			self::$json     = json_encode(self::$d);
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
		if($name[0] != '#'){
			//sender::ToAll(js::jsFunc("iDb.incrby",[$name,$value]));
			if(isset(self::$d[$name])){
				self::$d[$name] += $value;
			}else{
				self::$d[$name] = $value;
			}
			self::$json     = json_encode(self::$d);
		}
		return self::$DB->INCRBY($name,$value);
	}

	/**
	 * @param $name
	 *
	 * @return array|bool|int|string
	 */
	public static function GET($name){
		return self::$DB->GET($name);
	}

	/**
	 * @param $name
	 *
	 * @return array|bool|int|string
	 */
	public static function KEYS($name){
		return self::$DB->KEYS($name);
	}

	/**
	 * @param $key
	 *
	 * @return array|bool|int|string
	 */
	public static function DEL($key){
		if($key[0] !== '#'){
			unset(self::$d[$key]);
			self::$json     = json_encode(self::$d);
		}
		return self::$DB->DEL($key);
	}

	/**
	 * Make json string for new users to keep them update.
	 * @return string
	 */
	public static function GET_JSON(){
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
		return self::$DB->hset($hash,$field,$value);
	}

	/**
	 * @param $hash
	 * @param $field
	 *
	 * @return mixed
	 */
	public static function hget($hash,$field){
		return self::$DB->hget($hash,$field);
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
			$out[]  = $keys[$i];
			$out[]  = $values[$keys[$i]];
		}
		unset($values,$count,$i,$keys);
		return self::$DB->__call('hmset',$out);
	}
}