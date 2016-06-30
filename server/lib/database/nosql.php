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
namespace lib\database;

/**
 * Class nosql
 * Support:
 *  Insert
 *  Update
 *  Delete
 *  Select
 *  issetKey
 * @package database
 */
class nosql{
	/**
	 * @var string
	 */
	private static $dataString = '';
	private static $dataArray  = '';
	public static $nosql_fetch_count = 0;
	/**
	 * @param $str
	 *
	 * @return string
	 */
	protected static function encode($str){
		//STR: Hello My name is:%Qti3e%;
		//$str = str_replace('%','%3',$str);//STR:Hello My name is:%3Qti3e%3;
		//$str = str_replace(';','%2',$str);//STR:Hello My name is:%3Qti3e%3%2
		//$str = str_replace(':','%1',$str);//STR:Hello My name is%1%3Qti3e%3%2
		return str_replace(['%',';',':'],['%3','%2','%1'],$str);
	}

	/**
	 * @param $str
	 *
	 * @return string
	 */
	protected static function decode($str){
		//STR:Hello My name is%1%3Qti3e%3%2
		//$str = str_replace('%1',':',$str);//STR:Hello My name is:%3Qti3e%3%2
		//$str = str_replace('%2',';',$str);//STR:Hello My name is:%3Qti3e%3;
		//$str = str_replace('%3','%',$str);//STR:Hello My name is:%Qti3e%;
		return str_replace(['%1','%2','%3'],[':',';','%'],$str);
	}

	/**
	 * @return array
	 */
	public static function getDb(){
		self::$dataArray = self::makeArray();
		return self::$dataArray;
	}

	/**
	 * @return array
	 */
	private static function makeArray(){
		preg_match_all('/;([\s\S]+?):([\s\S]+?);/',self::$dataString,$matches);
		$count = count($matches[0]);
		$return= array();
		for($i = 0;$i < $count;$i++){
			$key = $matches[1][$i];
			$val = $matches[2][$i];
			$return[self::decode($key)] = self::decode($val);
		}
		return $return;
	}

	/**
	 * @param array|string $query
	 *
	 * @return array
	 */
	public static function select($query = []){
//		[
//			'key'=>[
//				'start'=>'',
//				'in'   =>'',
//				'end'  =>''
//			],
//			'val'=>[
//					'start'=>'',
//					'in'   =>'',
//					'end'  =>''
//			],
//			'call_back'=>function($key,$name){return [$key,$name];}
//		];
		$key    = '[\s\S]+?';
		$val    = '[\s\S]+?';
		$call   = function($key,$value){
			return [$key,$value];
		};
		if(is_array($query)){
			if(isset($query['key'])){
				if(is_string($query['key'])){
					if($query['key'] !== '*'){
						$key = preg_quote(self::encode($query['key']));
					}
				}else{
					if(isset($query['key']['in'])){
						$key = '[\s\S]+?'.preg_quote(self::encode($query['key']['in'])).'[\s\S]+?';
					}
					if(isset($query['key']['start'])){
						$key = preg_quote(self::encode($query['key']['start'])).$key;
					}
					if(isset($query['key']['end'])){
						$key.= preg_quote(self::encode($query['key']['end']));
					}
				}
			}
			if(isset($query['val'])){
				if(is_string($query['val'])){
					if($query['val'] !== '*'){
						$val = preg_quote(self::encode($query['val']));
					}
				}else{
					if(isset($query['val']['in'])){
						$val = '[\s\s]+?'.preg_quote(self::encode($query['val']['in'])).'[\s\S]+?';
					}
					if(isset($query['val']['start'])){
						$val = preg_quote(self::encode($query['val']['start'])).$val;
					}
					if(isset($query['val']['end'])){
						$val.= preg_quote(self::encode($query['val']['end']));
					}
				}
			}
			if(isset($query['call_back'])){
				if(is_callable($query['call_back'])){
					if(is_array($end = $query['call_back']('test','test'))){
						if(count($end) == 2){
							$call = $query['call_back'];
						}
					}
				}
			}
		}else{
			$val = preg_quote(self::encode((string)$query));
		}
		preg_match_all('/;('.$key.'):('.$val.');/',self::$dataString,$matches);
		$count = count($matches[0]);
		self::$nosql_fetch_count = $count;
		$return = [];
		for($i = 0;$i < $count;$i++){
			$key = self::decode($matches[1][$i]);
			$val = self::decode($matches[2][$i]);
			$re  = $call($key,$val);
			$return[$re[0]] = $re[1];
		}
		return $return;
	}

	/**
	 * @param $key
	 * @param $value
	 *
	 * @return mixed
	 */
	public static function update($key,$value){
		if(is_array($key)&&is_array($value)){
			if(count($key) != count($value)){
				return false;
			}else{
				$count = count($key);
				$re    = 0;
				for($i = 0;$i < $count;$i++){
					$re += self::update($key[$i],$value[$i]);
				}
				self::save();
				return $re;
			}
		}elseif(is_array($key) && !is_array($value)){
			$count = count($key);
			$re    = 0;
			for($i = 0;$i < $count;$i++){
				$re += self::update($key[$i],$value);
			}
			self::save();
			return $re;
		}elseif(!is_array($key) && !is_array($value)){
			$key = self::encode($key);
			$val = self::encode($value);
			$to  = ';'.$key.':'.$val.';';
			self::$dataString = preg_replace('/;'.preg_quote($key).':[\s\S]+?;/',$to,self::$dataString,-1,$count);
			self::save();
			return $count;
		}
		self::save();
		return false;
	}

	/**
	 * @param $key
	 *
	 * @return bool
	 */
	public static function issetKey($key){
		$pattern = '/;'.preg_quote(self::decode($key)).':[\s\S]+?;/';
		preg_match_all($pattern,self::$dataString,$matches);
		return count($matches[0]) != 0;
	}

	/**
	 * @param $key
	 * @param $value
	 *
	 * @return void
	 */
	public static function insert($key,$value) {
		if(self::issetKey($key)){
			self::update($key,$value);
		}else{
			self::$dataString .= self::encode($key).':'.self::encode($value).';';
			self::save();
		}
	}

	/**
	 * @param $key
	 *
	 * @return void
	 */
	public static function delete($key){
		$pattern = ';'.self::encode($key).':[\s\S]+?;';
		self::$dataString = preg_replace($pattern,';',self::$dataString);
		self::save();
	}

	/**
	 * @return void
	 */
	public static function save(){
		file_put_contents('lib/database/nosql.db',self::$dataString);
	}

	/**
	 * @return void
	 */
	public static function load(){
		self::$dataString = file_get_contents('lib/database/nosql.db');
		self::$dataArray  = self::makeArray();
	}

	/**
	 * @param $key
	 *
	 * @return bool
	 */
	public static function get($key){
		$pattern = '/;'.preg_quote(self::encode($key)).':([\s\S]+?);/';
		preg_match_all($pattern,self::$dataString,$matches);
		if(isset($matches[1][0])){
			return $matches[1][0];
		}
		return false;
	}

	/**
	 * Alias for insert
	 * @param $key
	 * @param $value
	 *
	 * @return void
	 */
	public static function set($key,$value){
		self::insert($key,$value);
	}
}