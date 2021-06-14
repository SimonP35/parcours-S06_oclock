<?php

//! StudentModel (Classe représentant la table student dans la DB)

//? Namespace 
namespace App\Models;

use App\Utils\Database;
use PDO;

class Student extends CoreModel
{
    //?===========================================
    //?               Propriétés
    //?===========================================

    protected $firstname;
    protected $lastname;

    //?===========================================
    //?               Méthodes
    //?===========================================

    public function insert()
    {
        $pdo = Database::getPDO();

        $sql = "INSERT INTO `student` (firstname, lastname, created_at, teacher_id, status)
            VALUES (:firstname, :lastname, NOW(), :teacher_id, :status)
        ";

        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $pdoStatement->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $pdoStatement->bindValue(':teacher_id', $this->teacher_id, PDO::PARAM_STR);
        $pdoStatement->bindValue(':status', $this->status, PDO::PARAM_STR);

        $validateRequest = $pdoStatement->execute();

        return $validateRequest;
    }

    public function update()
    {
        $pdo = Database::getPDO();

        $sql = "UPDATE `student`
        SET
            firstname = :firstname,
            lastname = :lastname,
            teacher_id = :teacher_id,
            status = :status,
            updated_at = NOW()
        WHERE id = :id
        ";

        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $pdoStatement->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $pdoStatement->bindValue(':teacher_id', $this->teacher_id, PDO::PARAM_STR);
        $pdoStatement->bindValue(':status', $this->status, PDO::PARAM_STR);
        $pdoStatement->bindValue(':id', $this->id);

        $validateRequest = $pdoStatement->execute();
        return $validateRequest;
    }

    public function delete()
    {
        $pdo = Database::getPDO();

        $sql = "DELETE FROM `student`
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
}