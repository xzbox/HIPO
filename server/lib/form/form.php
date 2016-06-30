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
namespace lib\form;

/**
 * Class form
 * @package lib\form
 */
class form{
	protected static $content;
	protected static $user;

	/**
	 * @param $user
	 * @param $content
	 *
	 * @return void
	 */
	public static function call($user,$content){
		$keys           = array_keys($content);
		$count          = count($content);
		self::$content  = [];
		for($i = 0;$i < $count;$i++){
			self::$content[$keys[$i]]   = base64_decode($content[$keys[$i]]);
		}
		self::$user     = $user;
	}

	/**
	 * @param $file
	 * @param $address
	 *
	 * @return bool|int
	 */
	protected static function move_file_uploaded($file,$address){
		if(isset(self::$content[$file])){
			return file_put_contents($address,self::$content[$file]);
		}
		return false;
	}

	/**
	 * @return void
	 */
	public static function parse(){}
}