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
namespace lib\controller;
use lib\database\Credis_Client;
use lib\database\DB;
use lib\database\myRedis;
use lib\hipo\admin;
use lib\network\Network;
use lib\network\Socket;
use lib\sessions\sessions;
use lib\view\templates;

/**
 * Class Controller
 * @package lib\controller
 */
class Controller{
    protected $server;

    /**
     * @param $class
     *
     * @return bool
     */
    public function auto_load($class){
        $file = str_replace("\\","/",$class).'.php';
        if(file_exists($file)){
            require_once($file);
            if(class_exists($class)){
                return true;
            }
        }
        return false;
    }

    /**
     * Controller constructor.
     */
    public function __construct(){
        spl_autoload_register([$this,"auto_load"]);
        DB::$DB = new Credis_Client(redis_host,redis_port);
    }

    public function run(){
        sessions::$tmp_address = sessions_folder;
        sessions::load();
        templates::load();
        admin::load();
        printf("Welcome to the PHPSocket!\r\nApp name     : \"".app_name."\"\r\nIPv4 Address : %s\r\n",Network::ServerIPv4());
        $this->server = new Socket(socket_addr,socket_port,socket_bufferLength);
        $this->server->run();
    }
}