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
 * Class files
 * @package lib\helper
 */
class files{
	protected static $cd = './';
	protected static $defDir = './';

	/**
	 * Changes the current directory.
	 * @param string|bool|false $value
	 *
	 * @return bool|string
	 */
	public static function cd($value = false) {
		if ($value == false) {
			return self::$cd;
		} elseif (file_exists($dir = self::get_file_name($value))) {
			$tmp = self::$cd;
			$dir = rtrim($dir);
			$dir = $dir . '/';
			self::$cd = $dir;
			return $tmp;
		} else {
			return false;
		}
	}

	/**
	 * @param bool|false $name
	 * @param bool|true  $cd
	 *
	 * @return bool|string
	 */
	public static function defDir($name = false,$cd = true){
		if($name == false){
			return self::$defDir;
		}elseif(file_exists($dir = self::get_file_name($name))){
			$tmp = self::$defDir;
			$dir = rtrim($dir);
			$dir = $dir . '/';
			self::$defDir = $dir;
			if($cd){
				self::cd($name);
			}
			return $tmp;
		}else{
			return false;
		}
	}

	/**
	 * @param $name
	 *
	 * @return string
	 */
	protected static function get_file_name($name){
		if(@$name[0] == '/'){
			return substr($name,1,strlen($name));
		}else{
			return self::$cd.$name;
		}
	}

	/**
	 * @param $name
	 *
	 * @return bool
	 */
	public static function is_exists($name){
		$name = self::get_file_name($name);
		return file_exists($name);
	}

	/**
	 * @param $dir
	 *
	 * @return bool
	 */
	public static function dir_exists($dir){
		if(self::is_exists($dir)){
			return is_dir(self::get_file_name($dir));
		}else{
			return false;
		}
	}

	/**
	 * @param $file
	 *
	 * @return bool
	 */
	public static function file_exists($file){
		if(self::is_exists($file)){
			return is_file(self::get_file_name($file));
		}else{
			return false;
		}
	}

	/**
	 * @param $link
	 *
	 * @return bool
	 */
	public static function link_exists($link){
		if(self::file_exists($link)){
			return is_link($link);
		}else{
			return false;
		}
	}

	/**
	 * @param $name
	 *
	 * @return bool
	 */
	public static function mkdir($name){
		return mkdir(self::get_file_name($name));
	}

	/**
	 * @param $name
	 *
	 * @return bool
	 */
	public static function unlink($name){
		return unlink(self::get_file_name($name));
	}

	/**
	 * @return void
	 */
	public static function reset(){
		self::dir_exists(self::$defDir);
	}

	/**
	 * @param $name
	 *
	 * @return array
	 */
	public static function glob($name){
		return glob(self::get_file_name($name));
	}
}