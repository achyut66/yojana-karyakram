<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$data0= Enlist::find_by_type(0);
$data1= Enlist::find_by_type(1);
$data2= Enlist::find_by_type(2);
$data3= Enlist::find_by_type(3);
$data4=  Enlist::find_by_type(4);
$data5= Costumerassociationdetails0::find_all();
//print_r($enlist);exit;
	?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>सूची दर्ता विवरण  :: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	
                <div class="maincontent">
                    <h2 class="headinguserprofile">सूची दर्ता विवरण | <a href="settings_enlist.php" class="btn">सूची दर्ता  थप्नुहोस  +</a> | <a href="program_settings.php" class="btn">पछि जानुहोस</a></h2>
                    
                    <div class="OurContentFull">
                    	
                        <div class="userprofiletable">
                        	<div class="myMessage"><?php echo $message;?></div>
                                    <div class="inputWrap">
                                    	<h1>सूची दर्ता विवरण</h1>
                                        <div class="titleInput">संचालन गर्ने:</div>
                                        <div class="newInput"><select name="type" class="showhide">
                                               <option value="">छान्नुहोस्</option>
                                               <option value="0">फर्म/कम्पनी</option>
                                               <option value="1">कर्मचारी</option>
                                               <option value="2">संस्था</option>
                                               <option value="3">पदाधिकारी</option>
                                                <option value="4">अन्य समूह </option>
                                                <option value="5">उपभोक्ता समिति</option>
                                           </select></div>
                                        <div class="myspacer"></div>
                                    </div><!-- input wrap ends -->	
                                     <table id="company" class="table table-bordered table-hover" style="display: none">
                                           <tr>
                                           <td class="myCenter"><strong>फर्म/कम्पनीका नाम</strong></td>
                                            <td class="myCenter"><strong>ठेगाना</strong></td>
                                            <td class="myCenter"><strong>सम्पर्क नं</strong></td>
                                            <td class="myCenter"><strong>सच्याउनुहोस् </strong></td>
                                          </tr>
                                                      
                                          <?php foreach ($data0 as $data): 
                                               
                                              ?>
                                              <tr>
                                                <td class="myCenter"><?php echo $data->name0; ?></td>
                                                  <td class="myCenter"><?php echo $data->address0; ?></td>
                                                  <td class="myCenter"><?php echo $data->number0; ?></td>
                                                  <form method="post" action="enlist_firm_delete.php">
                                                <td class="myCenter">
                                                    <a href="settings_enlist.php?id=<?php echo $data->id; ?>" class="btn">सच्याउनुहोस्</a>
                                                    <span><button class="button btn-danger">हटाउनुहोस</button></span>
                                                    <input type="hidden" name="id" value="<?=$data->id?>">
                                                </td>
                                                  </form>
                                              </tr>
                                        
                                          <?php endforeach; ?>
                                        </table>
                                    <table id="staff" class="table table-bordered table-hover" style="display: none">
                                           <td class="myCenter"><strong>कर्मचारीका नाम</strong></td>
                                            <td class="myCenter"><strong>पद</strong></td>
                                            <td class="myCenter"><strong>कार्यरत शाखा</strong></td>
                                            <td class="myCenter"><strong>ठेगाना</strong></td>
                                            <td class="myCenter"><strong>सम्पर्क नं</strong></td>
                                            <td class="myCenter"><strong>सच्याउनुहोस्</strong> </td>
                                          </tr>
                                                      
                                          <?php foreach ($data1 as $data): 
//                                               print_r($data);
                                              ?>
                                              <tr>
                                                <td class="myCenter"><?php echo $data->name1; ?></td>
                                                  <td class="myCenter"><?php echo $data->post1; ?></td>
                                                  <td class="myCenter"><?php echo $data->branch1; ?></td>
                                                   <td class="myCenter"><?php echo $data->address1; ?></td>
                                                   <td class="myCenter"><?php echo $data->number1; ?></td>
                                                  <form method="post" action="enlist_karmachari_delete.php">
                                                <td class="myCenter">
                                                    <a href="settings_enlist.php?id=<?php echo $data->id; ?>" class="btn">सच्याउनुहोस्</a>
                                                    <span><button class="button btn-danger">हटाउनुहोस</button></span>
                                                    <input type="hidden" name="id" value="<?=$data->id?>">
                                                </td>
                                                  </form>
                                              </tr>
                                        
                                          <?php endforeach; ?>
                                        </table>
                                     
                                       <table id="group" class="table table-bordered table-hover" style="display: none">
                                           <td class="myCenter"><strong>संस्थाका नाम</strong></td>
                                            <td class="myCenter"><strong>ठेगाना</strong></td>
                                            <td class="myCenter"><strong>सम्पर्क नं</strong></td>
                                            <td class="myCenter"><strong>सच्याउनुहोस् </strong></td>
                                          </tr>
                                                      
                                          <?php foreach ($data2 as $data): 
                                               
                                              ?>
                                              <tr>
                                                <td class="myCenter"><?php echo $data->name2; ?></td>
                                                  <td class="myCenter"><?php echo $data->address2; ?></td>
                                                  <td class="myCenter"><?php echo $data->number2; ?></td>
                                                <td class="myCenter"><a href="settings_enlist.php?id=<?php echo $data->id; ?>" class="btn">सच्याउनुहोस्</a></td>
                                              </tr>
                                        
                                          <?php endforeach; ?>
                                        </table>
                                        <table id="working-field" class="table table-bordered table-hover" style="display: none">
                                           <td class="myCenter"><strong>कर्मचारीका नाम</strong></td>
                                            <td class="myCenter"><strong>पद</strong></td>
                                            <td class="myCenter"><strong>ठेगाना</strong></td>
                                            <td class="myCenter"><strong>सम्पर्क नं</strong></td>
                                            <td class="myCenter"><strong>सच्याउनुहोस् </strong></td>
                                          </tr>
                                                      
                                          <?php foreach ($data3 as $data): 
                                               
                                              ?>
                                              <tr>
                                                <td class="myCenter"><?php echo $data->name3; ?></td>
                                                <td class="myCenter"><?php echo $data->post3;?></td>
                                                  <td class="myCenter"><?php echo $data->address3; ?></td>
                                                  <td class="myCenter"><?php echo $data->number3; ?></td>
                                                <td class="myCenter"><a href="settings_enlist.php?id=<?php echo $data->id; ?>" class="btn">सच्याउनुहोस्</a></td>
                                              </tr>
                                        
                                          <?php endforeach; ?>
                                        </table>
                                     <table id="other-field" class="table table-bordered table-hover" style="display: none">
                                           <td class="myCenter"><strong>नाम</strong></td>
                                            <td class="myCenter"><strong>ठेगाना</strong></td>
                                            <td class="myCenter"><strong>सम्पर्क नं</strong></td>
                                            <td class="myCenter"><strong>सच्याउनुहोस् </strong></td>
                                          </tr>
                                                      
                                          <?php foreach ($data4 as $data): 
                                               
                                              ?>
                                              <tr>
                                                <td class="myCenter"><?php echo $data->name4; ?></td>
                                                <td class="myCenter"><?php echo $data->address4; ?></td>
                                                  <td class="myCenter"><?php echo $data->number4; ?></td>
                                                <td class="myCenter">
                                                    <a href="settings_enlist.php?id=<?php echo $data->id; ?>" class="btn">सच्याउनुहोस्</a>
                                                    <span><button class="button btn-danger">हटाउनुहोस</button></span>
                                                </td>
                                              </tr>
                                        
                                          <?php endforeach; ?>
                                        </table>
                                        <table id="upabhokta-field" class="table table-bordered table-hover" style="display: none">
                                        <tr>
                                             <td class="myCenter"><strong>नाम</strong></td>
                                            <td class="myCenter"><strong>वडा नं</strong></td>
                                            
                                         </tr>
                                                      
                                          <?php foreach ($data5 as $data): 
                                               
                                              ?>
                                              <tr>
                                                <td class="myCenter"><?php echo $data->program_organizer_group_name; ?></td>
                                                <td class="myCenter"><?php echo convertedcit($data->program_organizer_group_address) ?></td>
                                               
                                            </tr>
                                        
                                          <?php endforeach; ?>
                                        </table>

                        </div>
                  </div>
                </div><!-- main menu ends -->
          
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>
