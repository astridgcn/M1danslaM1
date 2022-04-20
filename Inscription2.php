<?php
	session_start();
?>
<html>
<head>
	<title>M1danslaM1 - Inscription & Modification</title>
	<link rel="icon" type="image/png" sizes="16x16" href="images/main.png">
</head>

<body>
<?php
	//Vérifications : tous les champs sont remplis.
	if (!empty($_POST["pseudo"]) and !empty($_POST["mdp"]) and !empty($_POST["mdp2"]) and !empty($_POST["nom"])and !empty($_POST["prenom"]) and !empty($_POST["age"]) and !empty($_POST["email"]) and !empty($_POST["dpl"]) and $_POST["mdp"]==$_POST["mdp2"]) { 
	
		// Informations de connexion. 
		$pseudo = $_POST["pseudo"];
		$mdp = $_POST["mdp"];

		$nom = $_POST["nom"];
		$prenom = $_POST["prenom"];
		$age = $_POST["age"];
		$email = $_POST["email"];

		$dpl = $_POST["dpl"];
		$dpl2 = $_POST["dpl2"];
		$formact = $_POST["formact"];

		if($_FILES["nom_du_fichier"]["name"]==""){
				$_FILES["nom_du_fichier"]["name"]= "Avatar.png";
			}
		else{
			// Vérification image.
			if ($_FILES['nom_du_fichier']['error']) {
				die("Erreur du transfert de l'image.<br><a href=\"Index.php\">Accueil</a>");
			}

			// Transfert de l'image vers le répertoire. 
			if (isset($_FILES['nom_du_fichier']['name']) && ($_FILES['nom_du_fichier']['error'] == UPLOAD_ERR_OK)) {
				$chemin_destination = 'images/Pdps/'; 
				move_uploaded_file($_FILES['nom_du_fichier']['tmp_name'], $chemin_destination.$_FILES['nom_du_fichier']['name']);
			}
		}

		// Connexion à la base de données. 
		$connexion = mysqli_connect("localhost", "root", "");
		$connexion->set_charset("utf8");
		mysqli_select_db($connexion, "projet_db");

		if(!empty($_POST["modif"])){
			$req='
	                UPDATE UTILISATEUR
	                SET Pseudo = "'.$_POST['pseudo'].'", Mdp = "'.$_POST['mdp'].'", Nom = "'.$_POST['nom'].'", Prenom = "'.$_POST['prenom'].'", Age = '.$_POST['age'].', Mail = "'.$_POST['email'].'", Avatar = "'.$_FILES['nom_du_fichier']['name'].'", Diplome = "'.$_POST['dpl'].'", FormationActuelle = "'.$_POST['formact'].'"
	                WHERE IdUser = '.$_SESSION['IdUser'].'
	                ;';

	        echo $req;
	        $_SESSION=array();
		}
		else{
			$req = '
					INSERT INTO UTILISATEUR (Pseudo, Nom, Prenom, Mail, Mdp, Age, Avatar, Diplome, FormationActuelle) 
					VALUES ("'.$pseudo.'", "'.$nom.'", "'.$prenom.'","'.$email.'","'.$mdp.'","'.$age.'", "'.$_FILES['nom_du_fichier']['name'].'", "'.$dpl.' '.$dpl2.'","'.$formact.'");';
			echo $req;
		}

		mysqli_query($connexion, $req);

		mysqli_close($connexion); 

		echo 'Le pseudo utilisé est '.$pseudo.', l\'email est '.$email.' et le mot de passe '.$mdp.'.';

		header("location:Profil.php");


	}
	else {
		if ($_POST["mdp"]!=$_POST["mdp2"]){
			die("Erreur : les mots de passe sont différents.");
		}
		else{ 
			die("Erreur : veuillez remplir tous les champs.");
		}
	}
?>
<br>
<br>
<a href="Index.php">Accueil</a>
</body>
</html>