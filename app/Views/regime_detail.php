<!DOCTYPE html>
<html lang="fr">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Détail du Régime</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="<?= base_url('favicon.ico') ?>" type="image/x-icon" />

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
    <link rel="stylesheet" href="<?= base_url('admin/assets/css/demo.css') ?>" />
</head>

<body>
    <div class="wrapper">
        <?php include 'layout/sidebar.php'; ?>

        <div class="main-panel">
            <?php include 'layout/main-header.php'; ?>

            <div class="container">
                <div class="page-inner">
                    <div class="page-header">
                        <h3 class="fw-bold mb-3">Détail du Régime</h3>
                        <ul class="breadcrumbs mb-3">
                            <li class="nav-home">
                                <a href="<?= base_url('') ?>">
                                    <i class="icon-home"></i>
                                </a>
                            </li>
                            <li class="separator">
                                <i class="icon-arrow-right"></i>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('regime/list') ?>">Régimes</a>
                            </li>
                            <li class="separator">
                                <i class="icon-arrow-right"></i>
                            </li>
                            <li class="nav-item">
                                <a href="#">Détail</a>
                            </li>
                        </ul>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h4 class="card-title"><?= esc($regime['name']) ?></h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="card card-dark bg-secondary-gradient">
                                                <div class="card-body pb-0">
                                                    <div class="h1 fw-bold float-end"><i class="fas fa-info-circle"></i></div>
                                                    <h2 class="mb-2">Description</h2>
                                                    <p><?= esc($regime['description']) ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="card card-dark bg-success-gradient">
                                                <div class="card-body pb-0">
                                                    <div class="h1 fw-bold float-end"><i class="fas fa-weight"></i></div>
                                                    <h2 class="mb-2">Variation de poids</h2>
                                                    <p><?= esc($regime['variation_poids_semaine']) ?> kg / semaine</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <div class="card card-post card-round">
                                                <div class="card-body">
                                                    <div class="d-flex">
                                                        <div class="avatar">
                                                            <span class="avatar-title rounded-circle border border-white bg-warning"><i class="fas fa-blender"></i></span>
                                                        </div>
                                                        <div class="info-post ms-2">
                                                            <p class="username">Compositions (%)</p>
                                                        </div>
                                                    </div>
                                                    <div class="separator-solid"></div>
                                                    <?php if (!empty($regime['compositions'])) : ?>
                                                        <ul class="list-group list-group-bordered">
                                                            <?php foreach ($regime['compositions'] as $compo) : ?>
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    <?= esc($compo['ingredient_name']) ?>
                                                                    <span class="badge badge-primary badge-pill"><?= esc($compo['pourcentage']) ?> %</span>
                                                                </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    <?php else : ?>
                                                        <p class="text-muted">Aucune composition pour ce régime.</p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="card card-post card-round">
                                                <div class="card-body">
                                                    <div class="d-flex">
                                                        <div class="avatar">
                                                            <span class="avatar-title rounded-circle border border-white bg-info"><i class="fas fa-dollar-sign"></i></span>
                                                        </div>
                                                        <div class="info-post ms-2">
                                                            <p class="username">Prix par Semaine</p>
                                                        </div>
                                                    </div>
                                                    <div class="separator-solid"></div>
                                                    <?php if (!empty($regime['prix'])) : ?>
                                                        <ul class="list-group list-group-bordered">
                                                            <?php foreach ($regime['prix'] as $p) : ?>
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    Semaine <?= esc($p['duree_semaine']) ?>
                                                                    <span class="badge badge-success badge-pill"><?= esc($p['prix']) ?> Ar</span>
                                                                </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    <?php else : ?>
                                                        <p class="text-muted">Aucun prix défini.</p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4 text-center">
                                        <a href="<?= base_url('regime/list') ?>" class="btn btn-black btn-border">
                                            <i class="fas fa-arrow-left"></i> Retour à la liste
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <?php include 'layout/main-footer.php'; ?>
        </div>
    </div>

    <?php include 'layout/core-js.php'; ?>
</body>

</html>
