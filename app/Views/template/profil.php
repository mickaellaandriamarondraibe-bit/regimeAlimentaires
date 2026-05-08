<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon profil</title>
</head>
<body>

    <h2>Modifier mon profil</h2>

    <?php if (session()->getFlashdata('success')): ?>
        <p style="color: green;">
            <?= esc(session()->getFlashdata('success')) ?>
        </p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <p style="color: red;">
            <?= esc(session()->getFlashdata('error')) ?>
        </p>
    <?php endif; ?>

    <form action="/profil/update" method="post">
        <?= csrf_field() ?>

        <div>
            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                value="<?= esc($user['email'] ?? '') ?>"
                required
            >
        </div>

        <div>
            <label for="username">Nom d'utilisateur</label>
            <input
                type="text"
                id="username"
                name="username"
                value="<?= esc($user['username'] ?? '') ?>"
                required
            >
        </div>

        <div>
            <label for="pwd">Nouveau mot de passe</label>
            <input
                type="password"
                id="pwd"
                name="pwd"
                placeholder="Laisser vide pour ne pas changer"
            >
        </div>

        <div>
            <label for="phone">Téléphone</label>
            <input
                type="text"
                id="phone"
                name="phone"
                value="<?= esc(($client['phone'] ?? '') === '0' ? '' : ($client['phone'] ?? '')) ?>"
            >
        </div>

        <div>
            <label for="genre">Genre</label>
            <select id="genre" name="genre" required>
                <option value="">Sélectionner</option>
                <option value="H" <?= ($client['genre'] ?? '') === 'H' ? 'selected' : '' ?>>
                    Homme
                </option>
                <option value="F" <?= ($client['genre'] ?? '') === 'F' ? 'selected' : '' ?>>
                    Femme
                </option>
            </select>
        </div>

        <div>
            <label for="taille">Taille en cm</label>
            <input
                type="number"
                id="taille"
                name="taille"
                step="0.01"
                min="50"
                max="250"
                value="<?= esc($client['taille'] ?? '') ?>"
                required
            >
        </div>

        <div>
            <label for="poids">Poids en kg</label>
            <input
                type="number"
                id="poids"
                name="poids"
                step="0.01"
                min="10"
                max="300"
                value="<?= esc($client['poids'] ?? '') ?>"
                required
            >
        </div>

        <?php 
        if (isset($client['is_gold']) && $client['is_gold'] == 1): ?>
            <p style="color: gold;">Vous êtes un membre Gold !</p>
        <?php endif; ?>



        <button type="submit">Enregistrer</button>
    </form>

</body>
</html>