<?php
$isLoggedIn = (bool) session()->get('user_id');
$isAdmin = (session('role') ?? '') === 'admin';
$path = trim((string) service('uri')->getPath(), '/');
$isActive = static function (string $target) use ($path): bool {
    return $path === trim($target, '/');
};
?>

<header class="navbar">
    <div class="container nav-inner">
        <a class="logo" href="<?= site_url($isLoggedIn ? 'accueil' : 'login') ?>">
            <span class="logo-icon"><i class="fa-solid fa-heart-pulse"></i></span>
            NutriFit
        </a>

        <nav class="nav-menu" id="navMenu">
            <?php if ($isAdmin): ?>
                <a href="<?= site_url('dashboard') ?>">Dashboard</a>
                <a href="<?= site_url('objectifs') ?>">Objectifs</a>
                <a href="<?= site_url('codes') ?>">Codes</a>
                <a href="<?= site_url('regime/list') ?>">Régimes</a>
                <a href="<?= site_url('sport') ?>">Sports</a>
                <a href="<?= site_url('parametres') ?>">Paramètres</a>
                <a href="<?= site_url('admin/transactions') ?>">Transactions</a>
            <?php elseif ($isLoggedIn): ?>
                <a class="<?= $isActive('accueil') ? 'is-active' : '' ?>" href="<?= site_url('accueil') ?>">Accueil</a>
                <a class="<?= $isActive('programme') ? 'is-active' : '' ?>" href="<?= site_url('programme') ?>">Programme</a>
                <a class="<?= $isActive('programme/catalogue') ? 'is-active' : '' ?>" href="<?= site_url('programme/catalogue') ?>">Catalogue</a>
                <a class="<?= $isActive('programme/mes-programmes') ? 'is-active' : '' ?>" href="<?= site_url('programme/mes-programmes') ?>">Mes programmes</a>
                <a class="<?= $isActive('transactions') ? 'is-active' : '' ?>" href="<?= site_url('transactions') ?>">Transactions</a>
                <a class="<?= $isActive('profil') ? 'is-active' : '' ?>" href="<?= site_url('profil') ?>">Profil</a>
            <?php else: ?>
                <a href="<?= site_url('accueil') ?>">Accueil</a>
                <a href="<?= site_url('programme/catalogue') ?>">Catalogue</a>
            <?php endif; ?>
        </nav>

        <div class="nav-icons">
            <?php if (!$isLoggedIn): ?>
                <a href="<?= site_url('login') ?>">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    <span>Login</span>
                </a>
            <?php else: ?>
                <a href="<?= site_url('logout') ?>">
                    <i class="fa-solid fa-power-off"></i>
                    <span>Logout</span>
                </a>
            <?php endif; ?>
        </div>

        <button class="btn btn-light mobile-btn" id="mobileBtn" type="button">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>
</header>
