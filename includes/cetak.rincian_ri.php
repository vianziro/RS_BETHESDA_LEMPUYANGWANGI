<?phpsession_start();require_once("../lib/setting.php");require_once("../lib/terbilang.php");require_once("../lib/dbconn.php");require_once("../lib/form.php");require_once("../lib/class.PgTable.php");require_once("../lib/functions.php");$ROWS_PER_PAGE = 999999;?><html>    <head>        <title><?php echo $RS_NAME; ?></title>        <link rel='styleSheet' type='text/css' href='../cetak.css'>        <link rel='styleSheet' type='text/css' href='../invoice.css'>        <script LANGUAGE="JavaScript">            <!-- Begin            function printWindow() {                bV = parseInt(navigator.appVersion);                if (bV >= 4) window.print();            }            //  End -->        </script>        <style type="text/css">			.white_border{				border-bottom:2px solid #ffffff;				}			.black_border{				border-bottom:2px solid #000000;				}			 #rincian td{				font-size:10pt;				letter-spacing: 0px;				white-space:nowrap;			 }			.infopasien td{				font-size:10pt;				letter-spacing: 0px;				white-space:nowrap;			 }			         </style>    </HEAD>    <BODY TOPMARGIN=0 LEFTMARGIN=5 MARGINWIDTH=0 MARGINHEIGHT=0 />  	<!--START KOP KWITANSI -->	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family: arial; font-size: 14px; letter-spacing: 0px;">		<tr valign="middle" >			<td rowspan="2" align="center">			<img width="70px" height="70px" src="../<?=$set_client_logo?>" style="margin-left:5px;margin-top:5px;" align="left"/>			<font color=white>				<div style="font-family: arial; font-size: 12px; color: #000; padding-left: 8px; padding-right: 8px;">&nbsp</div>			    <div style="font-family: arial; font-size: 14px; color: #000; padding-left: 8px; padding-right: 8px; font-weight: bold"><?=$set_header[0]?></div>				<div style="font-family: arial; font-size: 14px; color: #000; padding-left: 8px; padding-right: 8px; font-weight: bold"><?=$set_header[2]?></div>				<div style="font-family: arial; font-size: 14px; color: #000; padding-left: 8px; padding-right: 8px; font-weight: bold"><?=$set_header[3]?></div>			</font>		</tr>			</table>	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family: arial; font-size: 2px; letter-spacing: 0px;">	    <tr>	        <td align="left" style='border-top:solid 0px #000;border-bottom:solid 2px #000;'>&nbsp;</td>	    </tr>	    <tr>	        <td align="left" style='border-top:solid 2px #000;border-bottom:solid 0px #000;'>&nbsp;</td>	    </tr>	</table>	<!--END KOP KWITANSI -->    <?php        $reg = $_GET["rg"];    $rt = pg_query($con,            "SELECT a.id, to_char(a.tanggal_reg,'DD MONTH YYYY') AS tanggal_reg, a.waktu_reg, " .            "    a.mr_no, upper(e.nama)as nama, to_char(e.tgl_lahir, 'DD MONTH YYYY') AS tgl_lahir, " .            "    e.tmp_lahir, e.jenis_kelamin, f.tdesc AS agama, " .            "    upper(e.alm_tetap)as alm_tetap, upper(e.kota_tetap)as kota_tetap, e.umur, e.pos_tetap, e.tlp_tetap, " .            "    a.id_penanggung, b.tdesc AS penanggung, a.id_penjamin, " .            "    c.tdesc AS penjamin, a.no_jaminan,a.no_asuransi ,a.rujukan, a.rujukan_rs_id, " .            "    d.tdesc AS rujukan_rs, a.rujukan_dokter, a.rawat_inap, " .            "    a.status, a.tipe, g.tdesc AS tipe_desc, a.diagnosa_sementara, " .            "    to_char(a.tanggal_reg, 'DD MONTH YYYY') AS tanggal_reg_str, " .            "        CASE " .            "            WHEN a.rawat_inap = 'I' THEN 'Rawat Inap' " .            "            WHEN a.rawat_inap = 'Y' THEN 'Rawat Jalan' " .            "            ELSE 'IGD' " .            "        END AS rawat, " .            "        age(a.tanggal_reg , e.tgl_lahir ) AS umur, " .            "	case when a.rujukan = 'Y' then 'Rujukan' else 'Non-Rujukan' end as datang " .            "    , i.tdesc as poli,e.pangkat_gol,e.nrp_nip,e.kesatuan " .            "FROM rs00006 a " .            "   LEFT JOIN rs00001 b ON a.id_penanggung = b.tc AND b.tt = 'PEN'" .            "   LEFT JOIN rs00001 c ON a.id_penjamin = c.tc AND c.tt = 'PJN' " .            "   LEFT JOIN rs00002 e ON a.mr_no = e.mr_no " .            "   LEFT JOIN rs00001 f ON e.agama_id = f.tc AND f.tt = 'AGM' " .            "   LEFT JOIN rs00001 g ON a.tipe = g.tc AND g.tt = 'JEP' " .            "   LEFT JOIN rs00001 d ON a.id_penjamin = d.tc AND d.tt = 'RUJ' " .            "   LEFT JOIN rs00001 h ON a.jenis_kedatangan_id = h.tc AND h.tt = 'JDP' " .            "   left join rs00001 i on i.tc_poli = a.poli " .            "WHERE a.id = '$reg'  ");//"WHERE a.id = '$reg'");    $nt = pg_num_rows($rt);    if ($nt > 0)        $dt = pg_fetch_object($rt);    pg_free_result($rt);    if ($reg) {        if (getFromTable("select to_number(id,'9999999999') as id " .                        "from rs00006 " .                        "where id = '$reg' " .                        " ") == 0) {            //"and status = 'A'") == 0) {            $reg = 0;            $msg = "Nomor registrasi tidak ditemukan. Masukkan kembali nomor registrasi.";        }    }    //========= Kwitansi    if ($_GET[kas] == "rj") {        $ksr1 = "BYR";    } elseif ($_GET[kas] == "ri") {        $ksr1 = "BYI";    } elseif ($_GET[kas] == "igd") {        $ksr1 = "BYD";    }    $kwitansi = getFromTable("select max(new_id) from rs00005 where reg='$reg' and layanan != 'BATAL' and kasir='$ksr1' ");//==========    $r12 = pg_query($con,            "select a.id, a.ts_check_in::date, e.bangsal, d.bangsal as ruangan, b.bangsal as bed, " .            "    c.tdesc as klasifikasi_tarif, " .            "    extract(day from a.ts_calc_stop - a.ts_calc_start) as qty, " .            "    d.harga as harga_satuan, " .            "    extract(day from a.ts_calc_stop - a.ts_calc_start) * d.harga as harga, " .            "    a.ts_calc_stop " .            "from rs00010 as a " .            "    join rs00012 as b on a.bangsal_id = b.id " .            "    join rs00012 as d on substr(b.hierarchy,1,6) || '000000000' = d.hierarchy " .            "    join rs00012 as e on substr(b.hierarchy,1,3) || '000000000000' = e.hierarchy " .            "    join rs00001 as c on d.klasifikasi_tarif_id = c.tc and c.tt = 'KTR' " .            "where a.id  = (SELECT max(id) FROM rs00010 WHERE to_number(no_reg,'9999999999') = $reg and ts_calc_stop is not null)");    $nt1 = pg_num_rows($r12);    if ($nt1 > 0)        $dt1 = pg_fetch_object($r12);    pg_free_result($r12);    if ($_GET["kas"] == "rj") {        $kasir = ("Kasir Rawat Jalan");        $rawatan = "Poli Pendaftaran";        $poli = $dt->poli;    } elseif ($_GET["kas"] == "ri") {        $kasir = ("Kasir Rawat Inap");        $rawatan = "Bangsal";        $poli = $dt1->bangsal . " / " . $dt1->ruangan . " / " . $dt1->bed . " / " . $dt1->klasifikasi_tarif;    } else {        $kasir = ("Kasir IGD");        $rawatan = "Ruang";        $poli = "IGD";    }    include ("tagihan_ri");    ?>    <table cellpadding="0" cellspacing="0" class="items" >        <tbody>        <table width="100%" cellpadding="0" cellspacing="0">            <tr>                <td style="font-family: arial; font-size: 18px; letter-spacing: 0px;" align="center">					<u><b>Rincian Pasien Pulang</b></u>				</td>            </tr>            <tr>                <td style="font-family: arial; font-size: 12px; letter-spacing: 0px;" align="center">					<b><?=date("d / M Y",time())?> / RI</b>				</td>            </tr>        </table>        <?        $tgl_sekarang = date("d M Y",time());        ?>        <table border="0" class="infopasien" cellpadding="0" cellspacing="0" width="100%" style="margin-top:20px;">            <tr>                <td width="45%">                    <table border="0" class="none" cellpadding="0" cellspacing="0"  width="100%">                        <tr>                            <td>NO. KWITANSI</td>                            <td>:</td>                            <td><? echo $kwitansi; ?></td>                        </tr>						 <tr>                            <td>NO. REG</td>                            <td>:</td>                            <td><? echo $dt->id; ?></td>                        </tr>                        <tr>                            <td>NAMA</td>                            <td>:</td>                            <td><? echo $dt->nama; ?></td>                        </tr>                        <tr>                            <td>ALAMAT</td>                            <td>:</td>                            <td><? echo $dt->alm_tetap . " " . $dt->kota_tetap; ?></td>                        </tr>                        <tr>                            <td>NO. RM</td>                            <td>:</td>                            <td><? echo $dt->mr_no; ?></td>                        </tr>                        <tr>                            <td>&nbsp;</td>                        </tr>                    </table>                </td>                <td width="10%">&nbsp;</td>                <td width="45%">                    <table border="0" class="infopasien" cellpadding="0" cellspacing="0" width="100%">                        <tr>                            <td>RUANG / KELAS</td><td>:</td><td><? echo $poli; ?></td>                        </tr>                        <tr>                            <td>PENJAMIN</td><td>:</td><td><? echo $dt->tipe_desc; ?></td>                        </tr>                        <tr>                        <tr>                            <td>TGL MASUK</td><td>:</td><td><? echo tanggal_format((getFromTable("SELECT ts_check_in FROM rs00010 WHERE id = (SELECT MIN(id) FROM rs00010 WHERE no_reg='".$reg."')")),'d / m / Y'); ?></td>                        </tr>                        <tr>                            <td>TGL KELUAR</td><td>:</td><td><?php echo tanggal_format(getFromTable("SELECT ts_calc_stop FROM rs00010 WHERE id = (SELECT max(id) FROM rs00010 WHERE ts_calc_stop IS NOT NULL AND no_reg= '".$reg."')"),'d / m / Y'); ?></td>                        </tr>                        <tr>                            <td>&nbsp;</td>                        </tr>                    </table></td>            </tr>        </table>        <?php        $pembayar = getFromTable("select max(bayar) as jumlah from rs00005 " .                "where kasir in ('BYR','BYI','BYD') and " .                "to_number(reg,'999999999999') = '$reg' ");        if ($pembayar == '') {            $pembayar1 = $dt->nama;        } else {            $pembayar1 = $pembayar;        }        $i=1;        ?>        <br>		<table border="0" align="right" width="100%" cellpadding="0" cellspacing="0" id="rincian">		<?php if ($admin > 0){?>			<tr>				<td align="right"><?php echo $i++ ;?>.</td><td colspan="5" class="black_border"><span class="white_border">&nbsp;Pendaftaran</span></td><td>&nbsp;Rp.&nbsp;</td><td align="right"><?php echo number_format($admin - $adminPenjamin, 2) ?></td>			</tr>		<?php } 		if($adminRI>0){ ?>			<tr>				<td align="right"><?php echo $i++ ;?>.</td><td colspan="5" class="black_border">&nbsp;Administrasi</td><td>&nbsp;Rp.&nbsp;</td><td align="right"><?php echo number_format($adminRI - $adminPenjaminRI, 2)?></td>			</tr>			<?php }		?>			<tr>				<td align="right"><?php echo $i++ ;?>.</td><td colspan="6" >&nbsp;Pemeriksaan UGD</td><td>&nbsp;</td>			</tr>			<?php			if($layananDokter > 0){			//$periksa_query = pg_query("SELECT b.layanan, a.tagihan,a.dibayar_penjamin, c.nama FROM rs00008 a 			//JOIN rs00034 b ON  b.id = a.item_id::numeric AND b.layanan ILIKE '%pemeriksaan%'			//LEFT JOIN rs00017 c ON a.no_kwitansi = c.id WHERE a.no_reg = '".$_GET['rg']."' AND a.trans_type = 'LTM' ");			$periksa_query = pg_query("select b.layanan, a.tagihan,a.dibayar_penjamin, d.nama  from rs00008 a left join rs00034 b on b.id=a.item_id::numeric				left join rs00017 d on a.no_kwitansi = d.id left join rs00001 c on c.tc = b.sumber_pendapatan_id and c.tt='SBP'				where a.no_reg='".$_GET[rg]."' AND (a.trans_type='LTM') and c.tdesc like '%PEMERIKSAAN DOK%' ");		while($periksa = pg_fetch_array($periksa_query)){			?>						<tr>				<td>&nbsp;</td><td colspan="5">&nbsp;<?php echo $periksa['layanan']." - ".$periksa['nama'];?></td>				<td>&nbsp;Rp.&nbsp;</td><td align="right"><?php echo number_format($periksa['tagihan']-$periksa['dibayar_penjamin'], 2);?></td>			</tr>			<?php			}		}			if($akomodasi > 0){ 							$result	= pg_query("SELECT bangsal_id,harga, SUM(qty) AS qty, SUM(tagihan) AS tagihan, SUM(dibayar_penjamin) AS dibayar_penjamin FROM rs00008 WHERE trans_type = 'POS' AND no_reg = '".$reg."' AND tagihan > 0				GROUP BY bangsal_id, harga");			while($row = pg_fetch_array($result)){				?>							<tr>				<td align="right"><?php echo $i++ ;?>.</td><td>&nbsp;Kamar</td><td>:</td><td align="right"><?php echo $row['qty']?></td><td>Hari</td><td align="right">&#64; Rp. <?php echo number_format($row['harga'],2) ?></td><td>&nbsp;Rp.&nbsp;</td><td align="right"><?php echo number_format($row['tagihan']-$row['dibayar_penjamin'],2)?></td>			</tr>				<?php				}			}			if($akomodasiMakan > 0){ 				$result	= pg_query("select a.harga, SUM(a.qty) AS qty,SUM(tagihan) AS tagihan,SUM(dibayar_penjamin) AS dibayar_penjamin from rs00008 a									join rs00034 b on b.id=a.item_id::numeric 									join rs00001 c on c.tc = b.sumber_pendapatan_id and c.tt='SBP'  									where a.no_reg='".$reg."' AND (a.trans_type='LTM') AND b.layanan ILIKE '%Paket Makan%' GROUP BY a.harga");			while($row = pg_fetch_array($result)){				?>			<tr>				<td align="right"><?php echo $i++ ;?>.</td><td>&nbsp;Akomodasi</td><td>:</td><td align="right"><?php echo $row['qty'] ?></td><td>Hari</td><td align="right">&#64; Rp. <?php echo number_format($row['harga'],2) ?></td><td>&nbsp;Rp.&nbsp;</td><td align="right"><?php echo number_format($row['tagihan']-$row['dibayar_penjamin'],2) ?></td>			</tr>			<?php }			} if($visite > 0){ 			?>						<tr>				<td align="right"><?php echo $i++ ;?>.</td><td colspan="7">&nbsp;Visite</td>			</tr>				<?php				$result = pg_query("SELECT b.layanan, c.nama,SUM(a.qty) AS qty,a.harga, SUM(a.tagihan) AS tagihan,SUM(a.dibayar_penjamin) as dibayar_penjamin FROM rs00008 a 				    JOIN rs00034 b ON  b.id = a.item_id::numeric AND b.layanan ILIKE '%visite%' 				    LEFT JOIN rs00017 c ON a.no_kwitansi = c.id				    WHERE a.no_reg = '".$reg."' AND a.trans_type = 'LTM' GROUP BY b.layanan,c.nama,a.harga");				while($row = pg_fetch_array($result)){			?>			<tr>				<td align="right">&nbsp;</td><td>&nbsp;<?php echo $row['layanan'] ?></td><td>:</td><td align="right"><?php echo $row['qty'] ?></td><td>Hari</td><td align="right">&#64; Rp. <?php echo number_format($row['harga'],2) ?></td><td>&nbsp;Rp.&nbsp;</td><td align="right"><?php echo number_format($row['tagihan']-$row['dibayar_penjamin'],2) ?></td>			</tr>			<tr>				<td align="right">&nbsp;</td><td colspan="7">&nbsp;<?php echo $row['nama'] ?></td>			</tr>			<?php						}			}			if($konsultasiDokter>0){ ?>			<?php				$result = pg_query("SELECT b.layanan, c.nama,SUM(a.qty) AS qty,a.harga, SUM(a.tagihan) AS tagihan,SUM(a.dibayar_penjamin) as dibayar_penjamin FROM rs00008 a 				    JOIN rs00034 b ON  b.id = a.item_id::numeric AND (b.layanan ILIKE '%kontrol%' OR b.layanan ILIKE '%konsultasi%' OR b.layanan ILIKE '%kunjungan%') 				    JOIN rs00017 c ON a.no_kwitansi = c.id				    WHERE a.no_reg = '".$_GET['rg']."' AND a.trans_type = 'LTM' AND a.no_kwitansi <> 0 GROUP BY b.layanan,c.nama,a.harga");				while($row = pg_fetch_array($result)){			?>			<tr>				<td align="right">&nbsp;</td><td>&nbsp;<?php echo $row['layanan'] ?></td><td>:</td><td align="right"><?php echo $row['qty'] ?></td><td>Hari</td><td align="right">&#64; Rp. <?php echo number_format($row['harga'],2) ?></td><td>&nbsp;Rp.&nbsp;</td><td align="right"><?php echo number_format($row['tagihan']-$row['dibayar_penjamin'],2) ?></td>			</tr>			<tr>				<td align="right">&nbsp;</td><td colspan="7">&nbsp;<?php echo $row['nama'] ?></td>			</tr>			<?php						}			}			if($askep > 0){				$result = pg_query("select a.harga, SUM(a.qty) AS qty, SUM(a.tagihan) AS tagihan, SUM(a.dibayar_penjamin) AS dibayar_penjamin								from rs00008 a								join rs00034 b on b.id=a.item_id::numeric AND b.layanan ILIKE '%jasa perawatan%'								join rs00001 c on c.tc = b.sumber_pendapatan_id and c.tt='SBP'  								where a.no_reg='".$reg."' AND (a.trans_type='LTM') and c.tdesc like '%TINDAK%' GROUP BY a.harga");				while($row = pg_fetch_array($result)){			?>			<tr>				<td align="right"><?php echo $i++ ;?>.</td><td>&nbsp;Jasa Perawatan</td><td>:</td><td align="right"><?php echo $row['qty'] ?></td><td>Hari</td><td align="right">&#64; Rp. <?php echo number_format($row['harga'],2) ?></td><td>&nbsp;Rp.&nbsp;</td><td align="right"><?php echo number_format($row['tagihan']-$row['dibayar_penjamin'],2) ?></td>			</tr>			<?php }		} 			if($tindakanBangsal > 0){			?>			<tr>				<td align="right"><?php echo $i++ ;?>.</td><td colspan="5" class="black_border">&nbsp;Tindakan Bangsal</td><td>&nbsp;Rp.&nbsp;</td><td align="right"><?php echo number_format($tindakanBangsal - $tindakanBangsalPenjamin,2) ?></td>			</tr>			<?php 			}			if($obat>0){				?>			<tr>				<td align="right"><?php echo $i++ ;?>.</td><td colspan="5" class="black_border">&nbsp;Obat</td><td>&nbsp;Rp.&nbsp;</td><td align="right"><?php echo number_format($obat - $obatPenjamin,2) ?></td>			</tr>			<?php }			if($laborat > 0){			?>			<tr>				<td align="right"><?php echo $i++ ;?>.</td><td colspan="5" class="black_border">&nbsp;Laboratorium</td><td>&nbsp;Rp.&nbsp;</td><td align="right"><?php echo number_format($laborat - $laboratPenjamin,2)?></td>			</tr>			<?php }			if($transfusi>0){				?>			<tr>				<td align="right"><?php echo $i++ ;?>.</td><td colspan="5" class="black_border">&nbsp;Transfusi</td><td>&nbsp;Rp.&nbsp;</td><td align="right"><?php echo number_format($transfusi - $transfusiPenjamin,2) ?></td>			</tr>			<?php } 			if($ambulan>0){				?>			<tr>				<td align="right"><?php echo $i++ ;?>.</td><td colspan="5" class="black_border">&nbsp;Ambulan</td><td>&nbsp;Rp.&nbsp;</td><td align="right"><?php echo number_format($ambulan - $ambulanPenjamin,2) ?></td>			</tr>			<?php } 						if ($operasi > 0){						?>			<tr>				<td align="right"><?php echo $i++ ;?>.</td><td colspan="5" class="black_border">&nbsp;Operasi</td><td>&nbsp;Rp.&nbsp;</td><td align="right"><?php echo number_format($operasi - $operasiPenjamin,2) ?></td>			</tr>			<?php			  }						if ($anestesi > 0){						?>			<tr>				<td align="right"><?php echo $i++ ;?>.</td><td colspan="5" class="black_border">&nbsp;Anestesi</td><td>&nbsp;Rp.&nbsp;</td><td align="right"><?php echo number_format($anestesi - $anestesiPenjamin,2) ?></td>			</tr>			<?php			  }			if ($sewaKamarOperasi > 0){						?>			<tr>				<td align="right"><?php echo $i++ ;?>.</td><td colspan="5" class="black_border">&nbsp;Sewa Kamar Operasi</td><td>&nbsp;Rp.&nbsp;</td><td align="right"><?php echo number_format($sewaKamarOperasi - $sewaKamarOperasiPenjamin,2) ?></td>			</tr>			<?php			  }			  /**			if($konsultasi>0){ ?>			<tr>					<td align="right"><?php echo $i++ ;?>.</td><td colspan="5" class="black_border">&nbsp;Konsultasi</td><td>&nbsp;Rp.&nbsp;</td><td align="right"><?php echo number_format($konsultasi - $konsultasiPenjamin,2) ?></td>			</tr>			<?php 			}**/									if($tindakanMedis > 0){			?>			<tr>				<td align="right"><?php echo $i++ ;?>.</td><td colspan="5" class="black_border">&nbsp;Tindakan Medis</td><td>&nbsp;Rp.&nbsp;</td><td align="right">&nbsp;</td>			</tr>			<?php 			$result = pg_query("select b.layanan, d.nama, a.tagihan, a.dibayar_penjamin								from rs00008 a								left join rs00034 b on b.id=a.item_id::numeric AND layanan NOT ILIKE '%jasa perawatan%' AND hierarchy NOT LIKE '004003%' AND hierarchy NOT LIKE '004004%'								 AND hierarchy NOT LIKE '004005%' AND layanan NOT ILIKE '%jasa perawatan%' AND layanan NOT ILIKE '%konsultasi%' AND layanan NOT ILIKE '%fisioterapi%' AND layanan NOT ILIKE '%usg%'								 AND layanan NOT ILIKE '%ekg%' AND layanan NOT ILIKE '%Paket Makan%' AND layanan NOT ILIKE '%transfusi darah%' AND layanan NOT ILIKE '%transfortasi transfusi%'								join rs00001 c on c.tc = b.sumber_pendapatan_id and c.tt='SBP'  								JOIN rs00017 d ON a.no_kwitansi = d.id AND (d.nama ILIKE '%DR.%' OR d.nama ILIKE '%DRG.%')								where a.no_reg='".$_GET['rg']."' AND (a.trans_type='LTM') and c.tdesc like '%TINDAK%' AND a.referensi!='P'");				while($row = pg_fetch_array($result)){			?>			<tr>				<td align="right">&nbsp;</td><td><?php echo $row['layanan'].' - '.$row['nama'];?></td><td>:</td><td align="right">&nbsp;</td><td>&nbsp;</td><td align="right">&nbsp;</td><td>&nbsp;&nbsp;</td><td align="right"><?php echo number_format($row['tagihan'] - $row['dibayar_penjamin'],2)?></td>			</tr>			<?php }			}			if($radiologi > 0){			?>			<tr>				<td align="right"><?php echo $i++ ;?>.</td><td colspan="5" class="black_border">&nbsp;Radiologi</td><td>&nbsp;Rp.&nbsp;</td><td align="right"><?php echo number_format($radiologi - $radiologiPenjamin,2)?></td>			</tr>			<?php } 			if($usg > 0){			?>			<tr>				<td align="right"><?php echo $i++ ;?>.</td><td colspan="5" class="black_border">&nbsp;USG</td><td>&nbsp;Rp.&nbsp;</td><td align="right"><?php echo number_format($usg - $usgPenjamin,2)?></td>			</tr>			<?php }			if($fisio > 0){			?>			<tr>				<td align="right"><?php echo $i++ ;?>.</td><td colspan="5" class="black_border">&nbsp;Fisiotherapi</td><td>&nbsp;Rp.&nbsp;</td><td align="right"><?php echo number_format($fisio - $fisioPenjamin,2)?></td>			</tr>			<?php } if ($ekg > 0){?>			<tr>				<td align="right"><?php echo $i++ ;?>.</td><td colspan="5" class="black_border">&nbsp;EKG</td><td>&nbsp;Rp.&nbsp;</td><td align="right"><?php echo number_format($ekg-$ekgPenjamin,2)?></td>			</tr>			<?php } 				if ($oksigen > 0) {			?>			<tr>				<td align="right"><?php echo $i++ ;?>.</td><td colspan="5" class="black_border">&nbsp;O<sup>2</sup></td><td>&nbsp;Rp.&nbsp;</td><td align="right"><?php echo number_format($oksigen-$oksigenPenjamin,2) ?></td>			</tr>			<?php } 				if($paket > 0){ ?>			<tr>				<td align="right"><?php echo $i++ ;?>.</td><td colspan="5" class="black_border">&nbsp;Paket</td><td>&nbsp;Rp.&nbsp;</td><td align="right"><?php echo number_format($paket - $paketPenjamin,2)?></td>			</tr>			<?php } if($bhp > 0){ ?>			<tr>				<td align="right"><?php echo $i++ ;?>.</td><td colspan="5" class="black_border">&nbsp;BHP</td><td>&nbsp;Rp.&nbsp;</td><td align="right"><?php echo number_format($bhp - $bhpPenjamin,2)?></td>			</tr>			<?php }						if($alat > 0){ ?>			<tr>				<td align="right"><?php echo $i++ ;?>.</td><td colspan="5" class="black_border">&nbsp;ALAT</td><td>&nbsp;Rp.&nbsp;</td><td align="right"><?php echo number_format($alat - $alatPenjamin,2)?></td>			</tr>			<?php			}						if ($PX > 0){ ?>			<tr>				<td align="right"><?php echo $i++ ;?>.</td><td colspan="5" class="black_border">&nbsp;PX Dr. Ghazali</td><td>&nbsp;Rp.&nbsp;</td><td align="right"><?php echo number_format($PX - $PXPenjamin,2)?></td>			</tr>			<?php } ?>			<tr>				<td colspan="8">&nbsp;</td>			</tr>			<?php 			if($obatReturn > 0){ ?>			<tr>				<td align="right"><?php echo $i++ ;?>.</td><td colspan="5" class="black_border">&nbsp;PENGEMBALIAN OBAT</td><td>&nbsp;Rp.&nbsp;</td><td align="right">- <?php echo number_format($obatReturn - $obatPenjaminReturn,2)?></td>			</tr>			<?php } ?>			<tr>				<td colspan="8">&nbsp;</td>			</tr>			<?php if($potongan > 0){?>			<tr>				<td align="right">&nbsp;</td><td align="left" colspan="5" class="black_border"><span class="white_border">&nbsp;JUMLAH SEBELUM POTONGAN&nbsp;</span></td><td>&nbsp;Rp.&nbsp;</td>				<td align="right"><?php echo number_format($total-$totalPenjamin-getFromTable("SELECT SUM(tagihan-dibayar_penjamin) FROM rs00008_return WHERE no_reg ='".$reg."'"), 2) ?></td>			</tr>			<tr>				<td align="right">&nbsp;</td><td align="left" colspan="5" class="black_border"><span class="white_border">&nbsp;POTONGAN&nbsp;				<?php $keterangan = getFromTable("SELECT keterangan FROM rs00005 WHERE reg='".$_GET['rg']."' AND kasir = 'POT'");					if($keterangan <> ''){					    echo '('.$keterangan.')';					  }				  ?></span></td><td>&nbsp;Rp.&nbsp;</td>				<td align="right"><?php echo number_format($potongan, 2) ?></td>			</tr>			<?php } ?>			<tr>				<td align="right">&nbsp;</td><td align="left" colspan="5" class="black_border"><span class="white_border"><b>&nbsp;TAGIHAN&nbsp;</b></span></td><td>&nbsp;Rp.&nbsp;</td>				<td align="right"><b><?php echo number_format($total-$totalPenjamin-getFromTable("SELECT SUM(tagihan-dibayar_penjamin) FROM rs00008_return WHERE no_reg ='".$reg."'")-$potongan, 2) ?></b></td>			</tr>												<?php			//TUNAI & KEMBLAI			$cashPembayaran = getFromTable("select sum(cash_pembayaran) from rs00005 where reg='$reg' and kasir in ('BYR','BYD','BYI') and layanan != 'DEPOSIT' ");			$cashPengembalian = getFromTable("select sum(cash_pengembalian) from rs00005 where reg='$reg' and kasir in ('BYR','BYD','BYI') and layanan != 'DEPOSIT' ");			?>									<tr>				<td align="right">&nbsp;</td><td align="left" colspan="5" class="black_border"><span class="white_border"><b>&nbsp;TUNAI&nbsp;</b></span></td><td>&nbsp;Rp.&nbsp;</td>				<td align="right"><b><?php echo number_format($cashPembayaran, 2) ?></b></td>			</tr>			<tr>				<td align="right">&nbsp;</td><td align="left" colspan="5" class="black_border"><span class="white_border"><b>&nbsp;KEMBALI&nbsp;</b></span></td><td>&nbsp;Rp.&nbsp;</td>				<td align="right"><b><?php echo number_format($cashPengembalian, 2) ?></b></td>			</tr>			<tr>				<td colspan="8">&nbsp;</td>			</tr>			<tr>				<td align="right">&nbsp;</td><td align="left" colspan="5">&nbsp;NB **** Apabila ada yang kurang jelas mohon hubungi kasir, Terima Kasih.</td><td>&nbsp;</td><td>&nbsp;</td>			</tr>		</table>        <table border="0" align="right" width="30%" cellpadding="0" cellspacing="0" style="float:right;margin-top:40px;">			<tr>                <td align="center" class="TITLE_SIM3"><u><b><font size="2" face="arial"><?php echo tanggal_format(getFromTable("SELECT tgl_entry FROM rs00005 WHERE reg='".$reg."' AND is_bayar = 'Y' AND kasir = 'BYI' ORDER BY id ASC LIMIT 1 OFFSET 0"),'d / m / Y'); ?></b></u></td>            </tr>			<tr>                <td align="center" class="TITLE_SIM3"><u><b><font size="2" face="arial">Kasir</b></u></td>            </tr>            <tr>                <td align="center" class="TITLE_SIM3" height="100px"><u><b><font size="2" face="arial"><?php echo $_SESSION["nama_usr"]; ?></b></u></td>            </tr>        </table>        <SCRIPT LANGUAGE="JavaScript">            <!-- Begin            printWindow();            //  End -->        </script>    </body></html>