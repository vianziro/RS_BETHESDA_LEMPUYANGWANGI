<?php // Nugraha, 18/02/2004
	  // Pur, 27/02/2004


$PID = "order_menu";

require_once("../lib/dbconn.php");
$no_reg=$_GET['id'];
pg_query("DELETE FROM menu_pasien  WHERE id='".$no_reg."'");

header("Location: ../index2.php?p=$PID");
exit;


?>
