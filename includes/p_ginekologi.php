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
        // Agung S. Menambahkan group by pada riwayat_klinik
		//Agung Sunandar 12:41 07/06/2012 menambahkan field yang kurang pada tab riwayat klinik
		// Agung Sunandar 13:23 07/06/2012 menambahkan operasi pada tab riwayat klinik

session_start();
$PID = "p_ginekologi";
$SC = $_SERVER["SCRIPT_NAME"];

require_once("startup.php");
require_once("lib/visit_setting.php");

//--fungsi column color-------------- Agung Sunandar 22:58 26/06/2012
function color( $dstr, $r ) {

	    if($_GET['list2']=="tab1"){
	    	if ($dstr[7] == 'BELUM ADA TAGIHAN' ){
	    		return "<font color=red><b>{$dstr[$r]}</b></font>";
	    	}else{
	    		return "<font color=blue><b>{$dstr[$r]}</b></font>";
	    	}
	    }else{
	    	if ($dstr[6] == 'BELUM ADA TAGIHAN' ){
	    		return "<font color=red><b>{$dstr[$r]}</b></font>";
	    	}else{
	    		return "<font color=blue><b>{$dstr[$r]}</b></font>";
	    	}
	    }
}
//-------------------------------       	
$_GET["mPOLI"]=$setting_poli["kebidanan_ginekologi"];
$rg = isset($_GET["rg"])? $_GET["rg"] : $_POST["rg"];
$mr = isset($_GET["mr"])? $_GET["mr"] : $_POST["mr"];
// Tambahan BHP
$POLI=$setting_poli["kebidanan_ginekologi"];
// ======================================

include ("session.php");

echo "<table border=0 width='100%'><tr><td>";

title_print("<img src='icon/rawat-jalan-2.gif' align='absmiddle' >  POLIKLINIK KEBIDANAN DAN PENYAKIT KANDUNGAN (GINEKOLOGI)");
title_excel("p_ginekologi&list=".$_GET['list']."&rg=".$_GET['rg']."&poli=".$_GET['poli']."&mr=".$_GET['mr']."&sub=".$_GET['sub']."&act=".$_GET['act']."&polinya=".$_GET['polinya']."&tblstart=".$_GET['tblstart']."");

echo "</td></tr></table>";

unset($_GET["layanan"]);

$reg = $_GET["rg"];
$reg2 =  $_GET["rg"];

include ("tab.php");

if ($reg > 0) {
    include ("keterangan");

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
        $f = new Form("actions/p_ginekologi.insert.php");
        $f->hidden("rg",$_GET["rg"]);
        $f->hidden("mr",$_GET["mr"]);
        $f->hidden("poli",$_GET["poli"]);
	$f->hidden("sub",$_GET["sub"]);
        $f->hidden("byr",$total);
        //$f->text("byr","Jumlah Pembayaran",15,15,$total,"STYLE='text-align:right'");
        $f->submit(" Simpan &amp; Bayar ");
        $f->execute();
    
} elseif ($_GET["list"] == "icd") {  // -------- ICD
		if(!$GLOBALS['print']){
		$T->show(2);
		}else{}
		$PID = 'p_ginekologi';
        include ("icd.php");
	
        include("rincian3.php");
        
} elseif ($_GET["list"] == "icd9") {  // -------- ICD9
		if(!$GLOBALS['print']){
		$T->show(3);
		}else{}
		$PID = 'p_ginekologi';
        include ("icd9.php");
	
        include("rincian3.php");
        
    }elseif ($_GET["list"] == "layanan") { // ----------------------------- LAYANAN MEDIS
    	if(!$GLOBALS['print']){
    	$T->show(1);
    	}else{}
		
        //-------------------------------------------------------------------------------------------
		//start check status bayar pasien
		$StatusBayar = getFromTable("select statusbayar from rsv0012 where id = '".$_GET["rg"]."'");
		$StatusTagih = getFromTable("select tagih from rsv0012 where id = '".$_GET["rg"]."'");
		$StatusInap = getFromTable("select rawat_inap from rs00006 where id = '".$_GET["rg"]."'");
		if($StatusInap == 'I'){
			$StatusCHK = getFromTable("select count(trans_types) from rs00010 where no_reg = '".$_GET["rg"]."' and trans_types='CHK'");
		}else{
			$StatusCHK = 1;
		}
		$cekKonsul = getFromTable("select max(tanggal_konsul) from c_visit where no_reg = '".$_GET["rg"]."' and id_konsul='".$_GET["mPOLI"]."'");
		//var_dump($StatusInap);
		//end check status bayar pasien
		
		if(($StatusBayar=='LUNAS')&&($StatusTagih > 0) && $StatusCHK!=0 && $cekKonsul!=date('Y-m-d')){
			echo "<div align=center><br>";
			echo "<font color=red size=3><blink>PERINGATAN </blink>!</font><br>";
			echo "<font color=red size=3>TAGIHAN PASIEN <font color=navy><blink>".$StatusBayar."</blink></font>, INPUT LAYANAN CLOSED<br>";
			echo "</div>";
		}else{	
			include ("pelayanan.php");
        }
		//-------------------------------------------------------------------------------------------
        
		include("rincian3.php"); 
       
    } elseif($_GET["list"] == "riwayat") {
    	if(!$GLOBALS['print']){
		$T->show(4);
	}else{}
    	if ($_GET["act"] == "detail") {
				$sql = "select a.*,b.nama,h.nama as perawat,to_char(a.tanggal_reg,'dd Month yyyy')as tanggal_reg,f.layanan 
						from c_visit a 
						left join rs00017 b on a.id_dokter = B.ID 
						left join rs00017 h on a.id_perawat = h.id
						left join rsv0002 c on a.no_reg=c.id 
						left join rs00006 d on d.id = a.no_reg
						left join rs00008 e on e.no_reg = a.no_reg
						--left join rs00034 f on f.id = trim(e.item_id,0)
						left join rs00034 f on 'f.id' = e.item_id
						where a.no_reg='{$_GET['rg']}' and a.id_poli='".$_GET["mPOLI"]."' ";
				$r = pg_query($con,$sql);
				$n = pg_num_rows($r);
			    if($n > 0) $d = pg_fetch_array($r);
			    pg_free_result($r);
				//echo $sql;exit;			
			    $_GET['id'] = $_GET['rg'] ;	
	 			
			echo"<div class=box>";
			echo "<table width='100%' border='0'><tr><td colspan='2'>";
			echo"<div class=form_subtitle>PEMERIKSAAN PASIEN KLINIK GINEKOLOGI</div>";
			echo "</td></tr>";
    		echo "<tr><td valign=top>";
    		$f = new ReadOnlyForm();
			$f->text("Tanggal Pemeriksaan","<b>".$d["tanggal_reg"]);
			$f->title1("<U>PEMERIKSAAN UMUM</U>","LEFT");
			$f->text($visit_ginekologi["vis_1"],$d[3] );
			$f->text($visit_ginekologi["vis_2"],$d[4]."&nbsp;Cm");
			$f->text($visit_ginekologi["vis_3"],$d[5]."&nbsp;mm Hg");
			//$f->text($visit_ginekologi["vis_4"],$d[6]."&nbsp;Celcius");

			$f->text($visit_ginekologi["vis_5"],$d[7]);
			//$f->text($visit_ginekologi["vis_7"],$d[9]);
			$f->text($visit_ginekologi["vis_6"],$d[8]."&nbsp;Kg");
			//$f->text($visit_ginekologi["vis_8"],$d[10]."&nbsp;/Menit");    
			if ($d[11] == null) {
				null;
			}else {$f->text($visit_ginekologi["vis_9"],"<IMG BORDER=0 SRC='../onemedic_kso_siti/images/icon-ok.png'>");}
			if ($d[12] == null) {
				null;
			}else {$f->text($visit_ginekologi["vis_10"],"<IMG BORDER=0 SRC='../onemedic_kso_siti/images/icon-ok.png'>");}
			if ($d[13] == null) {
				null;
			}else {$f->text($visit_ginekologi["vis_11"],"<IMG BORDER=0 SRC='../onemedic_kso_siti/images/icon-ok.png'>");}
			if ($d[14] == null) {
				null;
			}else {$f->text($visit_ginekologi["vis_12"],"<IMG BORDER=0 SRC='../onemedic_kso_siti/images/icon-ok.png'>");}
			if ($d[15] == null) {
				null;
			}else {$f->text($visit_ginekologi["vis_13"],"<IMG BORDER=0 SRC='../onemedic_kso_siti/images/icon-ok.png'>");}
			if ($d[16] == null) {
				null;
			}else {$f->text($visit_ginekologi["vis_14"],"<IMG BORDER=0 SRC='../onemedic_kso_siti/images/icon-ok.png'>");}
			
			//$f->title1("Pembesaran Kelenjar Getah Bening","LEFT");
			//$f->text("Supraclavikula",$d[17]."&nbsp;"."<b>x</b>"."&nbsp;".$d[18]."&nbsp;"."<b>x</b>"."&nbsp;".$d[19]."&nbsp;"."Cm");
			//$f->text("Inguil",$d[20]."&nbsp;"."<b>x</b>"."&nbsp;".$d[21]."&nbsp;"."<b>x</b>"."&nbsp;".$d[22]."&nbsp;"."Cm");
			//$f->text("Aksila",$d[23]."&nbsp;"."<b>x</b>"."&nbsp;".$d[24]."&nbsp;"."<b>x</b>"."&nbsp;".$d[25]."&nbsp;"."Cm");
			$f->title1("Benjolan / Tumor Lokasi","LEFT");
			if ($d[26] == null) {
				null;
			}else {$f->text($d[26],$d[27]."&nbsp;"."<b>x</b>"."&nbsp;".$d[28]."&nbsp;"."<b>x</b>"."&nbsp;".$d[29]."&nbsp;"."Cm");}
			//$f->execute();
			
			//echo "</td><td valign=top>";
    		//$f = new ReadOnlyForm();
			if ($d[30] == null) {
				null;
			}else {$f->text($d[30],$d[31]."&nbsp;"."<b>x</b>"."&nbsp;".$d[32]."&nbsp;"."<b>x</b>"."&nbsp;".$d[33]."&nbsp;"."Cm");}			
			if ($d[34] == null) {
				null;
			}else {$f->text($d[34],$d[35]."&nbsp;"."<b>x</b>"."&nbsp;".$d[36]."&nbsp;"."<b>x</b>"."&nbsp;".$d[37]."&nbsp;"."Cm");}
			if ($d[38] == null) {
				null;
			}else {$f->text($d[38],$d[39]."&nbsp;"."<b>x</b>"."&nbsp;".$d[40]."&nbsp;"."<b>x</b>"."&nbsp;".$d[41]."&nbsp;"."Cm");}
			$f->text($visit_ginekologi["vis_40"],$d[42] );
			$f->execute();
			
			echo "</td><td valign=top>";
    		$f = new ReadOnlyForm();
			
			$f->title1("<U>PEMERIKSAAN GINEKOLOGI</U>","LEFT");
			$f->title1("Porsio","LEFT");
			if ($d[43] == null) {
				null;
			}else {$f->text($visit_ginekologi["vis_41"],"<IMG BORDER=0 SRC='../onemedic_kso_siti/images/icon-ok.png'>");}
			if ($d[44] == null) {
				null;
			}else {$f->text($visit_ginekologi["vis_42"],"<IMG BORDER=0 SRC='../onemedic_kso_siti/images/icon-ok.png'>");}
			if ($d[45] == null) {
				null;
			}else {$f->text($visit_ginekologi["vis_43"],"<IMG BORDER=0 SRC='../onemedic_kso_siti/images/icon-ok.png'>");}
			if ($d[46] == null) {
				null;
			}else {$f->text($visit_ginekologi["vis_44"],"<IMG BORDER=0 SRC='../onemedic_kso_siti/images/icon-ok.png'>");}
			if ($d[47] == null) {
				null;
			}else {$f->text($visit_ginekologi["vis_45"],"<IMG BORDER=0 SRC='../onemedic_kso_siti/images/icon-ok.png'>");}
			$f->text("Ukuran Tumor",$d[48]."&nbsp;"."<b>x</b>"."&nbsp;".$d[49]."&nbsp;"."<b>x</b>"."&nbsp;".$d[50]."&nbsp;"."Cm");
			$f->text($visit_ginekologi["vis_49"],$d[51]);
			$f->text($visit_ginekologi["vis_50"],$d[52]."&nbsp;"."Cm");
			$f->text($visit_ginekologi["vis_51"],$d[53] );
			$f->text($visit_ginekologi["vis_52"],$d[54] );
			$f->text($visit_ginekologi["vis_53"],$d[55]."&nbsp;"."g%" );
			$f->text($visit_ginekologi["vis_54"],$d[56]."&nbsp;"."/mm3" );
			$f->title1("<U>DOKTER PEMERIKSA</U>","LEFT");
			$f->text("Dokter",$d["nama"]);
			$f->text("Perawat",$d["perawat"]);
			$f->execute();
    		echo "</td></tr>";
  			echo "<tr><td colspan='3'>";
  			echo "<br>";
  			include(rm_tindakan3);
  			echo "</td><td>";
  			echo "</td></tr></table>";

			
			}else {
				echo"<div align=center class=form_subtitle1>RIWAYAT PENYAKIT PASIEN</div>";
		//detail riwayat
		echo "<table border=0 width='100%' cellspacing=0 cellpadding=0><tr><td valign=top width='33%'  colspan=2>";
		
		//$f = new Form($SC, "GET");
				$sql = "SELECT A.NO_REG,TO_CHAR(A.TANGGAL_REG,'DD MON YYYY')AS TANGGAL,TO_CHAR(A.TANGGAL_REG,'HH:MM:SS') AS WAKTU,C.TDESC,D.NAMA,A.ID_POLI::text,a.oid ". 
					   "FROM C_VISIT A ".
					   "LEFT JOIN RS00006 B ON A.NO_REG=B.ID ".
					   "LEFT JOIN RS00001 C ON A.ID_POLI = C.TC_POLI AND C.TT='LYN'".
					   "LEFT JOIN RS00017 D ON A.ID_DOKTER = D.ID ".
					   "LEFT JOIN RS00001 E ON A.ID_KONSUL = E.TC AND E.TT='LYN'".
					   "WHERE A.VIS_1 != '' and B.MR_NO = '".$_GET["mr"]."' AND  A.ID_POLI = '{$_GET["mPOLI"]}' 
                                            GROUP BY A.NO_REG,A.TANGGAL_REG,C.TDESC,D.NAMA,A.ID_POLI,a.oid
                                            ";
					
				$t = new PgTable($con, "100%");
			    $t->SQL = $sql ;
			    $t->setlocale("id_ID");
			    $t->ShowRowNumber = true;
			   	$t->ColHidden[6]= true;
			   	$t->ColHidden[1]= true;
			    $t->RowsPerPage = $ROWS_PER_PAGE;
			    $t->ColHeader = array("TANGGAL PEMERIKSAAN","","WAKTU KUNJUNGAN","KLINIK","DOKTER PEMERIKSA","DETAIL");
			   	$t->ColAlign = array("center","center","center","left","left","left","center","center");
				$t->ColFormatHtml[6] = "<A CLASS=TBL_HREF HREF='$SC?p=$PID&list=riwayat&act=detail&mr=".$_GET["mr"]."&poli=".$_GET["mPOLI"]."&rg=<#0#>'>".icon("view","View")."</A>";	
				$t->execute();
				
				echo"<br>";
         		echo"</div>";
				echo "</td></tr></table></div>";
    				}
}elseif($_GET["list"] == "riwayat_klinik") {
    	if(!$GLOBALS['print']){
		$T->show(5);
	}else{}
	
	include ("riwayat_klinik.php");
	
}elseif ($_GET["list"] == "unit_rujukan"){
    	$T->show(6);
    	
	include ("unit_rujukan.php");
				        	
}elseif ($_GET["list"] == "konsultasi"){
    	$T->show(7);
    	echo"<br>";
    	
	include ("konsultasi.php");
		
}elseif ($_GET["list"] == "resepobat"){ //RESEP OBAT
    	$T->show(8);
    	//echo"<br>";
    	
 include ("resep_obat.php");
 
 include("rincianobat.php"); 


				        	
    }else {       //pemeriksaan
    	if(!$GLOBALS['print']) {
		$T->show(0);
	}else{}
    		
    		$sql2 =	"SELECT A.*,B.NAMA,D.nama as perawat FROM C_VISIT A 
    				LEFT JOIN RS00017 B ON A.ID_DOKTER = B.ID
    				LEFT JOIN RS00017 D ON A.ID_PERAWAT = D.ID
    				WHERE A.ID_POLI={$_GET["mPOLI"]} AND A.NO_REG='$rg'"; 
	    	$r=pg_query($con,$sql2);
	    	$n = pg_num_rows($r);		    	
			    if($n > 0) $d2 = pg_fetch_array($r);
			    pg_free_result($r);
				//-------------------------tambah for update------hery 08072007
				echo "<div align=left><input type=button value=' Edit ' OnClick=\"window.location = './index2.php?p=$PID&rg=$rg&mr={$_GET['mr']}&poli={$_GET["poli"]}&act=edit';\">\n";   
				
				    
				if ($_GET['act'] == "edit") {
					
						echo "<font color='#000000' size='2'> >>Edit Pemeriksaan Pasien</font>";
						$f = new Form("actions/p_ginekologi.insert.php", "POST", "NAME=Form2");
						$f->hidden("act","edit");
						$f->hidden("f_no_reg",$d2["no_reg"]);
					    $f->hidden("f_tanggal_reg",$d2["tanggal_reg"]);
						$f->hidden("list","pemeriksaan");
					    $f->hidden("mr",$_GET["mr"]);
					    $f->hidden("f_id_poli",$_GET["poli"]);
					    $f->hidden("f_user_id",$_SESSION[uid]);
					    
					  
				}else {
					if($n > 0){
						$ext= "disabled";
					}else {
						$ext = "";
					}
				//---------------------------------------------------------------------------------			
						
					$f = new Form("actions/p_ginekologi.insert.php", "POST", "NAME=Form2");
					$f->hidden("act","new");
					$f->hidden("f_no_reg",$d->id);
					$f->hidden("list","pemeriksaan");
				    $f->hidden("mr",$_GET["mr"]);
				    $f->hidden("f_id_poli",$_GET["poli"]);
				    $f->hidden("f_user_id",$_SESSION[uid]);
			}
				    
				//$f->calendar("tanggal_reg","Tanggal Registrasi",15,15,$d2[1],"Form2","icon/calendar.gif","Pilih Tanggal",$ext);
					
				    echo "<table border=1 width='100%' cellspacing=0 cellpadding=0><tr><td valign=top width='100%'>";
					unset($_SESSION["DOKTER"]["id"]);
				    echo "<table border=1 width='100%' cellspacing=0 cellpadding=0><tr><td valign=top width='33%'>";
					echo "<table width='100%' border='0' cellspacing=0 cellpadding=0><tr><td>";
					//untuk dokter
					if (isset($_SESSION["SELECT_EMP"])) {
    					$_SESSION["DOKTER"]["id"] = $_SESSION["SELECT_EMP"];
    					$_SESSION["DOKTER"]["nama"] =
        				getFromTable(
                                        "select nama from rs00017 where id = '".$_SESSION["DOKTER"]["id"]."'");
			            
                                        $f->textAndButton3("f_id_dokter","Dokter Pemeriksa",2,10,$_SESSION["DOKTER"]["id"],$ext,"nm2",30,70,$_SESSION["DOKTER"]["nama"],$ext,"...",$ext,"OnClick='selectPegawai();';");	
			            
    					//unset($_SESSION["SELECT_EMP"]);
					}elseif ($d2["id_dokter"] != '') {
							$f->textAndButton3("f_id_dokter","Dokter Pemeriksa",2,10,$d2["id_dokter"],$ext,"nm2",30,70,$d2["nama"],$ext,"...",$ext,"OnClick='selectPegawai();';");
					}else{
						$f->textAndButton3("f_id_dokter","Dokter Pemeriksa",2,10,0,$ext,"nm2",30,70,$d2["nama"],$ext,"...",$ext,"OnClick='selectPegawai();';");
					}
					//untuk perawat
                                        if (isset($_SESSION["SELECT_EMP2"])) {
    					$_SESSION["PERAWAT"]["id"] = $_SESSION["SELECT_EMP2"];
    					$_SESSION["PERAWAT"]["nama"] =
        				getFromTable(
                                        "select nama from rs00017 where id = '".$_SESSION["PERAWAT"]["id"]."'");
			            
                                        $f->textAndButton3("f_id_perawat","Perawat",2,10,$_SESSION["PERAWAT"]["id"],$ext,"nm3",30,70,$_SESSION["PERAWAT"]["nama"],$ext,"...",$ext,"OnClick='selectPegawai2();';");	
			            
    					//unset($_SESSION["SELECT_EMP2"]);
					}elseif ($d2["id_perawat"] != '') {
						$f->textAndButton3("f_id_perawat","Perawat",2,10,$d2["id_perawat"],$ext,"nm3",30,70,$d2["perawat"],$ext,"...",$ext,"OnClick='selectPegawai2();';");
					}else{
						$f->textAndButton3("f_id_perawat","Perawat",2,10,0,$ext,"nm3",30,70,$d2["perawat"],$ext,"...",$ext,"OnClick='selectPegawai2();';");
					}

					
			$f->text_ginekologi("<U>PEMERIKSAAN UMUM</U>","f_vis_1",$visit_ginekologi["vis_1"],15,30,ucfirst($d2["vis_1"]),"","f_vis_2",$visit_ginekologi["vis_2"],7,10,ucfirst($d2["vis_2"]),"Cm","f_vis_3",$visit_ginekologi["vis_3"],7,10,$d2["vis_3"],"mm Hg","f_vis_4",$visit_ginekologi["vis_4"],7,10,$d2["vis_4"],"&deg;C",
				    	"f_vis_5",$visit_ginekologi["vis_5"],15,30,$d2["vis_5"],"","f_vis_6",$visit_ginekologi["vis_6"],7,10,$d2["vis_6"],"Kg","f_vis_7",$visit_ginekologi["vis_7"],15,30,$d2["vis_7"],"","f_vis_8",$visit_ginekologi["vis_8"],7,10,$d2["vis_8"],"/Menit",$ext);
			if ($d2["vis_9"] != ''){
				$f->checkbox_1("check1","CHECKED",$visit_ginekologi["vis_9"],$visit_ginekologi["vis_9"],$ext);
			}else {
				$f->checkbox_1("check1","",$visit_ginekologi["vis_9"],$visit_ginekologi["vis_9"],$ext);
			}
			if ($d2["vis_10"] != ''){
				$f->checkbox_1("check2","CHECKED",$visit_ginekologi["vis_10"],$visit_ginekologi["vis_10"],$ext);
			}else {
				$f->checkbox_1("check2","",$visit_ginekologi["vis_10"],$visit_ginekologi["vis_10"],$ext);
			}
			if ($d2["vis_11"] != ''){
				$f->checkbox_1("check3","CHECKED",$visit_ginekologi["vis_11"],$visit_ginekologi["vis_11"],$ext);
			}else {
				$f->checkbox_1("check3","",$visit_ginekologi["vis_11"],$visit_ginekologi["vis_11"],$ext);
			}
			if ($d2["vis_12"] != ''){
				$f->checkbox_1("check4","CHECKED",$visit_ginekologi["vis_12"],$visit_ginekologi["vis_12"],$ext);
			}else {
				$f->checkbox_1("check4","",$visit_ginekologi["vis_12"],$visit_ginekologi["vis_12"],$ext);
			}
			if ($d2["vis_13"] != ''){
				$f->checkbox_1("check5","CHECKED",$visit_ginekologi["vis_13"],$visit_ginekologi["vis_13"],$ext);
			}else {
				$f->checkbox_1("check5","",$visit_ginekologi["vis_13"],$visit_ginekologi["vis_13"],$ext);
			}
			if ($d2["vis_14"] != ''){
				$f->checkbox_1("check6","CHECKED",$visit_ginekologi["vis_14"],$visit_ginekologi["vis_14"],$ext);
			}else {
				$f->checkbox_1("check6","",$visit_ginekologi["vis_14"],$visit_ginekologi["vis_14"],$ext);
			}
			
			 	
			$f->text_x3("<U>BENJOLAN / TUMOR LOKASI</U>","f_vis_24",ucfirst($d2["vis_24"]),"f_vis_25",ucfirst($d2["vis_25"]),"f_vis_26",ucfirst($d2["vis_26"]),"f_vis_27",ucfirst($d2["vis_27"]),"f_vis_28",ucfirst($d2["vis_28"]),"f_vis_29",ucfirst($d2["vis_29"]),"f_vis_30",ucfirst($d2["vis_30"]),"f_vis_31",ucfirst($d2["vis_31"]),"f_vis_32",ucfirst($d2["vis_32"]),"f_vis_33",ucfirst($d2["vis_33"]),"f_vis_34",ucfirst($d2["vis_34"]),"f_vis_35",ucfirst($d2["vis_35"]),"f_vis_36",ucfirst($d2["vis_36"]),"f_vis_37",ucfirst($d2["vis_37"]),"f_vis_38",ucfirst($d2["vis_38"]),"f_vis_39",ucfirst($d2["vis_39"]),$ext);
			$f->textarea("f_vis_40",$visit_ginekologi["vis_40"] ,1, $visit_ginekologi["vis_40"."W"],ucfirst($d2["vis_40"]),$ext);
			echo"</td>";
			echo "<tr><td width='20%'><br><br><br><br><br><br><br><IMG BORDER=0 SRC='images/bg_tbh_12.gif'><br><br><br><br><br><br><br><br><br><br>";
			echo"<IMG BORDER=0 SRC='images/bg_tbh_07.gif'><br>";
			echo "<IMG BORDER=0 SRC='images/bg_tbh_10.gif'><br>";
	 		echo "<IMG BORDER=0 SRC='images/bg_tbh_09.gif'>";
	 		echo "<IMG BORDER=0 SRC='images/bg_tbh_08.gif'><br>";
	 		echo "<IMG BORDER=0 SRC='images/bg_tbh_11.gif'>";
	 		echo"</td>";
	 		echo "<td valign='top'>";
	 		$f->title1("<U>PORSIO</U>","");
	
			if ($d2["vis_42"] != ''){
				$f->checkbox_1("check7","CHECKED",$visit_ginekologi["vis_42"],$visit_ginekologi["vis_42"],$ext);
			}else {
				$f->checkbox_1("check7","",$visit_ginekologi["vis_42"],$visit_ginekologi["vis_42"],$ext);
			}
			if ($d2["vis_43"] != ''){
				$f->checkbox_1("check8","CHECKED",$visit_ginekologi["vis_43"],$visit_ginekologi["vis_43"],$ext);
			}else {
				$f->checkbox_1("check8","",$visit_ginekologi["vis_43"],$visit_ginekologi["vis_43"],$ext);
			}
			if ($d2["vis_44"] != ''){
				$f->checkbox_1("check9","CHECKED",$visit_ginekologi["vis_44"],$visit_ginekologi["vis_44"],$ext);
			}else {
				$f->checkbox_1("check9","",$visit_ginekologi["vis_44"],$visit_ginekologi["vis_44"],$ext);
			}
			if ($d2["vis_45"] != ''){
				$f->checkbox_1("check10","CHECKED",$visit_ginekologi["vis_45"],$visit_ginekologi["vis_45"],$ext);
			}else {
				$f->checkbox_1("check10","",$visit_ginekologi["vis_45"],$visit_ginekologi["vis_45"],$ext);
			}
			
	 		
			/*$f->checkbox_5("PEMERIKSAAN GINEKOLOGI","<b>Porsio</b>","f_vis_41",$visit_ginekologi["vis_41"],$visit_ginekologi["vis_41"],"f_vis_42",$visit_ginekologi["vis_42"],$visit_ginekologi["vis_42"],
			"f_vis_43",$visit_ginekologi["vis_43"],$visit_ginekologi["vis_43"],"f_vis_44",$visit_ginekologi["vis_44"],$visit_ginekologi["vis_44"],
			"f_vis_45",$visit_ginekologi["vis_45"],$visit_ginekologi["vis_45"]);*/
			$f->text_x1("Ukuran Tumor","f_vis_46",$d2["vis_46"],"f_vis_47",$d2["vis_47"],"f_vis_48",(ucfirst($d2["vis_48"])),$ext);
	 		$f->textarea("f_vis_49",$visit_ginekologi["vis_49"],1,$visit_ginekologi["vis_49"."W"],ucfirst($d2["vis_49"]),$ext);
	 		$f->textinfo("f_vis_50",$visit_ginekologi["vis_50"],10,10,$d2["vis_50"],"Cm",$ext);
			$f->textarea("f_vis_51",$visit_ginekologi["vis_51"],1,$visit_ginekologi["vis_51"."W"],ucfirst($d2["vis_51"]),$ext);
			$f->textinfo("f_vis_52",$visit_ginekologi["vis_52"],30,30,$d2["vis_52"],"",$ext);
			$f->textinfo("f_vis_53",$visit_ginekologi["vis_53"],10,10,$d2["vis_53"],"g%",$ext);
			$f->textinfo("f_vis_54",$visit_ginekologi["vis_54"],10,10,$d2["vis_54"],"/mm3",$ext);
			   
			$f->submitAndCancel("Simpan",$ext,"Batal","window.history.back()",$ext);
			$f->execute();
			echo"</div>";
			
    	
    }
    
    //pemeriksaan
    
    echo "</div>";
    
	     echo "\n<script language='JavaScript'>\n";
	    echo "function selectLayanan() {\n";
	   	echo "    sWin = window.open('popup/layanan.php', 'xWin', 'top=0,left=0,width=600,height=400,menubar=no,scrollbars=yes');\n";
	    echo "    sWin.focus();\n";
	    echo "}\n";
        echo "function selectPegawai(tag) {\n";
        echo "    sWin = window.open('popup/pegawai.php?tag=' + tag, 'xWin',".
             " 'top=0,left=0,width=500,height=400,menubar=no,scrollbars=yes');\n";
        echo "    sWin.focus();\n";
        echo "}\n";


		/* Untuk Layanan Paket             */
		/* Agung Sunandar 16:53 26/06/2012 */
	    //echo "\n<script language='JavaScript'>\n";
	    echo "function selectLayanan2() {\n";
	   	echo "    sWin = window.open('popup/layanan_paket.php', 'xWin', 'top=0,left=0,width=600,height=400,menubar=no,scrollbars=yes');\n";
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
   		
} else {
	//update tab pasien App.25-11-07
	echo"<br>";
	$tab_disabled = array("tab1"=>true, "tab2"=>true);
	$T1 = new TabBar();
	$T1->addTab("$SC?p=$PID&list2=tab1&list=layanan", "Daftar Pasien Konsul"	, $tab_disabled["tab1"]);
	$T1->addTab("$SC?p=$PID&list2=tab2&list=layanan", "Daftar Pasien Klinik"	, $tab_disabled["tab2"]);

    if($_GET['list2']=="tab1") {
    	$T1->show(0);
    $ext = "OnChange = 'Form1.submit();'";
    $f = new Form($SC, "GET", "NAME=Form1");
    $f->PgConn = $con;
    $f->hidden("p", $PID);
    $f->hidden("poli",$_GET["mPOLI"]);
    $f->hidden("list2",tab1);
   
   		echo "<div align='right' valign='middle'>";	
		$f = new Form($SC, "GET","NAME=Form4");
	    $f->hidden("p", $PID);
	    $f->hidden("list2","tab1");
	    if (!$GLOBALS['print']){
	    	$f->search("search","Pencarian",20,20,$_GET["search"],"icon/ico_find.gif","Cari","OnChange='Form4.submit();'");
	    //	title_excel("p_ginekologi&tblstart=".$_GET['tblstart']);
		}else { 
		   	$f->search("search","Pencarian",20,20,$_GET["search"],"icon/ico_find.gif","Cari","disabled");
		   //	title_excel("p_ginekologi&tblstart=".$_GET['tblstart']);
		}
	    $f->execute();
    	if ($msg) errmsg("Error:", $msg);
    	echo "</div>";
		//---------------------
		echo "<br>";
		
	$SQLSTR = 	"select distinct a.mr_no,a.id,upper(a.nama)as nama,a.alm_tetap,a.pangkat_gol,a.nrp_nip,a.kesatuan,a.tdesc,c.tdesc,
	a.statusbayar
				from rsv_pasien4 a 
				left join c_visit b on b.no_reg = a.id
				left join rs00001 c on c.tc = b.id_poli and c.tt='LYN'
				WHERE b.id_konsul='".$_GET["mPOLI"]."'";
		// 24-12-2006 --> tambahan 'where is_bayar = 'N'
		//status_akhir,rawatan di query sementara di tutup
        
		$tglhariini = date("Y-m-d", time());
    if (strlen($_GET["mPOLI"]) > 0 ) {
		$SQLWHERE =
			"AND".
			"	(UPPER(a.NAMA) LIKE '%".strtoupper($_GET["search"])."%') ";
	}
	if ($_GET["search"]) {
		$SQLWHERE =
			"and (upper(a.nama) LIKE '%".strtoupper($_GET["search"])."%' or a.id like '%".$_GET['search']."%' or a.mr_no like '%".$_GET["search"]."%' ".
					" or upper(a.pangkat_gol) like '%".strtoupper($_GET["search"])."%' or a.nrp_nip like '%".$_GET['search']."%' ".
					" or upper(a.kesatuan) like '%".strtoupper($_GET["search"])."%' ) ";
	}
	if (!isset($_GET[sort])) {

           $_GET[sort] = "a.id";
           $_GET[order] = "asc";
	}
	$rstr=pg_query($con, "$SQLSTR $SQLWHERE ");
   // $n = pg_num_rows($rstr);		    	
	$dstr = pg_fetch_array($rstr); 
	   	$t = new PgTable($con, "100%");
	    $t->SQL = "$SQLSTR $SQLWHERE ";
	    $t->setlocale("id_ID");
	    $t->ShowRowNumber = true;
	    $t->ColAlign = array("CENTER","CENTER","LEFT","LEFT","LEFT","CENTER","LEFT","LEFT","LEFT","LEFT","LEFT");	
	    $t->RowsPerPage = $ROWS_PER_PAGE;
	    $t->ColFormatHtml[2] = "<A CLASS=SUB_MENU1 HREF='$SC?p=$PID&rg=<#1#>&mr=<#0#>&poli={$_GET["mPOLI"]}&list=layanan'><#2#>";
	    //(awal)$t->ColFormatHtml[8] = "<A HREF='$SC?p=$PID&rg=<#1#>&mr=<#0#>&poli={$_GET["mPOLI"]}&act=periksa'><INPUT NAME='submitButton' TYPE=SUBMIT VALUE='Periksa' >";
	   	//$t->ColHeader = array("NO.MR", "NO<br>REGISTRASI","TANGGAL  REG","WAKTU REG","NAMA PASIEN","PANGKAT","NRP/NIP","KESATUAN","LOKET","TIPE PASIEN","STATUS");
	   	$t->ColHeader = array("NO.MR", "NO<br>REGISTRASI","NAMA PASIEN","ALAMAT","PANGKAT","NRP/NIP","KESATUAN","TIPE PASIEN","UNIT ASAL","STATUS");
	    $t->ColColor[7] = "color";
	    //$t->ColRowSpan[2] = 2;
	    $t->execute();
	    echo"<br><div class=NOTE>Catatan : Daftar pasien di urut berdasarkan no antrian</div><br>";	
    }else{
    	$T1->show(1);	
    $ext = "OnChange = 'Form1.submit();'";
    $f = new Form($SC, "GET", "NAME=Form1");
    $f->PgConn = $con;
    $f->hidden("p", $PID);
    $f->hidden("poli",$_GET["mPOLI"]);
   
   		echo "<div align='right' valign='middle'>";	
		$f = new Form($SC, "GET","NAME=Form2");
	    $f->hidden("p", $PID);
	    $f->hidden("list2","tab2");
	    if (!$GLOBALS['print']){
	    	$f->search("search","Pencarian",20,20,$_GET["search"],"icon/ico_find.gif","Cari","OnChange='Form2.submit();'");
	    	//title_excel("p_ginekologi&tblstart=".$_GET['tblstart']);
		}else { 
		   	$f->search("search","Pencarian",20,20,$_GET["search"],"icon/ico_find.gif","Cari","disabled");
		   	//title_excel("p_ginekologi&tblstart=".$_GET['tblstart']);
		}
	    $f->execute();
    	if ($msg) errmsg("Error:", $msg);
    	echo "</div>";
		//---------------------
		echo "<br>";
		
	$SQLSTR = 	"select distinct a.mr_no,a.id,upper(a.nama)as nama,a.alm_tetap,a.pangkat_gol,a.nrp_nip,a.kesatuan,a.tdesc,
				a.statusbayar
				from rsv_pasien4 a 
				left join c_visit b on b.no_reg = a.id
				WHERE a.poli='".$_GET["mPOLI"]."'";
		// 24-12-2006 --> tambahan 'where is_bayar = 'N'
		//status_akhir,rawatan di query sementara di tutup
        
		$tglhariini = date("Y-m-d", time());
    if (strlen($_GET["mPOLI"]) > 0 ) {
		$SQLWHERE =
			"AND a.TANGGAL_REG = '$tglhariini' AND".
			"	(UPPER(a.NAMA) LIKE '%".strtoupper($_GET["search"])."%') ";
	}
	if ($_GET["search"]) {
		$SQLWHERE =
			"and (upper(a.nama) LIKE '%".strtoupper($_GET["search"])."%' or a.id like '%".$_GET['search']."%' or a.mr_no like '%".$_GET["search"]."%' ".
					" or upper(a.pangkat_gol) like '%".strtoupper($_GET["search"])."%' or a.nrp_nip like '%".$_GET['search']."%' ".
					" or upper(a.kesatuan) like '%".strtoupper($_GET["search"])."%' ) ";
	}
	if (!isset($_GET[sort])) {

           $_GET[sort] = "a.id";
           $_GET[order] = "asc";
	}
	$rstr=pg_query($con, "$SQLSTR $SQLWHERE ");
   // $n = pg_num_rows($rstr);		    	
	$dstr = pg_fetch_array($rstr); 
	   	$t = new PgTable($con, "100%");
	    $t->SQL = "$SQLSTR $SQLWHERE ";
	    $t->setlocale("id_ID");
	    $t->ShowRowNumber = true;
	    $t->ColAlign = array("CENTER","CENTER","LEFT","LEFT","LEFT","CENTER","LEFT","LEFT","LEFT","LEFT","LEFT");	
	    $t->RowsPerPage = $ROWS_PER_PAGE;
	    $t->ColFormatHtml[2] = "<A CLASS=SUB_MENU1 HREF='$SC?p=$PID&rg=<#1#>&mr=<#0#>&poli={$_GET["mPOLI"]}&list=layanan'><#2#>";
	    //(awal)$t->ColFormatHtml[8] = "<A HREF='$SC?p=$PID&rg=<#1#>&mr=<#0#>&poli={$_GET["mPOLI"]}&act=periksa'><INPUT NAME='submitButton' TYPE=SUBMIT VALUE='Periksa' >";
	   	//$t->ColHeader = array("NO.MR", "NO<br>REGISTRASI","TANGGAL  REG","WAKTU REG","NAMA PASIEN","PANGKAT","NRP/NIP","KESATUAN","LOKET","TIPE PASIEN","STATUS");
	   	$t->ColHeader = array("NO.MR", "NO<br>REGISTRASI","NAMA PASIEN","ALAMAT","PANGKAT","NRP/NIP","KESATUAN","TIPE PASIEN","STATUS");
	    $t->ColColor[6] = "color";
	    //$t->ColRowSpan[2] = 2;
	    $t->execute();
	    echo"<br><div class=NOTE>Catatan : Daftar pasien di urut berdasarkan no antrian</div><br>";
    }
	
}
  
?>