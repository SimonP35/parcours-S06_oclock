<?php

//! CoreModel (Classe abstraite parent des autres Models)

//? Namespace 
namespace App\Models;

use App\Utils\Database;
use PDO;

abstract class CoreModel {

    //?===========================================
    //?               Propriétés
    //?===========================================

    protected $id;
    protected $status;
    protected $created_at;
    protected $updated_at;
    protected $teacher_id;

    //?===========================================
    //?               Méthodes
    //?===========================================

    abstract public function insert();
    abstract public function update();
    abstract public function delete();

    public static function find($id, $table, $Model)
    {
        $pdo = Database::getPDO();
        $sql = "SELECT * FROM `$table` WHERE `id` = $id";
        $pdoStatement = $pdo->query($sql);
        return $pdoStatement->fetchObject("App\Models\\$Model");
    }

    public static function findAll($table, $Model) 
    { 
        $pdo = Database::getPDO();            
        $sql = "SELECT * FROM `$table`";
        $statement = $pdo->query( $sql );            
        return $statement->fetchAll( PDO::FETCH_CLASS, "App\Models\\$Model" );
    }
     
    public function save() 
    {
        if($this->id != null){
            return $this->update();
        } else {
            return $this->insert();
        }
    }

    //?===========================================
    //?             Getter & Setter 
    //?===========================================

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of firstname
     */ 
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @return  self
     */ 
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of lastname
     */ 
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @return  self
     */ 
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of created_at
     */ 
    public function getCreated_at()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */ 
    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Get the value of updated_at
     */ 
    public function getUpdated_at()
    {
        return $this->updated_at;
    }

    /**
     * Set the value of updated_at
     *
     * @return  self
     */ 
    public function setUpdated_at($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * Get the value of teacher_id
     */ 
    public function getTeacherId()
    {
        return $this->teacher_id;
    }

    /**
     * Set the value of teacher_id
     *
     * @return  self
     */ 
    public function setTeacherId($teacher_id)
    {
        $this->teacher_id = $teacher_id;

        return $this;
    }
}
