<? // Nugraha, 17/02/2004
   // Pur, 27/02/2004
   // Pur, 27/03/2004 : new libs table
   // sfdn, 30-04-2004
   
$PID = "804";
$SC = $_SERVER["SCRIPT_NAME"];

require_once("lib/dbconn.php");
require_once("lib/form.php");
require_once("lib/class.PgTable.php");
require_once("lib/functions.php");

$r = pg_query($con,"select * from rs00011");
$d = pg_fetch_object($r);
pg_free_result($r);


if(strlen($_GET["e"]) > 0) {
    if($_GET["e"] == "new") {
        $f = new Form("actions/804.insert.php");
        title("Ruangan Baru");
        echo "<BR>";
        $f->text("id","ID",12,12,"<OTOMATIS>","DISABLED");
    } else {
        $r2 = pg_query($con,
            "select * ".
            "from rs00011 ".
            "where id='".$_GET["e"]."'");
        $d2 = pg_fetch_object($r2);
        pg_free_result($r2);
        $f = new Form("actions/804.update.php");
        title("Edit Ruangan");
        echo "<BR>";
        $f->hidden("id",$_GET["e"]);
        $f->text("id","ID",4,4,$_GET["e"],"DISABLED");
    }
    $f->PgConn = $con;
    $f->text("f_ruangan","Ruangan",40,50,$d2->ruangan);
    $f->selectSQL("f_bangsal_id", "Bangsal",
                  "select id, bangsal from rs00010",
                  $d2->bangsal_id);
    $f->submit(" Simpan ");
    $f->execute();
    echo "<br>";
    if(strlen($_GET["err"]) > 0) {
        errmsg("Terjadi Kesalahan", stripslashes($_GET["err"]));
    }
} else {

    title("Tabel Master: Ruangan");
    echo "<DIV ALIGN=RIGHT><TABLE BORDER=0><FORM ACTION=$SC><TR>";
    echo "<INPUT TYPE=HIDDEN NAME=p VALUE=$PID>";
    echo "<TD><INPUT TYPE=TEXT NAME=search VALUE='".$_GET["search"]."'></TD>";
    echo "<TD><INPUT TYPE=SUBMIT VALUE=' Cari '></TD>";
    echo "</TR></FORM></TABLE></DIV>";

    $t = new PgTable($con, "100%");
    $t->SQL = 
        "select rs00011.ruangan, rs00010.bangsal, rs00011.id as dummy from rs00010, rs00011 where rs00011.bangsal_id = rs00010.id ".
        "and ".
        "(upper(rs00011.ruangan) LIKE '%".strtoupper($_GET["search"])."%' ".
        "OR upper(rs00010.bangsal) LIKE '%".strtoupper($_GET["search"])."%')";
    $t->setlocale("id_ID");
    $t->ShowRowNumber = true;
    $t->RowsPerPage = 14;
    $t->ColAlign[3] = "CENTER";
    $t->ColFormatHtml[2] = "<A CLASS=TBL_HREF HREF='$SC?p=$PID&e=<#2#>'>".icon("edit","Edit")."</A>";
    $t->ColHeader = array("RUANGAN", "BANGSAL", "E d i t");
    
    $t->execute();
    
    echo "<BR><DIV ALIGN=RIGHT><A CLASS=SUB_MENU ".
         "HREF='index2.php?p=$PID&e=new'>&#171; Tambah Data Ruangan &#187;</A></DIV>";
}
    

?>
