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

    <title>M1danslaM1 - Accueil</title>

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
    <section id="main">
        <h1>Recherche.</h1>

        <?php
            echo'
            <form action="Recherche.php" method="GET">
                <h2>Critères.</h2> 
                <b>Dominante :</b>     
                <select name="dominante">';

                    // Requête pour séléctionner une dominante.
                    $connexion=mysqli_connect("localhost", "root", "") ; 
                    $connexion->set_charset("utf8");
                    mysqli_select_db($connexion,"projet_db");
                    $req="SELECT DISTINCT Dominante FROM master2 ORDER BY Dominante ASC;";
                    $res=mysqli_query($connexion, $req);
                    while ($dom=mysqli_fetch_array($res)){            
                        echo'<option value="'.$dom["Dominante"].'"> 
                                '.$dom["Dominante"].'
                            </option>';
                        }
            echo'
                </select>
                ';
            echo'
            <br>
                <b>Ville :</b>             
                <select name="ville">';

                    // Requête pour séléctionner une ville.
                    $req="SELECT DISTINCT Ville FROM master1 ORDER BY Ville ASC;";
                    $res=mysqli_query($connexion, $req);
                    while ($ville=mysqli_fetch_array($res)){
                        echo'<option value="'.$ville["Ville"].'"> 
                                '.$ville["Ville"].'
                            </option>';
                            }
            echo'
                <br>
                <br>
                <input type="submit" value="Rechercher" style="font-family: MerriweatherBold; color: #3B3B3B"/>
                <br>
            </form>';
            if (isset($_GET["dominante"])){
            echo'<br>
                <h2>
                    Résultats.
                </h2>';
                }

        ?>

        <table width="100%" border="1">
            <?php
                $connexion=mysqli_connect("localhost", "root", "") ; 
                mysqli_select_db($connexion,"projet_db");
                $connexion->set_charset("utf8");

                if(isset($_GET['dominante'])){

                    $req2='

                    SELECT 
                    master1.IdM1,
                    master2.IdM2,
                    master1.NomM1, master1.Ville, master1.Etablissement, 
                    master2.NomM2, master2.Dominante 
                    FROM master2 
                    INNER JOIN master1 ON master2.IdM1 = master1.IdM1  
                    WHERE master2.Dominante LIKE "'.$_GET["dominante"].'" AND master1.Ville LIKE "'.$_GET["ville"].'" 
                    ;';

                    $res2=mysqli_query($connexion, $req2);
                    $n = 0;
                    echo '<h3>Master 1 et 2 en '.$_GET["dominante"].' dans la ville de '.$_GET["ville"].'.</h3></br>';
                    while ($ligne_master=mysqli_fetch_array($res2)){
                        $n = $n +1;
                        echo'<tr> 

                                <td width = "3%">'
                                    .$n.
                                '</td>

                                <td>
                                    <a href="Formation.php?IdM1='.$ligne_master["IdM1"].'"> M1 : '.$ligne_master["NomM1"].'.</a>
                                    <br>
                                    <a href="Formation.php?IdM2='.$ligne_master["IdM2"].'"> M2 : '.$ligne_master["NomM2"].'.</a>
                                </td>

                                <td>'
                                    .$ligne_master['Ville'].
                                '</td>

                                <td>'
                                    .$ligne_master['Etablissement'].
                                '</td>

                             </tr>'; 
                        }
                        if ($n==0) {
                            echo 'Il n\'existe pas de Master en '.$_GET["dominante"].' dans la ville de '.$_GET["ville"].'.</br>';
                        }
                    }

                mysqli_close($connexion) ;
            ?>
        </table>
        <a class="back-to-top" href="#main">Remonter</a>
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
