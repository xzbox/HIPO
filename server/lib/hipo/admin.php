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

use lib\database\DB;

class admin{
	public static function createContest($values){
		if(isset($values['name']) && $values['level'] && $values['start'] && $values['time']){
			DB::INCR('contestId');
			$id = DB::GET('contestId');
			DB::hset('contests','name',$values['name']);
			DB::hset('contests','level',$values['level']);
			DB::hset('contests','start',$values['start']);
			DB::hset('contests','end',$values['start'] + $values['time']);
			return true;
		}
		return false;
	}
}