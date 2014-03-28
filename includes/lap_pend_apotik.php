<?php
/*--------------
 * 2013-03-07
 * wildan sawaludin code
--------------*/

session_start();
$PID = "lap_pend_apotik";
$SC = $_SERVER["SCRIPT_NAME"];

require_once("startup.php");
require_once("lib/form.php");

//--start
if (!$GLOBALS['print']){
    title_print("<img src='icon/keuangan-2.gif' align='absmiddle' > <b>LAPORAN PENDAPATAN APOTIK (OBAT)</b>");
    title_excel("lap_penj_obat&tanggal1D=".$_GET["tanggal1D"]."&tanggal1M=".$_GET["tanggal1M"]."&tanggal1Y=".$_GET["tanggal1Y"]."".
        "&tanggal2D=".$_GET["tanggal2D"]."&tanggal2M=".$_GET["tanggal2M"]."&tanggal2Y=".$_GET["tanggal2Y"]."".
        "&mUNIT=".$_GET["mUNIT"]."&mPASIEN=".$_GET["mPASIEN"]."&mKATEGORY=".$_GET["mKATEGORY"]."&mDOKTER=".$_GET["mDOKTER"]."");
} else {
    title("<img src='icon/keuangan.gif' align='absmiddle' > Laporan Pendapatan Apotik (Obat)");
    title_excel("lap_penj_obat&tanggal1D=".$_GET["tanggal1D"]."&tanggal1M=".$_GET["tanggal1M"]."&tanggal1Y=".$_GET["tanggal1Y"]."".
        "&tanggal2D=".$_GET["tanggal2D"]."&tanggal2M=".$_GET["tanggal2M"]."&tanggal2Y=".$_GET["tanggal2Y"]."".
        "&mUNIT=".$_GET["mUNIT"]."&mPASIEN=".$_GET["mPASIEN"]."&mKATEGORY=".$_GET["mKATEGORY"]."&mDOKTER=".$_GET["mDOKTER"]."");
}


//if (!$GLOBALS['print']) {
//    echo "<DIV ALIGN=RIGHT><A HREF='$SC?p=$PID'>".icon("back","Kembali")."</a></DIV>";
//}

//--------------------------- start for print
$ts_check_in1 = date("Y-m-d", mktime(0,0,0,$_GET["tanggal1M"],$_GET["tanggal1D"],$_GET["tanggal1Y"]));
$ts_check_in2 = date("Y-m-d", mktime(0,0,0,$_GET["tanggal2M"],$_GET["tanggal2D"],$_GET["tanggal2Y"]));

if ($_GET["mUNIT"] == "Y") {
    $unit = "Rawat Jalan";
} elseif  ($_GET["mUNIT"] == "N"){
    $unit = "IGD";
} elseif ($_GET["mUNIT"] == "I"){
    $unit = "Rawat Inap";
} else {
    $unit = "Semua";
}

if ($_GET["mPASIEN"] != '') {
    $pasien = getFromTable(
               "select tdesc from rs00001 ".
               "where tc = '".$_GET["mPASIEN"]."' and tt='JEP'");
} else {
    $pasien = "Semua";
}

if ($_GET["mKATEGORY"] != '') {
    $kategory = getFromTable(
               "select tdesc from rs00001 ".
               "where tc = '".$_GET["mKATEGORY"]."' and tt='GOB'");
} else {
    $kategory = "Semua";
}
if ($_GET["mDOKTER"] != '') {
    $dokter = getFromTable(
               "select nama from rs00017 ".
               "where nama = '".$_GET["mDOKTER"]."' and pangkat LIKE '%DOKTER%' Order By nama Asc;");
} else {
    $dokter = "Semua";
}

//--------------------------- start for print

if(!$GLOBALS['print']){
    $f = new Form($SC, "GET", "NAME=Form1");
    $f->PgConn = $con;
    $f->hidden("p", $PID);

    if (!isset($_GET['tanggal1D'])) {

        $tanggal1D = date("d", time());
        $tanggal1M = date("m", time());
        $tanggal1Y = date("Y", time());
        $tanggal2D = date("d", time());
        $tanggal2M = date("m", time());
        $tanggal2Y = date("Y", time());
    
        $ts_check_in1 = date("Y-m-d", mktime(0,0,0,0,0,0));
        $ts_check_in2 = date("Y-m-d", mktime(0,0,0,0,0,0));
        $f->selectDate("tanggal1", "Dari Tanggal", getdate(mktime(0,0,0,$tanggal1M,$tanggal1D,$tanggal1Y)), "");
        $f->selectDate("tanggal2", "s/d Tanggal", getdate(mktime(0,0,0,$tanggal2M,$tanggal2D,$tanggal2Y)), "");

    } else {

        $ts_check_in1 = date("Y-m-d", mktime(0,0,0,$_GET["tanggal1M"],$_GET["tanggal1D"],$_GET["tanggal1Y"]));
        $ts_check_in2 = date("Y-m-d", mktime(0,0,0,$_GET["tanggal2M"],$_GET["tanggal2D"],$_GET["tanggal2Y"]));
        $f->selectDate("tanggal1", "Dari Tanggal", getdate(mktime(0,0,0,$_GET["tanggal1M"],$_GET["tanggal1D"],$_GET["tanggal1Y"])), "");
        $f->selectDate("tanggal2", "s/d Tanggal", getdate(mktime(0,0,0,$_GET["tanggal2M"],$_GET["tanggal2D"],$_GET["tanggal2Y"])), "");
        
    }
    
    $f->selectArray("mUNIT", "Rawatan",
        Array(""=>"", "Y" => "Rawat Jalan", "I" => "Rawat Inap", "N" => "IGD"), $_GET["mUNIT"],
        $ext);


    $f->selectSQL("mPASIEN", "Tipe Pasien",
        "select '' as tc, '' as tdesc union ".
        "select tc, tdesc ".
        "from rs00001  ".
        "where tt='JEP' and tc != '000' order by tdesc", $_GET["mPASIEN"],
        $ext);
 
    $f->selectSQL("mKATEGORY", "Kategori Obat",
        "select '' as tc, '' as tdesc union ".
        "select tc, tdesc ".
        "from rs00001  ".
        "where tt='GOB' and tc != '000' order by tdesc", $_GET["mKATEGORY"],
        $ext);
    
    $f->selectSQL("mDOKTER", "Dokter",
        "select '' as nm_dok, '' as nama union ".
        "select nama as nm_dok, nama ".
        "from rs00017 ".
        "WHERE pangkat LIKE '%DOKTER%' order by nama ;", $_GET["mDOKTER"],
        $ext);

    $f->selectArray("shift", "Shift",  Array(""=>"","P" => "Shift Pagi (07.00-14.00)", "S" => "Shift Siang (14.01-20.00)" , "M1" => "Shift Malam (20.01-23.59)", "M2" => "Shift Malam (00.00-06.59)"  ), $_GET["shift"]," ");
    
    $f->submit ("TAMPILKAN");
    $f->execute();
} else {
    $f = new Form("");
    $f->titleme("Dari Tanggal &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: $ts_check_in1");
    $f->titleme("s/d Tanggal  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: $ts_check_in2");
    $f->titleme("Rawatan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: $unit");
    $f->titleme("Tipe Pasien &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: $pasien");
    $f->titleme("Kategori &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: $kategory");
    $f->titleme("Dokter &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: $dokter");
    $f->execute();
}

echo "<br>";
if (!isset($_GET[sort])) {
       $_GET[sort] = "no_reg";
       $_GET[order] = "asc";
}
// Shift Kerja
if ($_GET["shift"]=="P"){
	$jam1="07:00:00";
	$jam2="14:00:00";
	}elseif($_GET["shift"]=="S"){
	$jam1="14:01:00";
	$jam2="20:00:00";
	}elseif($_GET["shift"]=="M1"){
	$jam1="20:01:00";
	$jam2="23:59:00";
	}elseif($_GET["shift"]=="M2"){
	$jam1="00:00:00";
	$jam2="06:59:00";
	}else{
	$jam1="00:00:00";
	$jam2="23:59:59";
	}


//-- add param start
$addParam = '';
if($_GET['mUNIT'] != ''){
    $addParam = $addParam." AND b.rawat_inap = '".$_GET['mUNIT']."' ";
}
if($_GET['mPASIEN'] != ''){
    $addParam = $addParam." AND d.tc = '".$_GET['mPASIEN']."' ";
}
if($_GET['mKATEGORY'] != ''){
    $addParam = $addParam." AND e.kategori_id = '".$_GET['mKATEGORY']."' ";
}
if($_GET['mDOKTER'] != ''){
    $addParam = $addParam." AND b.diagnosa_sementara = '".$_GET['mDOKTER']."' ";
}
//-- add param end

?>

<SCRIPT language="JavaScript" src="plugin/jquery-1.8.2.js"></SCRIPT>
<SCRIPT language="JavaScript" src="plugin/jquery-ui.js"></SCRIPT>
<LINK rel="stylesheet" type="text/css" href="plugin/jquery.ui.theme.css">
<LINK rel="stylesheet" type="text/css" href="plugin/jquery.ui.datepicker.css">
<?php

//-- jumlah tuslah obat racikan
$rRacikan = pg_query($con,
          "select ".
          "		CASE WHEN e.kategori_id::numeric=020 THEN (a.qty * 100)
		            ELSE 0
		       	END as harga_tuslah ".
          "from rs00008 a ".
          "     left join rs00006 b ON a.no_reg = b.id ".
          "     left join rs00001 d ON (b.tipe = d.tc and d.tt = 'JEP') ".
          "     left join rs00016 f ON a.item_id = f.obat_id::character varying ".
          "     left join rs00015 e ON to_number(a.item_id,'999999999999') = e.id ".
          "where (a.tanggal_trans between '$ts_check_in1' and '$ts_check_in2') and ".
          "     (a.trans_type::text = 'OB1'::text OR a.trans_type::text = 'RCK'::text) ".
          "     ".$addParam." and (b.waktu_reg between '$jam1' and '$jam2') ");

while($aRacikan = pg_fetch_array($rRacikan)) {
	$totalTuslahRacikan += $aRacikan['harga_tuslah'];
}
//--

//-- jumlah tuslah obat grand total
$rowsObatTotal = pg_query($con,
		  "select sum(a.harga) as jual, ".
          "sum((a.referensi::numeric)) as tuslah, ".
          "sum((a.qty * a.harga)+(a.referensi::numeric)) as jum ".
          "from rs00008 a ".
          "     left join rs00006 b ON a.no_reg = b.id ".
          "     left join rs00001 d ON (b.tipe = d.tc and d.tt = 'JEP') ".
          "     left join rs00016 f ON a.item_id = f.obat_id::character varying ".
          "     left join rs00015 e ON to_number(a.item_id,'999999999999') = e.id ".
          "where (a.tanggal_trans between '$ts_check_in1' and '$ts_check_in2') and ".
          "     (a.trans_type::text = 'OB1'::text OR a.trans_type::text = 'RCK'::text) ".
          "     ".$addParam." and (b.waktu_reg between '$jam1' and '$jam2') ");

$rowsObatGrandTotal = pg_fetch_object($rowsObatTotal);
pg_free_result($rowsObatTotal);
//--

//-- rows semua obat
$rowsObat = pg_query($con, "select a.tanggal_trans as tgl, a.nmr_transaksi as nmr_transaksi, a.no_reg as no_reg, c.mr_no as mr_no, c.nama as nama, ".
          "     e.obat as obat, a.qty as qty, f.harga::integer as harga_pokok, ".
          "		CASE WHEN e.kategori_id::numeric=020 THEN (a.harga - 100)
		            ELSE a.harga::numeric
		       	END as harga_jual, ".
          "		CASE WHEN e.kategori_id::numeric=020 THEN (a.qty * 100)
		            ELSE a.referensi::numeric
		       	END as harga_tuslah, ".
          "		sum((a.qty * a.harga)+(a.referensi::numeric)) as harga_total ".
          "from rs00008 a ".
          "     left join rs00006 b ON a.no_reg = b.id ".
          "     left join rs00002 c ON b.mr_no = c.mr_no ".
          "     left join rs00001 d ON (b.tipe = d.tc and d.tt = 'JEP') ".
          "     left join rs00016 f ON a.item_id = f.obat_id::character varying ".
          "     left join rs00015 e ON to_number(a.item_id,'999999999999') = e.id ".
          "where ".
          "     (a.tanggal_trans between '$ts_check_in1' and '$ts_check_in2') and ".
          "     (a.trans_type::text = 'OB1'::text OR a.trans_type::text = 'RCK'::text) ".
          "     ".$addParam." and (b.waktu_reg between '$jam1' and '$jam2') ".
          "group by tgl, a.nmr_transaksi, a.no_reg, a.waktu_entry, c.mr_no, c.nama, e.obat, a.qty, a.harga, f.harga, a.referensi, e.kategori_id ".
          "order by a.nmr_transaksi, a.waktu_entry");
//--

//-- jumlah row tuslah obat grand total
$rowsTotalTuslahObats = pg_query($con, "select sum(a.harga) as jual, ".
          "		sum(CASE WHEN e.kategori_id::numeric=020 THEN (a.qty * 100)
		            ELSE a.referensi::numeric
		       	END) as tuslah, ".
          
          //"sum((a.referensi::numeric)) as tuslah, ".
          "sum((a.qty * a.harga)+(a.referensi::numeric)) as jum ".
          "from rs00008 a ".
          "     left join rs00006 b ON a.no_reg = b.id ".
          "     left join rs00001 d ON (b.tipe = d.tc and d.tt = 'JEP') ".
          "     left join rs00016 f ON a.item_id = f.obat_id::character varying ".
          "     left join rs00015 e ON to_number(a.item_id,'999999999999') = e.id ".
          "where (a.tanggal_trans between '$ts_check_in1' and '$ts_check_in2') and ".
          "     (a.trans_type::text = 'OB1'::text OR a.trans_type::text = 'RCK'::text) ".
          "     ".$addParam." and (b.waktu_reg between '$jam1' and '$jam2') group by a.nmr_transaksi order by a.nmr_transaksi ");

while($hargaTuslahObat = pg_fetch_array($rowsTotalTuslahObats)) {
	$hargaJualObats[]	.= $hargaTuslahObat['jual'];
	$hargaTuslahObats[]	.= $hargaTuslahObat['tuslah'];
	$hargaJumObats[]	.= $hargaTuslahObat['jum'];
}
//--

?>

<table id="list-pasien" width="100%">
    <thead>
        <tr>
            <td align="CENTER" class="TBL_HEAD" width="20">No.</td>
            <td align="CENTER" class="TBL_HEAD" width="60">TANGGAL TRANSAKSI</td>
            <td align="CENTER" class="TBL_HEAD" width="40">NO.RESEP</td>
            <td align="CENTER" class="TBL_HEAD" width="40">NO.REG</td>
            <td align="CENTER" class="TBL_HEAD" width="40">NO.MR</td>
            <td align="CENTER" class="TBL_HEAD" width="120">NAMA PASIEN</td>
            <td align="CENTER" class="TBL_HEAD" width="150">NAMA OBAT</td>
            <td align="CENTER" class="TBL_HEAD" width="40">QTY</td>
            <td align="CENTER" class="TBL_HEAD" width="55">HARGA POKOK</td>
            <td align="CENTER" class="TBL_HEAD" width="55">HARGA JUAL</td>
            <td align="CENTER" class="TBL_HEAD" width="55">TUSLAH</td>
            <td align="CENTER" class="TBL_HEAD" width="55">TOTAL (Rp.)</td>
        </tr>
    </thead>
    <tbody>
        <?php
            if(!empty($rowsObat)){
                 $i=1;
				 $j=0;
                 while($row=pg_fetch_array($rowsObat)){
                 	
					 $newTgl		= $row['tgl'];
					 $newNoRes		= $row['nmr_transaksi'];
					 $newNoReg		= $row['no_reg'];
					 $newNoMR		= $row['mr_no'];
					 $newNama		= $row['nama'];
					 $hargaTuslah	= 0;
					 $hargaTotal	= 0;
					 
					 if ($oldNoRes == $row['nmr_transaksi'] && $oldNoRes != '') {
						$ii='';
						$jj='';
					 } else {
					 	$ii=$i++;
						$jj=$j++;
					 }
					 
					 //if ($oldTgl == $row['tgl'] && $oldTgl != '') {
						//$newTgl = '';
						//$newTgl *ikut $newNoRes
					 //}
					 
					 if ($oldNoRes == $row['nmr_transaksi'] && $oldNoRes != '') {
						$newNoRes = '';
						$newTgl = '';
					 }
					 
					 if ($oldNoReg == $row['no_reg'] && $oldNoReg != '') {
						$newNoReg = '';
					 }
					 
					 if ($oldNoMR == $row['mr_no'] && $oldNoMR != '') {
						$newNoMR = '';
					 }
					 
					 if ($oldNama == $row['nama'] && $oldNama != '') {
						$newNama = '';
					 }
					 
					 if ($ii == '' || $newNoRes == '' || $newNoReg == '' || $newNoMR == '' || $newNama == '') {
						$hargaTuslah = '';
						$hargaTotal  = '';
					 } else {
					 	$hargaTuslah = $hargaTuslahObats[$jj];
						$hargaTotal  = $hargaJumObats[$jj];
					 }
					 
        ?>
        <tr>
            <td align="right"><?php echo $ii?></td>
            <td align="right"><?php echo tanggalShort($newTgl);?>&nbsp;&nbsp;&nbsp;</td>
            <td align="left">&nbsp;&nbsp;&nbsp;<?php echo $newNoRes;?></td>
            <td align="left"><a href="index2.php?p=lap_transaksi_pasien&no_reg=<?php echo $newNoReg;?>"><?php echo $newNoReg;?></a>&nbsp;&nbsp;&nbsp;</td>
            <td align="left">&nbsp;&nbsp;&nbsp;<?php echo $newNoMR;?></td>
            <td align="left">&nbsp;&nbsp;&nbsp;<?php echo $newNama;?></td>
            <td align="left">&nbsp;&nbsp;&nbsp;<?php echo $row['obat'];?></td>
            <td align="right"><?php echo $row['qty'];?>&nbsp;&nbsp;&nbsp;</td>
            <td align="right"><?php echo number_format($row['harga_pokok'],2);?>&nbsp;&nbsp;&nbsp;</td>
            <td align="right"><?php echo number_format($row['harga_jual'],2);?>&nbsp;&nbsp;&nbsp;</td>
            <td align="right"><?php echo number_format($hargaTuslah,2);?>&nbsp;&nbsp;&nbsp;</td>
            <td align="right"><?php echo number_format($hargaTotal,2);?>&nbsp;&nbsp;&nbsp;</td>
        </tr>
        <?php
        	$oldTgl		= $row['tgl'];
			$oldNoRes	= $row['nmr_transaksi'];
        	$oldNoReg	= $row['no_reg'];
			$oldNoMR	= $row['mr_no'];
			$oldNama	= $row['nama'];
                 }
            }
        ?>
        <tr>
	        <td colspan="10" class="TBL_HEAD" align="right">T O T A L</td>
	        <!--<td class="TBL_HEAD" align="right" id="jumlah_harga"><?php /*echo number_format($rowsObatGrandTotal->jual,2);*/?></td>-->
	        <td class="TBL_HEAD" align="right" id="jumlah_tuslah"><?php echo number_format($rowsObatGrandTotal->tuslah + $totalTuslahRacikan,2);?></td>
	        <td class="TBL_HEAD" align="right" id="jumlah_total"><?php echo number_format($rowsObatGrandTotal->jum,2);?></td>
	    </tr>
    </tbody>    
</table>

<script language="JavaScript" type="text/JavaScript">
$(document).ready(function() { 
	//jquery code here
});
</script>

<?php
function tanggal($tanggal) {
    $arrTanggal = explode('-', $tanggal);

    $hari = $arrTanggal[2];
    $bulan = $arrTanggal[1];
    $tahun = $arrTanggal[0];

    $result = $hari . ' ' . bulan($bulan) . ' ' . $tahun;

    return $result;
}

function tanggalShort($tanggal) {
    $arrTanggal = explode('-', $tanggal);

    $hari = $arrTanggal[2];
    $bulan = $arrTanggal[1];
    $tahun = $arrTanggal[0];

    $result = $hari . ' ' . substr(bulan($bulan),0,3) . ' ' . $tahun;

    return $result;
}

function bulan($params) {
    switch ($params) {
        case 1:
            $bln = "Januari";
            break;
        case 2:
            $bln = "Pebruari";
            break;
        case 3:
            $bln = "Maret";
            break;
        case 4:
            $bln = "April";
            break;
        case 5:
            $bln = "Mei";
            break;
        case 6:
            $bln = "Juni";
            break;
        case 7:
            $bln = "Juli";
            break;
        case 8:
            $bln = "Agustus";
            break;
        case 9:
            $bln = "September";
            break;
        case 10:
            $bln = "Oktober";
            break;
        case 11:
            $bln = "Nopember";
            break;
        case 12:
            $bln = "Desember";
            break;
            break;
    }
    return $bln;
}
?>
