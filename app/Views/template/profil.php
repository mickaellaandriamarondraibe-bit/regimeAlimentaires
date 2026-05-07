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
            <label>Email</label>
            <input
                type="email"
                name="email"
                value="<?= esc($user['email'] ?? '') ?>"
                required
            >
        </div>

        <div>
            <label>Nom d'utilisateur</label>
            <input
                type="text"
                name="name"
                value="<?= esc($user['username'] ?? '') ?>"
                required
            >
        </div>

        <div>
            <label>Nouveau mot de passe</label>
            <input
                type="password"
                name="pwd"
                placeholder="Laisser vide pour ne pas changer"
            >
        </div>

        <div>
            <label>Téléphone</label>
            <input
                type="text"
                name="phone"
                value="<?= esc(($client['phone'] ?? '') === '0' ? '' : ($client['phone'] ?? '')) ?>"
            >
        </div>

        <div>
            <label>Genre</label>
            <select name="genre" required>
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
            <label>Taille en cm</label>
            <input
                type="number"
                name="taille"
                step="0.01"
                value="<?= esc($client['taille'] ?? '') ?>"
                required
            >
        </div>

        <div>
            <label>Poids en kg</label>
            <input
                type="number"
                name="poids"
                step="0.01"
                value="<?= esc($client['poids'] ?? '') ?>"
                required
            >
        </div>

        <button type="submit">Enregistrer</button>
    </form>

</body>
</html>