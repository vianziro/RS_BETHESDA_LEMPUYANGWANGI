<?php// sfdn, 24-12-2006session_start();require_once("../lib/setting.php");require_once("../lib/terbilang.php");require_once("../lib/dbconn.php");require_once("../lib/form.php");require_once("../lib/class.PgTable.php");require_once("../lib/functions.php");$ROWS_PER_PAGE = 999999;//$RS_NAME           = $set_header[0]."<br>".$set_header[1];//$RS_ALAMAT         = $set_header[2]."<br>".$set_header[3].$set_header[4];?><HTML>    <HEAD>        <TITLE></TITLE>        <!--<TITLE>::: Sistem Informasi <?php echo $RS_NAME; ?> :::</TITLE>-->        <LINK rel='styleSheet' type='text/css' href='../cetak.css'>        <LINK rel='styleSheet' type='text/css' href='../invoice.css'>        <SCRIPT LANGUAGE="JavaScript">            <!-- Begin            function printWindow() {                bV = parseInt(navigator.appVersion);                if (bV >= 4) window.print();            }            //  End -->        </script>    </HEAD>    <BODY TOPMARGIN=1 LEFTMARGIN=5 MARGINWIDTH=0 MARGINHEIGHT=0 />  	<!--START KOP KWITANSI -->	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family: arial; font-size: 14px; letter-spacing: 2px;">		<tr valign="middle" >			<td rowspan="2" align="center"><!--<img width="70px" height="70px" src="../images/logo_kotakab_sragen.png" align="left"/>-->			<font color=white>				<div style="font-family: arial; font-size: 12px; color: #000; padding-left: 8px; padding-right: 8px;">&nbsp</div>			    <div style="font-family: arial; font-size: 14px; color: #000; padding-left: 8px; padding-right: 8px; font-weight: bold"><?=$set_header[0]?></div>				<div style="font-family: arial; font-size: 14px; color: #000; padding-left: 8px; padding-right: 8px; font-weight: bold"><?=$set_header[2]?></div>				<div style="font-family: arial; font-size: 14px; color: #000; padding-left: 8px; padding-right: 8px; font-weight: bold"><?=$set_header[3]?></div>			</font>		</tr>			</table>	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family: arial; font-size: 2px; letter-spacing: 2px;">	    <tr>	        <td align="left" style='border-top:solid 0px #000;border-bottom:solid 2px #000;'>&nbsp;</td>	    </tr>	    <tr>	        <td align="left" style='border-top:solid 2px #000;border-bottom:solid 0px #000;'>&nbsp;</td>	    </tr>	</table>	<!--END KOP KWITANSI -->    <?    //    echo "<hr>";//    titlecashier2('');//    titlecashier4('RS SITI KHADIJAH PEKALONGAN');//    titlecashier1('');//    titlecashier1('');//    echo "<hr>";//echo "<br>";    $reg = $_GET["rg"];    //echo $reg;    $rt = pg_query($con,            "SELECT a.id, to_char(a.tanggal_reg,'DD MONTH YYYY') AS tanggal_reg, a.waktu_reg, " .            "    a.mr_no, upper(e.nama)as nama, to_char(e.tgl_lahir, 'DD MONTH YYYY') AS tgl_lahir, " .            "    e.tmp_lahir, e.jenis_kelamin, f.tdesc AS agama, " .            "    upper(e.alm_tetap)as alm_tetap, upper(e.kota_tetap)as kota_tetap, e.umur, e.pos_tetap, e.tlp_tetap, " .            "    a.id_penanggung, b.tdesc AS penanggung, a.id_penjamin, " .            "    c.tdesc AS penjamin, a.no_jaminan,a.no_asuransi ,a.rujukan, a.rujukan_rs_id, " .            "    d.tdesc AS rujukan_rs, a.rujukan_dokter, a.rawat_inap, " .            "    a.status, a.tipe, g.tdesc AS tipe_desc, a.diagnosa_sementara, " .            "    to_char(a.tanggal_reg, 'DD MONTH YYYY') AS tanggal_reg_str, " .            "        CASE " .            "            WHEN a.rawat_inap = 'I' THEN 'Rawat Inap' " .            "            WHEN a.rawat_inap = 'Y' THEN 'Rawat Jalan' " .            "            ELSE 'IGD' " .            "        END AS rawat, " .            "        age(a.tanggal_reg , e.tgl_lahir ) AS umur, " .            "	case when a.rujukan = 'Y' then 'Rujukan' else 'Non-Rujukan' end as datang " .            "    , i.tdesc as poli,e.pangkat_gol,e.nrp_nip,e.kesatuan " .            "FROM rs00006 a " .            "   LEFT JOIN rs00001 b ON a.id_penanggung = b.tc AND b.tt = 'PEN'" .            "   LEFT JOIN rs00001 c ON a.id_penjamin = c.tc AND c.tt = 'PJN' " .            "   LEFT JOIN rs00002 e ON a.mr_no = e.mr_no " .            "   LEFT JOIN rs00001 f ON e.agama_id = f.tc AND f.tt = 'AGM' " .            "   LEFT JOIN rs00001 g ON a.tipe = g.tc AND g.tt = 'JEP' " .            "   LEFT JOIN rs00001 d ON a.id_penjamin = d.tc AND d.tt = 'RUJ' " .            "   LEFT JOIN rs00001 h ON a.jenis_kedatangan_id = h.tc AND h.tt = 'JDP' " .            "   left join rs00001 i on i.tc_poli = a.poli " .            "WHERE a.id = '$reg'  ");//"WHERE a.id = '$reg'");    $nt = pg_num_rows($rt);    if ($nt > 0)        $dt = pg_fetch_object($rt);    pg_free_result($rt);    if ($reg) {        if (getFromTable("select to_number(id,'9999999999') as id " .                        "from rs00006 " .                        "where id = '$reg' " .                        " ") == 0) {            //"and status = 'A'") == 0) {            $reg = 0;            $msg = "Nomor registrasi tidak ditemukan. Masukkan kembali nomor registrasi.";        }    }    //========= Kwitansi    if ($_GET[kas] == "rj") {        $ksr1 = "BYR";    } elseif ($_GET[kas] == "ri") {        $ksr1 = "BYI";    } elseif ($_GET[kas] == "igd") {        $ksr1 = "BYD";    }    $kwitansi = getFromTable("select max(no_kwitansi) from rs00005 where reg='$reg' and layanan != 'BATAL' and kasir='$ksr1' ");//==========    $r12 = pg_query($con,            "select a.id, a.ts_check_in::date, e.bangsal, d.bangsal as ruangan, b.bangsal as bed, " .            "    c.tdesc as klasifikasi_tarif, " .            "    extract(day from a.ts_calc_stop - a.ts_calc_start) as qty, " .            "    d.harga as harga_satuan, " .            "    extract(day from a.ts_calc_stop - a.ts_calc_start) * d.harga as harga, " .            "    a.ts_calc_stop " .            "from rs00010 as a " .            "    join rs00012 as b on a.bangsal_id = b.id " .            "    join rs00012 as d on substr(b.hierarchy,1,6) || '000000000' = d.hierarchy " .            "    join rs00012 as e on substr(b.hierarchy,1,3) || '000000000000' = e.hierarchy " .            "    join rs00001 as c on d.klasifikasi_tarif_id = c.tc and c.tt = 'KTR' " .            "where to_number(a.no_reg,'9999999999') = $reg and ts_calc_stop is not null");    $nt1 = pg_num_rows($r12);    if ($nt1 > 0)        $dt1 = pg_fetch_object($r12);    pg_free_result($r12);    if ($_GET["kas"] == "rj") {        $kasir = ("Kasir Rawat Jalan");        $rawatan = "Poli Pendaftaran";        $poli = $dt->poli;    } elseif ($_GET["kas"] == "ri") {        $kasir = ("Kasir Rawat Inap");        $rawatan = "Bangsal";        $poli = $dt1->bangsal . " / " . $dt1->ruangan . " / " . $dt1->bed . " / " . $dt1->klasifikasi_tarif;    } else {        $kasir = ("Kasir IGD");        $rawatan = "Ruang";        $poli = "IGD";    }    ?>    <table cellpadding="0" cellspacing="0" class="items">        <tbody>        <table width="100%" cellpadding="0" cellspacing="0">            <tr>                <td style="font-family: arial; font-size: 18px; letter-spacing: 4px;" align="center"><?php				    if ($_GET["kas"] == "rj") {				        echo "KWITANSI PEMBAYARAN RAWAT JALAN";				    } elseif ($_GET["kas"] == "ri") {				        echo "KWITANSI PEMBAYARAN RAWAT INAP";				    } else {				        echo "KWITANSI PEMBAYARAN IGD";				    }				    ?>				</td>            </tr>        </table>        <?        $tgl_sekarang = date("d M Y",time());        ?>        <table border="0" class="none" cellpadding="0" cellspacing="0">            <tr>                <td>                    <table border="0" class="none" cellpadding="0" cellspacing="0">                        <tr>                            <td class="add-bold"><font size="1"  face="arial">NO. KWITANSI</font></td>                            <td class="add-bold"><font size="1"  face="arial">:</font></td>                            <td class="add-bold"><font size="2"  face="arial"><? echo $kwitansi; ?></font></td>                        </tr>                      <!--<tr>                        <td><font size="1"  face="arial">NO. REG.</font></td>                        <td><font size="1"  face="arial">:</font></td>                        <td><font size="1"  face="arial"><? // echo $dt->id;  ?></font></td>                        </tr>-->                        <tr>                            <td><font size="1"  face="arial">NAMA PASIEN</font></td>                            <td><font size="1"  face="arial">:</font></td>                            <td><font size="1"  face="arial"><? echo $dt->nama; ?></font></td>                        </tr>                        <tr>                            <td><font size="1"  face="arial">ALAMAT</font></td>                            <td><font size="1"  face="arial">:</font></td>                            <td><font size="1"  face="arial" ><? echo $dt->alm_tetap . " " . $dt->kota_tetap; ?></font></td>                        </tr>                    </table>                </td>                <td width="200">&nbsp;</td>                <td>                    <table border="0" class="none" cellpadding="0" cellspacing="0">                        <tr>                            <td class="add-bold"><font size="1"  face="arial"><? echo $tgl_sekarang; ?></font>                        </tr>                        <tr>                            <td><font size="1"  face="arial"><? echo $poli; ?></font>                        </tr>                        <tr>                            <td><font size="1"  face="arial">PENJAMIN:<? echo $dt->tipe_desc; ?></font>                        </tr>                        <tr>                            <td>&nbsp;</td>                        </tr>                    </table></td>            </tr>        </table>        <?php        $pembayar = getFromTable("select max(bayar) as jumlah from rs00005 " .                "where kasir in ('BYR','BYI','BYD') and " .                "to_number(reg,'999999999999') = '$reg' ");        if ($pembayar == '') {            $pembayar1 = $dt->nama;        } else {            $pembayar1 = $pembayar;        }        ?>        <br>        <table border="0" width=100% cellpadding="0" cellspacing="0">            <tr>                <td valign=top width=35% class="TITLE_SIM3"><b><font size="1"  face="arial">SUDAH TERIMA DARI </font></b></td>                <td valign=top class="TITLE_SIM3"><b><font size="1"  face="arial">:</font></b></td>                <td valign=top class="TITLE_SIM3"><b><font size="1"  face="arial"><?= $pembayar1 ?></font></b></td>            </tr>            <?            $rrs = pg_query($con,                    "select sum(jumlah) as jumlah from rs00005 " .                    "where kasir in ('BYR','BYI','BYD') and " .                    "	to_number(reg,'999999999999') = '$reg' "); //and ".            //"	referensi IN ('KASIR')");            while ($dds = pg_fetch_object($rrs)) {                ?>                <tr>                    <td valign=top width=30% class="TITLE_SIM3"><b><font size="1"  face="arial">UANG SEJUMLAH</font></b></td>                    <td valign=top class="TITLE_SIM3"><b><font size="1"  face="arial">:</font></b></td>                    <td valign=top  class="TITLE_SIM3"><b><font size="1"  face="arial">Rp. <?= number_format($dds->jumlah,2) ?></font></b></td>                </tr><tr>                    <td valign=top class="TITLE_SIM3"><b></b></td>                    <td valign=top class="TITLE_SIM3"><b></b></td>                </tr>    <?php    $y = terbilang($dds->jumlah);    ?>                <!--<table>                <tr>    <td valign=top class="TITLE_SIM3"><b><i><font size="1"  face="arial"><?php // $y = terbilang($dds->jumlah);    //echo strtoupper($y);     ?> RUPIAH</font></i></b></td>    </tr>        </table>-->    <?}pg_free_result($rrs);$y = terbilang($dds->jumlah);?>        </table>        <?//                                    include("335.inc_2.php");        echo "<table border=0 width='100%' cellspacing=0 cellpadding=0>";        echo "<tr>";        echo "<td><img src=\"images/spacer.gif\" height=1></td>";        echo "<td><img src=\"images/spacer.gif\" height=1></td>";        echo "<td><img src=\"images/spacer.gif\" height=1></td>";        echo "</tr>";        echo "<tr>";        echo "<th class=TBL_HEAD2><b><font size=2 face=arial>NO</th>";        echo "<th class=TBL_HEAD2><b><font size=2 face=arial>URAIAN</th>";        echo "<th class=TBL_HEAD2><b><font size=2 face=arial>TAGIHAN</th>";        echo "</tr>";        if ($_GET["kas"] == "igd") {            $loket = "IGD";            $kasir = "IGD";            $lyn = "layanan = '100'";        } elseif ($_GET["kas"] == "rj") {            $loket = "RJL";            $kasir = "RJL";            $lyn = "layanan not in ('100','99996','99997','12651','13111')";        } else {            $loket = "RIN";            $kasir = "RIN";            $lyn = "(layanan not in ('99996','99997','12651','13111'))";            $d->poli = 0;        }        $poli = getFromTable("SELECT tdesc FROM rs00001 WHERE tt = 'LYN' and tc=$d->poli");        $karcis = getFromTable("SELECT sum(jumlah) as jumlah FROM rs00005 WHERE reg='" . $_GET[rg] . "' AND is_karcis='Y'  ");        if ($_GET[kas] == "ri") {            $cekBayar = getFromTable("select SUM(jumlah) from rs00005 where reg='" . $_GET[rg] . "' and (kasir='BYR' or kasir = 'BYD' or kasir ='BYI')");            $cekBayar = $cekBayar - $karcis;        } else {            $cekBayar = getFromTable("select SUM(jumlah) from rs00005 where reg='" . $_GET[rg] . "' and (kasir='BYR' or kasir = 'BYD' or kasir ='BYI') and is_obat='N'");        }        $loket = getFromTable("select " .                "case when rawat_inap = 'I' then 'RIN' " .                "     when rawat_inap = 'Y' then 'RJL' " .                "     else 'IGD' " .                "end as rawatan " .                "from rs00006 where id = '" . $_GET[rg] . "'");        $kodepoli = getFromTable("select poli from rs00006 where id = '" . $_GET[rg] . "'");        $namadokter = getFromTable("SELECT B.NAMA FROM RS00017 B    				LEFT JOIN  C_VISIT A ON A.ID_DOKTER = B.ID    				WHERE A.ID_POLI=$kodepoli AND A.NO_REG='" . $_GET[rg] . "'");        if ($namadokter != "") {            $namadokter = "(" . $namadokter . ")";        };        $cekAskes = getFromTable("select  sum(a.tagihan) from   rs00008  a,  rs00034 b 	         " .                "where a.no_reg = '" . $_GET[rg] . "'  AND b.tipe_pasien_id = '007'  " .                "AND  b.id = to_number(a.item_id,'999999999999') AND a.trans_form <> '-' and a.item_id <>'-'  ");        $karcis = getFromTable("SELECT sum(jumlah) as jumlah FROM rs00005 WHERE reg='" . $_GET[rg] . "' AND is_karcis='Y'  ");        $tipepasien = getFromTable("select  b.tipe from   rs00008  a,  rs00006 b 	         " .                "where a.no_reg = '" . $_GET[rg] . "'  AND b.id = a.no_reg ");        if ($loket == "IGD") {            $lyn123 = 100;        } elseif ($loket == "RJL") {            $lyn123 = $kodepoli;            if ($lyn123 == 101 or $lyn123 == 105) {                           } else {                     }        } else {            $lyn123 = 0;        }        if ($tipepasien == '007') {            $paket1 = 'PAKET I ASKES';            $cekAskes = $cekAskes;        } else {            $paket1 = 'KARCIS + PEMERIKSAAN DOKTER';        };        $cekPotong = getFromTable("select jumlah from rs00005 where reg='" . $_GET[rg] . "' and kasir='POT'");        $karcis = $hargatiket;        $bangsal_sudah_posting = 0.00;        $rec = pg_query("select * from rs00008 " .                "where trans_type = 'POS' and to_number(no_reg,'999999999999') = $reg order by id");        $rec_num = pg_num_rows($rec);        if ($rec_num > 0) {            $r1 = pg_query($con,                    "select a.id, a.ts_check_in::date, e.bangsal, d.bangsal as ruangan, b.bangsal as bed, " .                    "    c.tdesc as klasifikasi_tarif, " .                    "    extract(day from a.ts_calc_stop - a.ts_calc_start) as qty,			(select (substring((z.ts_calc_stop::timestamp)::text,12,8))::time - (substring((z.ts_check_in::timestamp)::text,12,8))::time from rs00010 z where z.id=a.id) as jumlah_jam, " .                    "    d.harga as harga_satuan, " .                    "    extract(day from a.ts_calc_stop - a.ts_calc_start) * d.harga as harga, " .                    "    a.ts_calc_stop " .                    "from rs00010 as a " .                    "    join rs00012 as b on a.bangsal_id = b.id " .                    "    join rs00012 as d on substr(b.hierarchy,1,6) || '000000000' = d.hierarchy " .                    "    join rs00012 as e on substr(b.hierarchy,1,3) || '000000000000' = e.hierarchy " .                    "    join rs00001 as c on d.klasifikasi_tarif_id = c.tc and c.tt = 'KTR' " .                    "where to_number(a.no_reg,'9999999999') = $reg and a.ts_calc_stop is not null");            while ($ddd = pg_fetch_object($rec)) {                while ($d1 = pg_fetch_object($r1)) {                    if ($d1->jumlah_jam >= "02:00:00") {                        $qty = 1;                    } else {                        $qty = $d1->qty;                    }                    $harga = $qty * $d1->harga_satuan;                    $bangsal_sudah_posting = $bangsal_sudah_posting + $harga;                }            }        }// >>>>>>>>>>>>>>>>  <<<<<<<<<<<<<<<<<<<<<<<        if (getFromTable("select rawat_inap from rs00006 " .                        "where to_number(id,'999999999999') = $reg") == "I") {// TAGIHAN SEMENTARA AKOMODASI            $bangsal_belum_posting = 0.00;            $r1 = pg_query($con,                    "select a.id, a.ts_check_in::date, e.bangsal, d.bangsal as ruangan, b.bangsal as bed, " .                    "    c.tdesc as klasifikasi_tarif, " .                    "    extract(day from current_timestamp - a.ts_calc_start) as qty, " .                    "    d.harga as harga_satuan, " .                    // sfdn, 17-12-2006 --> harga = harga * jumlah hari                    "    extract(day from current_timestamp - a.ts_calc_start) * d.harga as harga " .                    // --- eof sfdn, 17-12-2006                    "from rs00010 as a " .                    "    join rs00012 as b on a.bangsal_id = b.id " .                    "    join rs00012 as d on substr(b.hierarchy,1,6) || '000000000' = d.hierarchy " .                    "    join rs00012 as e on substr(b.hierarchy,1,3) || '000000000000' = e.hierarchy " .                    "    join rs00001 as c on d.klasifikasi_tarif_id = c.tc and c.tt = 'KTR' " .                    "where to_number(a.no_reg,'9999999999') = $reg and ts_calc_stop is null");            if ($d1 = pg_fetch_object($r1)) {                $bangsal_belum_posting = $bangsal_belum_posting + $d1->harga;                // --- eof 17-12-2006 ---                pg_free_result($r1);            }        }        if ($bangsal_sudah_posting > 0) {            $bangsal_belum_posting = 0;        }        $r1 = pg_query($con,                "select sum(tagihan) as tagihan, sum(pembayaran) as pembayaran " .                "from rs00008 " .                "where trans_type in ('LTM', 'BYR') " .                "and to_number(no_reg, '999999999999') = $reg");        $d1 = pg_fetch_object($r1);        pg_free_result($r1);        $jml_total_Tagihan = $bangsal_sudah_posting + $bangsal_belum_posting;        include ("tagihan_ri");// obat nggambus        $reg = $_GET["rg"];        $rec = getFromTable("select count(id) from rs00008 " .                "where trans_type = 'OB1' and to_number(no_reg,'999999999999') = $reg and referensi != 'F'");        if ($rec > 0) {            $SQL =  "select a.id, to_char(tanggal_trans,'DD-MM-YYYY') as tanggal_trans, " .                    "obat, qty, c.tdesc as satuan, sum(harga*qty) as tagihan, pembayaran, trans_group, d.tdesc as kategori " .                    "from rs00008 a, rs00015 b, rs00001 c, rs00001 d " .                    "where to_number(a.item_id,'999999999999') = b.id  " .                    "and b.satuan_id = c.tc and a.trans_type = 'OB1' " .                    "and c.tt = 'SAT' " .                    "and b.kategori_id = d.tc and d.tt = 'GOB' " .                    "and to_number(a.no_reg,'999999999999')= $reg  and referensi != 'F'" .                    "group by  d.tdesc, a.tanggal_trans, a.id, b.obat, a.qty, a.pembayaran, a.trans_group,   c.tdesc ";            $r1 = pg_query($con,"$SQL ");            $kateg = "000";            $ob_urut = 0;                        while ($d1 = pg_fetch_object($r1)) {                if ($d1->kategori != $kateg) {                    $ob_urut++;                    $obatx[$ob_urut] = 0;                    $kateg = $d1->kategori;                    $cek_kateg = substr($kateg,0,1);                }                if ($cek_kateg == "A") {   // apbd                    $obatx[1] = $obatx[1] + $d1->tagihan;                } elseif ($cek_kateg == "D") {    // dpho                    $obatx[2] = $obatx[2] + $d1->tagihan;                } elseif ($cek_kateg == "K") {    // koperasi                    $obatx[3] = $obatx[3] + $d1->tagihan;                }                //  $tot_obat = $tot_obat + $d1->tagihan;                $tot_obat = 0;            }            pg_free_result($r1);        }        $cek_loket = getFromTable("select kasir from rs00005 where reg = '" . $_GET[rg] . "' and is_karcis = 'Y'");        $nomor = 1;        if ($admin > 0) {            echo "<tr>";            echo "<td class=TBL_BODY align=center><font size=2 face=arial>$nomor</td>";            $nomor = $nomor + 1;            echo "<td class=TBL_BODY align=left><font size=2 face=arial>PENDAFTARAN</td>";            echo "<td class=TBL_BODY align=right><font size=2 face=arial>" . number_format($admin - $adminPenjamin, 2) . "</td>";            echo "</tr>";        }                if ($adminRI > 0) {            echo "<tr>";            echo "<td class=TBL_BODY align=center><font size=2 face=arial>$nomor</td>";            $nomor = $nomor + 1;            echo "<td class=TBL_BODY align=left><font size=2 face=arial>ADMINISTRASI RAWAT INAP</td>";            echo "<td class=TBL_BODY align=right><font size=2 face=arial>" . number_format($adminRI - $adminRIPenjamin, 2) . "</td>";            echo "</tr>";        }        if ($tindakan > 0) {            echo "<tr>";            echo "<td class=TBL_BODY align=center><font size=2 face=arial>$nomor</td>";            $nomor = $nomor + 1;            echo "<td class=TBL_BODY align=left><font size=2 face=arial>LAYANAN DOKTER</td>";            echo "<td class=TBL_BODY align=right><font size=2 face=arial>&nbsp;</td>";            echo "</tr>";        }        if ($tindakan > 0) {            echo "<tr>";            echo "<td class=TBL_BODY align=center><font size=2 face=arial>&nbsp;</td>";            echo "<td class=TBL_BODY align=left><font size=2 face=arial>- TINDAKAN MEDIS</td>";            echo "<td class=TBL_BODY align=right><font size=2 face=arial>" . number_format($tindakan - $tindakanPenjamin,2) . "</td>";            echo "</tr>";	    $tindakan_query=pg_query("SELECT layanan,b.nama FROM rs00008 a 					JOIN rs00017 b ON a.no_kwitansi = b.id 					JOIN rs00034 c ON a.item_id::integer = c.id AND hierarchy NOT LIKE '004008%' AND hierarchy NOT LIKE '004003%' AND hierarchy NOT LIKE '004004%'					AND hierarchy NOT LIKE '004005%' AND layanan NOT ILIKE '%konsultasi%' AND layanan NOT ILIKE '%fisioterapi%' AND layanan NOT ILIKE '%usg%'					AND layanan NOT ILIKE '%ekg%'					JOIN rs00001 d ON d.tt = 'SBP' AND d.tc = c.sumber_pendapatan_id AND d.tdesc LIKE '%TINDAKAN%'					WHERE a.no_reg = '".$_GET['rg']."' AND trans_type = 'LTM'");			while($tdk = pg_fetch_array($tindakan_query)){				echo "<tr>";				echo "<td $cls align=center>&nbsp;</td>";				echo "<td $cls align=left>&nbsp;&nbsp;&nbsp;<font size=1><i>".$tdk['layanan']."</i> - (".$tdk['nama'].")</font></td>";				echo "<td $cls align=right>&nbsp;</td>";				echo "<td $cls align=right>&nbsp;</td>";				echo "<td $cls align=right>&nbsp;</td>";				echo "</tr>";			}        }                if ($visite > 0) {            echo "<tr>";            echo "<td class=TBL_BODY align=center><font size=2 face=arial>&nbsp;</td>";            echo "<td class=TBL_BODY align=left><font size=2 face=arial>- VISITE</td>";            echo "<td class=TBL_BODY align=right><font size=2 face=arial>" . number_format($visite - $visitePenjamin,2) . "</td>";            echo "</tr>";        }        if ($layananDokter > 0) {            echo "<tr>";            echo "<td class=TBL_BODY align=center><font size=2 face=arial>&nbsp;</td>";            echo "<td class=TBL_BODY align=left><font size=2 face=arial>- PEMERIKSAAN DOKTER - (".getFromTable("SELECT diagnosa_sementara FROM rs00006 WHERE id = '".$_GET['rg']."'").")</td>";            echo "<td class=TBL_BODY align=right><font size=2 face=arial>" . number_format($layananDokter-$layananDokterPenjamin,2) . "</td>";            echo "</tr>";        }        if ($konsul > 0) {            echo "<tr>";            echo "<td class=TBL_BODY align=center><font size=2 face=arial>&nbsp;</td>";            echo "<td class=TBL_BODY align=left><font size=2 face=arial>- KONSUL</td>";            echo "<td class=TBL_BODY align=right><font size=2 face=arial>" . number_format($konsul - $konsulPenjamin,2) . "</td>";            echo "</tr>";              }        if ($alat > 0) {            echo "<tr>";            echo "<td class=TBL_BODY align=center><font size=2 face=arial>&nbsp;</td>";            echo "<td class=TBL_BODY align=left><font size=2 face=arial>- ALAT</td>";            echo "<td class=TBL_BODY align=right><font size=2 face=arial>" . number_format($alat - $alatPenjamin,2) . "</td>";            echo "</tr>";        }        if($konsultasi > 0){			echo "<tr>";            echo "<td class=TBL_BODY align=center><font size=2 face=arial>$nomor</td>";            $nomor = $nomor + 1;            echo "<td class=TBL_BODY align=left><font size=2 face=arial>KONSULTASI</td>";            echo "<td class=TBL_BODY align=right><font size=2 face=arial>" . number_format($konsultasi - $konsultasiPenjamin,2) . "</td>";            echo "</tr>";		}		if($askep > 0){			echo "<tr>";            echo "<td class=TBL_BODY align=center><font size=2 face=arial>$nomor</td>";            $nomor = $nomor + 1;            echo "<td class=TBL_BODY align=left><font size=2 face=arial>ASUHAN KEPERAWATAN</td>";            echo "<td class=TBL_BODY align=right><font size=2 face=arial>" . number_format($askep - $askepPenjamin,2) . "</td>";            echo "</tr>";		}		if($paket > 0){			echo "<tr>";            echo "<td class=TBL_BODY align=center><font size=2 face=arial>$nomor</td>";            $nomor = $nomor + 1;            echo "<td class=TBL_BODY align=left><font size=2 face=arial>PAKET</td>";            echo "<td class=TBL_BODY align=right><font size=2 face=arial>" . number_format($paket - $paketPenjamin,2) . "</td>";            echo "</tr>";		}        if ($bhp > 0) {            echo "<tr>";            echo "<td class=TBL_BODY align=center><font size=2 face=arial>$nomor</td>";            $nomor = $nomor + 1;            echo "<td class=TBL_BODY align=left><font size=2 face=arial>BHP (Obat Anestesi)</td>";            echo "<td class=TBL_BODY align=right><font size=2 face=arial>" . number_format($bhp - $bhpPenjamin,2) . "</td>";            echo "</tr>";        }        if ($obat > 0) {            echo "<tr>";            echo "<td class=TBL_BODY align=center><font size=2 face=arial>$nomor</td>";            $nomor = $nomor + 1;            echo "<td class=TBL_BODY align=left><font size=2 face=arial>OBAT / FARMASI</td>";            echo "<td class=TBL_BODY align=right><font size=2 face=arial>" . number_format($obat - $obatPenjamin,2) . "</td>";            echo "</tr>";        }        if ($laborat > 0) {            echo "<tr>";            echo "<td class=TBL_BODY align=center><font size=2 face=arial>$nomor</td>";            $nomor = $nomor + 1;            echo "<td class=TBL_BODY align=left><font size=2 face=arial>LABORATORIUM</td>";            echo "<td class=TBL_BODY align=right><font size=2 face=arial>" . number_format($laborat - $laboratPenjamin,2) . "</td>";            echo "</tr>";        }        if ($radiologi > 0) {            echo "<tr>";            echo "<td class=TBL_BODY align=center><font size=2 face=arial>$nomor</td>";            $nomor = $nomor + 1;            echo "<td class=TBL_BODY align=left><font size=2 face=arial>RADIOLOGI</td>";            echo "<td class=TBL_BODY align=right><font size=2 face=arial>" . number_format($radiologi - $radiologiPenjamin, 2) . "</td>";            echo "</tr>";        }        if ($usg > 0) {            echo "<tr>";            echo "<td class=TBL_BODY align=center><font size=2 face=arial>$nomor</td>";            $nomor = $nomor + 1;            echo "<td class=TBL_BODY align=left><font size=2 face=arial>USG / ECG</td>";            echo "<td class=TBL_BODY align=right><font size=2 face=arial>" . number_format($usg - $usgPenjamin, 2) . "</td>";            echo "</tr>";        }        if ($ekg > 0){			echo "<tr>";			echo "<td class=TBL_BODY align=center><font size=2 face=arial>$nomor</font></td>";			$nomor = $nomor + 1;			echo "<td class=TBL_BODY align=left><font size=2 face=arial>EKG</font></td>";			echo "<td class=TBL_BODY align=right><font size=2 face=arial>" . number_format($ekg-$ekgPenjamin, 2) . "</font></td>";			echo "</tr>";		}        if ($oksigen > 0) {            echo "<tr>";            echo "<td class=TBL_BODY align=center><font size=2 face=arial>$nomor</td>";            $nomor = $nomor + 1;            echo "<td class=TBL_BODY align=left><font size=2 face=arial>PEMAKAIAN OKSIGEN / NO2</td>";            echo "<td class=TBL_BODY align=right><font size=2 face=arial>" . number_format($oksigen - $oksigenPenjamin, 2) . "</td>";            echo "</tr>";        }        if ($fisio > 0) {            echo "<tr>";            echo "<td class=TBL_BODY align=center><font size=2 face=arial>$nomor</td>";            $nomor = $nomor + 1;            echo "<td class=TBL_BODY align=left><font size=2 face=arial>FISIOTERAPHI</td>";            echo "<td class=TBL_BODY align=right><font size=2 face=arial>" . number_format($fisio - $fisioPenjamin, 2) . "</td>";            echo "</tr>";        }        if ($sewaKamarOperasi > 0) {            echo "<tr>";            echo "<td class=TBL_BODY align=center><font size=2 face=arial>$nomor</td>";            $nomor = $nomor + 1;            echo "<td class=TBL_BODY align=left><font size=2 face=arial>SEWA KAMAR OPERASI</td>";            echo "<td class=TBL_BODY align=right><font size=2 face=arial>" . number_format($sewaKamarOperasi - $sewaKamarOperasiPenjamin, 2) . "</td>";            echo "</tr>";        }        if ($operasi > 0) {            echo "<tr>";            echo "<td class=TBL_BODY align=center><font size=2 face=arial>$nomor</td>";            $nomor = $nomor + 1;            echo "<td class=TBL_BODY align=left><font size=2 face=arial>JASA OPERASI</td>";            echo "<td class=TBL_BODY align=right><font size=2 face=arial>" . number_format($operasi - $operasiPenjamin, 2) . "</td>";            echo "</tr>";        }        if ($anestesi > 0) {            echo "<tr>";            echo "<td class=TBL_BODY align=center><font size=2 face=arial>$nomor</td>";            $nomor = $nomor + 1;            echo "<td class=TBL_BODY align=left><font size=2 face=arial>ANESTESI (Pembiusan)</td>";            echo "<td class=TBL_BODY align=right><font size=2 face=arial>" . number_format($anestesi - $anestesiPenjamin, 2) . "</td>";            echo "</tr>";        }        if ($ambulan > 0) {            echo "<tr>";            echo "<td class=TBL_BODY align=center><font size=2 face=arial>$nomor</td>";            $nomor = $nomor + 1;            echo "<td class=TBL_BODY align=left><font size=2 face=arial>AMBULANCE</td>";            echo "<td class=TBL_BODY align=right><font size=2 face=arial>" . number_format($ambulan - $ambulanPenjamin, 2) . "</td>";            echo "</tr>";        }        if ($PX > 0){		echo "<tr>";		echo "<td class='TBL_BODY' align=center><font size=2 face=arial>$nomor</font></td>";		$nomor = $nomor + 1;		echo "<td class='TBL_BODY' align=left><font size=2 face=arial>PX Dr. Ghazali</font></td>";		echo "<td class='TBL_BODY' align=right><font size=2 face=arial>" . number_format($PX-$PXPenjamin, 2) . "</font></td>";		echo "</tr>";		}        if ($lain > 0) {            echo "<tr>";            echo "<td class=TBL_BODY align=center><font size=2 face=arial>$nomor</td>";            $nomor = $nomor + 1;            echo "<td class=TBL_BODY align=left><font size=2 face=arial>LAIN - LAIN</td>";            echo "<td class=TBL_BODY align=right><font size=2 face=arial>" . number_format($lain - $lainPenjamin, 2) . "</td>";            echo "</tr>";        }         // if ($_SESSION[uid] == "kasir2" || $_SESSION[uid] == "root") {        if ($_GET["kas"] == "ri" || $_GET["kas"] == "root") {            echo "<tr>";            echo "<td class=TBL_BODY align=center><font size=2 face=arial>$nomor</td>";            $nomor = $nomor + 1;            echo "<td class=TBL_BODY align=left><font size=2 face=arial>AKOMODASI RAWAT INAP</td>";            echo "<td class=TBL_BODY align=right><font size=2 face=arial>" . number_format($akomodasi, 2) . "</td>";            echo "</tr>";        }        echo "<tr>";        echo "<td align=center><b><font size=2 face=arial>&nbsp;</td>";        echo "<td align=right><b><font size=2 face=arial>TOTAL TAGIHAN :</td>";        echo "<td align=right><b><font size=2 face=arial>" . number_format($total, 2) . "</td>";        echo "</tr>";        $Askes = getFromTable("select sum(jumlah) from rs00005 where reg='$reg' and kasir='ASK'");        if ($Askes > 0) {            echo "<tr>";            echo "<td class=TBL_BODY align=center><b><font size=2 face=arial>&nbsp;</td>";            echo "<td class=TBL_BODY align=right><b><font size=2 face=arial>DIBAYARKAN PENJAMIN :</td>";            echo "<td class=TBL_BODY align=right><b><font size=2 face=arial>" . number_format($Askes,2) . "</td>";            echo "</tr>";        }        if ($cekPotong > 0) {            echo "<tr>";            echo "<td class=TBL_BODY align=center><b><font size=2 face=arial>&nbsp;</td>";            echo "<td class=TBL_BODY align=right><b><font size=2 face=arial>POTONGAN (".strtoupper(getFromTable("SELECT keterangan FROM rs00005 WHERE reg = '".$_GET['rg']."' AND kasir='POT'")).") :</td>";            echo "<td class=TBL_BODY align=right><b><font size=2 face=arial>" . number_format($cekPotong,2) . "</td>";            echo "</tr>";        }        $tagihan = $total - ($Askes + $cekBayar + $cekPotong);        $SQL1a = "select distinct to_char(tgl_entry,'dd/mm/yyyy') as tgl_entry, to_char(waktu_bayar,'HH24:MI:SS') as waktu_bayar, jumlah, bayar, cab, no_kwitansi				  from rs00005 where reg = '$reg' and kasir in ('BYR','BYI','BYD')	order by tgl_entry, waktu_bayar ";        $r1a = pg_query($con, "$SQL1a ");        while ($d1a = pg_fetch_object($r1a)) {            /* echo "<tr>";              echo "<td class=TBL_BODY align=center>&nbsp;</td>";              echo "<td class=TBL_BODY align=right>".$d1a->tgl_entry." ".$d1a->waktu_bayar." Pembayar ".$d1a->bayar." :</td>";              echo "<td class=TBL_BODY align=right>" . number_format($d1a->jumlah, 2) . "</td>";              echo "</tr>"; */        }        //pg_free_result($r1);            //--pembulatan		$totalPembulatan = pembulatan($cekBayar);		$pembulatan = $totalPembulatan - $cekBayar;		//--        echo "<tr>";        echo "<td class=TBL_BODY align=center><b><font size=1 face=arial>&nbsp;</td>";        echo "<td class=TBL_BODY align=right><b><font size=1 face=arial>PEMBAYARAN :</td>";        echo "<td class=TBL_BODY align=right><b><font size=1 face=arial>" . number_format($cekBayar,2) . "</td>";        echo "</tr>";             echo "<tr>";        echo "<td class=TBL_BODY align=center><b><font size=1 face=arial>&nbsp;</td>";        echo "<td class=TBL_BODY align=right><b><font size=1 face=arial>PEMBULATAN :</td>";        echo "<td class=TBL_BODY align=right><b><font size=1 face=arial>" . number_format($pembulatan,2) . "</td>";        echo "</tr>";		echo "<tr>";        echo "<td class=TBL_BODY align=center><b><font size=1 face=arial>&nbsp;</td>";        echo "<td class=TBL_BODY align=right><b><font size=1 face=arial>TOTAL PEMBAYARAN :</td>";        echo "<td class=TBL_BODY align=right><b><font size=1 face=arial>" . number_format($totalPembulatan, 2) . "</td>";        echo "</tr>";        if ($tagihan > 0) {            echo "<tr>";            echo "<td class=TBL_HEAD2 align=center><b><font size=1 face=arial>&nbsp;</td>";            echo "<td class=TBL_HEAD2 align=right><b><font size=1 face=arial>TAGIHAN :</td>";            echo "<td class=TBL_HEAD2 align=right><b><font size=1 face=arial>" . number_format($tagihan,2) . "</td>";            echo "</tr>";        }         //while ($qr = pg_fetch_object($q)) {        //}        echo "</table><br>";        echo "\n<script language='JavaScript'>\n";        echo "function cetakrincian(tag) {\n";        echo "    sWin = window.open('index2.php?tag=' + tag, 'xWin'," .        " 'width=500,height=400,menubar=no,scrollbars=yes');\n";        echo "    sWin.focus();\n";        echo "}\n";        echo "</script>\n";        $tgl_sekarang = date("d M Y", time());        echo "<table>";        echo "<td valign=top class='TITLE_SIM3'><b><i><font size='2'  face='arial'>";        if($totalPembulatan==0){		echo "GRATIS";		}		else{        $y = terbilang($totalPembulatan);        echo strtoupper($y)."RUPIAH</font></i></b>";		}        echo "</td>";        echo "</tr>";        echo "</table>";        ?>        <table border="0" align="right" width="50%" cellpadding="0" cellspacing="0">            <tr>                <td align="right" class="TITLE_SIM3"><u><b><font size="1" face="arial"><? echo $_SESSION["nama_usr"]; ?></b></u></td>            </tr>        </table>        <SCRIPT LANGUAGE="JavaScript">            <!-- Begin            printWindow();            //  End -->        </script>    </body></html>