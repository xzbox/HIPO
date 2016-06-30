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
namespace forms;

use lib\client\js;
use lib\form\form;
use lib\helper\validation;
use lib\hipo\user;

/**
 * Class signup
 * @package forms
 */
class signup extends form{
	/**
	 * @return void
	 */
	public static function parse(){
		$email      = self::$content['email'];
		$pass       = self::$content['password'];
		$re_pass    = self::$content['password_repeat'];
		$fname      = self::$content['fname'];
		$lname      = self::$content['lname'];
		$age        = self::$content['age'];
		$username   = self::$content['username'];
		if(!validation::validate_email($email)){
			js::doFunc(self::$user,'signup_wrong_email');
			return;
		}
		if($pass !== $re_pass){
			js::doFunc(self::$user,'signup_same_repass');
			return;
		}
		if(!((int)$age > 0 && (int)$age < 100)){
			js::doFunc(self::$user,'signup_wrong_age');
			return;
		}
		$re         = user::signup(self::$user,$username,$pass,$age,$email,$fname,$lname);
		if($re == false){
			js::doFunc(self::$user,'signup_used_username');
			return;
		}
		js::doFunc(self::$user,'signup_success');
	}
}