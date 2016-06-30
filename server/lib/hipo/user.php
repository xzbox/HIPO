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
use lib\database\DB;
use lib\network\WebSocketUser;
use lib\sessions\DBStorage;

class user{
	/**
	 * @param WebSocketUser $user
	 * @param $username
	 * @param $password
	 *
	 * @return bool
	 */
	public static function login($user,$username,$password){
		if(DBStorage::get($user->sessionId,'wrong_pass') > 7){
			//return false;
		}
		$user_pass  = DB::GET('#u.'.strtolower(trim($username)).'.pass');
		if($user_pass == sha1($password)){
			DBStorage::set($user->sessionId,'login',1);
			DBStorage::set($user->sessionId,'login_username',$username);
			$user->isLogin  = true;
			js::doFunc($user,'iDb.set',['current_username',user::username($user)]);
			js::doFunc($user,'right_login');
			return true;
		}
		DBStorage::incr($user->sessionId,'wrong_pass');
		js::doFunc($user,'wrong_login');
		return false;
	}

	/**
	 * @param WebSocketUser $user
	 *
	 * @return bool
	 */
	public static function is_login($user){
		$re = DBStorage::get($user->sessionId,'login') == 1;
		return $user->isLogin = $re;
	}

	/**
	 * @param $user
	 *
	 * @return mixed
	 */
	public static function username($user){
		return DBStorage::get($user->sessionId,'login_username');
	}

	/**
	 * @param WebSocketUser $user
	 *
	 * @return array|bool|int|string
	 */
	public static function logout($user){
		$user->isLogin  = false;
		DBStorage::del($user->sessionId,'login');
		return DBStorage::del($user->sessionId,'login_username');
	}

	public static function signup($user,$username,$pass,$age,$email,$fname,$lname){
		if(count(DB::KEYS('u.'.strtolower($username).'.*')) == 0){
			$p      = 'u.'.strtolower($username).'.';
			DB::SET('#'.$p.'pass',sha1($pass));
			DB::SET($p.'age',$age);
			DB::SET('#'.$p.'email',$email);
			//Hash of email address for gravatar
			DB::SET($p.'email',md5(strtolower(trim($email))));
			DB::SET($p.'fname',$fname);
			DB::SET($p.'lname',$lname);
			DB::SET($p.'time',time());
			DB::SET($p.'score',0);
			user::login($user,$username,$pass);
			return true;
		}else{
			return false;
		}
	}
}