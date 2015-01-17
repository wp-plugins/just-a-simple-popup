<?php
/*
Plugin Name: just a simple popup
Author: Ankit Chauhan
Author URI: https://profiles.wordpress.org/ankitinaugurate/
Version:2.0.1
Description: The plugin allows you to show the pop up on any page by setting up the values in the admin panel after activating the plugin. User can add multiple pop ups. Also User can change the background,fade In time, opacity, content of the pop in the Admin panel. User can also add shortcode to the content of this popup.
*/

include('listPopups.php');  // To show pop ups as list

//// ADD NEW POPUP . This function will be called when user adds a new pop up

function justAsimplePopup_add_new_popup()
	{
		global $wpdb;
		$popupupdated='';
		if(isset($_REQUEST['saveJustapopup']))   // This condition will be true when Submits the add new pop up form 
			{
				$name=$_REQUEST['popname'];
				$color=$_REQUEST['background'];
				$fadetime=$_REQUEST['fadetime'];
				$pageids=','.$_REQUEST['pageids'].',';
				$home=$_REQUEST['onhome'][0];
				$popuodescription=$_REQUEST['popupcontent'];
				$opacity=$_REQUEST['opacity'];
				$width=$_REQUEST['width'];
				$clickbuttons=$_REQUEST['clickbuttons'];
				$onpageload=$_REQUEST['onpageload'][0];
				$background_repeat=$_REQUEST['background-repeat'][0];
				$background_size=$_REQUEST['background-size'];
				
				global $user_ID;
				$new_post = array(
				'post_title' => $name,
				'post_content' => $popuodescription,
				'post_status' => 'publish',
				'post_date' => date('Y-m-d H:i:s'),
				'post_author' => $user_ID,
				'post_type' => 'just_a_simple_popup',				
				);
				$post_id = wp_insert_post($new_post);
				
				$currTime=time();
				if($_FILES['background-image'])
					{
						$target_dir = '../wp-content/plugins/just-a-simple-popup/popup-backgrounds/';
						$target_file = $target_dir .$currTime. basename($_FILES["background-image"]["name"]);
						$uploadOk = 1;
						$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
						
						// Allow certain file formats
						if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"  && $imageFileType != "gif" ) 
							{
								$popupupdated.= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
								$uploadOk = 0;
							}
						// Check if $uploadOk is set to 0 by an error
						if($uploadOk!= 0) 
							{
								if (move_uploaded_file($_FILES["background-image"]["tmp_name"], $target_file)) 
									{
										$popupupdated.= "The file ".$currTime. basename( $_FILES["background-image"]["name"]). " has been uploaded.<br>";
										add_post_meta($post_id,'background_image',$currTime. basename($_FILES["background-image"]["name"]));
									} 
								else 
									{
										$popupupdated.= "Sorry, there was an error uploading your file.<br>";
									}
							}										
					}
				$popup = array(
					  'ID'           => $popupId,
					  'post_content' => $popuodescription,
					  'post_title' => $name,
				  );
				
				add_post_meta($post_id, 'color', $color);
				add_post_meta($post_id, 'fadetime', $fadetime);
				add_post_meta($post_id, 'pageids', $pageids);
				add_post_meta($post_id, 'home', $home);
				add_post_meta($post_id, 'opacity', $opacity);
				add_post_meta($post_id, 'width', $width);
				add_post_meta($post_id, 'clickbuttons', $clickbuttons);
				add_post_meta($post_id, 'onpageload', $onpageload);
				add_post_meta($post_id, 'background-repeat', $background_repeat);
				add_post_meta($post_id,'background-size',$background_size);
				$popupupdated='Pop up successfully added.';
			}
					
		echo '<script src="'.plugins_url().'/just-a-simple-popup/js/jscolor.js"></script><div id="justAsimplePopuppAdmin">
				<link href="'.plugins_url().'/just-a-simple-popup/css/style-admin.css" rel="stylesheet">		
				</link>
				<div id="justAsimplePopuppAdminWrapper">
					<div id="justAsimplePopuppAdminContent">
						<h2>Add Simple Popup :  <a href="http://www.opieproductions.com/just-a-simple-popup-demo">Check Pro version here</a></h2>
						<h4>'.$popupupdated.'</h4>
						<div id="justAsimplePopuppAdminForm">
									
							<form action="" method="post" enctype="multipart/form-data">
								<div class="justAsimplePopuppAdminFormRow">
									<label for="name">Name : </label>
									<input type="text" name="popname" id="name" class="name" value="" required="required" />								
								</div>
								<div class="justAsimplePopuppAdminFormRow">
									<label for="background">Background-color : </label>
									<input type="text" name="background" id="background" class="color" value="" readonly="readonly"/>								
								</div>
								<div class="justAsimplePopuppAdminFormRow">
									<label for="background-image">Background-image : </label>
									<input type="file" name="background-image" id="background-image" class="background-image" value="" />								
								</div>
								<div class="justAsimplePopuppAdminFormRow">
									<label for="background-size">Background-size in % : </label>
									<input type="number" name="background-size" id="background-size" min="1" max="100" class="background-size" value="" />								
								</div>
								<div class="justAsimplePopuppAdminFormRow">
									<label for="background-repeat">Background-repeat : </label>
									<input type="radio" name="background-repeat[]" id="background-repeat" value="1" >
										Yes	
									<input type="radio" name="background-repeat[]" id="background-repeat" value="0">
										No									
								</div>
								<div class="justAsimplePopuppAdminFormRow">
									<label for="opacity">Background-transparency : </label>
									<input type="text" name="opacity" id="opacity"  value="" />								
								</div>
								<div class="justAsimplePopuppAdminFormRow">
									<label for="fadeintime">FadeIn Time : </label>
									<input type="text" name="fadetime" id="fadeintime" value="" /> (Please enter FadeIn time.)								
								</div>
								<div class="justAsimplePopuppAdminFormRow">
									<label for="pageids">Show on Pages : </label>
									<input type="text" name="pageids" id="pageids" value="" /> (Please enter page IDs seperated by commas(,) on which the popup will be displayed.)								
								</div>
								<div class="justAsimplePopuppAdminFormRow">
									<label for="width">Popup Width(in %) : </label>
									<input type="text" name="width" id="width" value="" />								
								</div>
								<div class="justAsimplePopuppAdminFormRow">
									<label for="clickbuttons">Enter HTML Element Id/class : </label>
									<input type="text" name="clickbuttons" id="clickbuttons" value="" /> (Seperate the Ids/Class by comma and include # for id and . for class by clicking on which the popup will appear)							
								</div>
								<div class="justAsimplePopuppAdminFormRow">
									<label for="onhome">Show on Home Page : </label>
									<input type="radio" name="onhome[]" id="onhome" value="1" ';
									if($home==1)
										echo ' checked="checked"';
									echo '/>	Yes	
									<input type="radio" name="onhome[]" id="onhome" value="0"';
									if($home==0)
										echo ' checked="checked"';
									echo '/>	No							
								</div>
								<div class="justAsimplePopuppAdminFormRow" style="margin-bottom:30px;">
									<label for="onpageload">Show on Page Load : </label>
									<input type="radio" name="onpageload[]" id="onpageload" value="1" ';
									if($onpageload==1)
										echo ' checked="checked"';
									echo '/>	Yes	
									<input type="radio" name="onpageload[]" id="onpageload" value="0"';
									if($onpageload==0)
										echo ' checked="checked"';
									echo '/>	No							
								</div>';
								
								wp_editor( '', 'testabcd', $settings = array('textarea_name'=>'popupcontent','media_buttons'=>true) );
								echo '
								<div class="justAsimplePopuppAdminFormRow">
									<input type="submit" name="saveJustapopup" id="saveJustapopup" value="Add"/>								
								</div>
							</form>
						</div>
					</div>
				</div>				
			  </div>';
	}


/// SETTING THE POP-UP IN ADMIN PANEL ////////


function justAsimplePopup_admin() 
	{
		global $wpdb;
		$popupupdated='';
		$action=isset($_REQUEST['action'])?$_REQUEST['action']:'';
		$popupId=isset($_REQUEST['popupid'])?$_REQUEST['popupid']:'';
		if($action!='' && $popupId!='')
			{
				if($action=='edit')
					{
						if(isset($_REQUEST['saveJustapopup']))
							{
								$name=$_REQUEST['popname'];
								$width=$_REQUEST['width'];
								$color=$_REQUEST['background'];
								$fadetime=$_REQUEST['fadetime'];
								$pageids=','.$_REQUEST['pageids'].',';
								$home=$_REQUEST['onhome'][0];
								$popuodescription=$_REQUEST['popupcontent'];
								$opacity=$_REQUEST['opacity'];
								$clickbuttons=$_REQUEST['clickbuttons'];
								$onpageload=$_REQUEST['onpageload'][0];
								$background_repeat=$_REQUEST['background-repeat'][0];
								$background_size=$_REQUEST['background-size'];
								
								
								$currTime=time();
								if($_FILES['background-image'])
									{
										$target_dir = '../wp-content/plugins/just-a-simple-popup/popup-backgrounds/';
										$target_file = $target_dir .$currTime. basename($_FILES["background-image"]["name"]);
										$uploadOk = 1;
										$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
										
										// Allow certain file formats
										if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"  && $imageFileType != "gif" ) 
											{
												$popupupdated.= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
												$uploadOk = 0;
											}
										// Check if $uploadOk is set to 0 by an error
										if($uploadOk!= 0) 
											{
												if (move_uploaded_file($_FILES["background-image"]["tmp_name"], $target_file)) 
													{
														$popupupdated.= "The file ".$currTime. basename( $_FILES["background-image"]["name"]). " has been uploaded.<br>";
														update_post_meta($popupId,'background_image',$currTime. basename($_FILES["background-image"]["name"]));
													} 
												else 
													{
														$popupupdated.= "Sorry, there was an error uploading your file.<br>";
													}
											}										
									}
								$popup = array(
									  'ID'           => $popupId,
									  'post_content' => $popuodescription,
									  'post_title' => $name,
								  );
								
								// Update the post into the database
								wp_update_post( $popup );
								
								update_post_meta($popupId,'color',$color);
								update_post_meta($popupId,'pageids',$pageids);
								update_post_meta($popupId,'fadetime',$fadetime);
								update_post_meta($popupId,'home',$home);
								update_post_meta($popupId,'width',$width);
								update_post_meta($popupId,'opacity',$opacity);
								update_post_meta($popupId,'clickbuttons',$clickbuttons);
								update_post_meta($popupId,'onpageload',$onpageload);
								update_post_meta($popupId,'background-repeat',$background_repeat);
								update_post_meta($popupId,'background-size',$background_size);
								//update_post_meta($popupId,'background-size',$background_size);
							
								
								//$wpdb->update($wpdb->prefix .'justAsimplePopup',array('color'=>$color,'fadetime'=>$fadetime,'pages'=>$pageids,'home'=>$home,'opacity'=>$opacity,'content'=>$popuodescription,'name'=>$name,'width'=>$width,'clickbuttons'=>$clickbuttons),array('id'=>$popupId));
								$popupupdated.="Setting have been successfully saved.";
							}
						//$getdata=$wpdb->get_row("SELECT * from ".$wpdb->prefix ."justAsimplePopup WHERE id=".$popupId);
						
						$args = array('p' => $popupId,'post_type'=>'just_a_simple_popup');
						query_posts($args); 
						if(have_posts())
							{
								while(have_posts())
									{
										the_post();		
										$color=get_post_meta(get_the_ID(),'color');
										$pa=get_post_meta(get_the_ID(),'pageids');
										$fadetime=get_post_meta(get_the_ID(),'fadetime');								
										$home=get_post_meta(get_the_ID(),'home');								
										$width=get_post_meta(get_the_ID(),'width');
										$curr_ID=get_the_ID();
										$opa=get_post_meta(get_the_ID(),'opacity');								
										$clickbuttons=get_post_meta(get_the_ID(),'clickbuttons');
										$onpageload=get_post_meta(get_the_ID(),'onpageload');
										$onpageload=get_post_meta(get_the_ID(),'onpageload');
										$editbackgroundrepeat=get_post_meta(get_the_ID(),'background-repeat');
										$editbackgroundimage=get_post_meta(get_the_ID(),'background_image');
										$editbackgroundsize=get_post_meta(get_the_ID(),'background-size');
										
										
										$editname=get_the_title();
										$editcolor=$color[0];
										$editfadetime=$fadetime[0];
										$editpages=$pa[0];
										$edithome=$home[0];
										$editpopupdesc=get_the_content();
										$editwidth=$width[0];
										$editopacity=$opa[0];
										$editclickbuttons=$clickbuttons[0];	
										$editonpageload=$onpageload[0];									
										
									}
							}
						
						
						echo '<script src="'.plugins_url().'/just-a-simple-popup/js/jscolor.js"></script><div id="justAsimplePopuppAdmin">
						<script src="'.plugins_url().'/just-a-simple-popup/js/script.js"></script><div id="justAsimplePopuppAdmin">
						<link href="'.plugins_url().'/just-a-simple-popup/css/style-admin.css" rel="stylesheet">		
						</link>
						<div id="justAsimplePopuppAdminWrapper">
							<div id="justAsimplePopuppAdminContent">
								<h2>Just A Simple Popup Settings:   <a href="http://www.opieproductions.com/just-a-simple-popup-demo">Check Pro version here</a></h2>
								<h4>'.$popupupdated.'</h4>
								<div id="justAsimplePopuppAdminForm">
											
									<form action="" method="post" enctype="multipart/form-data">
										<div class="justAsimplePopuppAdminFormRow">
											<label for="name">Name : </label>
											<input type="text" name="popname" id="name" class="name" value="'.$editname.'" required="required" />								
										</div>
										<div class="justAsimplePopuppAdminFormRow">
											<label for="background">Background-color : </label>
											<input type="text" name="background" id="background" class="color" value="'.$editcolor.'" readonly="readonly"/>								
										</div>
										<div class="justAsimplePopuppAdminFormRow">
											<label for="background-image">Background-image : </label>
											<input type="file" name="background-image" id="background-image" class="background-image" value="" />								
										</div>';
										if($editbackgroundimage[0]!='')
											{
												echo '<div class="justAsimplePopuppAdminFormRow">
														<label for="">&nbsp;</label>
														<img src="'.plugins_url()."/just-a-simple-popup/popup-backgrounds/".$editbackgroundimage[0].'"  width="100"/>
														<a href="javascript:void(0);" id="removePopupImage" data="'.$popupId.'">Remove Image</a>							
													</div>';
											}											
										echo '
										
										<div class="justAsimplePopuppAdminFormRow">
											<label for="background-size">Background-size in % : </label>
											<input type="number" name="background-size" id="background-size" min="1" max="100" class="background-size" value="'.$editbackgroundsize[0].'" />								
										</div>
										<div class="justAsimplePopuppAdminFormRow">
											<label for="background-repeat">Background-repeat : </label>
											<input type="radio" name="background-repeat[]" id="background-repeat" value="1" ';
											if($editbackgroundrepeat[0]==1)
												echo ' checked="checked"';
											echo '/>	Yes	
											<input type="radio" name="background-repeat[]" id="background-repeat" value="0"';
											if($editbackgroundrepeat[0]==0)
												echo ' checked="checked"';
											echo '/>	No									
										</div>
										<div class="justAsimplePopuppAdminFormRow">
											<label for="opacity">Background-transparency : </label>
											<input type="text" name="opacity" id="opacity"  value="'.$editopacity.'" />								
										</div>
										<div class="justAsimplePopuppAdminFormRow">
											<label for="fadeintime">FadeIn Time : </label>
											<input type="text" name="fadetime" id="fadeintime" value="'.$editfadetime.'" /> (Please enter FadeIn time.)								
										</div>
										<div class="justAsimplePopuppAdminFormRow">
											<label for="pageids">Show on Pages : </label>
											<input type="text" name="pageids" id="pageids" value="'.rtrim(ltrim($editpages,','),',').'" /> (Please enter page IDs seperated by commas(,) on which the popup will be displayed.)								
										</div>
										<div class="justAsimplePopuppAdminFormRow">
											<label for="width">Popup Width(in %) : </label>
											<input type="text" name="width" id="width"  value="'.$editwidth.'"  />								
										</div>
										<div class="justAsimplePopuppAdminFormRow">
									<label for="clickbuttons">Enter HTML Element Id/class : </label>
									<input type="text" name="clickbuttons" id="clickbuttons" value="'.$editclickbuttons.'" />  (Seperate the Ids/Class by comma and include # for id and . for class by clicking on which the popup will appear)							
								</div>
										<div class="justAsimplePopuppAdminFormRow">
											<label for="onhome">Show on Home Page : </label>
											<input type="radio" name="onhome[]" id="onhome" value="1" ';
											if($edithome==1)
												echo ' checked="checked"';
											echo '/>	Yes	
											<input type="radio" name="onhome[]" id="onhome" value="0"';
											if($edithome==0)
												echo ' checked="checked"';
											echo '/>	No							
										</div>
										<div class="justAsimplePopuppAdminFormRow" style="margin-bottom:30px;">
											<label for="onpageload">Show on Page Load : </label>
											<input type="radio" name="onpageload[]" id="onpageload" value="1" ';
											if($editonpageload==1)
												echo ' checked="checked"';
											echo '/>	Yes	
											<input type="radio" name="onpageload[]" id="onpageload" value="0"';
											if($editonpageload==0)
												echo ' checked="checked"';
											echo '/>	No							
										</div><br>';
										wp_editor( stripslashes($editpopupdesc), 'testabcd', $settings = array('textarea_name'=>'popupcontent','media_buttons'=>true) );
										echo '
										<div class="justAsimplePopuppAdminFormRow">
											<input type="submit" name="saveJustapopup" id="saveJustapopup" value="Update"/>								
										</div>
									</form>
								</div>
							</div>
						</div>				
					  </div>';
					}
				else if($action=='delete')
					{
						wp_delete_post($popupId);
					?>
					<script>
						location.href='<?php echo site_url(); ?>/wp-admin/admin.php?page=justAsimplePopup';
					</script>
					<?php
					}
			}
		else
			{		
				$popupListTable = new POPUP_LISTS();
				$popupArray=array();
				$countPop=0;
				$args = array('post_type' => 'just_a_simple_popup');
				query_posts($args); 
				if(have_posts())
					{
						while(have_posts())
							{
								the_post();		
								$color=get_post_meta(get_the_ID(),'color');
								$pa=get_post_meta(get_the_ID(),'pageids');
								$fadetime=get_post_meta(get_the_ID(),'fadetime');								
								$home=get_post_meta(get_the_ID(),'home');								
								$width=get_post_meta(get_the_ID(),'width');
								$curr_ID=get_the_ID();
								$opa=get_post_meta(get_the_ID(),'opacity');								
								$clickbuttons=get_post_meta(get_the_ID(),'clickbuttons');
								
								
								$popupArray[$countPop]['ID']=get_the_ID();
								$popupArray[$countPop]['name']=get_the_title();
								$popupArray[$countPop]['color']=$color[0];
								$popupArray[$countPop]['pages']=$pa[0];
								$popupArray[$countPop]['home']=$home[0];
								$popupArray[$countPop]['opacity']=$opa[0];
								$popupArray[$countPop]['fadetime']=$fadetime[0];
								$popupArray[$countPop]['content']=get_the_content;	
								$popupArray[$countPop]['width']=$width[0];	
								$countPop++;
								
							}
						 $popupListTable->prepare_items($popupArray);
						 ?>
                         <div class="wrap"><h2>Simple Popups <a href="<?php echo site_url();?>/wp-admin/admin.php?page=addpopup" class="add-new-h2">Add New</a>  &nbsp;&nbsp;&nbsp;    <a href="http://www.opieproductions.com/just-a-simple-popup-demo">Check Pro version here</a></h2>
                        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
                             <form id="movies-filter" method="get">
                                 <!-- For plugins, we also need to ensure that the form posts back to our current page -->
                                 <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
                                 <!-- Now we can render the completed list table -->
                                 <?php $popupListTable->display() ?>
                             </form>
                         </div>
                  <?php 
					}				
				
				else	
					{
				?>
						<div class="wrap"><h2>Popups <a href="<?php echo site_url();?>/wp-admin/admin.php?page=addpopup" class="add-new-h2">Add New</a></h2>
						<h3>No popup found.</h3>
				<?php
				}
			}
	}

function justAsimplePopup_admin_actions() 
	{
		add_menu_page("Simple Popups", "Simple Popups", 1, "justAsimplePopup", "justAsimplePopup_admin");
		add_submenu_page( 'justAsimplePopup', 'Add Simple Popup', 'Add Simple Popup',1, 'addpopup', 'justAsimplePopup_add_new_popup' );
	}
	
	
	
/// SHOWING THE POP-UP ON FRONT END ////////

function justAsimplePopup() 
	{
   		global $wpdb;
		if(is_home() || is_front_page())
			{
				$args = array('post_type' => 'just_a_simple_popup','meta_query' => array(array('key' => 'home','value' => 1,'compare' => '=')),'posts_per_page'=>1);
				query_posts($args); 
				if(have_posts()){
				while(have_posts())
					{
						the_post();		
						$color=get_post_meta(get_the_ID(),'color');
						$pa=get_post_meta(get_the_ID(),'pageids');
						$fadetime=get_post_meta(get_the_ID(),'fadetime');
						$pages=explode(',',$pa[0]);
						$home=get_post_meta(get_the_ID(),'home');
						
						$width=get_post_meta(get_the_ID(),'width');
						$curr_ID=get_the_ID();
						$opa=get_post_meta(get_the_ID(),'opacity');
						$rgba = jasp_hex2rgba($color[0], $opa[0]);
						$clickbuttons=get_post_meta(get_the_ID(),'clickbuttons');
						$backgroundimage=get_post_meta(get_the_ID(),'background_image');
						$backgroundrepeat=get_post_meta(get_the_ID(),'background-repeat');
						$backgroundsize=get_post_meta(get_the_ID(),'background-size');
						
						echo '
						<script src="'.plugins_url().'/just-a-simple-popup/js/jquery.min.js" type="text/javascript"></script>
						<style>
						 #simpleclosePopup  
						 {
							float: right;
							margin-top: -22px;
							margin-right: -22px;
							background: #000;
							padding: 3px 7px;
							border-radius: 50px;
							color:#fff;
							text-decoration:none;
						}
						#justAsimplePopupOverlay 
							 {
								position: absolute;
								display: none;
								top: 0px;
								left: 0px;
								background-color: '.$rgba.';
								background-image:url('.plugins_url().'/just-a-simple-popup/popup-backgrounds/'.$backgroundimage[0].');';
								if($backgroundrepeat[0]==0)
									echo 'background-repeat:no-repeat;';
								echo '
								background-size:'.$backgroundsize[0].'% '.$backgroundsize[0].'% ;
								width: 100%;
								z-index: 999999;
							}
						  #justAsimplePopupWrapper 
							  {
								width: '.$width[0].'%;
								margin: 0 auto;
								background: #FAFAFA;
								padding: 25px;
								margin-top: 60px;
								border-radius:10px;
							 }
						
						</style>';
						if($clickbuttons[0]!='')
							{
								echo '
								
								<script>
										  jQuery(document).ready(function()
											{
												jQuery("'.$clickbuttons[0].'").click(function()
													{
													  
														jQuery("#justAsimplePopupOverlay").css("height",jQuery(document).height());
														jQuery("#justAsimplePopupOverlay").fadeIn('.$fadetime[0].');
													 
													  
														jQuery("#simpleclosePopup").click(function()
															{		
																jQuery("#justAsimplePopupOverlay").fadeOut(500);
															}); 
													
												  });
											 });
									</script>';
							}
						if($home[0])
							{
								echo '<script>
								 jQuery(document).ready(function()
									{
									  
										jQuery("#justAsimplePopupOverlay").css("height",jQuery(document).height());
										jQuery("#justAsimplePopupOverlay").fadeIn('.$fadetime[0].');
									 
									  
									  jQuery("#simpleclosePopup").click(function()
											{		
												jQuery("#justAsimplePopupOverlay").fadeOut(500);
											}); 
									
								  });
								</script>';
						}
						ob_start();
						the_content();
						$content = ob_get_clean();
						echo '
						<div id="justAsimplePopupOverlay">
							 <div id="justAsimplePopupWrapper">
								<div id="justAsimplePopupContent">
									<a href="javascript:void(0)" id="simpleclosePopup" title="close" >X</a>
									'.$content.'
								</div>
							 </div> 
						 </div> ';
										
					}
				}				
			}
		else
			{
				//$getdata=$wpdb->get_row("SELECT * from ".$wpdb->prefix ."justAsimplePopup  WHERE pages LIKE   OR clickbuttons!='' LIMIT 1");
				$args = array('post_type' => 'just_a_simple_popup','meta_query' => array(array('key' => 'pageids','value' => ",".get_the_ID().",",'compare' => 'LIKE')),'posts_per_page'=>1);
				query_posts($args); 
				if(have_posts()){
				while(have_posts())
					{
						the_post();		
						$color=get_post_meta(get_the_ID(),'color');
						$pa=get_post_meta(get_the_ID(),'pageids');
						$fadetime=get_post_meta(get_the_ID(),'fadetime');
						$pages=explode(',',$pa[0]);
						$home=get_post_meta(get_the_ID(),'home');
						
						$width=get_post_meta(get_the_ID(),'width');
						$curr_ID=get_the_ID();
						$opa=get_post_meta(get_the_ID(),'opacity');
						$rgba = jasp_hex2rgba($color[0], $opa[0]);
						$clickbuttons=get_post_meta(get_the_ID(),'clickbuttons');
						$onpageload=get_post_meta(get_the_ID(),'onpageload');
						$backgroundimage=get_post_meta(get_the_ID(),'background_image');
						$backgroundrepeat=get_post_meta(get_the_ID(),'background-repeat');
						
						echo '<style>
						 #simpleclosePopup  
						 {
							float: right;
							margin-top: -22px;
							margin-right: -22px;
							background: #000;
							padding: 3px 7px;
							border-radius: 50px;
							color:#fff;
							text-decoration:none;
						}
						 #justAsimplePopupOverlay 
							 {
								position: absolute;
								display: none;
								top: 0px;
								left: 0px;
								background-color: '.$rgba.';
								background-image:url('.plugins_url().'/just-a-simple-popup/popup-backgrounds/'.$backgroundimage[0].');';
								if($backgroundrepeat[0]==0)
									echo 'background-repeat:no-repeat;';
								echo '
								background-size:'.$backgroundsize[0].'% '.$backgroundsize[0].'% ;
								width: 100%;
								z-index: 999999;
							}
						#justAsimplePopupWrapper 
							  {
								width: '.$width[0].'%;
								margin: 0 auto;
								background: #FAFAFA;
								padding: 25px;
								margin-top: 60px;
								border-radius:10px;
							 }
						
						</style>';
						if($clickbuttons[0]!='')
							{
								echo '<script>
										  jQuery(document).ready(function()
											{
												jQuery("'.$clickbuttons[0].'").click(function()
													{
													  
														jQuery("#justAsimplePopupOverlay").css("height",jQuery(document).height());
														jQuery("#justAsimplePopupOverlay").fadeIn('.$fadetime[0].');
													 
													  
														jQuery("#simpleclosePopup").click(function()
															{		
																jQuery("#justAsimplePopupOverlay").fadeOut(500);
															}); 
													
												  });
											 });
									</script>';
							}
						if($onpageload[0]==1)	
							{
								echo '<script>
										 jQuery(document).ready(function()
											{
											  
												jQuery("#justAsimplePopupOverlay").css("height",jQuery(document).height());
												jQuery("#justAsimplePopupOverlay").fadeIn('.$fadetime[0].');
											 
											  
											  jQuery("#simpleclosePopup").click(function()
													{		
														jQuery("#justAsimplePopupOverlay").fadeOut(500);
													}); 
											
										  });
										</script>';
							}
						
						ob_start();
						the_content();
						$content = ob_get_clean();
						echo '
						<div id="justAsimplePopupOverlay">
							 <div id="justAsimplePopupWrapper">
								<div id="justAsimplePopupContent">
									<a href="javascript:void(0)" id="simpleclosePopup" title="close" >X</a>
									'.$content.'
								</div>
							 </div> 
						 </div> ';
										
					}
				}
			}	
		
			
	}

add_action('admin_menu', 'justAsimplePopup_admin_actions');
add_action('wp_head','justAsimplePopup');

function jasp_hex2rgba($color, $opacity = false) 
	{

		$default = 'rgb(0,0,0)';

		//Return default if no color provided
		if(empty($color))
			  return $default; 

		//Sanitize $color if "#" is provided 
			if ($color[0] == '#' ) {
				$color = substr( $color, 1 );
			}

			//Check if color has 6 or 3 characters and get values
			if (strlen($color) == 6) {
					$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
			} elseif ( strlen( $color ) == 3 ) {
					$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
			} else {
					return $default;
			}

			//Convert hexadec to rgb
			$rgb =  array_map('hexdec', $hex);

			//Check if opacity is set(rgba or rgb)
			if($opacity){
				if(abs($opacity) > 1)
					$opacity = 1.0;
				$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
			} else {
				$output = 'rgb('.implode(",",$rgb).')';
			}

			//Return rgb(a) color string
			return $output;
	}


?>