<?php

$PID = "p_jenazah2";

require_once("../lib/dbconn.php");
require_once("../lib/querybuilder.php");

$no_reg=$_GET['no_reg'];
$petugas=$_GET['petugas'];
$nama_jen=$_GET['nama_jen'];
$jenis_kel=$_GET['jenis_kel'];
$umur=$_GET['umur'];
$agama=$_GET['agama'];
$alamat=$_GET['alamat'];
$tgl_msk=$_GET['tgl_msk'];
$jam_msk=$_GET['jam_msk'];
$tgl_keluar=$_GET['tgl_keluar'];
$jam_keluar=$_GET['jam_keluar'];
$diagnosa=$_GET['diagnosa'];

pg_query("UPDATE jenazah SET petugas='".$petugas."',nama='".$nama_jen."',jenis_kel='".$jenis_kel."' ,umur='".$umur."', agama='".$agama."', tgl_msk='".$tgl_msk."', jam_msk='".$jam_msk."',tgl_keluar='".$tgl_keluar."', jam_keluar='".$jam_keluar."' , diagnosa='".$diagnosa."' WHERE no_reg='".$no_reg."'");

header("Location: ../index2.php?p=$PID");
exit;

?>
