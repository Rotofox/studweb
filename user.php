<?php
session_start();
include("head.php");
// verificare user si parola
if (isset($_POST['submit']))
  {
    require_once ("libs/config.php");
    $db=mysqli_connect($host,$usernamesql,$passwordsql,$db_name) or die ("could not connect");
    $myusername=$_POST['username'];
    $mypassword=$_POST['parola'];
    $orderby=$_POST['order'];
    $myusername = stripslashes($myusername);
    $mypassword = stripslashes($mypassword);
    $myusername = mysqli_real_escape_string($db,$myusername);
    $mypassword = mysqli_real_escape_string($db,$mypassword);
    $mypassword = md5($mypassword);
    $query="SELECT * FROM $tbl_utilizatori WHERE username='$myusername' and parola='$mypassword'";
    $result=mysqli_query($db,$query);
    while($r=mysqli_fetch_array($result))
    {
        $UserID=$r["id"];
        $Username=$r["username"];
        $UserNume=$r["nume"];
        $UserPrenume=$r["prenume"];
        $UserEmail=$r["email"];
        $UserStarecivila=$r["starecivila"];
        $UserSex=$r["sex"];
        $UserPassword=$r["parola"];

    }
    $count=mysqli_num_rows($result);
    // daca ok, inregistrare user
    if($count==1)
    {
        $_SESSION['Username'] = $Username;
        $_SESSION['UserID'] = $UserID;
        $_SESSION['UserNume'] = $UserNume;
        $_SESSION['UserPrenume'] = $UserPrenume;
        $_SESSION['UserEmail'] = $UserEmail;
        $_SESSION['UserStarecivila'] = $UserStarecivila;
        $_SESSION['UserSex'] = $UserSex;
        $_SESSION['Orderby'] = $orderby;
        $_SESSION['Password'] = $UserPassword;
        date_default_timezone_set('EET');
        $currentLogin=date("Y-m-d H:i:s", time());
        require_once ("libs/config.php");
        $db=mysqli_connect($host,$usernamesql,$passwordsql,$db_name) or die ("could not connect");
        $query1="UPDATE $tbl_utilizatori SET datalogin='$currentLogin' WHERE id=$UserID";
        $result=mysqli_query($db,$query1);
        echo "<meta http-equiv='refresh' content='0;URL=index.php'>";
    }
// daca user sau parola incorecta
    else 
    {
        echo "Utilizator sau parola incorecta. <br><br>
        <a href='index.php' target='_self'>Prima pagina</a>
        &nbsp;   |   &nbsp;
        <a href='login.php' target='_self'>Inapoi la Login</a>
        &nbsp;   |   &nbsp;
        <a href='signup.php' target='_self'>Inregistrare utilizator nou</a>";
    }
}
?>
