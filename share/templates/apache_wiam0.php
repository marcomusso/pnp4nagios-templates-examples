<?php
#
# Copyright (c) 2009 Gerhard Lausser (gerhard.lausser@consol.de)
# Plugin: check_apachestatus_auto (http://www.spreendigital.de/blog/nagios/?#check_apachestatus_auto)
# Release 1.0 2009-07-14
#
# This is a template for the visualisation addon PNP (http://www.pnp4nagios.org)
#
# Modified version for the values extracted by out custom script check_apachestatus
#

$defcnt = 1;

$colors=array("CC3300","CC3333","CC3366","CC3399","CC33CC","CC33FF","336600","336633","336666","336699","3366CC","3366FF","33CC33","33CC66","609978","922A99","997D6D","174099","1E9920","E88854","AFC5E8","57FA44","FA6FF6","008080","D77038","272B26","70E0D9","0A19EB","E5E29D","930526","26FF4A","ABC2FF","E2A3FF","808000","000000","00FAFA","E5FA79","F8A6FF","FF36CA","B8FFE7","CD36FF", "CC3300","CC3333","CC3366","CC3399","CC33CC","CC33FF","336600","336633","336666","336699","3366CC","3366FF","33CC33","33CC66","609978","922A99","997D6D","174099","1E9920","E88854","AFC5E8","57FA44","FA6FF6","008080","D77038","272B26","70E0D9","0A19EB","E5E29D","930526","26FF4A","ABC2FF","E2A3FF","808000","000000","00FAFA","E5FA79","F8A6FF");
$area_unica=0;

# out wiam0 instances and max configured slots
$instances=4;
$slots_per_instance=960;
$project="wiam0";

foreach ($DS as $i) {

    if(preg_match('/AvailableSlots$/', $NAME[$i])) {
        $ds_name[$defcnt] = "AvailableSlots";
        $opt[$defcnt] = "--vertical-label \"slot\" --title \"Apache ".$project." | Slot disponibili\" ";
        $def[$defcnt] = "";
        $def[$defcnt] .= "DEF:wiam0_webmo106=/usr/local/pnp4nagios/var/perfdata/webmo106/Apache_wiam0.rrd:$DS[$i]:AVERAGE " ;
        $def[$defcnt] .= "DEF:wiam0_webmo107=/usr/local/pnp4nagios/var/perfdata/webmo107/Apache_wiam0.rrd:$DS[$i]:AVERAGE " ;
        $def[$defcnt] .= "DEF:wiam0_webst60=/usr/local/pnp4nagios/var/perfdata/webst60/Apache_wiam0.rrd:$DS[$i]:AVERAGE " ;
        $def[$defcnt] .= "DEF:wiam0_webst61=/usr/local/pnp4nagios/var/perfdata/webst61/Apache_wiam0.rrd:$DS[$i]:AVERAGE " ;

	# per sostituire UKNOWN con 0 solo per la wiam0_webmo106 ("normalizzo"), da fare per tutti...
	$def[$defcnt] .= "CDEF:norm_wiam0_webmo106=wiam0_webmo106,UN,0,wiam0_webmo106,IF " ;

	$def[$defcnt] .= "CDEF:AvailableSlots=norm_wiam0_webmo106,wiam0_webmo107,+,wiam0_webst60,+,wiam0_webst61,+ " ;

	$TotalSlots=$instances*$slots_per_instance;

        $def[$defcnt] .= "GPRINT:AvailableSlots:LAST:\"Ultimo valore\: %4.0lf %S \" ";
        $def[$defcnt] .= "GPRINT:AvailableSlots:MAX:\" Massimo\: %4.0lf %S \" ";
        $def[$defcnt] .= "GPRINT:AvailableSlots:AVERAGE:\"Media\: %4.0lf %S \" ";
        #if($CRIT[$defcnt] != ""){
        #  $def[$defcnt] .= rrd::hrule($CRIT[$defcnt], "#FF0000", "Critico\: ".$CRIT[$defcnt].$UNIT[$defcnt]." slot\\n");
        #}
	# riga al numero massimo di slot disponibili
        $def[$defcnt] .= "HRULE:".$TotalSlots."#00ff00:\"Totale slot\: ".$TotalSlots." \\n\" ";

	if ($area_unica == 0) {
		#$colors['AvailableSlots'] = "3333ee";
		#$def[$defcnt] .= "AREA:AvailableSlots#".$colors['AvailableSlots'].":\" Slot disponibili \" ";
 		$def[$defcnt] .= rrd::gradient('AvailableSlots','ff0000','0000a0','Slot disponibili', $instances);
	} else {
	  $def[$defcnt] .= "AREA:wiam0_webmo106#".$colors[3].":\" wiam0_webmo106 \":STACK ";
	  $def[$defcnt] .= "AREA:wiam0_webmo107#".$colors[4].":\" wiam0_webmo107 \":STACK ";
	  $def[$defcnt] .= "AREA:wiam0_webst60#".$colors[5].":\" wiam0_webst60 \":STACK ";
	  $def[$defcnt] .= "AREA:wiam0_webst61#".$colors[6].":\" wiam0_webst61 \":STACK ";
	}

        $defcnt++;
    }
}

