<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
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
</form>
    <script>

     function showError(id, show) {
        document.getElementById(id).style.display = show ? "block" : "none";
    }

    function validationCode(){
        const code = document.getElementById('code').value; 
        const erreur = document.getElementById('erreu_code');
        const attente = document.getElementById('attente_code');
        const codeBase = verifierCode(code);
        if(code.trim() === codeBase){
            showError('erreu_code', false);
            showError('attente_code', true);
            return true;
        } else {
            erreur.textContent = "Code incorrect.";
            showError('erreu_code', true);
            showError('attente_code', false);
            return false;
        }
     }
    </script>
</body>
</html>