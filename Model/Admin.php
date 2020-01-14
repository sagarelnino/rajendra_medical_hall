<?php
	class Admin
	{
	    public $db;
	 	public  $fullname;
	 	public $username;
	 	public $password;
	 	public $adminTypeTextId;
	 	public $created;
	 	public $updated;
	    public function __construct($con)
	    {
	      $this->db = $con;
	    }
	    public static function getMyName(){
	    	return 'Admin';
	    }
	    public function getAllAdmins(){
	    	$st = $this->db->prepare("SELECT * FROM admin");
	    	$st->execute();
	    	$resultSet = $st->fetchAll(PDO::FETCH_ASSOC);
	    	return $resultSet;
		}
	    public function isExistAdmin($username,$password){
	    	$st = $this->db->prepare("SELECT * FROM admin WHERE username=:username AND password=:password");
	    	$st->bindParam(':username',$username);
	    	$st->bindParam(':password',$password);
	    	$st->execute();
	    	$resultSet = $st->fetch(PDO::FETCH_ASSOC);
	    	if($resultSet){
	    		return true;
	    	}
	    	return false;
	    }
        public function isExistAdminByUsername($username){
            $st = $this->db->prepare("SELECT * FROM admin WHERE username=:username");
            $st->bindParam(':username',$username);
            $st->execute();
            $resultSet = $st->fetch(PDO::FETCH_ASSOC);
            if($resultSet){
                return true;
            }
            return false;
        }
	    public function getAdminByUsernameAndPassword($username,$password){
	    	$st = $this->db->prepare("SELECT * FROM admin WHERE username=:username AND password=:password");
	    	$st->bindParam(':username',$username);
	    	$st->bindParam(':password',$password);
	    	$st->execute();
	    	$resultSet = $st->fetch(PDO::FETCH_ASSOC);
	    	return $resultSet;
	    }
	    public function getAdminById($id){
	    	$st = $this->db->prepare("SELECT * FROM admin WHERE id=:id");
	    	$st->bindParam(':id',$id);
	    	$st->execute();
	    	$resultSet = $st->fetch(PDO::FETCH_ASSOC);
	    	return $resultSet;
	    }
        public function updateAdmin($fullname,$username,$password,$updated,$id){
            $st = $this->db->prepare("UPDATE admin SET fullname=:fullname, username=:username, password=:password, updated=:updated WHERE id=:id");
            $st->bindParam(':fullname',$fullname);
            $st->bindParam(':username',$username);
            $st->bindParam(':password',$password);
            $st->bindParam(':updated',$updated);
            $st->bindParam(':id',$id);
            $st->execute();
            return true;
        }
        public function deleteAdmin($id){
        	$st = $this->db->prepare("DELETE FROM admin WHERE id=:id");
        	$st->bindParam(':id',$id);
        	$st->execute();
        	return true;
		}
		public function addAdmin($fullname,$adminTypeTextId,$username,$password,$created){
        	$st = $this->db->prepare("INSERT INTO admin (fullname,adminTypeTextId,username,password,created) VALUES (:fullname,:adminTypeTextId,:username,:password,:created)");
        	$st->bindParam(':fullname',$fullname);
        	$st->bindParam(':adminTypeTextId',$adminTypeTextId);
        	$st->bindParam(':username',$username);
        	$st->bindParam(':password',$password);
        	$st->bindParam(':created',$created);
        	$st->execute();
        	return true;
		}
        public function updateAdminByAdmin($fullname,$adminTypeTextId,$updated,$id){
            $st = $this->db->prepare("UPDATE admin SET fullname=:fullname,adminTypeTextId=:adminTypeTextId,updated=:updated WHERE id=:id");
            $st->bindParam(':fullname',$fullname);
            $st->bindParam(':adminTypeTextId',$adminTypeTextId);
            $st->bindParam(':updated',$updated);
            $st->bindParam(':id',$id);
            $st->execute();
            return true;
        }
	}		
?>    