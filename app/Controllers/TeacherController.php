<?php

//! TeacherController (Classe gérant l'affichage des pages relatives aux enseignants)

//? Namespace 
namespace App\Controllers;

//? Use
use App\Models\Teacher;

class TeacherController extends CoreController
{
    public function list()
    {
        $this->generateCSRFToken();

        $teachersList = Teacher::findAll("teacher", "Teacher");

        $viewVars = [
            "teachersList" => $teachersList
        ];

        $this->show("teacher/list", $viewVars);
    }

    public function add()
    {
        $this->generateCSRFToken();

        $this->show('teacher/add');
    }

    public function addPost()
    {
        $router = $this->router;

        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
        $job = filter_input(INPUT_POST, 'job', FILTER_SANITIZE_STRING);
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);

        $errorList = [];

        foreach ($_POST as $key => $value) {
            if (empty($value)) {
                $errorList[] = "Merci de remplir le champ : {$key} !";
            }
        }

        if (empty($errorList)) {
            $teacher = new Teacher();
            $teacher->setFirstname($firstname);
            $teacher->setLastname($lastname);
            $teacher->setJob($job);
            $teacher->setStatus($status);

            if ($teacher->save()) {
                header("Location: " . $router->generate('teacher-list'));
                exit;
            } else {
                $errorList[] = 'La sauvegarde a échoué';
            }
        }

        if (!empty($errorList)) {
            $this->show('teacher/add', ['errorList' => $errorList]);
            exit;
        }
    }

    public function update($id)
    {
        $this->generateCSRFToken();

        $teacher = Teacher::find($id, "teacher", "Teacher");

        $viewVars = [
            'teacher' => $teacher,
        ];

        $this->show('teacher/edit', $viewVars);
    }

    public function updatePost($id)
    {
        $router = $this->router;

        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
        $job = filter_input(INPUT_POST, 'job', FILTER_SANITIZE_STRING);
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);

        $errorList = [];

        $teacher = Teacher::find($id, "teacher", "Teacher");

        $teacher->setFirstname($firstname);
        $teacher->setLastname($lastname);
        $teacher->setJob($job);
        $teacher->setStatus($status);

        if ($teacher->save()) {
            header("Location: " . $router->generate("teacher-update", [ "id" => $teacher->getId()]));
            exit;
        } else {
            $errorList[] = 'La sauvegarde a échoué';
        }

        if (!empty($errorList)) {
            $this->show('teacher/edit', ['errorList' => $errorList]);
            exit;
        }
    }

    public function delete($id)
    {
        $router = $this->router;

        $teacher = Teacher::find($id, "teacher", "Teacher");

        $teacher->delete();

        header("Location: ".$router->generate('teacher-list'));
        exit;
    }
}