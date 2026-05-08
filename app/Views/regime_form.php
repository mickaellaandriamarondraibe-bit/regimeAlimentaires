<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Création de Régime</title>
    <style>
        .error-message {
            color: #d9534f;
            font-size: 0.85rem;
            margin-top: 5px;
            display: block;
        }
        .field-group { margin-bottom: 15px; }
    </style>
</head>
<body>
    <?php $errors = session()->getFlashdata('errors'); ?>

    <form action="<?= base_url('regime/create') ?>" method="post">
        <?= csrf_field() ?>

        <fieldset>
            <legend>Informations sur le régime</legend>
            
            <!-- Champ Nom -->
            <div class="field-group">
                <label for="regime_name">Nom</label><br>
                <input type="text" name="regime_name" id="regime_name" value="<?= old('regime_name') ?>">
                <?php if (isset($errors['name'])) : ?>
                    <span class="error-message"><?= esc($errors['name']) ?></span>
                <?php endif ?>
            </div>

            <!-- Champ Type de Variation -->
            <div class="field-group">
                <label>Type de variation</label><br>
                <input type="radio" name="type_variation" id="variation_perte" value="perte" <?= set_radio('type_variation', 'perte', true); ?>>
                <label for="variation_perte">Perte</label>
                <input type="radio" name="type_variation" id="variation_gain" value="gain" <?= set_radio('type_variation', 'gain'); ?>>
                <label for="variation_gain">Gain</label>
                <?php if (isset($errors['type_variation'])) : ?>
                    <span class="error-message"><?= esc($errors['type_variation']) ?></span>
                <?php endif ?>
            </div>

            <!-- Champ Variation Poids -->
            <div class="field-group">
                <label for="variation_poids_jour">Variation du poids par jour</label><br>
                <input type="number" name="variation_poids_jour" id="variation_poids_jour" step="any" value="<?= old('variation_poids_jour') ?>">
                <?php if (isset($errors['variation_poids_jour'])) : ?>
                    <span class="error-message"><?= esc($errors['variation_poids_jour']) ?></span>
                <?php endif ?>
            </div>

            <!-- Champ Prix -->
            <div class="field-group">
                <label for="prix_jour">Prix journalier</label><br>
                <input type="number" name="prix_jour" id="prix_jour" step="any" value="<?= old('prix_jour') ?>">
                <?php if (isset($errors['prix_jour'])) : ?>
                    <span class="error-message"><?= esc($errors['prix_jour']) ?></span>
                <?php endif ?>
            </div>
        </fieldset>

        <fieldset>
            <legend>Compositions du régime (%)</legend>
            <?php foreach ($ingredients as $item): ?>
                <div class="field-group">
                    <label for="pourcentage_<?= $item['name'] ?>"><?= $item['name'] ?></label>
                    <input type="number" name="pourcentage_<?= $item['name'] ?>" id="pourcentage_<?= $item['name'] ?>" step="any" value="<?= old('pourcentage_' . $item['name'], '0.0') ?>">
                    
                    <!-- Erreur spécifique à l'ingrédient si nécessaire -->
                    <?php if (isset($errors['pourcentage_' . $item['name']])) : ?>
                        <span class="error-message"><?= esc($errors['pourcentage_' . $item['name']]) ?></span>
                    <?php endif ?>
                </div>
            <?php endforeach;?>
        </fieldset>

        <div class="btn-group">
            <input type="submit" value="Insérer le régime">
            <input type="button" value="Abandonner l'insertion">
        </div>
    </form>
</body>
</html>