<?php
    class Expense
    {
        public $db;
        public function __construct($con)
        {
            $this->db = $con;
        }
        public function addExpense($expenseTo,$expensePurpose,$expenseAmount,$issuedBy,$created){
            $st = $this->db->prepare("INSERT INTO expense(expenseTo,expensePurpose,expenseAmount,issuedBy,created) VALUES(:expenseTo,:expensePurpose,:expenseAmount,:issuedBy,:created)");
            $st->bindParam(':expenseTo',$expenseTo);
            $st->bindParam(':expensePurpose',$expensePurpose);
            $st->bindParam(':expenseAmount',$expenseAmount);
            $st->bindParam(':issuedBy',$issuedBy);
            $st->bindParam(':created',$created);
            $st->execute();
            return true;
        }
        public function getAllExpense(){
            $st = $this->db->prepare("SELECT * FROM expense");
            $st->execute();
            $resultSet = $st->fetchAll(PDO::FETCH_ASSOC);
            return $resultSet;
        }
        public function getTopExpense(){
            $st = $this->db->prepare("SELECT * FROM expense ORDER BY created DESC LIMIT 5");
            $st->execute();
            $resultSet = $st->fetchAll(PDO::FETCH_ASSOC);
            return $resultSet;
        }
        public function deleteExpense($id){
            $st = $this->db->prepare("DELETE FROM expense WHERE id=:id");
            $st->bindParam(':id',$id);
            $st->execute();
            return true;
        }
        public function getExpenseById($id){
            $st = $this->db->prepare("SELECT * FROM expense WHERE id=:id");
            $st->bindParam(':id',$id);
            $st->execute();
            $resultSet = $st->fetch(PDO::FETCH_ASSOC);
            return $resultSet;
        }
        public function getAllExpenseSumByDate($date){
            $st = $this->db->prepare("SELECT SUM(expenseAmount) FROM expense WHERE created LIKE CONCAT(:date,'%')");
            $st->bindParam(':date',$date);
            $st->execute();
            $resultSet = $st->fetch(PDO::FETCH_NUM);
            return $resultSet;
        }
        public function getAllExpenseByDate($date){
            $st = $this->db->prepare("SELECT * FROM expense WHERE created LIKE CONCAT(:date,'%')");
            $st->bindParam(':date',$date);
            $st->execute();
            $resultSet = $st->fetchAll(PDO::FETCH_ASSOC);
            return $resultSet;
        }
        public function getAllExpensesNumber(){
            $st = $this->db->prepare("SELECT * FROM expense");
            $st->execute();
            return $st->rowCount();
        }
        public function getAllExpensesWithLimit($start, $limit){
            $st = $this->db->prepare("SELECT * FROM expense ORDER BY created DESC LIMIT $start, $limit");
            $st->execute();
            $resultSet = $st->fetchAll(PDO::FETCH_ASSOC);
            return $resultSet;
        }
    }
?>