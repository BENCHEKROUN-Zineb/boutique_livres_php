<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
<div id="container" class="container">
		<!-- FORM SECTION -->
		<div class="row">
        <!-- SIGN UP -->
        <div class="col align-items-center flex-col sign-up">
            <div class="form-wrapper align-items-center">
                <div class="form sign-up">
                    <form method="post" action="signup.php" enctype="multipart/form-data">
                        <div class="input-group">
                            <i class='bx bxs-user'></i>
                            <input type="text" name="nom_u" placeholder="Username" required>
                        </div>
                        <div class="input-group">
                            <i class='bx bx-mail-send'></i>
                            <input type="email" name="email" placeholder="Email" required>
                        </div>
                        <div class="input-group">
                            <i class='bx bxs-lock-alt'></i>
                            <input type="password" name="mdp" placeholder="Password" required>
                        </div>
                        <div class="input-group">
                            <i class='bx bxs-lock-alt'></i>
                            <input type="password" name="confirm_mdp" placeholder="Confirm password" required>
                        </div>
                        <div class="input-group">
                            <i class='bx bxs-user'></i>
                            <input type="text" name="genre" placeholder="Genre" required>
                        </div>
                        <button type="submit" name="signup">
                            Sign up
                        </button>
                    </form>
                    <p>
                        <span>
                            Already have an account?
                        </span>
                        <b onclick="toggle()" class="pointer">
                            Sign in here
                        </b>
                    </p>
                </div>
            </div>
        </div>
        <!-- END SIGN UP -->
			<!-- SIGN IN -->
			<div class="col align-items-center flex-col sign-in">
				<div class="form-wrapper align-items-center">
					<?php 
						if (isset($_POST['login'])) {
							$email = $_POST['email'];
							$mdp = $_POST['mdp'];

							if(!empty($email) && !empty($mdp)){
								require_once '../include/connexion.php';
								$query = $pdo->prepare('SELECT * FROM utilisateur WHERE email = :emaill AND mdp = :mdpp');
								$query->execute(array('emaill' => $email, 'mdpp' => $mdp));
								
								if ($query->rowCount() > 0) {
									$user = $query->fetch(PDO::FETCH_ASSOC);
									$_SESSION['email'] = $user['email'];
									$_SESSION['isadmin'] = $user['isadmin'];
									
									if ($user['isadmin'] == 1) {
										header('Location: ../Admin/indexAdmin.php?page=dashboardAdmin');
									} else {
										header('Location: ../index.php?page=dashboardClient');
									}
									exit(); // Assurez-vous d'ajouter exit() après header pour arrêter l'exécution du script
								} else {
									echo 'Invalid email or password';
								}
							}else {
								echo 'Please fill in both fields';
							}
						}
					?>
					<form method="post" action="#" class="form sign-in">
						<div class="input-group">
							<i class='bx bxs-user'></i>
							<input type="text" name="email" placeholder="Username">
						</div>
						<div class="input-group">
							<i class='bx bxs-lock-alt'></i>
							<input type="password" name="mdp" placeholder="Password">
						</div>
						<button type="submit" name="login">
							Se Connecter
						</button>
						<p>
							<b>
								Mot de passe oublié ?
							</b>
						</p>
						<p>
							<span>
								Vous n'avez pas un compte ?
							</span>
							<b onclick="toggle()" class="pointer">
								S'incrire
							</b>
						</p>
					</form>
				</div>
				<div class="form-wrapper">
					<!-- Other content if needed -->
				</div>
			</div>

			<!-- END SIGN IN -->
		</div>
		<!-- END FORM SECTION -->
		<!-- CONTENT SECTION -->
		<div class="row content-row">
			<!-- SIGN IN CONTENT -->
			<div class="col align-items-center flex-col">
				<div class="text sign-in">
					<h2>
						Welcome
					</h2>
	
				</div>
				<div class="img sign-in">
		
				</div>
			</div>
			<!-- END SIGN IN CONTENT -->
			<!-- SIGN UP CONTENT -->
			<div class="col align-items-center flex-col">
				<div class="img sign-up">
				
				</div>
				<div class="text sign-up">
					<h2>
						Join with us
					</h2>
	
				</div>
			</div>
			<!-- END SIGN UP CONTENT -->
		</div>
		<!-- END CONTENT SECTION -->
	</div>

    <script src="../js/login.js"></script>

</body>
</html>