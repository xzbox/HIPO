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

/**
 * Class iDb
 * @package lib\client
 */
class iDb{
	/**
	 * @param $user
	 * @param $key
	 * @param $value
	 *
	 * @return int
	 */
	public static function set($user,$key,$value){
		return sender::ByUser($user,'1'.json_encode([$key,$value]));
	}

	/**
	 * @param $user
	 * @param $key
	 *
	 * @return int
	 */
	public static function incr($user,$key){
		return sender::ByUser($user,'3'.$key);
	}

	/**
	 * @param $user
	 * @param $key
	 * @param $value
	 *
	 * @return int
	 */
	public static function incrBy($user,$key,$value){
		return sender::ByUser($user,'4'.json_encode([$key,$value]));
	}

	/**
	 * @param $user
	 * @param $key
	 *
	 * @return int
	 */
	public static function del($user,$key){
		return sender::ByUser($user,'2'.$key);
	}

	/**
	 * @param $user
	 * @param $input
	 *
	 * @return int
	 */
	public static function set_json($user,$input){
		return sender::ByUser($user,'5'.$input);
	}
}