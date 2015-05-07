<?php
#
#
$_WARNRULE = '#FFFF00';
$_CRITRULE = '#FF0000';
$_AREA     = '#256aef';
$_LINE     = '#000000';

# two DS expected: array & semaphores with max

$opt[1] = " --vertical-label \"# array\" -W \"KM Consulting\" -l 0 -u $MAX[1] --title \"Numero di array di semafori allocati su $hostname\" ";
$def[1] = "DEF:var1=$RRDFILE[1]:$DS[1]:AVERAGE " ;
$def[1] .= "LINE3:var1#ff0000:\"Numero di array\\n\" " ;
$def[1] .= "GPRINT:var1:LAST:\"ultimo valore\: %.0lf, \" " ;
$def[1] .= "GPRINT:var1:MAX:\"massimo\: %.0lf, \" " ;
$def[1] .= "GPRINT:var1:AVERAGE:\"media\: %.0lf, \" " ;
$def[1] .= "GPRINT:var1:MIN:\"minimo\: %.0lf\\n\" " ;
$def[1] .= rrd::hrule($MAX[1], "#000000", "Numero massimo di array disponibili\: ".$MAX[1]);

$opt[2] = " --vertical-label \"# semafori\" -W \"KM Consulting\" -o --units=si -l 1 -u $MAX[2] --title \"Numero di semafori allocati su $hostname\" ";
$def[2] = "DEF:var1=$RRDFILE[1]:$DS[1]:AVERAGE " ;
$def[2] .= "LINE3:var1#ff0000:\"Numero di semafori\\n\" " ;
$def[2] .= "GPRINT:var1:LAST:\"ultimo valore\: %.0lf, \" " ;
$def[2] .= "GPRINT:var1:AVERAGE:\"media\: %.0lf, \" " ;
$def[2] .= "GPRINT:var1:MAX:\"massimo\: %.0lf\\n\" " ;
$def[2] .= rrd::hrule($MAX[1], "#aaaaaa", "Numero massimo di semafori disponibili in caso di 1 semaforo per array \: ".$MAX[1]);
$def[2] .= rrd::hrule($MAX[2], "#000000", "Numero massimo (teorico) di semafori disponibili \: ".$MAX[2]);

?>
