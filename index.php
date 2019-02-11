<html>
<?php session_start();?>
<?php include("head.php");?>
<body>
<div align="left">
<?php
// se verifica daca utilizatorul este autentificat
if (isset($_SESSION['Username']))
  {
    echo "<a href='logout.php' target='_self'>Logout</a>";
      echo "&nbsp; | &nbsp;";
    echo "<a href='resetpassword.php' target='_self'>Reset Password</a>";
  }
// daca utilizatorul nu este autentificat
else
  {
    echo "<a href='login.php' target='_self'>Login</a>";
    echo "&nbsp; | &nbsp;";
    echo "<a href='signup.php' target='_self'>Inregistrare utilizator nou</a>";
    echo "<p align='left'>Trebuie sa va autentificati sa vedeti datele utilizatorilor</p>";
  }
?>
</div>
<h2>Utilizatori inregistrati</h2>
<?php
// daca utilizatorul este autentificat se va afisa o lista cu utilizatorii in ordinea aleasa la login cu datele complete
if (isset($_SESSION['Username']))
  {
    require_once ("libs/config.php");
    $orderby = $_SESSION['Orderby'];
    $db=mysqli_connect($host,$usernamesql,$passwordsql,$db_name) or die ("could not connect");
    $query="SELECT * FROM $tbl_utilizatori ORDER BY username $orderby";
    $result=mysqli_query($db,$query);
    while ($r=mysqli_fetch_array($result)) {
        $user4=$r['username'];
        echo "<div class='row'>";
        echo "<div class='column left'><p align='left'>".$user4."</p></div>";
        $nume4=$r['nume'];
        $prenume4=$r['prenume'];
        echo "<div class='column middle'><p align='left'>".$nume4." ".$prenume4."</p></div>";
        $id4=$r['id'];
        echo "<div class='column right'><p align='left'><a href='users.php?id=$id4' target='_self'>Mai multe detalii</a></p></div>";
        echo"</div>";
      }
  }
// daca utilizatorul nu este autentificat se va afisa numai o lista cu username-uri fara a ordona
else
  {
    require_once ("libs/config.php");
    $db=mysqli_connect($host,$usernamesql,$passwordsql,$db_name) or die ("could not connect");
    $query="SELECT * FROM $tbl_utilizatori";
    $result=mysqli_query($db,$query);
    while ($r=mysqli_fetch_array($result)) {
        $user4=$r['username'];
        echo "<p align='left'>".$user4."</p>";
      }
    }
?>
</body>
</html>