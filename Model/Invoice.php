<?php
class Invoice
{
    public $db;
    public function __construct($con)
    {
        $this->db = $con;
    }
    public static function getMyName(){
        return 'Invoice';
    }
    public function addInvoice($userId,$invoiceItems,$netPrice,$discount,$total,$created){
        $st = $this->db->prepare("INSERT INTO invoice (userId,invoiceItems,netPrice,discount,total,created) VALUES (:userId,:invoiceItems,:netPrice,:discount,:total,:created)");
        $st->bindParam(':userId',$userId);
        $st->bindParam(':invoiceItems',$invoiceItems);
        $st->bindParam(':netPrice',$netPrice);
        $st->bindParam(':discount',$discount);
        $st->bindParam(':total',$total);
        $st->bindParam(':created',$created);
        $st->execute();
        return $this->db->lastInsertId();
    }
    public function getInvoiceById($invoiceId){
        $st = $this->db->prepare("SELECT * FROM invoice WHERE id=:id");
        $st->bindParam(':id',$invoiceId);
        $st->execute();
        $resultSet = $st->fetch(PDO::FETCH_ASSOC);
        return $resultSet;
    }
    public function isExistInvoiceById($id){
        $st = $this->db->prepare("SELECT * FROM invoice WHERE id=:id");
        $st->bindParam('id',$id);
        $st->execute();
        if($st->rowCount()){
            return true;
        }
        return false;
    }
    public function getAllInvoices(){
        $st = $this->db->prepare("SELECT * FROM invoice ORDER BY created DESC");
        $st->execute();
        $resultSet = $st->fetchAll(PDO::FETCH_ASSOC);
        return $resultSet;
    }
    public function getTopInvoices(){
        $st = $this->db->prepare("SELECT * FROM invoice ORDER BY created DESC LIMIT 5");
        $st->execute();
        $resultSet = $st->fetchAll(PDO::FETCH_ASSOC);
        return $resultSet;
    }
    public function getAllInvoicesSumByDate($date){
        $st = $this->db->prepare("SELECT SUM(total) FROM invoice WHERE created LIKE CONCAT(:date,'%')");
        $st->bindParam(':date',$date);
        $st->execute();
        $resultSet = $st->fetch(PDO::FETCH_NUM);
        return $resultSet;
    }
    public function getAllInvoicesByDate($date){
        $st = $this->db->prepare("SELECT * FROM invoice WHERE created LIKE CONCAT(:date,'%')");
        $st->bindParam(':date',$date);
        $st->execute();
        $resultSet = $st->fetchAll(PDO::FETCH_ASSOC);
        return $resultSet;
    }
    public function getAllInvoicesNumber(){
        $st = $this->db->prepare("SELECT * FROM invoice");
        $st->execute();
        return $st->rowCount();
    }
    public function getAllInvoicesWithLimit($start, $limit){
        $st = $this->db->prepare("SELECT * FROM invoice ORDER BY created DESC LIMIT $start, $limit");
        $st->execute();
        $resultSet = $st->fetchAll(PDO::FETCH_ASSOC);
        return $resultSet;
    }
}
?>