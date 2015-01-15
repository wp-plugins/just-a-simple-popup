<?php
include('../../../wp-blog-header.php');
global $wpdb;

if(current_user_can( 'manage_options' ))
	{
		$post_Id=$_REQUEST['popupId'];	
		$getbackgroundimage=get_post_meta($post_Id,'background_image');
		$imageName='../../../wp-content/plugins/just-a-simple-popup/popup-backgrounds/'.$getbackgroundimage[0];
		unlink($imageName);
		update_post_meta($post_Id,'background_image','');
		echo 1;
	}
?>