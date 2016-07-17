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

/**
 * Class admin
 * @package lib\hipo
 */
class admin{
	/**
	 * @param $values
	 *
	 * @return bool
	 */
	public static function createContest($values){
		if(isset($values['name']) && isset($values['level']) && isset($values['start']) && isset($values['time'])){
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

	/**
	 * @param $id
	 * @param $values
	 *
	 * @return bool
	 */
	public static function editContest($id,$values){
		if(isset($values['name']) && isset($values['level']) && isset($values['start']) && isset($values['time'])){
			DB::hset('contests',$id.'.name',$values['name']);
			DB::hset('contests',$id.'.level',$values['level']);
			DB::hset('contests',$id.'.start',$values['start']);
			DB::hset('contests',$id.'.end',$values['start'] + $values['time']);
			return true;
		}
		return false;
	}

	/**
	 * @param $id
	 *
	 * @return void
	 */
	public static function removeContest($id){
		DB::hdel('contests',$id.'.name');
		DB::hdel('contests',$id.'.level');
		DB::hdel('contests',$id.'.start');
		DB::hdel('contests',$id.'.end');
		$questions  = DB::hscan('questions','*.contest');
		$count      = count($questions);
		$keys       = array_keys($questions);
		for($i      = 0;$i < $count;$i++){
			if($questions[$keys[$i]] == $id){
				preg_match_all('/(.+)\.contest/',$questions[$keys[$i]],$questionId);
				$questionId = $questionId[1][0];
				self::removeQuestion($questionId);
			}
		}
	}

	/**
	 * @param $values
	 *
	 * @return bool
	 */
	public static function createQuestion($values){
		if(isset($values['name']) && isset($values['level']) && isset($values['contest']) && isset($values['si']) &&
			isset($values['so']) && isset($values['ci']) && isset($values['co']) && isset($values['content'])){

			DB::INCR('questionId');
			$id = DB::GET('questionId');
			DB::hset('questions',$id.'.name',$values['name']);
			DB::hset('questions',$id.'.level',$values['level']);
			DB::hset('questions',$id.'.contest',$values['contest']);
			DB::hset('questions',$id.'.si',$values['si']);
			DB::hset('questions',$id.'.so',$values['so']);
			DB::hset('questions','#'.$id.'.ci',$values['ci']);
			DB::hset('questions','#'.$id.'.co',$values['co']);
			DB::hset('questions',$id.'.content',$values['content']);
			return true;
		}
		return false;
	}

	/**
	 * @param $id
	 * @param $values
	 *
	 * @return bool
	 */
	public static function editQuestion($id,$values){
		if(isset($values['name']) && isset($values['level']) && isset($values['contest']) && isset($values['si']) &&
				isset($values['so']) && isset($values['ci']) && isset($values['co']) && isset($values['content'])){

			DB::hset('questions',$id.'.name',$values['name']);
			DB::hset('questions',$id.'.level',$values['level']);
			DB::hset('questions',$id.'.contest',$values['contest']);
			DB::hset('questions',$id.'.si',$values['si']);
			DB::hset('questions',$id.'.so',$values['so']);
			DB::hset('questions','#'.$id.'.ci',$values['ci']);
			DB::hset('questions','#'.$id.'.co',$values['co']);
			DB::hset('questions',$id.'.content',$values['content']);
			return true;
		}
		return false;
	}

	/**
	 * @param $id
	 *
	 * @return void
	 */
	public static function removeQuestion($id){
		DB::hdel('questions',$id.'.name');
		DB::hdel('questions',$id.'.level');
		DB::hdel('questions',$id.'.contest');
		DB::hdel('questions',$id.'.si');
		DB::hdel('questions',$id.'.so');
		DB::hdel('questions',$id.'.ci');
		DB::hdel('questions',$id.'.co');
		$logs   = DB::hscan('logs','*.question');
		$count  = count($logs);
		$keys   = array_keys($logs);
		for($i  = 0;$i < $count;$i++){
			$key= $keys[$i];
			$val= $logs[$key];
			if($val == $id){
				preg_match_all('/(.+)\.question/',$val,$logId);
				$logId  = $logId[1][0];
				DB::hdel('logs',[
				              $logId.'.time',
				              $logId.'.question',
				              $logId.'.user',
				              $logId.'.tof',
				              $logId.'.lang',
				              '#'.$logId.'.code'
				]);
			}
		}
	}
}