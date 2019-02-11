<html>
<?php include("head.php");?>
<?php session_start();?>
<body>
<h2>ResetPassword</h2>
<?php
$passworderr="";
$eroare=0;
if ($_SERVER["REQUEST_METHOD"]=="POST")
  {if (isset($_SESSION['Username']))
  { $mypassword=$_SESSION['Password'];
    echo $mypassword;
if ($_SESSION['Password'] !=md5($_POST["parolaexistenta"]))
    {  $passworderr="Parola curenta nu este corecta";
     $eroare=1;}
     if (md5($_POST["parolaa"])==$_SESSION['Password'])
    {
      $passworderr="Parola este similara cu cea veche";
      $eroare=1;
    }
     if (empty($_POST["parolab"]))
    {
      $passworderr="Parola este obligatorie";
      $eroare=1;
    }
   if ($_POST["parolaa"]!=$_POST["parolab"])
          {
            $passworderr="Parola nu se potriveste";
            $eroare=1;
          }
      if ($eroare==0)
       {
         require_once ("libs/config.php");
         $db=mysqli_connect($host,$usernamesql,$passwordsql,$db_name) or die ("could not connect");

         $parola1=$_POST["parolab"];
    // se cripteaza parola
         $parola1=md5($parola1);
          $userIDCurrent=$_SESSION['UserID'];
    // se setaza valoarea pentru starecivila, care in cazul in care nu este bifat, nu se trimite din formular

    $query="UPDATE $tbl_utilizatori SET parola='$parola1' WHERE id=$userIDCurrent";
          // $query="INSERT INTO $tbl_utilizatori (id, username, parola, sex, starecivila, nume, prenume, email,RegisterDate,fileextension) VALUES ('$idnew', '$username1', '$parola1', '$sex1', '$starecivila1', '$nume1', '$prenume1', '$email1','$currentDate','$image_type')";
          $result=mysqli_query($db,$query);
          $_SESSION['Password']=$parola1;

    // se specifica pagina catre care se va redirectiona dupa inserare in baza de date
          header("Location: index.php");
        }

    } else {
      echo "<meta http-equiv='refresh' content='0; URL=index.php'>";
    }
  } ?>
  <p><span class="error">* camp obligatoriu</span></p>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" target="_self" enctype="multipart/form-data">
    Parola curenta: <br><input type="password" name="parolaexistenta"  lenght="40">
    <span class="error">* <?php echo $passworderr;?></span><br><br>
    Parola: <?php echo $passworderr;?> <br><input type="password" name="parolaa" lenght="40">
    <br><br>
    Verificare parola: <br><input type="password" name="parolab" lenght="40">
    <span class="error">* <?php echo $passworderr;?></span><br>
  </fieldset>
  <br>
    <input type="submit" name="submit" value="Trimite">
  </form>
  <br><br>
  <a href='index.php' target='_self'>Prima pagina</a>
  &nbsp; | &nbsp;
  <a href='login.php' target='_self'>Login</a>
</body></html>
