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
namespace lib\sysadmin;

use lib\client\sender;

/**
 * Class sys
 * @package lib\sysadmin
 */
class sys{
	private static $user;
	/**
	 * @param $user
	 * @param $message
	 *
	 * @return void
	 */
	public static function onMessage($user,$message){
		self::$user = $user;
		preg_match_all("/[a-z]+(\\s+'[\\w\\W]*?'|\\s+[0-9]+)*/",$message,$commands);
		$commands   = $commands[0];
		$count      = count($commands);
		if(!isset($commands[0])){
			sender::ByUser($user,'');
			return;
		}
		$ex         = explode(' ',$commands[0]);
		$in         = substr($commands[0],strlen($ex[0])+1);
		preg_match_all("/'([\\w\\W]*?)'|([^\\s']+)/",$in,$p);
		$input      = self::runCommand($ex[0],$p[1]);

		for($i = 1;$i < $count;$i++){
			$ex         = explode(' ',$commands[$i]);
			$in         = substr($commands[$i],strlen($ex[0])+1);
			preg_match_all("/'([\\w\\W]*?)'|([^\\s']+)/",'2 '.$in,$p);
			$p[1][0]    = $input;
			$input      = self::runCommand($ex[0],$p[1]);
		}
		sender::ByUser($user,$input);
	}

	/**
	 * @param $name
	 *
	 * @return bool
	 */
	protected static function commandExists($name){
		return class_exists('lib\\sysadmin\\commands\\'.$name);
	}

	/**
	 * @param $name
	 * @param $param
	 *
	 * @return bool|string
	 */
	public static function runCommand($name,$param){
		$count = count($param);
		if(self::commandExists($name)){
			$class  = 'lib\\sysadmin\\commands\\'.$name;
			if($class::$needLogin == true && self::$user->isAdmin == 1){
				return false;
			}else{
				for($i = 0;$i < $count;$i++){
					if(($param[$i][0] == substr($param[$i],-1)) == '\''){
						$param[$i]    = substr($param[$i],1,-1);
					}
				}
				return $class::process($param,self::$user);
			}
		}else{
			return 'Command<'.$name.'> not found!';
		}
	}
}