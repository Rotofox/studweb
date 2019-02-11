<html>
<?php session_start();?>
<?php include("head.php");?>
<body>
<?php
$id4 = (isset($_GET['id']))? $_GET['id'] : '';
if (isset($_SESSION['Username']))
{
  echo "<a href='index.php' target='_self'>Inapoi la lista utilizatori</a>";
  echo "&nbsp; | &nbsp;";
  echo "<a href='logout.php' target='_self'>Logout</a>";
  echo "&nbsp; | &nbsp;";
  echo "<a href='email.php?id=$id4' target='_self'>Email(TODO)</a>";

  require_once ("libs/config.php");
  $db=mysqli_connect($host,$usernamesql,$passwordsql,$db_name) or die ("could not connect");
  $query="SELECT * FROM $tbl_utilizatori WHERE id=$id4";
  $result=mysqli_query($db,$query);
  while ($r=mysqli_fetch_array($result)) {
      $user4=$r['username'];
      echo "<h2>Utilizator: ".$user4."</h2>";
      $nume4=$r['nume'];
      $prenume4=$r['prenume'];
      echo "<p align='left'>Nume: ".$nume4." ".$prenume4."</p>";
      $email4=$r['email'];
      echo "<p align='left'>E-mail: ".$email4."</p>";
      $sex4=$r['sex'];
      echo "<p align='left'>Sex: ".$sex4."</p>";
      $starecivila4=$r['starecivila'];
      if ($starecivila4==0) $starecivila4="Necasatorit"; else $starecivila4="Casatorit";
      echo "<p align='left'>Stare civila: ".$starecivila4."</p>";
      $sex4=$r['sex'];
      $fileextension4=$r['extensie'];
      $foto4=$file_dir.$user4.".".$fileextension4;
      echo "<p align='left'><img src='". $foto4 ."' width='150'></p>";
      $RegisterDate4=$r['dataregistrare'];  
      echo "<p align='left'>Data integistrarii: ".$RegisterDate4."</p>";
      $Telefon4=$r['telefon'];
      echo "<p align='left'>Telefon: ".$Telefon4."</p>";
  }
}
//daca nu este autentificat, il trimite inapoi la index
else
{
  echo "<meta http-equiv='refresh' content='0; URL=index.php'>";
}
?>


</body>
</html>
