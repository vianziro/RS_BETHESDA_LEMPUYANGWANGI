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
$PID = "p_operasi";
$SC = $_SERVER["SCRIPT_NAME"];

require_once("startup.php");
require_once("lib/visit_setting.php");
//--fungsi column color-------------- Agung Sunandar 22:58 26/06/2012
function color( $dstr, $r ) {

	    if($_GET['list2']=="tab1"){
	    	if ($dstr[8] == 'BELUM ADA TAGIHAN' ){
	    		return "<font color=red><b>{$dstr[$r]}</b></font>";
	    	}else{
	    		return "<font color=blue><b>{$dstr[$r]}</b></font>";
	    	}
	    }else{
	    	if ($dstr[7] == 'BELUM ADA TAGIHAN' ){
	    		return "<font color=red><b>{$dstr[$r]}</b></font>";
	    	}else{
	    		return "<font color=blue><b>{$dstr[$r]}</b></font>";
	    	}
	    }
}
//-------------------------------       	
$_GET["mPOLI"]=$setting_poli["operasi"];
$rg = isset($_GET["rg"])? $_GET["rg"] : $_POST["rg"];
$mr = isset($_GET["mr"])? $_GET["mr"] : $_POST["mr"];
// Tambahan BHP
$POLI=$setting_poli["operasi"];
// ======================================


include ("session.php");

echo "<table border=0 width='100%'><tr><td>";
title("<img src='icon/rawat-jalan-2.gif' align='absmiddle' >  LAYANAN OPERASI");
echo "</td></tr></table>";

unset($_GET["layanan"]);

$reg = $_GET["rg"];
$reg2 = $_GET["rg"];

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
        $f = new Form("actions/p_operasi.insert.php");
        $f->hidden("rg",$_GET["rg"]);
        $f->hidden("mr",$_GET["mr"]);
        $f->hidden("poli",$_GET["poli"]);
	$f->hidden("sub",$_GET["sub"]);
        $f->hidden("byr",$total);
        //$f->text("byr","Jumlah Pembayaran",15,15,$total,"STYLE='text-align:right'");
        $f->submit(" Simpan &amp; Bayar ");
        $f->execute();
    
} 
elseif ($_GET["list"] == "input_operasi") {  // -------- OPERASI
		if(!$GLOBALS['print']){
		$T->show(1);
		}else{}
        include("operasi.php");
        
    }
elseif ($_GET["list"] == "icd") {  // -------- ICD
		if(!$GLOBALS['print']){
		$T->show(3);
		}else{}
		
        include ("icd.php");
	
        include("rincian3.php");
        
    }elseif ($_GET["list"] == "icd9") {  // -------- ICD 9
        if (!$GLOBALS['print']) {
            $T->show(4);
        } else {
            
        }

        include ("icd9.php");

        include("rincian3.php");
    }elseif ($_GET["list"] == "layanan") { // ----------------------------- LAYANAN MEDIS
    	if(!$GLOBALS['print']){
    	$T->show(2);
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
    	$T->show(5);
    	}else{}
    	if ($_GET["act"] == "detail") {
				$sql = "select a.*,	to_char(a.tanggal_reg,'dd Month yyyy')as tanggal_reg,f.layanan, 
						b.nama as dokter_periksa,
						g.nama as operator1,
						h.nama as operator2,
						i.nama as asisten1,
						j.nama as asisten2,
						k.nama as asisten3,
						l.nama as asisten4,
						m.nama as anestesi1,
						n.nama as anestesi2,
						o.nama as anestesi3,
						p.nama as anestesi4
						from c_visit_operasi a 
						left join rs00017 b on a.id_dokter = b.id 
						left join rs00017 g on a.id_operator1 = g.id 
						left join rs00017 h on a.id_operator2 = h.id 
						left join rs00017 i on a.id_asisten1 = i.id 
						left join rs00017 j on a.id_asisten2 = j.id 
						left join rs00017 k on a.id_asisten3 = k.id 
						left join rs00017 l on a.id_asisten4 = l.id 
						left join rs00017 m on a.id_anestesi1 = m.id 
						left join rs00017 n on a.id_anestesi2 = n.id 
						left join rs00017 o on a.id_anestesi3 = o.id 
						left join rs00017 p on a.id_anestesi4 = p.id 
						left join rsv0002 c on a.no_reg=c.id 
						left join rs00006 d on d.id = a.no_reg
						left join rs00008 e on e.no_reg = a.no_reg
						left join rs00034 f on 'f.id' = e.item_id
						where a.no_reg='{$_GET['rg']}' and a.id_poli='".$_GET["mPOLI"]."' ";
				$r = pg_query($con,$sql);
				$n = pg_num_rows($r);
			    if($n > 0) $d = pg_fetch_array($r);
			    pg_free_result($r);
				//echo $sql;exit;			
			    $_GET['id'] = $_GET['rg'] ;	
	 			
			echo "<div class=box>";
			echo "<table width='100%' border='0'><tr><td colspan='2'>";
			echo "<div class=form_subtitle>PEMERIKSAAN PASIEN</div>";
			echo "</td></tr>";
    			echo "<tr><td valign=top>";
			$f = new ReadOnlyForm();
			$f->text("Tanggal Pemeriksaan","<b>".$d["tanggal_reg"]);
			$f->title1("<U>DOKTER PEMERIKSA</U>","LEFT");
			$f->text("Dokter Pemeriksa",$d["dokter_periksa"]);
			$f->text("Operator 1",$d["operator1"]);
			$f->text("Operator 2",$d["operator2"]);
			$f->text("Asisten 1",$d["asisten1"]);
			$f->text("Asisten 2",$d["asisten2"]);
			$f->text("Asisten 3",$d["asisten3"]);
			$f->text("Asisten 4",$d["asisten4"]);
			$f->text("Petugas Anastesi 1",$d["anestesi1"]);
			$f->text("Petugas Anastesi 2",$d["anestesi2"]);
			$f->text("Petugas Anastesi 3",$d["anestesi3"]);
			$f->text("Petugas Anastesi 4",$d["anestesi4"]);
            $f->title1("<U>PEMERIKSAAN</U>","LEFT");
			$f->text($visit_operasi["vis_1"],$d[3] );
			$f->text($visit_operasi["vis_2"],$d[4]);
			$f->text($visit_operasi["vis_3"],$d[5]);
			$f->text($visit_operasi["vis_4"],$d[6] );
			echo "</td><td valign=top>";
			$f->title1("<U>DIAGNOSA</U>","LEFT");	
			$f->text($visit_operasi["vis_5"],$d[7] );
			$f->text($visit_operasi["vis_6"],$d[8] );
			$f->text($visit_operasi["vis_7"],$d[9]);
			$f->text($visit_operasi["vis_8"],$d[10]);
			$f->text($visit_operasi["vis_9"],$d[11]);
			$f->text($visit_operasi["vis_10"],$d[12] );
			
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
				$sql = "SELECT A.NO_REG,TO_CHAR(A.TANGGAL_REG,'DD MON YYYY')AS TANGGAL,TO_CHAR(A.TANGGAL_REG,'HH:MM:SS') AS WAKTU,C.NAMA,'DUMMY' ". 
					   "FROM C_VISIT_OPERASI A ".
					   "LEFT JOIN RS00006 B ON A.NO_REG=B.ID ".
                       "LEFT JOIN RS00017 C ON A.ID_OPERATOR1=C.ID ".
					   "WHERE B.MR_NO = '".$_GET["mr"]."' AND A.ID_POLI = '{$_GET["mPOLI"]}' ";
				$t = new PgTable($con, "100%");
			    $t->SQL = $sql ;
			    $t->setlocale("id_ID");
			    $t->ShowRowNumber = true;
			   	//$t->ColHidden[4]= true;
			    $t->RowsPerPage = $ROWS_PER_PAGE;
			    $t->ColHeader = array("NO REGISTRASI","TANGGAL PEMERIKSAAN","WAKTU KUNJUNGAN","OPERATOR","DETAIL");
			   	$t->ColAlign = array("center","center","center","left","center");
				$t->ColFormatHtml[4] = "<A CLASS=TBL_HREF HREF='$SC?p=$PID&list=riwayat&act=detail&mr=".$_GET["mr"]."&rg=<#0#>'>".icon("view","View")."</A>";	
				$t->execute();
				
				echo"<br>";
         		echo"</div>";
				echo "</td></tr></table></div>";
    	
			}
    }elseif($_GET["list"] == "riwayat_klinik") {
    	if(!$GLOBALS['print']){
    	$T->show(6);
    	}else{}
    	if ($_GET["act"] == "detail_klinik") {
				$sql = "select a.*,b.nama,to_char(a.tanggal_reg,'dd Month yyyy')as tanggal_reg,f.layanan,a.id_poli 
						from c_visit a 
						left join rs00017 b on a.id_dokter = B.ID 
						left join rsv0002 c on a.no_reg=c.id 
						left join rs00006 d on d.id = a.no_reg
						left join rs00008 e on e.no_reg = a.no_reg
						left join rs00034 f on f.id::text = e.item_id::text
						where a.no_reg='{$_GET['rg']}' and a.oid='{$_GET['oid']}'";
                                    
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
    		$poli=$_GET["polinya"];
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
			}elseif ($poli == $setting_poli["gizi"]){
    			include(detail_gizi);
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
    		elseif ($poli == $setting_poli["psikiatri"]){
    			include(detail_psikiatri);
    		}
    		elseif ($poli == $setting_poli["laboratorium"]){
    			include(detail_laboratorium);
    		}
                elseif ($poli == $setting_poli["operasi"]){
    			include(detail_operasi);
			}
    		elseif ($poli == $setting_poli["saraf"]){
    			include(detail_saraf);
    		}
    		elseif ($poli == $setting_poli["radiologi"]){
    			include(detail_radiologi);
    		}
                elseif ($poli == "A01"){
    			include(detail_resume_anak);
    		}
                elseif ($poli == "A01"){
    			include(detail_resume_anak);
    		}
                elseif ($poli == "A02"){
    			include(detail_resume_kebidanan);
    		}
                elseif ($poli == "A03"){
    			include(detail_resume_bayi);
    		}
                elseif ($poli == "B01"){
    			include(detail_grafik_suhu);
    		}
                elseif ($poli == "B02"){
    			include(detail_grafik_ibu);
    		}
                elseif ($poli == "B03"){
    			include(detail_grafik_bayi);
    		}
                elseif ($poli == "C03"){
    			include(detail_ringkasan_masuk_keluar);
    		}
                elseif ($poli == "D04"){
    			include(detail_dokumen_surat_pengantar);
    		}
                elseif ($poli == "E05"){
    			include(detail_riwayat_penyakit);
    		}
                elseif ($poli == "F01"){
    			include(detail_catatan_kebidanan);
    		}
                elseif ($poli == "F02"){
    			include(detail_catatan_bayi_baru);
    		}
                elseif ($poli == "F03"){
    			include(detail_catatan_harian);
    		}
                elseif ($poli == "G02"){
    			include(detail_catatan_laporan_pembedahan);
    		}
                elseif ($poli == "K02"){
    			include(detail_hasil_radiologi);
    		}
                elseif ($poli == "J10"){
    			include(detail_lembar_konsultasi);
    		}
                elseif ($poli == "G03"){
    			include(detail_alat_pembedahan);
    		}
                elseif ($poli == "I02"){
    			include(detail_pasien_anak);
    		}
                elseif ($poli == "F04"){
    			include(detail_catatan_perkembangan_bayi);
                }
                elseif ($poli == "K03"){
    			include(detail_hasil_ekg);
                }
                 elseif ($poli == "I03"){
    			include(detail_obstetri);
                }
                 elseif ($poli == "H03"){
    			include(detail_pemakaian_alat_keperawatan);
                }
                elseif ($poli == "H01"){
    			include(detail_asuhan_keperawatan);
                }
                elseif ($poli == "H03"){
    			include(detail_pengawasan_khusus_pasien_dewasa);
                }
                elseif ($poli == "K01"){
    			include(detail_hasil_labor_patologi);
                }
                elseif ($poli == "K04"){
    			include(detail_hasil_usg);
                }
                elseif ($poli == "I01"){
    			include(detail_pasien_dewasa);
                }
                elseif ($poli == "H02"){
       			include(detail_catatan_proses_keperawatan);
                }
				elseif ($poli == "205"){
       			include(detail_fisioterapi);
				}
               
    		else{
                    
    			include(detail_laboratorium);
    		}
    		
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
					   "WHERE B.MR_NO = '".$_GET["mr"]."' AND A.ID_POLI != 100
                        GROUP BY A.NO_REG,A.TANGGAL_REG,C.TDESC,D.NAMA,A.ID_POLI,a.oid
						union 
						SELECT A.NO_REG,TO_CHAR(A.TANGGAL_REG,'DD MON YYYY')AS TANGGAL,TO_CHAR(A.TANGGAL_REG,'HH:MM:SS') AS WAKTU,'RAWAT INAP - '||C.TDESC,D.NAMA,A.ID_RI,a.oid
						FROM C_VISIT_RI A 
						LEFT JOIN RS00006 B ON A.NO_REG=B.ID 
						LEFT JOIN RS00001 C ON A.ID_RI::text = C.TC::text AND C.TT='LRI'
						LEFT JOIN RS00017 D ON A.ID_DOKTER = D.ID 
						WHERE B.MR_NO = '".$_GET["mr"]."' AND A.ID_RI::text != 100::text
						GROUP BY A.NO_REG,A.TANGGAL_REG,C.TDESC,D.NAMA,A.ID_RI,a.oid
						union 
						SELECT A.NO_REG,TO_CHAR(A.TANGGAL_REG,'DD MON YYYY')AS TANGGAL,TO_CHAR(A.TANGGAL_REG,'HH:MM:SS') AS WAKTU,'PELAYANAN OPERASI',D.NAMA,'209',a.oid
						FROM C_VISIT_OPERASI A 
						LEFT JOIN RS00006 B ON A.NO_REG=B.ID 
						LEFT JOIN RS00017 D ON A.ID_DOKTER = D.ID 
						WHERE B.MR_NO = '".$_GET["mr"]."'
						GROUP BY A.NO_REG,A.TANGGAL_REG,D.NAMA,a.oid
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
				$t->ColFormatHtml[6] = "<A CLASS=TBL_HREF HREF='$SC?p=$PID&list=riwayat_klinik&act=detail_klinik&polinya=<#5#>&mr=".$_GET["mr"]."&rg=<#0#>&oid=<#6#>'>".icon("view","View")."</A>";	
				$t->execute();
				
				echo"<br>";
         		echo"</div>";
				echo "</td></tr></table></div>";
    	
			}
			}elseif ($_GET["list"] == "unit_rujukan"){
    	$T->show(7);
    	echo"<br>";
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
    
    	//$laporan = getFromTable("select tdesc from rs00001 where tt='LRI' and tc = '".$_SESSION[SELECT_LAP]."'");
    	$f = new Form("actions/p_operasi.insert.php", "POST", "NAME=Form2");
					$f->hidden("act","new1");
					$f->hidden("f_no_reg",$d->id);
					$f->hidden("list","unit_rujukan");
				    $f->hidden("mr",$_GET["mr"]);
				    $f->hidden("f_tanggal_reg",$d2["tanggal_reg"]);
				    $f->hidden("f_id_poli",$_GET["poli"]);
				    $f->hidden("f_user_id",$_SESSION[uid]);
				    $f->hidden("status_akhir",$_GET["status_akhir"]);
				    
					echo"<br>";
					$tipe = getFromTable("select status_akhir_pasien from rs00006 where id='".$_GET["rg"]."'");
				    $f->PgConn=$con;
					$f->selectSQL("status_akhir","Status Akhir Pasien", "select '' as tc, '' as tdesc union select tc , tdesc from rs00001 where tt='SAP' and tc not in ('000')", $tipe,$ext);
				    $f->submitAndCancel("Simpan",$ext,"Batal","window.history.back()",$ext);
				    $f->execute();
				    
}
				        	
    }elseif ($_GET["list"] == "konsultasi"){
    	$T->show(8);
    	echo"<br>";
    	
    	//$laporan = getFromTable("select tdesc from rs00001 where tt='LRI' and tc = '".$_SESSION[SELECT_LAP]."'");
    	$f = new Form("actions/p_operasi.insert.php", "POST", "NAME=Form2");
				    $f->hidden("act","new2");
				    $f->hidden("f_no_reg",$d->id);
				    $f->hidden("list","konsultasi");
				    $f->hidden("mr",$_GET["mr"]);
				    $f->hidden("f_id_poli",$_GET["poli"]);
				    $f->hidden("f_tanggal_reg",$d2["tanggal_reg"]);
				    $f->hidden("f_user_id",$_SESSION[uid]);
				    $f->hidden("konsultasi",$_GET["konsultasi"]);
				    
					echo"<br>";
					$konsul = getFromTable("select id_konsul from c_visit_operasi where no_reg='".$_GET["rg"]."' and id_poli='".$_GET["poli"]."'");
				    $f->PgConn=$con;
				    $f->selectSQL("konsultasi","Unit Yang Dituju", "select tc,tdesc from rs00001 where tt='LYN' and tc not in ('000','100','201','202','206','207','208') order by tdesc",$konsul,$ext);
				    $f->submitAndCancel("Simpan",$ext,"Batal","window.history.back()",$ext);
				    $f->execute();
					echo "<b>Pasien di Konsul ke Poli:</b><br>";
					$t = new PgTable($con, "100%");
					$t->SQL = "select b.tdesc, a.oid from c_visit_operasi a left join rs00001 b on b.tc=a.id_konsul and b.tt='LYN'  where  a.no_reg='".$_GET[rg]."' and a.id_poli='".$_GET["poli"]."' and a.id_konsul != '' ";
					$t->setlocale("id_ID");
					$t->ShowRowNumber = true;
					$t->ColAlign = array("LEFT","CENTER","LEFT","LEFT","LEFT","CENTER","LEFT","LEFT","LEFT","LEFT","LEFT");	
					$t->RowsPerPage = $ROWS_PER_PAGE;
					$t->ColFormatHtml[1] = "<A CLASS=SUB_MENU1 HREF='actions/p_operasi.delete.php?p=$PID&oid=<#1#>&tbl=konsultasi&mr=".$_GET[mr]."&rg=".$_GET[rg]."&f_id_poli=".$_GET["poli"]."'>". icon("delete","Edit Status pekerjaan")."</A>";
					$t->ColHeader = array("KONSUL KE", "HAPUS");
					$t->execute();
		echo"<br><font color=black>&nbsp;* Catatan : Hasil Pemeriksaan Pasien harus diisi minimal Dokter Pemeriksa</font><br>";
    }elseif ($_GET["list"] == "resepobat"){ //RESEP OBAT
    	$T->show(9);
    	//echo"<br>";
    	
 include ("resep_obat.php");
 
 include("rincianobat.php"); 

				        	
}else {       //pemeriksaan
    	if(!$GLOBALS['print']){
    	$T->show(0);
    	}else{}
    	
    		$sql2 =	"
            SELECT A.*,(B.NAMA) AS DOKTER ,(C.NAMA) AS OPERATOR1,(D.NAMA) AS OPERATOR2,(E.NAMA) AS ASISTEN1,
            (F.NAMA) AS ASISTEN2,(G.NAMA) AS ASISTEN3,(H.NAMA) AS ASISTEN4,(I.NAMA) AS ANESTESI1,
            (J.NAMA) AS ANESTESI2,(K.NAMA) AS ANESTESI3,(L.NAMA) AS ANESTESI4
            FROM C_VISIT_OPERASI A 
		    LEFT JOIN RS00017 B ON A.ID_DOKTER = B.ID
            LEFT JOIN RS00017 C ON A.ID_OPERATOR1 = C.ID
            LEFT JOIN RS00017 D ON A.ID_OPERATOR2 = D.ID
            LEFT JOIN RS00017 E ON A.ID_ASISTEN1 = E.ID
            LEFT JOIN RS00017 F ON A.ID_ASISTEN2 = F.ID
            LEFT JOIN RS00017 G ON A.ID_ASISTEN3 = G.ID
            LEFT JOIN RS00017 H ON A.ID_ASISTEN4 = H.ID
            LEFT JOIN RS00017 I ON A.ID_ANESTESI1 = I.ID
            LEFT JOIN RS00017 J ON A.ID_ANESTESI2 = J.ID
            LEFT JOIN RS00017 K ON A.ID_ANESTESI3 = K.ID
            LEFT JOIN RS00017 L ON A.ID_ANESTESI4 = L.ID
    		WHERE A.ID_POLI={$_GET["mPOLI"]} AND A.NO_REG='$rg'
                    "; 
	    	$r=pg_query($con,$sql2);
	    	$n = pg_num_rows($r);		    	
			    if($n > 0) $d2 = pg_fetch_array($r);
			    pg_free_result($r);
				//-------------------------tambah for update------hery 08072007
				echo "<div align=left><input type=button value=' Edit ' OnClick=\"window.location = './index2.php?p=$PID&rg=$rg&mr={$_GET['mr']}&poli={$_GET["poli"]}&act=edit';\">\n";   
				//echo "<input type='image' src='images/icon-edit.png' action='edit' >";
				    
				if ($_GET['act'] == "edit"){
						echo "<font color='#000000' size='2'> >>Edit Pemeriksaan Pasien</font>";
						$f = new Form("actions/p_operasi.insert.php", "POST", "NAME=Form2");
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
					echo "<table border=1 width='100%' cellspacing=0 cellpadding=0><tr><td valign=top width='33%'>";	
					$f = new Form("actions/p_operasi.insert.php", "POST", "NAME=Form2");
					$f->hidden("act","new");
					$f->hidden("f_no_reg",$d->id);
					$f->hidden("list","pemeriksaan");
				    $f->hidden("mr",$_GET["mr"]);
				    $f->hidden("f_id_poli",$_GET["poli"]);
				    $f->hidden("f_user_id",$_SESSION[uid]);
			}
				    
				//$f->calendar("tanggal_reg","Tanggal Registrasi",15,15,$d2[1],"Form2","icon/calendar.gif","Pilih Tanggal",$ext);
					
				    //echo"<div align=left class=FORM_SUBTITLE1>ANAMNESA PASIEN</div>";
				    
				     if (isset($_SESSION["SELECT_EMP"])) {
    					$_SESSION["DOKTER"]["id"] = $_SESSION["SELECT_EMP"];
    					$_SESSION["DOKTER"]["nama"] =
        				getFromTable(
			            "select nama from rs00017 where id = '".$_SESSION["SELECT_EMP"]."'");
    					$f->textAndButton3("f_id_dokter","Dokter Pemeriksa",2,10,$_SESSION["DOKTER"]["id"],$ext,"nm2",30,70,$_SESSION["DOKTER"]["nama"],$ext,"...",$ext,"OnClick='selectPegawai();';");
			            //unset($_SESSION["SELECT_EMP"]);
					}elseif ($d2["id_dokter"] != '') {
							$f->textAndButton3("f_id_dokter","Dokter Pemeriksa",2,10,$d2["id_dokter"],$ext,"nm2",30,70,$d2["dokter"],$ext,"...",$ext,"OnClick='selectPegawai();';");
					
					}else{
						$f->textAndButton3("f_id_dokter","Dokter Pemeriksa",2,10,0,$ext,"nm2",30,70,$d2["nama"],$ext,"...",$ext,"OnClick='selectPegawai();';");
					}
					
                   if (isset($_SESSION["SELECT_EMP2"])) {
    					$_SESSION["DOKTER"]["id2"] = $_SESSION["SELECT_EMP2"];
    					$_SESSION["DOKTER"]["nama2"] =
        				getFromTable(
			            "select nama from rs00017 where id = '".$_SESSION["DOKTER"]["id2"]."'");
    					$f->textAndButton3("f_id_operator1","Operator 1",2,10,$_SESSION["DOKTER"]["id2"],$ext,"nm3",30,70,$_SESSION["DOKTER"]["nama2"],$ext,"...",$ext,"OnClick='selectPegawai2();';");
			            //unset($_SESSION["SELECT_EMP2"]);
					}elseif ($d2["id_operator1"] != ''){
						$f->textAndButton3("f_id_operator1","Operator 1",2,10,$d2["id_operator1"],$ext,"nm3",30,70,$d2["operator1"],$ext,"...",$ext,"OnClick='selectPegawai2();';");
					}else{
						$f->textAndButton3("f_id_operator1","Operator 1",2,10,0,$ext,"nm2",30,70,$d2["operator1"],$ext,"...",$ext,"OnClick='selectPegawai2();';");
					}
                   if (isset($_SESSION["SELECT_EMP3"])) {
    					$_SESSION["DOKTER"]["id3"] = $_SESSION["SELECT_EMP3"];
    					$_SESSION["DOKTER"]["nama3"] =
        				getFromTable(
			            "select nama from rs00017 where id = '".$_SESSION["DOKTER"]["id3"]."'");
    					$f->textAndButton3("f_id_operator2","Operator 2",2,10,$_SESSION["DOKTER"]["id3"],$ext,"nm4",30,70,$_SESSION["DOKTER"]["nama3"],$ext,"...",$ext,"OnClick='selectPegawai3();';");
			            //unset($_SESSION["SELECT_EMP3"]);
					}elseif ($d2["id_operator2"] != ''){
						$f->textAndButton3("f_id_operator2","Operator 2",2,10,$d2["id_operator2"],$ext,"nm4",30,70,$d2["operator2"],$ext,"...",$ext,"OnClick='selectPegawai3();';");
					}else{
						$f->textAndButton3("f_id_operator2","Operator 2",2,10,0,$ext,"nm2",30,70,$d2["operator2"],$ext,"...",$ext,"OnClick='selectPegawai3();';");
					}
                   if (isset($_SESSION["SELECT_EMP4"])) {
    					$_SESSION["DOKTER"]["id4"] = $_SESSION["SELECT_EMP4"];
    					$_SESSION["DOKTER"]["nama4"] =
        				getFromTable(
			            "select nama from rs00017 where id = '".$_SESSION["DOKTER"]["id4"]."'");
    					$f->textAndButton3("f_id_asisten1","Asisten Anestesi 1",2,10,$_SESSION["DOKTER"]["id4"],$ext,"nm5",30,70,$_SESSION["DOKTER"]["nama4"],$ext,"...",$ext,"OnClick='selectPegawai4();';");
			            //unset($_SESSION["SELECT_EMP2"]);
					}elseif ($d2["id_asisten1"] != ''){
						$f->textAndButton3("f_id_asisten1","Asisten Anestesi 1",2,10,$d2["id_asisten1"],$ext,"nm5",30,70,$d2["asisten1"],$ext,"...",$ext,"OnClick='selectPegawai4();';");
					}else{
						$f->textAndButton3("f_id_asisten1","Asisten Anestesi 1",2,10,0,$ext,"nm2",30,70,$d2["asisten1"],$ext,"...",$ext,"OnClick='selectPegawai4();';");
					}
                   if (isset($_SESSION["SELECT_EMP5"])) {
    					$_SESSION["DOKTER"]["id5"] = $_SESSION["SELECT_EMP5"];
    					$_SESSION["DOKTER"]["nama5"] =
        				getFromTable(
			            "select nama from rs00017 where id = '".$_SESSION["DOKTER"]["id5"]."'");
    					$f->textAndButton3("f_id_asisten2","Asisten 1 Operator",2,10,$_SESSION["DOKTER"]["id5"],$ext,"nm6",30,70,$_SESSION["DOKTER"]["nama5"],$ext,"...",$ext,"OnClick='selectPegawai5();';");
			            //unset($_SESSION["SELECT_EMP2"]);
					}elseif ($d2["id_asisten2"] != ''){
						$f->textAndButton3("f_id_asisten2","Asisten 1 Operator",2,10,$d2["id_asisten2"],$ext,"nm6",30,70,$d2["asisten2"],$ext,"...",$ext,"OnClick='selectPegawai5();';");
					}else{
						$f->textAndButton3("f_id_asisten2","Asisten 1 Operator",2,10,0,$ext,"nm6",30,70,$d2["asisten2"],$ext,"...",$ext,"OnClick='selectPegawai5();';");
					}
                    if (isset($_SESSION["SELECT_EMP6"])) {
    					$_SESSION["DOKTER"]["id6"] = $_SESSION["SELECT_EMP6"];
    					$_SESSION["DOKTER"]["nama6"] =
        				getFromTable(
			            "select nama from rs00017 where id = '".$_SESSION["DOKTER"]["id6"]."'");
    					$f->textAndButton3("f_id_asisten3","Asisten 2 Operator",2,10,$_SESSION["DOKTER"]["id6"],$ext,"nm7",30,70,$_SESSION["DOKTER"]["nama6"],$ext,"...",$ext,"OnClick='selectPegawai6();';");
			            //unset($_SESSION["SELECT_EMP2"]);
					}elseif ($d2["id_asisten3"] != ''){
						$f->textAndButton3("f_id_asisten3","Asisten 2 Operator",2,10,$d2["id_asisten3"],$ext,"nm7",30,70,$d2["asisten3"],$ext,"...",$ext,"OnClick='selectPegawai6();';");
					}else{
						$f->textAndButton3("f_id_asisten3","Asisten 2 Operator",2,10,0,$ext,"nm7",30,70,$d2["asisten3"],$ext,"...",$ext,"OnClick='selectPegawai6();';");
					}
                     if (isset($_SESSION["SELECT_EMP7"])) {
    					$_SESSION["DOKTER"]["id7"] = $_SESSION["SELECT_EMP7"];
    					$_SESSION["DOKTER"]["nama7"] =
        				getFromTable(
			            "select nama from rs00017 where id = '".$_SESSION["DOKTER"]["id7"]."'");
    					$f->textAndButton3("f_id_asisten4","Dokter Anestesi",2,10,$_SESSION["DOKTER"]["id7"],$ext,"nm8",30,70,$_SESSION["DOKTER"]["nama7"],$ext,"...",$ext,"OnClick='selectPegawai7();';");
			            //unset($_SESSION["SELECT_EMP2"]);
					}elseif ($d2["id_asisten4"] != ''){
						$f->textAndButton3("f_id_asisten4","Dokter Anestesi",2,10,$d2["id_asisten4"],$ext,"nm8",30,70,$d2["asisten4"],$ext,"...",$ext,"OnClick='selectPegawai7();';");
					}else{
						$f->textAndButton3("f_id_asisten4","Dokter Anestesi",2,10,0,$ext,"nm8",30,70,$d2["asisten4"],$ext,"...",$ext,"OnClick='selectPegawai7();';");
					}
                    if (isset($_SESSION["SELECT_EMP8"])) {
    					$_SESSION["DOKTER"]["id8"] = $_SESSION["SELECT_EMP8"];
    					$_SESSION["DOKTER"]["nama8"] =
        				getFromTable(
			            "select nama from rs00017 where id = '".$_SESSION["DOKTER"]["id8"]."'");
    					$f->textAndButton3("f_id_anestesi1","Petugas Anastesi 1",2,10,$_SESSION["DOKTER"]["id8"],$ext,"nm9",30,70,$_SESSION["DOKTER"]["nama8"],$ext,"...",$ext,"OnClick='selectPegawai8();';");
			            //unset($_SESSION["SELECT_EMP2"]);
					}elseif ($d2["id_anestesi1"] != ''){
						$f->textAndButton3("f_id_anestesi1","Petugas Anastesi 1",2,10,$d2["id_anestesi1"],$ext,"nm9",30,70,$d2["anestesi1"],$ext,"...",$ext,"OnClick='selectPegawai8();';");
					}else{
						$f->textAndButton3("f_id_anestesi1","Petugas Anastesi 1",2,10,0,$ext,"nm9",30,70,$d2["anestesi1"],$ext,"...",$ext,"OnClick='selectPegawai8();';");
					}
                    if (isset($_SESSION["SELECT_EMP9"])) {
    					$_SESSION["DOKTER"]["id9"] = $_SESSION["SELECT_EMP9"];
    					$_SESSION["DOKTER"]["nama9"] =
        				getFromTable(
			            "select nama from rs00017 where id = '".$_SESSION["DOKTER"]["id9"]."'");
    					$f->textAndButton3("f_id_anestesi2","Petugas Anastesi 2",2,10,$_SESSION["DOKTER"]["id9"],$ext,"nm10",30,70,$_SESSION["DOKTER"]["nama9"],$ext,"...",$ext,"OnClick='selectPegawai9();';");
			            //unset($_SESSION["SELECT_EMP2"]);
					}elseif ($d2["id_anestesi2"] != ''){
						$f->textAndButton3("f_id_anestesi2","Petugas Anastesi 2",2,10,$d2["id_anestesi2"],$ext,"nm10",30,70,$d2["anestesi2"],$ext,"...",$ext,"OnClick='selectPegawai9();';");
					}else{
						$f->textAndButton3("f_id_anestesi2","Petugas Anastesi 2",2,10,0,$ext,"nm10",30,70,$d2["anestesi2"],$ext,"...",$ext,"OnClick='selectPegawai9();';");
					}
                    if (isset($_SESSION["SELECT_EMP10"])) {
    					$_SESSION["DOKTER"]["id10"] = $_SESSION["SELECT_EMP10"];
    					$_SESSION["DOKTER"]["nama10"] =
        				getFromTable(
			            "select nama from rs00017 where id = '".$_SESSION["DOKTER"]["id10"]."'");
    					$f->textAndButton3("f_id_anestesi3","Room Loop",2,10,$_SESSION["DOKTER"]["id10"],$ext,"nm11",30,70,$_SESSION["DOKTER"]["nama10"],$ext,"...",$ext,"OnClick='selectPegawai10();';");
			            //unset($_SESSION["SELECT_EMP2"]);
					}elseif ($d2["id_anestesi3"] != ''){
						$f->textAndButton3("f_id_anestesi3","Room Loop",2,10,$d2["id_anestesi3"],$ext,"nm11",30,70,$d2["anestesi3"],$ext,"...",$ext,"OnClick='selectPegawai10();';");
					}else{
						$f->textAndButton3("f_id_anestesi3","Room Loop",2,10,0,$ext,"nm11",30,70,$d2["anestesi3"],$ext,"...",$ext,"OnClick='selectPegawai10();';");
					}
                    if (isset($_SESSION["SELECT_EMP11"])) {
    					$_SESSION["DOKTER"]["id11"] = $_SESSION["SELECT_EMP11"];
    					$_SESSION["DOKTER"]["nama11"] =
        				getFromTable(
			            "select nama from rs00017 where id = '".$_SESSION["DOKTER"]["id11"]."'");
    					$f->textAndButton3("f_id_anestesi4","Perawat RR",2,10,$_SESSION["DOKTER"]["id11"],$ext,"nm12",30,70,$_SESSION["DOKTER"]["nama11"],$ext,"...",$ext,"OnClick='selectPegawai11();';");
			            /* unset($_SESSION["SELECT_EMP"]);
                        unset($_SESSION["SELECT_EMP2"]);
                        unset($_SESSION["SELECT_EMP3"]);
                        unset($_SESSION["SELECT_EMP4"]);
                        unset($_SESSION["SELECT_EMP5"]);
                        unset($_SESSION["SELECT_EMP6"]);
                        unset($_SESSION["SELECT_EMP7"]);
                        unset($_SESSION["SELECT_EMP8"]);
                        unset($_SESSION["SELECT_EMP9"]);
                        unset($_SESSION["SELECT_EMP10"]);
                        unset($_SESSION["SELECT_EMP11"]); */
					}elseif ($d2["id_anestesi4"] != ''){
						$f->textAndButton3("f_id_anestesi4","Perawat RR",2,10,$d2["id_anestesi4"],$ext,"nm11",30,70,$d2["anestesi4"],$ext,"...",$ext,"OnClick='selectPegawai11();';");
					}else{
						$f->textAndButton3("f_id_anestesi4","Perawat RR",2,10,0,$ext,"nm11",30,70,$d2["anestesi4"],$ext,"...",$ext,"OnClick='selectPegawai11();';");
					}
                                  /*   if (isset($_SESSION["SELECT_EMP"])) {
    					$_SESSION["DOKTER"]["id"] = $_SESSION["SELECT_EMP"];
    					$_SESSION["DOKTER"]["nama"] =
        				getFromTable(
			            "select nama from rs00017 where id = '".$_SESSION["DOKTER"]["id"]."'");
    					$f->textAndButton3("f_id_dokter","Dokter Pemeriksa",2,10,$_SESSION["DOKTER"]["id"],$ext,"nm2",30,70,$_SESSION["DOKTER"]["nama"],$ext,"...",$ext,"OnClick='selectPegawai();';");
			            unset($_SESSION["SELECT_EMP"]);
					}else{
						$f->textAndButton3("f_id_dokter","Operator 2",2,10,$d2["id_dokter"],$ext,"nm2",30,70,$d2["nama"],$ext,"...",$ext,"OnClick='selectPegawai();';");
					}
                                     if (isset($_SESSION["SELECT_EMP"])) {
    					$_SESSION["DOKTER"]["id"] = $_SESSION["SELECT_EMP"];
    					$_SESSION["DOKTER"]["nama"] =
        				getFromTable(
			            "select nama from rs00017 where id = '".$_SESSION["DOKTER"]["id"]."'");
    					$f->textAndButton3("f_id_dokter","Dokter Pemeriksa",2,10,$_SESSION["DOKTER"]["id"],$ext,"nm2",30,70,$_SESSION["DOKTER"]["nama"],$ext,"...",$ext,"OnClick='selectPegawai();';");
			            unset($_SESSION["SELECT_EMP"]);
					}else{
						$f->textAndButton3("f_id_dokter","Asisten 1",2,10,$d2["id_dokter"],$ext,"nm2",30,70,$d2["nama"],$ext,"...",$ext,"OnClick='selectPegawai();';");
					}
                                      if (isset($_SESSION["SELECT_EMP"])) {
    					$_SESSION["DOKTER"]["id"] = $_SESSION["SELECT_EMP"];
    					$_SESSION["DOKTER"]["nama"] =
        				getFromTable(
			            "select nama from rs00017 where id = '".$_SESSION["DOKTER"]["id"]."'");
    					$f->textAndButton3("f_id_dokter","Dokter Pemeriksa",2,10,$_SESSION["DOKTER"]["id"],$ext,"nm2",30,70,$_SESSION["DOKTER"]["nama"],$ext,"...",$ext,"OnClick='selectPegawai();';");
			            unset($_SESSION["SELECT_EMP"]);
					}else{
						$f->textAndButton3("f_id_dokter","Asisten 2",2,10,$d2["id_dokter"],$ext,"nm2",30,70,$d2["nama"],$ext,"...",$ext,"OnClick='selectPegawai();';");
					}
if (isset($_SESSION["SELECT_EMP"])) {
    					$_SESSION["DOKTER"]["id"] = $_SESSION["SELECT_EMP"];
    					$_SESSION["DOKTER"]["nama"] =
        				getFromTable(
			            "select nama from rs00017 where id = '".$_SESSION["DOKTER"]["id"]."'");
    					$f->textAndButton3("f_id_dokter","Dokter Pemeriksa",2,10,$_SESSION["DOKTER"]["id"],$ext,"nm2",30,70,$_SESSION["DOKTER"]["nama"],$ext,"...",$ext,"OnClick='selectPegawai();';");
			            unset($_SESSION["SELECT_EMP"]);
					}else{
						$f->textAndButton3("f_id_dokter","Asisten 3",2,10,$d2["id_dokter"],$ext,"nm2",30,70,$d2["nama"],$ext,"...",$ext,"OnClick='selectPegawai();';");
					}

if (isset($_SESSION["SELECT_EMP"])) {
    					$_SESSION["DOKTER"]["id"] = $_SESSION["SELECT_EMP"];
    					$_SESSION["DOKTER"]["nama"] =
        				getFromTable(
			            "select nama from rs00017 where id = '".$_SESSION["DOKTER"]["id"]."'");
    					$f->textAndButton3("f_id_dokter","Dokter Pemeriksa",2,10,$_SESSION["DOKTER"]["id"],$ext,"nm2",30,70,$_SESSION["DOKTER"]["nama"],$ext,"...",$ext,"OnClick='selectPegawai();';");
			            unset($_SESSION["SELECT_EMP"]);
					}else{
						$f->textAndButton3("f_id_dokter","Asisten 4",2,10,$d2["id_dokter"],$ext,"nm2",30,70,$d2["nama"],$ext,"...",$ext,"OnClick='selectPegawai();';");
					}*/
				    
					$max = count($visit_operasi) ; 
					$i = 1;
					while ($i<= $max) {		
					if 		($visit_operasi["vis_".$i."F"] == "memo") {
							$f->textarea("f_vis_".$i,$visit_operasi["vis_".$i] ,1, $visit_operasi["vis_".$i."W"],ucfirst($d2[2+$i]),$ext);
				
					}elseif ($visit_operasi["vis_".$i."F"] == "memo1") {
							$f->textarea1("DIAGNOSA KERJA","f_vis_".$i,$visit_operasi["vis_".$i] ,1, $visit_operasi["vis_".$i."W"],ucfirst($d2[2+$i]),$ext);
				
					}elseif ($visit_operasi["vis_".$i."F"] == "edit") {
	        				$f->text("f_vis_".$i,$visit_operasi["vis_".$i],$visit_operasi["vis_".$i."W"],$visit_operasi["vis_".$i."W"],ucfirst($d2[2+$i]),$ext);
	    			
					}elseif ($visit_operasi["vis_".$i."F"] == "edit4") {
				    		$f->text_4("PEMERIKSAAN FISIK","f_vis_5",$visit_operasi["vis_5"],7,10,$d2[2+$i],"","f_vis_6",$visit_operasi["vis_6"],7,10,$d2[2+$i+1],"mm Hg","f_vis_7",$visit_operasi["vis_7"],7,10,$d2[2+$i+2],"/Menit","f_vis_8",$visit_operasi["vis_8"],7,10,$d2[2+$i+3],"",$ext);
				    		
				    }elseif ($visit_operasi["vis_".$i."F"] == "edit5") {
							$f->text_4("","f_vis_9",$visit_operasi["vis_9"],7,10,$d2[2+$i],"","f_vis_10",$visit_operasi["vis_10"],7,10,$d2[2+$i+1],"Kg","f_vis_11",$visit_operasi["vis_11"],7,10,$d2[2+$i+2],"Celcius","f_vis_12",$visit_operasi["vis_12"],7,10,$d2[2+$i+3],"",$ext);			    	
				    }
	 		$i++ ; 	
			}
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
        echo "function selectPegawai2(tag) {\n";
        echo "    sWin = window.open('popup/pegawai2.php?tag=' + tag, 'xWin',".
             " 'top=0,left=0,width=500,height=400,menubar=no,scrollbars=yes');\n";
        echo "    sWin.focus();\n";
        echo "}\n";
        echo "function selectPegawai3(tag) {\n";
        echo "    sWin = window.open('popup/pegawai3.php?tag=' + tag, 'xWin',".
             " 'top=0,left=0,width=500,height=400,menubar=no,scrollbars=yes');\n";
        echo "    sWin.focus();\n";
        echo "}\n";
        echo "function selectPegawai4(tag) {\n";
        echo "    sWin = window.open('popup/pegawai4.php?tag=' + tag, 'xWin',".
             " 'top=0,left=0,width=500,height=400,menubar=no,scrollbars=yes');\n";
        echo "    sWin.focus();\n";
        echo "}\n";
        echo "function selectPegawai5(tag) {\n";
        echo "    sWin = window.open('popup/pegawai5.php?tag=' + tag, 'xWin',".
             " 'top=0,left=0,width=500,height=400,menubar=no,scrollbars=yes');\n";
        echo "    sWin.focus();\n";
        echo "}\n";
        echo "function selectPegawai6(tag) {\n";
        echo "    sWin = window.open('popup/pegawai6.php?tag=' + tag, 'xWin',".
             " 'top=0,left=0,width=500,height=400,menubar=no,scrollbars=yes');\n";
        echo "    sWin.focus();\n";
        echo "}\n";
        echo "function selectPegawai7(tag) {\n";
        echo "    sWin = window.open('popup/pegawai7.php?tag=' + tag, 'xWin',".
             " 'top=0,left=0,width=500,height=400,menubar=no,scrollbars=yes');\n";
        echo "    sWin.focus();\n";
        echo "}\n";
        echo "function selectPegawai8(tag) {\n";
        echo "    sWin = window.open('popup/pegawai8.php?tag=' + tag, 'xWin',".
             " 'top=0,left=0,width=500,height=400,menubar=no,scrollbars=yes');\n";
        echo "    sWin.focus();\n";
        echo "}\n";
        echo "function selectPegawai9(tag) {\n";
        echo "    sWin = window.open('popup/pegawai9.php?tag=' + tag, 'xWin',".
             " 'top=0,left=0,width=500,height=400,menubar=no,scrollbars=yes');\n";
        echo "    sWin.focus();\n";
        echo "}\n";
        echo "function selectPegawai10(tag) {\n";
        echo "    sWin = window.open('popup/pegawai10.php?tag=' + tag, 'xWin',".
             " 'top=0,left=0,width=500,height=400,menubar=no,scrollbars=yes');\n";
        echo "    sWin.focus();\n";
        echo "}\n";
        echo "function selectPegawai11(tag) {\n";
        echo "    sWin = window.open('popup/pegawai11.php?tag=' + tag, 'xWin',".
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
		echo "\n<script language='JavaScript'>\n";
	    echo "function selectLayanan() {\n";
	   	echo "    sWin = window.open('popup/layanan.php', 'xWin', 'top=0,left=0,width=600,height=400,menubar=no,scrollbars=yes');\n";
	    echo "    sWin.focus();\n";
	    echo "}\n";
        echo "function selectPegawai3(tag) {\n";
        echo "    sWin = window.open('popup/pegawai3.php?tag=' + tag, 'xWin',".
             " 'top=0,left=0,width=500,height=400,menubar=no,scrollbars=yes');\n";
        echo "    sWin.focus();\n";
        echo "}\n";
        /* Untuk Layanan Paket             */
		/* Agung Sunandar 16:53 26/06/2012 */
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

    if($_GET['list2']=="tab1"){
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
		}else { 
		   	$f->search("search","Pencarian",20,20,$_GET["search"],"icon/ico_find.gif","Cari","disabled");
		}
	    $f->execute();
    	if ($msg) errmsg("Error:", $msg);
    	echo "</div>";
		//---------------------
		echo "<br>";
		
	$SQLSTR = 	"select distinct a.mr_no,a.id,upper(a.nama)as nama,tanggal(b.tanggal_konsul,0)||' '||to_char(b.waktu_konsul,'hh:mi:ss') as tgl,a.alm_tetap,a.kesatuan,a.tdesc,c.tdesc,a.statusbayar
				from rsv_pasien4 a 
				left join c_visit b on b.no_reg = a.id
				left join rs00001 c on c.tc_poli = b.id_poli and c.tt='LYN'
				WHERE b.id_konsul='".$_GET["mPOLI"]."'";
		// 24-12-2006 --> tambahan 'where is_bayar = 'N'
		//status_akhir,rawatan di query sementara di tutup
        
		$tglhariini = date("Y-m-d", time());
    if (strlen($_GET["mPOLI"]) > 0 ) {
		$SQLWHERE =
			"AND b.TANGGAL_KONSUL = '$tglhariini' AND".
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
	    $t->ColFormatHtml[2] = "<A CLASS=SUB_MENU1 HREF='$SC?p=$PID&rg=<#1#>&mr=<#0#>&poli={$_GET["mPOLI"]}&list=layanan&sub2=nonpaket'><#2#>";
	    //(awal)$t->ColFormatHtml[8] = "<A HREF='$SC?p=$PID&rg=<#1#>&mr=<#0#>&poli={$_GET["mPOLI"]}&act=periksa'><INPUT NAME='submitButton' TYPE=SUBMIT VALUE='Periksa' >";
	   	//$t->ColHeader = array("NO.MR", "NO<br>REGISTRASI","TANGGAL  REG","WAKTU REG","NAMA PASIEN","PANGKAT","NRP/NIP","KESATUAN","LOKET","TIPE PASIEN","STATUS");
	   	$t->ColHeader = array("NO.MR", "NO<br>REGISTRASI","NAMA PASIEN","WAKTU KONSUL","ALAMAT","PEKERJAAN","TIPE PASIEN","UNIT ASAL","STATUS");
	    $t->ColColor[8] = "color";
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
		}else { 
		   	$f->search("search","Pencarian",20,20,$_GET["search"],"icon/ico_find.gif","Cari","disabled");
		}
	    $f->execute();
    	if ($msg) errmsg("Error:", $msg);
    	echo "</div>";
		//---------------------
		echo "<br>";
		
	$SQLSTR = 	"select distinct a.mr_no,a.id,upper(a.nama)as nama,tanggal(a.tanggal_reg,0)||' '||to_char(waktu_reg,'hh:mi:ss') as tgl,a.alm_tetap,a.kesatuan,a.tdesc,a.statusbayar
				from rsv_pasien4 a 
				left join c_visit_operasi b on b.no_reg = a.id
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
	    $t->ColFormatHtml[2] = "<A CLASS=SUB_MENU1 HREF='$SC?p=$PID&rg=<#1#>&mr=<#0#>&poli={$_GET["mPOLI"]}&list=pemeriksaan&sub2=nonpaket'><#2#>";
	    //(awal)$t->ColFormatHtml[8] = "<A HREF='$SC?p=$PID&rg=<#1#>&mr=<#0#>&poli={$_GET["mPOLI"]}&act=periksa'><INPUT NAME='submitButton' TYPE=SUBMIT VALUE='Periksa' >";
	   	//$t->ColHeader = array("NO.MR", "NO<br>REGISTRASI","TANGGAL  REG","WAKTU REG","NAMA PASIEN","PANGKAT","NRP/NIP","KESATUAN","LOKET","TIPE PASIEN","STATUS");
	   	$t->ColHeader = array("NO.MR", "NO<br>REGISTRASI","NAMA PASIEN","WAKTU REGISTRASI","ALAMAT","PEKERJAAN","TIPE PASIEN","STATUS");
	    $t->ColColor[7] = "color";
	    //$t->ColRowSpan[2] = 2;
	    $t->execute();
	    echo"<br><div class=NOTE>Catatan : Daftar pasien di urut berdasarkan no antrian</div><br>";
    }
	
}
  
?>
