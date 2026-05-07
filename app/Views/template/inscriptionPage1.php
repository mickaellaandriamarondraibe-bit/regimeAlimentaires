<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Étape 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/inscription.css'); ?>">
</head>
<body>
    <div class="inscription-container">
        <!-- Section des étapes -->
        <div class="steps-section">
            <div class="step active">
                <div class="step-icon">👤</div>
                <div class="step-label">Step 01</div>
            </div>
            <div class="step-connector"></div>
            <div class="step">
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
        <h2 class="section-title">Informations personnelles</h2>

        <!-- Formulaire -->
        <form action="/step2" method="get" id="form">
            <!-- Ligne 1 -->
            <div class="form-row">
                <div>
                    <label for="email">Email</label>
                    <input type="text" class="form-control" name="email" id="email" value="<?php echo session('email') ?? ''; ?>">
                    <span id="erreur_email" class="error-message">Email requis</span>
                </div>
                <div>
                    <label for="name">Nom d'utilisateur</label>
                    <input type="text" class="form-control" name="name" id="name" value="<?php echo session('name') ?? ''; ?>">
                    <span id="erreur_name" class="error-message">Nom d'utilisateur requis</span>
                </div>
            </div>

            <!-- Ligne 2 -->
            <div class="form-row-full">
                <div>
                    <label for="pwd">Mot de passe</label>
                    <input type="password" class="form-control" name="pwd" id="pwd">
                    <span id="erreur_mdp" class="error-message">Mot de passe requis</span>
                </div>
            </div>

            <!-- Champs cachés pour transmettre les données de page 2 -->
            <input type="hidden" name="phone" value="<?php echo session('phone') ?? ''; ?>">
            <input type="hidden" name="genre" value="<?php echo session('genre') ?? ''; ?>">
            <input type="hidden" name="taille" value="<?php echo session('taille') ?? ''; ?>">
            <input type="hidden" name="poids" value="<?php echo session('poids') ?? ''; ?>">

            <!-- Boutons -->
            <div class="btn-group">
                <button type="button" class="btn btn-back" onclick="window.history.back()">Retour</button>
                <button type="button" class="btn btn-continue" onclick="validateForm()">Continuer</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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

            if (count === 3) {
                document.getElementById("form").submit();
            }

            return true;
        }
    </script>
</body>
</html>
