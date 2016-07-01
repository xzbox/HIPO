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
namespace lib\helper;

/**
 * Class console
 * Print report to the output
 * @package lib\helper
 */
class console{
	private static $len    = 0;
	private static $data   = [];
	private static function stdout(){
		fwrite(STDOUT,"\r");
		$out    = '';
		$keys   = array_keys(self::$data);
		$count  = count(self::$data);
		for($i  = 0;$i < $count;$i++){
			$out.= $keys[$i].":".self::$data[$keys[$i]]."\t";
		}
		$out  = trim($out);
		$len  = strlen($out);
		fwrite(STDOUT,$out);
		self::$len = $len;
	}
	public static function set($key,$value){
		self::$data[$key]   = $value;
		self::stdout();
		return $value;
	}
	public static function get($key){
		if(isset(self::$data[$key])){
			return self::$data[$key];
		}
		return false;
	}
	public static function del($key){
		if(isset(self::$data[$key])){
			unset(self::$data[$key]);
			self::stdout();
			return true;
		}
		return false;
	}
}