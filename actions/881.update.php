<?php // Nugraha, 22/02/2004

$PID = "881";

require_once("../lib/dbconn.php");
require_once("../lib/querybuilder.php");

$qb = New UpdateQuery();
$qb->HttpAction = "POST";
$qb->TableName = "rs99995";
$qb->VarPrefix = "f_";
$qb->addPrimaryKey("id", "'" . $_POST["id"] . "'");
$SQL = $qb->build();
pg_query($con, $SQL);


header("Location: ../index2.php?p=$PID");
exit;

?>
