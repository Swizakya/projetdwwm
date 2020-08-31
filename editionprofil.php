<?php 
SESSION_START();
$serveur ="localhost";
$login= "root";
$pass= "";
$dbname="moi";
if(!isset($_SESSION['Idsession'])){ 
   header('Location: acceuil.php'); 
   exit; }

if (isset( $_SESSION['Idsession'])){
   $idsession = $_SESSION['Idsession'];
   
   $bdd = new PDO("mysql:host=$serveur;dbname=$dbname",$login,$pass);
   $options         = array(
     PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
     PDO::ATTR_CASE               => PDO::CASE_LOWER,
     PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION
   );
    $allinfos= $bdd->prepare("SELECT * FROM user WHERE Idsession ='$idsession'");
    if($allinfos->execute(array())  && $reqall= $allinfos->fetch())
      {
       $_SESSION['Nom']  = $reqall['Nom'];
       $_SESSION['Prenom']  = $reqall['Prenom'];
       $_SESSION['Pseudo']  = $reqall['Pseudo'];
       $_SESSION['Mail']  = $reqall['Mail'];
       $_SESSION['Idsession'] =$reqall['Idsession'] ;
       $urpass =$reqall['MDP'] ; }

      if (isset($_POST['Enregistrer']))
      {
					extract($_POST);		
        $Pseudo= trim(strip_tags(trim($_POST['Pseudo'])));
        $MDP1 = trim(strip_tags ($_POST['MDP1'])); 
        $MDP =  password_hash("$MDP1", PASSWORD_DEFAULT);
        $Mail =  strip_tags(trim($_POST['Mail']));
        $idsession = $_SESSION['Idsession'];
        $idsession = $_SESSION['Idsession'];
        $urpass =$reqall['MDP'] ;
        
   $req = $bdd -> prepare (" SELECT Pseudo FROM user WHERE Pseudo= '$Pseudo'");
   $req->execute(array());
   $req->rowCount();

        if($Pseudo != "" && $_POST['MDP1'] != "" && $Mail == "")
              {                
                  if   ( $req->rowCount() ==0)
                  {
                     if (password_verify($MDP1, $urpass)) { 
               // header('Location: espace.php?id='.$_SESSION['Idsession']);

                     try { 
                        $bdd = new PDO("mysql:host=$serveur;dbname=$dbname",$login,$pass,$options);
                        $sqlpass = $bdd->prepare("UPDATE user SET Pseudo ='$Pseudo' WHERE Idsession= '$idsession'");
                        $sqlpass->execute(array());
                        echo $oknew = "Votre Pseudo à été mise à jour";
                       }
                       catch (Exception $e)
                       {
                         echo "Connection à MySql impossible : ", $e->getMessage();
                         die();
                       }
           
                  }}}}}
                  if (isset($_POST['Enregistrer']))
                  {
                           extract($_POST);		
                    $Pseudo=strip_tags(trim($_POST['Pseudo']));
                    $MDP1 = trim(strip_tags ($_POST['MDP1'])); 
                    $Mail =  strip_tags(trim($_POST['Mail']));
                   $idsession = $_SESSION['Idsession'];
                    $urpass =$reqall['MDP'] ;
               if (!password_verify($MDP1, $urpass)) { 
                   echo "mot de passe incorrecte";}
               }
            

   ?>
<!DOCTYPE html>
<html>
   <head>
      <title>Editer mon profil</title>
      <meta charset="utf-8">
   </head>
   <body>
   <script>
function myFunction() {
  var x = document.getElementById("myInput");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>

<div align="right"> <?php if(isset($_SESSION['Idsession'])){ var_dump(  $idsession.''. $MDP);echo "BIENVENUE " .$_SESSION['Prenom']. " "  .$_SESSION['Nom']. "," ; }?></div>
            <form method="POST" action="editionprofil.php">
            <h2 align="center" class="Titre"> EDITER MON PROFIL </h2>
            <table align="center">
            <tr>
     	    <td> 
     		  <label for="Pseudo"> Entrer votre pseudo : </label>
     	    </td> 
     	    <td>
     		  <input class="case" type="texte" name="Pseudo" placeholder="<?php if(isset($_SESSION['Idsession'])){ echo $_SESSION['Pseudo'] ; }?>" value="<?php if(isset($Pseudo)){ echo $Pseudo ; }?>" title="Choississez votre Pseudo" >
     	    </td>
     	</tr>
        <tr>
     	    <td> 
     		  <label for="Mail"> Entrer votre email : </label>
     	    </td> 
     	    <td>
     		  <input class="case" type="mail" name="Mail" placeholder="<?php if(isset($_SESSION['Idsession'])){ echo $_SESSION['Mail'] ; }?>" pattern ="[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([_\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})" title="Veuillez saisir une adresse e-mail valide." >
     	    </td>
     	</tr>
        <tr>
     	    <td> 
     		  <label for="MDP1"> Entrer un mot de passe : </label>
     	    </td> 
     	    <td>
     		  <input class="case" type="password" name="MDP1" placeholder="Votre mot de Passe" id="myInput" title="7 caractères minimum, contenant au moins une MAJ, un minuscule et un chiffre." required> 
        </td>
        <td>
            <input  style="width:20px; height:20px;" checked class="bouton" type="checkbox" onclick="myFunction()">
        </td>
     	    
     	</tr>
        <br /> <br />
        <tr align = "center">
     	    <td>
            <input  type="submit" value="Enregistrer" name="Enregistrer"/>
     	    </td>
     	</tr>
        <br /> <br />
     </table>
            </form>
         
         </div>
      </div>
   </body>
</html>
