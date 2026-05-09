<!DOCTYPE html>
<html lang="fr">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Création de Régime</title>
    <meta
        content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
        name="viewport" />
    <link
        rel="icon"
        href="favicon.ico"
        type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="<?= base_url('admin/assets/js/plugin/webfont/webfont.min.js') ?>"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["<?= base_url('admin/assets/css/fonts.min.css') ?>"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="<?= base_url('admin/assets/css/bootstrap.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('admin/assets/css/plugins.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('admin/assets/css/kaiadmin.min.css') ?>" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="<?= base_url('admin/assets/css/demo.css') ?>" />
</head>

<body>
    <div class="wrapper">
        <!-- include sidebar here -->
        <?php include 'layout/sidebar.php'; ?>

        <div class="main-panel">
            <!-- include main header here -->
            <?php include 'layout/main-header.php'; ?>

            <div class="container">
                <div class="page-inner">
                    <h3 class="fw-bold mb-3">Création de Régime</h3>
                    <div class="page-category">
                        Remplissez le formulaire ci-dessous pour créer un nouveau régime alimentaire. Vous pouvez voir la liste des regimes déjà créés en cliquant
                        <a href="<?= base_url('regime/list') ?>">ici</a>.
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">Form Elements</div>
                                </div>
                                <?php $errors = session()->getFlashdata('errors'); ?>

                                <form action="<?= base_url('regime/create') ?>" method="post">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 col-lg-12">
                                                <?= csrf_field() ?>
                                                <fieldset>
                                                    <legend>Informations sur le régime</legend>
                                                    <div class="form-group">
                                                        <label for="regime_name">Nom du régime</label>
                                                        <input type="text" name="regime_name" id="regime_name" value="<?= old('regime_name') ?>" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" placeholder="Entrer le nom" />
                                                        <?php if (isset($errors['name'])) : ?>
                                                            <small id="error-message" class="form-text text-danger"><?= esc($errors['name']) ?></small>
                                                        <?php endif ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="variation_poids_semaine">Variation du poids par semaine</label>
                                                        <input type="number" name="variation_poids_semaine" id="variation_poids_semaine" step="any" value="<?= old('variation_poids_semaine') ?>" class="form-control <?= isset($errors['variation_poids_semaine']) ? 'is-invalid' : '' ?>" placeholder="Négative pour perte de poids et positive pour prise de poids">
                                                        <?php if (isset($errors['variation_poids_semaine'])) : ?>
                                                            <small id="error-message" class="form-text text-danger"><?= esc($errors['variation_poids_semaine']) ?></small>
                                                        <?php endif ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="description">Description</label>
                                                        <textarea class="form-control" id="description" rows="2"><?= old('description') ?></textarea>
                                                    </div>
                                                </fieldset>
                                                <fieldset>
                                                    <legend>Compositions du régime (%)</legend>
                                                    <?php foreach ($ingredients as $item): ?>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" style="width: 10%;"><?= $item['name'] ?></span>
                                                            <input type="number" name="pourcentage_<?= $item['name'] ?>" id="pourcentage_<?= $item['name'] ?>" step="any" value="<?= old('pourcentage_' . $item['name'], '0.0') ?>" class="form-control">
                                                            <span class="input-group-text">%</span>
                                                            <?php if (isset($errors['pourcentage_' . $item['name']])) : ?>
                                                                <small id="error-message" class="form-text text-danger"><?= esc($errors['pourcentage_' . $item['name']]) ?></small>
                                                            <?php endif ?>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </fieldset>
                                                <fieldset id="prix-fieldset">
                                                    <legend>Prix du régime</legend>
                                                    <div class="prix-week">
                                                        <div class="row">
                                                            <div class="col-lg-5">
                                                                <div class="form-group">
                                                                    <label>Numéro de la semaine</label>
                                                                    <input type="number" name="semaine[]" id="semaine" value="<?= old('semaine.0') ?>" class="form-control">
                                                                    <?php if (isset($errors['semaine.0'])) : ?>
                                                                        <small id="error-message" class="form-text text-danger"><?= esc($errors['semaine.0']) ?></small>
                                                                    <?php endif ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-5">
                                                                <div class="form-group">
                                                                    <label>Prix (Ar)</label>
                                                                    <input type="number" name="prix[]" id="prix" step="any" value="<?= old('prix.0') ?>" class="form-control">
                                                                    <?php if (isset($errors['prix.0'])) : ?>
                                                                        <small id="error-message" class="form-text text-danger"><?= esc($errors['prix.0']) ?></small>
                                                                    <?php endif ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2 d-flex align-items-center">
                                                                <button type="button" class="btn btn-info" id="add-week" style="margin-top: 10%; width: 100%;"><i class="fas fa-plus mr-6"></i> Ajouter une semaine</button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-action">
                                        <input type="submit" value="Insérer le régime" class="btn btn-success mr-6">
                                        <a href="/regime/list"><button class="btn btn-danger ml-6">Abandonner l'insertion</button></a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- include main footer here -->
                <?php include 'layout/main-footer.php'; ?>
            </div>
        </div>

        <script src="<?= base_url('admin/assets/js/regime_form.js') ?>"></script>
        <?php include 'layout/core-js.php'; ?>
</body>

</html>