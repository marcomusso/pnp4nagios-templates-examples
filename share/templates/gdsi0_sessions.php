<?php
#
#
#

$colors=array("CC3300","CC3333","CC3366","CC3399","CC33CC","CC33FF","336600","336633","336666","336699","3366CC","3366FF","33CC33","33CC66","609978","922A99","997D6D","174099","1E9920","E88854","AFC5E8","57FA44","FA6FF6","008080","D77038","272B26","70E0D9","0A19EB","E5E29D","930526","26FF4A","ABC2FF","E2A3FF","808000","000000","00FAFA","E5FA79","F8A6FF","FF36CA","B8FFE7","CD36FF", "CC3300","CC3333","CC3366","CC3399","CC33CC","CC33FF","336600","336633","336666","336699","3366CC","3366FF","33CC33","33CC66","609978","922A99","997D6D","174099","1E9920","E88854","AFC5E8","57FA44","FA6FF6","008080","D77038","272B26","70E0D9","0A19EB","E5E29D","930526","26FF4A","ABC2FF","E2A3FF","808000","000000","00FAFA","E5FA79","F8A6FF");

$defcnt = 1;

        $ds_name[$defcnt] = "Numero di sessioni";
        $opt[$defcnt] = "--vertical-label \"sessioni\" --title \"Sessioni GDSI0\" ";
        $def[$defcnt] = "";
        $def[$defcnt] .= "DEF:salvmp67_gdsi0_sessions=/usr/local/pnp4nagios/var/perfdata/salvmp67/GDSI0_Documentum_SESSION.rrd:$DS[1]:AVERAGE " ; 
        $def[$defcnt] .= "DEF:salvmp68_gdsi0_sessions=/usr/local/pnp4nagios/var/perfdata/salvmp68/GDSI0_Documentum_SESSION.rrd:$DS[1]:AVERAGE " ; 
        $def[$defcnt] .= "DEF:salvmp67_gdsi0_maxsessions=/usr/local/pnp4nagios/var/perfdata/salvmp67/GDSI0_Documentum_SESSION.rrd:$DS[2]:AVERAGE " ; 
        $def[$defcnt] .= "DEF:salvmp68_gdsi0_maxsessions=/usr/local/pnp4nagios/var/perfdata/salvmp68/GDSI0_Documentum_SESSION.rrd:$DS[2]:AVERAGE " ; 

	$def[$defcnt] .= "CDEF:sessions=salvmp67_gdsi0_sessions,salvmp68_gdsi0_sessions,+ " ;
	$def[$defcnt] .= "CDEF:maxsessions=salvmp67_gdsi0_maxsessions,salvmp68_gdsi0_maxsessions,+ " ;

        $def[$defcnt] .= "GPRINT:sessions:LAST:\"Ultimo valore\: %4.0lf %S \" "; 
        $def[$defcnt] .= "GPRINT:sessions:MAX:\" Massimo\: %4.0lf %S \" "; 
        $def[$defcnt] .= "GPRINT:sessions:AVERAGE:\"Media\: %4.0lf %S \" "; 

        $def[$defcnt] .= "GPRINT:maxsessions:LAST:\"Ultimo valore\: %4.0lf %S \" "; 
        $def[$defcnt] .= "GPRINT:maxsessions:MAX:\" Massimo\: %4.0lf %S \" "; 
        $def[$defcnt] .= "GPRINT:maxsessions:AVERAGE:\"Media\: %4.0lf %S \" "; 

        if($CRIT[$defcnt] != ""){
          $def[$defcnt] .= rrd::hrule($CRIT[$defcnt], "#FF0000", "Critico\: ".$CRIT[$defcnt].$UNIT[$defcnt]." sessioni\\n");
        }

	$def[$defcnt] .= "AREA:salvmp67_gdsi0_sessions#".$colors[10].":\" salvmp67_gdsi0_sessions \":STACK ";
	$def[$defcnt] .= "AREA:salvmp68_gdsi0_sessions#".$colors[20].":\" salvmp68_gdsi0_sessions \":STACK ";

	$def[$defcnt] .= "LINE:maxsessions#".$colors[1].":\" maxsessions \": ";

        $defcnt++;

