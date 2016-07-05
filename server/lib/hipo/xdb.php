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
namespace lib\hipo;
use lib\client\sender;
use lib\database\DB;
use lib\helper\strings;

class xdb{
	private static $keys    = [
		'user'      =>[
			'0001',
			12,
			[
				'#pass'         => '0001',
				'#email'        => '0010',
				'email'         => '0011',
				'age'           => '0100',
				'fname'         => '0101',
				'lname'         => '0110',
				'score'         => '0111',
				'tSends'        => '1000',
				'wSends'        => '1001',
				'bio'           => '1010',
				'username'      => '1011'
			]
		],
		'contest'   => [
			'0010',
			9,
			[
				'name'          => '001',
				'level'         => '010',
				'start'         => '011',
				'end'           => '100'
			]
		],
		'questions' => [
			'0011',
			9,
			[
				'name'          => '000',
				'level'         => '001',
				'content'       => '010',
				'si'            => '011',
				'so'            => '100',
				'#ci'           => '101',
				'#co'           => '110',
				'contest'       => '111'
			]
		],
		'log'       => [
			'0100',
			9,
			[
				'time'          => '001',
				'question'      => '001',
				'user'          => '001',
				'tof'           => '001',
				'lang'          => '001',
				'#code'         => '001',
			]
		],
		'messages'  => [
			'0101',
			9,
			[
				'title'         => '001',
				'tag'           => '010',
				'message'       => '011',
				'contest'       => '100',
				'question'      => '101',
			]
		]
	];

	/**
	 * @param $db
	 * @param $id
	 * @param $filed
	 *
	 * @return string
	 */
	private static function _key($db,$id,$filed){
		$id     = str_pad(decbin($id),self::$keys[$db][1],'0',STR_PAD_LEFT);
		$c      = ($filed[0] == '#' ? '#' : '');
		$filed  = self::$keys[$db][2][$filed];
		$db     = self::$keys[$db][0];
		return strings::str2bin($c.$db.$id.$filed);
	}

	/**
	 * @param $db
	 * @param $id
	 * @param $filed
	 *
	 * @return bool|string
	 */
	public static function key($db,$id,$filed){
		if(isset(self::$keys[$db][2][$filed])){
			return self::_key($db,$id,$filed);
		}
		return false;
	}

	/**
	 * Create a new filed
	 * @param $db
	 * @param $info
	 *
	 * @return bool
	 */
	public static function create($db,$info){
		if(isset(self::$keys[$db])){
			DB::INCR($k = '#'.bindec(self::$keys[$db][0]));
			$id     = DB::GET($k);
			$keys   = array_keys($info);
			$count  = count($info);
			for($i  = 0;$i < $count;$i++){
				self::set($db,$id,$keys[$i],$info[$keys[$i]],true);
			}
			return true;
		}
		return false;
	}

	/**
	 * @param            $db
	 * @param            $id
	 * @param            $filed
	 * @param            $value
	 * @param bool|false $t
	 *
	 * @return bool
	 */
	public static function set($db,$id,$filed,$value,$t = false){
		if($t){
			$key = self::_key($db,$id,$filed);
			DB::SET($key,$value);
			sender::ToAll('1'.$key.$value);
		}elseif(isset(self::$keys[$db][2][$filed])){
			self::set($db,$id,$filed,$value,true);
		}
		return false;
	}

	/**
	 * @param        $db
	 * @param        $id
	 * @param string $filed
	 *
	 * @return bool
	 */
	public static function del($db,$id,$filed = '*'){
		if($filed == '*'){
			$filed = array_keys(self::$keys[$db][2]);
			$count = count($filed);
			for($i = 0;$i < $count;$i++){
				self::del($db,$id,$filed[$i]);
			}
		}elseif(isset(self::$keys[$db][2][$filed])){
			$key = self::_key($db,$id,$filed);
			DB::DEL($key);
			sender::ToAll('4'.$key);
			return true;
		}
		return false;
	}

	/**
	 * @param $db
	 * @param $id
	 * @param $filed
	 *
	 * @return array|bool|int|string
	 */
	public static function get($db,$id,$filed){
		if(isset(self::$keys[$db][2][$filed])){
			$key = self::_key($db,$id,$filed);
			return DB::GET($key);
		}
		return false;
	}

	/**
	 * @param $db
	 * @param $id
	 * @param $filed
	 *
	 * @return bool
	 */
	public static function incr($db,$id,$filed){
		if(isset(self::$keys[$db][2][$filed])){
			$key = self::_key($db,$id,$filed);
			DB::INCR($key);
			sender::ToAll('2'.$key);
			return true;
		}
		return false;
	}

	/**
	 * @param $db
	 * @param $id
	 * @param $filed
	 * @param $value
	 *
	 * @return bool
	 */
	public static function incrBy($db,$id,$filed,$value){
		if(isset(self::$keys[$db][2][$filed])){
			$key = self::_key($db,$id,$filed);
			DB::INCRBY($key,$value);
			sender::ToAll('3'.$key.$value);
			return true;
		}
		return false;
	}
}