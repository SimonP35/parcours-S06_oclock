<?php

//! AppUserModel (Classe représentant la table app_user dans la DB)

//? Namespace 
namespace App\Models;

use App\Utils\Database;
use PDO;

class AppUser extends CoreModel
{
    //?===========================================
    //?               Propriétés
    //?===========================================

    private $email;
    private $name;
    private $password;
    private $role;

    //?===========================================
    //?               Méthodes
    //?===========================================

    public static function findByEmail($email)
    {
        $pdo = Database::getPDO();
        $sql = "SELECT *
            FROM `app_user`
            WHERE `email` = :email";
    
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':email', $email);
        $validateRequest = $pdoStatement->execute();
    
        if ($validateRequest === true) {
        
            return $pdoStatement->fetchObject(self::class);
        }
        
        return false;
  
    }
  
    public function insert()
    {
        $pdo = Database::getPDO();

        $sql = "INSERT INTO `app_user` (email, name, created_at, role, password, status)
            VALUES (:email, :name, NOW(),:role, :password, :status)
        ";

        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':email', $this->email, PDO::PARAM_STR);
        $pdoStatement->bindValue(':name', $this->name, PDO::PARAM_STR);
        $pdoStatement->bindValue(':password', $this->password, PDO::PARAM_STR);
        $pdoStatement->bindValue(':status', $this->status, PDO::PARAM_STR);
        $pdoStatement->bindValue(':role', $this->role, PDO::PARAM_STR);

        $validateRequest = $pdoStatement->execute();

        return $validateRequest;

    }

    public function update()
    {
        $pdo = Database::getPDO();

        $sql = "UPDATE `app_user`
        SET
            email = :email,
            name = :name,
            password = :password,
            role = :role,
            status = :status,
            updated_at = NOW()
        WHERE id = :id
        ";

        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':email', $this->email, PDO::PARAM_STR);
        $pdoStatement->bindValue(':name', $this->name, PDO::PARAM_STR);
        $pdoStatement->bindValue(':password', $this->password, PDO::PARAM_STR);
        $pdoStatement->bindValue(':role', $this->role, PDO::PARAM_STR);
        $pdoStatement->bindValue(':status', $this->status, PDO::PARAM_STR);
        $pdoStatement->bindValue(':id', $this->id);

        $validateRequest = $pdoStatement->execute();
        return $validateRequest;
    }

    public function delete()
    {
        $pdo = Database::getPDO();

        $sql = "DELETE FROM `app_user`
        WHERE id = :id
        ";

        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);

        $validateRequest = $pdoStatement->execute();
        return $validateRequest;

    }

    //?===========================================
    //?             Getter & Setter 
    //?===========================================

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of role
     */ 
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */ 
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }
}