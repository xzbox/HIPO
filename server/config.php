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

if(class_exists('\lib\network\Network')){
	/**
	 * As you now for set bind a socket we have to set a listening address, this constant is socket's listen address.
	 * You can change it to your custom configure.
	 */
	//define('socket_addr',\lib\network\Network::ServerIPv4());
	define('socket_addr','192.168.1.2');
}else{
	/**
	 * This is socket's port for times that system is not connected to any network and there is no IPV4.
	 * So we bind our socket with our famous port:
	 *      127.0.0.1
	 */
	define('default_server_IPV4','127.0.0.1');


	/**
	 * socket_port is constant for socket listen port.
	 * Default port for PHPSocket application is 8085.
	 */
	define('socket_port',8085);

	/**
	 * Socket's buffer length
	 */
	define('socket_bufferLength',2048);//2MB

	/**
	 * This constant is for times when you have a multi-language web application, and you want to set default language for new users.
	 */
	define('default_lang','en');

	/**
	 * In PHPSocket like PHP we have tmp folder for saving sessions' data
	 */
	define('sessions_folder','.tmp');

	/**
	 * It's nothing :)
	 * This constant is only for use in javascript's checking.
	 */
	define('undefined','undefined');

	/**
	 * Redis' server host address normally 127.0.0.1
	 */
	define('redis_host','127.0.0.1');

	/**
	 * Redis' server port 6379 as default number
	 */
	define('redis_port',6379);
	/**
	 * Redis' server password
	 * default value null
	 */
	define('redis_password',null);

	/**
	 * Print reports when it's true
	 */
	define('server_interactive',true);

	/**
	 * Your application name
	 */
	define('app_name','Demo');

	/**
	 * sysadmin's user  name
	 */
	define('admin_username','admin');

	/**
	 * sysadmin's password
	 */
	define('admin_password','admin');
}