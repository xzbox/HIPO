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
use lib\client\js;
use lib\client\sender;
class admin{
	private static $pages = array();
	private static $md5   = '';
	private static $jsCode= '';

	/**
	 * @param $content
	 *
	 * @return mixed
	 */
	private static function min($content){
		return preg_replace('/\s+(\S+)\s+/',' $1 ',$content);
	}

	/**
	 * @return void
	 */
	public static function load(){
		$md5   = md5('');
		$DB    = array();
		$tem   = glob('templates/admin/*.html');
		$count = count($tem);
		for($i = 0;$i < $count;$i++){
			$page   = 'pages\\' . substr(basename($tem[$i]), 0, -5);
			self::$pages[$page]         = self::min(file_get_contents($tem[$i]));
			$DB['template_page_'.$page] = self::$pages[$page];
			$md5    = md5($md5.self::$pages[$page].$page);
		}
		$pages = glob('pages/admin/*.php');
		$count = count($pages);
		for($i = 0;$i < $count;$i++){
			/**
			 * @type \lib\view\view
			 */
			$class = 'pages\\admin\\' . substr(basename($pages[$i]), 0, -4);
			$class::load();
			self::$pages[$class] = self::min($class::getTemplate($class));
			$DB['template_page_pages\\' . substr(basename($pages[$i]), 0, -4)] = self::$pages[$class];
			$md5 = md5($md5 . self::$pages[$class]);
		}
		$DB    = json_encode($DB);
		self::$jsCode = js::jsFunc('iDb.SET_JSON',[$DB]);
		self::$md5 = $md5;
	}

	/**
	 * @param $name
	 *
	 * @return bool
	 */
	public static function get($name){
		if(isset(self::$pages[$name])){
			return self::$pages[$name];
		}
		return false;
	}

	/**
	 * @return mixed
	 */
	public static function md5(){
		return self::$md5;
	}

	/**
	 * @return string
	 */
	public static function jsCode(){
		return self::$jsCode;
	}

	/**
	 * @param $user
	 *
	 * @return void
	 */
	public static function sendAdminTemplate($user){
		js::doFunc($user,'iDb.removeTemplate');
		sender::ByUser($user,self::jsCode());
		js::doFunc($user,'iDb.set',['templateHash',admin::md5()]);
	}
}