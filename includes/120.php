<? // Nugraha, 29/03/2004
   // sfdn, 22-04-2004
   // sfdn, 24-12-2006
   // sfdn, 27-12-2006
	//session_start();
	//if ($_SESSION[uid] == "daftar" || $_SESSION[uid] == "daftarri"  || $_SESSION[uid] == "igd" || $_SESSION[uid] == "root") {
	// Agung Sunandar 13:51 06/06/2012 menghilangkan daftar Bayi lahir, Rawatan Paket serta poli-poli yang tidak diperlukan

$PID = "120";
$SC = $_SERVER["SCRIPT_NAME"];

unset($_SESSION["IBU"]["id"]);
unset($_SESSION["IBU"]["nama"]);
		
require_once("lib/dbconn.php");
require_once("lib/form.php");
require_once("lib/class.PgTable.php");
require_once("lib/functions.php");
     
if (strlen($_GET["registered"]) == 0) $_GET["registered"] = "Y";
   title(" <img src='icon/informasi-2.gif' align='absmiddle' > PENDAFTARAN PASIEN ");
?>
<br/>
<?php
$f = new Form($SC, "GET", "NAME=Form2");
$f->hidden("p",$PID);
$f->selectArray("registered", "Pasien",
	// Agung Sunandar 13:53 06/06/2012
    //Array("N" => "Pasien Baru", "Y" => "Pasien Lama", "B" => "Pasien Bayi Lahir"  ),
    Array("N" => "Pasien Baru", "Y" => "Pasien Lama", "B" => "Pasien Bayi Lahir"  ),
    $_GET["registered"],"onChange=\"Form2.submit();\"");
$f->hidden("q","search");
if ($_GET["registered"] == "Y" && $_GET["q"] != "reg") {
    //$f->text("search","Nama atau No.MR",40,40,$_GET["search"]);
?>
<script type="text/javascript" src="plugin/jquery.js"></script>
<script type='text/javascript' src='plugin/jquery.bgiframe.min.js'></script>
<script type='text/javascript' src='plugin/jquery.ajaxQueue.js'></script>
<script type='text/javascript' src='plugin/thickbox-compressed.js'></script>
<script type='text/javascript' src='plugin/jquery.autocomplete.js'></script>
<script type='text/javascript' src='plugin/localdata.js'></script>
<link rel="stylesheet" type="text/css" href="plugin/jquery.autocomplete.css" />
<script type="text/javascript">
$().ready(function() {
	function log(event, data, formatted) {
		$("<li>").html( !data ? "No match!" : "Selected: " + formatted).appendTo("#result");
	}
	function formatItem(row) {
		return row[0] + " (<strong>id: " + row[1] + "</strong>)";
	}
	function formatResult(row) {
		return row[0].replace(/(<.+?>)/gi, '');
	}
	$("#suggest1").focus().autocomplete(cities);
	$("#pasien1").focus().autocomplete(nama);
	$("#month").autocomplete(months, {
		minChars: 0,
		max: 12,
		autoFill: true,
		mustMatch: true,
		matchContains: false,
		scrollHeight: 220,
		formatItem: function(data, i, total) {
			// don't show the current month in the list of values (for whatever reason)
			if ( data[0] == months[new Date().getMonth()] )
				return false;
			return data[0];
		}
	});
	$("#suggest13").autocomplete(emails, {
		minChars: 0,
		width: 310,
		matchContains: "word",
		autoFill: false,
		formatItem: function(row, i, max) {
			return i + "/" + max + ": \"" + row.name + "\" [" + row.to + "]";
		},
		formatMatch: function(row, i, max) {
			return row.name + " " + row.to;
		},
		formatResult: function(row) {
			return row.to;
		}
	});
	$("#singleBirdRemote").autocomplete("search.php", {
		width: 260,
		selectFirst: false
	});
	$("#AUTOTEXT").autocomplete("lib/coba.php", {
		width: 260,
		selectFirst: false
	});
	$("#suggest14").autocomplete(cities, {
		matchContains: true,
		minChars: 0
	});
	$("#suggest3").autocomplete(cities, {
		multiple: true,
		mustMatch: true,
		autoFill: true
	});
	$("#suggest4").autocomplete('search.php', {
		width: 300,
		multiple: true,
		matchContains: true,
		formatItem: formatItem,
		formatResult: formatResult
	});
	$("#imageSearch").autocomplete("images.php", {
		width: 320,
		max: 4,
		highlight: false,
		scroll: true,
		scrollHeight: 300,
		formatItem: function(data, i, n, value) {
			return "<img src='images/" + value + "'/> " + value.split(".")[0];
		},
		formatResult: function(data, value) {
			return value.split(".")[0];
		}
	});
	$("#tags").autocomplete(["c++", "java", "php", "coldfusion", "javascript", "asp", "ruby", "python", "c", "scala", "groovy", "haskell", "pearl"], {
		width: 320,
		max: 4,
		highlight: false,
		multiple: true,
		multipleSeparator: " ",
		scroll: true,
		scrollHeight: 300
	});


	$(":text, textarea").result(log).next().click(function() {
		$(this).prev().search();
	});
	$("#singleBirdRemote").result(function(event, data, formatted) {
		if (data)
			$(this).parent().next().find("input").val(data[1]);
	});
	$("#suggest4").result(function(event, data, formatted) {
		var hidden = $(this).parent().next().find(">:input");
		hidden.val( (hidden.val() ? hidden.val() + ";" : hidden.val()) + data[1]);
	});
    $("#suggest15").autocomplete(cities, { scroll: true } );
	$("#scrollChange").click(changeScrollHeight);

	$("#thickboxEmail").autocomplete(emails, {
		minChars: 0,
		width: 310,
		matchContains: true,
		highlightItem: false,
		formatItem: function(row, i, max, term) {
			return row.name.replace(new RegExp("(" + term + ")", "gi"), "<strong>$1</strong>") + "<br><span style='font-size: 80%;'>Email: &lt;" + row.to + "&gt;</span>";
		},
		formatResult: function(row) {
			return row.to;
		}
	});

	$("#clear").click(function() {
		$(":input").unautocomplete();
	});
});

function changeOptions(){
	var max = parseInt(window.prompt('Please type number of items to display:', jQuery.Autocompleter.defaults.max));
	if (max > 0) {
		$("#suggest1").setOptions({
			max: max
		});
	}
}

function changeScrollHeight() {
    var h = parseInt(window.prompt('Please type new scroll height (number in pixels):', jQuery.Autocompleter.defaults.scrollHeight));
    if(h > 0) {
        $("#suggest1").setOptions({
			scrollHeight: h
		});
    }
}

function changeToMonths(){
	$("#suggest1")
		// clear existing data
		.val("")
		// change the local data to months
		.setOptions({data: months})
		// get the label tag
		.prev()
		// update the label tag
		.text("Month (local):");
}
</script>
<?
if($_GET['search'] != ''){
    $sqlNoMR = pg_query($con,  "SELECT mr_no FROM rs00002 WHERE mr_no = '".$_GET["search"]."' ");
    if(pg_num_rows($sqlNoMR) == 1){
        echo '<script>';
        echo 'window.location = "index2.php?p=120&q=reg&mr_no='.$_GET['search'].'&is_baru=N" ';
        echo '</script>';
    }
   
}
    
    $f->textauto("search","Nama atau No.MR",40,40,$_GET["search"]);
    $f->textauto("search1","Alamat",40,40,$_GET["search1"]);
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
	if ($_GET["cetak"] == "Y") {
	    	?>
	    	<SCRIPT language="JavaScript">
		 sWin = window.open('includes/cetak.120.php?rg=<?echo $d->mr_no;?>', 'xWin','top=0,left=0,width=500,height=300,menubar=no,scrollbars=yes');
		sWin.focus();  
	        </SCRIPT>	
	        <?
		}
		$cek_status=getFromTable("select is_bayar from rs00006 where mr_no='".$_GET["mr_no"]."' AND is_bayar='N' order by is_bayar ASC");
		$no_reg=getFromTable("select id from rs00006 where mr_no='".$_GET["mr_no"]."' AND is_bayar='N' order by is_bayar ASC");
		$rawatan=getFromTable("select rawat_inap from rs00006 where mr_no='".$_GET["mr_no"]."' AND is_bayar='N' order by is_bayar ASC");
		
		if ($rawatan == 'Y')
		{$rawat='RAWAT JALAN';}
		else if ($rawatan == 'I')
		{$rawat='RAWAT INAP';}
		else
		{$rawat='IGD';
		}
		
		if ($cek_status=='N'){
		echo "<br>";
		echo "<center><font color='red' size=3>Pasien Belum Lunas / Kabur. <br> Silahkan cek kasir dengan No. Reg $no_reg di Kasir $rawat</font></center>";
		echo "<br>";
		}else{
        $f = new Form("actions/120.insert.php", "POST", "NAME=Form1");
        $f->hidden("p",$PID);
        $f->hidden("f_mr_no",$d->mr_no); 
        $f->hidden("f_user_id",$_SESSION[uid]);
        $f->hidden("f_is_baru",$_GET[is_baru]);
        //echo date("Y-m-d H:i:s");
        $f->subtitle("Pasien");
        $f->text("mr_no","No.MR",12,12,$d->mr_no,"DISABLED");
        $f->textinfo("f_nama","Nama",50,50,$d->nama,$psn,"DISABLED");
        $f->text("f_mr_rs","MR lama",50,50,"$d->mr_rs","DISABLED");
        $f->text("f_tmp_lahir","Tempat Lahir",50,50,"$d->tmp_lahir","DISABLED");
        $f->text("f_tgl_lahir","Tanggal Lahir",50,50,date("d M Y", pgsql2mktime($d->tgl_lahir)),"DISABLED");
        $f->text("f_umur","Umur",5,3,$d->umur,"DISABLED");
        $f->text("f_alm_tetap","Alamat Tetap",50,150,"$d->alm_tetap, $d->kota_tetap, $d->pos_tetap","DISABLED");
        $f->text("f_tlp_tetap","Telepon",15,15,$d->tlp_tetap,"DISABLED"); 
        $f->text("f_no_ktp","Nomor KTP/SIM/KTA",50,50,"$d->no_ktp","DISABLED"); 
		$f->text("f_pangkat_gol","Pangkat/Golongan ",50,50,"$d->pangkat_gol","DISABLED");
		$f->text("f_nrp_nip","NRP/NIP ",50,50,"$d->nrp_nip","DISABLED");
		$f->text("f_kesatuan","Kesatuan/Instansi/Pekerjaan ",50,50,"$d->kesatuan","DISABLED"); 	
        $f->subtitle("Registrasi");
        $f->text("no_reg","No. Registrasi",12,12,"<OTOMATIS>","DISABLED");           
          if ($_SESSION[uid] == "igd") {	        	
	        $f->selectArray("f_rawat_inap", "Rawatan",Array("N" => "IGD"),"N", "OnChange=\"setPoli(this.value);\"");
	        $f->PgConn = $con;
			$f->selectSQL("f_poli", "Poli","select '' as tc, '-' as tdesc union ".
							"SELECT tc,tdesc FROM rs00001 WHERE tt = 'LYN' and tc not in ('000','201','202','206','207','208','110')
							 order by tdesc ","", "DISABLED");	
	        // edit by. yudha } elseif ($_SESSION[uid] == "daftar" || $_SESSION[uid] == "daftarri") {
		        } elseif ( $_SESSION[uid] == "daftarri") {
	        $f->selectArray("f_rawat_inap", "Rawatan",Array("Y" => "Rawat Jalan"),"Y", "OnChange=\"setPoli(this.value);\"");
			// $f->selectArray("f_rawat_inap", "Rawatan",Array("Y" => "Rawat Jalan", "N" => "IGD"), "Y", "OnChange=\"setPoli(this.value);\"");	       
	        $f->PgConn = $con;
	        $f->selectSQL2("f_poli", "Poli","select '' as tc, '-' as tdesc union ".
							"SELECT tc,tdesc FROM rs00001 WHERE tt = 'LYN' and tc not in ('000','201','202','206','207','208','110')
							 order by tdesc ","", "",$psn2);		
			} else {
			// Agung SUnandar 13:54 06/06/2012
	        //$f->selectArray("f_rawat_inap", "Rawatan",Array("Y" => "Rawat Jalan", "N" => "IGD", "I" => "PAKET INAP"), "N", "OnChange=\"setPoli(this.value);\"");
	        $f->selectArray("f_rawat_inap", "<font color='red'>Rawatan",Array("Y" => "Rawat Jalan", "N" => "IGD"), "N", "OnChange=\"setPoli(this.value);\"");
	        $f->PgConn = $con;
			$f->selectSQL2("f_poli", "<font color='red'>Pelayanan","select '' as tc, '-' as tdesc union ".
							"SELECT tc,tdesc FROM rs00001 WHERE tt = 'LYN' and tc not in ('000','100','201','202','206','207','208','110')
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
        $f->selectSQL("f_id_penjamin", "Penjamin","select tc, tdesc from rs00001 where tt = 'PJN' and tc != '000'","999","OnChange=\"setNoJaminan(this.value);\"");
        $f->text("f_no_jaminan","No Jaminan",50,50,"","DISABLED");                      
        $f->selectSQL("f_tipe", "<font color='red'>Tipe Pasien","select tc, tdesc from rs00001 where tt = 'JEP' and tc != '000' Order By tdesc Asc;","001","OnChange=\"setNoAss(this.value);\"");
		//$f->text("f_no_asuransi","No Asuransi",50,50,"","");  
		$f->text("f_no_asuransi", "No Asuransi", 50, 50,"","DISABLED");                     
        $f->selectSQL("f_diagnosa_sementara", "<font color='red'> Dokter Pemeriksa","select nama, nama from rs00017 WHERE pangkat LIKE '%DOKTER%' Order By nama Asc ;",
		              $d->diagnosa_sementara);
        $f->hidden("f_status_akhir_pasien","-");        
        $f->submit(" Registrasi ");        
		$f->execute();	
		echo "\n<script language='JavaScript'>\n";
        echo "function selectciu() {\n";
        echo "sWin = window.open('popup/ciu2.php', 'xWin', 'top=0,left=0,width=500,height=400,menubar=no,scrollbars=yes');\n";
        echo "sWin.focus();\n";
        echo "}\n";
        echo "</script>\n";
        
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
			document.Form1.f_poli.selectedIndex = -2;
            function setPoli( v )
            {
                document.Form1.f_poli.disabled = v == "N";
				document.Form1.f_poli.disabled = v == "I";
                document.Form1.f_poli.selectedIndex = document.Form1.f_poli.selectedIndex == -1 && v == "Y" ? 0 : v == "Y" ? document.Form1.f_poli.selectedIndex : -1;
				document.Form1.f_poli.selectedIndex = document.Form1.f_poli.selectedIndex == -2 && v == "Y" ? 0 : v == "Y" ? document.Form1.f_poli.selectedIndex : -2;
            }
        </SCRIPT>        
        <SCRIPT language="JavaScript">

            function setNmPenanggung( v )
            {
                  document.Form1.f_nm_penanggung.disabled = v == "001";
                  document.Form1.f_hub_penanggung.disabled = v == "001";

            }
        </SCRIPT>

		<SCRIPT language="JavaScript">
            function setNoJaminan( v )
            {
                  document.Form1.f_no_jaminan.disabled = v == "999";
            }
        </SCRIPT>	
		<SCRIPT language="JavaScript">
            function setNoAss( v )
            {
                  document.Form1.f_no_asuransi.disabled = v == "006";
            }
        </SCRIPT>
        <?php
    }
	}
} else {
    if ($_GET["registered"] == "N") {
    
    
    	?>
    	        <SCRIPT language="JavaScript">

            function Cekthis()
            {
            	 var pesan ;

            	document.Form1.reg.disabled=false ;
            	  pesan = "";   
            	  if (document.Form1.f_nama.value == "") {
                       pesan = " Nama, "  ;
                	document.Form1.reg.disabled=true ;
                  } 
            	  if (document.Form1.f_no_ktp.value == "") {
            	  	 pesan =  pesan + " No. KTP/SIM/KTA, "  ;
                 	document.Form1.reg.disabled=true ;
                  } 
            	  if (document.Form1.f_alm_tetap.value == "") {
			 pesan = pesan + " Alamat "  ;
                 	document.Form1.reg.disabled=true ;
                  }                     
   		  if (pesan) {alert(pesan + " Harus Di Isi");}
            }
function hitung2(){
var umur,tahun ;   
tahun = Math.round(document.Form1.tahun.value)  ;  
umur = Math.round(document.Form1.umur.value);    
document.Form1.f_tgl_lahirY.value = tahun + umur ;
}

function hitungTanggalLahir(){
	var tahun = parseInt(document.Form1.f_tgl_lahirY.value);
	var bulan = parseInt(document.Form1.f_tgl_lahirM.value)-1;
	var tanggal = parseInt(document.Form1.f_tgl_lahirD.value);
	var tanggalan = new Date();
	var today = new Date();
	var jml_hari = 0;
	if(isNaN(parseInt(document.Form1.f_umur_tanggal.value))){
		jml_hari = 0;
		}
	else{
		jml_hari = parseInt(document.Form1.f_umur_tanggal.value);
		}
	var tgl_lahir = parseInt(today.getDate()) - jml_hari;	
	
	var jml_bulan = 0;	
	if(tgl_lahir<1){
		jml_bulan++;
		tanggalan = new Date(tahun, bulan, 0);
		tgl_lahir = tanggalan.getDate()+tgl_lahir;
		}
	if(isNaN(parseInt(document.Form1.f_umur_bulan.value))){
		jml_bulan = 0;
		}
	else{		
		jml_bulan = parseInt(document.Form1.f_umur_bulan.value) + jml_bulan;
		}
		var selisih_bulan = parseInt(today.getMonth()+1) - jml_bulan;
		jml_tahun = 0;
	if(selisih_bulan<1){
		jml_tahun++;
		jml_bulan = 12+selisih_bulan;
		}
	if(isNaN(parseInt(document.Form1.f_umur.value))){
		jml_tahun = 0;
		}
	else{
		jml_tahun = parseInt(document.Form1.f_umur.value)+jml_tahun;
		}
	document.Form1.f_tgl_lahirD.value = tgl_lahir;
	document.Form1.f_tgl_lahirM.value = jml_bulan;
	document.Form1.f_tgl_lahirY.value = parseInt(today.getFullYear()) - jml_tahun;
	}
function hitungUmur(){
	var today = new Date();
	var tahun = parseInt(document.Form1.f_tgl_lahirY.value);
	var bulan = parseInt(document.Form1.f_tgl_lahirM.value)-1;
	var tanggal = parseInt(document.Form1.f_tgl_lahirD.value);
	var lahir = new Date(tahun,bulan,tanggal);
	var selisih = Date.parse(today.toGMTString()) - Date.parse(lahir.toGMTString());
	var lastDay = new Date(tahun, bulan+1, 0);
	var umur_tahun = parseInt((selisih/(1000*60*60*24*365)));
	var umur_bulan = Math.round((selisih/(1000*60*60*24*365/12)))%12;
	var umur_hari  = parseInt((selisih/(1000*60*60*24)))%30;
	document.Form1.f_umur.value = umur_tahun;
	document.Form1.f_umur_bulan.value = umur_bulan;
	document.Form1.f_umur_tanggal.value = umur_hari;
}
        </SCRIPT>		
        <?php
        $okeh =" name=\"reg\"";
        $r8 = pg_query($con,"select max(mr_no) as mr_no from rs00002");
            $d8 = pg_fetch_object($r8);
            pg_free_result($r8);
            $_GET["mr_no"] = str_pad(((int) $d8->mr_no) + 1, 8, "0", STR_PAD_LEFT);
            $cuk = str_pad(((int) $d8->mr_no) + 1, 8, "0", STR_PAD_LEFT);
            ?><img border="0" src="lib/phpbarcode/barcode.php?code=<?echo $cuk;?>&encoding=128B&scale=1&mode=png" width="0" height="0">
            <?

	echo "\n<script language='JavaScript'>\n";
	echo "function hitung2() {\n";
	echo "       var umur,tahun ;   \n";
	echo "       umur = Math.round(document.Form1.umur.value);  \n";
	echo "       tahun = Math.round(document.Form1.tahun.value);    ; \n";
	echo "       document.Form1.f_tgl_lahirY.value = Math.round(document.Form1.tahun.value) - Math.round(document.Form1.umur.value);     \n";
	echo "        \n";
	echo "}\n";
	echo "</script>\n";

        $f = new Form("actions/110.insert.php", "POST", "NAME=Form1");
        $f->subtitle("Identitas");
        $f->subtitle("<font color='red'><b>*</b> : Harus Di Isi</font>");
        $f->hidden("mr_no","new");
        $f->hidden("p",$PID);
        $f->text("mr_no","No.MR",12,12,"<OTOMATIS>","DISABLED");
        $f->PgConn = $con;
        $f->textinfo("f_nama"         ,"<font color='red'>Nama *"       ,40,50,$_GET[f_nama],$psn," required");
        $f->textinfo("f_mr_rs","MR lama",40,50,""           ,""   ," ");
        $f->selectArray("f_jenis_kelamin", "<font color='red'>Jenis Kelamin",Array("L" => "Laki-laki", "P" => "Perempuan"),"");
        $f->textinfo("f_tmp_lahir","<font color='red'>Tempat Lahir",40,40,"",$psn," required");
	$f->selectDate_reg("f_tgl_lahir", "Tanggal Lahir", getdate(), 'onChange="hitungUmur()"');
	$name['tahun']='f_umur';$size['tahun']='3';$ext['tahun']='style="text-align:right;" onkeyup="hitungTanggalLahir()"';$def_val['tahun']='0';
	$name['bulan']='f_umur_bulan';$size['bulan']='3';$ext['bulan']='style="text-align:right;" onkeyup="hitungTanggalLahir()"';$def_val['bulan']='0';
	$name['hari']='f_umur_tanggal';$size['tanggal']='3';$ext['hari']='style="text-align:right;" onkeyup="hitungTanggalLahir()"';$def_val['hari']='0';
	$f->textUmurTahunBulanHari($name,"Umur",$size,$max_length,$def_val,$ext);
	$thn=getFromTable("select to_char(CURRENT_DATE,'yyyy') ");
	$f->hidden("tahun",$thn);
        $f->selectSQL("f_agama_id", "Agama","select tc, tdesc from rs00001 where tt = 'AGM' and tc != '000' order by tc","");
        $f->textinfo("f_no_ktp","<font color='red'>Nomor KTP/SIM/KTA *",50,50,"","-"," required"); 
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
        $f->textinfo("f_alm_tetap","<font color='red'>Alamat *",50,50,"",$psn," required");
		$f->textinfo("f_kota_tetap","<font color='red'>Kota *",50,50,"",$psn," required");
        $f->text("f_pos_tetap","Kode Pos",5,5,"");
        $f->text("f_tlp_tetap","<font color='red'>Telepon *",15,15,null," required");


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

		$f->subtitle("TIPE PASIEN");
        $f->selectSQL("f_tipe_pasien", "<font color='red'>Tipe Pasien",
        			  "select tc, tdesc from rs00001 where tt = 'JEP' and tc != '000' order by tc asc","001");                      
        $f->selectArray("cek_printer", "CETAK KARTU BEROBAT ? ",Array("Y" => "CETAK", "N" => "TIDAK DI CETAK "),"Y"); 
        
        $f->submit(" Registrasi ",$okeh);
        
        $f->execute();
        
        ?>
        <script>
        document.Form1.f_nama.focus();
        </script>
        <?
        
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
        $f->text("f_tmp_lahir","Tempat Lahir Bayi",35,40,"Sragen");
        $f->selectDate("f_tgl_lahir", "Tanggal Lahir Bayi", getdate());
        
        $f->hidden("f_mr_no_ibu",$_SESSION["IBU"]["id"]);
        $f->hidden("f_is_bayi","Y");
        
        $f->selectSQL("f_gol_darah", "Golongan Darah ","select '' as tc, '-' as tdesc union ".
        			  "select tc, tdesc from rs00001 where tt = 'GOL' and tc != '000'","");
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

		$f->subtitle("Tipe Pasien");
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
        $t->SQL = "select a.mr_no, a.nama,a.mr_rs,a.tmp_lahir,a.umur,a.kesatuan,b.tdesc,a.alm_tetap||'&nbsp;'||a.kota_tetap,a.tlp_tetap, ".
			" a.mr_no as href FROM rs00002 a ".
                        "left join rs00001 b on a.tipe_pasien = b.tc and b.tt = 'JEP'".
			"where (upper(a.nama) LIKE '%".strtoupper($_GET["search"])."%' OR a.mr_no LIKE '%".$_GET["search"]."%' or upper(a.alm_tetap) LIKE '%".strtoupper($_GET["search"])."%' or upper(a.kota_tetap) LIKE '%".strtoupper($_GET["search"])."%') 
			and (upper(a.nama) LIKE '%".strtoupper($_GET["search1"])."%' OR a.mr_no LIKE '%".$_GET["search1"]."%' or upper(a.alm_tetap) LIKE '%".strtoupper($_GET["search1"])."%' or upper(a.kota_tetap) LIKE '%".strtoupper($_GET["search1"])."%') 
			";
                	
		if (!isset($_GET[sort])) {
        	$_GET[sort] = "a.mr_no";
           	$_GET[order] = "asc";
		}
        $t->ColHeader = array("NO.MR","NAMA","MR LAMA","TEMPAT LAHIR","UMUR (TAHUN)","PEKERJAAN","TIPE PASIEN","ALAMAT","TELEPON","REGISTRASI");
        $t->ShowRowNumber = true;
        $t->ColAlign[0] = "CENTER";
        $t->ColAlign[2] = "CENTER";
        $t->ColAlign[4] = "CENTER";
        $t->ColAlign[9] = "CENTER";
        $t->RowsPerPage = 50;
	 //$t->RowsPerPage = $ROWS_PER_PAGE;
        //$t->DisableStatusBar = true;
		// sfdn, 27-12-2006 -> hanya pembetulan baris
	   	$t->ColFormatHtml[9] = "<nobr>
	   					<A CLASS=TBL_HREF "."HREF='$SC?p=$PID&q=reg&mr_no=<#9#>&is_baru=N'>".icon("ok","Registrasi")."</A>
                				</nobr>";
		// --- eof 27-12-2006
        $t->execute();
    }
}
?>
<script>
$("input[name='f_tgl_lahirY']").change( function(){

var tglLahir        = $(".hari_d").val();
var blnLahir        = $(".hari_m").val();
var thnLahir        = $("input[name='f_tgl_lahirY']").val();

var now = new Date();

var dayBD = parseInt(tglLahir);                
var monthBD = parseInt(blnLahir);             
var yearBD = parseInt(thnLahir);

var dayNow = now.getDate()-1;
var monthNow = now.getMonth()+1;
var yearNow = now.getFullYear();

umurTahun = yearNow-yearBD;
umurBulan = monthNow-monthBD;
umurHari  = (dayNow-dayBD)-1;

if(monthNow<monthBD){
umurBulan = umurBulan+12;
umurTahun = umurTahun-1;
}

if(dayNow<dayBD){
umurHari = umurHari+30;
umurBulan = umurBulan-1;
if(umurBulan<0){
umurBulan = 0;
umurTahun = umurTahun = (yearNow-yearBD)-1;
}
}

$("input[name='umur']").val(umurTahun);	
$("input[name='bulanlahir']").val(umurBulan);
$("input[name='harilahir']").val(umurHari);
});
$("input[name='umur']").after('tahun');
$("input[name='bulanlahir']").after('bulan');
$("input[name='harilahir']").after('hari');
</script>
<?
//session_destroy();
//} // end of $_SESSION[uid] == daftar || igd
?>
