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
		$keys   = self::KEYS('*');
		$count  = count($keys);
		for($i  = 0;$i < $count;$i++){
			$key= $keys[$i];
			if($key[0] != '#'){
				self::$d[$keys[$i]] = self::GET($keys[$i]);
			}
		}
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
}