<?php 	// Nugraha, Sun Apr 18 18:58:42 WIT 2004
      	// sfdn, 22-04-2004: hanya merubah beberapa title
      	// sfdn, 23-04-2004: tambah harga obat
      	// sfdn, 30-04-2004
      	// sfdn, 09-05-2004
      	// sfdn, 18-05-2004: age
      	// sfdn, 02-06-2004
      	// Nugraha, Sun Jun  6 18:14:41 WIT 2004 : Paket Transaksi
      	// sfdn, 24-12-2006 --> layanan hanya diberikan kpd. pasien yang blm. lunas
		// rs00006.is_bayar = 'N'
		// sfdn, 27-12-2006
		// App,02-06-2007 --> Developer

session_start();
$PID = "p_resume_dewasa_anak";
$SC = $_SERVER["SCRIPT_NAME"];

require_once("startup.php");
require_once("lib/visit_setting.php");
$tglhariini = date("d-m-Y", time());
//--fungsi column color-------------- 
function color( $dstr, $r ) {
	    //if ($dstr[7] == '-') {
	    	if ($dstr[10] == 'Sudah Diperiksa' ){
	    		return "<font color=#FF33FF>{$dstr[$r]}</font>";
	    	}elseif ($dstr[10] == 'Menunggu'){
	    		return "<font color=#66FFCC>{$dstr[$r]}</font>";
	    	}elseif ($dstr[10] == 'Bayar Angsur'){
	    		return "<font color=#FF9900>{$dstr[$r]}</font>";
	    	}elseif ($dstr[10] == 'Bayar Lunas'){
	    		return "<font color=#FF3300>{$dstr[$r]}</font>";
	    	}
	    	return "<font color=#0000FF>{$dstr[$r]}</font>";
	    //}else return $dstr[$i];
}
//-------------------------------       	
$_GET["mPOLI"]=$setting_ri["resume_dewasa_anak"];
$rg = isset($_GET["rg"])? $_GET["rg"] : $_POST["rg"];
$mr = isset($_GET["mr"])? $_GET["mr"] : $_POST["mr"];


		if (isset($_GET["del"])) {
		    $temp = $_SESSION["layanan"];
		    unset($_SESSION["layanan"]);
		    foreach ($temp as $k => $v) {
		        if ($k != $_GET["del"]) $_SESSION["layanan"][count($_SESSION["layanan"])] = $v;
		    }
		    	header("Location: $SC?p=" . $_GET["p"] . "&list=layanan&rg1=" . $_GET["rg1"]."&rg=" . $_GET["rg"]."&ri=".$_GET["ri"]."&mr=" . $_GET["mr"]."&sub=layanan");
		    	exit;
		    
		} elseif (isset($_GET["del-icd"])) {
		    $temp = $_SESSION["icd"];
		    unset($_SESSION["icd"]);
		    foreach ($temp as $k => $v) {
		        if ($k != $_GET["del-icd"]) $_SESSION["icd"][count($_SESSION["icd"])] = $v;
		    }
		    	header("Location: $SC?p=" . $_GET["p"] . "&list=icd&rg1=" . $_GET["rg1"]."&rg=" . $_GET["rg"]."&ri=".$_GET["ri"]."&mr=" . $_GET["mr"] . "&sub=icd");
		    	exit;
		    
		} elseif (isset($_GET["del-obat"])) {
		    $temp = $_SESSION["obat"];
		    unset($_SESSION["obat"]);
		    foreach ($temp as $k => $v) {
		        if ($k != $_GET["del-obat"]) $_SESSION["obat"][count($_SESSION["obat"])] = $v;
		    }
		    	header("Location: $SC?p=" . $_GET["p"] . "&rg1=" . $_GET["rg1"]."&rg=" . $_GET["rg"]."&ri=".$_GET["ri"]."&mr=" . $_GET["mr"] . "&sub=obat");
		    	exit;
		    
		} elseif (isset($_GET["del-pjm"])) {
		    $temp = $_SESSION["pjm"][$_GET["del-pjm"]];
		    unset($_SESSION["pjm"][$_GET["del-pjm"]]);
		    foreach ($temp as $k => $v) {
		        if ($k != $_GET["del-emp"])
		            $_SESSION["pjm"][$_GET["del-pjm"]][count($_SESSION["pjm"][$_GET["del-pjm"]])] = $v;
		    }
		    	header("Location: $SC?p=" . $_GET["p"] . "&rg1=" . $_GET["rg1"]."&rg=" . $_GET["rg"]."&ri=".$_GET["ri"]."&mr=" . $_GET["mr"] . "&sub=pjm");
		    	exit;
		    
		} elseif (isset($_GET["s2note"])) {
		    $_SESSION["s2note"] = $_GET["s2note"];
		    	header("Location: $SC?p=" . $_GET["p"] . "&list=icd&rg1=" . $_GET["rg1"]."&rg=" . $_GET["rg"]."&ri=".$_GET["ri"]."&mr=" . $_GET["mr"] . "&sub=icd");
		    	exit;
		    
		} elseif (isset($_GET["obat"])) {
		    $r = pg_query($con,"SELECT * FROM RSV0004 WHERE ID = '".$_GET["obat"]."'");
		    $d = pg_fetch_object($r);
		    pg_free_result($r);
		
		    if (is_array($_SESSION["obat"])) {
		        $cnt = count($_SESSION["obat"]);
		    } else {
		        $cnt = 0;
		    }
		    
		    if (!empty($d->obat)) {
		        $_SESSION["obat"][$cnt]["id"]     = $_GET["obat"];
		        $_SESSION["obat"][$cnt]["desc"]   = $d->obat;
		        //$_SESSION["obat"][$cnt]["dosis"]  = $_GET["dosis_obat"];
		        $_SESSION["obat"][$cnt]["jumlah"] = $_GET["jumlah_obat"];
		        $_SESSION["obat"][$cnt]["harga"]  = $d->harga;
		        $_SESSION["obat"][$cnt]["total"]  = $d->harga * $_GET["jumlah_obat"];
		        //$_SESSION["obat"][$cnt]["satuan"] = $d->satuan;
		        unset($_SESSION["SELECT_OBAT"]);
		    }
		    	header("Location: $SC?p=" . $_GET["p"] . "&rg1=" . $_GET["rg1"]."&rg=" . $_GET["rg"]."&ri=".$_GET["ri"]."&mr=" . $_GET["mr"] . "&sub=obat");
		    	exit;
    
		} elseif (isset($_GET["icd"])) {
		    $r = pg_query($con,"SELECT * FROM RSV0005 WHERE DIAGNOSIS_CODE = '" . $_GET["icd"] . "'");
		    $d = pg_fetch_object($r);
		    pg_free_result($r);
		    if (is_array($_SESSION["icd"])) {
		        $cnt = count($_SESSION["icd"]);
		    } else {
		        $cnt = 0;
		    }
		    
		    if (strlen($d->description) > 0) {
		        $_SESSION["icd"][$cnt]["id"]   = $_GET["icd"];
		        $_SESSION["icd"][$cnt]["desc"] = $d->description;
		        $_SESSION["icd"][$cnt]["kate"] = $d->category;
		        unset($_SESSION["SELECT_ICD"]);
		    }
		    header("Location: $SC?p=" . $_GET["p"] . "&list=icd&rg1=" . $_GET["rg1"]."&rg=" . $_GET["rg"]."&ri=".$_GET["ri"]."&mr=" . $_GET["mr"] . "&sub=icd");
		    exit;
		    
		} elseif (isset($_GET["layanan"])) {
			
		    $r = pg_query($con,"SELECT * FROM RSV0034 WHERE ID = '" . $_GET["layanan"] . "'");
		    $d = pg_fetch_object($r);
		    pg_free_result($r);

    $gol_tindakan = getFromTable("select golongan_tindakan_id from rs00034 where id='".$_GET["layanan"]."'");
   // $is_range = $d->harga_atas > 0 || $d->harga_bawah > 0;

    if ($d->id) {
    //    if (($is_range && isset($_GET["harga"])) || (!$is_range)) {
            if (is_array($_SESSION["layanan"])) {
                $cnt = count($_SESSION["layanan"]);
            } else {
                $cnt = 0;
            }
           
            $dokter = getFromTable("select nama from rs00017 where id = '".$_SESSION[SELECT_EMP]."'");
            $harga = $is_range ? $_GET["harga"] : $d->harga;
            $_SESSION["layanan"][$cnt]["id"]     = str_pad($_GET["layanan"],5,"0",STR_PAD_LEFT);
            
            if ($d->klasifikasi_tarif) $embel= " - ".$d->klasifikasi_tarif;
            $_SESSION["layanan"][$cnt]["nama"]   = $d->layanan . $embel;
            $_SESSION["layanan"][$cnt]["jumlah"] = $_GET["jumlah"];
            $_SESSION["layanan"][$cnt]["satuan"] = $d->satuan;
            $_SESSION["layanan"][$cnt]["harga"]  = $harga;
            $_SESSION["layanan"][$cnt]["total"]  = $harga * $_GET["jumlah"];
            $_SESSION["layanan"][$cnt]["dokter"]  = $dokter;
            $_SESSION["layanan"][$cnt]["nip"]  = $_SESSION[SELECT_EMP];
            
            
            // tindakan non operatif
            if (substr($d->hierarchy,0,9) == "006001008") {

	               $t = pg_query($con,"SELECT * FROM RS00034 WHERE HIERARCHY LIKE '006001007%' AND GOLONGAN_TINDAKAN_ID = '$gol_tindakan'");
	               $tr = pg_fetch_object($t);
	               
	            do {
	            $cnt++;
	            $harga = $tr->harga;
	            $_SESSION["layanan"][$cnt]["id"]     = str_pad($tr->id,5,"0",STR_PAD_LEFT);
	            if ($tr->klasifikasi_tarif) $embel= " - ".$tr->klasifikasi_tarif;
	            $_SESSION["layanan"][$cnt]["nama"]   = $tr->layanan . $embel;
	            $_SESSION["layanan"][$cnt]["jumlah"] = $_GET["jumlah"];
	            $_SESSION["layanan"][$cnt]["satuan"] = $tr->satuan;
	            $_SESSION["layanan"][$cnt]["harga"]  = $harga;
	            $_SESSION["layanan"][$cnt]["total"]  = $harga * $_GET["jumlah"];
	            
	            } while ($tr = pg_fetch_object($t));
            }


            // tindakan operatif
            if (substr($d->hierarchy,0,9) == "006003002") {

               $t = pg_query($con,"SELECT * FROM RS00034 WHERE HIERARCHY LIKE '006003006%' AND GOLONGAN_TINDAKAN_ID = '$gol_tindakan'");
               $tr = pg_fetch_object($t);
         
	            do {
	            $cnt++;
	            $harga = $tr->harga;
	            $_SESSION["layanan"][$cnt]["id"]     = str_pad($tr->id,5,"0",STR_PAD_LEFT);
	            if ($tr->klasifikasi_tarif) $embel= " - ".$tr->klasifikasi_tarif;
	            $_SESSION["layanan"][$cnt]["nama"]   = $tr->layanan . $embel;
	            $_SESSION["layanan"][$cnt]["jumlah"] = $_GET["jumlah"];
	            $_SESSION["layanan"][$cnt]["satuan"] = $tr->satuan;
	            $_SESSION["layanan"][$cnt]["harga"]  = $harga;
	            $_SESSION["layanan"][$cnt]["total"]  = $harga * $_GET["jumlah"];
	            } while ($tr = pg_fetch_object($t));

            }

            // tindakan rawat jalan
            if (substr($d->hierarchy,0,9) == "006001001") {

               $t = pg_query($con,"SELECT * FROM RS00034 WHERE HIERARCHY LIKE '006001007%' AND GOLONGAN_TINDAKAN_ID = '$gol_tindakan'");
               $tr = pg_fetch_object($t);
               
	            do {
	            $cnt++;
	            $harga = $tr->harga;
	            $_SESSION["layanan"][$cnt]["id"]     = str_pad($tr->id,5,"0",STR_PAD_LEFT);
	            if ($tr->klasifikasi_tarif) $embel= " - ".$tr->klasifikasi_tarif;
	            $_SESSION["layanan"][$cnt]["nama"]   = $tr->layanan . $embel;
	            $_SESSION["layanan"][$cnt]["jumlah"] = $_GET["jumlah"];
	            $_SESSION["layanan"][$cnt]["satuan"] = $tr->satuan;
	            $_SESSION["layanan"][$cnt]["harga"]  = $harga;
	            $_SESSION["layanan"][$cnt]["total"]  = $harga * $_GET["jumlah"];
	            } while ($tr = pg_fetch_object($t));

            }

            unset($_SESSION["SELECT_LAYANAN"]);
            unset($_SESSION["SELECT_EMP"]);

            header("Location: $SC?p=" . $_GET["p"] . "&list=layanan&rg1=" . $_GET["rg1"]."&rg=" . $_GET["rg"]."&ri=".$_GET["ri"]."&mr=" . $_GET["mr"]."&sub=layanan");
            exit;
            
    /*    } elseif ($is_range) {
            $_SESSION["SELECT_LAYANAN"] = $_GET["layanan"];
            header("Location: $SC?p=" . $_GET["p"] . "&list=layanan&rg1=" . $_GET["rg1"]."&rg=" . $_GET["rg"]."&ri=".$_GET["ri"]."&mr=" . $_GET["mr"]. "&jumlah=" . $_GET["jumlah"]);
            exit;
        } */
    } else {
        header("Location: $SC?p=" . $_GET["p"] . "&list=layanan&rg1=" . $_GET["rg1"]."&rg=" . $_GET["rg"]."&ri=".$_GET["ri"]."&mr=" . $_GET["mr"]."&sub=layanan");
        exit;
    }
}


unset($_GET["layanan"]);

$reg = $_GET["rg"];
$reg1 = (int) $_GET["rg1"];
	$tab_disabled = array("pemeriksaan"=>true, "layanan"=>true, "icd"=>true, "riwayat"=>true,"riwayat_klinik"=>true);
	if ($_GET["act"] == "del" ) {
	$tab_disabled = array("pemeriksaan"=>false, "layanan"=>false, "icd"=>false, "riwayat"=>false,"riwayat_klinik"=>false);
	$tab_disabled[$_GET["sub"]] = true;
	$tab_disabled[$_POST["sub"]] = true;
	}
	$T = new TabBar();
	$T->addTab("$SC?p=$PID&list=pemeriksaan&rg1={$_GET["rg1"]}&rg=$rg&ri=".$_GET["mPOLI"]."&mr=$mr ", "Data Resume Pasien"	, $tab_disabled["pemeriksaan"]);
	//$T->addTab("$SC?p=$PID&list=layanan&rg1={$_GET["rg1"]}&rg=$rg&ri=".$_GET["mPOLI"]."&mr=$mr&sub=layanan", "layanan / Tindakan"	, $tab_disabled["layanan"]);
	$T->addTab("$SC?p=$PID&list=icd&rg1={$_GET["rg1"]}&rg=$rg&ri=".$_GET["mPOLI"]."&mr=$mr&sub=icd", "Pilih I C D"	, $tab_disabled["icd"]);
	$T->addTab("$SC?p=$PID&list=riwayat&rg1={$_GET["rg1"]}&rg=$rg&ri=".$_GET["mPOLI"]."&mr=$mr", "Riwayat Resume Pasien"	, $tab_disabled["riwayat"]);
	$T->addTab("$SC?p=$PID&list=riwayat_klinik&rg1={$_GET["rg1"]}&rg=$rg&ri=".$_GET["mPOLI"]."&mr=$mr", "Riwayat Medis"	, $tab_disabled["riwayat_klinik"]);

if ($reg > 0) {
	$r1 = pg_query($con,
	"select tdesc from rs00001 where tt='LRI' and tc='{$_GET["ri"]}'");
	$n1 = pg_num_rows($r1);
	if($n1 > 0) $d1 = pg_fetch_object($r1);
	pg_free_result($r1);
	
	title_print("<img src='icon/rawat-inap-2.gif' align='absmiddle' >  $d1->tdesc");
    	//if($_GET["list"] != "riwayat_klinik"){
		$sql="select a.id,a.mr_no,a.nama,a.umur,a.tgl_lahir,a.tmp_lahir,to_char(b.ts_check_in,'DD MON YYYY')as tanggal_reg,
				a.status_akhir,a.diagnosa_sementara, a.jenis_kelamin,a.pangkat_gol,a.nrp_nip,a.kesatuan,b.bangsal_id,e.bangsal,
				a.poli,a.rawatan,a.nama_ayah,a.agama,to_char(f.ts_check_in,'dd Mon YYYY')as tgl_masuk,to_char(f.ts_calc_stop,'dd Mon yyyy')as tgl_keluar 
				from rsv_pasien2 a 
				join rs00010 as b on a.id = b.no_reg join rs00012 as c on b.bangsal_id = c.id 
				join rs00012 as d on d.hierarchy = substr(c.hierarchy,1,6) || '000000000' 
				join rs00012 as e on e.hierarchy = substr(d.hierarchy,1,3) || '000000000000' 
				join rs00010 as f on f.no_reg = a.id
				where a.id = '$reg1'";
    	
    $r = pg_query($con,$sql);
    $n = pg_num_rows($r);
    if($n > 0) $d = pg_fetch_object($r);
    pg_free_result($r);
    $rawatan = $d->rawatan;
    // ambil bangsal
    $id_max = getFromTable("select max(id) from rs00010 where no_reg = '".$_GET["rg"]."'");
    if (!empty($id_max)) {
    $bangsal = getFromTable("select c.bangsal || ' / ' || e.tdesc ".
                       "from rs00010 as a ".
                       "    join rs00012 as b on a.bangsal_id = b.id ".
                       "    join rs00012 as c on c.hierarchy = substr(b.hierarchy,1,6) || '000000000' ".
                       //"    join rs00012 as d on d.hierarchy = substr(b.hierarchy,1,3) || '000000000000' ".
                       "    join rs00001 as e on c.klasifikasi_tarif_id = e.tc and e.tt = 'KTR' ".
                       "where a.id = '$id_max'");
    }
    $umure = umur($d->umur);
    $umure = explode(" ",$umure);
    $umur = $umure[0]." Tahun";

	//===============update to rs00006 (status pemeriksaan)=============
    if($_GET['act'] == "periksa"){
	//pg_query("update rs00006 set periksa='Y' where id =lpad('".$_GET["rg"]."',10,'0')");
	}
	echo "<hr noshade size='1'>";
		echo "<table border=1 width='100%' cellspacing=0 cellpadding=0><tr><td valign=top>";
		$f = new ReadOnlyForm();
		$f->text("<b>"."Nama",$d->nama);
		$f->text("<b>"."No RM",$d->mr_no);
		$f->text("<b>"."No Reg", formatRegNo($_GET["rg1"]));
		$f->text("<b>"."Keluarga Dari", $d->nama_ayah);
		//$f->text("Kedatangan",$d->datang);
		$f->execute();
		echo "</td><td align=left valign=top>";
		$f = new ReadOnlyForm();
		$f->text("<b>"."NRP/NIP/Pangkat",$d->nrp_nip." / ".$d->pangkat_gol);
		$f->text("<b>"."Kesatuan",$d->kesatuan);
		$f->text("<b>"."Umur", $umur);
		$f->text("<b>"."Seks",$d->jenis_kelamin);
		$f->execute();
		echo "</td><td align=left valign=top>";
		$f = new ReadOnlyForm();
		$f->text("<b>"."Agama",$d->agama);
		$f->text("<b>"."Tanggal Masuk",$d->tgl_masuk);
		$f->text("<b>"."Tanggal Keluar",$d->tgl_keluar);
		$f->text("<b>"."Ruang",$d->bangsal);
		$f->execute();
		echo "</td></tr></table>";
		echo"<hr noshade size='2'>";
        
    echo "</div>";
 	if(!$GLOBALS['print']){
    echo "<DIV ALIGN=RIGHT><A HREF='$SC?p=p_layanan_rawat_inap&rg={$_GET["rg"]}&mr={$_GET["mr"]}&rg1={$_GET["rg1"]}'>".icon("back","Kembali")."</a></DIV>";
    	echo"<br>";
 	}
    //disini

    $total = 0.00;
    if (is_array($_SESSION["layanan"])) {
        foreach($_SESSION["layanan"] as $k => $l) {
            $total += $l["total"];
        }
    }

    //echo "<div class=box>";
if ($_GET["sub"] == "byr") {
        title("Total Tagihan: Rp. ".number_format($total,2));
        echo "<br><br><br>";
        $f = new Form("actions/p_resume_dewasa_anak.insert.php");
        $f->hidden("rg",$_GET["rg"]);
        $f->hidden("mr",$_GET["mr"]);
        $f->hidden("ri",$_GET["ri"]);
        $f->hidden("poli",$d->poli);
	$f->hidden("sub",$_GET["sub"]);
        $f->hidden("byr",$total);
        //$f->text("byr","Jumlah Pembayaran",15,15,$total,"STYLE='text-align:right'");
        $f->submit(" Simpan &amp; Bayar ");
        $f->execute();
    
} elseif ($_GET["list"] == "icd") {  // -------- ICD
	if(!$GLOBALS['print']){	
	$T->show(1);
	}
        echo"<div align=center class=form_subtitle1>KLASIFIKASI PENYAKIT</div>";
        echo "<table width='100%' border=0 cellspacing=0 cellpadding=0><tr>";
        echo "<script language='JavaScript'>\n";
        echo "document.Form3.b2.disabled = true;\n";
        echo "document.Form3.b4.disabled = false;\n";
        echo "</script>\n";
        echo "<form action='$SC'>";
        echo "<INPUT TYPE=HIDDEN NAME=p VALUE='$PID'>";
        echo "<INPUT TYPE=HIDDEN NAME=rg VALUE='".$_GET["rg"]."'>";
        echo "<INPUT TYPE=HIDDEN NAME=rg1 VALUE='".$_GET["rg1"]."'>";
        echo "<INPUT TYPE=HIDDEN NAME=sub VALUE='".$_GET["sub"]."'>";
        echo "<INPUT TYPE=HIDDEN NAME=mr VALUE='".$_GET["mr"]."'>";
        echo "<input type=hidden name=rawatan value='".$rawatan."'>";
        echo "<input type=hidden name=ri value='".$_GET["ri"]."'>";
        echo "<INPUT TYPE=HIDDEN NAME=list VALUE='icd'>";
        echo "<INPUT TYPE=HIDDEN NAME=httpHeader VALUE='1'>";
        echo "</form>";
        echo "<td valign=top>";

        $namaICD = getFromTable("SELECT DESCRIPTION FROM RSV0005 WHERE DIAGNOSIS_CODE = '".$_SESSION["SELECT_ICD"]."'");
        $katICD = getFromTable("SELECT CATEGORY FROM RSV0005 WHERE DIAGNOSIS_CODE = '".$_SESSION["SELECT_ICD"]."'");
        
        $t = new BaseTable("100%");
        $t->printTableOpen();
        echo "<FORM ACTION='$SC' NAME=Form11>";
        echo "<INPUT TYPE=HIDDEN NAME=p VALUE='$PID'>";
        echo "<INPUT TYPE=HIDDEN NAME=rg VALUE='".$_GET["rg"]."'>";
        echo "<INPUT TYPE=HIDDEN NAME=rg1 VALUE='".$_GET["rg1"]."'>";
        echo "<INPUT TYPE=HIDDEN NAME=list VALUE='icd'>";
        echo "<INPUT TYPE=HIDDEN NAME=mr VALUE='".$_GET["mr"]."'>";
        echo "<input type=hidden name=rawatan value='".$rawatan."'>";
        echo "<input type=hidden name=ri value='".$_GET["ri"]."'>";
        echo "<INPUT TYPE=HIDDEN NAME=httpHeader VALUE='1'>";
        $t->printTableHeader(Array("KODE ICD", "KETERANGAN","KATEGORI", "&nbsp;"));
        
        if (is_array($_SESSION["icd"])) {
            foreach($_SESSION["icd"] as $k => $l) {
                $t->printRow(
                    Array($l["id"], $l["desc"],$l["kate"], "<A HREF='$SC?p=$PID&list=icd&rg1=".$_GET["rg1"]."&rg=".$_GET["rg"]."&ri=".$_GET["ri"]."&mr=".$_GET["mr"]."&del-icd=$k&httpHeader=1'>".icon("del-left")."</A>"), Array("CENTER", "LEFT", "LEFT","CENTER")
                );
            }
        }
		// sfdn, 27-12-2006 --> pembetulan directory icon = ../simrs/images/*.png
        $t->printRow(
            Array("<INPUT OnKeyPress='refreshSubmit()' NAME=icd STYLE='text-align:center' TYPE=TEXT SIZE=5 MAXLENGTH=10 VALUE='".$_SESSION["SELECT_ICD"]."'>&nbsp;<A HREF='javascript:selectICD()'><IMG BORDER=0 SRC='images/icon-view.png'></A>", $namaICD,"$katICD", "<INPUT NAME='submitButton' TYPE=SUBMIT VALUE='OK'>"),
            Array("CENTER", "LEFT", "LEFT","CENTER")
        );
		// --- eof 27-12-2006 ---
        echo "</FORM>";
        
        $t->printTableClose();
        //echo "</td></tr></table>";
        echo "\n<script language='JavaScript'>\n";
        echo "function selectICD() {\n";
        echo "sWin = window.open('popup/icd.php', 'xWin', 'top=0,left=0,width=500,height=400,menubar=no,scrollbars=yes');\n";
        echo "sWin.focus();\n";
        echo "}\n";
        echo "</script>\n";
        
        echo "<form name='Form9' action='actions/p_resume_dewasa_anak.insert.php' method=POST>";
        echo "<input type=hidden name=rg value='".$_GET["rg"]."'>";
        echo "<input type=hidden name=rg1 value='".$_GET["rg1"]."'>";
        echo "<INPUT TYPE=HIDDEN NAME=sub VALUE='".$_GET["sub"]."'>";
        echo "<INPUT TYPE=HIDDEN NAME=mr VALUE='".$_GET["mr"]."'>";
        echo "<INPUT TYPE=HIDDEN NAME=list VALUE='icd'>";
        echo "<input type=hidden name=ri value='".$_GET["ri"]."'>";
        echo "<input type=hidden name=rawatan value='".$rawatan."'>";
        echo "<br><div align=right><input type=button value='Simpan' onClick='document.Form9.submit()'>&nbsp;</div>";
        echo "</form>";
     
	 // DIAGNOSA
	$rec1 = getFromTable ("select count(id) from rs00008 ".	// sfdn, 27-12-2006 --> melakukan testing apakah ada data diagnosa
						  "where trans_type = 'ICD' and no_reg ='".$_GET["rg"]."'");
	if ($rec1 > 0) {

		$f = new Form("");
		echo "<br>";
		$f->title1("Data Diagnosa");
		$f->execute();
		
		$t = new PgTable($con, "100%");
		$t->SQL = "select a.item_id,b.description,b.category,a.oid from rs00008 a 
				   left join rsv0005 b on b.diagnosis_code = a.item_id
				   where trans_type='ICD' and a.no_reg ='".$_GET["rg"]."' order by tanggal_entry";		   
		$t->setlocale("id_ID");
		$t->ShowRowNumber = true;
		$t->RowsPerPage = $ROWS_PER_PAGE;
		$t->ColHeader = array("KODE ICD","DESKRIPSI ICD","DIAGNOSA","HAPUS");
		$t->ColAlign = array("center","left","left","center");
		$t->DisableScrollBar = true;
		$t->DisableStatusBar = true;	
		$t->ColFormatHtml[3] = "<A CLASS=TBL_HREF HREF='actions/p_icd_ri.delete.php?p=$PID&sub=icd&list=icd&mr=".$_GET["mr"]."&poli=".$_GET["mPOLI"]."&rg=".$_GET["rg"]."&id=<#3#>'>".icon("delete","Hapus")."</A>";			
		$t->execute();
	}
	
        include("rincian.php");
        
    }elseif ($_GET["list"] == "layanan") { // ----------------------------- LAYANAN MEDIS
    	if(!$GLOBALS['print']){
    	$T->show(1);
    	}
        echo"<div align=center class=form_subtitle1>LAYANAN DAN TINDAKAN MEDIS</div>";
        echo "<script language='JavaScript'>\n";
        echo "document.Form3.b1.disabled = true;\n";
        echo "document.Form3.b2.disabled = false;\n";
        echo "document.Form3.b4.disabled = false;\n";
        echo "</script>\n";

        echo "<FORM ACTION='$SC' NAME=Form8>";
        echo "<INPUT TYPE=HIDDEN NAME=p VALUE='$PID'>";
        echo "<INPUT TYPE=HIDDEN NAME=rg VALUE='".$_GET["rg"]."'>";
        echo "<INPUT TYPE=HIDDEN NAME=rg1 VALUE='".$_GET["rg1"]."'>";
        echo "<INPUT TYPE=HIDDEN NAME=list VALUE='layanan'>";
        echo "<INPUT TYPE=HIDDEN NAME=mr VALUE='".$_GET["mr"]."'>";
        echo "<INPUT TYPE=HIDDEN NAME=ri VALUE='".$_GET["ri"]."'>";
        echo "<input type=hidden name=rawatan value='".$rawatan."'>";
        echo "<INPUT TYPE=HIDDEN NAME=httpHeader VALUE='1'>";
        


        $t = new BaseTable("100%");
        $t->printTableOpen();
        $t->printTableHeader(Array("KODE", "LAYANAN", "DOKTER", "JUMLAH", "SATUAN",
            "HARGA SATUAN", "HARGA TOTAL", ""));
            
        if (is_array($_SESSION["layanan"])) {
            $total = 0.00;
            foreach($_SESSION["layanan"] as $k => $l) {

                $q = pg_query("SELECT B.TDESC AS KELAS_TARIF, SUBSTR(A.HIERARCHY,1,6) AS HIE FROM RS00034 A ".
                        "LEFT JOIN RS00001 B ON A.KLASIFIKASI_TARIF_ID = B.TC AND B.TT = 'KTR' ".
                        "WHERE A.ID = $l[id]");
                $qr = pg_fetch_object($q);

                if ($qr->hie == "003002") {
                   $tambahan = " - ".$qr->kelas_tarif;

                }

                $t->printRow(
                    Array($l["id"], $l["nama"].$tambahan, $l["dokter"], $l["jumlah"], $l["satuan"],
                        number_format($l["harga"],2), number_format($l["total"],2),
                        "<A HREF='$SC?p=$PID&list=layanan&rg1=".$_GET["rg1"]."&rg=".$_GET["rg"]."&ri=".$_GET["ri"]."&mr=".$_GET["mr"]."&del=$k&httpHeader=1'>".icon("del-left")."</A>"),
                    Array("CENTER", "LEFT", "CENTER","RIGHT", "LEFT", "RIGHT", "RIGHT", "CENTER")
                );
                $total += $l["total"];
            }
        }
        
        if (isset($_SESSION["SELECT_LAYANAN"])) {
            $r = pg_query($con,"select * from rsv0034 where id = '" . $_SESSION["SELECT_LAYANAN"] . "'");
            $d = pg_fetch_object($r);
            pg_free_result($r);

        //    $is_range = $d->harga_atas > 0 || $d->harga_bawah > 0;
         //   $harga = $is_range ? $_GET["harga"] : $d->harga;

          //  $hargaHtml = $is_range ?
           //     "<INPUT TYPE=TEXT NAME=harga SIZE=10 MAXLENGTH=12 VALUE='$d->harga'>" : $d->harga;
        }
		// sfdn, 27-12-2006 -> pembetulan directory gambar = ../simrs/images/*.png
        $t->printRow(
            Array("<INPUT OnKeyPress='refreshSubmit()' NAME=layanan STYLE='text-align:center' TYPE=TEXT SIZE=5 MAXLENGTH=10 VALUE='".$_SESSION["SELECT_LAYANAN"].
			"'>&nbsp;<A HREF='javascript:selectLayanan()'><IMG BORDER=0 SRC='images/icon-view.png'></A>",
			$d->layanan . " - " . $d->klasifikasi_tarif, "<INPUT OnKeyPress='refreshSubmit()' NAME=dokter STYLE='text-align:center' TYPE=TEXT SIZE=5 MAXLENGTH=12 VALUE='"
                        .$_SESSION["SELECT_EMP"]."'>&nbsp;<A HREF='javascript:selectPegawai()'><IMG BORDER=0 SRC='images/icon-view.png'></a>", "<INPUT VALUE='".(isset($_GET["jumlah"]) ? $_GET["jumlah"] : "1").
			"'NAME=jumlah OnKeyPress='refreshSubmit()' TYPE=TEXT SIZE=5 MAXLENGTH=10 VALUE='1' STYLE='text-align:right'>", $d->satuan, $d->harga,
			"", "<INPUT NAME='submitButton' TYPE=SUBMIT VALUE='OK' >"),
            Array("CENTER", "LEFT", "CENTER","CENTER", "LEFT", "RIGHT", "LEFT", "CENTER")
        );
		// --- eof 27-12-2006 ---
        $t->printRow(
            Array("", "", "", "", "", "", number_format($total,2),""),
            Array("RIGHT", "RIGHT", "RIGHT", "RIGHT", "RIGHT", "RIGHT", "RIGHT")
        );
        $t->printTableClose();
        echo "</FORM>";
        
     /*   if (isset($_SESSION["SELECT_LAYANAN"]) && $is_range) {
            echo "<br>";
            info("Informasi Harga:",
                "$d->unit_layanan, $d->sub_unit_layanan, $d->layanan<BR>".
                "Harga: <big>Rp. $d->harga_bawah</big> sampai dengan <big>Rp. $d->harga_atas</big>");
        } */
        echo "<form name='Form10' action='actions/p_resume_dewasa_anak.insert.php' method=POST>";
        echo "<input type=hidden name=rg value='".$_GET["rg"]."'>";
        echo "<input type=hidden name=rg1 value='".$_GET["rg1"]."'>";
        echo "<INPUT TYPE=HIDDEN NAME=sub VALUE='".$_GET["sub"]."'>";
        echo "<INPUT TYPE=HIDDEN NAME=mr VALUE='".$_GET["mr"]."'>";
        echo "<input type=hidden name=rawatan value='".$rawatan."'>";
        echo "<input type=hidden name=ri value='".$_GET["ri"]."'>";
        echo "<input type=hidden name=list value='layanan'>";
        echo "<br><div align=right><input type=button value='Simpan' onClick='document.Form10.submit()'>&nbsp;";
        echo "</form>";
       
       include("rincian.php"); 
       
    } elseif($_GET["list"] == "riwayat") {
    	if(!$GLOBALS['print']){
    	$T->show(2);
    	}
    	if ($_GET["act"] == "detail") {
				$sql = 	"select a.*,to_char(a.tanggal_reg,'DD MON YYYY HH24:MI:SS')as tanggal_reg,f.layanan,(g.nama)as merawat,(h.nama)as mengirim ".
						"from c_visit_ri a ". 
						"left join rsv0002 c on a.no_reg=c.id ".
						"left join rs00006 d on d.id = a.no_reg ".
						"left join rs00008 e on e.no_reg = a.no_reg ".
						"left join rs00034 f on f.id::text = e.item_id::text ".
						"left join rs00017 g on a.id_dokter::text = g.id::text ".
						"left join rs00017 h on a.id_perawat::text = h.id::text ".
						"where a.no_reg='{$_GET['rg']}' and a.id_ri= '{$_GET["mPOLI"]}' and a.tanggal_reg = '{$_GET["tgl"]}'";
				$r = pg_query($con,$sql);
				$n = pg_num_rows($r);
			    if($n > 0) $d = pg_fetch_array($r);
			    pg_free_result($r);
				//echo $sql;exit;			
			    $_GET['id'] = $_GET['rg'] ;	
	 			
			echo"<div class=box>";
			echo "<table width='100%' border='0'><tr><td colspan='2'>";
			echo"<div class=form_subtitle>DATA RESUME PASIEN</div>";
			echo "</td></tr>";
    		echo "<tr><td  valign=top>";
    		$f = new ReadOnlyForm();
			
			$f->text("<B>".$visit_ri_resume["vis_1"]."</B>",$d["merawat"] );
			$f->text("<B>".$visit_ri_resume["vis_2"]."</B>",$d["mengirim"]);
			$f->text($visit_ri_resume["vis_3"],$d[6]);
			$f->title1("<U>DIAGNOSA</U>","LEFT");
			$f->text($visit_ri_resume["vis_4"],$d[7] );
			$f->text($visit_ri_resume["vis_5"],$d[8]);
			$f->text($visit_ri_resume["vis_6"],$d[9]);
			$f->text($visit_ri_resume["vis_7"],$d[10]);
			$f->text($visit_ri_resume["vis_8"],$d[11] );    
			$f->text($visit_ri_resume["vis_9"],$d[12]);
			$f->text($visit_ri_resume["vis_10"],$d[13]);
			$f->title1("<U>DATA PENUNJANG</U>","LEFT");
			$f->text($visit_ri_resume["vis_11"],$d[14]);
			$f->text($visit_ri_resume["vis_12"],$d[15] );
			$f->execute();
			echo "</td><td valign=top>";
    		$f = new ReadOnlyForm();	
			$f->text($visit_ri_resume["vis_13"],$d[16] );
			$f->text($visit_ri_resume["vis_14"],$d[17]);
			$f->text($visit_ri_resume["vis_15"],$d[18]);
			$f->text($visit_ri_resume["vis_16"],$d[19]);
			$f->text($visit_ri_resume["vis_17"],$d[20] );	
			$f->text($visit_ri_resume["vis_18"],$d[21] );
			$f->title1("<U>KEPERLUAN</U>","LEFT");
			$f->text($visit_ri_resume["vis_19"],$d[22]);
			$f->text($visit_ri_resume["vis_20"],$d[23]);
			$f->text($visit_ri_resume["vis_21"],$d[24]);
			$f->text($visit_ri_resume["vis_22"],$d[25] );
			$f->execute();	
    		echo "</td></tr>";
  			echo "<tr><td colspan='3'>";
  			echo "<br>";
  			include(rm_tindakan3);
  			echo "</td><td>";
  			echo "</td></tr></table>";

			
			}else {
				echo"<div align=center class=form_subtitle1>RIWAYAT RESUME DEWASA / ANAK</div>";
		//detail riwayat
		echo "<table border=0 width='100%' cellspacing=0 cellpadding=0><tr><td valign=top width='33%'  colspan=2>";
		
		//$f = new Form($SC, "GET");
				$sql = "SELECT A.NO_REG,to_char(A.TANGGAL_REG,'DD MON YYYY HH24:MI:SS')as tgl_reg,A.VIS_19,A.VIS_21,A.VIS_22,A.TANGGAL_REG,'DUMMY' ". 
					   "FROM C_VISIT_RI A ".
					   "LEFT JOIN RS00006 B ON A.NO_REG=B.ID ".
					   "WHERE B.MR_NO = '".$_GET["mr"]."' AND A.ID_ri = '{$_GET["mPOLI"]}' ";
				$t = new PgTable($con, "100%");
			    $t->SQL = $sql ;
			    $t->setlocale("id_ID");
			    $t->ShowRowNumber = true;
			   	//$t->ColHidden[4]= true;
			    $t->RowsPerPage = 6;
			    $t->ColHeader = array("NO REGISTRASI","TANGGAL/JAM PEMERIKSAAN","OBAT","PEMERIKSAAN ULANG","TINDAKAN ULANG","DETAIL");
			   	$t->ColAlign = array("center","center","left","left","left","center","center");
			   	$t->ColHidden[6]=true;
				$t->ColFormatHtml[6] = "<A CLASS=TBL_HREF HREF='$SC?p=$PID&list=riwayat&rg1={$_GET["rg1"]}&ri=".$_GET["mPOLI"]."&act=detail&mr=".$_GET["mr"]."&rg=<#0#>&tgl=<#5#>'>".icon("view","View")."</A>";	
				$t->execute();
				
				echo"<br>";
         		echo"</div>";
				echo "</td></tr></table></div>";
    	
			}
    }elseif($_GET["list"] == "riwayat_klinik") {
    	if(!$GLOBALS['print']){
    	$T->show(3);
    	}
    	if ($_GET["act"] == "detail_klinik") {
				$sql = "select a.*,b.nama,to_char(a.tanggal_reg,'dd Month yyyy')as tanggal_reg,f.layanan,a.id_poli 
						from c_visit a 
						left join rs00017 b on a.id_dokter = b.id 
						left join rsv0002 c on a.no_reg=c.id 
						left join rs00006 d on d.id = a.no_reg
						left join rs00008 e on e.no_reg = a.no_reg
						left join rs00034 f on 'f.id' = e.item_id
						where a.no_reg='{$_GET['rg']}' ";
				$r = pg_query($con,$sql);
				$n = pg_num_rows($r);
			    if($n > 0) $d = pg_fetch_array($r);
			    pg_free_result($r);
				//echo $sql;exit;			
			    $_GET['id'] = $_GET['rg'] ;	
	 			
			//echo"<div class=box>";
			echo "<table width='100%' border='0'><tr><td colspan='2'>";
			//echo"<div class=form_subtitle>PEMERIKSAAN PASIEN</div>";
			echo "</td></tr>";
    		echo "<tr><td>";
    		$f = new ReadOnlyForm();
    		$poli=$d["id_poli"];
    		$f->text("Poli","<b>".$poli);
    		if ($poli == $setting_poli["igd"]) {
    			include(detail_igd);
    		}elseif ($poli == $setting_poli["umum"]){
    			include(detail_umum);
    		}elseif ($poli == $setting_poli["mata"]){
    			include(detail_mata);
    		}elseif ($poli == $setting_poli["peny_dalam"]){
    			include(detail_peny_dalam);
    		}
    		elseif ($poli == $setting_poli["anak"]){
    			include(detail_anak);
    		}
    		elseif ($poli == $setting_poli["gigi"]){
    			include(detail_gigi);
    		}
    		elseif ($poli == $setting_poli["tht"]){
    			include(detail_tht);
    		}
    		elseif ($poli == $setting_poli["bedah"]){
    			include(detail_bedah);
    		}
    		elseif ($poli == $setting_poli["kulit_kelamin"]){
    			include(detail_kulit_kelamin);
    		}
    		elseif ($poli == $setting_poli["akupunktur"]){
    			include(detail_akupunktur);
    		}
    		elseif ($poli == $setting_poli["jantung"]){
    			include(detail_jantung);
    		}
    		elseif ($poli == $setting_poli["paru"]){
    			include(detail_paru);
    		}
    		elseif ($poli == $setting_poli["kebidanan_obstetri"]){
    			include(detail_obstetri);
    		}
    		elseif ($poli == $setting_poli["kebidanan_ginekologi"]){
    			include(detail_ginekologi);
    		}
    		elseif ($poli == $setting_poli["saraf"]){
    			include(detail_saraf);
    		}
    		elseif ($poli == $setting_poli["psikiatri"]){
    			include(detail_psikiatri);
    		}
    		elseif ($poli == $setting_poli["fisioterapi"]){
    			include(detail_fisioterapi);
    		}
    		elseif ($poli == $setting_poli["radiologi"]){
    			include(detail_radiologi);
    		}
    		else{
    			include(detail_laboratorium);
    		}
    		
			}else {
				echo"<div align=center class=form_subtitle1>RIWAYAT PENYAKIT PASIEN</div>";
		//detail riwayat
		echo "<table border=0 width='100%' cellspacing=0 cellpadding=0><tr><td valign=top width='33%'  colspan=2>";
		
		//$f = new Form($SC, "GET");
				$sql = "SELECT A.NO_REG,TO_CHAR(A.TANGGAL_REG,'DD MON YYYY')AS TANGGAL,TO_CHAR(A.TANGGAL_REG,'HH:MM:SS')AS WAKTU,C.TDESC,D.NAMA,'DUMMY' ". 
					   "FROM C_VISIT A ".
					   "LEFT JOIN RS00006 B ON A.NO_REG= B.ID  ".
					   "LEFT JOIN RS00001 C ON A.ID_POLI = CAST(C.TC as numeric) AND C.TT='LYN'".
					   "LEFT JOIN RS00017 D ON A.ID_DOKTER = D.ID ".
					   "WHERE B.MR_NO = '".$_GET["mr"]."'
                                            group by A.NO_REG,A.TANGGAL_REG,C.TDESC,D.NAMA ";
				$t = new PgTable($con, "100%");
			    $t->SQL = $sql ;
			    $t->setlocale("id_ID");
			    $t->ShowRowNumber = true;
			   	$t->ColHidden[5]= true;
			    $t->RowsPerPage = 6;
			    $t->ColHeader = array("NO REGISTRASI","TANGGAL KUNJUNGAN","WAKTU KUNJUNGAN","KLINIK","DETAIL");
			   	$t->ColAlign = array("center","center","center","center","center","center");
				$t->ColFormatHtml[5] = "<A CLASS=TBL_HREF HREF='$SC?p=$PID&list=riwayat_klinik&rg1={$_GET["rg1"]}&ri=".$_GET["mPOLI"]."&act=detail_klinik&mr=".$_GET["mr"]."&rg=<#0#>'>".icon("view","View")."</A>";	
				$t->execute();
				
				echo"<br>";
         		echo"</div>";
				echo "</td></tr></table></div>";
    	
			}
    }else {       //pemeriksaan
    	if(!$GLOBALS['print']){
    	$T->show(0);
    	}
    	if($_GET['act']=="edit"){
    		$sql2 =	"SELECT A.*,(C.NAMA)AS nama,(D.NAMA)AS perawat FROM C_VISIT_RI A 
    				LEFT JOIN RS00017 C ON C.ID = $_GET[tmp22]
    				LEFT JOIN RS00017 D ON D.ID = $_GET[tmp23] 
    				WHERE A.ID_RI='{$_GET["ri"]}' AND A.NO_REG='{$_GET["rg1"]}' AND A.TANGGAL_REG='{$_GET["tmp2"]}'";
    	}else{
    		$sql2 =	"SELECT A.* FROM C_VISIT_RI A
    				WHERE A.ID_RI='{$_GET["ri"]}' AND A.NO_REG='{$_GET["rg1"]}'";
    	}
			$r=pg_query($con,$sql2);
			$n = pg_num_rows($r);
			if($n > 0) $d2 = pg_fetch_array($r);
			pg_free_result($r);
				//-------------------------tambah for update------hery 08072007
				//echo "<div align=left><input type=button value=' Edit ' OnClick=\"window.location = './index2.php?p=$PID&rg1={$_GET["rg1"]}&rg=$rg&mr={$_GET['mr']}&ri={$_GET["ri"]}&act=edit';\">\n";   
				//echo "<input type='image' src='images/icon-edit.png' action='edit' >";
				    
				if ($_GET['act'] == "edit") {
                                            echo "<font color='#000000' size='2'> >>Edit Pemeriksaan Pasien</font>";
                                            $f = new Form("actions/p_resume_dewasa_anak.insert.php", "POST", "NAME=Form2");
                                            $f->hidden("act","edit");
                                            $f->hidden("f_no_reg",$d2["no_reg"]);
                                            $f->hidden("f_tanggal_reg",$_GET[tmp2]);
                                            $f->hidden("list","pemeriksaan");
                                            $f->hidden("rawatan",$rawatan);
                                            $f->hidden("f_id_rujukan",$d->poli);
                                            $f->hidden("mr",$_GET["mr"]);
					    $f->hidden("f_id_ri",$_GET["ri"]);
					    $f->hidden("f_user_id",$_SESSION[uid]);
					    $f->hidden("rg1",$_GET[rg1]);
				
				echo "<table border=1 width='100%' cellspacing=0 cellpadding=0><tr><td valign=top width='33%'>";
				if (isset($_SESSION["SELECT_EMP"])) {
    					$_SESSION["RESUME_DEWASA"]["id"] = $_SESSION["SELECT_EMP"];
    					$_SESSION["RESUME_DEWASA"]["nama"] =
        				getFromTable(
			            "select nama from rs00017 where id = '".$_SESSION["RESUME_DEWASA"]["id"]."'");
    					$f->textAndButton3("f_id_dokter","Dokter Yang Merawat",2,10,$_SESSION["RESUME_DEWASA"]["id"],$ext,"nm2",30,70,$_SESSION["RESUME_DEWASA"]["nama"],$ext,"...",$ext,"OnClick='selectPegawai();';");
			            
					}elseif ($_GET[tmp22] != '') {
							$f->textAndButton3("f_id_dokter","Dokter Yang Merawat",2,10,$_GET[tmp22],$ext,"nm2",30,70,$d2["nama"],$ext,"...",$ext,"OnClick='selectPegawai();';");
					}else{
						$f->textAndButton3("f_id_dokter","Dokter Yang Merawat",2,10,0,$ext,"nm2",30,70,$d2["nama"],$ext,"...",$ext,"OnClick='selectPegawai();';");
						
					}
                                        
                                        
                                if (isset($_SESSION["SELECT_EMP2"])) {
    					$_SESSION["RESUME_DEWASA"]["id2"] = $_SESSION["SELECT_EMP2"];
    					$_SESSION["RESUME_DEWASA"]["nama2"] =
        				getFromTable(
			            "select nama from rs00017 where id = '".$_SESSION["RESUME_DEWASA"]["id2"]."'");
    					$f->textAndButton3("f_id_perawat","Dokter Yang Mengirim",2,10,$_SESSION["RESUME_DEWASA"]["id2"],$ext,"nm3",30,70,$_SESSION["RESUME_DEWASA"]["nama2"],$ext,"...",$ext,"OnClick='selectPegawai2();';");
			            
					}elseif ($_GET[tmp23] != '') {
						$f->textAndButton3("f_id_perawat","Dokter Yang Mengirim",2,10,$_GET[tmp23],$ext,"nm3",30,70,$d2["perawat"],$ext,"...",$ext,"OnClick='selectPegawai2();';");
					}else{
						$f->textAndButton3("f_id_perawat","Dokter Yang Mengirim",2,10,0,$ext,"nm3",30,70,$d2["perawat"],$ext,"...",$ext,"OnClick='selectPegawai2();';");
					}
                                        
			$f->text("f_vis_3",$visit_ri_resume["vis_3"],60,50,$_GET["tmp3"],$ext);
			$f->textarea("f_vis_4",$visit_ri_resume["vis_4"] ,1, $visit_ri_resume["vis_4"."W"],$_GET["tmp4"],$ext);
			$f->textarea("f_vis_5",$visit_ri_resume["vis_5"] ,1, $visit_ri_resume["vis_5"."W"],$_GET["tmp5"],$ext);
			$f->text("f_vis_6",$visit_ri_resume["vis_6"],60,100,$_GET["tmp6"],$ext);
			$f->text("f_vis_7",$visit_ri_resume["vis_7"],60,100,$_GET["tmp7"],$ext);
			$f->textarea("f_vis_8",$visit_ri_resume["vis_8"] ,1, $visit_ri_resume["vis_8"."W"],$_GET["tmp8"],$ext);
			$f->text("f_vis_9",$visit_ri_resume["vis_9"],60,50,$_GET["tmp9"],$ext);
			$f->textarea("f_vis_10",$visit_ri_resume["vis_10"] ,1, $visit_ri_resume["vis_10"."W"],$_GET["tmp10"],$ext);
			$f->title1("<U>DATA PENUNJANG</U>");
			$f->text("f_vis_11",$visit_ri_resume["vis_11"],60,100,$_GET["tmp11"],$ext);
			$f->text("f_vis_12",$visit_ri_resume["vis_12"],60,100,$_GET["tmp12"],$ext);
			$f->text("f_vis_13",$visit_ri_resume["vis_13"],60,100,$_GET["tmp13"],$ext);
			$f->text("f_vis_14",$visit_ri_resume["vis_14"],60,100,$_GET["tmp14"],$ext);
			$f->textarea("f_vis_15",$visit_ri_resume["vis_15"] ,1, $visit_ri_resume["vis_15"."W"],$_GET["tmp15"],$ext);
			$f->textarea("f_vis_16",$visit_ri_resume["vis_16"] ,1, $visit_ri_resume["vis_16"."W"],$_GET["tmp16"],$ext);
			$f->textarea("f_vis_17",$visit_ri_resume["vis_17"] ,1, $visit_ri_resume["vis_17"."W"],$_GET["tmp17"],$ext);
			$f->text("f_vis_18",$visit_ri_resume["vis_18"],60,100,$_GET["tmp18"],$ext);
			$f->title1("<U>KEPERLUAN</U>");
			$f->text("f_vis_19",$visit_ri_resume["vis_19"],60,100,$_GET["tmp1"],$ext);
			$f->text("f_vis_20",$visit_ri_resume["vis_20"],60,100,$_GET["tmp19"],$ext);
			$f->text("f_vis_21",$visit_ri_resume["vis_21"],60,100,$_GET["tmp20"],$ext);
			$f->text("f_vis_22",$visit_ri_resume["vis_22"],60,100,$_GET["tmp21"],$ext);
			$f->submitAndCancel("Simpan",$ext,"Batal","window.history.back()",$ext);
			$f->execute();
				
			//unset($_SESSION["SELECT_EMP"]);
			//unset($_SESSION["SELECT_EMP2"]);
			echo"</div>";
			echo "<div align=right><b>RM x</b></div>";	    
					   
				}elseif ($_GET['act'] == "tambah") {
						echo "<font color='#000000' size='2'>Tambah Data Proses Keperawatan</font>";
					$f = new Form("actions/p_resume_dewasa_anak.insert.php", "POST", "NAME=Form2");
					$f->hidden("act","new");
					$f->hidden("f_no_reg",$d->id);
					$f->hidden("f_id_rujukan",$d->poli);
					$f->hidden("list","pemeriksaan");
					$f->hidden("rawatan",$rawatan);
                                        $f->hidden("mr",$_GET["mr"]);
                                        $f->hidden("f_id_ri",$_GET["ri"]);
					$f->hidden("f_user_id",$_SESSION[uid]);
					$f->hidden("rg1",$_GET[rg1]);
					
					echo "<table border=1 width='100%' cellspacing=0 cellpadding=0><tr><td valign=top width='33%'>";
                         if (isset($_SESSION["SELECT_EMP"])) {
    					$_SESSION["RESUME_DEWASA"]["id"] = $_SESSION["SELECT_EMP"];
    					$_SESSION["RESUME_DEWASA"]["nama"] =
        				getFromTable(
			            "select nama from rs00017 where id = '".$_SESSION["RESUME_DEWASA"]["id"]."'");
    					$f->textAndButton3("f_id_dokter","Dokter Yang Merawat",2,10,$_SESSION["RESUME_DEWASA"]["id"],$ext,"nm2",30,70,$_SESSION["RESUME_DEWASA"]["nama"],$ext,"...",$ext,"OnClick='selectPegawai();';");
			            
					}elseif ($_GET[tmp22] != '') {
							$f->textAndButton3("f_id_dokter","Dokter Yang Merawat",2,10,$_GET[tmp22],$ext,"nm2",30,70,$d2["nama"],$ext,"...",$ext,"OnClick='selectPegawai();';");
					}else{
						$f->textAndButton3("f_id_dokter","Dokter Yang Merawat",2,10,0,$ext,"nm2",30,70,$d2["nama"],$ext,"...",$ext,"OnClick='selectPegawai();';");
						
					}
			if (isset($_SESSION["SELECT_EMP2"])) {
    					$_SESSION["RESUME_DEWASA"]["id2"] = $_SESSION["SELECT_EMP2"];
    					$_SESSION["RESUME_DEWASA"]["nama2"] =
        				getFromTable(
			            "select nama from rs00017 where id = '".$_SESSION["RESUME_DEWASA"]["id2"]."'");
    					$f->textAndButton3("f_id_perawat","Dokter Yang Mengirim",2,10,$_SESSION["RESUME_DEWASA"]["id2"],$ext,"nm3",30,70,$_SESSION["RESUME_DEWASA"]["nama2"],$ext,"...",$ext,"OnClick='selectPegawai2();';");
			            
					}elseif ($_GET[tmp23] != '') {
						$f->textAndButton3("f_id_perawat","Dokter Yang Mengirim",2,10,$_GET[tmp23],$ext,"nm3",30,70,$d2["perawat"],$ext,"...",$ext,"OnClick='selectPegawai2();';");
					}else{
						$f->textAndButton3("f_id_perawat","Dokter Yang Mengirim",2,10,0,$ext,"nm3",30,70,$d2["perawat"],$ext,"...",$ext,"OnClick='selectPegawai2();';");
					}
                                        
                                        
			$f->text("f_vis_3",$visit_ri_resume["vis_3"],60,50,$d2["vis_3"],$ext);
			$f->textarea("f_vis_4",$visit_ri_resume["vis_4"] ,1, $visit_ri_resume["vis_4"."W"],$d2["vis_4"],$ext);
			$f->textarea("f_vis_5",$visit_ri_resume["vis_5"] ,1, $visit_ri_resume["vis_5"."W"],$d2["vis_5"],$ext);
			$f->text("f_vis_6",$visit_ri_resume["vis_6"],60,100,$d2["vis_6"],$ext);
			$f->text("f_vis_7",$visit_ri_resume["vis_7"],60,100,$d2["vis_7"],$ext);
			$f->textarea("f_vis_8",$visit_ri_resume["vis_8"] ,1, $visit_ri_resume["vis_8"."W"],$d2["vis_8"],$ext);
			$f->text("f_vis_9",$visit_ri_resume["vis_9"],60,50,$d2["vis_9"],$ext);
			$f->textarea("f_vis_10",$visit_ri_resume["vis_10"] ,1, $visit_ri_resume["vis_10"."W"],$d2["vis_10"],$ext);
			$f->title1("<U>DATA PENUNJANG</U>");
			$f->text("f_vis_11",$visit_ri_resume["vis_11"],60,100,$d2["vis_11"],$ext);
			$f->text("f_vis_12",$visit_ri_resume["vis_12"],60,100,$d2["vis_12"],$ext);
			$f->text("f_vis_13",$visit_ri_resume["vis_13"],60,100,$d2["vis_13"],$ext);
			$f->text("f_vis_14",$visit_ri_resume["vis_14"],60,100,$d2["vis_14"],$ext);
			$f->textarea("f_vis_15",$visit_ri_resume["vis_15"] ,1, $visit_ri_resume["vis_15"."W"],$d2["vis_15"],$ext);
			$f->textarea("f_vis_16",$visit_ri_resume["vis_16"] ,1, $visit_ri_resume["vis_16"."W"],$d2["vis_16"],$ext);
			$f->textarea("f_vis_17",$visit_ri_resume["vis_17"] ,1, $visit_ri_resume["vis_17"."W"],$d2["vis_17"],$ext);
			$f->text("f_vis_18",$visit_ri_resume["vis_18"],60,100,$d2["vis_18"],$ext);
			$f->title1("<U>KEPERLUAN</U>");
			$f->text("f_vis_19",$visit_ri_resume["vis_19"],60,100,"",$ext);
			$f->text("f_vis_20",$visit_ri_resume["vis_20"],60,100,$d2["vis_20"],$ext);
			$f->text("f_vis_21",$visit_ri_resume["vis_21"],60,100,$d2["vis_21"],$ext);
			$f->text("f_vis_22",$visit_ri_resume["vis_22"],60,100,$d2["vis_22"],$ext);
			$f->submitAndCancel("Simpan",$ext,"Batal","window.history.back()",$ext);
			$f->execute();
			//unset($_SESSION["SELECT_EMP"]);
			//unset($_SESSION["SELECT_EMP2"]);
			echo"</div>";
			echo "<div align=right><b>RM x</b></div>";
					
				}else {
					if($n > 0) {
						$ext= "disabled";
					}else {
						$ext = "";
					}
				//---------------------------------------------------------------------------------			
						
					$f = new Form("actions/p_resume_dewasa_anak.insert.php", "POST", "NAME=Form2");
					$f->hidden("act","new");
					$f->hidden("f_no_reg",$d->id);
					$f->hidden("f_id_rujukan",$d->poli);
					$f->hidden("list","pemeriksaan");
					$f->hidden("rawatan",$rawatan);
                                        $f->hidden("mr",$_GET["mr"]);
                                        $f->hidden("f_id_ri",$_GET["ri"]);
					$f->hidden("f_user_id",$_SESSION[uid]);
					$f->hidden("rg1",$_GET[rg1]);
					
			
			echo"<br>";
			echo"<div align=center class=form_subtitle1>KEPERLUAN OBAT-OBATAN</div>";
			$sql = "SELECT to_char(A.TANGGAL_REG,'MM MONTH YYYY')as tanggal, to_char(A.TANGGAL_REG,'HH24:MM:SS')as waktu,A.VIS_19,A.TANGGAL_REG,A.VIS_3,A.VIS_4,A.VIS_5,".
					"A.VIS_6,A.VIS_7,A.VIS_8,A.VIS_9,A.VIS_10,A.VIS_11,A.VIS_12,A.VIS_13,A.VIS_14,A.VIS_15,A.VIS_16,A.VIS_17,A.VIS_18,A.VIS_20,A.VIS_21,A.vis_22,A.id_dokter,A.id_perawat,'DUMMY'". 
					"FROM C_VISIT_RI A ".
					"LEFT JOIN RS00006 B ON A.NO_REG=B.ID ".
					"WHERE B.mr_no = '".$_GET["mr"]."' AND A.id_ri = '{$_GET["mPOLI"]}' ORDER BY A.TANGGAL_REG ";
				$t = new PgTable($con, "100%");
			    $t->SQL = $sql ;
			    $t->setlocale("id_ID");
			    $t->ShowRowNumber = true;
			    $t->ColHidden[5] =true;
			    $t->ColHidden[4] =true;$t->ColHidden[6] =true;$t->ColHidden[7] =true;$t->ColHidden[8] =true;
			    $t->ColHidden[9] =true;$t->ColHidden[10] =true;$t->ColHidden[11] =true;$t->ColHidden[12] =true;
			    $t->ColHidden[13] =true;$t->ColHidden[14] =true;$t->ColHidden[15] =true;$t->ColHidden[16] =true;
			    $t->ColHidden[17] =true;$t->ColHidden[18] =true;$t->ColHidden[19] =true;$t->ColHidden[20] =true;
			    $t->ColHidden[21] =true;$t->ColHidden[22] =true;$t->ColHidden[23] =true;$t->ColHidden[24] =true;$t->ColHidden[25] =true;
			    $t->RowsPerPage = 6;
			    $t->ColHeader = array("TANGGAL","JAM","OBAT","EDIT");
			   	$t->ColAlign [0] = "CENTER" ;
			   	$t->ColAlign [1] = "CENTER" ;
			   	$t->ColAlign [2] = "LEFT" ;
			   	$t->ColAlign [25] = "CENTER" ;
				$t->ColFormatHtml[25] = "<A CLASS=TBL_HREF HREF='$SC?p=$PID&list=pemeriksaan&rg1={$_GET["rg1"]}&ri=".$_GET["mPOLI"]."&act=edit&mr=".$_GET["mr"]."&rg=<#0#>
				&tmp1=<#2#>&tmp2=<#3#>&tmp3=<#4#>&tmp4=<#5#>&tmp5=<#6#>&tmp6=<#7#>&tmp7=<#8#>&tmp8=<#9#>&tmp9=<#10#>&tmp10=<#11#>&tmp11=<#12#>&tmp12=<#13#>&tmp13=<#14#>&tmp14=<#15#>&tmp15=<#16#>&tmp16=<#17#>&tmp17=<#18#>&tmp18=<#19#>&tmp19=<#20#>&tmp20=<#21#>&tmp21=<#22#>&tmp22=<#23#>&tmp23=<#24#>'>".icon("edit","Edit")."</A>";	
				$t->execute();
				echo "<br>";
				echo "<div align=left><input type=button value=' Tambah ' OnClick=\"window.location = './index2.php?p=$PID&rg1={$_GET["rg1"]}&rg=$rg&mr={$_GET['mr']}&ri={$_GET["ri"]}&act=tambah';\">\n";
				
						
			echo "<table border=1 width='100%' cellspacing=0 cellpadding=0><tr><td valign=top width='33%'>";
			if (isset($_SESSION["SELECT_EMP"])) {
    					$_SESSION["RESUME_DEWASA"]["id"] = $_SESSION["SELECT_EMP"];
    					$_SESSION["RESUME_DEWASA"]["nama"] =
        				getFromTable(
			            "select nama from rs00017 where id = '".$_SESSION["RESUME_DEWASA"]["id"]."'");
    					$f->textAndButton3("f_id_dokter","Dokter Yang Merawat",2,10,$_SESSION["RESUME_DEWASA"]["id"],$ext,"nm2",30,70,$_SESSION["RESUME_DEWASA"]["nama"],$ext,"...",$ext,"OnClick='selectPegawai();';");
			            
					}elseif ($_GET[tmp22] != '') {
							$f->textAndButton3("f_id_dokter","Dokter Yang Merawat",2,10,$_GET[tmp22],$ext,"nm2",30,70,$d2["nama"],$ext,"...",$ext,"OnClick='selectPegawai();';");
					}else{
						$f->textAndButton3("f_id_dokter","Dokter Yang Merawat",2,10,0,$ext,"nm2",30,70,$d2["nama"],$ext,"...",$ext,"OnClick='selectPegawai();';");
						
					}
			if (isset($_SESSION["SELECT_EMP2"])) {
    					$_SESSION["RESUME_DEWASA"]["id2"] = $_SESSION["SELECT_EMP2"];
    					$_SESSION["RESUME_DEWASA"]["nama2"] =
        				getFromTable(
			            "select nama from rs00017 where id = '".$_SESSION["RESUME_DEWASA"]["id2"]."'");
    					$f->textAndButton3("f_id_perawat","Dokter Yang Mengirim",2,10,$_SESSION["RESUME_DEWASA"]["id2"],$ext,"nm3",30,70,$_SESSION["RESUME_DEWASA"]["nama2"],$ext,"...",$ext,"OnClick='selectPegawai2();';");
			            
					}elseif ($_GET[tmp23] != '') {
						$f->textAndButton3("f_id_perawat","Dokter Yang Mengirim",2,10,$_GET[tmp23],$ext,"nm3",30,70,$d2["perawat"],$ext,"...",$ext,"OnClick='selectPegawai2();';");
					}else{
						$f->textAndButton3("f_id_perawat","Dokter Yang Mengirim",2,10,0,$ext,"nm3",30,70,$d2["perawat"],$ext,"...",$ext,"OnClick='selectPegawai2();';");
					}
			$f->text("f_vis_3",$visit_ri_resume["vis_3"],60,50,$d2["vis_3"],$ext);
			$f->textarea("f_vis_4",$visit_ri_resume["vis_4"] ,1, $visit_ri_resume["vis_4"."W"],$d2["vis_4"],$ext);
			$f->textarea("f_vis_5",$visit_ri_resume["vis_5"] ,1, $visit_ri_resume["vis_5"."W"],$d2["vis_5"],$ext);
			$f->text("f_vis_6",$visit_ri_resume["vis_6"],60,100,$d2["vis_6"],$ext);
			$f->text("f_vis_7",$visit_ri_resume["vis_7"],60,100,$d2["vis_7"],$ext);
			$f->textarea("f_vis_8",$visit_ri_resume["vis_8"] ,1, $visit_ri_resume["vis_8"."W"],$d2["vis_8"],$ext);
			$f->text("f_vis_9",$visit_ri_resume["vis_9"],60,50,$d2["vis_9"],$ext);
			$f->textarea("f_vis_10",$visit_ri_resume["vis_10"] ,1, $visit_ri_resume["vis_10"."W"],$d2["vis_10"],$ext);
			$f->title1("<U>DATA PENUNJANG</U>");
			$f->text("f_vis_11",$visit_ri_resume["vis_11"],60,100,$d2["vis_11"],$ext);
			$f->text("f_vis_12",$visit_ri_resume["vis_12"],60,100,$d2["vis_12"],$ext);
			$f->text("f_vis_13",$visit_ri_resume["vis_13"],60,100,$d2["vis_13"],$ext);
			$f->text("f_vis_14",$visit_ri_resume["vis_14"],60,100,$d2["vis_14"],$ext);
			$f->textarea("f_vis_15",$visit_ri_resume["vis_15"] ,1, $visit_ri_resume["vis_15"."W"],$d2["vis_15"],$ext);
			$f->textarea("f_vis_16",$visit_ri_resume["vis_16"] ,1, $visit_ri_resume["vis_16"."W"],$d2["vis_16"],$ext);
			$f->textarea("f_vis_17",$visit_ri_resume["vis_17"] ,1, $visit_ri_resume["vis_17"."W"],$d2["vis_17"],$ext);
			$f->text("f_vis_18",$visit_ri_resume["vis_18"],60,100,$d2["vis_18"],$ext);
			$f->title1("<U>KEPERLUAN</U>");
			$f->text("f_vis_19",$visit_ri_resume["vis_19"],60,100,$d2["vis_19"],$ext);
			$f->text("f_vis_20",$visit_ri_resume["vis_20"],60,100,$d2["vis_20"],$ext);
			$f->text("f_vis_21",$visit_ri_resume["vis_21"],60,100,$d2["vis_21"],$ext);
			$f->text("f_vis_22",$visit_ri_resume["vis_22"],60,100,$d2["vis_22"],$ext);
			$f->submitAndCancel("Simpan",$ext,"Batal","window.history.back()",$ext);
			$f->execute();
			//unset($_SESSION["SELECT_EMP"]);
			//unset($_SESSION["SELECT_EMP2"]);
			echo"</div>";
			echo "<div align=right><b>RM x</b></div>";
				}
    }
    
    //pemeriksaan
    
    echo "</div>";
    
	    echo "\n<script language='JavaScript'>\n";
	    echo "function selectLayanan() {\n";
	   	echo "    sWin = window.open('popup/layanan.php', 'xWin', 'top=0,left=0,width=700,height=400,menubar=no,scrollbars=yes');\n";
	    echo "    sWin.focus();\n";
	    echo "}\n";
        echo "function selectPegawai(tag) {\n";
        echo "    sWin = window.open('popup/pegawai.php?tag=' + tag, 'xWin',".
             " 'top=0,left=0,width=500,height=400,menubar=no,scrollbars=yes');\n";
        echo "    sWin.focus();\n";
        echo "}\n";
        echo "function selectPegawai2(tag) {\n";
        echo "    sWin = window.open('popup/pegawai2.php?tag=' + tag, 'xWin',".
             " 'top=0,left=0,width=500,height=400,menubar=no,scrollbars=yes');\n";
        echo "    sWin.focus();\n";
        echo "}\n";
        
    if (empty($_GET[sub])) {
	    echo "function refreshSubmit() {\n";
	    echo "    document.Form8.submitButton.disabled = Number(document.Form8.layanan.value) == 0 || Number(document.Form8.jumlah.value == 0);\n";
	    echo "}\n";
	    echo "refreshSubmit();\n";
	    }
	    echo "</script>\n";
   		
} 
  
?>
