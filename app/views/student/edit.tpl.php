
    <div class="container my-4"> <a href="<?= $router->generate("student-list") ?>" class="btn btn-success float-right">Retour</a>
        <h2>Mettre à jour un étudiant</h2>

        <?php if (!empty($viewVars['errorList'])) : ?>
           <?php foreach ($errorList as $error) : ?>
               <div class="alert alert-danger" role="alert">
                   <?= $error ?>
               </div>
           <?php endforeach ?>
       <?php endif ?>

        <form action="" method="POST" class="mt-5">
            <div class="form-group">
                <label for="firstname">Prénom</label>
                <input type="text" class="form-control" name="firstname" id="firstname" placeholder="" value="<?= $student->getFirstname() ?>">
            </div>
            <div class="form-group">
                <label for="lastname">Nom</label>
                <input type="text" class="form-control" name="lastname" id="lastname" placeholder="" value="<?= $student->getLastname() ?>">
            </div>
            <div class="form-group">
                <label for="teacher_id">Prof</label>
                <select name="teacher_id" id="teacher_id" class="form-control">
                    <option value="0" <?= $student->getStatus() == 0 ? "selected" : "" ?>>-</option>
                <?php foreach ($teachers as $key => $currentTeacher) : ?>
                    <option value="<?= $key+1 ?>" <?= $student->getTeacherId() == $key+1 ? "selected" : "" ?>><?= $currentTeacher->getFirstname() ?> <?= $currentTeacher->getLastname() ?> - <?= $currentTeacher->getJob() ?></option>
                <?php endforeach ?>
                </select>
            </div>
            <div class="form-group">
                <label for="status">Statut</label>
                <select name="status" id="status" class="form-control">
                    <option value="0" <?= $student->getStatus() == 0 ? "selected" : "" ?>>-</option>
                    <option value="1" <?= $student->getStatus() == 1 ? "selected" : "" ?>>actif</option>
                    <option value="2" <?= $student->getStatus() == 2 ? "selected" : "" ?>>désactivé</option>
                </select>
            </div>
            
            <input type="hidden" name="token" value="<?= $_SESSION["csrfToken"] ?>">

            <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
        </form>
    </div>
