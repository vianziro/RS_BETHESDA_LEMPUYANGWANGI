<? // Nugraha, 29/03/2004
   // sfdn, 22-04-2004
   // sfdn, 24-12-2006
	// sfdn, 27-12-2006
//session_start();
//if ($_SESSION[uid] == "daftar" || $_SESSION[uid] == "daftarri"  || $_SESSION[uid] == "igd" || $_SESSION[uid] == "root") {

$PID = "1202";
$SC = $_SERVER["SCRIPT_NAME"];

unset($_SESSION["IBU"]["id"]);
unset($_SESSION["IBU"]["nama"]);
		
require_once("lib/dbconn.php");
require_once("lib/form.php");
require_once("lib/class.PgTable.php");
require_once("lib/functions.php");
     
if (strlen($_GET["registered"]) == 0) $_GET["registered"] = "Y";
   title(" <img src='icon/informasi-2.gif' align='absmiddle' > PENDAFTARAN PASIEN RAWAT INAP");

echo "<br>";

$f = new Form($SC, "GET", "NAME=Form2");
$f->hidden("p",$PID);
$f->selectArray("registered", "Pasien",
    Array("Y" => "Pasien Lama", "N" => "Pasien Baru", "B" => "Pasien Bayi Lahir"),
    $_GET["registered"],"onChange=\"Form2.submit();\"");
$f->hidden("q","search");
if ($_GET["registered"] == "Y" && $_GET["q"] != "reg") {
    $f->text("search","Nama atau No.RM",40,40,$_GET["search"]);
    $f->submit("Tampilkan");
}
$f->execute();

$psn = "<font color='red'>{$_GET['psn']}</font>";
$psn2 = "<font color='red'>{$_GET['psn2']}</font>";

if ($_GET["q"] == "reg") {
    if ($_GET["mr_no"] != "new") {
        $r = pg_query($con, "select * from rs00002 where mr_no = '".$_GET["mr_no"]."'");
        $n = pg_num_rows($r);
        if($n > 0) $d = pg_fetch_object($r);
        pg_free_result($r);
		
        $f = new Form("actions/1202.insert.php", "POST", "NAME=Form1");
        $f->hidden("p",$PID);
        $f->hidden("f_mr_no",$d->mr_no); 
         $f->hidden("f_user_id",$_SESSION[uid]);

        $f->subtitle("Pasien");
        $f->text("mr_no","No.MR",12,12,$d->mr_no,"DISABLED");
        $f->textinfo("f_nama","Nama",50,50,$d->nama,$psn,"DISABLED");
        $f->text("f_nama_keluarga","Nama Keluarga",50,50,"$d->nama_keluarga","DISABLED");
        $f->text("f_tmp_lahir","Tempat Lahir",50,50,"$d->tmp_lahir","DISABLED");
        $f->text("f_tgl_lahir","Tanggal Lahir",50,50,date("d M Y", pgsql2mktime($d->tgl_lahir)),"DISABLED");
        $f->text("f_umur","Umur",5,3,$d->umur,"DISABLED");
        $f->text("f_alm_tetap","Alamat Tetap",50,150,"$d->alm_tetap, $d->kota_tetap, $d->pos_tetap","DISABLED");
        $f->text("f_tlp_tetap","Telepon",15,15,$d->tlp_tetap,"DISABLED"); 
        $f->text("f_no_ktp","Nomor KTP/SIM/KTA",50,50,"$d->no_ktp","DISABLED"); 
		$f->text("f_pangkat_gol","Pangkat/Golongan ",50,50,"$d->pangkat_gol","DISABLED");
		$f->text("f_nrp_nip","NRP/NIP ",50,50,"$d->nrp_nip","DISABLED");
		$f->text("f_kesatuan","Kesatuan/Instansi/Pekerjaan ",50,50,"$d->kesatuan","DISABLED"); 
	
        $f->subtitle("Registrasi Pasien");
        $f->text("no_reg","No. Registrasi",12,12,"<OTOMATIS>","DISABLED");
           
          if ($_SESSION[uid] == "igd") {
	        	
	        $f->selectArray("f_rawat_inap", "Rawatan",Array("N" => "IGD"),"N", "OnChange=\"setPoli(this.value);\"");
	        $f->PgConn = $con;
			$f->selectSQL("f_poli", "Poli","select '' as tc, '-' as tdesc union ".
							"SELECT tc,tdesc FROM rs00001 WHERE tt = 'LYN' and tc not in ('000','201','202','206','207','208')
							 order by tdesc ","", "DISABLED");
	
	        } elseif ($_SESSION[uid] == "daftar" || $_SESSION[uid] == "daftarri") {
	
	        $f->selectArray("f_rawat_inap", "Rawatan",Array("Y" => "Rawat Jalan"),"Y", "OnChange=\"setPoli(this.value);\"");
	        $f->PgConn = $con;
	        $f->selectSQL2("f_poli", "Poli","select '' as tc, '-' as tdesc union ".
							"SELECT tc,tdesc FROM rs00001 WHERE tt = 'LYN' and tc not in ('000','201','202','206','207','208')
							 order by tdesc ","", "",$psn2);
	        } else {
	
	        $f->selectArray("f_rawat_inap", "Rawatan",Array("Y" => "Rawat Jalan", "N" => "IGD"),
	                        "N", "OnChange=\"setPoli(this.value);\"");
	        $f->PgConn = $con;
			$f->selectSQL2("f_poli", "Poli","select '' as tc, '-' as tdesc union ".
							"SELECT tc,tdesc FROM rs00001 WHERE tt = 'LYN' and tc not in ('000','201','202','206','207','208')
							 order by tdesc ","", "DISABLED",$psn2);
	        }
        
        $f->selectArray("f_rujukan", "Jenis Kedatangan",Array("N" => "Non Rujukan", "Y" => "Rujukan"),
                        "N", "OnChange=\"setRujukan(this.value);\"");
        $f->selectSQL("f_rujukan_rs_id", "Rumah Sakit Perujuk","select '' as tc, '' as tdesc union ".
                      "select tc, tdesc from rs00001 where tt = 'RUJ' and tc != '000'","", "DISABLED");
        $f->text("f_rujukan_dokter","Dokter Perujuk",50,50,"","DISABLED");        
        $f->selectSQL("f_id_penanggung", "Penanggung","select tc, tdesc from rs00001 where tt = 'PEN' and tc != '000'",
                      "001","OnChange=\"setNmPenanggung(this.value);\"");                      
        $f->text("f_nm_penanggung","Nama Penanggung",50,50,"","DISABLED");
        $f->text("f_hub_penanggung","Hubungan Dengan Pasien",50,50,"","DISABLED");                      
        $f->selectSQL("f_id_penjamin", "Penjamin","select tc, tdesc from rs00001 where tt = 'PJN' and tc != '000'","999");
        $f->selectSQL("f_tipe", "Tipe Pasien","select tc, tdesc from rs00001 where tt = 'JEP' and tc != '000'","$d->tipe_pasien");
        $f->textarea("f_diagnosa_sementara", "Diagnosa Sementara", 4, 50, "");
        $f->hidden("f_status_akhir_pasien","-");
        //$f->hidden("f_jenis_kedatangan_id","0");
/* rAWAT iNAP */        

echo "\n<script language='JavaScript'>\n";
echo "function selectBangsal() {\n";
echo "    sWin = window.open('popup/bangsal.php', 'xWin', 'width=600,height=400,menubar=no,scrollbars=yes');\n";
echo "    sWin.focus();\n";
echo "}\n";
echo "</script>\n";

          $f->subtitle("Registrasi Raawat Jalan ");      

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

    $f->hidden("kode_bangsal",$_SESSION["BANGSAL"]["id"]);

    $f->textAndButton("nm_bangsal","Bangsal",70,70,$_SESSION["BANGSAL"]["desc"],"DISABLED","...",
        "OnClick='selectBangsal();';");
    $jam 	= getFromTable("select to_char(CURRENT_TIMESTAMP,'HH24:MI') as jam");
         $f->selectDate("tanggal", "Terhitung Mulai", getdate(), "");
        $f->text("jam","Jam (format = 24)",15,15,$jam,"");        

/* Rawat Inap End */

        
        $f->submit(" Registrasi ");
        
	$f->execute();
        
        if ($_GET[err] == 1) {
           echo "<br><font color=red>ERROR: Poli belum dipilih.</font>";
        }
        ?>

        <SCRIPT language="JavaScript">
            document.Form1.f_rujukan_rs_id.selectedIndex = -1;

            function setRujukan( v )
            {
                document.Form1.f_rujukan_rs_id.disabled = v == "N";
                document.Form1.f_rujukan_dokter.disabled = v == "N";
                document.Form1.f_rujukan_dokter.value = v == "N" ? "" : document.Form1.f_rujukan_dokter.value;
                document.Form1.f_rujukan_rs_id.selectedIndex = document.Form1.f_rujukan_rs_id.selectedIndex == -1 && v == "Y" ? 0 : v == "Y" ? document.Form1.f_rujukan_rs_id.selectedIndex : -1;
            }
        </SCRIPT>
        <SCRIPT language="JavaScript">
            document.Form1.f_poli.selectedIndex = -1;
            function setPoli( v )
            {
                document.Form1.f_poli.disabled = v == "N";
                document.Form1.f_poli.selectedIndex = document.Form1.f_poli.selectedIndex == -1 && v == "Y" ? 0 : v == "Y" ? document.Form1.f_poli.selectedIndex : -1;
            }
        </SCRIPT>
        
        <SCRIPT language="JavaScript">

            function setNmPenanggung( v )
            {
                  document.Form1.f_nm_penanggung.disabled = v == "001";
                  document.Form1.f_hub_penanggung.disabled = v == "001";

            }
        </SCRIPT>		
        <?php
    }
} else {
    if ($_GET["registered"] == "N") {
        $f = new Form("actions/110.insert.php", "POST", "NAME=Form1");
        $f->subtitle("Identitas");
        $f->hidden("mr_no","new");
        $f->hidden("p",$PID);
        $f->text("mr_no","No.MR",12,12,"<OTOMATIS>","DISABLED");
        //$f->text("no_reg","No. Registrasi",12,12,"<OTOMATIS>","DISABLED");
        $f->PgConn = $con;
        $f->textinfo("f_nama","Nama",40,50,"",$psn);
        $f->text("f_nama_keluarga","Nama Keluarga",40,50,"");
        $f->selectArray("f_jenis_kelamin", "Jenis Kelamin",Array("L" => "Laki-laki", "P" => "Perempuan"),"");
        $f->text("f_tmp_lahir","Tempat Lahir",40,40,"");
        $f->selectDate("f_tgl_lahir", "Tanggal Lahir", getdate());
        //$f->text("f_umur", "(Umur)", 5,3,"","disabled");
        $f->selectSQL("f_agama_id", "Agama","select tc, tdesc from rs00001 where tt = 'AGM' and tc != '000'","");
        $f->text("f_no_ktp","Nomor KTP/SIM/KTA",50,50,"",""); 
		$f->text("f_pangkat_gol","Pangkat/Golongan ",50,50,"","");
		$f->text("f_nrp_nip","NRP/NIP ",50,50,"","");
		$f->text("f_kesatuan","Kesatuan/Instansi/Pekerjaan ",50,50,"","");
        $f->selectSQL("f_status_nikah", "Status Pernikahan","select '' as tc, '-' as tdesc union ".
        			  "select tc, tdesc from rs00001 where tt = 'SNP' and tc != '000'","");
        $f->selectSQL("f_gol_darah", "Golongan Darah","select '' as tc, '-' as tdesc union ".
        			  "select tc, tdesc from rs00001 where tt = 'GOL' and tc != '000'","");
        $f->selectSQL("f_resus_faktor", "Resus Faktor","select '' as tc, '-' as tdesc union ".
                        "select tc, tdesc from rs00001 where tt = 'REF' and tc != '000'","");
		$f->text("f_nama_ayah","Nama Ayah ",50,50,"",""); 
		$f->text("f_nama_ibu","Nama Ibu",50,50,"","");
		$f->text("f_pekerjaan","Pekerjaan Orangtua",50,50,"",""); 
     
        $f->subtitle("Alamat Tetap");
        $f->text("f_alm_tetap","Alamat",50,50,"");
        // sfdn, 24-12-2006
		$f->text("f_kota_tetap","Kota",50,50,"Bandung");
        $f->text("f_pos_tetap","Kode Pos",5,5,"");
        $f->text("f_tlp_tetap","Telepon",15,15,"");
        
        /*
        $f->subtitle("Alamat Sementara");
        $f->text("f_alm_sementara","Alamat",50,50,"");
        $f->text("f_kota_sementara","Kota",50,50,"");
        $f->text("f_pos_sementara","Kode Pos",5,5,"");
        $f->text("f_tlp_sementara","Telepon",15,15,"");
        
        
        $f->hidden("f_keluarga_dekat","");
        $f->hidden("f_alm_keluarga","");
        $f->hidden("f_kota_keluarga","");
        $f->hidden("f_pos_keluarga","");
        $f->hidden("f_tlp_keluarga","");
		*/

        $f->subtitle("Keluarga Dekat");
        $f->text("f_keluarga_dekat","Nama",50,50,"");
        $f->text("f_alm_keluarga","Alamat",50,50,"");
        $f->text("f_kota_keluarga","Kota",50,50,"");
        $f->text("f_pos_keluarga","Kode Pos",5,5,"");
        $f->text("f_tlp_keluarga","Telepon",15,15,"");
        

        $f->hidden("f_alm_sementara","");
        $f->hidden("f_kota_sementara","");
        $f->hidden("f_pos_sementara","");
        $f->hidden("f_tlp_sementara","");

		$f->subtitle("KARTU BEROBAT");
		// $f->hidden("f_tgl_reg",date("Y-d-m"));
        $f->selectSQL("f_tipe_pasien", "Tipe Pasien",
        			  "select tc, tdesc from rs00001 where tt = 'JEP' and tc != '000' order by tc asc","001");                      
        $f->selectArray("cek_printer", "CETAK KARTU BEROBAT ? ",Array("Y" => "CETAK", "N" => "TIDAK DI CETAK "),"N"); 
        $f->submit(" Registrasi ");
        $f->execute();
        
    }elseif ($_GET["registered"] == "B") {
    	
    		
    	echo "\n<script language='JavaScript'>\n";
	    echo "function selectIbu(tag) {\n";
        echo "    sWin = window.open('popup/ibu.php?tag=' + tag, 'xWin',".
             " 'top=0,left=0,width=500,height=400,menubar=no,scrollbars=yes');\n";
        echo "    sWin.focus();\n";
        echo "}\n";
        echo "</script>\n";
 

   	
       echo "<table border='0' width='100%'><tr valign='top'><td align='left' width='60%'> ";
    	 $f = new Form("actions/110.insert.php", "POST", "NAME=Form1");
        $f->subtitle("Identitas Bayi");
        $f->hidden("mr_no","new");
        $f->hidden("registered","B");
        $f->hidden("p",$PID);
        $f->text("mr_no Bayi","No.MR",12,12,"<OTOMATIS>","DISABLED");
        $f->PgConn = $con;
        
        	if (isset($_SESSION["SELECT_IBU"]) || $_GET['ibu']) {
    					$_SESSION["IBU"]["id"] = $_SESSION["SELECT_IBU"];
    					$_SESSION["IBU"]["nama"] =
        				getFromTable("select nama from rs00002 where mr_no = '".$_SESSION["IBU"]["id"]."'");
    					$f->textAndButton("f_nama_ibu","Nama Ibu",30,70,$_SESSION["IBU"]["nama"],"readonly","...","OnClick='selectIbu();';");
			            unset($_SESSION["SELECT_IBU"]);
        	}else{
						$f->textAndButton("f_nama_ibu","Nama Ibu",30,70,$_SESSION["IBU"]["nama"],"readonly","...","OnClick='selectIbu();';");
        	}
        	//echo "session=".$_SESSION["SELECT_IBU"];
        	
        	$SQL3 = "select a.*, b.tdesc as goldarah, c.tdesc as resus, d.tdesc as tipe ".
							"from rs00002 a  ".
							"left join rs00001 b on a.gol_darah=b.tc and b.tt='GOL' ".
							"left join rs00001 c on a.resus_faktor=c.tc and c.tt='REF' ".
							"left join rs00001 d on a.gol_darah=d.tc and d.tt='JEP' ".
 							"where a.mr_no='{$_SESSION["IBU"]["id"]}'";
        			$r3 = pg_query($con,$SQL3);
        			$n3 = pg_num_rows($r3);
        			if ($n3 > 0) $d3 = pg_fetch_array($r3);
        			pg_free_result($r3);
        	       	
        	
        $f->textinfo("f_nama","Nama Bayi ",35,50,"",$psn,"");
        $f->selectArray("f_jenis_kelamin", "Jenis Kelamin Bayi",Array("L" => "Laki-laki", "P" => "Perempuan"),"");
        $f->text("f_tmp_lahir","Tempat Lahir Bayi",35,40,"Bandung");
        $f->selectDate("f_tgl_lahir", "Tanggal Lahir Bayi", getdate());
        
        $f->hidden("f_mr_no_ibu",$_SESSION["IBU"]["id"]);
        $f->hidden("f_is_bayi","Y");
        
        $f->selectSQL("f_gol_darah", "Golongan Darah ","select '' as tc, '-' as tdesc union ".
        			  "select tc, tdesc from rs00001 where tt = 'GOL' and tc != '000'",$d3['gol_darah']);
        $f->selectSQL("f_resus_faktor", "Resus Faktor","select '' as tc, '-' as tdesc union ".
                        "select tc, tdesc from rs00001 where tt = 'REF' and tc != '000'",$d3['resus_faktor']);
		
        $f->subtitle("Alamat Tetap");
        $f->text("f_alm_tetap","Alamat",50,50,$d3['alm_tetap']);
        // sfdn, 24-12-2006
		$f->text("f_kota_tetap","Kota",50,50,$d3['kota_tetap']);
        $f->text("f_pos_tetap","Kode Pos",5,5,$d3['pos_tetap']);
        $f->text("f_tlp_tetap","Telepon",15,15,$d3['tlp_tetap']);
        
        $f->subtitle("Keluarga Dekat");
        $f->text("f_keluarga_dekat","Nama",50,50,$d3['keluarga_dekat']);
        $f->text("f_alm_keluarga","Alamat",50,50,$d3['alm_keluarga']);
        $f->text("f_kota_keluarga","Kota",50,50,$d3['kota_keluarga']);
        $f->text("f_pos_keluarga","Kode Pos",5,5,$d3['pos_keluarga']);
        $f->text("f_tlp_keluarga","Telepon",15,15,$d3['tlp_keluarga']);
        

        $f->hidden("f_alm_sementara","");
        $f->hidden("f_kota_sementara","");
        $f->hidden("f_pos_sementara","");
        $f->hidden("f_tlp_sementara","");

		$f->subtitle("KARTU BEROBAT");
		// $f->hidden("f_tgl_reg",date("Y-d-m"));
        $f->selectSQL("f_tipe_pasien", "Tipe Pasien",
        			  "select tc, tdesc from rs00001 where tt = 'JEP' and tc != '000' order by tc asc",$d3['tipe_pasien']);                      
        $f->selectArray("cek_printer", "CETAK KARTU BEROBAT ? ",Array("Y" => "CETAK", "N" => "TIDAK DI CETAK "),"Y"); 
        $f->submit(" Registrasi ");
        $f->execute();
        
        echo "</td><td width='2%'></td><td width='43%' align='left'>";
        	
       	$f = new ReadOnlyForm();
       	$f->subtitle("Identitas Ibu");
        $f->text("No.MR Ibu",$d3['mr_no']);
        $f->text("Nama Ibu",$d3['nama']);
        $f->text("Pekerjaan",$d3['pekerjaan']); 
     	$f->text("Nomor KTP/SIM/KTA",$d3['no_ktp']); 
		$f->text("Pangkat/Golongan Ibu",$d3['pangkat_gol']);
		$f->text("NRP/NIP Ibu ",$d3['nrp_nip']);
		$f->text("Kesatuan/Instansi/Pekerjaan",$d3['kesatuan']);
		$f->text("Golongan Darah",$d3['goldarah']);
		$f->text("Resus Faktor",$d3['resus']);
        
		$f->subtitle("Alamat Tetap");
        $f->text("Alamat",$d3['alm_tetap']);
        $f->text("Kota",$d3['kota_tetap']);
        $f->text("Kode Pos",$d3['pos_tetap']);
        $f->text("Telepon",$d3['tlp_tetap']);

        $f->subtitle("Keluarga Dekat");
        $f->text("Nama",$d3['keluarga_dekat']);
        $f->text("Alamat",$d3['alm_keluarga']);
        $f->text("Kota",$d3['kota_keluarga']);
        $f->text("Kode Pos",$d3['pos_keluarga']);
        $f->text("Telepon",$d3['tlp_keluarga']);
        $f->text("Tipe Pasien",$d3['tipe']);
        $f->execute();
        
        echo "</td></tr></table>";
    }

	if ($_GET["registered"] == "Y" && $_GET["q"] == "search" && strlen($_GET["search"]) > 0) {
    	$t = new PgTable($con, "100%");
        $t->SQL = "select a.mr_no, a.nama,a.nama_keluarga,a.pangkat_gol,a.nrp_nip,a.kesatuan,a.alm_tetap||'&nbsp;'||a.kota_tetap, ".
			//"case when (select x.statusbayar from rsv0012 x where x.mr_no = a.mr_no ".
			//"AND x.id = (select max(d.id) from rs00006 d where d.mr_no = a.mr_no)) <> 'LUNAS' ".
			//"	then 'MASIH DIRAWAT' else 'BOLEH BEROBAT' end as akhir, ".
			" a.mr_no as href FROM rs00002 a ".
			"where upper(a.nama) LIKE '%".strtoupper($_GET["search"])."%' ".
			"OR a.mr_no LIKE '%".$_GET["search"]."%' ";
                	
		if (!isset($_GET[sort])) {
        	$_GET[sort] = "a.mr_no";
           	$_GET[order] = "asc";
		}
        $t->ColHeader = array("NO.MR","NAMA","NAMA KELUARGA","PANGKAT","NRP/NIP","KESATUAN","ALAMAT","REGISTRASI");
        $t->ShowRowNumber = true;
        $t->ColAlign[0] = "CENTER";
        $t->ColAlign[7] = "CENTER";
        $t->RowsPerPage = 10;
	 //$t->RowsPerPage = $ROWS_PER_PAGE;
        //$t->DisableStatusBar = true;
		// sfdn, 27-12-2006 -> hanya pembetulan baris
	   	$t->ColFormatHtml[7] = "<nobr>
	   					<A CLASS=TBL_HREF "."HREF='$SC?p=$PID&q=reg&mr_no=<#7#>'>".icon("ok","Registrasi")."</A>
                				</nobr>";
		// --- eof 27-12-2006
        $t->execute();
    }
}

//session_destroy();
//} // end of $_SESSION[uid] == daftar || igd
?>
