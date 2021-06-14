<div class="container my-4">
    <div class="card card--signin">
        <div class="card-header">
            Connexion
        </div>
        
        <?php if (!empty($viewVars['errorList'])) : ?>
            <?php foreach ($errorList as $error) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= $error ?>
                </div>
            <?php endforeach ?>
        <?php endif ?>

        <div class="card-body">
            <form action="" method="post">
                <div class="form-group">
                    <label for="email">Adresse email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Saisissez votre adresse email" value="">
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Saisissez votre mot de passe" value="">
                </div>

                <input type="hidden" name="token" value="<?= $_SESSION["csrfToken"] ?>">

                <button type="submit" class="btn btn-primary btn-block mt-4">se connecter</button>
            </form>
        </div>
    </div>
</div>