<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Problema examen</title>
<link type="text/css" rel="stylesheet" href="style.css" />
</head>
<?php 
//se asigura pagina, sa nu se poate sparge folosind metoda GET
$urlurl=$_SERVER['QUERY_STRING'];
$urlurlurl=strlen($urlurl);
if ($urlurlurl >= '20') 	echo "<meta http-equiv='refresh' content='0; URL=index.php'>";
?>