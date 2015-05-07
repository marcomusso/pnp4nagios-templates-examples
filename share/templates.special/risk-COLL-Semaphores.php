<?php
#
#
#
$this->MACRO['TITLE']   = "Risk Semaphores"; 
$this->MACRO['COMMENT'] = "Risk Semaphores Arrays for all COLL DRM Nodes";
#
# Get a List of Services by regex 
# Option 1 = 'Host Regex'
# Option 2 = 'Service Regex'
#
$services = $this->tplGetServices("risk.u..1[01][34567890]","Semaphores");
#$services = $this->tplGetServices("risk.d..1*","Semaphores");
#
# The Datasource Name for Graph 0
$ds_name[0] = "# Semaphores Arrays"; 
$opt[0]     = "--title \"Stacked Semaphores Arrays\"";
$def[0]     = "";
#
# Iterate through the list of hosts

foreach($services as $key=>$val){
    #
    # get the data for a given Host/Service
    $a = $this->tplGetData($val['host'],$val['service']);
    #
    # Throw an exception to debug the content of $a
    # Just to get Infos about the Array Structure
    #
    #throw new Kohana_exception(print_r($a,TRUE));
    $def[0]    .= rrd::def("a$key" ,$a['DS'][0]['RRDFILE'], $a['DS'][0]['DS'], "AVERAGE");
    #$def[0]    .= rrd::def("b$key" ,$a['DS'][1]['RRDFILE'], $a['DS'][1]['DS'], "AVERAGE");
    $def[0]    .= rrd::area("a$key", rrd::color($key), $a['MACRO']['HOSTNAME'], "STACK");
    $def[0]    .= rrd::gprint("a$key", array("MIN", "MAX", "LAST"), "%.2lf%s");
    #$def[0]    .= rrd::gprint("b$key", array("MIN", "MAX", "LAST"), "%.2lf%s");
}
?>
