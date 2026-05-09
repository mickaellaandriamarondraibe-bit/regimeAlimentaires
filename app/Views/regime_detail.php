<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détail du Régime</title>
</head>
<body>
    <h1>Détail du Régime : <?= esc($regime['name']) ?></h1>

    <div>
        <strong>Description :</strong>
        <p><?= esc($regime['description']) ?></p>
    </div>

    <div>
        <strong>Variation de poids par semaine :</strong>
        <span><?= esc($regime['variation_poids_semaine']) ?> kg</span>
    </div>

    <hr>

    <h2>Compositions (%)</h2>
    <?php if (!empty($regime['compositions'])) : ?>
        <ul>
            <?php foreach ($regime['compositions'] as $compo) : ?>
                <li><?= esc($compo['ingredient_name']) ?> : <?= esc($compo['pourcentage']) ?> %</li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p>Aucune composition pour ce régime.</p>
    <?php endif; ?>

    <hr>

    <h2>Prix</h2>
    <?php if (!empty($regime['prix'])) : ?>
        <ul>
            <?php foreach ($regime['prix'] as $p) : ?>
                <li>Semaine <?= esc($p['duree_semaine']) ?> : <?= esc($p['prix']) ?> Ar</li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p>Aucun prix défini.</p>
    <?php endif; ?>

    <br>
    <a href="<?= base_url('regime/list') ?>">Retour à la liste</a>
</body>
</html>
