<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique Z-H</title>
    <link rel="icon" type="image/png" href="../img/logo.png">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/templatemo-style.css">
    <link rel="stylesheet" href="../assets/font-awesome/css/all.min.css">
    <link href="../css/sidebars.css" rel="stylesheet">
    <script src="../js/jquery-3.6.0.js"></script>
    <!-- Include DataTables CSS and JS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>


    <style>
        body {
            display: flex;
        }
        #sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            width: 250px;
            background-color: #f8f9fa;
            padding: 0;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        #main-content {
            margin-left: 250px;
            flex-grow: 1;
        }
        #content {
            padding: 20px;
            background-color: #fff;
            margin-top: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <?php
        session_start();
        if (isset($_SESSION['email'])) {
            // echo 'welcome';
        }
    ?>

    <div id="sidebar">
        <?php include 'sidebarAdmin.php'; ?>
    </div>
    <div id="main-content">
        <?php include 'navAdmin.php'; ?>

        <div class="container-fluid">
            <div id="content">
                <?php
                    if(isset($_GET['page'])) {
                        $page = $_GET['page'];
                    } else {
                        $page = 'dashboardAdmin';
                    }
                    include("$page.php");
                ?>
            </div>
        </div>
        <?php //include 'footerAdmin.php'; ?>
    </div>

        <!-- Toast for success message -->
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 5">
            <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        opération accomplie avec succès!
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>

    <script>
        // Show the toast if success is true in URL
        document.addEventListener('DOMContentLoaded', function () {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('success') === 'true') {
                var successToast = new bootstrap.Toast(document.getElementById('successToast'));
                successToast.show();
            }
        });
    </script>


    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/main.js"></script>


</body>

</html>
