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
namespace lib\sysadmin\commands;

use lib\network\Socket;
use lib\network\WebSocketUser;

/**
 * Class ls
 * @package lib\sysadmin\commands
 */
class ls{
	/**
	 * @var bool
	 */
	public static $needLogin    = true;

	/**
	 * @param $param
	 * @param WebSocketUser $user
	 *
	 * @return string
	 */
	public static function process($param,$user){
		$keys   = array_keys(Socket::$socket->users);
		$count  = count(Socket::$socket->users);
		$re     = "Online clients:".Socket::$online." \t Total transferred data:".Socket::formatSizeUnits(Socket::$transferred)."\n";
		for($i  = 0;$i < $count;$i++){
			$u  = Socket::$socket->users[$keys[$i]];
			if($u == $user){
				$re .= 'YOU-- ';
			}else{
				$re .= '      ';
			}
			$re.= $u->id."\t".$u->ip['address'].':'.$u->ip['port']."\n";
		}
		return $re;
	}
}