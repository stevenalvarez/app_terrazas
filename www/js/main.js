/************************************ VARIABLES DE CONFIGURACION *******************************************************/

/************************************ server *******************************************************/
var IDIOMA = "esp";
var serviceURL = "http://lasterrazasdebecerril.es/services/";
var BASE_URL = "http://lasterrazasdebecerril.es/";

/************************************ localhost *******************************************************/
//var serviceURL = "http://localhost/lasterrazas_mobile/services/";
//var BASE_URL = "http://localhost/lasterrazas_mobile/";

/************************************ EVENTOS *******************************************************/

//Las Terrazas
$(document).on('pageinit', "#las_terrazas", function(){
   getLasTerrazas();
});

//Las Menu Diario
$(document).on('pageinit', "#menu_dia", function(){
   getMenuDiario();
});

//Galeria Restaurante
$(document).on('pageinit', "#galeria_restaurante", function(){
   getGaleriaFoto("restaurante");
});

//Galeria La Carta
$(document).on('pageinit', "#galeria_la_carta", function(){
   getGaleriaFoto("la_carta");
});

//La Carta - Menu
$('#la_carta').live('pagebeforeshow', function(event, ui) {
    var element = $(this).find(".content_lista_galeria").find("a");
    element.removeClass("selected");
    element.unbind("click");
	element.click(function(){
	   element.removeClass("selected");
       $(this).addClass("selected");
	});
    
    //Idioma
    var idioma = $(this).find("a#seleccionar_idioma");
    idioma.unbind("click");
	idioma.click(function(){
	   $("body").css("background-color", "#000");
       $("body").css("opacity", "0.1");
       $("body").animate({opacity: 1}, 800, function() {
             $("body").css("background-color", "#fff");
       });
       //Ahora si hizo click estando la bandera en ingles, significa que quiere ver la carta en ingles y vicerversa
       if($(this).hasClass("esp")){
        $(this).removeClass("esp").addClass("eng");
        IDIOMA = "esp";
        
        /* Lo traducimos al lenguaje seleccinado SPANISH */
        $('#la_carta').find("h1").html(NUESTRA_CARTA_esp);
        $('#la_carta').find(".entrantes .ui-btn-text").html(ENTRANTES_esp);
        $('#la_carta').find(".primeros .ui-btn-text").html(PRIMEROS_esp);
        $('#la_carta').find(".pescados .ui-btn-text").html(PESCADOS_esp);
        $('#la_carta').find(".carnes .ui-btn-text").html(ASADOS_esp);
        $('#la_carta').find(".comida_para_llevar .ui-btn-text").html(COMIDA_esp);
        $('#la_carta').find(".nuestros_vinos .ui-btn-text").html(VINOS_esp);
        $('#la_carta').find(".menu_grupo .ui-btn-text").html(MENU_GRUPOS_esp);
        
       }else if($(this).hasClass("eng")){
        $(this).removeClass("eng").addClass("esp");
        IDIOMA = "eng";
        
        /* Lo traducimos al lenguaje seleccinado INGLES */
        $('#la_carta').find("h1").html(NUESTRA_CARTA_eng);
        $('#la_carta').find(".entrantes .ui-btn-text").html(ENTRANTES_eng);
        $('#la_carta').find(".primeros .ui-btn-text").html(PRIMEROS_eng);
        $('#la_carta').find(".pescados .ui-btn-text").html(PESCADOS_eng);
        $('#la_carta').find(".carnes .ui-btn-text").html(ASADOS_eng);
        $('#la_carta').find(".comida_para_llevar .ui-btn-text").html(COMIDA_eng);
        $('#la_carta').find(".nuestros_vinos .ui-btn-text").html(VINOS_eng);
        $('#la_carta').find(".menu_grupo .ui-btn-text").html(MENU_GRUPOS_eng);
        
       }
	});    
});

//La Carta - Items
$('#la_carta_detail').live('pagebeforeshow', function(event, ui) {
    
    //Elimanos los platos que estan
    $('#la_carta_detail h3').html("");
    $("#la_carta_detail").find(".pedidos_text").remove();
    $('#la_carta_detail').find("ul > li").remove();
    
    var href;
    var tipo_plato = $(ui.prevPage).find(".content_lista_galeria").find("a.selected");
    if(tipo_plato.context == undefined){
        href = "#la_carta_detail?tipo_plato=entrante";
    }else{
        href = tipo_plato.attr("href");
    }
    tipo_plato = getUrl(href)["tipo_plato"];
    $.getJSON(serviceURL + 'get_platos.php?tipo_plato='+tipo_plato, loadPlato);
});

//Novedades
$(document).on('pageinit', "#novedades", function(){
   getNovedades();
});

//Novedades detalle
$('#novedad_detalle').live('pagebeforeshow', function(event, ui) {
    var id = getUrlVars()["id"];
    $.getJSON(serviceURL + 'get_novedad.php?id='+id, showNovedad);
});

//ENVIAR A UN AMIGO
$('#envia_a_un_amigo').live('pageshow', function(event, ui) {
    var parent = $('#envia_a_un_amigo');
    parent.find('a.borrar').off('click').on("click", function(){
        document.getElementById("form_envia_amigo").reset();
    });
    
    parent.find('a.enviar').off('click').on("click", function(){
        enviarAmigo();
    });
});

//Horarios
$(document).on('pageinit', "#horarios", function(){
   getHorarios(1);
});

//FORMULARIO CONTACTO
$('#formulario_contacto').live('pageshow', function(event, ui) {
    var parent = $('#formulario_contacto');
    
    parent.find('a.enviar').off('click').on("click", function(){
        enviarContacto();
    });
});

//Categoria vinos
$(document).on('pageinit', "#categoria_vinos", function(){
   getCategoriaVinos();
});
//Cambios a ingle o spanish el titulo de la page
$( '#categoria_vinos' ).live( 'pagebeforeshow',function(event){
    //controlamos el idioma en el cual deberia estar el plato
    if(IDIOMA == "esp"){
        $("#categoria_vinos h1").html(nuetros_vinos_esp);
    }else if(IDIOMA == "eng"){
        $("#categoria_vinos h1").html(nuetros_vinos_eng);
    }
});

//Lista vinos de una categoria especifica
$('#vinos_x_categoria').live('pagebeforeshow', function(event, ui) {
    var id = getUrlVars()["id"];
    $.getJSON(serviceURL + 'get_vinos.php?id='+id, showVinos);
});

//La Carta - Menu
$('#menu_grupos').live('pagebeforeshow', function(event, ui) {
    var element = $(this).find(".content_lista_galeria").find("a");
    element.removeClass("selected");
    element.unbind("click");
	element.click(function(){
	   element.removeClass("selected");
       $(this).addClass("selected");
	});
});

//Lista menus de una categoria especifica
$('#menu_grupos_detail').live('pagebeforeshow', function(event, ui) {
    var href;
    var categoria_menu = $(ui.prevPage).find(".content_lista_galeria").find("a.selected");
    if(categoria_menu.context == undefined){
        href = "#menu_grupos_detail?categoria_menu=eventos";
    }else{
        href = categoria_menu.attr("href");
    }
    categoria_menu = getUrl(href)["categoria_menu"];
    $.getJSON(serviceURL + 'get_menus.php?categoria_menu='+categoria_menu, showMenusGrupos);
});

//Galerias detalle
$('#galeria_detalle').live('pagebeforeshow', function(event, ui) {
    var id = getUrlVars()["id"];
    $.getJSON(serviceURL + 'get_foto.php?id='+id, showFoto);
});

//Localizacion
$('#localizacion').live('pagebeforeshow', function(event, ui) {
    getLocalizacion();
});


/************************************ FUNCTIONS *******************************************************/

//Obtiene el ultimo post de las terrazas
function getLasTerrazas() {
	$.getJSON(serviceURL + 'get_laterraza.php', function(data) {
	    //mostramos loading
        $.mobile.loading( 'show' );
        
		var la_terraza = data.item;
        $('#las_terrazas img').attr('src', BASE_URL + 'img/fotos/' + la_terraza.url);
        $('#las_terrazas').find(".text").html(htmlspecialchars_decode(la_terraza.descripcion));
        
        $('#las_terrazas img').load(function(){
            //ocultamos loading
            $.mobile.loading( 'hide' );
        });
	});
}	

//Obtiene el menu diario
function getMenuDiario() {
	$.getJSON(serviceURL + 'get_menudiario.php', function(data) {
        if(data.item){
            
    	    //mostramos loading
            $.mobile.loading( 'show' );
    		var menu_diario = data.item;
            
            $('#menu_dia h2').html(menu_diario.dia_spanish);
            if(menu_diario.tipo_menu == "diario"){
                $('#menu_dia').find("h1").show();
                $('#menu_dia').find(".primeros").html(htmlspecialchars_decode(menu_diario.primeros)).prev().show();
                $('#menu_dia').find(".segundos").html(htmlspecialchars_decode(menu_diario.segundos)).prev().show();
                $('#menu_dia').find(".precio_descripcion span").text(menu_diario.precio_descripcion).parent().show();
                $('#menu_dia').find(".diario .dia").html(menu_diario.dia_spanish + " " + menu_diario.dia_numerico);
                $('#menu_dia').find(".diario .mes").html(menu_diario.mes_spanish).parent().show();
            }else if(menu_diario.tipo_menu == "festivo"){
                $('#menu_dia').find("h1").html("Festivo").show();
                $('#menu_dia').find(".primeros").html(htmlspecialchars_decode(menu_diario.especialidades));
                $('#menu_dia').find(".festivo .dia").html(menu_diario.dia_spanish + " " + menu_diario.dia_numerico);
                $('#menu_dia').find(".festivo .mes").html(menu_diario.mes_spanish).parent().show();
            }
            
            $('#menu_dia').find(".primeros").promise().done(function() {
                //ocultamos loading
                $.mobile.loading( 'hide' );
            });
        }
	});
}

//Obtiene la galeria de fotos(Restaurante|La Carta)
function getGaleriaFoto(galeria) {
    var parent;
    var galeria_id;
    
    //Enviamos su id de la galeria
    if(galeria == "restaurante"){
        parent = $("#galeria_restaurante");
        galeria_id = 3;
    }else if(galeria == "la_carta"){
        parent = $("#galeria_la_carta");
        galeria_id = 4;
    }
	$.getJSON(serviceURL + 'get_galeria.php?galeria_id='+galeria_id, function (data) {
	    if(data.items){
	       
            //mostramos loading
            $.mobile.loading( 'show' );
        	var fotos = data.items;
            parent.find("li").remove();
        	$.each(fotos, function(index, foto) {
        		parent.find(".content_lista_fotos").find("ul").append('<li><a href="galeria_detalle.html?id=' + foto.id + '"><img src="'+BASE_URL+'img/fotos/thumbnails/'+foto.url+'"/></a></li>');
        	});
            
            parent.find(".content_lista_fotos").find("ul").promise().done(function() {
                $(this).find("li:last img").load(function(){
                    //ocultamos loading
                    $.mobile.loading( 'hide' );
                });
            });
	    }
	});
}

//Carga el plato que se selecciono de la carta
function loadPlato(data) {
    
    //mostramos loading
    $.mobile.loading( 'show' );
    
    //controlamos el idioma en el cual deberia estar el plato
    if(IDIOMA == "esp"){
        $("#la_carta_detail h1").html(NUESTRA_CARTA_esp);
    }else if(IDIOMA == "eng"){
        $("#la_carta_detail h1").html(NUESTRA_CARTA_eng);
    }
    
	var platos = data.items;
    var tipo_plato = data.tipo_plato;
    var tipo_plato_text = data.tipo_plato_text;
    
    var texto_comida_rapida = "";
    
    $('#la_carta_detail h3').removeClass();
    $('#la_carta_detail h3').addClass("page_custom");
    $('#la_carta_detail h3').addClass(tipo_plato);
    
    if(IDIOMA == "esp"){
        $('#la_carta_detail h3').text(tipo_plato_text);
    }else if(IDIOMA == "eng"){
        if(tipo_plato == "entrante"){
            tipo_plato_text = ENTRANTES_eng;
        }
        if(tipo_plato == "primero"){
            tipo_plato_text = PRIMEROS_eng;
        }
        if(tipo_plato == "pescado"){
            tipo_plato_text = PESCADOS_eng;
        }
        if(tipo_plato == "asado_carne"){
            tipo_plato_text = ASADOS_eng;
        }
        if(tipo_plato == "comida_para_llevar"){
            tipo_plato_text = COMIDA_eng;
        }
        $("#la_carta_detail h3").html(tipo_plato_text);
    }
    
   if(tipo_plato == "comida_para_llevar"){
        if(IDIOMA == "esp"){
            texto_comida_rapida = "<span class='pedidos_text'> (Los pedidos son v&iacute;a telef&oacute;nica <b>91-853-8002</b>) </span>";
        }else if(IDIOMA == "eng"){
            texto_comida_rapida = "<span class='pedidos_text'> (Telephone orders are <b>91-853-8002</b>) </span>";
        }
        
        $("#la_carta_detail h3").after(texto_comida_rapida);
   }
    
	$.each(platos, function(index, plato) {
	    var nombre = "";
        var descripcion = "";
        var html = "";
        //controlamos el idioma en el cual deberia estar el plato
        if(IDIOMA == "esp"){
            nombre = plato.nombre;
            descripcion = plato.descripcion;
        }else if(IDIOMA == "eng"){
            nombre = plato.nombre_eng;
            descripcion = plato.descripcion_eng;
        }	   
	   html += htmlspecialchars_decode(nombre);
       if($.trim(plato.descripcion) != ""){
            html += "<span class='info_plato'>" + " (" + htmlspecialchars_decode(descripcion) + ") " + "</span>";
       }
       //append plato
       $("#la_carta_detail").find(".lista_platos").append("<li><h2>"+html+"<span class='precio'>"+plato.precio+" &euro;</span></h2></li>");
       
	});
    
    $("#la_carta_detail").find(".lista_platos").promise().done(function() {
        //ocultamos loading
        $.mobile.loading( 'hide' );
    });
    
}

//Carga el plato que se selecciono de la carta
function getNovedades() {
	$.getJSON(serviceURL + 'get_novedades.php', function(data) {
		$('#lista_novedades li').remove();
        
        if(data.items){
            //mostramos loading
            $.mobile.loading( 'show' );
                    
    		novedades = data.items;
    		$.each(novedades, function(index, novedad) {
    			$('#lista_novedades').append('<li><a href="novedad_detalle.html?id=' + novedad.id + '">' +
    					'<img src="'+BASE_URL+'img/novedades/thumbnails/' + novedad.imagen + '"/>' +
    					'<h3 class="ui-li-heading">' + novedad.nombre + '</h3>' +
    					'<b>' + novedad.fecha + '</b>' +
    					'<p class="ui-li-desc">' + htmlspecialchars_decode(novedad.descripcion_cut) + '</p></a></li>');
    		});
    		$('#lista_novedades').listview('refresh');
            
            $('#lista_novedades').find("li:last img").load(function() {
                //ocultamos loading
                $.mobile.loading( 'hide' );
            });
        }
	});
}
//Carga la novedad que se selecciono de las novedades
function showNovedad(data) {
    if(data.item){
        
        //mostramos loading
        $.mobile.loading( 'show' );
    	var novedad = data.item;
        $('#novedad_detalle img').attr('src', BASE_URL + 'img/novedades/' + novedad.imagen);
        $('#novedad_detalle').find("h2").html(htmlspecialchars_decode(novedad.nombre));
        $('#novedad_detalle').find(".descripcion").html(htmlspecialchars_decode(novedad.descripcion));
        
        $('#novedad_detalle').find("img").load(function(){
            //ocultamos loading
            $.mobile.loading( 'hide' );
        });
    }
}

//Enviamos un mail a un amigo
function enviarAmigo(){
    var nombre = $.trim($("#form_envia_amigo").find("input#form_nombre").val());
    var email = $.trim($("#form_envia_amigo").find("input#form_email").val());
    var comentario = $.trim($("#form_envia_amigo").find("textarea").val());
    
    if(nombre !="" && email !="" && comentario !=""){
        if(valEmail(email)){
            $(".ui-loader").show();
            $("#form_envia_amigo").find("textarea").val(comentario + "\n\t");
            $.post(serviceURL + 'enviar_amigo.php', $("#form_envia_amigo").serialize()).done(function(data) {
                $(".ui-loader").hide();
                document.getElementById("form_envia_amigo").reset();
                alert(data);
            });
        }else{
            alert("El email: " + email + ", no es correcto!!!!, por favor ingrese un email valido");
        }        
    }else{
        alert("Por favor ingrese todos los datos!!!.");
    }
}

//Enviamos el contacto
function enviarContacto(){
    var nombre = $.trim($("#form_contact").find("input#form_nombre").val());
    var telefono = $.trim($("#form_contact").find("input#form_telefono").val());
    var email = $.trim($("#form_contact").find("input#form_email").val());
    var comentario = $.trim($("#form_contact").find("textarea").val());
    
    if(nombre !="" && email !="" && comentario !=""){
        if(valEmail(email)){
            $(".ui-loader").show();
            $.post(serviceURL + 'enviar_contacto.php', $("#form_contact").serialize()).done(function(data) {
                $(".ui-loader").hide();
                document.getElementById("form_contact").reset();
                alert(data);
            });
        }else{
            alert("El email: " + email + ", no es correcto!!!!, por favor ingrese un email valido.");
        }
    }else{
        alert("Por favor ingrese todos los campos obligatorios!.");
    }
}

//Obtiene el restaurant terrazas
function getHorarios(restaurant_id) {
	$.getJSON(serviceURL + 'get_restaurant.php?restaurant_id='+restaurant_id, function (data) {
        if(data.item){
            
            //mostramos loading
            $.mobile.loading( 'show' );
            
    		var restaurant = data.item;
            $('#horarios').find(".hora.lunes").text(restaurant.horario.lunes);
            $('#horarios').find(".hora.martes").text(restaurant.horario.martes);
            $('#horarios').find(".hora.miercoles").text(restaurant.horario.miercoles);
            $('#horarios').find(".hora.jueves").text(restaurant.horario.jueves);
            $('#horarios').find(".hora.viernes").text(restaurant.horario.viernes);
            $('#horarios').find(".hora.sabado").text(restaurant.horario.sabado);
            $('#horarios').find(".hora.domingo").text(restaurant.horario.domingo);
            
            $('#horarios').find(".hora.domingo").promise().done(function() {
                //ocultamos loading
                $.mobile.loading( 'hide' );
            });
        }
	});
}

//Carga la lista de las categorias de los vinos que existen
function getCategoriaVinos() {
    //controlamos el idioma en el cual deberia estar el plato
    if(IDIOMA == "esp"){
        $("#categoria_vinos h1").html(nuetros_vinos_esp);
    }else if(IDIOMA == "eng"){
        $("#categoria_vinos h1").html(nuetros_vinos_eng);
    }
	$.getJSON(serviceURL + 'get_categoria_vinos.php', function(data) {
	    if(data.items){
	       
            //mostramos loading
            $.mobile.loading( 'show' );
           
    		categoria_vinos = data.items;
    		$.each(categoria_vinos, function(index, categoria_vino) {
    		  
                var clone = $('#categoria_vinos #categorias').find('a:first').clone(true);
                clone.attr("href", "lista_vinos.html?id=" + categoria_vino.id);
                clone.find(".ui-btn-text").html(htmlspecialchars_decode(categoria_vino.nombre));
                clone.css("display", "block");
                
                $('#categoria_vinos #categorias').find(".ui-controlgroup-controls").append(clone);
    		});
            
            $('#categoria_vinos #categorias').find(".ui-controlgroup-controls").promise().done(function() {
                //ocultamos loading
                $.mobile.loading( 'hide' );
            });
	    }
	});
}

//Carga los vinos de una categoria
function showVinos(data) {
    
    //mostramos loading
    $.mobile.loading( 'show' );
    
    var categoria_nombre = data.categoria_nombre;
	var vinos = data.items;
    var clase = data.clase;
    $("#vinos_x_categoria").find("h1").removeClass();
    $("#vinos_x_categoria").find("h1").addClass("page_custom").addClass(clase)
    $("#vinos_x_categoria").find("h1").html(htmlspecialchars_decode(categoria_nombre));
    
    $.each(vinos, function(index, vino) {
        $("#vinos_x_categoria").find(".lista_vinos").append("<li><h2>"+htmlspecialchars_decode(vino.nombre)+"<span>"+vino.precio+" &euro;</span></h2></li>");
    });
    
    $("#vinos_x_categoria").find(".lista_vinos").promise().done(function() {
        //ocultamos loading
        $.mobile.loading( 'hide' );
    });
}
//Carga los menus de una categoria
function showMenusGrupos(data) {
    var categoria_nombre = data.categoria_nombre;
    var menus = data.items;
    $("#menu_grupos_detail").find("h1").html(categoria_nombre);
	
    //reseteamos la lista
    $('#menu_grupos_detail .lista_menus').find("li").remove();
    if(data.items){

        //mostramos loading
        $.mobile.loading( 'show' );
        
        $.each(menus, function(index, menu) {
    		//$('#menu_grupos_detail .lista_menus').append('<li><h2>'+htmlspecialchars_decode(menu.nombre)+'<span>'+menu.precio+' &euro;</span></h2><div class="descripcion">'+htmlspecialchars_decode(menu.descripcion)+'</div></li>');
            $('#menu_grupos_detail .lista_menus').append('<li><h2>'+htmlspecialchars_decode(menu.nombre)+'<span>'+menu.precio+' &euro;</span></h2><div class="descripcion">'+htmlspecialchars_decode(menu.descripcion)+'</div><div class="label_descargar"><a title="" href="'+BASE_URL+'menus/forceDowload/'+menu.pdf+'?'+menu.nombre_pdf+'" onclick="window.open(this.href,\'_blank\'); return false;">Descargar PDF</a></div></li>');
    	});
        
        $('#menu_grupos_detail .lista_menus').promise().done(function() {
            //ocultamos loading
            $.mobile.loading( 'hide' );
        });
    }
}

//Carga la foto que se selecciono de las galerias de fotos
function showFoto(data) {
    if(data.item){
        //mostramos loading
        $.mobile.loading( 'show' );
        
    	var foto = data.item;
        $('#galeria_detalle img').attr('src', BASE_URL + 'img/fotos/' + foto.url);
        
        $('#galeria_detalle img').load(function(){
            //ocultamos loading
            $.mobile.loading( 'hide' );
        });
    }
}

function getLocalizacion(){
    //mostramos loading
    $(".ui-loader").show();
    $('#localizacion').find("iframe").load(function(){
        //ocultamos loading
        $(".ui-loader").hide();
    });
}