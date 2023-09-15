<!-- Sidebar -->
<?php
// Obtenez le protocole (http ou https)
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";

// Obtenez le nom d'hôte (par exemple, localhost:8081)
$host = $_SERVER['HTTP_HOST'];

// Obtenez le chemin de la requête (par exemple, /admin/menu/list)
$uri = $_SERVER['REQUEST_URI'];

// Combinez-les pour obtenir l'URL complète
$url = $protocol . "://" . $host . $uri;
?>

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Blue Bird <sup>©</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= strpos($url, "/admin/dashboard/") ? 'active' : '' ?>">
        <a class="nav-link" href="/admin/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#">
            <i class="fas fa-fw fa-cog"></i>
            <span>Composants</span>
        </a>
    </li>

    <li class="nav-item <?= strpos($url, "/admin/utils/") ? 'active' : '' ?>">
        <a class="nav-link" href="/admin/utils/list">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Utilitaires</span>
        </a>
    </li>

    <li class="nav-item <?= strpos($url, "/admin/page/") ? 'active' : '' ?>">
        <a class="nav-link" href="/admin/page/list">
            <i class="fas fa-fw fa-paper-plane"></i>
            <span>Pages</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="/admin/media/list">
            <i class="fas fa-fw fa-camera"></i>
            <span>Média</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Administration
    </div>

    <li class="nav-item <?= strpos($url, "/admin/menu/") ? 'active' : '' ?>">
        <a class="nav-link" href="/admin/menu/list">
            <i class="fas fa-fw fa-bars"></i>
            <span>Menus</span>
        </a>
    </li>

    <li class="nav-item <?= strpos($url, "/admin/user/") ? 'active' : '' ?>">
        <a class="nav-link" href="/admin/user/list">
            <i class="fas fa-fw fa-user"></i>
            <span>Comptes</span>
        </a>
    </li>

    <li class="nav-item <?= strpos($url, "/admin/message/") ? 'active' : '' ?>">
        <a class="nav-link" href="/admin/message/list">
            <i class="fas fa-fw fa-inbox"></i>
            <span>Messages</span>
        </a>
    </li>

    <li class="nav-item <?= strpos($url, "/admin/review/") ? 'active' : '' ?>">
        <a class="nav-link" href="/admin/review/list">
            <i class="fas fa-fw fa-star"></i>
            <span>Notations</span>
        </a>
    </li>

    <li class="nav-item <?= strpos($url, "/admin/comment/") ? 'active' : '' ?>">
        <a class="nav-link" href="/admin/comment/list">
            <i class="fas fa-fw fa-comment"></i>
            <span>Commentaires</span>
        </a>
    </li>

    <li class="nav-item <?= strpos($url, "/admin/comment-reply/") ? 'active' : '' ?>">
        <a class="nav-link" href="/admin/comment-reply/list">
            <i class="fas fa-fw fa-reply"></i>
            <span>Réponses commentaires</span>
        </a>
    </li>

    <li class="nav-item <?= strpos($url, "/admin/post/") ? 'active' : '' ?>">
        <a class="nav-link" href="/admin/post/list">
            <i class="fas fa-fw fa-file"></i>
            <span>Articles</span>
        </a>
    </li>

    <li class="nav-item <?= strpos($url, "/admin/movie/") ? 'active' : '' ?>">
        <a class="nav-link" href="/admin/movie/list">
            <i class="fas fa-fw fa-film"></i>
            <span>Films</span>
        </a>
    </li>

    <li class="nav-item <?= strpos($url, "/admin/category-movie/") ? 'active' : '' ?>">
        <a class="nav-link" href="/admin/category-movie/list">
            <i class="fas fa-fw fa-tags"></i>
            <span>Catégories de film</span>
        </a>
    </li>

    <li class="nav-item <?= strpos($url, "/admin/productor/") ? 'active' : '' ?>">
        <a class="nav-link" href="/admin/productor/list">
            <i class="fas fa-fw fa-camera"></i>
            <span>Maisons de Production</span>
        </a>
    </li>


</ul>
<!-- End of Sidebar -->