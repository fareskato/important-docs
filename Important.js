/************* Set and get and check cookies via javascript ******************/

    jQuery(document).ready(function () {        
            function setCookie(c_name,value)
            {                
                document.cookie=c_name + "=" + value + '; path=/';
            }
            function getCookie(c_name)
            {
                var c_value = document.cookie;
                var c_start = c_value.indexOf(" " + c_name + "=");
                if (c_start == -1) {
                    c_start = c_value.indexOf(c_name + "=");
                }
                if (c_start == -1) {
                    c_value = null;
                } else {
                    c_start = c_value.indexOf("=", c_start) + 1;
                    var c_end = c_value.indexOf(";", c_start);
                    if (c_end == -1) {
                        c_end = c_value.length;
                    }
                    c_value = unescape(c_value.substring(c_start,c_end));
                }
                return c_value;
            }  
            setCookie('count_wp', parseInt(getCookie('count_wp')) ? parseInt(getCookie('count_wp'))+1 : 1)            
            if(parseInt(jQuery.cookie("count_wp"))=== 3 && jQuery.cookie("hide_newsletter")!= 'noNewsletter' ){
                jQuery('.newsletter-modal').attr('data-remodal-id','modal');
                jQuery('[data-remodal-id=modal]').remodal().open();
                jQuery('.newsletter-modal .remodal-close').on('click',function(){
                    document.cookie = 'hide_newsletter=noNewsletter; path=/'; 
                });
            }

    
    });
