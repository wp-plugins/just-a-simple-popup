// JavaScript Document
jQuery(document).ready(function(){
jQuery("#removePopupImage").click(function(){
		var popupId=jQuery("#removePopupImage").attr("data");
		
		jQuery.ajax({
			url:'../wp-content/plugins/just-a-simple-popup/removePopupImage.php?popupId='+popupId,
			type:'GET',
			success:function(response){
				if(response==1)
					jQuery("#removePopupImage").parent().fadeOut(500,function(){jQuery("#removePopupImage").parent().remove()});
			}
			});		
		
	});
});