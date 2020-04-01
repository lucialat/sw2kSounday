<?php


	class user {

		public static $className = "user";

		
		 private $id;
		 private $user;
		 private $name;
		 private $email;
         private $password;


		 public function __construct($id = null,$user = null,$name = null,$email = null,$password = null){
             $this->id = $id;
             if($id == null){
               $this->$id = uniqid();
             }
             $this->user = $user;
             $this->name = $name;
             $this->email = $email;
             $this->password = $password;
		 }

         public function getId(){
             return $this->id;
         }

         public function getUser(){
             return $this->user;
         }

		 public function getName(){
			 return $this->name;
		 }

		 public function getEmail(){
			 return $this->email;
		 }

		 public function getPassword(){
			 return $this->password;
		 }

         public function getThis($row = null,$id = null,$user = null,$name = null,$email = null,$password = null){
			if($row != null){
			   return new self($row["id"],$row["user"],$row["name"],$row["email"],$row["password"]);
			}
			return new self($id,$user,$name,$email,$password);
		 }
		 public function toString(){
			 return[
              "id"           => "".$this->id."",
              "user"         => "".$this->user."",
              "name"         => "".$this->name."",
              "firstName"         => "".$this->firstName."",
              "lastName"         => "".$this->lastName."",
			  "email"        => "".$this->email."",
			  "password"     => "".$this->password.""
			 ];
	     }

        public static function buscaUsuario($user){
            $user = databaseFactory::getTable("Users")->where("user", "=", $user)->get();
            return $user[0];
        }

        public function compruebaPassword($password){
            return $this->password == $password;
        }

        public static function login($user, $password){
            $user = self::buscaUsuario($user);
            if ($user != null && $user->compruebaPassword($password)) return $user;
            else return false;
        }

        public static function crea($user, $email, $contrasenia){
            return databaseFactory::getTable("Users")->insert(new user(null, $user, null, $email, $contrasenia));
        }
	}
?>