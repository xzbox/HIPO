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
namespace lib\view;

use lib\network\WebSocketUser;

/**
 * Class view
 * @package lib\view
 */
abstract class view{
    public $role = "";

    /**
     * @return string
     */
    public static function getTemplate(){return '';}

    /**
     * @param WebSocketUser $user
     *
     * @return mixed
     */
    public static function connected($user){}

    /**
     * @param WebSocketUser $user
     *
     * @return mixed
     */
    public static function closed($user){}

    /**
     * @return mixed
     */
    public static function load(){}
}