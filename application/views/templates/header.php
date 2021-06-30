<html>
    <head>
        <title>CCDB ID Generator</title>
    </head>
    <body>
        <script> 
            function setCookie(name,value,days) 
            {
                var expires = "";
                if (days) {
                    var date = new Date();
                    date.setTime(date.getTime() + (days*24*60*60*1000));
                    expires = "; expires=" + date.toUTCString();
                }
                document.cookie = name + "=" + (value || "")  + expires + "; path=/";
            }
            function getCookie(name) {
                var nameEQ = name + "=";
                var ca = document.cookie.split(';');
                for(var i=0;i < ca.length;i++) {
                    var c = ca[i];
                    while (c.charAt(0)==' ') c = c.substring(1,c.length);
                    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
                }
                return null;
            }
            function eraseCookie(name) {   
                document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
            }
            
        </script>
        <table style="width:100%;" cellspacing="0" cellpadding="0">
            <tr >
                <td style="background: #336699; width: 5%">
                    <span style="color:white">&nbsp;<a href="/Ccdb_id_gen" target="_self"><img width="60px" src="/pix/logo2.png" /></a></span>
                </td>
                <td style="background: #336699; width: 95%">
                    <span style="color:white"><h4>&nbsp;CCDB ID Generator</h4></span>
                </td>
            </tr>
        </table>
    
