<?php // Nugraha, 18/02/2004
	  // Pur, 27/02/2004

$PID = "806";

require_once("../lib/dbconn.php");
require_once("../lib/querybuilder.php");

$qb = New InsertQuery();
$qb->TableName = "rs00014";
$qb->HttpAction = "POST";
$qb->VarPrefix = "f_";
$qb->addFieldValue("id", "nextval('rs00014_seq')");
$SQL = $qb->build();

pg_query($con, $SQL);

header("Location: ../index2.php?p=$PID");
exit;

?>
