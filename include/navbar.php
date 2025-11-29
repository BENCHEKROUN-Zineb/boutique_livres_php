    <style>
        /* Custom styles to ensure the dropdown is displayed correctly */
        .navbar-nav .dropdown-menu {
            right: 0;
            left: auto;
        }
        .nav-cart {
            display: flex;
            align-items: center;
        }
        /* Fixing the navbar */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000; /* Ensures it stays on top of other content */
            background-color: #fff; /* Ensure background is visible */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Optional: Adds a slight shadow for better visibility */
        }
    </style>

    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-film mr-2"></i>
                Boutique Z-H
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto mb-2 mb-lg-0" id="list">
                    <li class="nav-item">
                        <a class="nav-link nav-link-1" href="index.php?page=dashboardClient">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-2" href="index.php?page=categorie">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-3" href="index.php?page=auteur">Auteurs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-4" href="index.php?page=contact">Contact</a>
                    </li>
                    <li class="nav-item nav-cart" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Panier">
                        <a href="index.php?page=ajouter_panier" style="text-decoration: none; color: #3399CC"><i class="fas fa-cart-shopping fa-xl"></i></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user-gear fa-lg"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="index.php?page=mesCommandes">Mes Commandes</a></li>
                            <li><a class="dropdown-item" href="#">Parametres de compte</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="auth/logout.php">Deconnexion</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const navLinks = document.querySelectorAll('.nav-link');

        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                navLinks.forEach(nav => nav.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Optionally, activate the current page link based on the URL
        const currentUrl = window.location.href;
        navLinks.forEach(link => {
            if (link.href === currentUrl) {
                link.classList.add('active');
            }
        });
    });
</script>



