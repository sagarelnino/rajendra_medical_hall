<?php
class Role
{
    public $db;

    public function __construct($con)
    {
        $this->db = $con;
    }
    public static function getMyName(){
        return 'Role';
    }
    public function getAllRoles(){
        $st = $this->db->prepare("SELECT * FROM role");
        $st->execute();
        $resultSet = $st->fetchAll(PDO::FETCH_ASSOC);
        return $resultSet;
    }
    public function getRoleById($id){
        $st = $this->db->prepare("SELECT * FROM role WHERE id=:id");
        $st->bindParam(':id',$id);
        $st->execute();
        $resultSet = $st->fetch(PDO::FETCH_ASSOC);
        return $resultSet;
    }
    public function isExistRole($id){
        $st = $this->db->prepare("SELECT * FROM role WHERE id=:id");
        $st->bindParam(':id',$id);
        $st->execute();
        $resultSet = $st->fetch(PDO::FETCH_ASSOC);
        if($resultSet){
            return true;
        }
        return false;
    }
    public function isExistRoleByName($name){
        $st = $this->db->prepare("SELECT * FROM role WHERE name=:name");
        $st->bindParam(':naem',$name);
        $st->execute();
        $resultSet = $st->fetch(PDO::FETCH_ASSOC);
        if($resultSet){
            return true;
        }
        return false;
    }
    public function updateRole($name,$details,$updated,$id){
        $st = $this->db->prepare("UPDATE role SET name=:name, details=:details, updated=:updated WHERE id=:id");
        $st->bindParam(':name',$name);
        $st->bindParam(':details',$details);
        $st->bindParam(':updated',$updated);
        $st->bindParam(':id',$id);
        $st->execute();
        return true;
    }
}
?>