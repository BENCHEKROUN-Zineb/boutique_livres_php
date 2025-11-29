<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>

    <div class="d-flex flex-column flex-shrink-0 p-3 bg-light">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
            <a class="navbar-brand" href="#">Boutique Z-H</a>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="indexAdmin.php?page=dashboardAdmin" class="nav-link <?= $page == 'home' ? 'active' : 'link-dark' ?>" aria-current="page">
                    <i class="fa-solid fa-house" style="color: #74C0FC;"></i>
                    Accueil
                </a>
            </li>
            <li>
                <a href="indexAdmin.php?page=commandesAdmin" class="nav-link <?= $page == 'commandesAdmin' ? 'active' : 'link-dark' ?>">
                    <i class="fa-solid fa-table" style="color: #74C0FC;"></i>
                    Commandes
                </a>
            </li>
            <li>
                <a href="indexAdmin.php?page=produitAdmin" class="nav-link <?= $page == 'produitAdmin' ? 'active' : 'link-dark' ?>">
                    <i class="fa-solid fa-swatchbook" style="color: #74C0FC;"></i>
                    Livres
                </a>
            </li>
            <li>
                <a href="indexAdmin.php?page=categorieAdmin" class="nav-link <?= $page == 'categorieAdmin' ? 'active' : 'link-dark' ?>">
                    <i class="fa-solid fa-shapes" style="color: #74C0FC;"></i>
                    Categories
                </a>
            </li>
            <li>
                <a href="indexAdmin.php?page=auteurAdmin" class="nav-link <?= $page == 'auteurAdmin' ? 'active' : 'link-dark' ?>">
                    <i class="fa-solid fa-users" style="color: #74C0FC;"></i>
                    Auteurs
                </a>
            </li>
            <li>
                <a href="indexAdmin.php?page=clientAdmin" class="nav-link <?= $page == 'clientAdmin' ? 'active' : 'link-dark' ?>">
                    <i class="fa-solid fa-user-tie" style="color: #74C0FC;"></i>
                    Clients
                </a>
            </li>
        </ul>
        <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                <strong>mdo</strong>
            </a>
            <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser1">
                <li><a class="dropdown-item" href="#">New project...</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="../auth/logout.php">Se déconnecter</a></li>
            </ul>
        </div>
    </div>
