<?php
    class Dbcon{
        private $con;
        private $sql = "";
        private $res = "";

        public function __construct()
        {
            $servername = "localhost";
            $password = "2533";

//            用于开发环境
            $username = "reserveSystem";
            $dbname = "reserveSystem";

//              用于生产环境
//            $dbname = "running";
//            $username = "running";

            $this->con = new mysqli($servername, $username, $password, $dbname);
            if ($this->con->connect_error){
                return 1;
            }
            else return 0;
        }
        public function __destruct(){
            $this->con->close();
        }


        public function setSql($str){
            $this->sql = $str;
            $this->res = $this->con->query($this->sql);
        }
        public function getRes(){
            return $this->res;
        }
    }