<?php
#
#
#

$colors=array("CC3300","CC3333","CC3366","CC3399","CC33CC","CC33FF","336600","336633","336666","336699","3366CC","3366FF","33CC33","33CC66","609978","922A99","997D6D","174099","1E9920","E88854","AFC5E8","57FA44","FA6FF6","008080","D77038","272B26","70E0D9","0A19EB","E5E29D","930526","26FF4A","ABC2FF","E2A3FF","808000","000000","00FAFA","E5FA79","F8A6FF","FF36CA","B8FFE7","CD36FF", "CC3300","CC3333","CC3366","CC3399","CC33CC","CC33FF","336600","336633","336666","336699","3366CC","3366FF","33CC33","33CC66","609978","922A99","997D6D","174099","1E9920","E88854","AFC5E8","57FA44","FA6FF6","008080","D77038","272B26","70E0D9","0A19EB","E5E29D","930526","26FF4A","ABC2FF","E2A3FF","808000","000000","00FAFA","E5FA79","F8A6FF");
$defcnt = 1;
$max_load=8*5; # we have 5 hosts with max load 8 (4 core each) ARGH!

$i=1;
#foreach ($DS as $i) {
#foreach (array(1,2,3) as $i) {

    if(preg_match('/load5/', $NAME[$i])) {
        $ds_name[$defcnt] = "Total load5";
        $opt[$defcnt] = "--vertical-label \"load5\" -W \"KM Consulting\" -u 40 --title \"Carico medio cumulativo su 5 macchine (5 minuti)\" ";
        $def[$defcnt] = "";
        $def[$defcnt] .= "DEF:sglvmp24_load5=/usr/local/pnp4nagios/var/perfdata/sglvmp24/Load_sglvmp24.rrd:$DS[$i]:AVERAGE " ;
        $def[$defcnt] .= "DEF:sglvmp26_load5=/usr/local/pnp4nagios/var/perfdata/sglvmp24/Load_sglvmp26.rrd:$DS[$i]:AVERAGE " ;
        $def[$defcnt] .= "DEF:sglvmp27_load5=/usr/local/pnp4nagios/var/perfdata/sglvmp24/Load_sglvmp27.rrd:$DS[$i]:AVERAGE " ;
        $def[$defcnt] .= "DEF:sglvmp28_load5=/usr/local/pnp4nagios/var/perfdata/sglvmp24/Load_sglvmp28.rrd:$DS[$i]:AVERAGE " ;
        $def[$defcnt] .= "DEF:sglvmp04_load5=/usr/local/pnp4nagios/var/perfdata/sglvmp24/Load_sglvmp04.rrd:$DS[$i]:AVERAGE " ;

	$def[$defcnt] .= "CDEF:TotalLoad5=sglvmp24_load5,sglvmp26_load5,+,sglvmp27_load5,+,sglvmp28_load5,+,sglvmp04_load5,+ " ;

        $def[$defcnt] .= "GPRINT:TotalLoad5:LAST:\"Ultimo valore\: %4.0lf %S \" ";
        $def[$defcnt] .= "GPRINT:TotalLoad5:MAX:\" Massimo\: %4.0lf %S \" ";
        $def[$defcnt] .= "GPRINT:TotalLoad5:AVERAGE:\"Media\: %4.0lf %S \\n\" ";
        #if($CRIT[$defcnt] != ""){
        #  $def[$defcnt] .= rrd::hrule($CRIT[$defcnt]*4, "#FF0000", "Critico per singola macchina\: ".$CRIT[$defcnt].$UNIT[$defcnt]." \\n");
        #}
	      # draw a line at the max
        $def[$defcnt] .= "HRULE:".$max_load."#ff0000:\"Carico massimo cumulativo su 5 macchine\: 8*5=".$max_load." \\n\" ";

	$def[$defcnt] .= "AREA:sglvmp24_load5#".$colors[11].":\" sglvmp24_load5 \":STACK ";
	$def[$defcnt] .= "AREA:sglvmp26_load5#".$colors[21].":\" sglvmp26_load5 \":STACK ";
	$def[$defcnt] .= "AREA:sglvmp27_load5#".$colors[31].":\" sglvmp27_load5 \":STACK ";
	$def[$defcnt] .= "AREA:sglvmp28_load5#".$colors[41].":\" sglvmp28_load5 \":STACK ";
	$def[$defcnt] .= "AREA:sglvmp04_load5#".$colors[15].":\" sglvmp04_load5 \":STACK ";

        $defcnt++;
    }

#}

?>
