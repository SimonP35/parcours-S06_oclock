   <div class="container my-4"> <a href="<?= $router->generate("teacher-list") ?>" class="btn btn-success float-right">Retour</a>
       <h2>Mettre à jour un prof</h2>

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
               <input type="text" class="form-control" name="firstname" id="firstname" placeholder="" value="<?= $teacher->getFirstname() ?>">
           </div>
           <div class="form-group">
               <label for="lastname">Nom</label>
               <input type="text" class="form-control" name="lastname" id="lastname" placeholder="" value="<?= $teacher->getLastname() ?>">
           </div>
           <div class="form-group">
               <label for="job">Titre</label>
               <input type="text" class="form-control" name="job" id="job" placeholder="" value="<?= $teacher->getJob() ?>">
           </div>
           <div class="form-group">
               <label for="status">Statut</label>
               <select name="status" id="status" class="form-control">
                   <option value="0" <?= $teacher->getStatus() == 0 ? "selected" : "" ?>>-</option>
                   <option value="1" <?= $teacher->getStatus() == 1 ? "selected" : "" ?>>actif</option>
                   <option value="2" <?= $teacher->getStatus() == 2 ? "selected" : "" ?>>désactivé</option>
               </select>
           </div>

           <input type="hidden" name="token" value="<?= $_SESSION["csrfToken"] ?>">

           <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
       </form>
   </div>