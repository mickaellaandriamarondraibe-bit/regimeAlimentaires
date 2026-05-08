<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <legend>Inscription - Etape 1</legend>
    <?php if (session()->getFlashdata('error')): ?>
        <p style="color:red;"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <form action="/step2" method="post" id="form" onsubmit="return validateForm()">
    <?= csrf_field() ?>
        <label> Email </label>
        <input type="text" name="email" id="email" value="<?php echo session('email') ?? ''; ?>">
        <span id="erreur_email" style="color: red; display: none;"> Email requis</span>

        <label> Nom d'utilisateur </label>
        <input type="text" name="name" id="name" value="<?php echo session('name') ?? ''; ?>">
        <span id="erreur_name" style="color: red; display: none;"> Nom requis</span>

        <label> Mot de passe </label>
        <input type="password" name="pwd" id="pwd">
        <span id="erreur_mdp" style="color: red; display: none;">Mot de passe requis </span>

        <!-- Champs cachés pour transmettre les données de page 2 -->
        <input type="hidden" name="phone" value="<?php echo session('phone') ?? ''; ?>">
        <input type="hidden" name="genre" value="<?php echo session('genre') ?? ''; ?>">
        <input type="hidden" name="taille" value="<?php echo session('taille') ?? ''; ?>">
        <input type="hidden" name="poids" value="<?php echo session('poids') ?? ''; ?>">

        <input type="submit" value="Suivant">
    </form>
</body>

<script>
    function validateForm() {
        let count = 0;

        const email = document.getElementById('email').value;
        const name = document.getElementById('name').value;
        const pwd = document.getElementById('pwd').value;

        let erreur_email = document.getElementById('erreur_email');
        let erreur_name = document.getElementById('erreur_name');
        let erreur_mdp = document.getElementById('erreur_mdp');

        if (email.trim() === "") {
            erreur_email.style.display = "block";
        } else {
            const emailBase = verifierPasswordAndEmail(email);
            if (emailBase) {
                erreur_email.textContent = "Cet email est déjà utilisé.";
                erreur_email.style.display = "block";
                return false;
            }
            erreur_email.style.display = "none";
            count++;
        }

        if (name.trim() === "") {
            erreur_name.style.display = "block";
        } else {
            erreur_name.style.display = "none";
            count++;
        }

        if (pwd.trim() === "") {
            erreur_mdp.style.display = "block";
        } else {
            erreur_mdp.style.display = "none";
            count++;
        }

        return count === 3;
    }
</script>
</html>
