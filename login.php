<html>
<?php include("head.php");?>
<body>
<h2>Login</h2>
<form method="post" action="user.php" target="_self">
  <fieldset>
  <legend>Login</legend>
    Utilizator: <br><input type="text" name="username" lenght="40">
    <br><br>
    Parola: <br><input type="password" name="parola" lenght="40">
    <br><br>
    Ordoneaza utilizatorii:<br><input type="radio" name="order" value="ASC" checked> ascendent
    <input type="radio" name="order" value="DESC"> descendent
    <br><br>
    <input type="submit" name="submit" value="Login">
    <br>
  </fieldset>
</form>
<br><br>
<a href='index.php' target='_self'>Prima pagina</a>
&nbsp; | &nbsp;
<a href='signup.php' target='_self'>Inregistrare utilizator nou</a>
</body>
</html>