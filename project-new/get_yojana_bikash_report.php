<?php
    require_once("includes/initialize.php");

    $max_ward = Plandetails1::find_max_ward_no();
    $colors= array("193,66,66","191, 127, 63","191, 191, 63","127, 191, 63","63, 191, 63","63, 191, 127","63, 191, 191","63, 127, 191","127, 63, 191","63, 63, 191");
    $topic_area=  Topicarea::find_all();
   // $topics =array("पूर्वाधार","आर्थिक","सामाजिक","वातावरण","संस्थागत","वित्तीय व्यवस्थापन","चालु खर्च","सामाजिक भत्ता","अन्य आनुदान");
    $topic_area_id="";
    $fiscal_id= Fiscalyear::find_current_id();
    $_POST['ward']=0;
    $counted_result = getOnlyRegisteredPlans($_POST['ward_no']);
    $format         = 1;
    $type           = 0;
//    print_r($topic_area); exit;
       $res = array();
       $i = 0;
 foreach($topic_area as $topic)
 {
   // $topic_area_type_ids =  Topicareatype::find_by_topic_area_id($topic->id);
    $current_id = Fiscalyear::find_current_id();
    $count = Plandetails1::count_by_topic_area($topic->id,'',"");
    $res[$i]['count'] = $count;
    $res[$i]['topic'] = $topic->name;
    $res[$i]['color'] = $colors[$i];
    $i++;
    
 }
 echo json_encode($res);exit;
?>

