<? // Agung S.

$PID = "lap_pend_kasir";
$SC = $_SERVER["SCRIPT_NAME"];

require_once("startup.php");
require_once("lib/functions.php");
	echo '<br/>';
    //title("<img src='icon/keuangan-2.gif' align='absmiddle' width='32' > LAPORAN PENDAPATAN KASIR");
    title_print("<img src='icon/keuangan-2.gif' align='absmiddle' width='32' > LAPORAN PENDAPATAN KASIR");
		  
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
	/**
	$f->selectSQL("mKASIR", "Petugas Kasir", "SELECT '' AS id, '' AS nama UNION SELECT uid as id, nama FROM rs99995 WHERE grup_id = 'RSPA-KASIR' ORDER BY nama ASC", $_GET["mKASIR"], "");
	*/
    $f->selectArray("shift", "Shift Kerja", array("07:00 - 14:00"=>"07:00 - 14:00 (Pagi)", "14:01 - 21:00"=>"14:01 - 21:00 (Siang)", 
	"21:01 - 23:59"=>"21:01 - 23:59 (Malam)", "00:00 - 06:59"=>"00:00 - 06:59 (Malam)", "00:00 - 23:59"=>"00:00 - 23:59 (Hari)"), $_GET['shift']);
    $f->selectArray("kasir", "Kasir", array(""=>"","BYI"=>"Rawat Inap", "BYR"=>"Rawat Jalan","BYD"=>"IGD"), $_GET['kasir']);
    $f->submit ("TAMPILKAN");
    $f->execute();
    echo "<br>";
	$shift = explode('-', $_GET['shift']); 

	if(empty($_GET['kasir'])){
	  $SQL_WHERE = "AND (rs00005.kasir='BYI' OR rs00005.kasir='BYR' OR rs00005.kasir='BYD')";
	}
	else {
	  $SQL_WHERE = "AND rs00005.kasir='".$_GET['kasir']."'";
	}
      
	$rowsJumlah   = pg_query($con, "SELECT rs00005.tgl_entry, SUM(rs00005.jumlah) AS jumlah
                                        FROM rs00005
                                        JOIN rs99995 ON rs00005.user_id = rs99995.uid".
                                        //AND uid = '".$_GET["mKASIR"]."'
				       " JOIN rs00006 ON rs00005.reg = rs00006.id::text
                                        JOIN rs00002 ON rs00006.mr_no = rs00002.mr_no AND rs00006.tipe IN ('001','002')
					
                                        WHERE (rs00005.tgl_entry::date between '$ts_check_in1' AND '$ts_check_in2') ".$SQL_WHERE.
					"AND cab NOT LIKE '002' AND waktu_bayar BETWEEN '".$shift[0]."' AND '".$shift[1]."' GROUP BY tgl_entry ");
     
	$rowsTagihan   = pg_query($con, "SELECT rs00002.nama, rs00005.cab, rs00005.reg, rs00005.no_kwitansi, rs00005.tgl_entry, SUM(rs00005.jumlah) AS jumlah, to_char(waktu_bayar,'HH24:MI:SS') AS waktu_bayar
                                        FROM rs00005
                                        JOIN rs99995 ON rs00005.user_id = rs99995.uid
                                        JOIN rs00006 ON rs00005.reg = rs00006.id::text
                                        JOIN rs00002 ON rs00006.mr_no = rs00002.mr_no AND rs00006.tipe IN ('001','002')
                                        WHERE (rs00005.tgl_entry::date between '$ts_check_in1' AND '$ts_check_in2') ".$SQL_WHERE.
                                        //AND uid = '".$_GET["mKASIR"]."'  
					" AND waktu_bayar BETWEEN '".$shift[0]."' AND '".$shift[1]."'".
					" GROUP BY reg, waktu_bayar, cab,no_kwitansi, tgl_entry, rs00002.nama ORDER BY  tgl_entry, waktu_bayar ASC");

	$thisUrl = apache_getenv("REQUEST_URI");
	//$excelUrl = "includes/lap_pend_kasir_xls.php?tanggal1D=".$_GET['tanggal1D']."&tanggal1M=".$_GET['tanggal1M']."&tanggal1Y=".$_GET['tanggal1Y']."&tanggal2D=".$_GET['tanggal2D']."&tanggal2M=".$_GET['tanggal2M']."&tanggal2Y=".$_GET['tanggal2Y']."&mKASIR=".$_GET['mKASIR'];
/**	title_excel($PID.'&tanggal1D='.$_GET['tanggal1D'].'&tanggal1M='.$_GET['tanggal1M'].'&tanggal1Y='.$_GET['tanggal1Y'].
'&tanggal2D='.$_GET['tanggal2D'].'&tanggal2M='.$_GET['tanggal2M'].'&tanggal2Y='.$_GET['tanggal2Y'].'&shift='.$_GET['shift']);
*/

?>
<!-- &nbsp;&nbsp;&nbsp; <a href="<?php echo $excelUrl?>&xls=true" target="_blank"><img border="0" src="icon/Excel-22.gif" width="24"><b>&nbsp; [ Download To Excel ]</b></a> -->
<!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="<?php echo $excelUrl?>" target="_blank"><img border="0" src="icon/print_icon.gif" width="24"><b>&nbsp; [ Cetak ]</b></a> -->

<br/><br/>

<table width='100%'>
	<tr>
		<td width="70%" valign="top">
			<table width='100%'>
				<tr>
					<td class="TBL_HEAD" width='3%'><center>No.</center></td>
					<td class="TBL_HEAD" width='12%' ><center>Waktu Pembayaran</center></td>
					<td class="TBL_HEAD" width='12%' ><center>No. Register</center></td>
					<td class="TBL_HEAD" width='' ><center>Nama</center></td>
					<td class="TBL_HEAD" width='18%' ><center>No. Kwitansi</center></td>
					<td class="TBL_HEAD" width='18%' ><center>Tanggal</center></td>
					<td class="TBL_HEAD" width='10%'><center>Jumlah</center></td>
				</tr>
				<?php
					$iData          = 0;
					$total          = 0;
					while($rowTagihan=pg_fetch_array($rowsTagihan)){
						$iData++;
						$tagihan_pembulatan = pembulatan($rowTagihan["jumlah"]);
						if($rowTagihan['cab']=='002'){
						  $tagihan_pembulatan = $tagihan_pembulatan*-1;
						}
						$total          = $total + $tagihan_pembulatan;
				?>
				<tr>
					<td class="TBL_BODY" align="right"><?=$iData?></td>
					<td class="TBL_BODY" align="left"><?=$rowTagihan["waktu_bayar"]?></td>
					<td class="TBL_BODY" align="left"><?=$rowTagihan["reg"]?></td>
					<td class="TBL_BODY" align="left"><?=$rowTagihan["nama"]?></td>
					<td class="TBL_BODY" align="left"><?=$rowTagihan["no_kwitansi"]?></td>
					<td class="TBL_BODY" align="right"><?=tanggal($rowTagihan["tgl_entry"])?></td>
					<td class="TBL_BODY" align="right"><?= number_format($tagihan_pembulatan,'0', '', '.')?></td>
				</tr>
				<?php
					}
				?>
				<tr>
					<td class="TBL_HEAD" colspan="6" align="right">T O T A L &nbsp;&nbsp;</td>
					<td class="TBL_HEAD" width='8%' align="right"><?php echo number_format($total,'0', '', '.') ?></td>
				</tr>
			</table>
		</td>
		<td width="30%" valign="top">
			<table width='100%'>
				<tr>
					<td class="TBL_HEAD" width='3%'><center>No.</center></td>
					<td class="TBL_HEAD" width='12%' ><center>Tanggal</center></td>
					<td class="TBL_HEAD" width='8%'><center>Jumlah</center></td>
				</tr>
				<?php
					$iData          = 0;
					$total          = 0;
					while($rowJumlah=pg_fetch_array($rowsJumlah)){
						$iData++;
						
						$total          = $total + $rowJumlah["jumlah"];
				?>
				<tr>
					<td class="TBL_BODY" align="right"><?=$iData?></td>
					<td class="TBL_BODY" align="right"><?=tanggal($rowJumlah["tgl_entry"])?></td>
					<td class="TBL_BODY" align="right"><?= number_format($rowJumlah["jumlah"],'0', '', '.')?></td>
				</tr>
				<?php
					}
				?>
				<tr>
					<td class="TBL_HEAD" colspan="2" align="right">T O T A L &nbsp;&nbsp;</td>
					<td class="TBL_HEAD" width='8%' align="right"><?php echo number_format($total,'0', '', '.') ?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php
function tanggal($tanggal) {
        $arrTanggal = explode('-', $tanggal);

        $hari = $arrTanggal[2];
        $bulan = $arrTanggal[1];
        $tahun = $arrTanggal[0];

        $result = $hari . ' ' . bulan($bulan) . ' ' . $tahun;

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
    }
    return $bln;
}
?>
