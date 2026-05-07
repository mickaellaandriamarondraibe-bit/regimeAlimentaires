
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <legend>Inscription - Etape 2</legend>
    <form action="/register/step1" method="post">
        <label> phone </label>
        <input type = "text" name="phone" id ="phone" value="<?php echo session('phone') ?? ''; ?>">
        <span id="erreur_phone" style="color : red ; display : none; "> phone requis</span>
        <label> Genre </label>
        <select name="genre" id="genre" value="<?php echo session('genre') ?? ''; ?>">
            <option value="">Sélectionnez votre genre</option>
            <option value="H">Homme</option>
            <option value="F">Femme</option>
        </select>
        <span id="erreur_genre" style="color : red ; display : none; "> Genre requis</span>
        <label for="taille">Taille</label>

        <input type="number" name="taille" id="taille" value="<?php echo session('taille') ?? ''; ?>">
        <label for="poids">Poids</label>
        
        <input type="number" name="poids" id="poids" value="<?php echo session('poids') ?? ''; ?>">

        <input type="button" onclick="validateForm()" value="Enregistrer les informations">
        <input type="button" onclick="retour()" value="Retour">
    </form>
</body>
<script>
    function retour (){
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/savePage2';
        
        const phone = document.createElement('input');
        phone.type = 'hidden';
        phone.name = 'phone';
        phone.value = document.getElementById('phone').value;
        form.appendChild(phone);
        
        const genre = document.createElement('input');
        genre.type = 'hidden';
        genre.name = 'genre';
        genre.value = document.getElementById('genre').value;
        form.appendChild(genre);
        
        const taille = document.createElement('input');
        taille.type = 'hidden';
        taille.name = 'taille';
        taille.value = document.getElementById('taille').value;
        form.appendChild(taille);
        
        const poids = document.createElement('input');
        poids.type = 'hidden';
        poids.name = 'poids';
        poids.value = document.getElementById('poids').value;
        form.appendChild(poids);
        
        document.body.appendChild(form);
        form.submit();
    }   
    function validateForm(){
        const phone = document.getElementById('phone').value; 
            const poids = document.getElementById('poids').value;
            const genre = document.getElementById('genre').value;  
            const taille = document.getElementById('taille').value;
            let erreur_phone= document.getElementById('erreur_phone');
            let erreur_poids= document.getElementById('erreur_poids');
            let erreur_genre= document.getElementById('erreur_genre');
            let erreur_taille= document.getElementById('erreur_taille');

        if(phone.trim()=== ""){
            erreur_phone.style.display = "block ";
                   }
        else{
            erreur_phone.style.display = "none";
           
        }
        if(genre.trim() ===""){
            erreur_genre.style.display = "block ";
           
        }
        else {
            erreur_genre.style.display = "none";
           
        }
        if(poids.trim() ===""){
            erreur_poids.style.display = "block ";
           
        }
        else {
            erreur_poids.style.display = "none";
            
        }
        if(taille.trim() ===""){
            erreur_taille.style.display = "block ";
           
        }
        else {
            erreur_taille.style.display = "none";
        }

        if(phone.trim() != '' && genre.trim() != '' && poids.trim() != '' && taille.trim() != ''){
            const save =
            window.location.href ="/step2"; 
        }
        
        return false ; 
}

</script>
    

</html>


