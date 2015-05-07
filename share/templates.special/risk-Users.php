<?php
#
#
#
$this->MACRO['TITLE']   = "Risk Users"; 
$this->MACRO['COMMENT'] = "Risk Users for all Linux PROD DRM Nodes";
#
# Get a List of Services by regex 
# Option 1 = 'Host Regex'
# Option 2 = 'Service Regex'
#
$services = $this->tplGetServices("risklp.*","Users");
#
# The Datasource Name for Graph 0
$ds_name[0] = "# Users"; 
$opt[0]     = "--title \"Stacked Users\"";
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
    $def[0]    .= rrd::area("a$key", rrd::color($key), $a['MACRO']['HOSTNAME'], "STACK");
    $def[0]    .= rrd::gprint("a$key", array("MIN", "MAX", "LAST"), "%.2lf%s");
}
?>
