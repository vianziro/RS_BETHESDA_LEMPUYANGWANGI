<?php
// Agung Sunandar 4:31 02/07/2012 Untuk Internal Transfer

session_start();


// tokit: biar ngga usah pilih2 kategeori terus :D
if (!empty($_SESSION[mOBT])) {
    $_GET[mOBT] = $_SESSION[mOBT];
    unset($_SESSION[mOBT]);
}

unset($_SESSION["SELECT_OBAT"]);
/*
  if (isset($_GET["e"])) {
  if ($_GET["n"] == 0){
  $_SESSION["SELECT_OBAT"] = $_GET["e"];
  ?>
  <SCRIPT language="JavaScript">
  window.opener.location = window.opener.location;
  window.close();
  </SCRIPT>
  <?php
  exit;
  }else{
  ?>
  <SCRIPT language="JavaScript"> alert ("OBAT HABIS ") </SCRIPT>
  <?
  }

  }
 */


if (isset($_GET["e"])) {
    $_SESSION["SELECT_OBAT"] = $_GET["e"];
    $_SESSION[mOBT] = $_GET[mOBT];
    ?>
    <SCRIPT language="JavaScript">
        window.opener.location = window.opener.location;
        window.close();
    </SCRIPT>
    <?php
    exit;
}
?>
<HTML>
    <HEAD>
        <TITLE>Pilih Obat</TITLE>
        <LINK rel='StyleSheet' type='text/css' href='../default.css'>
    </HEAD>
    <BODY>
        <TABLE border="0" bgcolor="#FFFFFF" width="100%" cellpadding="8"><TR><TD>
                    <?php
                    require_once("../lib/dbconn.php");
                    require_once("../lib/form.php");
                    require_once("../lib/class.PgTable.php");
                    require_once("../lib/functions.php");

                    $cek_depo = getFromTable("select tdesc from rs00001 where tt='GDP' and tc='" . $_GET["gudang"] . "' ");


                    title("Pilih Kategori Barang $cek_depo");
                    echo "<br>";

// tambahan 1
                    $ext = "OnChange = 'Form1.submit();'";
// akhir tambahan 1 sfdn



                    $f = new Form("obat001.php", "GET", "NAME=Form1");
                    $f->hidden("asal", $_GET["asal"]);
                    $f->hidden("tujuan", $_GET["tujuan"]);
                    $f->PgConn = $con;
// tambahan 2
                    $f->selectSQL("mOBT", "Kategori ", "select '' as tc, '' as tdesc union " .
                            "select tc, tdesc " .
                            "from rs00001 " .
                            "where tt = 'GOB' and tc != '000' " .
                            "order by tc", $_GET[mOBT], $ext);
                    $f->execute();
// akhir tambahan 2 sfdn
// search box
                    echo "<DIV ALIGN=RIGHT><TABLE BORDER=0><FORM ACTION='obat001.php'><TR>";
// tambahan 3
                    echo "<TD><INPUT TYPE=HIDDEN NAME=mOBT VALUE='" . $_GET["mOBT"] . "'></TD>";
                    echo "<TD><INPUT TYPE=HIDDEN NAME=asal VALUE='" . $_GET["asal"] . "'></TD>";
                    echo "<TD><INPUT TYPE=HIDDEN NAME=tujuan VALUE='" . $_GET["tujuan"] . "'></TD>";
// akhir tambahan 3 sfdn

                    echo "<TD class=SUB_MENU >NAMA BARANG: <INPUT TYPE=TEXT NAME=search VALUE='" . $_GET["search"] . "'></TD>";
                    echo "<TD><INPUT TYPE=SUBMIT VALUE=' CARI '></TD>";
                    echo "</TR></FORM></TABLE></DIV>";



                    $t = new PgTable($con, "100%");
                    $t->SQL = "select a.id, a.obat, (x.qty_" . $_GET["asal"] . ")||' - '||a.satuan as asal, (x.qty_" . $_GET["tujuan"] . ")||' - '||a.satuan_apo as tujuan " .
                            "from rsv0004 a, rs00016 b, rs00016a x " .
                            "where a.id = b.obat_id and " .
                            "a.id = x.obat_id and " .
                            "a.kategori_id ='" . $_GET["mOBT"] . "' AND " .
                            "upper(obat) LIKE '%" . strtoupper($_GET["search"]) . "%'
			group by a.satuan_apo,a.id, a.obat, a.satuan, x.qty_" . $_GET["asal"] . ", x.qty_" . $_GET["tujuan"] . " 
			";
                    $t->setlocale("id_ID");
//$t->ShowRowNumber = true;
                    $t->RowsPerPage = 20;
//$t->DisableStatusBar = true;

                    $t->ColFormatHtml[0] =
                            "<A HREF='obat001.php?e=<#0#>&nomor_bukti=" . $_GET["nomor_bukti"] . "&mOBT=" . $_GET[mOBT] . "'><IMG BORDER=0 SRC='../images/icon-ok.png'></A>";
                    $t->ColHeader = Array("&nbsp;", "KETERANGAN", "QTY ASAL", "QTY TUJUAN");
                    $t->ColAlign = Array("CENTER", "LEFT", "LEFT", "LEFT");
                    $t->execute();
                    ?>
                </TD></TR></TABLE>
    </BODY>
</HTML>
