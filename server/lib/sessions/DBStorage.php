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
use lib\database\DB;

/**
 * Class DBStorage
 * @package lib\sessions
 */
class DBStorage{
	/**
	 * @param $sessionId
	 * @param $key
	 * @param $value
	 *
	 * @return array|bool|int|string
	 */
	public static function set($sessionId,$key,$value){
		return DB::HSET('sessions','#'.$sessionId.'.'.$key,serialize($value));
	}

	/**
	 * @param $sessionId
	 * @param $key
	 *
	 * @return array|bool|int|string
	 */
	public static function incr($sessionId,$key){
		$val    = self::get($sessionId,$key);
		if($val == false){
			return self::set($sessionId,$key,1);
		}
		return self::set($sessionId,$key,++$val);
	}

	/**
	 * @param $sessionId
	 * @param $key
	 *
	 * @return mixed
	 */
	public static function get($sessionId,$key){
		$re     = DB::HGET('sessions','#'.$sessionId.'.'.$key);
		if($re !== false){
			return unserialize($re);
		}
		return false;
	}
	/**
	 * @param $sessionId
	 * @param $key
	 *
	 * @return array|bool|int|string
	 */
	public static function del($sessionId,$key){
		return DB::HDEL('sessions','#'.$sessionId.'.'.$key);
	}
}