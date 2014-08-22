<?php
/*
Plugin Name: just a simple popup
Author: Ankit Chauhan
Author URI: https://www.facebook.com/Ankit6765
Version:2.0
Description: The plugin allows you to show the pop up on any page by setting up the values in the admin panel after activating the plugin. You can change the background,fade In time, opacity, content of the pop in the Admin panel.
*/
global $justAsimplePopup_db_version;
$justAsimplePopup_db_version = "2.0";
include('listPopups.php');
function justAsimplePopup_install() {
   global $wpdb;
   global $justAsimplePopup_db_version;

   $table_name = $wpdb->prefix . "justAsimplePopup";
      
   $sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(200) NOT NULL,
  color varchar(6) NOT NULL,
  width varchar(6) NOT NULL,
  fadetime varchar(10) NOT NULL,
  pages varchar(200) NOT NULL,
  home tinyint(4) NOT NULL,
  content text NOT NULL,
  opacity decimal(3,2) NOT NULL,
  PRIMARY KEY (id)
)";

   require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
   $wpdb->query( $sql );
 
   add_option( "justAsimplePopup_db_version", $justAsimplePopup_db_version );
}




function justAsimplePopup_install_data() {
   global $wpdb;
   $table_name = $wpdb->prefix . "justAsimplePopup";
   $rows_affected = $wpdb->insert( $table_name, array('color'=>'#000000','fadetime'=>'500','pages'=>'','home'=>0,'opacity'=>0.8,'content'=>''));
}


function POD_deactivate()
{
	global $wpdb;	//required global declaration of WP variable

	$table_name = $wpdb->prefix."justAsimplePopup";

	$sql = "DROP TABLE ". $table_name;

	$wpdb->query($sql);

}

register_activation_hook( __FILE__, 'justAsimplePopup_install' );
register_activation_hook( __FILE__, 'justAsimplePopup_install_data' );
register_deactivation_hook(__FILE__ , 'POD_deactivate' );

//// ADD NEW POPUP

function justAsimplePopup_add_new_popup()
	{
		global $wpdb;
		if(isset($_REQUEST['saveJustapopup']))
			{
				$name=$_REQUEST['popname'];
				$color=$_REQUEST['background'];
				$fadetime=$_REQUEST['fadetime'];
				$pageids=','.$_REQUEST['pageids'].',';
				$home=$_REQUEST['onhome'][0];
				$popuodescription=$_REQUEST['popupcontent'];
				$opacity=$_REQUEST['opacity'];
				$width=$_REQUEST['width'];
				
				$wpdb->insert($wpdb->prefix .'justAsimplePopup',array('color'=>$color,'fadetime'=>$fadetime,'pages'=>$pageids,'home'=>$home,'opacity'=>$opacity,'content'=>$popuodescription,'name'=>$name,'width'=>$width));
				$popupupdated="Popup Successfully Created.";
			}
		
		/*$getdata=$wpdb->get_row("SELECT * from ".$wpdb->prefix ."justAsimplePopup ");
		$editcolor=$getdata->color;
		$editfadetime=$getdata->fadetime;
		$editpages=$getdata->pages;
		$edithome=$getdata->home;
		$editpopupdesc=$getdata->content;
		$editopacity=$getdata->opacity;*/
		
		echo '<script src="'.plugins_url().'/just-a-simple-popup/js/jscolor.js"></script><div id="justAsimplePopuppAdmin">
				<style>
				#justAsimplePopuppAdmin
					{
						width: 100%;
					}
				#justAsimplePopuppAdminWrapper
					{
						width: 80%;
						padding: 10px;
					}
				#justAsimplePopuppAdminContent
					{
						width: 80%;
						
					}
				#justAsimplePopuppAdminContent h2
					{
						border-bottom: 2px solid gray;
						padding-bottom: 10px;
					}
				.justAsimplePopuppAdminFormRow
					{
						width:100%;
						float:left;
						margin:5px 0;
					}	
				.justAsimplePopuppAdminFormRow label
					{
						width:24%;
						float:left;
					}
				.justAsimplePopuppAdminFormRow input[type="text"]
					{
						width:40%;
						float:left;
						
					}
				.justAsimplePopuppAdminFormRow textarea
					{
						width:60%;
						float:left;
						height:200px;
					}
				.justAsimplePopuppAdminFormRow input[type="submit"]
					{
						width: 25%;
						float: left;
						background: green;
						padding: 10px 0;
						border: none;
						cursor: pointer;
						border-radius: 10px;
						color: #fff;
						margin-top:20px
					}
				</style>
				<div id="justAsimplePopuppAdminWrapper">
					<div id="justAsimplePopuppAdminContent">
						<h2>Just A Simple Popup Settings:</h2>
						<h4>'.$popupupdated.'</h4>
						<div id="justAsimplePopuppAdminForm">
									
							<form action="" method="post">
								<div class="justAsimplePopuppAdminFormRow">
									<label for="popname">Name : </label>
									<input type="text" name="popname" id="name" class="name" value="" />								
								</div>
								<div class="justAsimplePopuppAdminFormRow">
									<label for="background-color">Background-color : </label>
									<input type="text" name="background" id="background" class="color" value="" readonly="readonly"/>								
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
								<div class="justAsimplePopuppAdminFormRow">
									<label for="onhome">Popup content : </label>
									<textarea name="popupcontent">'.stripslashes($editpopupdesc).'</textarea>	
								</div>
								<div class="justAsimplePopuppAdminFormRow">
									<input type="submit" name="saveJustapopup" id="saveJustapopup" value="Add"/>								
								</div>
							</form>
						</div>
					</div>
				</div>				
			  </div>';
	}


/// SETTING THE POP-UP IN ADMIN PANEL THE POP-UP ON FRONT END ////////


function justAsimplePopup_admin() 
	{
		global $wpdb;
		
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
								$wpdb->update($wpdb->prefix .'justAsimplePopup',array('color'=>$color,'fadetime'=>$fadetime,'pages'=>$pageids,'home'=>$home,'opacity'=>$opacity,'content'=>$popuodescription,'name'=>$name,'width'=>$width),array('id'=>$popupId));
								$popupupdated="Setting have been successfully saved.";
							}
						$getdata=$wpdb->get_row("SELECT * from ".$wpdb->prefix ."justAsimplePopup WHERE id=".$popupId);
						$editname=$getdata->name;
						$editcolor=$getdata->color;
						$editfadetime=$getdata->fadetime;
						$editpages=$getdata->pages;
						$edithome=$getdata->home;
						$editpopupdesc=$getdata->content;
						$editwidth=$getdata->width;
						$editopacity=$getdata->opacity;
						echo '<script src="'.plugins_url().'/just-a-simple-popup/js/jscolor.js"></script><div id="justAsimplePopuppAdmin">
						<style>
						#justAsimplePopuppAdmin
							{
								width: 100%;
							}
						#justAsimplePopuppAdminWrapper
							{
								width: 80%;
								padding: 10px;
							}
						#justAsimplePopuppAdminContent
							{
								width: 80%;
								
							}
						#justAsimplePopuppAdminContent h2
							{
								border-bottom: 2px solid gray;
								padding-bottom: 10px;
							}
						.justAsimplePopuppAdminFormRow
							{
								width:100%;
								float:left;
								margin:5px 0;
							}	
						.justAsimplePopuppAdminFormRow label
							{
								width:24%;
								float:left;
							}
						.justAsimplePopuppAdminFormRow input[type="text"]
							{
								width:40%;
								float:left;
								
							}
						.justAsimplePopuppAdminFormRow textarea
							{
								width:60%;
								float:left;
								height:200px;
							}
						.justAsimplePopuppAdminFormRow input[type="submit"]
							{
								width: 25%;
								float: left;
								background: green;
								padding: 10px 0;
								border: none;
								cursor: pointer;
								border-radius: 10px;
								color: #fff;
								margin-top:20px
							}
						</style>
						<div id="justAsimplePopuppAdminWrapper">
							<div id="justAsimplePopuppAdminContent">
								<h2>Just A Simple Popup Settings:</h2>
								<h4>'.$popupupdated.'</h4>
								<div id="justAsimplePopuppAdminForm">
											
									<form action="" method="post">
										<div class="justAsimplePopuppAdminFormRow">
											<label for="popname">Name : </label>
											<input type="text" name="popname" id="name" class="name" value="'.$editname.'" />								
										</div>
										<div class="justAsimplePopuppAdminFormRow">
											<label for="background-color">Background-color : </label>
											<input type="text" name="background" id="background" class="color" value="'.$editcolor.'" readonly="readonly"/>								
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
										<div class="justAsimplePopuppAdminFormRow">
											<label for="onhome">Popup content : </label>
											<textarea name="popupcontent">'.stripslashes($editpopupdesc).'</textarea>	
										</div>
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
						$deletePopup=$wpdb->query("delete from  ".$wpdb->prefix ."justAsimplePopup where id=".$popupId."");
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
				$getAllPopups=$wpdb->get_results("SELECT * FROM ".$wpdb->prefix."justAsimplePopup");
				$popupArray=array();
				$countPop=0;
				if(count($getAllPopups))
					{				
						foreach($getAllPopups as $popup)
							{
								$popupArray[$countPop]['id']=$popup->id;
								$popupArray[$countPop]['name']=$popup->name;
								$popupArray[$countPop]['color']=$popup->color;
								$popupArray[$countPop]['pages']=$popup->pages;
								$popupArray[$countPop]['home']=$popup->home;
								$popupArray[$countPop]['opacity']=$popup->opacity;
								$popupArray[$countPop]['fadetime']=$popup->fadetime;
								$popupArray[$countPop]['content']=$popup->content;	
								$popupArray[$countPop]['width']=$popup->width;	
								$countPop++;
							}				
					
				 $popupListTable->prepare_items($popupArray);	
				
				?>
				<div class="wrap"><h2>Popups <a href="<?php echo site_url();?>/wp-admin/admin.php?page=addpopup" class="add-new-h2">Add New</a></h2>
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
		add_menu_page("Just a Simple Popup", "Just a Simple Popup", 1, "justAsimplePopup", "justAsimplePopup_admin");
		add_submenu_page( 'justAsimplePopup', 'Add Popup', 'Add Popup',1, 'addpopup', 'justAsimplePopup_add_new_popup' );
	}
	
	
	
/// SHOWING THE POP-UP ON FRONT END ////////

function justAsimplePopup() 
	{
   		global $wpdb;
		if(is_home() || is_front_page())
			{
				$getdata=$wpdb->get_row("SELECT * from ".$wpdb->prefix ."justAsimplePopup WHERE home=1 LIMIT 1");
			}
		else
			{
				$getdata=$wpdb->get_row("SELECT * from ".$wpdb->prefix ."justAsimplePopup  WHERE pages LIKE '%,".get_the_ID().",%' LIMIT 1");
			}
		if(count($getdata))
			{
				$color=$getdata->color;
				$fadetime=$getdata->fadetime;
				$pages=explode(',',$getdata->pages);
				$home=$getdata->home;
				$popupdesc=$getdata->content;
				$width=$getdata->width;
				$curr_ID=get_the_ID();
				$rgba = hex2rgba($color, $getdata->opacity);
				
				
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
						background: '.$rgba.';
						width: 100%;
						z-index: 999999;
					}
				  #justAsimplePopupWrapper 
					  {
						width: '.$width.'%;
						margin: 0 auto;
						background: #eee;
						padding: 25px;
						margin-top: 60px;
						border-radius:10px;
					 }
				
				</style>
				<script>
				 jQuery(document).ready(function()
					{
					  
						jQuery("#justAsimplePopupOverlay").css("height",jQuery(document).height());
						jQuery("#justAsimplePopupOverlay").fadeIn('.$fadetime.');
					 
					  
					  jQuery("#simpleclosePopup").click(function()
							{		
								jQuery("#justAsimplePopupOverlay").fadeOut(500);
							}); 
					
				  });
				</script>
				<div id="justAsimplePopupOverlay">
					 <div id="justAsimplePopupWrapper">
						<div id="justAsimplePopupContent">
							<a href="javascript:void(0)" id="simpleclosePopup" title="close" >X</a>
							'.stripslashes($popupdesc).'
						</div>
					 </div> 
				 </div> ';
			}
	}

add_action('admin_menu', 'justAsimplePopup_admin_actions');
add_action('wp_head','justAsimplePopup');

function hex2rgba($color, $opacity = false) 
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