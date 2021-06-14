  <div class="container my-4"> <a href="<?= $router->generate("user-list") ?>" class="btn btn-success float-right">Retour</a>
      <h2>Mettre à jour un utilisateur</h2>

      <form action="" method="POST" class="mt-5">
          <div class="form-group">
              <label for="email">Adresse email</label>
              <input type="email" class="form-control" name="email" id="email" placeholder="" value="<?= $appuser->getEmail() ?>">
          </div>
          <div class="form-group">
              <label for="name">Nom</label>
              <input type="text" class="form-control" name="name" id="name" placeholder="" value="<?= $appuser->getName() ?>">
          </div>
          <div class="form-group">
              <label for="role">Role</label>
              <select name="role" id="role" class="form-control">
                  <option value="user" <?= $appuser->getRole() == "user" ? "selected" : "" ?>>Utilisateur</option>
                  <option value="admin" <?= $appuser->getRole() == "admin" ? "selected" : "" ?>>Administrateur</option>
              </select>
          </div>
          <div class="form-group">
              <label for="status">Statut</label>
              <select name="status" id="status" class="form-control">
                  <option value="0" <?= $student->getStatus() == 0 ? "selected" : "" ?>>-</option>
                  <option value="1" <?= $appuser->getStatus() == 0 ? "selected" : "" ?>>actif</option>
                  <option value="2" <?= $appuser->getStatus() == 0 ? "selected" : "" ?>>désactivé</option>
              </select>
          </div>

          <input type="hidden" name="token" value="<?= $_SESSION["csrfToken"] ?>">

          <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
      </form>
  </div>