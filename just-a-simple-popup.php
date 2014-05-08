<?php
/*
Plugin Name: just a simple popup
Author: Ankit Chauhan
Author URI: https://www.facebook.com/Ankit6765
Version:1.0
Description: The plugin allows you to show the pop up on any page by setting up the values in the admin panel after activating the plugin. You can change the background,fade In time, opacity, content of the pop in the Admin panel.
*/
global $justAsimplePopup_db_version;
$justAsimplePopup_db_version = "1.0";

function justAsimplePopup_install() {
   global $wpdb;
   global $justAsimplePopup_db_version;

   $table_name = $wpdb->prefix . "justAsimplePopup";
      
   $sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(200) NOT NULL,
  color varchar(6) NOT NULL,
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
   $rows_affected = $wpdb->insert( $table_name, array('color'=>'#000000','fadetime'=>'500','pages'=>'','home'=>1,'opacity'=>0.8,'content'=>''));
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

/// SETTING THE POP-UP IN ADMIN PANEL THE POP-UP ON FRONT END ////////


function justAsimplePopup_admin() 
	{
		global $wpdb;
		if(isset($_REQUEST['saveJustapopup']))
			{
				$color=$_REQUEST['background'];
				$fadetime=$_REQUEST['fadetime'];
				$pageids=$_REQUEST['pageids'];
				$home=$_REQUEST['onhome'][0];
				$popuodescription=$_REQUEST['popupcontent'];
				$opacity=$_REQUEST['opacity'];
				$wpdb->update($wpdb->prefix .'justAsimplePopup',array('color'=>$color,'fadetime'=>$fadetime,'pages'=>$pageids,'home'=>$home,'opacity'=>$opacity,'content'=>$popuodescription),array('id'=>1));
				$popupupdated="Setting have been successfully saved.";
			}
		
		$getdata=$wpdb->get_row("SELECT * from ".$wpdb->prefix ."justAsimplePopup ");
		$editcolor=$getdata->color;
		$editfadetime=$getdata->fadetime;
		$editpages=$getdata->pages;
		$edithome=$getdata->home;
		$editpopupdesc=$getdata->content;
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
						width:20%;
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
									<input type="text" name="pageids" id="pageids" value="'.$editpages.'" /> (Please enter page IDs seperated by commas(,) on which the popup will be displayed.)								
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
									<input type="submit" name="saveJustapopup" id="saveJustapopup" value="Update"/>								
								</div>
							</form>
						</div>
					</div>
				</div>				
			  </div>';
	}

function justAsimplePopup_admin_actions() 
	{
		add_options_page("Just a Simple Popup", "Just a Simple Popup", 1, "justAsimplePopup", "justAsimplePopup_admin");
	}
	
	
	
/// SHOWING THE POP-UP ON FRONT END ////////

function justAsimplePopup() 
	{
   		global $wpdb;
		$getdata=$wpdb->get_row("SELECT * from ".$wpdb->prefix ."justAsimplePopup ");
		$color=$getdata->color;
		$fadetime=$getdata->fadetime;
		$pages=explode(',',$getdata->pages);
		$home=$getdata->home;
		$popupdesc=$getdata->content;
		$curr_ID=get_the_ID();
		if(in_array($curr_ID,$pages) || ($home==1 && (is_home() || is_front_page())))
			{
			
			
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
				position: fixed;
				display: none;
				top: 0px;
				left: 0px;
				background: #'.$color.';
				opacity:'.$getdata->opacity.';
				width: 100%;
				z-index: 999999;
			}
		  #justAsimplePopupWrapper 
			  {
				width: 40%;
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
?>