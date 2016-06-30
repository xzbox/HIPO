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
 *                             Created by Qti3e                              *
 *       <http://Qti3e.Github.io>    LO-VE    <Qti3eQti3e@Gmail.com>         *
 *****************************************************************************/
namespace lib\database;
if( ! defined('CRLF')) define('CRLF', sprintf('%s%s', chr(13), chr(10)));
/**
 * Class redis
 */
class myRedis{
    /**
     * @var
     */
    private $connection;
    private $host;
    private $port;
    /**
     * @param $host
     * @param int $port
     * @return bool
     * @throws myRedisException
     */
    public function connect($host,$port = 6379){
        $connection = @fsockopen($host,$port,$errorN,$errorStr);
        if($connection){
            $this->connection   = $connection;
            $this->host         = $host;
            $this->port         = $port;
            return true;
        }else{
            throw new myRedisException("Error when trying to make connection to server(#$errorN):\n\t$errorStr\n");
        }
    }

    /**
     * @param $command
     * @param array $ar
     * @return string
     */
    private function mkCommand($command,$ar = []){
        $count = count($ar);
        for($i = 0;$i < $count;$i++){
            $command .= ' "'.str_replace(["\n","\r","\""],['\n','\r','\"'],$ar[$i]).'"';
        }
        return $command;
    }

    /**
     * @param $command
     * @return array|bool|int|string
     * @throws myRedisException
     */
    public function runCommand($command){
        $handle = $this->connection;
        echo $command."\n";
        fwrite($handle,$command."\r\n");
        return $this->readReply();
    }

    private function readReply(){
        $reply  = fgets($this->connection);//fl:First Line
        $re     = false;
        $reply = rtrim($reply, CRLF);
        var_dump($reply);
        /**
         * http://redis.io/topics/protocol
         * In RESP, the type of some data depends on the first byte:
         * -For Simple Strings the first byte of the reply is "+"
         * -For Errors the first byte of the reply is "-"
         * -For Integers the first byte of the reply is ":"
         * -For Bulk Strings the first byte of the reply is "$"
         * -For Arrays the first byte of the reply is "*"
         */
        switch($reply[0]){
            case '+'://bool true    +OK\r\n
                $re = true;
                break;
            case '-'://bool false   -[Error Str]\r\n
                //throw new myRedisException($fl,$command);
                break;
            case ':'://Int          :[number]\r\n
                $re = (int)(substr($reply,1,-2));
                break;
            case '$'://String       $[len]\r\n(...Get more)\r\n
                if($reply == '$-1'){
                    return false;
                }
                $size   = (int) substr($reply, 1);
                $re     = substr(stream_get_contents($this->connection, $size + 2), 0, $size);;
                break;
            case '*'://Array        $[count]\r\n(..Get more)\r\n
                $count = substr($reply, 1);
                if ($count == '-1') return FALSE;
                $re     = array();
                for ($i = 0; $i < $count; $i++) {
                    $re[]   = $this->readReply();
                }
                break;
        }
        return $re;
    }

    /**
     * @param $key
     * @param $value
     * @return array|bool|int|string
     * @throws myRedisException
     */
    public function SET($key,$value){
        return $this->runCommand($this->mkCommand('SET',[
            $key,
            $value
        ]));
    }

    /**
     * @param $key
     * @return array|bool|int|string
     * @throws myRedisException
     */
    public function GET($key){
        if(count($this->KEYS($key)) > 0){
            return $this->runCommand($this->mkCommand('GET',[
                $key
            ]));
        }
        return false;
    }

    /**
     * @return array|bool|int|string
     * @throws myRedisException
     */
    public function FLUSHALL(){
        return $this->runCommand('FLUSHALL');
    }

    /**
     * @param $key
     * @param $field
     * @param $value
     * @return array|bool|int|string
     * @throws myRedisException
     */
    public function HSET($key,$field,$value){
        return $this->runCommand($this->mkCommand(
            'HSET',[
                $key,
                $field,
                $value
            ]
        ));
    }

    /**
     * @param $key
     * @return array
     * @throws myRedisException
     */
    public function HGETALL($key){
        $re = $this->runCommand($this->mkCommand(
            'HGETALL',[
                $key
            ]
        ));
        $return = [];
        $count  = count($re)/2;
        for($i = 0;$i < $count;$i++){
            $return[$re[$i*2]] = $re[$i*2+1];
        }
        return $return;
    }

    /**
     * @param $key
     * @param $field
     * @return array|bool|int|string
     * @throws myRedisException
     */
    public function HGET($key,$field){
        return $this->runCommand($this->mkCommand(
            'HGET',[
                $key,
                $field
            ]
        ));
    }

    /**
     * @param $key
     * @return array|bool|int|string
     * @throws myRedisException
     */
    public function HVALS($key){
        return $this->runCommand($this->mkCommand(
            'HVALS',[
                $key
            ]
        ));
    }

    /**
     * @return array|bool|int|string
     * @throws myRedisException
     */
    public function INFO(){
        return $this->runCommand('INFO');
    }

    /**
     * @return mixed
     */
    public function VER(){
        $info = $this->INFO();
        preg_match_all('/redis_version:([0-9\.]+)/',$info,$matches);
        return $matches[1][0];
    }

    /**
     * @param $key
     * @param $field
     * @return array|bool|int|string
     * @throws myRedisException
     */
    public function HSTRLEN($key,$field){
        return $this->runCommand($this->mkCommand(
            'HSTRLEN',[
                $key,
                $field
            ]
        ));
    }

    /**
     * @param $key
     * @return array|bool|int|string
     * @throws myRedisException
     */
    public function INCR($key){
        return $this->runCommand($this->mkCommand(
            'INCR',[
                $key
            ]
        ));
    }

    /**
     * @param $key
     * @return array|bool|int|string
     * @throws myRedisException
     */
    public function STRLEN($key){
        return $this->runCommand($this->mkCommand(
            'STRLEN',[
                $key
            ]
        ));
    }

    /**
     * @param $key
     * @param int $value
     * @return array|bool|int|string
     * @throws myRedisException
     */
    public function INCRBY($key,$value){
        return $this->runCommand($this->mkCommand(
            'INCRBY',[
                $key,
                $value
            ]
        ));
    }

    /**
     * @param $name
     *
     * @return array|bool|int|string
     * @throws myRedisException
     */
    public function KEYS($name){
        return $this->runCommand($this->mkCommand(
            'KEYS',[
                      $name
            ]
        ));
    }

    /**
     * @param $name
     *
     * @return array|bool|int|string
     * @throws myRedisException
     */
    public function DEL($name){
        return $this->runCommand($this->mkCommand(
            'DEL',[
                $name
            ]
        ));
    }

    /**
     * Close socket handler
     */
    public function __destruct() {
        fclose($this->connection);
    }
}