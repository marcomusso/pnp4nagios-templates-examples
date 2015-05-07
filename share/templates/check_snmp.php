<?php

#
# Template personalizzato per gestire tutti i casi di check SNMP (proliferati con l'introduzione delle get SNMP per DRM, inizio 2013)
# Marco Musso (KM Consulting)
#
#

switch ($servicedesc) {

case "Users":
  $opt[1] = " --vertical-label \"# Users\" -l 0 --title \"Utenti connessi su $hostname\" ";
  $def[1] = "DEF:var1=$RRDFILE[1]:$DS[1]:AVERAGE " ;
  $def[1] .= "AREA:var1#ff0000:\"Numero di utenti connessi \" " ;
  $def[1] .= "GPRINT:var1:LAST:\"%7.0lf %S ultimo valore\" " ;
  $def[1] .= "GPRINT:var1:AVERAGE:\"%7.0lf %S media\" " ;
  $def[1] .= "GPRINT:var1:MAX:\"%7.0lf %S massimo\\n\" " ;
  break;

case "eth0":
case "bond0":
case "Network":
  $opt[1] = " --vertical-label \"Bytes\" --title \"Interface Traffic for $hostname\" ";
  $def[1] = "DEF:var1=$RRDFILE[1]:$DS[1]:AVERAGE " ;
  $def[1] .= "DEF:var2=$RRDFILE[1]:$DS[2]:AVERAGE " ;
  $def[1] .= "AREA:var1#00ea00:\"In  \" " ;
  $def[1] .= "GPRINT:var1:LAST:\"%7.0lf %SB/s last\" " ;
  $def[1] .= "GPRINT:var1:AVERAGE:\"%7.0lf %SB/s avg\" " ;
  $def[1] .= "GPRINT:var1:MAX:\"%7.0lf %SB/s max\\n\" " ;
  $def[1] .= "LINE3:var2#0000AA:\"Out \" " ;
  $def[1] .= "GPRINT:var2:LAST:\"%7.0lf %SB/s last\" " ;
  $def[1] .= "GPRINT:var2:AVERAGE:\"%7.0lf %SB/s avg\" " ;
  $def[1] .= "GPRINT:var2:MAX:\"%7.0lf %SB/s max\\n\" ";
  break;

case "Processes":
  $opt[1] = " --vertical-label \"# Processes\" -l 0 --title \"Numero di processi su $hostname\" ";
  $def[1] = "DEF:var1=$RRDFILE[1]:$DS[1]:AVERAGE " ;
  $def[1] .= "LINE3:var1#ff0000:\"Numero di processi \" " ;
  $def[1] .= "GPRINT:var1:LAST:\"%7.0lf %S ultimo valore\" " ;
  $def[1] .= "GPRINT:var1:AVERAGE:\"%7.0lf %S media\" " ;
  $def[1] .= "GPRINT:var1:MAX:\"%7.0lf %S massimo\\n\" " ;
  break;

case "Swap":
  $opt[1] = " --vertical-label \"Swap (GB)\" -l 0 --title \"Swap for $hostname\" ";
  $def[1] = "DEF:total=$RRDFILE[1]:$DS[1]:MAX " ;
  $def[1] .= "DEF:available=$RRDFILE[1]:$DS[2]:AVERAGE " ;
  $def[1] .= "CDEF:used=total,available,- " ;

  $def[1] .= "CDEF:gtotal=total,1024,/,1024,/ " ;
  $def[1] .= "CDEF:gused=used,1024,/,1024,/ " ;
  $def[1] .= "CDEF:gavailable=available,1024,/,1024,/ " ;

  $def[1] .= "GPRINT:gtotal:MAX:\"Total swap %4.2lf %SB \\n\" " ;

  $def[1] .= "AREA:gavailable#00ea00:\"Available swap \":STACK " ;
  $def[1] .= "GPRINT:gavailable:LAST:\"%4.2lf %SB last\" " ;
  $def[1] .= "GPRINT:gavailable:AVERAGE:\"%4.2lf %SB avg\" " ;
  $def[1] .= "GPRINT:gavailable:MAX:\"%4.2lf %SB max\\n\" ";

  $def[1] .= "AREA:gused#ea0000:\"Used swap      \":STACK " ;
  $def[1] .= "GPRINT:gused:LAST:\"%4.2lf %SB last\" " ;
  $def[1] .= "GPRINT:gused:AVERAGE:\"%4.2lf %SB avg\" " ;
  $def[1] .= "GPRINT:gused:MAX:\"%4.2lf %SB max\\n\" ";
  break;

case "CPU":
  # converto in CPU deducendo il numero di CPU dal totale / 100 come da suggerimento in http://www.opennms.org/wiki/Net-snmp_5.3_CPU_collections
  # per ora uso solo 4 delle 6 metriche (sono escluse kernel e wait)
  $opt[1] = " --vertical-label \"%\" -l 0 -u 100 --title \"CPU usage for $hostname\" ";
  $def[1] = "DEF:rawsystem=$RRDFILE[1]:$DS[1]:AVERAGE " ;
  $def[1] .= "DEF:rawnice=$RRDFILE[1]:$DS[2]:AVERAGE " ;
  $def[1] .= "DEF:rawuser=$RRDFILE[1]:$DS[3]:AVERAGE " ;
  $def[1] .= "DEF:rawidle=$RRDFILE[1]:$DS[4]:AVERAGE " ;
  $def[1] .= "CDEF:numCpu=rawuser,rawnice,+,rawsystem,+,rawidle,+,100,/ ";
 
  # calcolo percentuale
  $def[1] .= "CDEF:user=rawuser,numCpu,/ ";
  $def[1] .= "CDEF:nice=rawnice,numCpu,/ ";
  $def[1] .= "CDEF:system=rawsystem,numCpu,/ ";
  #$def[1] .= "CDEF:ssCpuKernel=ssCpuRawKernel,numCpu,/ ";
  #$def[1] .= "CDEF:ssCpuWait=ssCpuRawWait,numCpu,/ ";
  $def[1] .= "CDEF:idle=rawidle,numCpu,/ ";

  $def[1] .= "LINE2:system#ff4500:\"System \" " ;
  $def[1] .= "GPRINT:system:LAST:\"%4.2lf %S last\" " ;
  $def[1] .= "GPRINT:system:AVERAGE:\"%4.2lf %S avg\" " ;
  $def[1] .= "GPRINT:system:MAX:\"%4.2lf %S max\\n\" ";

  $def[1] .= "LINE2:nice#ea0000:\"Nice   \" " ;
  $def[1] .= "GPRINT:nice:LAST:\"%4.2lf %S last\" " ;
  $def[1] .= "GPRINT:nice:AVERAGE:\"%4.2lf %S avg\" " ;
  $def[1] .= "GPRINT:nice:MAX:\"%4.2lf %S max\\n\" ";

  $def[1] .= "LINE2:user#9400d3:\"User   \" " ;
  $def[1] .= "GPRINT:user:LAST:\"%4.2lf %S last\" " ;
  $def[1] .= "GPRINT:user:AVERAGE:\"%4.2lf %S avg\" " ;
  $def[1] .= "GPRINT:user:MAX:\"%4.2lf %S max\\n\" ";

  $def[1] .= "LINE2:idle#00ea00:\"Idle   \" " ;
  $def[1] .= "GPRINT:idle:LAST:\"%4.2lf %S last\" " ;
  $def[1] .= "GPRINT:idle:AVERAGE:\"%4.2lf %S avg\" " ;
  $def[1] .= "GPRINT:idle:MAX:\"%4.2lf %S max\\n\" ";
  break;

case "Memory":
  $opt[1] = " --vertical-label \"Memory (GB)\" -l 0 --title \"Memory usage for $hostname\" ";
  $def[1] = "DEF:total=$RRDFILE[1]:$DS[1]:AVERAGE " ;
  $def[1] .= "DEF:available=$RRDFILE[1]:$DS[2]:AVERAGE " ;
  $def[1] .= "DEF:buffer=$RRDFILE[1]:$DS[3]:AVERAGE " ;
  $def[1] .= "DEF:cached=$RRDFILE[1]:$DS[4]:AVERAGE " ;
  $def[1] .= "DEF:shared=$RRDFILE[1]:$DS[5]:AVERAGE " ;

  $def[1] .= "CDEF:gtotal=total,1024,/,1024,/ " ;
  $def[1] .= "CDEF:gavailable=available,1024,/,1024,/ " ;
  $def[1] .= "CDEF:gbuffer=buffer,1024,/,1024,/ " ;
  $def[1] .= "CDEF:gcached=cached,1024,/,1024,/ " ;
  $def[1] .= "CDEF:gshared=shared,1024,/,1024,/ " ;

  $def[1] .= "LINE2:gtotal#ff0000:\"Total \" " ;
  $def[1] .= "GPRINT:gtotal:LAST:\"%4.2lf %S last\" " ;
  $def[1] .= "GPRINT:gtotal:AVERAGE:\"%4.2lf %S avg\" " ;
  $def[1] .= "GPRINT:gtotal:MAX:\"%4.2lf %S max\\n\" ";

  $def[1] .= "LINE2:gavailable#00ea00:\"Available   \" " ;
  $def[1] .= "GPRINT:gavailable:LAST:\"%4.2lf %S last\" " ;
  $def[1] .= "GPRINT:gavailable:AVERAGE:\"%4.2lf %S avg\" " ;
  $def[1] .= "GPRINT:gavailable:MAX:\"%4.2lf %S max\\n\" ";

  $def[1] .= "LINE2:gbuffer#eeee00:\"Buffer   \" " ;
  $def[1] .= "GPRINT:gbuffer:LAST:\"%4.2lf %S last\" " ;
  $def[1] .= "GPRINT:gbuffer:AVERAGE:\"%4.2lf %S avg\" " ;
  $def[1] .= "GPRINT:gbuffer:MAX:\"%4.2lf %S max\\n\" ";

  $def[1] .= "LINE2:gcached#FFB266:\"Cached   \" " ;
  $def[1] .= "GPRINT:gcached:LAST:\"%4.2lf %S last\" " ;
  $def[1] .= "GPRINT:gcached:AVERAGE:\"%4.2lf %S avg\" " ;
  $def[1] .= "GPRINT:gcached:MAX:\"%4.2lf %S max\\n\" ";

  $def[1] .= "LINE2:gshared#994C00:\"Shared   \" " ;
  $def[1] .= "GPRINT:gshared:LAST:\"%4.2lf %S last\" " ;
  $def[1] .= "GPRINT:gshared:AVERAGE:\"%4.2lf %S avg\" " ;
  $def[1] .= "GPRINT:gshared:MAX:\"%4.2lf %S max\\n\" ";
  break;

}

$def[1] .= rrd::comment("Custom SNMP Template by KM Consulting\\r");

?>
