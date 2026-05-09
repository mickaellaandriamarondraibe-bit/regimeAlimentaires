<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php if (session()->getFlashdata('error')): ?>
        <p style="color:red;"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <p style="color:green;"><?= esc(session()->getFlashdata('success')) ?></p>
    <?php endif; ?>

    <form action="/envoyerCode" method="post">
    <?= csrf_field() ?>

    <label for="code">Code</label>
    <input type="text" name="code" id="code">

    <span id="erreur_code" style="color: red; display: none;">
        Code requis
    </span>

    <span id="attente_code" style="color: green; display: none;">
        En attente de validation du code
    </span>

    <input type="submit" value="Envoyer" onclick="return validationCode()">
    <a href="/acceuil">Retour à l'accueil</a>

    <?php   
    echo session()->get('user_id');
     if (session()->get('user_id')): ?>
        <p>Bienvenue, <?= esc(session()->get('username')) ?>!</p>
    <?php else: ?>
        
    <?php endif; ?>


    
</form>
    <script>

     function showError(id, show) {
        document.getElementById(id).style.display = show ? "block" : "none";
    }

    function validationCode(){
        const code = document.getElementById('code').value; 

        if (code.trim() === "") {
            showError('erreur_code', true);
            showError('attente_code', false);
            return false;
        }

        showError('erreur_code', false);
        showError('attente_code', true);
        return true;
     }
    </script>
</body>
</html>
