
<?php
    $mobile_number = $_POST['mobile_no'];
    $miti = $_POST['miti'];
    $prgrm_name = $_POST['prgrm_name'];
    $name = $_POST['name'];
    $diff = $_POST['diff'];
  
        $token = 'YCqXA7za1JqQDAOj1470EZsdomWHecGkOJkE';
        $to = $mobile_number;
        $sender    = '9851117526';
        $message = 'श्री ' .$name.'ले मिति ' .$miti. 'मा यस तारकेश्वर नगरपालिका सँग सम्झौता गर्नु भएको योजना ' .$prgrm_name. 'को म्याद सकिएको ' .$diff. 'दिन भैसकेको र म्याद थप गर्न आउनु हुनको लागि अनुरोध छ !! ' ;
      
        $content =[
            'token'=>rawurlencode($token),
            'to'=>rawurlencode($to),
            'sender'=>rawurlencode($sender),
            'message'=>rawurldecode($message),
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"http://beta.thesmscentral.com/api/v3/sms?");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$content);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec ($ch);
        curl_close ($ch);
     
        print_r($server_output);
?>