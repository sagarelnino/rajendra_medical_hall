<?php
    class Log
    {
        public $db;
        public function __construct($con)
        {
            $this->db = $con;
        }
        public function addLog($logDetails,$adminId,$created){
            $st = $this->db->prepare("INSERT INTO log(logDetails,adminId,created) VALUES(:logDetails,:adminId,:created)");
            $st->bindParam(':logDetails',$logDetails);
            $st->bindParam(':adminId',$adminId);
            $st->bindParam(':created',$created);
            $st->execute();
            return true;
        }
        public function getAllLogs(){
            $st = $this->db->prepare("SELECT * FROM log");
            $st->execute();
            $resultSet = $st->fetchAll(PDO::FETCH_ASSOC);
            return $resultSet;
        }
        public function deleteLog($id){
            $st = $this->db->prepare("DELETE FROM log WHERE id=:id");
            $st->bindParam(':id',$id);
            $st->execute();
            return true;
        }
        public function getAllLogsNumber(){
            $st = $this->db->prepare("SELECT * FROM log");
            $st->execute();
            return $st->rowCount();
        }
        public function getAllLogsWithLimit($start, $limit){
            $st = $this->db->prepare("SELECT * FROM log ORDER BY created DESC LIMIT $start, $limit");
            $st->execute();
            $resultSet = $st->fetchAll(PDO::FETCH_ASSOC);
            return $resultSet;
        }
    }
?>