<?php
$isLoggedIn = (bool) session()->get('user_id');
$isAdmin = (session('role') ?? '') === 'admin';
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
                <a href="<?= site_url('ingredient') ?>">Ingrédients</a>
                <a href="<?= site_url('regime/list') ?>">Régimes</a>
                <a href="<?= site_url('sport') ?>">Sports</a>
                <a href="<?= site_url('parametres') ?>">Paramètres</a>
                <a href="<?= site_url('admin/transactions') ?>">Transactions</a>
            <?php else: ?>
                <a href="<?= site_url('accueil') ?>">Accueil</a>
                <a href="<?= site_url('programme') ?>">Programme</a>
                <a href="<?= site_url('programme/catalogue') ?>">Catalogue</a>
                <a href="<?= site_url('programme/mes-programmes') ?>">Mes programmes</a>
                <a href="<?= site_url('transactions') ?>">Transactions</a>
                <a href="<?= site_url('profil') ?>">Profil</a>
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