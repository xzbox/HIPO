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
			DB::hset('contests',$id.'.name',$values['name']);
			DB::hset('contests',$id.'.level',$values['level']);
			DB::hset('contests',$id.'.start',$values['start']);
			DB::hset('contests',$id.'.end',$values['start'] + $values['time']);
			return true;
		}
		return false;
	}
	public static function editContest($id,$values){
		if(isset($values['name']) && $values['level'] && $values['start'] && $values['time']){
			DB::hset('contests',$id.'.name',$values['name']);
			DB::hset('contests',$id.'.level',$values['level']);
			DB::hset('contests',$id.'.start',$values['start']);
			DB::hset('contests',$id.'.end',$values['start'] + $values['time']);
			return true;
		}
		return false;
	}

	public static function createQuestion($values){
		if(isset($values['name']) && isset($values['level']) && isset($values['contest']) && isset($values['si']) &&
			isset($values['so']) && isset($values['ci']) && isset($values['co'])){

			DB::INCR('questionId');
			$id = DB::GET('questionId');
			DB::hset('questions',$id.'.name',$values['name']);
			DB::hset('questions',$id.'.level',$values['level']);
			DB::hset('questions',$id.'.contest',$values['contest']);
			DB::hset('questions',$id.'.si',$values['si']);
			DB::hset('questions',$id.'.so',$values['so']);
			DB::hset('questions',$id.'.ci',$values['ci']);
			DB::hset('questions',$id.'.co',$values['co']);
			return true;
		}
		return false;
	}

	public static function editQuestion($id,$values){
		if(isset($values['name']) && isset($values['level']) && isset($values['contest']) && isset($values['si']) &&
				isset($values['so']) && isset($values['ci']) && isset($values['co'])){

			DB::hset('questions',$id.'.name',$values['name']);
			DB::hset('questions',$id.'.level',$values['level']);
			DB::hset('questions',$id.'.contest',$values['contest']);
			DB::hset('questions',$id.'.si',$values['si']);
			DB::hset('questions',$id.'.so',$values['so']);
			DB::hset('questions',$id.'.ci',$values['ci']);
			DB::hset('questions',$id.'.co',$values['co']);
			return true;
		}
		return false;
	}
}