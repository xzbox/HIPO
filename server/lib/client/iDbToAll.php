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
 * Class iDbToAll
 *  Send iDb commands to all of users
 * @package lib\client
 */
class iDbToAll{
	/**
	 * @param $key
	 * @param $value
	 *
	 * @return int
	 */
	public static function set($key,$value){
		return sender::ToAll('1'.json_encode([$key,$value]));
	}

	/**
	 * @param $key
	 *
	 * @return int
	 */
	public static function incr($key){
		return sender::ToAll('3'.$key);
	}

	/**
	 * @param $key
	 * @param $value
	 *
	 * @return int
	 */
	public static function incrBy($key,$value){
		return sender::ToAll('4'.json_encode([$key,$value]));
	}

	/**
	 * @param $key
	 *
	 * @return int
	 */
	public static function del($key){
		return sender::ToAll('2'.$key);
	}

	/**
	 * @param $input
	 *
	 * @return int
	 */
	public static function set_json($input){
		return sender::ToAll('5'.$input);
	}
}