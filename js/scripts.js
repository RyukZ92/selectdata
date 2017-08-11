$(function(){
    
    
    $('.solo-numero-entero').keypress(function(tecla) {
        if(tecla.charCode > 47 
                && tecla.charCode < 58 
                || tecla.charCode == 0
                || tecla.charCode == 32) 
                return true;
            else 
                return false;
    });
    $('.numero-entero-y-punto').keypress(function(tecla) {
        if(tecla.charCode > 47 
                && tecla.charCode < 58 
                || tecla.charCode == 0
                || tecla.charCode == 32
                || tecla.charCode == 46) 
                return true;
            else 
                return false;
    });
    
    $('.solo-albabeto-espaniol-con-espacio').keypress(function(tecla) {
            if((tecla.charCode > 47
                    && tecla.charCode < 58) 
                    || (tecla.charCode > 64 
                    && tecla.charCode < 123) 
                    || tecla.charCode == 0 
                    || tecla.charCode == 32) 
                return true;
            else 
                return false;
            });
            
    $('.alfanumerico-sin-espacio').keypress(function(tecla) {
            if((tecla.charCode > 47 
                    && tecla.charCode < 58) 
                    || (tecla.charCode > 64 
                    && tecla.charCode < 123) 
                    || tecla.charCode == 0) 
                return true;
            else 
                return false;
            });
    $('.solo-letras-con-espacio-y-acentos').keypress(function(e) {
       var key = e.keyCode || e.which;
       var tecla = String.fromCharCode(key).toLowerCase();
       var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
       var especiales = "8-37-39-46";

       var tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla) == -1 && !tecla_especial){
            return false;
        }			
			
    });
    $('#filtro-postulante').on('submit','form',function(event) {
        var edadDesde = $('#edad-desde').val();
        var edadHasta = $('#edad-hasta').val();
        if (edadDesde == 0) {
            $('#edad-desde').css({'border':'1px solid #a94442'});
            $('#edad-desde').focus();
            return false;
        } else {
            $('#edad-desde').css({'border':'1px solid #cccccc'});
        }
        if (edadHasta == 0) {
            $('#edad-hasta').focus();
            $('#edad-hasta').css({'border':'1px solid #a94442'});
            return false;
        } else {
            $('#edad-hasta').css({'border':'1px solid #cccccc'});
        }
            if(edadDesde >  edadHasta ){
                $('#edad-desde').focus();
                alert("La edad inicial debe ser menor que la edad final");
                $('#edad-hasta').css({'border':'1px solid #a94442'});
                $('#edad-desde').css({'border':'1px solid #a94442'});
                return false;
            } else {
                ('#edad-hasta').css({'border':'1px solid #cccccc'});
                $('#edad-desde').css({'border':'1px solid #cccccc'});
            }
        
    });
/**
 * Validación para creación de postulante
 */
    $('.actualizar, .nuevo').on('submit','form',function(event) {
	var error = 0;
        var cj = '';
        var clave = false, email = false;
	$('.requerido').each(function(i, elem) {
            if($(elem).val() == 0){
                $(elem).css({'border':'1px solid #a94442'});
                    error++;
            } else if(elem.name == 'email') {
                email = true;
                  //alert("Estoy en Email. Valor:  " + $(elem).val());
                var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
                // Se utiliza la funcion test() nativa de JavaScript
                if (!regex.test($(elem).val().trim())) {
                    $(elem).css({'border':'1px solid #a94442'});
                        error++;
                } else {
                    $(elem).css({'border':'1px solid #cccccc'});
                }
              } else if(elem.name == 'clave') {
                  clave = true;
                  if(!validarPswd($(elem).val())) {
                      
                      $(elem).css({'border':'1px solid #a94442'});
                       $('#aviso').html('<i class="fa fa-info-circle text-danger"></i>\n\
                                    <small class="text-danger">La contrtaseña no cumple los criterios solicitados</small>');
                      error++;
                  } else {
                      
                      $('#aviso').html('');
                      $(elem).css({'border':'1px solid #cccccc'});
                }                  
              }              
            else{
                $(elem).css({'border':'1px solid #cccccc'});
            }
        });
        if(clave) {
            if($('#clave').val() != $('#clave2').val()) {
                $('#clave, #clave2').css({'border':'1px solid #a94442'});
                $('#aviso').html('<i class="fa fa-info-circle text-danger"></i>\n\
                                    <small class="text-danger">Las contraseñas no son iguales</small>');
                error++;
            } else {
                if(error == 0) {
                        $('#aviso').html('');
                    if($('#clave').val() != 0)
                        $('#clave, #clave2').css({'border':'1px solid #cccccc'});
                }
            }
        }
	if(error > 0){
            return false;
        }        
    });
$('#btn-campos-el, #btn-cancelar-el').click(function() {
   
    var camposEl = $('#experiencia-laboral');
    
    if (camposEl.css("display") == "none") {
        //alert('|Display: '+$('#btn-agregar-experiencia-laboral').css('display'));
        $('#btn-campos-el').css('display', 'none');
        camposEl.css("display", "block");        
    } else {
        $('#btn-campos-el').css('display', 'block');
        camposEl.css("display", "none");
    }
});
    $('#btn-agregar-el').click(function() {
	var error = 0;       
	$('.requerido-el').each(function(i, elem) {
            if($(elem).val() == 0) {
                $(elem).css({'border':'1px solid #a94442'});
                    error++;
            } else {
                $(elem).css({'border':'1px solid #cccccc'});
            }
        });
	if(error > 0){
            return false;
        }        
    });

/**
 * 
 * Inicio de registro dinmátimo de experiencia labotal del currículo
 */
//NOTA: "el" es abreviatura de Experiencia Laboral
var contenedor = '.lista-el';
var btnAgregar = '#btn-agregar-el';
var btnEliminar = '.btn-eliminar';
var btnEditar = '.btn-editar';
var j = $("input[name=total_el").val(); //Para saber cuantos registros totales hay en experencia laboral

/**
 * Crear en un lista el nuevo contenido de experiencia laboral
 */
$(btnAgregar).click(function() {

    var error = 0;       
    $('.requerido-el').each(function(i, elem) {
        if($(elem).val() == 0 || $(elem).val() == '') {
            $(elem).css({'border':'1px solid #a94442'});
                error++;
        } else {
            $(elem).css({'border':'1px solid #cccccc'});
        }
    });
    if(error == 0){                                    
        var idEl = $('#id_el').val();
        var empresaEl = $('#empresa_el').val();
        var cargoEl = $('#cargo_el').val();
        var anioInicio = $('#anio_inicio_el').val();
        var anioFin = $('#anio_fin_el').val();
        var mesInicio = $('#mes_inicio_el').val();
        var mesFin = $('#mes_fin_el').val();                
        var mesInicioNombre = getMesPorNombre(parseInt(mesInicio));
        var mesFinNombre = getMesPorNombre(parseInt(mesFin));    
        $('form').append("<input type='hidden' value='"+idEl+"' name='id_el_"+j+"'>");        
        $('form').append("<input type='hidden' value='"+cargoEl+"' name='cargo_el_"+j+"'>");
        $('form').append("<input type='hidden' value='"+empresaEl+"' name='empresa_el_"+j+"'>");
        $('form').append("<input type='hidden' value='"+mesInicio+"' name='mes_inicio_el_"+j+"'>");
        $('form').append("<input type='hidden' value='"+anioInicio+"' name='anio_inicio_el_"+j+"'>");
        $('form').append("<input type='hidden' value='"+mesFin+"' name='mes_fin_el_"+j+"'>");
        $('form').append("<input type='hidden' value='"+anioFin+"' name='anio_fin_el_"+j+"'>");
        //índice a seguir para registro
        $('form').append("<input type='hidden' class='form-control' name='indice_el_"+j+"' value='registrar'>");

        $('.requerido-el').each(function(i, elem) {
            //alert(elem.type);
            if(elem.type == 'select-one') {
                $(elem).val('0');
            } else {
                $(elem).val('');
            }
        });    
        //Total de campos agreagados
        $('#id_el').val('');
        $('#indice_el').val('');
            
        $("input[name=total_el").val(j);
        
        var campoHtml =  '<!--<div class="col-md-12">&nbsp;</div>-->'+
                            '<div class="col-md-12 lista-temp">'+
                            '<div class="row" style="border-bottom: 1px; border-bottom-color: #f1f1f1; border-bottom-style: solid;" >'+
                                '<div class="col-md-6"><strong>'+cargoEl+'</strong></div>'+
                                '<div class="col-md-6 text-right" >'+
                                    '<a class="fa fa-edit btn-editar" href="#" onClick="editarEl('+j+');"></a>'+
                                    '&nbsp;'+                                 
                                    '<a class="btn-eliminar" onClick="eliminarEl('+j+');" href="#" title="Eliminar">'+
                                    '<i class="fa fa-remove text-danger" ></i></a>'+
                                '</div>'+
                            '</div>'+
                            
                            '<div class="row">'+
                                '<div class="col-md-6">'+empresaEl+'</div>'+
                                '<div class="col-md-6 text-right text-muted" ><small>'+mesInicioNombre+' ' +anioInicio+' - '+mesFinNombre+' '+anioFin+'</small></div>'+
                            '</div>'+
                        '</div>';           
        $(contenedor).append(campoHtml);
        j++;
    }

});
/**
 * Eliminar contenido agregadode experiencia laboral
 */
$(contenedor).on('click', btnEliminar, function(){
    $(this).parent().parent().parent().remove();
});         
$(contenedor).on('click', btnEditar, function(){
    $(this).parent().parent().parent().remove();
});
//FIN :ecperiencia laboral

/**
 * 
 * INICIO: registro dinmátimo de formación del currículo
 */

$('#btn-campos-f, #btn-cancelar-f').click(function() {
   
    var camposF = $('#formacion');
    
    if (camposF.css("display") == "none") {
        //alert('|Display: '+$('#btn-agregar-experiencia-laboral').css('display'));
        $('#btn-campos-f').css('display', 'none');
        camposF.css("display", "block");        
    } else {
        $('#btn-campos-f').css('display', 'block');
        camposF.css("display", "none");
    }
});
    $('#btn-agregar-f').click(function() {
	var error = 0;       
	$('.requerido-f').each(function(i, elem) {
            if($(elem).val() == 0) {
                $(elem).css({'border':'1px solid #a94442'});
                    error++;
            } else {
                $(elem).css({'border':'1px solid #cccccc'});
            }
        });
	if(error > 0){
            return false;
        }        
    });
    
var contenedorF = '.lista-f';
var btnAgregarF = '#btn-agregar-f';
var btnEliminarF = '.btn-eliminar-f';
var btnEditarF = '.btn-editar-f';
var f = $("input[name=total_f").val(); //Para saber cuantos registros totales hay en experencia laboral

/**
 * Crear en un lista el nuevo contenido de formacion
 */
$(btnAgregarF).click(function() {

    var error = 0;       
    $('.requerido-f').each(function(i, elem) {
        if($(elem).val() == 0 || $(elem).val() == '') {
            $(elem).css({'border':'1px solid #a94442'});
                error++;
        } else {
            $(elem).css({'border':'1px solid #cccccc'});
        }
    });
    if(error == 0){                                    
        var idF = $('#id_f').val();
        var centroEducativoF = $('#centro_educativo_f').val();
        var nivelF = $('#nivel_f').val();
        var anioInicio = $('#anio_inicio_f').val();
        var anioFin = $('#anio_fin_f').val();
        var mesInicio = $('#mes_inicio_f').val();
        var mesFin = $('#mes_fin_f').val();                
        var mesInicioNombre = '';//getMesPorNombre(parseInt(mesInicio));
        var mesFinNombre = '';//getMesPorNombre(parseInt(mesFin));    
        $('form').append("<input type='hidden' value='"+idF+"' name='id_f_"+f+"'>");        
        $('form').append("<input type='hidden' value='"+centroEducativoF+"' name='centro_educativo_f_"+f+"'>");
        $('form').append("<input type='hidden' value='"+nivelF+"' name='nivel_f_"+f+"'>");
        //$('form').append("<input type='hidden' value='"+mesInicio+"' name='mes_inicio_f_"+j+"'>");
        $('form').append("<input type='hidden' value='"+anioInicio+"' name='anio_inicio_f_"+f+"'>");
        //$('form').append("<input type='hidden' value='"+mesFin+"' name='mes_fin_f_"+j+"'>");
        $('form').append("<input type='hidden' value='"+anioFin+"' name='anio_fin_f_"+f+"'>");
        //índice a seguir para registro
        $('form').append("<input type='hidden' class='form-control' name='indice_f_"+f+"' value='registrar'>");

        $('.requerido-f').each(function(i, elem) {
            //alert(elem.type);
            if(elem.type == 'select-one') {
                $(elem).val('0');
            } else {
                $(elem).val('');
            }
        });    
        //Total de campos agreagados
        $('#id_f').val('');
        $('#indice_f').val('');
            
        $("input[name=total_f").val(f);
        
        var campoHtml =  '<!--<div class="col-md-12">&nbsp;</div>-->'+
                            '<div class="col-md-12 lista-temp">'+
                            '<div class="row" style="border-bottom: 1px; border-bottom-color: #f1f1f1; border-bottom-style: solid;" >'+
                                '<div class="col-md-6"><strong>'+nivelF+'</strong></div>'+
                                '<div class="col-md-6 text-right" >'+
                                    '<a class="fa fa-edit btn-editar-f" href="#" onClick="editarF('+f+');"></a>'+
                                    '&nbsp;'+                                 
                                    '<a class="btn-eliminar-f" onClick="eliminarF('+f+');" href="#" title="Eliminar">'+
                                    '<i class="fa fa-remove text-danger" ></i></a>'+
                                '</div>'+
                            '</div>'+
                            
                            '<div class="row">'+
                                '<div class="col-md-6">'+centroEducativoF+'</div>'+
                                '<div class="col-md-6 text-right text-muted" ><small>'+mesInicioNombre+' ' +anioInicio+' - '+mesFinNombre+' '+anioFin+'</small></div>'+
                            '</div>'+
                        '</div>';           
        $(contenedorF).append(campoHtml);
        f++;
    }

});
/**
 * Eliminar contenido  formación
 */
$(contenedorF).on('click', btnEliminarF, function(){
    $(this).parent().parent().parent().remove();
});         
$(contenedorF).on('click', btnEditarF, function(){
    $(this).parent().parent().parent().remove();
});  



});
        
function eliminarF(id) {
    $("input[name=indice_f_"+id).val(false);
    $("input[name=eliminar_f_"+id).val('1');

}
function editarF(id) {
   $("input[name=indice_f_"+id).val(false);           
    var camposEl = $('#formacion');            
    $('#btn-campos-f').css('display', 'none');
    camposEl.css('display', 'block');        
    //alert('ID: ' + id);
    $('#indice_f').val(id);
    $('#id_f').val($("input[name=id_f_"+id).val());
    $('#nivel_f').val($("input[name=nivel_f_"+id).val());
    $('#centro_educativo_f').val($("input[name=centro_educativo_f_"+id).val());
    $('#anio_inicio_f').val($("input[name=anio_inicio_f_"+id).val());
    $('#anio_fin_f').val($("input[name=anio_fin_f_"+id).val());
    $('#mes_inicio_f').val($("input[name=mes_inicio_f_"+id).val());
    $('#mes_fin_f').val($("input[name=mes_fin_f_"+id).val());

}
function cancelarF() {
    var id = $('#id_f').val();
    var indice = $('#indice_f').val();
    var j = indice;
    $("input[name=indice_f_"+indice).val('registrar');           
    $('#btn-campos-f').css('display', 'block');
   //alert('indice: '+ j + "\nid: " + id)
    var idF = $('#id_f').val();
    var centroEducativoF = $('#centro_educativo_f').val();
    var nivelF = $('#nivel_f').val();
    var anioInicio = $('#anio_inicio_f').val();
    var anioFin = $('#anio_fin_f').val();
    //var mesInicio = $('#mes_inicio_f').val();
    //var mesFin = $('#mes_fin_f').val();                
    //var mesInicioNombre = getMesPorNombre(parseInt(mesInicio));
    //var mesFinNombre = getMesPorNombre(parseInt(mesFin));    
    if(indice != '' && idF > 0)  { 
        $('form').append("<input type='hidden' value='"+idF+"' name='id_el_"+j+"'>");        
        $('form').append("<input type='hidden' value='"+nivelF+"' name='nivel_f_"+j+"'>");
        $('form').append("<input type='hidden' value='"+centroEducativoF+"' name='centro_educativo_f_"+j+"'>");
        //$('form').append("<input type='hidden' value='"+mesInicio+"' name='mes_inicio_f_"+j+"'>");
        $('form').append("<input type='hidden' value='"+anioInicio+"' name='anio_inicio_f_"+j+"'>");
        //$('form').append("<input type='hidden' value='"+mesFin+"' name='mes_fin_f_"+j+"'>");
        $('form').append("<input type='hidden' value='"+anioFin+"' name='anio_fin_f_"+j+"'>"); 
        var campoHtml = '<!--<div class="col-md-12 lista-temp">&nbsp;</div>-->'+
                        '<div class="col-md-12 lista-temp">'+
                        '<div class="row" style="border-bottom: 1px; border-bottom-color: #f1f1f1; border-bottom-style: solid;" >'+
                            '<div class="col-md-6"><strong>'+nivelF+'</strong></div>'+
                            '<div class="col-md-6 text-right" >'+
                                "<a class='fa fa-edit btn-editar-f' href='#' onClick='editarF("+j+");'></a>"+
                                '&nbsp;'+                                 
                                "<a class='btn-eliminar-f' onClick='eliminarF("+j+");' href='#' title='Eliminar'>"+
                                '<i class="fa fa-remove text-danger" ></i></a>'+
                            '</div>'+
                        '</div>'+

                        '<div class="row">'+
                            '<div class="col-md-6">'+centroEducativoF+'</div>'+
                            '<div class="col-md-6 text-right text-muted" ><small> ' +anioInicio+' - '+anioFin+'</small></div>'+
                        '</div>'+
                    '</div>';
        $('.requerido-f').each(function(i, elem) {
            if(elem.type == 'select-one' && elem.name != 'nivel_f') {
                $(elem).val('0');
            } else {
                $(elem).val('');
            }
        }); 
    $('#id_f').val('');
    $('#indice_f').val('');

    $('.lista-f').append(campoHtml);
    }
}
function eliminarEl(id) {
    $("input[name=indice_el_"+id).val(false); 
    $("input[name=eliminar_el_"+id).val('1'); 
    //alert("valor: "+$("input[name=eliminar_el_"+id).val() + " ID: "+ id);
}
function editarEl(id) {
   $("input[name=indice_el_"+id).val(false);           
    var camposEl = $('#experiencia-laboral');            
    $('#btn-campos-el').css('display', 'none');
    camposEl.css('display', 'block');        

    $('#indice_el').val(id);
    $('#id_el').val($("input[name=id_el_"+id).val());
    $('#cargo_el').val($("input[name=cargo_el_"+id).val());
    $('#empresa_el').val($("input[name=empresa_el_"+id).val());
    $('#anio_inicio_el').val($("input[name=anio_inicio_el_"+id).val());
    $('#anio_fin_el').val($("input[name=anio_fin_el_"+id).val());
    $('#mes_inicio_el').val($("input[name=mes_inicio_el_"+id).val());
    $('#mes_fin_el').val($("input[name=mes_fin_el_"+id).val());

}
function cancelarEl() {
    var id = $('#id_el').val();
    var indice = $('#indice_el').val();
    var j = indice;
    $("input[name=indice_el_"+indice).val('registrar');           
    $('#btn-campos-el').css('display', 'block');

    var idEl = $('#id_el').val();
    var empresaEl = $('#empresa_el').val();
    var cargoEl = $('#cargo_el').val();
    var anioInicio = $('#anio_inicio_el').val();
    var anioFin = $('#anio_fin_el').val();
    var mesInicio = $('#mes_inicio_el').val();
    var mesFin = $('#mes_fin_el').val();                
    var mesInicioNombre = getMesPorNombre(parseInt(mesInicio));
    var mesFinNombre = getMesPorNombre(parseInt(mesFin));  

    if(indice != '' && idEl > 0)  { 
        $('form').append("<input type='hidden' value='"+idEl+"' name='id_el_"+j+"'>");        
        $('form').append("<input type='hidden' value='"+cargoEl+"' name='cargo_el_"+j+"'>");
        $('form').append("<input type='hidden' value='"+empresaEl+"' name='empresa_el_"+j+"'>");
        $('form').append("<input type='hidden' value='"+mesInicio+"' name='mes_inicio_el_"+j+"'>");
        $('form').append("<input type='hidden' value='"+anioInicio+"' name='anio_inicio_el_"+j+"'>");
        $('form').append("<input type='hidden' value='"+mesFin+"' name='mes_fin_el_"+j+"'>");
        $('form').append("<input type='hidden' value='"+anioFin+"' name='anio_fin_el_"+j+"'>"); 
        var campoHtml = '<!--<div class="col-md-12 lista-temp">&nbsp;</div>-->'+
                        '<div class="col-md-12 lista-temp">'+
                        '<div class="row" style="border-bottom: 1px; border-bottom-color: #f1f1f1; border-bottom-style: solid;" >'+
                            '<div class="col-md-6"><strong>'+cargoEl+'</strong></div>'+
                            '<div class="col-md-6 text-right" >'+
                                '<a class="fa fa-edit btn-editar" href="#" onClick="editarEl('+j+');"></a>'+
                                '&nbsp;'+                                 
                                '<a class="btn-eliminar" onClick="eliminarEl('+j+');" href="#" title="Eliminar">'+
                                '<i class="fa fa-remove text-danger" ></i></a>'+
                            '</div>'+
                        '</div>'+

                        '<div class="row">'+
                            '<div class="col-md-6">'+empresaEl+'</div>'+
                            '<div class="col-md-6 text-right text-muted" ><small>'+mesInicioNombre+' ' +anioInicio+' - '+mesFinNombre+' '+anioFin+'</small></div>'+
                        '</div>'+
                    '</div>';
        $('.requerido-el').each(function(i, elem) {
            if(elem.type == 'select-one') {
                $(elem).val('0');
            } else {
                $(elem).val('');
            }
        });

    $('#id_el').val('');
    $('#indice_el').val('');
    //alert(campoHtml);
    $('.lista-el').append(campoHtml);
    }
}


/**
 * Validación para actualización de postulante
 */
function validarCamposActualizacion(id) {
    	var error = 0;
        var cj = '';
	$('#act'+id+' .requerido').each(function(i, elem){
            if($(elem).val() == 0){
                $(elem).css({'border':'1px solid #a94442'});
                    error++;
                    cj += 'Nombre=<'+elem.name+'> | Valor=<' + $(elem).val()+'> | Error:('+error+')\n';
            }else{
                $(elem).css({'border':'1px solid #cccccc'});
            }

        });
        //alert(cj);
	if(error > 0){
            event.preventDefault();
            $('#aviso').html('<i class="icon-remove" ></i> Debe rellenar los campos requeridos <br/>');
            return false;
            } 
}
    function verificarCedulaExistente(cedula) {
        
        $.ajax({                
            url: 'ajax/verificarCedulaExistenteAjax.php',
            type: 'POST',
            data: {cedula:cedula},
            success: function(data) {
                if(data > 0) {
                    $("#msj-cedula").html("Esta cédula ya se encuestra registrada<br>");  
                    $("#msj-cedula").focus();
                    $("#btn-nuevo").attr('disabled', true);
                }else {
                    $("#msj-cedula").html(""); 
                    $("#btn-nuevo").attr('disabled', false);
                }
            }
        });       
    }
    function verificarUsuarioExistente(username, id = null) {
        $.ajax({                
            url: 'ajax/verificarUsuarioExistenteAjax.php',
            type: 'POST',
            data: {username:username, tipo:"registro"},
            success: function(data) {
                if(data > 0) {
                    $("#msj-username").html("Nombre de usuario existente en nuestros registros<br>");  
                    $("#msj-username").focus();
                    $("#btn-nuevo").attr('disabled', true);
                }else {
                    $("#msj-username").html(""); 
                    $("#btn-nuevo").attr('disabled', false);
                }
            }
        });       
    }
    function verificarEmailExistente(email, id = "") {
        $.ajax({                
            url: 'ajax/verificarEmailExistenteAjax.php',
            type: 'POST',
            data: {email:email, tipo:"actualizar", id:id},
            success: function(data) {
                if(data > 0) {
                    $("#msj-email"+id).html("Correo electrónico existente en nuestros registros<br>");  
                    $("#msj-email"+id).focus();
                    $("#btn-actualizar"+id+ ", #btn-nuevo").attr('disabled', true);
                }else {
                    $("#msj-email"+id).html(""); 
                    $("#btn-actualizar"+id+ ", #btn-nuevo").attr('disabled', false);
                }
            }
        });       
    }

function validarPswd(pswd) {
        // set password variable
        var error = 0;
        //validate the length
        if ( pswd.length < 8 ) {
            error++;
        }

        //validate letter
        if ( !pswd.match(/[A-z]/) ) {
            error++;
        }

        //validate capital letter
        if ( !pswd.match(/[A-Z]/) ) {
            error++;
        }

        //validate number
        if ( !pswd.match(/\d/) ) {
            error++;
        }
        if(error>0) {
            return false
        } else {
            return true;
        }
}
function getMesPorNombre(mes) {        
            switch(mes) {
                case 1:
                    mes =  "Enero";
                    break;
                case 2:
                    mes = "Febrero";
                    break;
                case 3:
                    mes = "Marzo";
                    break;
                case 4:
                    mes = "Abril";
                    break;
                case 5:
                    mes = "Mayo";
                    break;
                case 6:
                    mes = "Junio";
                    break;
                case 7:
                    mes = "Julio";
                    break;
                case 8:
                    mes = "Agosto";
                    break;
                case 9:
                    mes = "Septiembre";
                    break;
                case 10:
                    mes = "Octubre";
                    break;
                case 11:
                    mes = "Noviembre";
                    break;
                case 12:
                    mes = "Diciembre";
                    break;        
            }
            return mes;
        }