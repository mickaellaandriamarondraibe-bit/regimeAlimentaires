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

        .field-group {
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <?php $errors = session()->getFlashdata('errors'); ?>

    <form action="<?= base_url('regime/create') ?>" method="post">
        <?= csrf_field() ?>
        <div class="status"></div>

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

            <!-- Champ Objectif -->
            <div class="field-group">
                <label>Objectif</label><br>

                <?php foreach ($objectifs as $key => $obj) : ?>
                    <input type="radio"
                        name="objectif_id"
                        id="obj_<?= $obj['id'] ?>"
                        value="<?= $obj['id'] ?>"
                        <?= set_radio('objectif_id', $obj['id'], ($key === 0)); ?>>

                    <label for="obj_<?= $obj['id'] ?>">
                        <?= esc($obj['name']) ?>
                    </label>
                    <br>
                <?php endforeach; ?>

                <?php if (isset($errors['objectif_id'])) : ?>
                    <span class="error-message"><?= esc($errors['objectif_id']) ?></span>
                <?php endif ?>
            </div>

            <!-- Champ Variation Poids -->
            <div class="field-group">
                <label for="variation_poids_semaine">Variation du poids par semaine</label><br>
                <input type="number" name="variation_poids_semaine" id="variation_poids_semaine" step="any" value="<?= old('variation_poids_semaine') ?>">
                <?php if (isset($errors['variation_poids_semaine'])) : ?>
                    <span class="error-message"><?= esc($errors['variation_poids_semaine']) ?></span>
                <?php endif ?>
            </div>
            
            <!-- Champ Description -->
            <div class="field-group">
                <label for="description">Description</label><br>
                <textarea name="description" id="description"><?= old('description') ?></textarea>
                <?php if (isset($errors['description'])) : ?>
                    <span class="error-message"><?= esc($errors['description']) ?></span>
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
            <?php endforeach; ?>
        </fieldset>

        <fieldset id="prix-fieldset">
            <legend>Prix du régime</legend>
            <div class="prix-week">
                <label for="semaine">Numéro de la semaine</label>
                <input type="number" name="semaine[]" id="semaine" value="<?= old('semaine.0') ?>">
                <label for="prix">Prix (Ar)</label>
                <input type="number" name="prix[]" id="prix" step="any" value="<?= old('prix.0') ?>">
                <?php if (isset($errors['prix'])) : ?>
                    <span class="error-message"><?= esc($errors['prix']) ?></span>
                <?php endif ?>
            </div>
            <button type="button" id="add-week">Ajouter une semaine</button>
        </fieldset>

        <div class="btn-group">
            <input type="submit" value="Insérer le régime">
            <a href="/regime/list"><input type="button" value="Abandonner l'insertion"></a>
        </div>
    </form>

    <script src="/assets/js/regime_form.js"></script>
</body>

</html>