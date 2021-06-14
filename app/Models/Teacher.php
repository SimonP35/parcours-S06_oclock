<?php

//! TeacherModel (Classe représentant la table teacher dans la DB)

//? Namespace 
namespace App\Models;

use App\Utils\Database;
use PDO;

class Teacher extends CoreModel
{
    //?===========================================
    //?               Propriétés
    //?===========================================

    protected $firstname;
    protected $lastname;
    protected $job;

    //?===========================================
    //?               Méthodes
    //?===========================================

    public function insert()
    {
        $pdo = Database::getPDO();

        $sql = "INSERT INTO `teacher` (firstname, lastname, job, status, created_at)
            VALUES (:firstname, :lastname, :job, :status, NOW())
        ";

        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $pdoStatement->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $pdoStatement->bindValue(':job', $this->job, PDO::PARAM_STR);
        $pdoStatement->bindValue(':status', $this->status, PDO::PARAM_STR);

        $validateRequest = $pdoStatement->execute();

        return $validateRequest;
    }

    public function update()
    {
        $pdo = Database::getPDO();

        $sql = "UPDATE `teacher`
        SET
            firstname = :firstname,
            lastname = :lastname,
            job = :job,
            status = :status,
            updated_at = NOW()
        WHERE id = :id
        ";

        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $pdoStatement->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $pdoStatement->bindValue(':job', $this->job, PDO::PARAM_STR);
        $pdoStatement->bindValue(':status', $this->status, PDO::PARAM_INT);
        $pdoStatement->bindValue(':id', $this->id);

        $validateRequest = $pdoStatement->execute();
        return $validateRequest;
    }

    public function delete()
    {
        $pdo = Database::getPDO();

        $sql = "DELETE FROM `teacher`
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

    /**
     * Get the value of job
     */ 
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set the value of job
     *
     * @return  self
     */ 
    public function setJob($job)
    {
        $this->job = $job;

        return $this;
    }
}