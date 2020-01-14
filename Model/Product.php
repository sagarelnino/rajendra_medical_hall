<?php
class Product
{
    public $db;
    public $url;
    public $brandName;
    public $genericName;
    public $manufacturer;
    public $packSize;
    public $dosageForm;
    public $stockQuantity;
    public $buyPrice;
    public $salePrice;
    public $keptWhere;
    public $soldTimes;
    public $created;
    public $updated;

    public function __construct($con)
    {
        $this->db = $con;
    }
    public static function getMyName(){
        return 'Product';
    }
    public function getProductById($id){
        $st = $this->db->prepare("SELECT * FROM product WHERE id=:id");
        $st->bindParam(':id',$id);
        $st->execute();
        $resultSet = $st->fetch(PDO::FETCH_ASSOC);
        return $resultSet;
    }
    public function isExistProductById($id){
        $st = $this->db->prepare("SELECT * FROM product WHERE id=:id");
        $st->bindParam(':id',$id);
        $st->execute();
        $resultSet = $st->fetch(PDO::FETCH_ASSOC);
        if($resultSet){
            return true;
        }
        return false;
    }
    public function getAllProducts(){
        $st = $this->db->prepare("SELECT * FROM product LIMIT 40");
        $st->execute();
        $resultSet = $st->fetchAll(PDO::FETCH_ASSOC);
        return $resultSet;
    }
    public function getTopProducts(){
        $st = $this->db->prepare("SELECT * FROM product ORDER BY soldTimes DESC LIMIT 5");
        $st->execute();
        $resultSet = $st->fetchAll(PDO::FETCH_ASSOC);
        return $resultSet;
    }
    public function getLatestProducts(){
        $st = $this->db->prepare("SELECT * FROM product ORDER BY created DESC LIMIT 10");
        $st->execute();
        $resultSet = $st->fetchAll(PDO::FETCH_ASSOC);
        return $resultSet;
    }
    public function getAllProductsWithLimit($start, $limit){
        $st = $this->db->prepare("SELECT * FROM product ORDER BY soldTimes DESC LIMIT $start, $limit");
        $st->execute();
        $resultSet = $st->fetchAll(PDO::FETCH_ASSOC);
        return $resultSet;
    }
    public function getAllProductsNumber(){
        $st = $this->db->prepare("SELECT * FROM product");
        $st->execute();
        return $st->rowCount();
    }
    public function getSpeialProducts(){
        $st = $this->db->prepare("SELECT * FROM product WHERE isDone IS NULL");
        $st->execute();
        $resultSet = $st->fetchAll(PDO::FETCH_ASSOC);
        return $resultSet;
    }
    public function isExistProductByUrl($url){
        $st = $this->db->prepare("SELECT * FROM product WHERE url=:url");
        $st->bindParam(':url',$url);
        $st->execute();
        $resultSet = $st->fetchAll(PDO::FETCH_ASSOC);
        if($resultSet){
            return true;
        }
        return false;
    }
    public function addProductUrl($url){
        $st = $this->db->prepare("INSERT INTO product (url) VALUES (:url)");
        $st->bindParam(':url',$url);
        $st->execute();
        return true;
    }
    public function addProduct($brandName,$genericName,$manufacturer,$packSize,$dosageForm,$stockQuantity,$buyPrice,$salePrice,$keptWhere,$created){
        $st = $this->db->prepare("INSERT INTO product (brandName,genericName,manufacturer,packsize,dosageForm,stockQuantity,buyPrice,salePrice,keptWhere,created) VALUES (:brandName,:genericName,:manufacturer,:packSize,:dosageForm,:stockQuantity,:buyPrice,:salePrice,:keptWhere,:created)");
        $st->bindParam(':brandName',$brandName);
        $st->bindParam(':genericName',$genericName);
        $st->bindParam(':manufacturer',$manufacturer);
        $st->bindParam(':packSize',$packSize);
        $st->bindParam(':dosageForm',$dosageForm);
        $st->bindParam(':stockQuantity',$stockQuantity);
        $st->bindParam(':buyPrice',$buyPrice);
        $st->bindParam(':salePrice',$salePrice);
        $st->bindParam(':keptWhere',$keptWhere);
        $st->bindParam(':created',$created);
        $st->execute();
        return true;
    }
    public function updateProductApiById($brandName,$genericName,$manufacturer,$packSize,$dosageForm,$salePrice,$isDone,$created,$id){
        $st = $this->db->prepare("UPDATE product SET brandName=:brandName,genericName=:genericName,manufacturer=:manufacturer,packSize=:packSize,dosageForm=:dosageForm,salePrice=:salePrice,isDone=:isDone,created=:created WHERE id=:id");
        $st->bindParam(':brandName',$brandName);
        $st->bindParam(':genericName',$genericName);
        $st->bindParam(':manufacturer',$manufacturer);
        $st->bindParam(':packSize',$packSize);
        $st->bindParam(':dosageForm',$dosageForm);
        $st->bindParam(':salePrice',$salePrice);
        $st->bindParam(':isDone',$isDone);
        $st->bindParam(':created',$created);
        $st->bindParam(':id',$id);
        $st->execute();
        return true;
    }
    public function updateProductApiPriceById($salePrice,$isDone,$updated,$id){
        $st = $this->db->prepare("UPDATE product SET salePrice=:salePrice,isDone=:isDone,updated=:updated WHERE id=:id");
        $st->bindParam(':salePrice',$salePrice);
        $st->bindParam(':isDone',$isDone);
        $st->bindParam(':updated',$updated);
        $st->bindParam(':id',$id);
        $st->execute();
        return true;
    }
    public function updateProductById($brandName,$genericName,$manufacturer,$packSize,$dosageForm,$stockQuantity,$buyPrice,$salePrice,$keptWhere,$updated,$id){
        $st = $this->db->prepare("UPDATE product SET brandName=:brandName,genericName=:genericName,manufacturer=:manufacturer,packSize=:packSize,dosageForm=:dosageForm,stockQuantity=:stockQuantity,buyPrice=:buyPrice,salePrice=:salePrice,keptWhere=:keptWhere,updated=:updated WHERE id=:id");
        $st->bindParam(':brandName',$brandName);
        $st->bindParam(':genericName',$genericName);
        $st->bindParam(':manufacturer',$manufacturer);
        $st->bindParam(':packSize',$packSize);
        $st->bindParam(':dosageForm',$dosageForm);
        $st->bindParam(':stockQuantity',$stockQuantity);
        $st->bindParam(':buyPrice',$buyPrice);
        $st->bindParam(':salePrice',$salePrice);
        $st->bindParam(':keptWhere',$keptWhere);
        $st->bindParam(':updated',$updated);
        $st->bindParam(':id',$id);
        $st->execute();
        return true;
    }
    public function deleteProduct($id){
        $st = $this->db->prepare("DELETE FROM product WHERE id=:id");
        $st->bindParam(':id',$id);
        $st->execute();
        return true;
    }
    public function getSearchedResults($query){
        $st = $this->db->prepare("SELECT * FROM product WHERE brandName LIKE '$query%' ORDER BY soldTimes DESC");
        $st->execute();
        $resultSet = $st->fetchAll(PDO::FETCH_ASSOC);
        return $resultSet;
    }
    public function getManufacturerList($query){
        $st = $this->db->prepare("SELECT DISTINCT manufacturer FROM product WHERE manufacturer LIKE '$query%'");
        $st->execute();
        $resultSet = $st->fetchAll(PDO::FETCH_ASSOC);
        return $resultSet;
    }
    public function getPackSizeList($query){
        $st = $this->db->prepare("SELECT DISTINCT packSize FROM product WHERE packSize LIKE '$query%'");
        $st->execute();
        $resultSet = $st->fetchAll(PDO::FETCH_ASSOC);
        return $resultSet;
    }
    public function getDosageFormList($query){
        $st = $this->db->prepare("SELECT DISTINCT dosageForm FROM product WHERE dosageForm LIKE '$query%'");
        $st->execute();
        $resultSet = $st->fetchAll(PDO::FETCH_ASSOC);
        return $resultSet;
    }
    public function getSearchedProducts($query){
        $st = $this->db->prepare("SELECT * FROM product WHERE brandName LIKE '$query%'");
        $st->execute();
        $resultSet = $st->fetchAll(PDO::FETCH_ASSOC);
        return $resultSet;
    }
    public function updateIsInStock($id){
        $st = $this->db->prepare("UPDATE product SET isInStock = 'Yes' WHERE id=:id");
        $st->bindParam(':id',$id);
        $st->execute();
        return true;
    }
    public function updateIsInStockOk($id){
        $st = $this->db->prepare("UPDATE product SET isInStock = NULL WHERE id=:id");
        $st->bindParam(':id',$id);
        $st->execute();
        return true;
    }
    public function addSoldTimes($quantity,$id){
        $st = $this->db->prepare('UPDATE product SET soldTimes=soldTimes+:quantity, stockQuantity=stockQuantity-:quantity WHERE id=:id');
        $st->bindParam('quantity',$quantity);
        $st->bindParam('id',$id);
        $st->execute();
        return true;
    }
    public function addLoan($productId,$takenFrom,$takenQuantity,$takenBy,$created){
        $st = $this->db->prepare("INSERT INTO loan (productId,takenFrom,takenQuantity,takenBy,created) VALUES (:productId,:takenFrom,:takenQuantity,:takenBy,:created)");
        $st->bindParam(':productId',$productId);
        $st->bindParam(':takenFrom',$takenFrom);
        $st->bindParam(':takenQuantity',$takenQuantity);
        $st->bindParam(':takenBy',$takenBy);
        $st->bindParam(':created',$created);
        $st->execute();
        return true;
    }
    public function deleteLoanedProducts($productId){
        $st = $this->db->prepare("DELETE FROM loan WHERE productId=:productId");
        $st->bindParam(':productId',$productId);
        $st->execute();
        return true;
    }
    public function isExistAnyLoanedProductByProductId($productId){
        $st = $this->db->prepare("SELECT * FROM loan WHERE productId=:productId");
        $st->bindParam(':productId',$productId);
        $st->execute();
        if($st->rowCount()){
            return true;
        }
        return false;
    }
    public function getAllLoanRecords(){
        $st = $this->db->prepare("SELECT * FROM loan");
        $st->execute();
        $resultSet = $st->fetchAll(PDO::FETCH_ASSOC);
        return $resultSet;
    }
    public function getLoanById($id){
        $st = $this->db->prepare("SELECT * FROM loan WHERE id=:id");
        $st->bindParam(':id',$id);
        $st->execute();
        $resultSet = $st->fetch(PDO::FETCH_ASSOC);
        return $resultSet;
    }
    public function dismissLoan($quantity,$productId){
        $st = $this->db->prepare("UPDATE product SET stockQuantity = stockQuantity+:quantity WHERE id=:id");
        $st->bindParam(':quantity',$quantity);
        $st->bindParam(':id',$productId);
        $st->execute();
        return true;
    }
    public function backLoan($quantity,$loanId){
        $st = $this->db->prepare("UPDATE loan SET takenQuantity = takenQuantity-:quantity WHERE id=:id");
        $st->bindParam(':quantity',$quantity);
        $st->bindParam(':id',$loanId);
        $st->execute();
        return true;
    }
    public function deleteLoan($id){
        $st = $this->db->prepare("DELETE FROM loan WHERE id=:id");
        $st->bindParam(':id',$id);
        $st->execute();
        return true;
    }
}
?>