<?php
session_start();
$ROWS_PER_PAGE     = 14;

$PID = "888";
$SC = "../index2.php";

require_once("../lib/dbconn.php");
require_once("../lib/form.php");
require_once("../lib/class.PgTable.php");
require_once("../lib/functions.php");
require_once("../lib/class.PgTrans.php");
require_once("../lib/setting.php");
?>

<HTML>
<HEAD>
</HEAD>
<body>

<?
$reg = $_GET["rg"];?>
<script language="javascript">
	function cetakdepositrj(){
		sWin=window.open('cetak.sementara2.php?rg=<? echo $reg?>&kas=rj', 'xWin','top=0,left=0,width=850,height=550,menubar=no,scrollbars=yes');
		sWin.focus();
	}
</script>

<br>
<br>

<input type='button' value='Cetak Deposit  Rawat Jalan' onclick="cetakdepositrj()" style="border-style:none;"/>

</body>
</html>

<?php
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<DIV><A HREF='$SC?p=$PID&kas=rj'><img src='../images/icon-back.png'/></a></DIV>";
echo "<br>";
echo "<br>";
?>
