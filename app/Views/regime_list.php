<!DOCTYPE html>
<html lang="fr">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Liste des régimes</title>
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
                        <h3 class="fw-bold mb-3">Liste des régimes</h3>
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
                                <a href="#">Régimes</a>
                            </li>
                            <li class="separator">
                                <i class="icon-arrow-right"></i>
                            </li>
                            <li class="nav-item">
                                <a href="#">Liste</a>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 mb-4">
                             <a href="<?= base_url('regime/create') ?>" class="btn btn-primary btn-round">
                                <i class="fas fa-plus"></i> Ajouter un nouveau régime
                            </a>
                        </div>
                    </div>

                    <div class="row row-card-no-pd">
                        <?php foreach ($regimes as $regime): ?>
                        <div class="col-sm-6 col-md-4">
                            <div class="card card-stats card-round">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                                                <i class="fas fa-utensils"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category">Régime</p>
                                                <h4 class="card-title"><?= esc($regime['name']) ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12 text-center">
                                            <a href="<?= base_url('regime/detail/' . $regime['id']) ?>" class="btn btn-secondary btn-sm btn-border">
                                                <i class="fas fa-eye"></i> Voir le détail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                </div>
            </div>

            <?php include 'layout/main-footer.php'; ?>
        </div>
    </div>

    <?php include 'layout/core-js.php'; ?>
</body>
</html>