jQuery.noConflict();
(function($){
	
	var fb_text = wp_share_simple_object.fb_text, tw_text = wp_share_simple_object.tw_text;
	
	
    $(function() {
        $('.wp-share-simple').sharrre({
  share: {
    twitter: true,
    facebook: true,
    googlePlus: true
  },
  template:  '<div class="wp-share-simple-box">'
	          	+'<div class="wp-share-simple-buttons">'
	          		+'<div class="wp-share-simple-facebook facebook">'+fb_text+'</div>'
	          		+'<div class="wp-share-simple-twitter twitter">'+tw_text+'</div>'
	          	+'</div>'
	            +'<div class="wp-share-simple-count">{total}<span>SHARES</span></div>'
	          +'</div>'
	       ,
  enableHover: false,
  enableTracking: true,
  render: function(api, options){
  $(api.element).on('click', '.twitter', function() {
    api.openPopup('twitter');
  });
  $(api.element).on('click', '.facebook', function() {
    api.openPopup('facebook');
  });
  $(api.element).on('click', '.googleplus', function() {
    api.openPopup('googlePlus');
  });
 }
 });
});

})(jQuery);