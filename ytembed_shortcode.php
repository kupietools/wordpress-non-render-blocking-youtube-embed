<?php

#### ytembed shortcode

#put this in your theme's functions's php or in a custom plugin file,

#First we do some things in the global scope: create the footer script that will scan the page after loading for youtube videos that need to be embedded...

 $theScript = <<<END
    <script id="mk_ytEmbed_footerScript" type="text/javascript"><!--
    if(typeof inject != 'function'){ //this will allow this script to be injected without overwriting any other window.onload scripts
         window.inject=function(before, fn) {
         return function(){
                          before.apply(this, arguments);
                          return fn.apply (this, arguments);
                          }
          }

     }

  if(typeof setYTembed_footer != 'function'){ //make sure following function is only defined once
     function setYTembed_footer() { //function to create embed <iframe> tags
         if (document.querySelector("div.mk_YTembedDiv")) { //is there an embed on this page?
             var theseDivs = document.querySelectorAll("div.mk_YTembedDiv"); //get all divs to be embedded into
             for (var divi = 0; divi < theseDivs.length; divi++) { //loop through the found divs
                   if(! theseDivs.item(divi).children.length) { //make sure div is empty so we don't accidentally insert more than one video embed into the div
                        var f = document.createElement('iframe');
                        f.src = theseDivs.item(divi).getAttribute("data-url"); 
	                    f.setAttribute("title","YouTube video player");
	                    f.setAttribute("frameborder","0");
         	            f.setAttribute("allowfullscreen","allowfullscreen");
                        theseDivs.item(divi).append(f); //add the iframe to the div
     			    }
               }
          }
	 }

     if (window.onload) //inject the script so it runs when the page is done loading
          {window.onload=inject(window.onload,setYTembed_footer);}
     else
          {window.onload=setYTembed_footer;}
          }
//--></script>
END;

# Now we add the above to the page footer...
        
	add_action('wp_footer', function() use (&$theScript) {
		
        echo $theScript;
    });


#Add the shortcode...

add_shortcode("ytembed", "do_ytembed");

function do_ytembed($atts = [], $content = null)
{ //extract the attributes
   $atts = shortcode_atts(
        [
            "url" => "",
            "width"=>"516",
			"float"=>""
       ],
        $atts,
        "ytembed"
    );
    #create a unique classname based on the embed url. This is so the same video can be embedded more than once in a page
    $ytID = str_replace( array("%","+","."), "", rawurlencode($atts["url"]));     
    $thisID = "mk_ytID_$ytID";
    #create the div that will be populated with the video after page load
    $divFloat = $atts["float"]!=""?" style=\"float:".$atts["float"].";padding-right:4px;\"":""; //CSS float style property, if specified
    return "<div data-url=\"".$atts["url"]."\" class=\"mk_YTembedDiv\" width=\"".$atts["width"]."\"".$divFloat."></div>";
}
