<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Étape 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/inscription.css'); ?>">
</head>
<body>
    <div class="inscription-container">
        <!-- Section des étapes -->
        <div class="steps-section">
            <div class="step">
                <div class="step-icon">👤</div>
                <div class="step-label">Step 01</div>
            </div>
            <div class="step-connector"></div>
            <div class="step active">
                <div class="step-icon">🔒</div>
                <div class="step-label">Step 02</div>
            </div>
            <div class="step-connector"></div>
            <div class="step">
                <div class="step-icon">📋</div>
                <div class="step-label">Step 03</div>
            </div>
            <div class="step-connector"></div>
            <div class="step">
                <div class="step-icon">✅</div>
                <div class="step-label">Step 04</div>
            </div>
        </div>

        <!-- Titre -->
        <h2 class="section-title">Détails supplémentaires</h2>

        <!-- Formulaire -->
        <form id="form2">
            <!-- Ligne 1 -->
            <div class="form-row">
                <div>
                    <label for="phone">Téléphone</label>
                    <input type="text" class="form-control" name="phone" id="phone" value="<?php echo session('phone') ?? ''; ?>">
                    <span id="erreur_phone" class="error-message">Téléphone requis</span>
                </div>
                <div>
                    <label for="genre">Genre</label>
                    <select class="form-control" name="genre" id="genre">
                        <option value="">Sélectionnez votre genre</option>
                        <option value="H" <?php echo session('genre') === 'H' ? 'selected' : ''; ?>>Homme</option>
                        <option value="F" <?php echo session('genre') === 'F' ? 'selected' : ''; ?>>Femme</option>
                    </select>
                    <span id="erreur_genre" class="error-message">Genre requis</span>
                </div>
            </div>

            <!-- Ligne 2 -->
            <div class="form-row">
                <div>
                    <label for="taille">Taille (cm)</label>
                    <input type="number" class="form-control" name="taille" id="taille" value="<?php echo session('taille') ?? ''; ?>">
                    <span id="erreur_taille" class="error-message">Taille requise</span>
                </div>
                <div>
                    <label for="poids">Poids (kg)</label>
                    <input type="number" class="form-control" name="poids" id="poids" value="<?php echo session('poids') ?? ''; ?>">
                    <span id="erreur_poids" class="error-message">Poids requis</span>
                </div>
            </div>

            <!-- Boutons -->
            <div class="btn-group">
                <button type="button" class="btn btn-back" onclick="retour()">Retour</button>
                <button type="button" class="btn btn-continue" onclick="validateForm()">Continuer</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function retour (){
            // Créer un formulaire pour envoyer les données au serveur avant de revenir
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
                erreur_phone.style.display = "block";
            }
            else{
                erreur_phone.style.display = "none";
            }

            if(genre.trim() ===""){
                erreur_genre.style.display = "block";
            }
            else {
                erreur_genre.style.display = "none";
            }

            if(poids.trim() ===""){
                erreur_poids.style.display = "block";
            }
            else {
                erreur_poids.style.display = "none";
            }

            if(taille.trim() ===""){
                erreur_taille.style.display = "block";
            }
            else {
                erreur_taille.style.display = "none";
            }

            if(phone.trim() != '' && genre.trim() != '' && poids.trim() != '' && taille.trim() != ''){
                window.location.href ="/step2"; 
            }
            
            return false ; 
        }
    </script>
</body>
</html>


