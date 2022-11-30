 define(['jquery','custom-social-proof'], function($)
 {
    var r_text = new Array ();
r_text[0] = "London";
r_text[1] = "Edinburgh";
r_text[2] = "Cardiff";
r_text[3] = "Cambridge";
r_text[5] = "Windsor";
r_text[4] = "Liverpool";
r_text[6] = "Grimsby";
r_text[7] = "Manchester";
r_text[8] = "Leeds";
r_text[9] = "Reading";


    var r_map = new Array ();
r_map[0] = "https://s3.amazonaws.com/provely-public/images/maps/02a342794409deaf5f29216201d9da30.jpg";
r_map[1] = "https://s3.amazonaws.com/provely-public/images/maps/359f4e0ae29d7fb7af480e4e87ced439.jpg";
r_map[2] = "https://s3.amazonaws.com/provely-public/images/maps/4b2aee97b83b39dd44d9be1041e06a83.jpg";
r_map[4] = "https://s3.amazonaws.com/provely-public/images/maps/2211ef3aabad24eb566b23da26669662.jpg";
r_map[5] = "https://s3.amazonaws.com/provely-public/images/maps/3d147c6ba113929f5a004a5e9dcc832e.jpg";
r_map[6] = "https://s3.amazonaws.com/provely-public/images/maps/e10212e09e6eb3b49d00e046870445af.jpg";

 
var r_product = new Array ();
r_product[0] = "purchased item 1";
r_product[1] = "purchased item 2";
r_product[2] = "purchased item 3 Hosting";
r_product[3] = "purchased Licence ";
r_product[4] = "renewed Hosting";
r_product[5] = "renewed AWS/VPS";
r_product[6] = "renewed Wordpress Hosting";
r_product[7] = "renewed Licence ";

     setInterval(function(){ $(".custom-social-proof").stop().slideToggle('slow'); }, 3000);
      $(".custom-close").click(function() {
        $(".custom-social-proof").stop().slideToggle('slow');
      });
        setInterval(function(){    
        	var myNumber = Math.floor(7*Math.random());
        	// $("#map1").attr("src",r_map[myNumber]);
 			$('#country').text(r_text[myNumber]);

          	$('#product').text(r_product[Math.floor(7*Math.random())]);
 			var timeVal = Math.floor(7*Math.random());
 	
 			$('#time').text(timeVal);
 		
 		 
     //console.log(timeVal); 
 }, 6000);
 });