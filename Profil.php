<?php
    session_start();
?>
<!DOCTYPE html>
<!--[if IE 7 ]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8 oldie"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html> <!--<![endif]-->

<head>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta charset="utf-8"/>
    <meta name="description" content="">
    <meta name="author" content="">

    <title>M1danslaM1 - Profil</title>

    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/nivo-slider.css" type="text/css" />
    <link rel="stylesheet" href="css/jquery.fancybox-1.3.4.css" type="text/css" />
    <link rel="icon" type="image/png" sizes="16x16" href="images/main.png">

    <!--[if lt IE 9]>
	    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

</head>

<body>

<!-- header-wrap -->
<div id="header-wrap">
    <header>
        <hgroup>
            <h1 style="color:white">M1danslaM1 !</h1>
        </hgroup>

        <nav>
            <ul>
                <li><a href="Index.php">Accueil</a></li>
                <li><a href="Recherche.php">Recherche</a></li>
                <?php
                if (isset($_SESSION["Pseudo"])){
                    echo '<li><a href="Profil.php">'.$_SESSION["Prenom"].'</a></li>';
                }
                else {
                    echo '<li><a href="Profil.php">Profil</a></li>';
                }
                ?>
                <li><a href="Deconnexion.php">Déconnexion</a></li>
            </ul>
        </nav>

    </header>
</div>

<!-- content-wrap -->
<div class="content-wrap">

    <!-- Profil -->
    <section id="main">

            <h1>Votre profil.</h1>

            <h3>C'est ici que vous pouvez visualiser les informations vous concernant.</h3>
            <?php
                if (isset($_SESSION["Pseudo"])){

                    echo'
                    	
                    	<br>

                    	<img src="images/Pdps/'.$_SESSION["Pdp"].'" width=80px 
                    	style ="width:80px;
   clip-path:ellipse(40px 40px);"">
                    	<br>
                    	<br>

						<b>Pseudo : </b>'.$_SESSION["Pseudo"].'
						<br>
						<br>

						<b>Nom : </b>'.$_SESSION["Nom"].'
						<br/>
						<b>Prénom : </b>'.$_SESSION["Prenom"].'
						<br>
						<b>Âge : </b>'.$_SESSION["Age"].'
						<br>
						<br>
						
						<b>Adresse e-mail : </b>'.$_SESSION["Email"].'
						<br>
						<br>

						<b>Dernier diplôme obtenu : </b>'.$_SESSION["Dpl"].'
                        
						<br>
						<b>Formation actuelle : </b>'.$_SESSION["Formact"].'
						<br>
						<br>
                        <a href="ModifProfil.php">Modifier mon profil</a>
                        <br>
                        <br>
                    ';
                }
                else {
                    echo '</br>Oops... Il semblerait que vous ne soyez pas connecté.e.
                    <a class="back-to-top" href="#main">Remonter</a>
    </section>';
                }
            ?>
            
    <!-- Connexion -->
    

             <!--
            Variables :

            Connexion : pseudo ($pseudo), mot de passe($mdp).
            -->

    <?php
        if (!isset($_SESSION["Pseudo"])){
            echo'
				<section id="Connexion" >

	                <h1>Connexion.</h1>

	                    <h2>Connectez-vous à votre espace personnel.</h2>

	                    <form action="Connexion2.php" method="POST">
	                        Pseudo :
	                        <input type="text" size="20" name="pseudo" style="font-family: MerriweatherBold; color: #3B3B3B"/>
	                        <br>
	                        <br>
	                        Mot de passe :
	                        <input type="password" size="15" name="mdp" style="font-family: MerriweatherBold; color: #3B3B3B"/>
	                        <br>
	                        <br>
	                        <input type="reset" value="Réinitialiser" style="font-family: MerriweatherBold; color: #3B3B3B"/>
	                        <input type="submit" value="Envoyer" style="font-family: MerriweatherBold; color: #3B3B3B" />
	                    </form>

	            	<a class="back-to-top" href="#main">Remonter</a>
	    		
	    		</section>';
        }
        
    ?>





      <!-- Inscription -->
    <section id="Inscription" >

        <?php
            if(!isset($_SESSION['Pseudo'])){
                echo'<h1>Inscription.</h1>

                    <h2>Vous n\'avez pas encore de compte ? Créez-le.</h2>
                    <p>Attention : Par mesure de sécurité, vous serez invité.e à vous connecter à la suite de votre inscription.</p>
                
                        <form action="Inscription2.php" method="POST" ENCTYPE="multipart/form-data">
                            <h3>Veuillez remplir le formulaire suivant :</h3>
                            </br>

                            Pseudo : <input type="text" size="20" name="pseudo" style="font-family: MerriweatherBold; color: #3B3B3B"/>
                            <br>
                            
                        	Mot de passe : <input type="password" size="15" name="mdp" style="font-family: MerriweatherBold; color: #3B3B3B"/>
                        	<br>
                            
                            Confirmation du mot de passe : <input type="password" size="15" name="mdp2" style="font-family: MerriweatherBold; color: #3B3B3B"/>
                            <br>
                            <br>

                            Nom : <input type="text" size="15" name="nom" style="font-family: MerriweatherBold; color: #3B3B3B"/>
                            <br/>
                            
                            Prénom : <input type="text" size="15" name="prenom" style="font-family: MerriweatherBold; color: #3B3B3B"/>
                            <br>

                            Âge : <input type="Number" size="5" name="age" min="16" max="99" style="font-family: MerriweatherBold; color: #3B3B3B"/>
                            <br>
                            <br>
                            
                            Adresse e-mail : <input type="text" size="25" name="email" style="font-family: MerriweatherBold; color: #3B3B3B"/>
                            <br>

                            <input type="hidden" name="MAX_FILE_SIZE" value=1000000 style="font-family: MerriweatherBold; color: #3B3B3B">
                            Photo de profil : <input type="file" name="nom_du_fichier" style="font-family: MerriweatherBold; color: #3B3B3B">
                            <br>
                            <br>

                            Dernier diplôme obtenu  : <select name="dpl" style="font-family: MerriweatherBold; color: #3B3B3B">
                                        <option value="">Choisir</option>
                                        <option value="Baccalauréat">Baccalauréat</option>
                                        <option value="Licence 1">Licence 1</option>
                                        <option value="Licence 2">Licence 2</option>
                                        <option value="Licence 3">Licence 3</option>
                                        <option value="Master 1">Master 1</option>
                                        <option value="Master 2">Master 2</option>
                                        <option value="Doctorat">Doctorat</option>
                                      </select>
                                <input type="text" size="15" name="dpl2"/>
                            <br>

                            Formation actuelle : <input type="text" size="60" name="formact" style="font-family: MerriweatherBold; color: #3B3B3B"/>
                            <br>
                            <br>

                            <input type="reset" value="Réinitialiser" style="font-family: MerriweatherBold; color: #3B3B3B"/>
                            <input type="submit" value="Envoyer" style="font-family: MerriweatherBold; color: #3B3B3B" />
                        </form>
                    <a class="back-to-top" href="#main">Remonter</a>';
                }
        ?>

        
    </section>
</div>
<!-- footer -->
<footer>
    <div class="footer-content">
        <ul class="footer-menu">
            <li><a href="Index.php">Accueil</a></li>
            <li><a href="Recherche.php">Recherche</a></li>
            <li><a href="Profil.php">Profil</a></li>
            <li><a href="Deconnexion.php">Déconnexion</a></li>
            <!-- <li class="rss-feed"><a href="#">RSS Feed</a></li> -->
        </ul>

        <p class="footer-text">
            &copy; 2020 M1danslaM1 &nbsp; &nbsp;  
            Design by As & Ben &nbsp; &nbsp;            
        </p>

    </div>
</footer>

<!-- scripts -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/jquery-1.6.1.min.js"><\/script>')</script>

<script src="js/jquery.smoothscroll.js"></script>
<script src="js/jquery.nivo.slider.pack.js"></script>
<script src="js/jquery.easing-1.3.pack.js"></script>
<script src="js/jquery.fancybox-1.3.4.pack.js"></script>
<script src="js/init.js"></script>

</body>
</html>
