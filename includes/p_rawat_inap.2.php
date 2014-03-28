<?php // Nugraha, Sat May  8 23:31:59 WIT 2004
	  // sfdn, 31-05-2004
	  // sfdn, 06-06-2004
          // tokit, 7/16/2004 12:15:24 AM

if ($_GET["rg"] == '') $_GET[rg] = null;

// cek pasien udah ada di bangsal belum ?
if (isset($_GET["rg"])) {
$q = pg_query("select * from rs00010 where ts_calc_stop is null and to_number(no_reg,'999999999999') = '".$_GET['rg']."'");
$qn = pg_num_rows($q);
if ($qn > 0) {

echo "<script language=javascript>\n";
echo "alert('Error: Pasien dengan No. Registrasi ".$_GET['rg']." Belum Keluar dari Bangsal Rawat Inap.');\n";
echo "</script>";
$_GET[rg] = null;

}
}

// cek pasien = IGD / RAWAT JALAN
/*
	if (isset($_GET["rg"])) {
		$q = pg_query("select * from rs00006 where to_number(id,'999999999999') = '".$_GET['rg']."' and poli = 10");
		$qn = pg_num_rows($q);
		if ($qn < 1) {
		
			echo "<script language=javascript>\n";
			echo "alert('ERROR: Pasien dengan No. Registrasi ".$_GET['rg']." Bukan Pasien dari IGD.');\n";
			echo "</script>";
			$_GET[rg] = null;	
		}

	}
*/
if (isset($_GET["rg"])) {
    $r = pg_query($con, "select b.id as no_reg, a.nama,  ".
                        "case when b.rawat_inap ='Y' then 'Rawat Jalan' when b.rawat_inap = 'N' then 'IGD' else 'Rawat Inap' end as loket, ".
                        "   b.rujukan as asal ".
                        "from rs00002 a ".
                        "   left join rs00006 b ON a.mr_no = b.mr_no ".
                        "where to_number(b.id,'9999999999') = '".$_GET["rg"]."'");
    $d = pg_fetch_object($r);
    pg_free_result($r);
}

if (strlen($d->no_reg) > 0 && strlen($_SESSION["SELECT_BANGSAL"]) > 0) {
    $f = new Form("actions/p_rawat_inap.insert.php", "POST");
    $f->hidden("rg",$d->no_reg);
    $f->hidden("asal",$d->asal);
    $f->hidden("loket",$d->rawat_inap);


} else {
    $f = new Form("$SC", "GET");
    $f->hidden("p",$PID);
    $f->hidden("sub",$sub);
}

if (isset($_SESSION["SELECT_BANGSAL"])) {
    $_SESSION["BANGSAL"]["id"] = $_SESSION["SELECT_BANGSAL"];
    $_SESSION["BANGSAL"]["desc"] =
        getFromTable(
            "select c.bangsal || ' / ' || b.bangsal || ' / ' || a.bangsal ".
            "from rs00012 as a ".
            "    join rs00012 as b on b.hierarchy = substr(a.hierarchy,1,6) || '000000000' ".
            "    join rs00012 as c on c.hierarchy = substr(a.hierarchy,1,3) || '000000000000' ".
            "where a.id = '".$_SESSION["BANGSAL"]["id"]."'"
        );
    unset($_SESSION["SELECT_BANGSAL"]);
}

if (strlen($d->no_reg) > 0) {
    $f->PgConn = $con;
    $f->text("rg","Nomor Registrasi",10,10,$d->no_reg,"DISABLED");
    $f->text("nm","Nama Pasien",70,70,$d->nama,"DISABLED");

    $f->selectSQL("asal", "Jenis Kedatangan Pasien",
            "select '' as tc, '' as tdesc union ".
            "select 'Y' as tc, 'Rujukan' as tdesc union ".
			"select 'N' as tc, 'Non-Rujukan' as tdesc union ".
			"select 'U' as tc, 'Unit Lain' as tdesc ", $d->asal);
/*
    $f->selectSQL("loket", "Loket Pendaftaran",
            "select '' as tc, '' as tdesc union ".
			"select 'Y' as tc, 'RAWAT JALAN' as tdesc union ".
			"select 'N' as tc, 'IGD' as tdesc  ", $d->rawat_inap);
*/
    $f->text("loket","Loket Pendaftaran",30,30,$d->loket,"DISABLED");

    $f->textAndButton("nm","Bangsal",70,70,$_SESSION["BANGSAL"]["desc"],"DISABLED","...",
        "OnClick='selectBangsal();';");
    if (strlen($_SESSION["BANGSAL"]["desc"]) > 0) {
        $f->selectDate("tanggal", "Terhitung Mulai", getdate(), "");
        $f->text("jam","Jam (format = 24)",5,5,date("H:i"),"");
    }
} else {
    //$f->text("rg","Nomor Registrasi",10,10,"","");
}

//if (strlen($d->no_reg) == 0 || (strlen($d->no_reg) > 0 && strlen($_SESSION["BANGSAL"]["desc"]) > 0)) {
if ((strlen($d->no_reg) > 0 && strlen($_SESSION["BANGSAL"]["desc"]) > 0)) {
    $f->submit("Daftar");
}

$f->execute();

// list pasien
echo "<br>";
if (!isset($_GET[rg])) {


	echo "<div align=right>";
	echo "<form action='$SC' method='get'>";
	echo "<input type=hidden name=p value=$PID>";
	echo "<input type=hidden name=sub value=2>";
	
	echo "<font class=SUB_MENU >NO MR / NO REG / NAMA : </font><input type=text name=search>&nbsp;";
	echo "<input type=submit value=' CARI '>";
	echo "</form>";
	echo "</div>";

	$SQLSTR =
        "select a.mr_no, a.id, TO_CHAR(a.tanggal_reg,'dd Month yyyy') as tanggal_reg , d.nama, ".
		"	(select x.layanan from rs00034 x where x.id = a.poli) ".
		"		as layanan, ".
        "   case when a.rawat_inap='Y' then 'RAWAT JALAN' ".
		"		 when a.rawat_inap='I' then 'RAWAT INAP ' else 'IGD' end as rawatan, ".
        "   b.tdesc as pasien, ".
		"	case when a.rujukan='N' then 'Non-Rujukan' ".
		"		 when a.rujukan='U' then 'Unit Lain' else 'Rujukan' end as datang  ".
        "from rs00006 a  ".
        "   left join rs00001 b ON a.tipe = b.tc and b.tt='JEP' ".
        "   left join rs00002 d ON a.mr_no = d.mr_no ";

        $tglhariini = date("Y-m-d", time());
	
	$SQLWHERE =
   	          "where  ((upper(d.nama) LIKE '%".strtoupper($_GET["search"])."%' ) ".
		  "or a.mr_no like '%".$_GET[search]."%' or a.id like '%".$_GET[search]."%') ".
                 //"and a.rawat_inap != 'Y' ";
		 "and a.rawat_inap != 'I' and a.is_bayar = 'N'";
	
	if (!$_GET[search]) {		  
	     $SQLWHERE .= " and tanggal_reg = '$tglhariini'  ";
	}
 

	if (!isset($_GET[sort])) {

           $_GET[sort] = "id";
           $_GET[order] = "desc";
	}
//echo $SQLSTR.$SQLWHERE ;

    $t = new PgTable($con, "100%");
    $t->SQL = "$SQLSTR $SQLWHERE ";
    $t->setlocale("id_ID");
    $t->ShowRowNumber = true;
    $t->ColAlign = array("CENTER","CENTER","CENTER","LEFT","LEFT","CENTER","CENTER","CENTER","CENTER","CENTER");
    $t->RowsPerPage = $ROWS_PER_PAGE;
    $t->ColFormatHtml[0] = "<b><#0#></b>";
    $t->ColFormatHtml[1] = "<a class=SUB_MENU1 href='$SC?p=$PID&sub=2&rg=<#1#>'><#1#></a>";
    
    $t->ColFormatMoney[2] = "%!+#2n";
    $t->ColHeader = array("NO.RM", "NO.REG","TANGGAL  REGISTRASI","NAMA PASIEN","POLI","LOKET","TIPE PASIEN","KEDATANGAN");
    $t->execute();
}
// end of list pasien

echo "\n<script language='JavaScript'>\n";
echo "function selectBangsal() {\n";
echo "    sWin = window.open('popup/bangsal.php', 'xWin', 'width=600,height=400,menubar=no,scrollbars=yes');\n";
echo "    sWin.focus();\n";
echo "}\n";
echo "</script>\n";




?>
