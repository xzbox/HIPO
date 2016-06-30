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
/**
 * Test
 *
 * @package Web Socket
 * @category Index
 * @author Qti3e<Qti3eQti3e@Gmail.com>
 */
set_time_limit(0);
set_include_path(__DIR__);
include('lib/controller/Controller.php');
include('config.php');
$controller = new \lib\controller\Controller();
include('config.php');
$controller->run();

//echo \lib\Network::ServerIPv4();
//For run server type:CD /D E:\lab\WSoc && php index.php

//User:Connect
//Server:Accept
//Server:Require Session id
//User:Send session id
//Server:If session id==Non make and send a new session id
//      User:Save session id
//Server:Send templates hash
//User:if server's template hash!=template hash:Send request for give templates and remove old
//      Server:Send new template hash with details
//Finished So Simply
//In this step user is free to work with application
//echo json_encode([1,2,"H"=>'54',"sf"=>[4,5,7,"Ali"]]);