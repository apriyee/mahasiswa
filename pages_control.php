<!-- 
Paging by Apri suharto 20
-->

<style type="text/css">
#tnt_pagination {
	display:block;
	text-align:right;
	height:22px;
	line-height:21px;
	clear:both;
	padding-top:3px;
	font-family:Arial, Helvetica, sans-serif;
	font-size:11px;
	font-weight:normal;
}

#tnt_pagination a:link, #tnt_pagination a:visited{
	padding:3px;
	border:1px solid #EBEBEB;
	margin-left:1px;
	text-decoration:none;
	background-color:#F5F5F5;
	color:#0072bc;
	width:22px;
	font-weight:normal;
}

#tnt_pagination a:hover {
	background-color:#DDEEFF;
	border:1px solid #BBDDFF;
	color:#0072BC;	
}

#tnt_pagination .active_tnt_link {
	padding:3px;
	border:1px solid #BBDDFF;
	margin-left:1px;
	text-decoration:none;
	background-color:#DDEEFF;
	color:#0072BC;
	cursor:default;
}

#tnt_pagination .disabled_tnt_pagination {
	padding:3px;
	margin-left:1px;
	border:1px solid #EBEBEB;
	text-decoration:none;
	background-color:#F5F5F5;
	color:#D7D7D7;
	cursor:default;
}

</style>
<div id="tnt_pagination">
<?php 
if(isset($kondisi)) { 
	$total_record = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM $table WHERE $kondisi"),0); } 
	else { 
		$total_record = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM $table"),0); } 

$total_halaman = ceil($total_record / $jmlperhalaman);
$perhal=$jmlperhalaman;

if($hal > 1){ 
    $prev = ($page - 1); 
    echo "<a href=$pgurl&hal=$prev>&#9668; prev</a> "; 
    } else { 
	   echo "<span class=\"disabled\"> &#9668; prev</span>"; } 

if($total_halaman<=$jmlperhalaman){
	$hal1=1;
	$hal2=$total_halaman; 
}else{
	$hal1=$hal-$perhal;
	$hal2=$hal+$perhal;
}

if($hal<=$jmlperhalaman){  $hal1=1; }
if($hal<$total_halaman){ $hal2=$hal+$perhal; } else { $hal2=$hal; }
for($i = $hal1; $i <= $hal2; $i++){ 
    if(($hal) == $i){ 
	    echo "<span class=\"active_tnt_link\"><b>$i</b></span>"; 
       // echo " [<b>$i</b>] "; 
        } else { 
    if($i<=$total_halaman){
            echo " <a href=$pgurl&hal=$i>$i</a> "; 
    }
    } 
}
if($hal < $total_halaman){ 
    $next = ($page + 1); 
    echo "<a href=$pgurl&hal=$next>next &#9658; </a>"; 
} else { 
	echo "&nbsp;<span class=\"disabled\">next &#9658; </span>"; 
}
?>
</div>