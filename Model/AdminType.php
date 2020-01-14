<?php
class AdminType
{
    public $db;

    public function __construct($con)
    {
        $this->db = $con;
    }
    public static function getMyName(){
        return 'AdminType';
    }
    public function getAllAdminTypes(){
        $st = $this->db->prepare("SELECT * FROM admintype");
        $st->execute();
        $resultSet = $st->fetchAll(PDO::FETCH_ASSOC);
        return $resultSet;
    }
    public function getadminTypeByTextId($textId){
        $st = $this->db->prepare("SELECT * FROM admintype WHERE textId=:textId");
        $st->bindParam(':textId',$textId);
        $st->execute();
        $resultSet = $st->fetch(PDO::FETCH_ASSOC);
        return $resultSet;
    }
    public function isExistAdminType($textId){
        $st = $this->db->prepare("SELECT * FROM admintype WHERE textId=:textId");
        $st->bindParam(':textId',$textId);
        $st->execute();
        $resultSet = $st->fetch(PDO::FETCH_ASSOC);
        if($resultSet){
            return true;
        }
        return false;
    }
    public function updateRole($name,$details,$id){
        $st = $this->db->prepare("UPDATE role SET name=:name, details=:details WHERE id=:id");
        $st->bindParam(':name',$name);
        $st->bindParam(':details',$details);
        $st->bindParam(':id',$id);
        $st->execute();
        return true;
    }
    public function deleteAdminType($textId){
        $st = $this->db->prepare("DELETE FROM admintype WHERE textId=:textId");
        $st->bindParam(':textId',$textId);
        $st->execute();
        return true;
    }
    public function rolesArrayFromRoleIdCsv($roleIdCsv,$role){
        $roleIdCsv = explode(',',$roleIdCsv);
        $rolesArray = array();
        /**
         * @var $role Role
         */
        foreach ($roleIdCsv as $singleRole){
            if(empty($singleRole)){
                continue;
            }
            $singleRole = $role->getRoleById($singleRole);
            $rolesArray[] = $singleRole['name'];
        }
        return $rolesArray;
    }
    /*public function addAdminType($roleIdCsv,$name,$textId,$created){
        $st = $this->db->prepare("INSERT INTO admintype (roleIdCsv,name,textId,created) VALUES(:roleIdCsv,:name,;textId,:created)");
        $st->bindParam(':roleIdCsv', $roleIdCsv);
        $st->bindParam(':name', $name);
        $st->bindParam(':textId', $textId);
        $st->bindParam(':created', $created);
        $st->execute();
        return true;
    }*/
    public function addAdminType($roleIdCsv,$name,$textId,$created)
    {
        $st = $this->db->prepare("INSERT INTO admintype (roleIdCsv,name,textId,created) VALUES (:roleIdCsv,:name,:textId,:created)");
        $st->bindParam(':roleIdCsv',$roleIdCsv);
        $st->bindParam(':name',$name);
        $st->bindParam(':textId',$textId);
        $st->bindParam(':created',$created);
        $st->execute();
        return true;
    }
    public function updateAdminType($roleIdCsv,$name,$updated,$textId)
    {
        $st = $this->db->prepare("UPDATE admintype SET roleIdCsv=:roleIdCsv, name=:name, updated=:updated WHERE textId=:textId");
        $st->bindParam(':roleIdCsv',$roleIdCsv);
        $st->bindParam(':name',$name);
        $st->bindParam(':updated',$updated);
        $st->bindParam(':textId',$textId);
        $st->execute();
        return true;
    }
    public function getAdminTypeNameByTextId($textId){
        $st = $this->db->prepare("SELECT * FROM admintype WHERE textId=:textId");
        $st->bindParam(':textId',$textId);
        $st->execute();
        $resultSet = $st->fetch(PDO::FETCH_ASSOC);
        return $resultSet['name'];
    }
}
?>