<?php
	
    function deserializar($unserserialize){
        $serializado=@unserialize($unserserialize);
        if(!$serializado){
            $serializado=@unserialize(preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'",$unserserialize));
        }
        return $serializado;
    }
    
    function obtener_dia($dia_ingles){
        $dia = "";
        switch ($dia_ingles) {
            case "Monday":
                $dia = "Lunes";
                break;
            case "Tuesday":
                $dia = "Martes";
                break;
            case "Wednesday":
                $dia = "Mi�rcoles";
                break;
            case "Thursday":
                $dia = "Jueves";
                break;
            case "Friday":
                $dia = "Viernes";
                break;
            case "Saturday":
                $dia = "S�bado";
                break;
            case "Sunday":
                $dia = "Domingo";
                break;
        }
        
        return $dia;
    }
    
    function obtener_mes($mes_ingles){
        $mes = "";
        switch ($mes_ingles) {
            case "January":
                $mes = "Enero";
                break;
            case "February":
                $mes = "Febrero";
                break;
            case "March":
                $mes = "Marzo";
                break;
            case "April":
                $mes = "Abril";
                break;
            case "May":
                $mes = "Mayo";
                break;
            case "June":
                $mes = "Junio";
                break;
            case "July":
                $mes = "Julio";
                break;
            case "August":
                $mes = "Agosto";
                break;
            case "September":
                $mes = "Septiembre";
                break;
            case "October":
                $mes = "Octubre";
                break;
            case "November":
                $mes = "Noviembre";
                break;
            case "December":
                $mes = "Diciembre";
                break;
        }
        
        return $mes;
    }    
    
    function obtener_plato($plato){
        $tipo_plato = "";
        switch ($plato) {
            case "entrante":
                $tipo_plato = "ENTRANTES";
                break;
            case "primero":
                $tipo_plato = "PRIMEROS";
                break;
            case "pescado":
                $tipo_plato = "PESCADOS";
                break;
            case "asado_carne":
                $tipo_plato = "ASADOS Y CARNES";
                break;
            case "comida_para_llevar":
                $tipo_plato = "COMIDA PARA LLEVAR";
                break;
        }
        
        return $tipo_plato;
    }
    
    
    function enviar_mail($name, $to, $title, $menssage){
        $para = $to;
        $titulo = $title;
        
        // message
        $mensaje = '
        <html>
        <head>
          <title></title>
        </head>
        <body>
          <table>
            <tr>
              <td style="font-weight: bold;text-align: left;">Hola!</td>
            </tr>
            <tr>
              <td style="font-weight: bold;text-align: left;">Tu amigo '.$name.', te envi� el siguiente mensaje:</td>
            </tr>            
            <tr>
              <td><p style="font-weight: normal;text-align: left;">'.$menssage.'</p></td>
            </tr>
            <tr>
              <td style="font-weight: bold;text-align: left;">Tambi�n te recomendamos que te descargues nuestra aplicaci�n de App Store y Google Play</td>
            </tr>
            <tr>
              <td>
                <ul>
                    <li>Haz click <a target="_blank" href="https://itunes.apple.com/us/app/las-terrazas/id659544549?l=es&ls=1&mt=8">aqu�</a> para descargar la app de App Store</li>
                    <li>Haz click <a target="_blank" href="https://play.google.com/store/apps/details?id=terrazas.arrobacreativa&feature=search_result#?t=W251bGwsMSwyLDEsInRlcnJhemFzLmFycm9iYWNyZWF0aXZhIl0.">aqu�</a> para descargar la app de Google Play</li>
                </ul>
              </td>
            </tr>
            <tr>
                <td><hr/></td>
            </tr>
            <tr>
                <td style="text-align: left;">Restaurante Las Terrazas <br/> <span font-weight: bold;>"M�s de cuarenta a�os de experiencia nos avalan..."</span></td>
            </tr>
            <tr>
                <td style="text-align: left;">
                    <a target="_blank" href="http://www.lasterrazasdebecerril.es">http://www.lasterrazasdebecerril.es</a><br/>
                    contacto@ <br/>
                    91 853 8002 <br/><br/>
                    C/ San Sebasti�n 3 <br/>
                    Becerril de la Sierra - Madrid
                </td>
            </tr>
          </table>
        </body>
        </html>
        ';
        
        // Para enviar un correo HTML mail, la cabecera Content-type debe fijarse
        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        
        // Cabeceras adicionales
        $cabeceras .= 'From: Restaurante Las Terrazas <contacto@lasterrazasdebecerril.es>' . "\r\n";
        //$cabeceras .= 'Cc: test@example.com' . "\r\n";
        //$cabeceras .= 'Bcc: test@example.com' . "\r\n";
        // Mail it
        
        return mail($para, $titulo, $mensaje, $cabeceras);
    }
    
    function enviar_contacto($name, $phone, $email, $menssage){
        // message
        $mensaje = '
        <html>
        <head>
        <style> b { color: #cc1414;} td { color: #040404; font-size: 18px; font-family: Arial; line-height: 24px; text-align: justify; } a { text-transform: none; color: #cc1414; } </style><br>
          <title></title>
        </head>
        <body>
            <table style="border: solid 2px #cdcaca;" align="center" bgcolor="white" border="0" cellpadding="0" cellspacing="0" width="611">
            <tbody>
            	<tr>
            		<td style="text-align: center;">
                        <a target="_blank" href="http://www.lasterrazasdebecerril.es/" title="Terrazas">
                            <img style="" src="http://www.lasterrazasdebecerril.es/img/bg_logo_terrazas.png" title="Restaurante las terrazas" height="109" width="370">
                        </a>
                    </td>
            	</tr>
            
            	<tr>
                <tr>
                    <td>
                        <hr />
                    </td>
                </tr>
            		<td>
            <table align="center" bgcolor="white" border="0" cellpadding="0" cellspacing="0" width="611">
            <tbody>
            	<tr>
            		<td height="10"></td>
            	</tr>
            
            	<tr>
                    <td style="font-size: 18px;">
                        <label style="color: #C30505;">Nombre : </label>'.$name.'<br><br>
                        <label style="color: #C30505;">Telefono : </label><b>'.$phone.'</b><br><br> 
                        <label style="color: #C30505;">Email : </label><a href="mailto:'.$email.'">'.$email.'</a>: <br><br><br>
                        <label style="color: #C30505;">Mensaje : </label>'.$menssage.'
                    </td>
            
            		<td width="20"></td>
            
            		<td></td>
            	</tr>
            
            	<tr>
            		<td colspan="3" style="text-align: center;" height="100"><a style="color: #c30505; font-family: arial;" href="http://www.lasterrazasdebecerril.es/"><b><span style="color: #c30505; font-family: arial; font-size: 18px;">www.lasterrazasdebecerril.es</span></b></a><a></a></td>
            	</tr>
            </tbody>
            </table>
            </td>
            	</tr>
            
            	<tr>
            		<td><img style="" src="http://www.patrocinalos.com/img/mailing/mail-footerxx.jpg" height="28" width="611"></td>
            	</tr>
            
            	<tr>
            		<td width="533">
            <table align="center" bgcolor="white" border="0" cellpadding="0" cellspacing="0" width="533">
            <tbody>
            	<tr>
            		<td height="43" width="188">&nbsp;</td>
            	</tr>
            	<tr>
            		<td height="8"></td>
            	</tr>
            </tbody>
            </table>
            </td>
            	</tr>
            </tbody>
            </table>
            <table align="center" bgcolor="white" border="0" cellpadding="0" cellspacing="0" width="770">
            <tbody>
            	<tr>
            		<td style="font-size: 14px;"> &nbsp; </td>
            	</tr>
            </tbody>
            </table>
        </body>
        </html>
        ';
        
        // Para enviar un correo HTML mail, la cabecera Content-type debe fijarse
        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        
        // Cabeceras adicionales
        //$cabeceras .= 'To: Las terrazas <contacto@lasterrazasdebecerril.es>' . "\r\n";
        $cabeceras .= 'From: ' . $email . "\r\n";
        $subject = 'Contacto - ' . $name;
        //$cabeceras .= 'Cc: test@example.com' . "\r\n";
        //$cabeceras .= 'Bcc: test@example.com' . "\r\n";
        // Mail it
        
        return mail('contacto@lasterrazasdebecerril.es', $subject, $mensaje, $cabeceras);
    }
    
?>