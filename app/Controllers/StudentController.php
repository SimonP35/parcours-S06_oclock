<?php

//! StudentController (Classe gérant l'affichage des pages relatives aux étudiants)

//? Namespace 
namespace App\Controllers;

//? Use
use App\Models\Student; 
use App\Models\Teacher; 

class StudentController extends CoreController
{
    public function list()
    {
        $this->generateCSRFToken();

        $studentsList = Student::findAll("student", "Student");
        $teachers = Teacher::findAll("teacher", "Teacher");

        $viewVars = [
            "studentsList" => $studentsList,
            'teachers' => $teachers,
        ];

        $this->show("student/list", $viewVars);
    }

    public function add()
    {
        $this->generateCSRFToken();

        $teachers = Teacher::findAll("teacher", "Teacher");

        $viewVars = [
            'teachers' => $teachers,
        ];

        $this->show('student/add', $viewVars);
    }

    public function addPost()
    {
        $router = $this->router;

        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
        $teacher_id = filter_input(INPUT_POST, 'teacher', FILTER_VALIDATE_INT);

        $errorList = [];

        foreach ($_POST as $key => $value) {
            if (empty($value)) {
                $errorList[] = "Merci de remplir le champ : {$key} !";
            }
        }

        if (empty($errorList)) {
            
            $student = new Student();
            $student->setFirstname($firstname);
            $student->setLastname($lastname);
            $student->setStatus($status);
            $student->setTeacherId($teacher_id);

            if ($student->save()) {
                header("Location: ".$router->generate('student-list'));
                exit;
            } else {
                $errorList[] = 'La sauvegarde a échoué';
            }
        }

        if (!empty($errorList)) {
            $this->show('student/add', [ 'errorList' => $errorList ]);
            exit;
        }
    }

    public function update($id)
    {
        $this->generateCSRFToken();

        $student = Student::find($id, "student", "Student");
        $teachers = Teacher::findAll("teacher", "Teacher");

        $viewVars = [
            'student' => $student,
            'teachers' => $teachers,
        ];

        $this->show('student/edit', $viewVars);
    }

    public function updatePost($id)
    {
        $router = $this->router;

        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
        $teacher_id = filter_input(INPUT_POST, 'teacher_id', FILTER_VALIDATE_INT);

        $errorList = [];

        $student = Student::find($id, "student", "Student");

        $student->setFirstname($firstname);
        $student->setLastname($lastname);
        $student->setStatus($status);
        $student->setTeacherId($teacher_id);

        if ($student->save()) {
            header("Location: " . $router->generate("student-update", [ "id" => $student->getId()]));
            exit;
        } else {
            $errorList[] = 'La sauvegarde a échoué';
        }

        if (!empty($errorList)) {
            $this->show('student/edit', ['errorList' => $errorList]);
            exit;
        }
    }

    public function delete($id)
    {
        $router = $this->router;

        $student = Student::find($id, "student", "Student");

        $student->delete();

        header("Location: ".$router->generate('student-list'));
        exit;
    }

}