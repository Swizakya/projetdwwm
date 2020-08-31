<?php 
SESSION_START();

if(!isset($_SESSION['Idsession'])){ 
   header('Location: acceuil.php'); 
   exit; 

if (isset( $_SESSION['Idsession'])){  
    $idsession = $_SESSION['Idsession'];
    $serveur ="localhost";
    $login= "root";
    $pass= "";
    $dbname="moi";
    $okid =$ok['Idsession'];
    $Pseudo = $reqall['Pseudo'];
    $Cle = $reqall['CLE'];
   
    $personnel = '<a href="editionprofil.php">Editer mon profil</a><a href="deconnexion.php">Se déconnecter</a>';
    
    $bdd = new PDO("mysql:host=$serveur;dbname=$dbname",$login,$pass);
   $options         = array(
     PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
     PDO::ATTR_CASE               => PDO::CASE_LOWER,
     PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION
   );
   $id= $bdd->prepare("SELECT Idsession FROM user WHERE Idsession like '$idsession'");
   if($id->execute(array(':Idsession' => $idsession))  && $ok= $id->fetch()){
      $okid =$ok['Idsession'];
   }
   
    $allinfos= $bdd->prepare("SELECT * FROM user WHERE Idsession like '$idsession'");
    if($allinfos->execute(array(':Idsession' => $idsession))  && $reqall= $allinfos->fetch())
      {
       $Pseudo = $reqall['Pseudo'];
       $Cle = $reqall['CLE'];
       $_SESSION['Nom']  = $reqall['Nom'];
       $_SESSION['Prenom']  = $reqall['Prenom'];
       $_SESSION['Pseudo']  = $reqall['Pseudo'];
       $_SESSION['Mail']  = $reqall['Mail'];
       $_SESSION['MDP'] =  $reqall['MDP'];
      } }  
}
?>


<!DOCTYPE html>
<html>
    <head>
            <title>Espace Membre</title>
        <meta charset="utf-8" />
  </head>

  </head>

<body>

	<h2 align="center" class="Titre"> BIENVENUE <?php var_dump($_SESSION['MDP']); echo $_SESSION['Pseudo']; ?> </h2>
  <body>
      <div align="center">
         <h2>Profil <?php echo 'de '.$_SESSION['Prenom'].' '.$_SESSION['Nom'].',' ; ?></h2>
         <br /><br />
         Pseudo = <?php echo $_SESSION['Pseudo']; ?>
         <br />
         Mail = <?php echo $_SESSION['Mail']; ?>
         <br /> <br />
      <?php 
      if (isset($_SESSION['Idsession'])){
         $personnel = '<a href="editionprofil.php">Editer mon profil</a>    <a href="deconnexion.php">Se déconnecter</a>';

         echo $personnel;
      } ?>
        
      </div>
   </body>
</html>