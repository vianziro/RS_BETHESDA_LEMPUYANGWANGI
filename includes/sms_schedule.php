<? // Nugraha, 17/02/2004
   // Pur, 08/03/2004: new libs table
   // sfdn, 22-04-2004
   // sfdn, 23-04-2004
   // sfdn, 01-05-2004
   // sfdn, 01-06-2004
   // sfdn, 24-12-2006	

$PID = "sms_schedule";
$SC = $_SERVER["SCRIPT_NAME"];

require_once("startup.php");
require_once("lib/dbconn.php");

// 24-12-2006
    if ($_SESSION[uid] == "kasir2") {
       $what = "RAWAT INAP";
       $sqlayanan = "NOT LIKE '%IGD%'";	
    } elseif ($_SESSION[uid] == "kasir1") {
       $what = "RAWAT JALAN";
       $sqlayanan = "NOT LIKE '%IGD%'";
    } else {
       $what = "IGD";
       $sqlayanan = "LIKE '%IGD%'";
    
  echo "<table>";
    echo "<tr>";
    echo "<td><b><font size=4>SMS Broadcast</size></b></td>";
    echo "</tr>";
    echo "</table>";


// ---- end ----
  }
?>

<SCRIPT language=javascript>
		function jumlahKata(form) {
		with (form) {
			sisa.value = 160-pesan.value.length;
			if (parseInt(sisa.value)<0) {
				sisa.value = '0';
			}
		pesan.value = pesan.value.substr(0,160);
		}
		return;
	}

	</SCRIPT>



<form name ="fp" action="actions/sms_schedule_proc.php" method=POST>
    <table border="0"  align="center" width=75% cellspacing="0" cellpadding="0">
    <!--<TR>
        <td width=0%>&nbsp;</td>
        <TD width="25%" CLASS=FORM>Tanggal Pengiriman</TD>
        <TD width="4%" CLASS=FORM><div align="center">:</div></TD>
        <TD width="71%" CLASS=FORM>
    <INPUT TYPE=TEXT NAME=tgl_awal SIZE=10 MAXLENGTH=12>
    <A HREF="#" onClick="cal.select(document.forms['fp'].tgl_awal,'tanggalan','dd-MM-yyyy'); return false;" NAME="tanggalan" ID="tanggalan" >
    <INPUT TYPE='IMAGE' SRC='icon/calendar.gif' TITLE='Pilih' ></A></TD>
    </TR>
    <TR><TD></TD></TR>
     <!--<TR>
        <td width=0%>&nbsp;</td>
        <TD width="25%" CLASS=FORM>Tanggal Akhir</TD>
        <TD width="4%" CLASS=FORM><div align="center">:</div></TD>
        <TD width="71%" CLASS=FORM>
    <INPUT TYPE=TEXT NAME=tgl_akhir SIZE=10 MAXLENGTH=12>
    <A HREF="#" onClick="cal.select(document.forms['fp'].tgl_akhir,'tanggalan','dd-MM-yyyy'); return false;" NAME="tanggalan" ID="tanggalan" >
    <INPUT TYPE='IMAGE' SRC='icon/calendar.gif' TITLE='Pilih' ></A></TD>-->
    <tr>
	<td width=0%>&nbsp;</td>
        <td width=25%>Nomor Tujuan</td>
        <td width=4%><div align="center">:</div></td>
	<td>
	<select name="groupid">
            <?php
              //$SQL = "select tc, tdesc from rs00001 where tt='PEG' order by tc";
              $SQL = "select * from pbk_groups order by id asc";
			  $r1 = pg_query($con,$SQL);
               while ($data = pg_fetch_array($r1))
                {
            ?>
               <option value="<?php echo $data[id];?>"><?php echo $data[name];?></option>
            <?php
                }
            ?>
        </select>
						</td>
					</tr>
	<tr>
		<td width=0%>&nbsp;</td>
		<td width=25%>Pesan </td>
		<td width=4%><div align="center">:</div></td>
		<td width=88% height=25%><font color="#000066"><TEXTAREA onkeyup=jumlahKata(document.fp); name=pesan rows=8 cols=75></TEXTAREA>Panjang maksimum: 160 karakter<BR>Sisa karakter:<INPUT
            size=3 name=sisa class=inputcontent></font>
	</tr>
	<tr>
	<td><input type=submit value=Kirim></td>
	<td><input type=reset value=Reset></td>
	</tr>
</table>
<!--select b.tdesc,b.tc, a.phone from rs00017 a  
left outer join rs00001 b ON a.jjd_id = b.tc and b.tt='JJD' 
left outer join rs00001 c ON a.gol_ruang_id = c.tc and c.tt='GRP'
where a.jjd_id='005'  -->
</form>