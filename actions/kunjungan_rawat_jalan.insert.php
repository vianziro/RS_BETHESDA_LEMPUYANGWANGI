<?php

$PID = "input_kunjungan_rawat_jalan";

require_once("../lib/dbconn.php");
require_once("../lib/querybuilder.php");

$qb = New InsertQuery();
$qb->TableName = "rl100003";
$qb->HttpAction = "POST";
$qb->VarPrefix = "f_";

/*$qb->VarTypeIsDate = Array("tgl_lahir");*/

$qb->addFieldValue("no", "nextval('rl100003_seq')");
$SQL = $qb->build();

pg_query($con, $SQL);
header("Location: ../index2.php?p=$PID");

exit;

?>
