
var site_url = 'http://localhost/fanavard/captcha/public_html/' ;

function refresh_captcha()
{
	var site_key_val  = $(".cp-div").data('sitekey');
	var lang_val  = $(".cp-div").data('lang');
	var word_method_val  = $(".cp-div").data('method');
	$.ajax({
				url : site_url + "api/captcha/html/" ,
				method : "POST" ,
				data : { site_key: site_key_val, lang : lang_val , word_method : word_method_val} ,
				success : function(result){
					$(".cp-div").html(result) ;
				}
	}) ;
}

$(document).ready(function(){

	//run this function at first loading
	refresh_captcha();
	
});