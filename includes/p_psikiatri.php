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
$PID = "p_psikiatri";
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
$_GET["mPOLI"]=$setting_poli["psikiatri"];
$rg = isset($_GET["rg"])? $_GET["rg"] : $_POST["rg"];
$mr = isset($_GET["mr"])? $_GET["mr"] : $_POST["mr"];
// Tambahan BHP
$POLI=$setting_poli["psikiatri"];
// ======================================

include ("session.php");


echo "<table border=0 width='100%'><tr><td>";
title_print("<img src='icon/rawat-jalan-2.gif' align='absmiddle' >  POLIKLINIK JIWA");
title_excel("p_psikiatri&list=".$_GET['list']."&rg=".$_GET['rg']."&poli=".$_GET['poli']."&mr=".$_GET['mr']."&sub=".$_GET['sub']."&act=".$_GET['act']."&polinya=".$_GET['polinya']."&tblstart=".$_GET['tblstart']."");

//title("<img src='icon/rawat-jalan-2.gif' align='absmiddle' >  POLIKLINIK JIWA");
echo "</td></tr></table>";

unset($_GET["layanan"]);

$reg = $_GET["rg"];
$reg2 = $_GET["rg"];//identifikasi rincian

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
        $f = new Form("actions/p_psikiatri.insert.php");
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
		
        include ("icd.php");
	
        include("rincian3.php");
        
} elseif ($_GET["list"] == "icd9") {  // -------- ICD
		if(!$GLOBALS['print']){
		$T->show(3);
		}else{}
		
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
				$sql = "select a.*,b.nama,to_char(a.tanggal_reg,'dd Month yyyy')as tanggal_reg,f.layanan 
						from c_visit a 
						left join rs00017 b on a.id_dokter = B.ID 
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
			echo"<div class=form_subtitle>PEMERIKSAAN PASIEN</div>";
			echo "</td></tr>";
    		echo "<tr><td valign=top>";
    		$f = new ReadOnlyForm();
			$f->text("Tanggal Pemeriksaan","<b>".$d["tanggal_reg"]);
			//$f->title1("PEMERIKSAAN PASIEN","LEFT");
			$f->text($visit_psikiatri["vis_1"],$d[3] );
			$f->text($visit_psikiatri["vis_2"],$d[4]);
			$f->text($visit_psikiatri["vis_3"],$d[5]);
			$f->title1("<U>DIAGNOSA KERJA</U>","LEFT");	
			$f->text($visit_psikiatri["vis_4"],$d[6] );
			$f->title1("<U>DOKTER PEMERIKSA</U>","LEFT");
			$f->text("Nama",$d["nama"]);
			$f->execute();
    		echo "</td></tr>";
  			echo "<tr><td colspan='3'>";
  			include(rm_tindakan3);
  			echo "</td><td>";
  			echo "</td></tr></table>";

			
			}else {
				echo"<div align=center class=form_subtitle1>RIWAYAT PENYAKIT PASIEN</div>";
		//detail riwayat
		echo "<table border=0 width='100%' cellspacing=0 cellpadding=0><tr><td valign=top width='33%'  colspan=2>";
		
		//$f = new Form($SC, "GET");
				$sql = "SELECT A.NO_REG,TO_CHAR(A.TANGGAL_REG,'DD MON YYYY')AS TANGGAL,TO_CHAR(A.TANGGAL_REG,'HH:MM:SS') AS WAKTU,A.VIS_1,'DUMMY' ". 
					   "FROM C_VISIT A ".
					   "LEFT JOIN RS00006 B ON A.NO_REG=B.ID ".
					   "WHERE A.user_id != '' and B.MR_NO = '".$_GET["mr"]."' AND A.ID_POLI = '{$_GET["mPOLI"]}' ";
				$t = new PgTable($con, "100%");
			    $t->SQL = $sql ;
			    $t->setlocale("id_ID");
			    $t->ShowRowNumber = true;
			   	//$t->ColHidden[4]= true;
			    $t->RowsPerPage = $ROWS_PER_PAGE;
			    $t->ColHeader = array("NO REGISTRASI","TANGGAL PEMERIKSAAN","WAKTU KUNJUNGAN","KELUHAN UTAMA","DETAIL");
			   	$t->ColAlign = array("center","center","center","left","center");
				$t->ColFormatHtml[4] = "<A CLASS=TBL_HREF HREF='$SC?p=$PID&list=riwayat&act=detail&mr=".$_GET["mr"]."&poli=".$_GET["mPOLI"]."&rg=<#0#>'>".icon("view","View")."</A>";	
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
    
	include ("unit_rujukan.php");
	}
				        	
}elseif ($_GET["list"] == "konsultasi"){
    	$T->show(7);
    	echo"<br>";
    	
	include ("p_psikiatri.konsultasi.php");
		
}elseif ($_GET["list"] == "resepobat"){ //RESEP OBAT
    	$T->show(8);
    	//echo"<br>";
    	
 include ("resep_obat.php");
 
 include("rincianobat.php"); 

    }else {       //pemeriksaan
    	if(!$GLOBALS['print']){
    	$T->show(0);
    	}else{}
    		$sql2 =	"SELECT A.*,B.NAMA,D.NAMA AS perawat FROM C_VISIT A 
    				LEFT JOIN RS00017 B ON A.ID_DOKTER = B.ID
					LEFT JOIN RS00017 D ON A.ID_perawat  = D.ID
    				WHERE A.ID_POLI={$_GET["mPOLI"]} AND A.NO_REG='$rg'"; 
	    	$r=pg_query($con,$sql2);
	    	$n = pg_num_rows($r);		    	
			    if($n > 0) $d2 = pg_fetch_array($r);
			    pg_free_result($r);
				//-------------------------tambah for update------hery 08072007
				echo "<div align=left><input type=button value=' Edit ' OnClick=\"window.location = './index2.php?p=$PID&rg=$rg&mr={$_GET['mr']}&poli={$_GET["poli"]}&act=edit';\">\n";   
				//echo "<input type='image' src='images/icon-edit.png' action='edit' >";
				    
				if ($_GET['act'] == "edit"){
						echo "<font color='#000000' size='2'> >>Edit Pemeriksaan Pasien</font>";
						$f = new Form("actions/p_psikiatri.insert.php", "POST", "NAME=Form2");
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
					$f = new Form("actions/p_psikiatri.insert.php", "POST", "NAME=Form2");
					$f->hidden("act","new");
					$f->hidden("f_no_reg",$d->id);
					$f->hidden("list","pemeriksaan");
				    $f->hidden("mr",$_GET["mr"]);
				    $f->hidden("f_id_poli",$_GET["poli"]);
				    $f->hidden("f_user_id",$_SESSION[uid]);
			}
				    
				//$f->calendar("tanggal_reg","Tanggal Registrasi",15,15,$d2[1],"Form2","icon/calendar.gif","Pilih Tanggal",$ext);
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

					
				    $max = count($visit_psikiatri) ; 
					$i = 1;
					while ($i<= $max) {		
					if 		($visit_psikiatri["vis_".$i."F"] == "memo1") {
							$f->textarea("f_vis_".$i,$visit_psikiatri["vis_".$i] ,1, $visit_psikiatri["vis_".$i."W"],ucfirst($d2[2+$i]),$ext);
						
					}elseif ($visit_psikiatri["vis_".$i."F"] == "memo2") {
							$f->textarea("f_vis_".$i,$visit_psikiatri["vis_".$i] ,1, $visit_psikiatri["vis_".$i."W"],ucfirst($d2[2+$i]),$ext);
						
					}elseif ($visit_psikiatri["vis_".$i."F"] == "memo3") {
							$f->textarea("f_vis_".$i,$visit_psikiatri["vis_".$i] ,1, $visit_psikiatri["vis_".$i."W"],ucfirst($d2[2+$i]),$ext);
						
					}elseif ($visit_psikiatri["vis_".$i."F"] == "memo4") {
							$f->textarea("f_vis_".$i,$visit_psikiatri["vis_".$i] ,1, $visit_psikiatri["vis_".$i."W"],ucfirst($d2[2+$i]),$ext);
						
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
	    		    	//title_excel("p_psikiatri&tblstart=".$_GET['tblstart']);

		}else { 
		   	$f->search("search","Pencarian",20,20,$_GET["search"],"icon/ico_find.gif","Cari","disabled");
		   		    //	title_excel("p_psikiatri&tblstart=".$_GET['tblstart']);

		}
	    $f->execute();
    	if ($msg) errmsg("Error:", $msg);
    	echo "</div>";
		//---------------------
		echo "<br>";
		
	$SQLSTR = 	"select distinct a.mr_no,a.id,upper(a.nama)as nama,tanggal(b.tanggal_konsul,0)||' '||to_char(b.waktu_konsul,'hh:mi:ss') as tgl,a.alm_tetap,a.kesatuan,a.tdesc,CASE WHEN a.rawat_inap='I' THEN 'RAWAT INAP'
                             WHEN a.rawat_inap='N' THEN 'INSTALASI GAWAT DARURAT'
			     ELSE c.tdesc end as rawatan,a.statusbayar
				from rsv_pasien4 a 
				left join c_visit b on b.no_reg = a.id
				left join c_visit_operasi d on d.no_reg = a.id
				left join rs00001 c on c.tc_poli = b.id_poli and c.tt='LYN' or c.tc_poli = d.id_poli and c.tt='LYN'
				WHERE (b.id_konsul='".$_GET["mPOLI"]."' or d.id_konsul='".$_GET["mPOLI"]."')";
		// 24-12-2006 --> tambahan 'where is_bayar = 'N'
		//status_akhir,rawatan di query sementara di tutup
          //29-04-211 -->   status pasien ditampilkan perhari 'AND a.TANGGAL_REG = '$tglhariini' '        

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
	    //	title_excel("p_psikiatri&tblstart=".$_GET['tblstart']);
		}else { 
		   	$f->search("search","Pencarian",20,20,$_GET["search"],"icon/ico_find.gif","Cari","disabled");
		   		    //	title_excel("p_psikiatri&tblstart=".$_GET['tblstart']);

		}
	    $f->execute();
    	if ($msg) errmsg("Error:", $msg);
    	echo "</div>";
		//---------------------
		echo "<br>";
		
	$SQLSTR = 	"select distinct a.mr_no,a.id,upper(a.nama)as nama,tanggal(a.tanggal_reg,0)||' '||to_char(waktu_reg,'hh:mi:ss') as tgl,a.alm_tetap,a.kesatuan,a.tdesc,a.statusbayar
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
	    $t->ColFormatHtml[2] = "<A CLASS=SUB_MENU1 HREF='$SC?p=$PID&rg=<#1#>&mr=<#0#>&poli={$_GET["mPOLI"]}&list=layanan&sub2=nonpaket'><#2#>";
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
