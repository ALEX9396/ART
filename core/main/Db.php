<?php

    class Db{
        private $conn;

        private $mode;

        private $fails = 0;

        private $ended = false;

        public const AUTO_COMMIT_ON = 0;
        public const AUTO_COMMIT_OFF = 1;

        function __construct($mode = Db::AUTO_COMMIT_ON){
            $this->mode = $mode;

            $db_config = Config::get('db');

            $this->conn = mysqli_connect(
                $db_config['host'],
                $db_config['username'],
                $db_config['password'],
                $db_config['host']
            );

            if($mode == self::AUTO_COMMIT_OFF){
                $this->conn->autocommit(false);
            }
        }

        function exec($query){
            $res = $this->conn->query($query);
            if(!$res){
                $this->fails += 1;
            }

            return $res;
        }

        function fetch($query, Closure $loopable = null){
            $stmt = $this->conn->prepare($query);
            
            $res = $stmt->get_result();

			$rows = [];
			while($row = $res->fetch_assoc()){
				if($loopable!=null){
					$row = call_user_func($loopable, $row);
                }
                
				array_push($rows,$row);
			}
			
			return $rows;
        }

        function fetchOne(){
            $stmt = $this->conn->prepare($query);
			$res = $stmt->get_result();
			return $res->fetch_assoc();
        }

        function end(){
            if($this->mode == self::AUTO_COMMIT_OFF){
                if($this->fails > 0){
                    $this->commit();
                    return;
                }

                $this->rollback();
            }

            $this->ended = true;
        }

        function commit(){
            $this->conn->commit();

            $this->ended = true;
        }

        function rollback(){
            $this->conn->rollback();

            $this->ended = true;
        }

        function __destruct(){
            if(!$this->ended){
                $this->end;
            }

            $this->conn = null;
        }
    }

?>