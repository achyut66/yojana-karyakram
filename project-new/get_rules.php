<?php
$res=array();
$output =' <div class="remove_rules_details"><textarea name="rule[]" placeholder="सर्त हाल्नुहोस "></textarea></div> <div class="myspacer"></div>';
$res['html'] = $output;
echo json_encode($res);exit;