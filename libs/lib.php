<?php

function test_input($data)
  {
    $data=trim($data);
    $data=stripslashes($data);
    $data=htmlspecialchars($data);
    return $data;
  }

function new_id($table, $id_column_name)
  {
    require ("config.php");
    $db=mysqli_connect($host,$usernamesql,$passwordsql,$db_name)
               or die ("could not connect");

    $query="SELECT MAX($id_column_name) 
                AS max FROM $table";

    $result=mysqli_query($db,$query);
    $result2=mysqli_fetch_array($result);
    $idnew=$result2['max']+1;
    var_dump($result2);
    return $idnew;
  }
?>