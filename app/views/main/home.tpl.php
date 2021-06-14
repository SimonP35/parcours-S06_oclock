<div class="container my-4">
    <p class="display-5">
        Bienvenue dans le backOffice <strong>d'une école 100% en ligne formant des développeurs Web</strong>...
    </p>
    <?php if (isset($_SESSION['userObject'])) : ?>
        <p class="display-5">
            Vous êtes connecté en tant que :
            <ul>
                <li>Email : <?= $_SESSION['userObject']->getEmail() ?> </li>
                <li>Nom : <?= $_SESSION['userObject']->getName() ?></li>
                <li>Rôle : <?= $_SESSION['userObject']->getRole() ?> !</li>
            </ul>
        </p>
    <?php endif ?>
</div>