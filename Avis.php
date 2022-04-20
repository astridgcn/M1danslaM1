<?php
	session_start();
?>
<html>
<head>
	<title>M1danslaM1 - Avis</title>
	<link rel="icon" type="image/png" sizes="16x16" href="images/main.png">
</head>

<body bgcolor="#EEEEEE" text="black">

<?php

	/* Si l'utilisateur est connecté */
	if(isset($_SESSION['Pseudo'])){
		echo'Vous êtes connecté en tant que '.$_SESSION['Pseudo'].'.<br>';

		/* Si l'avis est posté pour un MASTER 1 */
		if (!empty($_POST["contenu"]) and !empty($_POST["IdM1"]) and !empty($_POST["note"])) {
			



			// Vérification image.
			if ($_FILES['nom_du_fichier']['error']) {
				die("Erreur du transfert de l'image.");
				}



			// Transfert de l'image vers le répertoire. 
			if (isset($_FILES['nom_du_fichier']['name']) && 
				($_FILES['nom_du_fichier']['error'] == UPLOAD_ERR_OK)) {

				$chemin_destination = 'images/Avis/'; 
				
				move_uploaded_file($_FILES['nom_du_fichier']['tmp_name'], 
					$chemin_destination.$_FILES['nom_du_fichier']['name']);
				}


			/* Connexion à la base de données */
			$connexion=mysqli_connect("localhost","root","");
			mysqli_select_db($connexion, "projet_db");
			$connexion->set_charset("utf8");

			/* Création de la requête */
			$req='
			INSERT INTO AVISM1 (IdUser, IdM1, Contenu1, Note1, Pj1) 
			VALUES ('.$_SESSION['IdUser'].', '.$_POST["IdM1"].', "'.$_POST["contenu"].'", '.$_POST["note"].', "'.$_FILES['nom_du_fichier']['name'].'");';
			/* Envoi de la requête */
			mysqli_query($connexion, $req);
			Echo 'Votre avis a bien été posté pour le Master 1. ';

			}


		/* Si l'avis est posté pour un MASTER 2 */
		else if (!empty($_POST["contenu"]) and !empty($_POST["IdM2"]) and !empty($_POST["note"])) {
			

			// Vérification image.
			if ($_FILES['nom_du_fichier']['error']) {
				die("Erreur du transfert de l'image.");
				}
			// Transfert de l'image vers le répertoire. 
			if (isset($_FILES['nom_du_fichier']['name']) && ($_FILES['nom_du_fichier']['error'] == UPLOAD_ERR_OK)) {
				$chemin_destination = 'images/Avis/'; 
				move_uploaded_file($_FILES['nom_du_fichier']['tmp_name'], $chemin_destination.$_FILES['nom_du_fichier']['name']);
				}

			/* Connexion à la base de données */
			$connexion=mysqli_connect("localhost","root","");
			mysqli_select_db($connexion, "projet_db");
			$connexion->set_charset("utf8");
			/* Création de la requête */
			$req='
			INSERT INTO AVISM2 (IdUser, IdM2, Contenu2, Note2, Pj2) 
			VALUES ('.$_SESSION['IdUser'].', '.$_POST["IdM2"].', "'.$_POST["contenu"].'", '.$_POST["note"].', "'.$_FILES['nom_du_fichier']['name'].'");';
			/* Envoi de la requête */
			mysqli_query($connexion, $req);
			Echo 'Votre avis a bien été posté pour le Master 2. ';

			}
			else {
				die("Veuillez remplir tous les champs. ");
			}
		}

		/* Si l'utilisateur n'est pas connecté */
		else{
			echo'Erreur : vous devez être connecté.e pour pouvoir poster un message.';
		}
?>

<br>
<a href="Index.php">Accueil</a>

</body>
</html>