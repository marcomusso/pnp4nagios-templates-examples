<?php
#
#
#

$colors=array("CC3300","CC3333","CC3366","CC3399","CC33CC","CC33FF","336600","336633","336666","336699","3366CC","3366FF","33CC33","33CC66","609978","922A99","997D6D","174099","1E9920","E88854","AFC5E8","57FA44","FA6FF6","008080","D77038","272B26","70E0D9","0A19EB","E5E29D","930526","26FF4A","ABC2FF","E2A3FF","808000","000000","00FAFA","E5FA79","F8A6FF","FF36CA","B8FFE7","CD36FF", "CC3300","CC3333","CC3366","CC3399","CC33CC","CC33FF","336600","336633","336666","336699","3366CC","3366FF","33CC33","33CC66","609978","922A99","997D6D","174099","1E9920","E88854","AFC5E8","57FA44","FA6FF6","008080","D77038","272B26","70E0D9","0A19EB","E5E29D","930526","26FF4A","ABC2FF","E2A3FF","808000","000000","00FAFA","E5FA79","F8A6FF");
$defcnt = 1;
# Max number of workers per host, see config /usr/local/etc/mod_gearman_worker.conf
$worker24=20;
$worker04=40;
$worker26=40;
$worker27=40;
$worker28=40;
$max_workers=$worker24+$worker04+$worker26+$worker27+$worker28;

#foreach ($DS as $i) {
foreach (array(1, 2) as $i) {

    if(preg_match('/worker/', $NAME[$i])) {
        $ds_name[$defcnt] = "Total number of workers";
        $opt[$defcnt] = "--vertical-label \"# di worker\" -W \"KM Consulting\" --title \"Worker attivi\" ";
        $def[$defcnt] = "";
        $def[$defcnt] .= "DEF:worker24_workers=/usr/local/pnp4nagios/var/perfdata/worker24/Worker_worker24.rrd:$DS[$i]:AVERAGE " ;
        $def[$defcnt] .= "DEF:worker26_workers=/usr/local/pnp4nagios/var/perfdata/worker24/Worker_worker26.rrd:$DS[$i]:AVERAGE " ;
        $def[$defcnt] .= "DEF:worker27_workers=/usr/local/pnp4nagios/var/perfdata/worker24/Worker_worker27.rrd:$DS[$i]:AVERAGE " ;
        $def[$defcnt] .= "DEF:worker28_workers=/usr/local/pnp4nagios/var/perfdata/worker24/Worker_worker28.rrd:$DS[$i]:AVERAGE " ;
        $def[$defcnt] .= "DEF:worker04_workers=/usr/local/pnp4nagios/var/perfdata/worker24/Worker_worker04.rrd:$DS[$i]:AVERAGE " ;

	$def[$defcnt] .= "CDEF:TotalWorkers=worker24_workers,worker26_workers,+,worker27_workers,+,worker28_workers,+,worker04_workers,+ " ;

        $def[$defcnt] .= "GPRINT:TotalWorkers:LAST:\"Ultimo valore\: %4.0lf %S \" ";
        $def[$defcnt] .= "GPRINT:TotalWorkers:MAX:\" Massimo\: %4.0lf %S \" ";
        $def[$defcnt] .= "GPRINT:TotalWorkers:AVERAGE:\"Media\: %4.0lf %S \\n\" ";
        if($CRIT[$defcnt] != ""){
          $def[$defcnt] .= rrd::hrule($CRIT[$defcnt], "#FF0000", "Critico\: ".$CRIT[$defcnt].$UNIT[$defcnt]." worker\\n");
        }
	# riga al numero massimo di slot disponibili
        $def[$defcnt] .= "HRULE:".$max_workers."#ff0000:\"Numero massimo di worker configurati\: ".$worker24."+".$worker26."+".$worker27."+".$worker28."+".$worker04."=".$max_workers." \\n\" ";

	$def[$defcnt] .= "AREA:worker24_workers#".$colors[10].":\" worker24_workers \":STACK ";
	$def[$defcnt] .= "AREA:worker26_workers#".$colors[20].":\" worker26_workers \":STACK ";
	$def[$defcnt] .= "AREA:worker27_workers#".$colors[30].":\" worker27_workers \":STACK ";
	$def[$defcnt] .= "AREA:worker28_workers#".$colors[40].":\" worker28_workers \":STACK ";
	$def[$defcnt] .= "AREA:worker04_workers#".$colors[50].":\" worker04_workers \":STACK ";

        $defcnt++;
    }

    if(preg_match('/jobs/', $NAME[$i])) {
        $ds_name[$defcnt] = "Job serviti";
        $opt[$defcnt] = "--vertical-label \"# di job\" --title \"Job serviti\" ";
        $def[$defcnt] = "";
        $def[$defcnt] .= "DEF:worker24_jobs=/usr/local/pnp4nagios/var/perfdata/worker24/Worker_worker24.rrd:$DS[$i]:AVERAGE " ;
        $def[$defcnt] .= "DEF:worker26_jobs=/usr/local/pnp4nagios/var/perfdata/worker24/Worker_worker26.rrd:$DS[$i]:AVERAGE " ;
        $def[$defcnt] .= "DEF:worker27_jobs=/usr/local/pnp4nagios/var/perfdata/worker24/Worker_worker27.rrd:$DS[$i]:AVERAGE " ;
        $def[$defcnt] .= "DEF:worker28_jobs=/usr/local/pnp4nagios/var/perfdata/worker24/Worker_worker28.rrd:$DS[$i]:AVERAGE " ;
        $def[$defcnt] .= "DEF:worker04_jobs=/usr/local/pnp4nagios/var/perfdata/worker24/Worker_worker04.rrd:$DS[$i]:AVERAGE " ;

	$def[$defcnt] .= "CDEF:TotalJobs=worker24_jobs,worker26_jobs,+,worker27_jobs,+,worker28_jobs,+,worker04_jobs,+ " ;

        $def[$defcnt] .= "GPRINT:TotalJobs:LAST:\"Ultimo valore\: %4.0lf %S \" ";
        $def[$defcnt] .= "GPRINT:TotalJobs:MAX:\" Massimo\: %4.0lf %S \" ";
        $def[$defcnt] .= "GPRINT:TotalJobs:AVERAGE:\"Media\: %4.0lf %S \\n\" ";
        #if($CRIT[$defcnt] != ""){
        #  $def[$defcnt] .= rrd::hrule($CRIT[$defcnt], "#FF0000", "Critico\: ".$CRIT[$defcnt].$UNIT[$defcnt]." job\\n");
        #}

	$def[$defcnt] .= "AREA:worker24_jobs#".$colors[10].":\" worker24_jobs \":STACK ";
	$def[$defcnt] .= "AREA:worker26_jobs#".$colors[20].":\" worker26_jobs \":STACK ";
	$def[$defcnt] .= "AREA:worker27_jobs#".$colors[30].":\" worker27_jobs \":STACK ";
	$def[$defcnt] .= "AREA:worker28_jobs#".$colors[40].":\" worker28_jobs \":STACK ";
	$def[$defcnt] .= "AREA:worker04_jobs#".$colors[50].":\" worker04_jobs \":STACK ";

        $defcnt++;
    }
}

