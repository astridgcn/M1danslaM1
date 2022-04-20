<?php
	session_start();
?>
<!DOCTYPE html>
<!--[if IE 7 ]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8 oldie"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html> <!--<![endif]-->


<!--
Variables : 
Connexion : pseudo ($pseudo), mot de passe($mdp).
Afficher le master : identifiant formation ($idM).
Recuillir les avis : contenu de l'avis ($avis), note ($note).
-->

<!-- MIS EN COMM POUR LA MISE EN PAGE
<?php
// If(isset($_GET["IdM2"])){
// 	echo 'La page que vous voulez consulter doit contenir le master 2 référence '.$_GET["IdM2"].'. ';
// }
// If(isset($_GET["IdM1"])){
// 	echo 'La page que vous voulez consulter doit contenir le master 1 référence '.$_GET["IdM1"].'. ';
// }
?>
-->

<head>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta charset="utf-8"/>
    <meta name="description" content="">
    <meta name="author" content="">

    <title>M1danslaM1 - Formation</title>

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

<?php
    
    // Connexion à la base de données. 
    $connexion=mysqli_connect("localhost", "root", "") ; 
    mysqli_select_db($connexion,"projet_db");
    $connexion->set_charset("utf8");

    // Si l'URL contient un MASTER 1.
    if(isset($_GET["IdM1"])){
        
        $req='
            SELECT DISTINCT
            master1.NomM1, master1.Ville, master1.Etablissement, master1.LienM1
            FROM master2 
            INNER JOIN master1 ON master2.IdM1 = master1.IdM1  
            WHERE master1.IdM1 = '.$_GET["IdM1"].' 

            ;';
        }

    // Si l'URL contient un MASTER 2.
    if(isset($_GET["IdM2"])){
        
        $req='
            SELECT DISTINCT
            master2.NomM2, master1.Ville, master1.Etablissement, master2.LienM2, master2.Dominante
            FROM master2 
            INNER JOIN master1 ON master2.IdM1 = master1.IdM1  
            WHERE master2.IdM2 = '.$_GET["IdM2"].' 

            ;';
        }


        // Envoi de la requête.
        $res=mysqli_query($connexion, $req);
        
        echo '
        <!--COMMUN PEU IMPORTE SI M1 OU M2 -->

    	    <!-- Présentation -->
            <section id="main" >
                <h1>
                    Présentation du Master.
                </h1>
                <h3>
                    Nom du Master : ';

                    // NOM.
                    while($M=mysqli_fetch_array($res)){
                        if(isset($_GET["IdM1"])){
                            echo $M["NomM1"];
                        }
                        if(isset($_GET["IdM2"])){
                            echo $M["NomM2"];
                        }
                    }
                    echo'
                </h3>
             	</br>
                <h4>';

                    // DOMINANTE si MASTER 2.
                    if(isset($_GET["IdM2"])){
                    	$res=mysqli_query($connexion, $req);
                        echo' 
                        Dominante : ';
                        while($M=mysqli_fetch_array($res)){
                            echo $M["Dominante"];
                        }
                        echo'
                        </br>
                        </br>
                        ';
             	 }

                    // ETABLISSEMENT.
                echo'
                Etablissement : ';
                $res=mysqli_query($connexion, $req);
                while($M=mysqli_fetch_array($res)){
                    echo $M["Etablissement"];
                }
                echo'
             	</br>
             	</br>
             	Ville : ';

                // VILLE.
                $res=mysqli_query($connexion, $req);
                while($M=mysqli_fetch_array($res)){
                    echo $M["Ville"];
                }
                echo'
             	</h4>
             	</br>
             	<p>
             	<i>Pour plus d\'informations : </i>';

                // LIEN.
                $res=mysqli_query($connexion, $req);
                while($M=mysqli_fetch_array($res)){
                    if(isset($_GET["IdM1"])){
                        echo '<a href="'.$M["LienM1"].'">'.$M["LienM1"].'</a>';
                    }
                    if(isset($_GET["IdM2"])){
                        echo '<a href="'.$M["LienM2"].'">'.$M["LienM2"].'</a>';
                    }
                }

                echo'
             	</p>
                <a class="back-to-top" href="#main">Remonter</a>

            </section>
        ';


    // MASTER 1.
    if(isset($_GET["IdM1"])){
    	$req='
            SELECT *
            FROM 
            (admission INNER JOIN master1 
            ON admission.IdM1 = master1.IdM1)
            INNER JOIN licence
            ON admission.IdLicence = licence.IdLicence
            WHERE master1.IdM1='.$_GET["IdM1"].' 
            ;';
    	
    	$res=mysqli_query($connexion, $req);
     	
    	

    	echo'

    	    <!-- Admission -->
    	    <section id="Admission" >

    	        <h1>Admission.</h1>

    	            <h2>Modalités d\'accès au M1.</h2>
    	            Ce Master est ouvert aux étudiant.es détenteur.rices d\'un diplôme de Licence ou équivalent en Sciences Cognitives, dans une discipline connexe, ou dans une discipline en lien direct avec la dominante du Master 1.
    	            </br>
    	            </br>
    	            <h2>Mentions conseillées.</h2>
    	            <ul>            	
    	    ';
            while($licence=mysqli_fetch_array($res)){ 
     		    echo '<li> Licence : '.$licence["Domaine"].'</li>'; 
     	        }
    	    
            echo'    	
    	            </ul>
    	            <a class="back-to-top" href="#main">Remonter</a>
    	        </section>

    	        <!-- Mentions -->
    	        <section id="Mentions" >

    	            <h1>Mentions.</h1>

    	            <h2>Parcours M2 proposés.</h2>
    	            <ul>';

                        $req1='SELECT * FROM master2 WHERE master2.IdM1='.$_GET["IdM1"].' ORDER BY Dominante ASC;';
                        $res1=mysqli_query($connexion, $req1);
                        $n = 0;

                        while ($mention=mysqli_fetch_array($res1)){
                            echo '
                                <li>
                                    <a href="Formation.php?IdM2='.$mention['IdM2'].'">'.$mention['NomM2'].' </a>('.$mention['Dominante'].')
                                </li>'; 
                            }

    	        echo '</ul>
    	            <a class="back-to-top" href="#main">Remonter</a>
    	        </section>
    	<!--FIN SI M1 -->';
    	}

    // MASTER 2.
    if(isset($_GET["IdM2"])){
    	$req='
            SELECT *
            FROM master2 
            INNER JOIN master1 ON master2.IdM1 = master1.IdM1  
            WHERE master2.IdM2='.$_GET["IdM2"].'";';

        $res=mysqli_query($connexion, $req);
    	echo'
          <!-- M1 -->
          <section id="M1" >

                <h1>Admission.</h1>

                <h2>Modalités d\'accès au M2.</h2>
                Ce Master 2 est ouvert aux étudiant.es détenteur.rices d\'un Master 1 en Sciences Cognitives ou dans une discipline en lien direct avec la dominante du Master 2.
                </br>
                </br>
                <h2>Master 1 proposés.</h2>
                <ul>';

                        $req1='
                            SELECT * 
                            FROM master1
                            INNER JOIN master2
                            ON master1.IdM1=master2.IdM1
                            WHERE master2.IdM2='.$_GET["IdM2"].' 
                            ORDER BY Dominante ASC;';
                        $res1=mysqli_query($connexion, $req1);
                        $n = 0;

                        while ($mention=mysqli_fetch_array($res1)){
                            echo '
                                <li>
                                    <a href="Formation.php?IdM1='.$mention['IdM1'].'">'.$mention['NomM1'].' </a>('.$mention['Dominante'].')
                                </li>'; 
                            }

                echo '</ul>
                <a class="back-to-top" href="#main">Remonter</a>
          </section>';
    	}

    echo'
    <!-- COMMUN -->

        <!-- Avis -->
        <section id="Avis" >

            <h1>Avis.</h1>

            <h2>Commentaires d\'ancien.nes et actuel.les étudiant.es.</h2>
            </br>
            ';

            echo'<!-- SI M1 -->

            <table width="100%" border="3px">';


    // MASTER 1.
    if (isset($_GET["IdM1"])){
        $a = 0;
        $reqM1='
        SELECT * 
        FROM avisM1 
        INNER JOIN utilisateur 
        ON avisM1.IdUser=utilisateur.IdUser 
        WHERE IdM1='.$_GET["IdM1"].' ORDER BY Note1 DESC;';
        $resM1=mysqli_query($connexion, $reqM1);

        while ($avisM1=mysqli_fetch_array($resM1)){
            $a += 1;
            $Contenu=$avisM1['Contenu1'];
            $Note=$avisM1['Note1'];
            $Pj=$avisM1['Pj1'];
            $IdUser=$avisM1['IdUser'];
            $IdM=$avisM1['IdM1'];
            $Pseudo=$avisM1['Pseudo'];
            $Dpl=$avisM1['Diplome'];
            $Avatar=$avisM1['Avatar'];
        echo '
            <tr>
                <th>
                    <h3>
                        Posté par
                    </h3>
                </th>
                <th>
                    <h3>
                        Avis
                    </h3>
                </th>
                <th>
                    <h3>
                        Note
                    </h3>
                </th>
            </tr>
            <tr>
                <td width="25%">
                    <center>
                        <br>
                        <img src="images/Pdps/'.$Avatar.'" width=60px style="clip-path:ellipse(30px 30px)"/>
                    </center>
                    <center>
                        <h4>
                            '.$Pseudo.'
                        </h4>
                    </center>
                    <center>
                        '.$Dpl.'
                    </center>
                    </br>
                    </br>
                </td>
                <td>'
                    .$Contenu.
                    '</br>
                    </br>
                    <img src="images/Avis/'.$Pj.'" width=400px>
                </td>
                <th></th><td width="3%">'
                .$Note.
                '</td>
            </tr>';
       }
       if ($a==0){
        echo 'Il n\'y a pour l\'instant aucun avis posté.';
       }
  }


    // MASTER 2.
    if (isset($_GET["IdM2"])){
        $a = 0;
        $reqM2='
        SELECT * 
        FROM avisM2 
        INNER JOIN utilisateur
        ON avisM2.IdUser=utilisateur.IdUser
        WHERE IdM2='.$_GET["IdM2"].' ORDER BY Note2 DESC;';
        $resM2=mysqli_query($connexion, $reqM2);

        while ($avisM2=mysqli_fetch_array($resM2)){
            $a += 1;
            $Contenu=$avisM2['Contenu2'];
            $Note=$avisM2['Note2'];
            $Pj=$avisM2['Pj2'];
            $IdUser=$avisM2['IdUser'];
            $IdM=$avisM2['IdM2'];
            $Pseudo=$avisM2['Pseudo'];
            $Dpl=$avisM2['Diplome'];
            $Avatar=$avisM2['Avatar'];
            echo '
                <tr>
                    <th>
                        <h3>
                            Posté par
                        </h3>
                    </th>
                    <th>
                        <h3>
                            Avis
                        </h3>
                    </th>
                    <th>
                        <h3>
                            Note
                        </h3>
                    </th>
                </tr>
                <tr>
                    <td width="25%">
                            <center>
                                <br>
                                <img src="images/Pdps/'.$Avatar.'" width=60px style="clip-path:ellipse(30px 30px)"/>
                            </center>
                        <h4>
                            <center>
                                '.$Pseudo.'
                            </center>
                        </h4>
                            <center>
                                '.$Dpl.'
                            </center>
                        </br>
                        </br>
                    </td>
                    <td>'
                        .$Contenu.'
                        </br>
                        </br>
                        <img src="images/Avis/'.$Pj.'" width=400px>
                    </td>
                    <th>Note</th><td width="3%">'
                    .$Note.
                    '</td>
                </tr>';
            }
            if ($a==0){
                echo 'Il n\'y a pour l\'instant aucun avis posté.';
            }

        }

    echo '</table>';

    // UTILISATEUR CONNECTÉ.
    if (isset($_SESSION["Pseudo"])){
		echo'
        <br>
        <br>	 
		<h2>Poster un commentaire.</h2>
			<p>Veuillez accompagner votre avis de votre emploi du temps ou de la plaquette de formation</p>
			<form action="Avis.php" method="POST" ENCTYPE="multipart/form-data">

                    Contenu : <br>
                    <textarea rows=6 cols=80 name="contenu"></textarea>
                    <br>
                    <br>

                    Note : <select name="note">
                                <option value=""></option>
                                <option value="1"  >1  </option>
                                <option value="1,5">1,5</option>
                                <option value="2"  >2  </option>
                                <option value="2,5">2,5</option>
                                <option value="3"  >3  </option>
                                <option value="3,5">3,5</option>
                                <option value="4"  >4  </option>
                                <option value="4,5">4,5</option>
                                <option value="5"  >5  </option>
                              </select>
                    <br>

                    <input type="hidden" name="MAX_FILE_SIZE" value=1000000>
                    Pièce jointe : <input type="file" name="nom_du_fichier" style="font-family: MerriweatherBold; color: #3B3B3B">
                    <br>
                    <br>';

                    if(isset($_GET["IdM1"])){
                        echo '<input type="hidden" name=IdM1 value="'.$_GET["IdM1"].'"/>';
                    }

                    if(isset($_GET["IdM2"])){
                        echo '<input type="hidden" name=IdM2 value="'.$_GET["IdM2"].'"/>';
                    }

                    echo '
                    <input type="reset" value="Réinitialiser" style="font-family: MerriweatherBold; color: #3B3B3B"/>
                    <input type="submit" value="Envoyer" style="font-family: MerriweatherBold; color: #3B3B3B"/>
                </form>
      		';
    	}
    else {
        echo '</br>Vous pouvez donnez votre avis en vous <a href="Profil.php">connectant</a>  ou en vous <a href="Profil.php">inscrivant</a>.';
    }

    	mysqli_close($connexion);
    ?>

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