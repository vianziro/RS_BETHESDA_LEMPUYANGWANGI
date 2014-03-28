<SCRIPT language="JavaScript" src="plugin/jquery-1.8.2.js"></SCRIPT>
<SCRIPT language="JavaScript" src="plugin/jquery-ui.js"></SCRIPT>
<LINK rel="stylesheet" type="text/css" href="plugin/jquery.ui.theme.css">
<LINK rel="stylesheet" type="text/css" href="plugin/jquery-ui.custom.css">
<LINK rel="stylesheet" type="text/css" href="plugin/jquery.ui.autocomplete.css">
<LINK rel="stylesheet" type="text/css" href="plugin/jquery.ui.tabs.css">
<LINK rel="stylesheet" type="text/css" href="plugin/jquery.dataTables.css">
<LINK rel="stylesheet" type="text/css" href="plugin/jquery.dataTables_themeroller.css">
<script src="plugin/ui/jquery.ui.core.js"></script>
<script src="plugin/ui/jquery.ui.tabs.js"></script>
<script src="plugin/jquery.dataTables.js"></script>
<script src="plugin/jquery.form.js"></script>
<?php 	
session_start();
require_once("lib/dbconn.php");
require_once("lib/form.php");
require_once("lib/class.PgTable.php");
require_once("lib/functions.php");
$PID = "apotik_umum";
$SC = $_SERVER["SCRIPT_NAME"];

$sql = pg_query($con, "SELECT MAX(no_reg) AS max_no_reg FROM apotik_umum");
$row = pg_fetch_array($sql);
$maxNoReg    = $row['max_no_reg'];
$lastNo      = substr($maxNoReg, 1, 4);
$nextNo      = substr('000'.($lastNo+1),-4);
$newNoReg    = 'A'.$nextNo.date('m').date('y');
$noreg	     = $newNoReg;

$resep  = '';
$dokter = '';
$praktek = '';
if($_GET['no_reg'] != ''){
    $newNoReg = $_GET['no_reg'];

    $sqlPenjualan = pg_query($con, "SELECT * FROM apotik_umum WHERE no_reg = '".$_GET['no_reg']."' ");

    $rowPenjulan  = pg_fetch_array($sqlPenjualan);
    $resep = $rowPenjulan['resep'];
    $dokter = $rowPenjulan['dokter'];
    $praktek = $rowPenjulan['praktek'];
}
?>
<p/>
<p/>
<script>
    $(function() {
            $( "#tabs" ).tabs();
    });
</script>
<table>
    <tr>
        <td><img src='icon/apotek1-icon.png' align='absmiddle' ><A CLASS=SUB_MENU  HREF='index2.php?p=320RJ&tt=swd'>Layanan Apotek Klinik</A></td>
	<td><img src='icon/apotek-icon.png' align='absmiddle' >APOTEK UMUM</td>
    </tr>
</table>
<br/>
<?php
$SQL12 = "SELECT a.id, b.tc from rs00008 a 
    		  left join rs00001 b on a.item_id = b.tc and tt='RAP'
    		  where a.trans_type='OBM' and a.no_reg='".$newNoReg."'"; 
	$r = pg_query($con,$SQL12);
	$n = pg_num_rows($r);		    	
	if($n > 0) $d2 = pg_fetch_array($r);
	pg_free_result($r);
	
	if($n > 0){
			echo "<font color='#000000' size='2'>Edit Relasi Apotik</font>";
			echo "<div align=left><input type=button value=' Edit ' OnClick=\"window.location = './index2.php?p=apotik_umum&tt=".$_GET[tt]."&rg=".$_GET[no_reg]."&sub=obat&nama_relasi=".$_GET[nama_relasi]."&id=".$d2->id."&act=edit';\"></div>\n";
		} else {
			$ext = "";					
    }

	if ($_GET['act'] == "edit") {
					
						echo "<font color='#0000FF' size='2'> >>> Silahkan Pilih Nama Relasi !</font>";


						$f = new Form("actions/apotik_umum_insert1.php", "POST", "NAME=Form2");
						$f->hidden("act","edit");
						$f->hidden("no_reg",$d2["no_reg"]);
					    	$f->hidden("tanggal_reg",$d2["tanggal_reg"]);
						$f->hidden("sub","obat");
						$f->hidden("nama_relasi",$_GET[nama_relasi]);
					    	$f->hidden("user_id",$_SESSION[uid]);
						$f->hidden("id",$d2["id"]);
					    
					  
				}else {
					if($n > 0){
						$ext= "disabled";
					}else {
						$ext = "";
					}

			}
	
$f = new Form("actions/apotik_umum_insert1.php", "POST", "NAME=Form2");
					$f->hidden("act","new2");
					$f->hidden("no_reg",$_GET['no_reg']);
				    	$f->hidden("tanggal_reg",$d2["tanggal_reg"]);
				    	$f->hidden("user_id",$_SESSION[uid]);
					$f->hidden("tt", $_GET["tt"]);
					//var_dump($noreg);
					echo"<br><div align=right>";
					$margin = getFromTable("select item_id from rs00008 where no_reg='".$newNoReg."' and trans_type='OBM'");
				    	$f->PgConn=$con;
					$f->title1("<U>Pilih Relasi Apotik</U>","LEFT");
					//$f->selectSQL("nama_relasi", "<I><B><font color='orange'><font size='2'>Nama Relasi</B>", "select '' as tc, '' as tdesc union select tc, tdesc from rs00001 where tt = 'RAP' and tc != '000' and tc_tipe='000' ", $margin,"id=nama_relasi",$_GET["nama_relasi"],$ext);
					$f->selectSQL("nama_relasi", "<I><B><font color='orange'><font size='2'>Nama Relasi</B>", "select '' as tc, '' as tdesc union select tc, tdesc from rs00001 where tt = 'RAP' and tc != '000' and tc IN ('001','002','003','004','005','006','007','008','009','010','011','012','013','014','015','016','017','018','019','020','021') ORDER BY tdesc ASC", $margin,"id=nama_relasi",$_GET["nama_relasi"],$ext);
				    	$f->submitAndCancel("Simpan",$ext,"Batal","window.history.back()",$ext);
echo"<br></div>";
				    	$f->execute();
?>
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Input Penjualan Obat</a></li>
		<li><a href="#tabs-2">Daftar Penjualan</a></li>
	</ul>
	<div id="tabs-1">
            <form method="post" action="actions/apotik_umum_insert.php" id="form-penjualan">
            <table>
		<tr>
                    <td></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><input type="button" value="Input Penjualan Baru" onClick="addNew()" /></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>No. Registrasi</td>
                    <td>: <input type="text" name="no_reg" value="<?php echo $newNoReg ?>" size="15" style="font-weight: bold; border: none" readonly="readonly"></td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>: <input type="text" name="nama" id="nama" value="" size="25"></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>: <input type="text" name="alamat" id="alamat" value="" size="50"></td>
                </tr>
                <tr>
                    <td>Dokter</td>
                    <td>: <input type="text" name="dokter" id="dokter" value="<?php echo $dokter?>" size="30"></td>
                </tr>
                <tr>
                    <td>Tempat Praktek</td>
                    <td>: <input type="text" name="praktek" id="praktek" value="<?php echo $praktek?>" size="40"> <i>isi dengan kode "RS" jika resep dari dokter Rumah Sakit</i></td>
                </tr>
            </table>
            <table id="list-obat">
            <thead><tr>
                <td align="CENTER" class="TBL_HEAD" width="300">Nama Obat</td>
                <td align="CENTER" class="TBL_HEAD" width="50">Resep</td>
                <td align="CENTER" class="TBL_HEAD" width="50">Jumlah</td>
                <td align="CENTER" class="TBL_HEAD" width="80">Harga Satuan</td>
                <td align="CENTER" class="TBL_HEAD" width="80">Harga Total</td>
                <td align="CENTER" class="TBL_HEAD" width="120"></td>
            </tr>
            </thead>
            <tbody>
                <tr id="list_obat">
                    <td>
                        <input type="hidden" name="id" id="id" value="">
                        <input type="hidden" name="obat_id" id="obat_id" value="">
                        <input type="hidden" name="qty_awal" id="qty_awal" value="">
                        <input type="hidden" name="harga_awal" id="harga_awal" value="">
                        <input type="text" name="obat_nama" id="obat_nama" size="50" value="">
                    </td>
                    <td align="center"><input type="checkbox" name="resep" id="resep" vaue="YA"></td>
                    <td><input type="text" name="qty" id="qty" size="3" value="" style="text-align: right;"></td>
                    <td><input type="text" name="harga" id="harga" size="10" value="" readonly="true" style="text-align: right;"></td>
                    <td><input type="text" name="jumlah" id="jumlah" size="10" value="" readonly="true" style="text-align: right;"></td>
                    <td><input type="submit" value="  OK  " /></td>
                    <!--td><input type="button" value="  OK  " onClick="addNewRow()" /></td-->
                </tr>
            </tbody>
            </table>
            <input type="hidden" name="max_obat"  id="max_obat" value="0">
            <!--input type="submit" id="save-obat" value=" Simpan " /-->
            </form>
            <div id="list_pembelian"></div>
	</div>
	<div id="tabs-2">
			<table>
                <tr>
                    <td>Pilih waktu yang akan ditampilkan </td>
                    <td>: 
                        <select name="range_date" id="range_date" onChange="fltData(this.value)">
                            <option value="<?php echo date('Y-m-d')?>" <?php if((string)date('Y-m-d') == $_GET['start_date']){ echo 'selected="selected"'; } ?> >Hari Ini</option>
                            <option value="<?php  echo date("Y-m-d", strtotime("-1 day") ) ?>" <?php if((string)date('Y-m-d', strtotime("-1 day")) == $_GET['start_date']){ echo 'selected="selected"'; } ?>>Kemarin</option>
                            <option value="<?php  echo date("Y-m-d", strtotime("-7 day") ) ?>" <?php if((string)date('Y-m-d', strtotime("-7 day")) == $_GET['start_date']){ echo 'selected="selected"'; } ?>>1 Minggu</option>
                            <option value="<?php  echo date("Y-m-d", strtotime("-30 day") ) ?>" <?php if((string)date('Y-m-d', strtotime("-30 day")) == $_GET['start_date']){ echo 'selected="selected"'; } ?>>1 Bulan</option>
                        	<option value="<?php  echo date("Y-m-d", strtotime("-365 day") ) ?>" <?php if((string)date('Y-m-d', strtotime("-365 day")) == $_GET['start_date']){ echo 'selected="selected"'; } ?>>1 Tahun</option>
                        </select>
                    </td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0" border="0" class="" id="daftar_penjulan_obat">
            <thead>
                <tr>
                    <th>no</th>
                    <th>Tanggal</th>
                    <th>No. Registrasi</th>
                    <th>Resep</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Dokter</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $flt = date('Y-m-d');
                if(!empty($_GET['start_date']) ){
                    $flt = $_GET['start_date'];   
                }
                $rows      = pg_query($con, "SELECT id, tanggal_entry, no_reg, nama, alamat, resep, dokter FROM apotik_umum WHERE tanggal_entry >= '".$flt."' ORDER BY no_reg DESC");
                $i=0;
                while($row=pg_fetch_array($rows)){
                    $i++;
                ?>
                        <tr class="odd gradeC">
                            <td><?php echo $i ?></td>
                            <td><?php echo $row["tanggal_entry"] ?></td>
                            <td><?php echo $row["no_reg"] ?></td>
                            <td><?php echo $row["resep"] ?></td>
                            <td><?php echo $row["nama"] ?></td>
                            <td><?php echo $row["alamat"] ?></td>
                            <td><?php echo $row["dokter"] ?></td>
                            <td><a href="<?php echo $SC.'?p='.$PID.'&no_reg='.$row["no_reg"]?>">edit</a> </td>
                        </tr>
                        <?php
                }
                ?>                    
            </tbody>
        </table> 
	</div>
</div>
<?php
$relasi =$_GET['nama_relasi'];
//var_dump($relasi); die;
$result = pg_query($con, "SELECT DISTINCT rs00015.id, rs00015.obat, rs00015.kategori_id, rs00016.harga,rs00016.harga_car_drs,
rs00016.harga_car_rsrj  AS harga_car_rsrj,rs00016.harga_car_rsri AS harga_car_rsri,rs00016.harga_inhealth_drs AS harga_inhealth_drs,rs00016.harga_inhealth_rs AS harga_inhealth_rs,
rs00016.harga_jam_ri,rs00016.harga_jam_rj,rs00016.harga_kry_kelinti,rs00016.harga_kry_kelbesar,
rs00016.harga_kry_kelgratisri,rs00016.harga_kry_kelrespoli,rs00016.harga_kry_kel,
rs00016.harga_kry_kelgratisrj,rs00016.harga_umum_ri,rs00016.harga_umum_rj,
rs00016.harga_umum_ikutrekening,rs00016.harga_gratis_rj,rs00016.harga_gratis_ri,
rs00016.harga_pen_bebas,rs00016.harga_nempil,rs00016.harga_nempil_apt,margin_apotik.tuslah_car_drs,
margin_apotik.tuslah_car_rsrj,margin_apotik.tuslah_car_rsri,margin_apotik.tuslah_inhealth_drs,
margin_apotik.tuslah_inhealth_rs,margin_apotik.tuslah_jam_ri,margin_apotik.tuslah_jam_rj,
margin_apotik.tuslah_kry_kelinti,margin_apotik.tuslah_kry_kelbesar,margin_apotik.tuslah_kry_kelgratisri,
margin_apotik.tuslah_kry_kelrespoli,margin_apotik.tuslah_kry_kel,margin_apotik.tuslah_kry_kelgratisrj,
margin_apotik.tuslah_umum_ri,margin_apotik.tuslah_umum_rj,margin_apotik.tuslah_umum_ikutrekening,
margin_apotik.tuslah_gratis_rj,margin_apotik.tuslah_gratis_ri,margin_apotik.tuslah_pen_bebas,
margin_apotik.tuslah_nempil,margin_apotik.tuslah_nempil_apt,
rs00001.comment AS jasa, rs00016a.qty_ri AS stok
    FROM rs00015 
    INNER JOIN rs00001 ON rs00015.kategori_id = rs00001.tc 
    INNER JOIN rs00016 ON rs00015.id = rs00016.obat_id
    INNER JOIN rs00016a ON rs00015.id = rs00016a.obat_id
    INNER JOIN margin_apotik on rs00015.kategori_id = margin_apotik.kategori_id 
    WHERE rs00001.tt = 'GOB' and rs00015.kategori_id = margin_apotik.kategori_id and status='1'
    ORDER BY rs00015.obat ASC");
?>
<script>
 $("#relasi_apotik").submit(function(){
        var nr = $('select[name="nama_relasi"]').val();

	       if (nr == '') 
		   { 
              alert('Nama relasi harus diisi!');
              return false;
		   }
	});
$('#list_pembelian').load('actions/apotik_umum_insert.php?no_reg=<?php echo $newNoReg?>')
$('#daftar_penjulan_obat').dataTable({
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "aoColumns": [
                            { "bSortable": false },
                            null,
                            null,
                            null,
                            null,
                            null,
                            null,
                            null
                        ]
});

var data = [
    <?php 
    while ($row = pg_fetch_array($result))
    {
        $id = $row["id"];
		
		if ($margin=='001' && ($row["kategori_id"] == '013' || $row["kategori_id"] == '014' || $row["kategori_id"] == '048')) {
				   $harga = (int)$row["harga"] * 1.25;
				    $jasa = (int)$row["tuslah_car_drs"];}
		else if ($margin=='002' && ($row["kategori_id"] == '013' || $row["kategori_id"] == '014' || $row["kategori_id"] == '048')) {
				   $harga = (int)$row["harga"] * 1.25;
				   $jasa = (int)$row["tuslah_car_rsrj"];}
		else if ($margin=='003' && ($row["kategori_id"] == '013' || $row["kategori_id"] == '014' || $row["kategori_id"] == '048')) {
				   $harga = (int)$row["harga"] * 1.25;
				   $jasa = (int)$row["tuslah_car_rsri"];}
		else if ($margin=='006' && ($row["kategori_id"] == '013' || $row["kategori_id"] == '014' || $row["kategori_id"] == '048')) {
				   $harga = (int)$row["harga"] * 1.25;
				   $jasa = (int)$row["tuslah_jam_ri"];}
		else if($relasi=='001'){
				   $harga = (int)$row["harga_car_drs"];}
				   /** Rawat Jalan - Karyawan */
		else if($relasi=='002'){
				   $harga = (int)$row["harga_car_rsrj"];}
		else if($relasi=='003'){
				   /** Rawat Inap - Karyawan */
				   $harga = (int)$row["harga_car_rsri"];}
		else if($relasi=='004'){
				   /** Rawat Jalan - JPK */
				   $harga = (int)$row["harga_inhealth_drs"];
				  }
		else if($relasi=='005'){
				   /** Rawat Inap - JPK */
				   $harga = (int)$row["harga_inhealth_rs"];
				   }
		else if($relasi=='006'){
				   $harga = (int)$row["harga_jam_ri"];}
		else if($relasi=='007'){
			           $harga = (int)$row["harga_jam_rj"];}
		else if($relasi=='008'){
				   $harga = (int)$row["harga_kry_kelinti"];}
		else if($relasi=='009'){
				   $harga = (int)$row["harga_kry_kelbesar"];}
		else if($relasi=='010'){
				   $harga = (int)$row["harga_kry_kelgratisri"];}
		else if($relasi=='011'){
				   $harga = (int)$row["harga_kry_kelrespoli"];}
		else if($relasi=='012'){
				   $harga = (int)$row["harga_kry_kel"];}
		else if($relasi=='013'){
				   $harga = (int)$row["harga_kry_kelgratisrj"];}
		else if($relasi=='014'){
				   $harga = (int)$row["harga_umum_ri"];}
		else if($relasi=='015'){
				   $harga = (int)$row["harga_umum_rj"];}
		else if($relasi=='016'){
				   $harga = (int)$row["harga_umum_ikutrekening"];}
		else if($relasi=='017'){
				   $harga = (int)$row["harga_gratis_rj"];}
		else if($relasi=='018'){
				   $harga = (int)$row["harga_gratis_ri"];}
		else if($relasi=='019'){
				   $harga = (int)$row["harga_pen_bebas"];}
		else if($relasi=='020'){
				   $harga = (int)$row["harga_nempil"];}
		else{
				   $harga = (int)$row["harga_nempil_apt"];}
		/*
		//////////
		if($relasi=='019'){
					$harga = (int)$row["harga_pen_bebas"];}
		else if($relasi=='001'){
				   $harga = (int)$row["harga_car_drs"];
				   }
		else if($relasi=='002'){
				   $harga = (int)$row["harga_karyawan_rj"];
				   }
		else if($relasi=='003'){
				   $harga = (int)$row["harga_karyawan_ri"];
				   }
		else if($relasi=='004'){
				    $harga = (int)$row["harga_inhealth_drs"];
				  }
				  
		else if($relasi=='005'){
				   $harga = (int)$row["harga_umum_ri"];
				   }
		else if($relasi=='006'){
				   $harga = (int)$row["harga_jam_ri"];
				   }
		else if($relasi=='007'){
			           $harga = (int)$row["harga_jam_rj"];
					}
					
		else if($relasi=='008'){
				   $harga = (int)$row["harga_kry_kelinti"];
				   }
		else if($relasi=='009'){
				   $harga = (int)$row["harga_kry_kelbesar"];
				   }
		else if($relasi=='010'){
				   $harga = (int)$row["harga_kry_kelgratisri"];
				   }
				   
		else if($relasi=='011'){
				   $harga = (int)$row["harga_kry_kelrespoli"];
				   }
		else if($relasi=='012'){
				   $harga = (int)$row["harga_kry_kel"];
				   }
		else if($relasi=='013'){
				   $harga = (int)$row["harga_kry_kelgratisrj"];
				   }
		else if($relasi=='014'){
				   $harga = (int)$row["harga_umum_ri"];
				   }
				   
		else if($relasi=='015'){
				   $harga = (int)$row["harga_umum_rj"];
				   }
		else if($relasi=='016'){
				   $harga = (int)$row["harga_umum_ikutrekening"];
				   }
		else if($relasi=='017'){
				   $harga = (int)$row["harga_gratis_rj"];
				   }
		else if($relasi=='018'){
				   $harga = (int)$row["harga_gratis_ri"];
				   }
		else if($relasi=='020'){
				   $harga = (int)$row["harga_nempil"];
				   }
		else{
				   $harga = (int)$row["harga_nempil_apt"];
        //$harga = (int)$row["harga"];
		}
		*/
        $obat = str_replace("'","/",$row["obat"]);
		
        echo "{";
        echo "id: ".$id .", ";
        echo "value: '".$obat ."', ";
        echo "harga: '".$harga ."'";
        echo "},";
    }
    ?>
                ""
];

$( "#obat_nama" ).autocomplete({
    source: data,
    messages: {
                noResults: "",
                results: function( amount ) {
                }
        },
    minLength: 3,
    select: function (event, ui) {
        $('#obat_id').val('');
        $('#obat_nama').val('');
        $('#qty').val('');
        $('#harga').val('');
        $('#harga_awal').val('');
        $('#jumlah').val('');
        var obatId = ui.item.id;
        var obatNama = ui.item.value;
        var obatSatuan = ui.item.satuan;
        var obatHarga = ui.item.harga;

        $('#obat_id').val(obatId);
        $('#obat_nama').val(obatNama);
        $('#harga').val(obatHarga);
        $('#harga_awal').val(obatHarga);
    }
});

$("#qty").keyup( function(){

    var obatQty = $('#qty').val();
    var obatHargaAwal = parseFloat($('#harga_awal').val());   
    
    
    isResep = 0;
    if ($('#resep').is(":checked"))
    {
        isResep = 1;
    }  
    
    if (isResep == 0 )
    {	obatHargaNew = (obatHargaAwal);
        //obatHargaNew = (obatHargaAwal)/12*11;
        obatHargaNew = parseInt(obatHargaNew);
//        duaPuluhPersenHarga = (20*obatHarga)/100;
//        hargaAwal = obatHarga-duaPuluhPersenHarga;
//        sepuluhPersenHargAwal  = (10*hargaAwal)/100; 
//        obatHarga = hargaAwal+sepuluhPersenHargAwal;
        $('#harga').val(obatHargaNew);
        $('#jumlah').val(obatHargaNew*obatQty);
    }else{    
        jumlah = (parseFloat(obatQty)*parseFloat(obatHargaAwal));
        $('#jumlah').val(jumlah);
    }
});

var options = { 
    target:        '#list_pembelian',    
    beforeSubmit:  showRequest,   
    success:       showResponse   
}; 

$('#form-penjualan').ajaxForm(options); 

/*start nama relasi checbox resep*/
$('#nama_relasi').change(function(){
    if($('#nama_relasi').val() == '022'){
    	$('#resep').attr('checked', true); 
    } else {
    	$('#resep').attr('checked', false); 
    }
    
});

if($('#nama_relasi').val() == '022'){
	$('#resep').attr('checked', true); 
} else {
	$('#resep').attr('checked', false); 
}
/* end  nama relasi checbox resep*/

function showRequest() { 
    if ($('#resep').is(":checked"))
    {
        $('#resep').val('YA');
    }else{
        $('#resep').val('TIDAK');
    }
} 

function showResponse(responseText, statusText, xhr, $form)  { 
    $('#list_pembelian').empty();
    $('#list_pembelian').load('actions/apotik_umum_insert.php?no_reg=<?php echo $newNoReg?>');

    $('#id').val('');
    $('#obat_id').val('');
    $('#obat_nama').val('');
    $('#qty').val('');
    $('#qty_awal').val('');
    $('#harga').val('');
    $('#jumlah').val('');  
    $('#resep').attr('checked', false); 
    
}

function addNew(){
    window.location = '<?php echo $SC.'?p='.$PID?>';
}

function cetakPembelian(no_reg){
    window.open('includes/cetak.apotik_umum.php?no_reg='+no_reg, 'xWin','top=0,left=0,width=750,height=550,menubar=no,location=no,scrollbars=yes');
}
function cetakRincianObat(no_reg){
    window.open('includes/cetak.apotik_umum_rincian.php?no_reg='+no_reg, 'xWin','top=0,left=0,width=750,height=550,menubar=no,location=no,scrollbars=yes');
}


function addNewRow(){
    var id              = $('#id').val();
    // jika nilai id tidak kosong berarti update
    if(parseInt(id) > 0){
        
        valObatId   = $('#obat_id').val();
        valObatNama = $('#obat_nama').val();
        valQty      = $('#qty').val();
        valHarga    = $('#harga').val();
        valJumlah   = $('#jumlah').val();

        if(valQty <= 0){
            alert('Jumlah obat harus diisi !');
            return false;
        }

        $.post('actions/apotik_umum_insert.php',
                    {
                        id: id,
                        obat_id: valObatId,
                        obat_nama: valObatNama,
                        qty: valQty,
                        harga: valHarga,
                        jumlah: valJumlah

                    }
                ).success(function(data){ 
                        $('#list_pembelian').empty();
                        $('#list_pembelian').load('actions/apotik_umum_insert.php?no_reg=<?php echo $newNoReg?>');
                                    });           
        
    }else{

        var maxObat         = $('#max_obat').val();
        var valObatId       = $('#obat_id').val();
        var valObatNama     = $('#obat_nama').val();
        var valQty          = $('#qty').val();
        var valHarga        = $('#harga').val();
        var valJumlah        = $('#jumlah').val();

        if(valQty == '' || valQty == 0){
            alert('Jumlah harus diisi!');
            return false;
        }
        indexNextObat	= parseInt(maxObat)+1;
        $('#max_obat').val(indexNextObat);

        $('#list-obat tbody').append( '<tr id="list_obat_'+indexNextObat+'">'+
            '<td>'+
            '<input type="hidden" name="obat_id_'+indexNextObat+'" value="'+valObatId+'" />'+
            '<input type="text" name="obat_nama_'+indexNextObat+'" value="'+valObatNama+'" size="50" readonly="" style="border:none;" />'+
            '</td>'+
            '<td>'+
            '<input type="text" name="qty_'+indexNextObat+'" value="'+valQty+'" size="3" readonly="" style="text-align:right;border:none;"/>'+
            '</td>'+
            '<td><input type="text" name="harga_'+indexNextObat+'" id="harga"  value="'+valHarga+'" size="10" readonly="" style="text-align: right;border:none;"/></td>'+
            '<td><input type="text" name="jumlah_'+indexNextObat+'" id="jumlah" value="'+valJumlah+'" size="10" readonly="" style="text-align: right;border:none;;" /></td>'+
            '<td><span ><a onClick="deleteRow('+indexNextObat+')"><b>[ - ]</b></a></td>'+
            '</tr>');
        $('#obat_id').val('');
        $('#obat_nama').val('');
        $('#qty').val('');
        $('#harga').val('');
        $('#jumlah').val('');   
    }
}

function deleteRow(iRow){
    $('#list_obat_'+iRow).remove();
}
    
function edit_data_obat(id){
    var obatId = $('#obat_id_'+id).val();
    var obatNama = $('#obat_nama_'+id).val();
    var qty = $('#qty_'+id).val();
    var harga = parseInt($('#harga_'+id).val().replace(',', ''));
    var jumlah = parseInt($('#jumlah_'+id).val().replace(',', ''));

    $('#id').val( id );
    $('#obat_id').val( obatId );
    $('#obat_nama').val( obatNama );
    $('#qty').val( qty );
    $('#harga').val( harga );
    $('#jumlah').val(jumlah);
}

function delete_data_obat(id){
    
        $.post('actions/apotik_umum_insert.php?no_reg=<?php echo $newNoReg?>',
                    {
                        id: id,
                        del: 'true'
                    }
                ).success(function(data){ 
                                    $('#list_pembelian').empty();
                                    $('#list_pembelian').load('actions/apotik_umum_insert.php?no_reg=<?php echo $newNoReg?>');
                 });   
}

function fltData(str){
    window.location = 'index2.php?p=apotik_umum&start_date='+str;
}
</script>
