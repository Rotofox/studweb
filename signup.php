<html>
<?php include("head.php");?>
  <style>.error {color:#FF0000;}</style>
<body>
<?php
// definirea valorilor pentru erori ca fiind goale
$numeerr=$prenumeerr=$emailerr=$passworderr=$sexerr=$usernameerr=$fileerr=$telefonerr=$disciplinaerr="";
// definirea variabilelor pentru valorile din formular
$nume1=$prenume1=$email1=$telefon1=$sex1=$username1=$starecivila1=$fileupload1=$disciplina1="";
//definirea valorii la eroarea principala
$eroare=0;
$id_utilizator = 'id';
$id_student = 'id_student';
//se deschide fisierul de configurare, pentru a citi variabilele DB
require_once ("libs/config.php");
// functie pentru sanitizarea datelor primite din formular - test_input
require_once ("libs/lib.php");
// verifica daca au fost trimise date din formular
if ($_SERVER["REQUEST_METHOD"]=="POST")
  {
// verifica daca campul nume a fost completat cu functia empty
    if (empty($_POST["nume"]))
      {
// in cazul in care nu a fost completat defineste o eroare
        $numeerr="Numele este obligatoriu";
// in cazul in care a fost definit o eroare la verificarea formularului, se modifica si eroarea principala
        $eroare=1;
      }
    else
      {
// se modifica valoarea goala de la variabila $nume cu valoarea primita din formular
        $nume1=test_input($_POST["nume"]);
// daca campul a fost completat, se verifica daca contine numai litere si spatii folosind functia de filtrare preg_match
        if (!preg_match("/^[a-zA-Z ]*$/",$nume1))
          {
            $numeerr="Numai litere si spatii sunt acceptate";
            $eroare=1;
          }
      }
      if (empty($_POST["prenume"]))
        {
          $prenumeerr="Prenumele este obligatoriu";
          $eroare=1;
        }
      else
        {
          $prenume1=test_input($_POST["prenume"]);
          if (!preg_match("/^[a-zA-Z ]*$/",$prenume1))
            {
              $prenumeerr="Numai litere si spatii sunt acceptate";
              $eroare=1;
            }
        }
        if (empty($_POST["email"]))
          {
            $emailerr="Adresa de e-mail este obligatorie";
            $eroare=1;
          }
        else
          {
            $email1=test_input($_POST["email"]);
// pentru a verifica formatul unei adrese de email, se poate folosi functia de filtrare filter_var
            if (!filter_var($email1, FILTER_VALIDATE_EMAIL))
              {
                $emailerr="Format adresa e-mail invalid";
                $eroare=1;
              }
          }
        if (empty($_POST["username"]))
          {
            $usernameerr="Utilizatorul este obligatoriu";
            $eroare=1;
          }
        else
          {
            $username1=test_input($_POST["username"]);
// daca campul a fost completat, se verifica daca contine numai litere, numere si spatii
            if (!preg_match("/^[a-zA-Z0-9 ]*$/",$username1))
              {
                $usernameerr="Numai litere, cifre si spatii sunt acceptate";
                $eroare=1;
              }
          }
          if (empty($_POST["telefon"]))
            {
              $telefonerr="Introduceti numarul de telefon";
              $eroare=1;
            }
          else
            {
              $telefon1=test_input($_POST["telefon"]);
  // daca campul a fost completat, se verifica daca contine numai litere, numere si spatii
              if (!preg_match("/^[0-9 ()+-]+$/",$telefon1))
                {
                  $telefonerr="Numai cifre, + si spatii sunt acceptate";
                  $eroare=1;
                }
            }
          if (empty($_POST["sex"]))
            {
              $sexerr="Sexul este obligatoriu";
              $eroare=1;
            }
          else
            {
              $sex1=test_input($_POST["sex"]);
            }
// formularul trimite valoarea checkboxului numai daca este bifat, altfel nu exista variabila in POST.
          if (isset($_POST["starecivila"]))
            {
              $starecivila1=$_POST["starecivila"];
            }
          if (empty($_POST["parolaa"]))
            {
              $passworderr="Parola este obligatorie";
              $eroare=1;
            }
          else
            {
              if (empty($_POST["parolab"]))
                {
                  $passworderr="Parola este obligatorie";
                  $eroare=1;
                }
                else
                  {
// se verefica daca cele doua parole sunt identice
                    if ($_POST["parolaa"]!=$_POST["parolab"])
                      {
                        $passworderr="Parola nu se potriveste";
                        $eroare=1;
                      }
                  }
            }
// verificare daca a fost uploadat un fisier
          if($_FILES["fileupload"]["size"]==0)
              {
                $fileerr="Poza de profil este obligatorie";
                $eroare=1;
              }
// verifica daca fisierul este o poza
          elseif(getimagesize($_FILES["fileupload"]["tmp_name"])==false)
              {
                $fileerr="Fisierul nu este o imagine";
                $eroare=1;
              }

          if (empty($_POST["disciplina"]))
              {
                $disciplinaerr="Introduceti disciplina dorita";
                $eroare=1;
              }
            else
              {
                $disciplina1=test_input($_POST["disciplina"]);
// daca campul a fost completat, se verifica daca contine numai litere, numere si spatii
                if (!preg_match("/^[a-zA-Z0-9 ]+$/",$disciplina1))
                  {
                    $disciplinaerr="Doar literele, cifrele si spatiile sunt acceptate.";
                    $eroare=1;
                  }
              }

// daca nu a fost nici o eroare la verificarea formularului, se va verifica in baza de date daca user-ul si e-mailul exista deja
      if ($eroare==0)
       {
         require_once ("libs/config.php");
         $db=mysqli_connect($host,$usernamesql,$passwordsql,$db_name) or die ("could not connect");
         $query="SELECT * FROM $tbl_utilizatori WHERE username='$username1'";
         $result=mysqli_query($db,$query);
         $num=mysqli_num_rows($result);
         if($num==1)
         {
           $usernameerr="Utilizator existent. Alegeti alt utilizator";
           $eroare=1;
         }
          $query="SELECT * FROM $tbl_utilizatori WHERE email='$email1'";
          $result=mysqli_query($db,$query);
          $num=mysqli_num_rows($result);
          if($num==1)
          {
            $emailerr="Adresa de e-mail existent. Alegeti alta adresa";
            $eroare=1;
          }
        }
// daca nu a fost nici o eroare la verificarea formularului se va salva poza si se vor introduce datele in baza de date
        if ($eroare==0)
         {
           require_once ("libs/config.php");
// se declara o variabila pentru locatia si denumirea fisierului de salvat (cu numele original al fisierului)
           $target_file = $file_dir . basename($_FILES["fileupload"]["name"]);
// se scoate extensia din denumirea fisierului
           $image_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// se declara o variabila pentru locatia si denumirea fisierului de salvat (cu username-ul introdus si extensia originala)
           $target_file = $file_dir . $username1 .".". $image_type;
// se uploadeaza poza
           move_uploaded_file($_FILES["fileupload"]["tmp_name"], $target_file);
// se conecteaza la baza de date
           $db=mysqli_connect($host,$usernamesql,$passwordsql,$db_name) or die ("could not connect");
// se cauta in tabel id-ul maxim, la care se va adauga 1, pentru a crea id-ul nou
          //  $query="SELECT MAX(id) AS max FROM $tbl_utilizatori";
          //  $result=mysqli_query($db,$query);
          //  $result2=mysqli_fetch_array($result);
          //  $idnew=$result2['max']+1;
          
// se sanitizeaza parola
           $parola1=test_input($_POST["parolaa"]);
// se cripteaza parola
           $parola1=md5($parola1);
// se setaza valoarea pentru starecivila, care in cazul in care nu este bifat, nu se trimite din formular
           if ($starecivila1="on")
            {
              $starecivila1=1;
            }
            else
            {
              $starecivila1=0;
            }
            $currentDate=date("Y/m/d");
            echo $currentDate;
// inserare in baza de date - utilizator, studenti, discipline
            require_once ("libs/lib.php");
            $idnew = new_id($tbl_utilizatori, $id_utilizator);
            $query="INSERT INTO $tbl_utilizatori (id, username, parola, sex, starecivila, nume, prenume, email, dataregistrare, extensie, telefon) 
                    VALUES ('$idnew', '$username1', '$parola1', '$sex1', '$starecivila1', '$nume1', '$prenume1', '$email1','$currentDate', '$image_type', '$telefon1')";
            $result=mysqli_query($db,$query);
            
            $idnew = new_id($tbl_studenti, $id_student);
            $query="INSERT INTO $tbl_studenti (id_student, nume, prenume)
                    VALUES ('$idnew', '$nume1', '$prenume1')";
            $result=mysqli_query($db,$query);

// se specifica pagina catre care se va redirectiona dupa inserare in baza de date
            header("Location: index.php");
          }
  }
?>
<h2>Inregistrare utilizator nou</h2>
<p><span class="error">* camp obligatoriu</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" target="_self" enctype="multipart/form-data">
  <fieldset>
  <legend>Informatii personale</legend>
    Nume: <br><input type="text" name="nume" value="<?php echo $nume1; ?>" lenght="40">
    <span class="error">* <?php echo $numeerr;?></span><br><br>
    Prenume: <br><input type="text" name="prenume" value="<?php echo $prenume1; ?>" lenght="40">
    <span class="error">* <?php echo $prenumeerr;?></span><br><br>
    E-mail: <br><input type="text" name="email" value="<?php echo $email1; ?>" lenght="40">
    <span class="error">* <?php echo $emailerr;?></span><br><br>
    Telefon: <br><input type="text" name="telefon" value="<?php echo $telefon1; ?>" lenght="40">
    <span class="error">* <?php echo $telefonerr;?></span><br><br>
    Sex:<br><input type="radio" name="sex" <?php if (isset($sex1)&&$sex1=="Feminin") echo "checked";?> value="Feminin">feminin
    <input type="radio" name="sex" <?php if (isset($sex1)&&$sex1=="Masculin") echo "checked";?> value="Masculin">masculin
    <span class="error">* <?php echo $sexerr;?></span><br><br>
    Stare civila:<br><input type="checkbox" name="starecivila" <?php if (isset($starecivila1)&&$starecivila1=="on") echo "checked";?>>casatorit
    <br>
    Disciplina: <br><input type="text" name="disciplina" value="<?php echo $disciplina1; ?>" lenght="40">
    <span class="error">* <?php echo $disciplinaerr;?></span><br><br>
  </fieldset>
  <br>
  <fieldset>
  <legend>Upload poza profil</legend>
    <input name="fileupload" type="file">
    <span class="error">* <?php echo $fileerr;?></span><br><br>
    <br>
  </fieldset>
  <br>
  <fieldset>
  <legend>Informatii login</legend>
    Utilizator: <br><input type="text" name="username" value="<?php echo $username1; ?>" lenght="40">
    <span class="error">* <?php echo $usernameerr;?></span><br><br>
    Parola: <br><input type="password" name="parolaa" lenght="40">
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
