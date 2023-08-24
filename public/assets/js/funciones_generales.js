// JavaScript Document
function validarformulario(data) {
	var valida = false;
	var rules={
	}; 
	if(data.hasOwnProperty('rules')){
		$.each(data.rules, function(index, value) {
			rules[index]=value;
		});
	}
	var validator = $("#" + data.frm).validate({ 
		errorElement: "div",
		errorPlacement: function(error, element) {
			error.addClass("invalid-feedback");
			error.insertBefore(element);
			//error.insertAfter(element);
		},
		highlight: function(element) {
			$(element).addClass("form_control_valid").removeClass("form_control_invalid");
		},
		unhighlight: function(element) {
			$(element).addClass("form_control_invalid").removeClass("form_control_valid");
		},
		submitHandler: function(form) {
		  //console.log("success");
		},
		invalidHandler: function() {
			/*show_swal({
				custom:{
					icon: 'error',
					title: 'Oops...',
					text: 'Something went wrong!',
					footer: '<a href="">Why do I have this issue?</a>'
				}			
			});*/
			show_swal({
				title: "¡UPS!",
				text: "Revise los Campos marcados",
				type: "error",
			});
		},
		ignore: [],
		rules: rules,
		messages: {
			password: {
				minlength: "Su contraseña debe tener al menos 8 caracteres."
			},
			repetir_password: {
				minlength: "Su contraseña debe tener al menos 8 caracteres.",
				equalTo: "Las contraseñas deben se iguales."
			},
			correo: "Por favor, ingresa un correo electrónico válido.",
			required: "Obligatorio.",
			remote: "Por favor, rellena este campo.",
			email: "Correo inválido.",
			url: "Por favor, escribe una URL válida.",
			date: "Por favor, escribe una fecha válida.",
			number: "Número inválido.",
			digits: "Sólo dígitos.",
			equalTo: "Por favor, escribe el mismo valor de nuevo.",
			extension: "Por favor, escribe un valor con una extensión aceptada.",
			maxlength: $.validator.format("Por favor, no escribas más de {0} caracteres."),
			minlength: $.validator.format("Por favor, no escribas menos de {0} caracteres."),
			rangelength: $.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
			range: $.validator.format("Por favor, escribe un valor entre {0} y {1}."),
			max: $.validator.format("Por favor, escribe un valor menor o igual a {0}."),
			min: $.validator.format("Por favor, escribe un valor mayor o igual a {0}."),

		},
	});
	valida = validator.form();
	return {
		"validacion":valida,
		"var":validator,
	};
}
function show_swal(json_data){
	var icon="success";
	var title=json_data.title;
	var text=json_data.text;
	var showConfirmButton=true;
	var showCancelButton=false;
	var confirmButtonText="Aceptar";
	var cancelButtonText="Cancelar";
	var cancelButtonColor='#d33';
	if(json_data.hasOwnProperty("type")){
		icon=json_data.type;
	}
	if(json_data.hasOwnProperty("confirmButtonText")){
		confirmButtonText=json_data.confirmButtonText;
	}
	if(json_data.hasOwnProperty("cancelButtonText")){
		cancelButtonText=json_data.cancelButtonText;
	}
	if(json_data.hasOwnProperty("showConfirmButton")){
		showConfirmButton=json_data.showConfirmButton;
	}
	if(json_data.hasOwnProperty("showCancelButton")){
		showCancelButton=json_data.showCancelButton;
		if(json_data.hasOwnProperty("cancelButtonColor")){
			cancelButtonColor=json_data.cancelButtonColor;
		}
	}
	if(json_data.hasOwnProperty("custom")){
		Swal.fire(
			json_data.custom
		);
	}
	else{
		Swal.fire({
			title:title,
			text:text,
			icon:icon,
			showConfirmButton:showConfirmButton,
			showCancelButton:showCancelButton,
			confirmButtonText:confirmButtonText,
			cancelButtonText:cancelButtonText,
			//confirmButtonColor: '#3085d6',
			cancelButtonColor:cancelButtonColor,
		}).then((result) => {
			if (result.isConfirmed) {
				if(json_data.hasOwnProperty("aceptar")){
					json_data.aceptar();
				}
			}
			else{
				if(json_data.hasOwnProperty("cancelar")){
					json_data.cancelar();
				}
			}
		});
	}
}
function muestra_error_ajax(div, error) {
	console.log(error);
	$(div).html('<div class="alert alert-warning" role="alert">Ha ocurrido un error, intente nuevamenrte</div>');
}
function accion_registros(json_datos){
	var accion="Guardar";// por default va a guardar
	var valida_frm=true;//pordefult va validado true si no hay que validar
	var swalTitle='¿Está seguro(a) de guardar los datos?';
	var swalText='Recuerde que debe ingresar todos los campos solicitados.';
	var swalTitleSuccess='¡Se han guardado los datos!';
	var text_e_validatos="Rellene toda la información solicitada";
	if(json_datos.accion!=undefined && json_datos.accion!=""){
		accion=json_datos.accion;
	}
	if(accion=="Guardar"){
		if(json_datos.hasOwnProperty('validaciones')){
			valida_frm=json_datos.validaciones();
			if(!valida_frm){
				if(json_datos.hasOwnProperty('funcion_error_validacion')){
					json_datos.funcion_error_validacion();
				}
				else{
					if(json_datos.hasOwnProperty('Text_error_validator')){
						text_e_validatos=json_datos.Text_error_validator;
					}
					show_swal({
						title: "¡UPS!",
						text: text_e_validatos,
						type: "error",
					});
				}
					
			}
		}
		if(json_datos.frm!=undefined && json_datos.frm!="" && valida_frm){
			valida_frm=validarformulario({
				frm:json_datos.frm,
				rules:json_datos.rules
			}).validacion;
		}
	}
	if(accion=="Otro" || accion=="otro"){
		mensajes=json_datos.mensajes;
		///copie y pegue por si se necesita hacer algo diferente en cada accion
		if(json_datos.hasOwnProperty('validaciones')){
			valida_frm=json_datos.validaciones();
			if(!valida_frm){
				if(json_datos.hasOwnProperty('funcion_error_validacion')){
					json_datos.funcion_error_validacion();
				}
				else{
					if(json_datos.hasOwnProperty('Text_error_validator')){
						text_e_validatos=json_datos.Text_error_validator;
					}
					show_swal({
						title: "¡UPS!",
						text: text_e_validatos,
						type: "error",
					});
				}
					
			}
		}
		if(json_datos.validar && json_datos.frm!=undefined && json_datos.frm!="" && valida_frm){
			valida_frm=validarformulario({
				frm:json_datos.frm,
				rules:json_datos.rules
			}).validacion;
		}
	}
	if(accion=="Eliminar" || accion=="eliminar"){
		swalTitle='¿Está seguro(a) de eliminar el registro?';
		swalText='Esta acción no se puede deshacer';
		swalTitleSuccess='¡Se ha eliminado el registro!';
		///copie y pegue por si se necesita hacer algo diferente en cada accion
		if(json_datos.hasOwnProperty('validaciones')){
			valida_frm=json_datos.validaciones();
			if(!valida_frm){
				if(json_datos.hasOwnProperty('funcion_error_validacion')){
					json_datos.funcion_error_validacion();
				}
				else{
					if(json_datos.hasOwnProperty('Text_error_validator')){
						text_e_validatos=json_datos.Text_error_validator;
					}
					show_swal({
						title: "¡UPS!",
						text: text_e_validatos,
						type: "error",
					});
					
				}
					
			}
		}
		if(json_datos.frm!=undefined && json_datos.frm!="" && valida_frm){
			valida_frm=validarformulario({
				frm:json_datos.frm,
				rules:json_datos.rules
			}).validacion;
		}
	}
	if(json_datos.hasOwnProperty("mensajes")){
		if(json_datos.mensajes.hasOwnProperty("swalTitle")){
			swalTitle=json_datos.mensajes.swalTitle;
		}
		if(json_datos.mensajes.hasOwnProperty("swalText")){
			swalText=json_datos.mensajes.swalText;
		}
		if(json_datos.mensajes.hasOwnProperty("swalTitleSuccess")){
			swalTitleSuccess=json_datos.mensajes.swalTitleSuccess;
		}
		
	}
	var mensajes={
		swalTitle:swalTitle,
		swalText:swalText,
		swalTitleSuccess:swalTitleSuccess,
	};
	if(valida_frm){
		show_swal({
			title:mensajes.swalTitle,
			text:mensajes.swalText,
			type:"question",
			showCancelButton:true,
			confirmButtonText: 'Sí',
			cancelButtonText: 'No',
			aceptar:function(){
				///mandar ajax
				mandar_ajax({
					ruta:json_datos.ruta,
					data:json_datos.data,
					btn:json_datos.btn,
					success:function(res){
						if(res.respuesta==1){
							show_swal({
								title: ""+mensajes.swalTitleSuccess,
								text: "",
								type: 'success',
								aceptar:function(){
									if(json_datos.hasOwnProperty('success')){
										json_datos.success(res);
									}
								}
							});
						}
						else{
							show_swal({
								title: '¡UPS!',
								text: ''+res.mensaje,
								type: 'error',
							});
							
							if(json_datos.hasOwnProperty('error')){
								json_datos.error();
							}
						}
					},
				});
			},
			cancelar:function(){
				//console.log("no");
			}
		});
		
	}
	else{
		if(json_datos.hasOwnProperty('error')){
			json_datos.error();
		}
	}
}
function mandar_ajax(json_datos){
	var validado=true;
	var dataType='json'
	var time=1500;
	var set_time=true;
	var btn=$("");
	if(json_datos.hasOwnProperty("btn")){
		btn=json_datos.btn;
	}
	if(json_datos.hasOwnProperty("dataType")){
		dataType=json_datos.dataType;
	}
	if(json_datos.hasOwnProperty("set_time")){
		set_time=json_datos.set_time;
		if(json_datos.hasOwnProperty("time")){
			time=json_datos.time;
		}
	}
	if(json_datos.validar){
		if(json_datos.hasOwnProperty('frm') && json_datos.frm!=""){
			validado=validarformulario(json_datos.frm).validacion;
		}
		else{
			console.log("Error de validacion de frm");
		}
	}
	if(validado){
		btn.prop("disabled",true);
		if(json_datos.hasOwnProperty("cargando")){
			if(json_datos.cargando.hasOwnProperty("id_element")){
				var loader="bar-loader";
				if(json_datos.cargando.hasOwnProperty('loader')){
					loader=json_datos.cargando.loader;
				}
				$(json_datos.cargando.id_element).html(set_loader(loader));
			}
		}
		$.ajax({
			type: 'POST',
			url: json_datos.ruta,
			data: json_datos.data,
			cache: false,
			contentType: false,
			processData: false,
			dataType: dataType,
			success: function(res) {
				if(set_time){
					setTimeout(function(){
						btn.prop("disabled",false);
						if(json_datos.hasOwnProperty('success')){
							json_datos.success(res);
						}	
					},time);
				}
				else{
					btn.prop("disabled",false);
					if(json_datos.hasOwnProperty('success')){
						json_datos.success(res);
					}	
				}
			}
		}).fail( function( jqXHR, textStatus, errorThrown ) {
			btn.prop("disabled",false);
			if(json_datos.hasOwnProperty('error')){
				json_datos.error(errorThrown);
			}
			else{
				setTimeout(function() {
					muestra_error_ajax('#'+json_datos.div_error, errorThrown);
					console.log(jqXHR);
					if(jqXHR.status==422){
						var res=jqXHR.responseJSON.errors;
						var mensaje="";
						$.each( res, function( key, error ) {
							mensaje+=error[0]+"\n";
						});
						show_swal({
							title: '¡UPS!',
							text: "Ha ocurrido un error\n"+mensaje,
							type: 'error',
							confirmButtonText: 'Aceptar',
							closeOnConfirm: true,
						});
						json_datos.btn.prop("disabled",false);
					}
					if(jqXHR.status==404){
						show_swal({
							title: '¡UPS!',
							text: "No se ha encontrado la ruta especifica",
							type: 'error',
							confirmButtonText: 'Aceptar',
							closeOnConfirm: true,
						});
						json_datos.btn.prop("disabled",false);
					}
					else{
						show_swal({
							title: '¡UPS!',
							text: "Ha ocurrido un error",
							type: 'error',
							confirmButtonText: 'Aceptar',
							closeOnConfirm: true,
						});
						json_datos.btn.prop("disabled",false);
					}
					
				}, 1500);
			}
		});
	}
	else{
		if(json_datos.hasOwnProperty('error')){
			json_datos.error();
		}
	}
}
var Tabla_Idioma = {
	"decimal": "",
	"emptyTable": "No hay información",
	"info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
	"infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
	"infoFiltered": "(Filtrado de _MAX_ total entradas)",
	"infoPostFix": "",
	"thousands": ",",
	"lengthMenu": "Mostrar _MENU_ Entradas",
	"loadingRecords": "Cargando...",
	"processing": "Procesando...",
	"search": "Buscar:",
	"zeroRecords": "Sin resultados encontrados",
	"paginate": {
		"first": "Primero",
		"last": "Ultimo",
		"next": "Siguiente",
		"previous": "Anterior"
	},
}
function inicia_Datatable(id_clase, ordenar) {
	client_table = $(id_clase).DataTable({
		"autoWidth": true,
		"info":true,
		"language": Tabla_Idioma,
		"aLengthMenu": [
			[5,10, 20, 50, -1],
			[5, 10,20, 50, "Todos"]
		],
		"iDisplayLength": 10,
		initComplete: function () {
			// Apply the search
			this.api().columns().every( function () {
				var that = this;
				$( 'input[type=text]', this.footer() ).on( 'keyup change clear', function () {
					if ( that.search() !== this.value ) {
						that.search( this.value ).draw();
					}
				} );
			} );
		},
		
	});
	
	//console.log(client_table.order);
}
function set_loader(type){
	//type mandamos un numero o una clase
	if(type!="bar" && type!="" && type!=undefined){
		var clase="dotted";
		if(type==1 || type=="dashed"){
			clase="dashed";
		}
		if(type==2 || type=="double"){
			clase="double";
		}
		if(type==3 || type=="groove"){
			clase="groove";
		}
		if(type==4 || type=="ridge"){
			clase="ridge";
		}
		loader="<span class='rotate "+clase+"'></span>"
	}
	else{
		return"<div class='loader-box d-flex justify-content-center'><div class='loader'><div class='line bg-primary'></div><div class='line bg-primary'></div><div class='line bg-primary'></div><div class='line bg-primary'></div></div></div>";
	}
	
	return "<div class='loader-box d-flex justify-content-center'>"+loader+"</div>";
}
function getModal(cfgModal) {
	var backdrop_value='static';
	var loader='bar';
    //$(cfgModal.idContent).html('');
    $(cfgModal.idContent).removeClass("modal-sm modal-lg modal-md");
    $(cfgModal.idContent).addClass(cfgModal.size);
	if(cfgModal.backdrop!=undefined && cfgModal.backdrop!=""){
		backdrop_value=cfgModal.backdrop;
	}
	if(cfgModal.hasOwnProperty('loader')){
		loader=cfgModal.loader;
	}
	var cargando=set_loader(loader);
	$(cfgModal.idContent).html("<div class='modal-content'><div class='modal-header'><h5 id='h_title_cargando_modal_modal' class='modal-title'>cargando...</h5><button style='display: none;' id='div_btn_cerrar_modal_modal' type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span> </button></div><div class='modal-body' id='div_modal_cargando_modal'>"+cargando+"</div><div style='display: none;' class='modal-footer' id='div_btn_cerrar_modal_modal2'><button type='button' id='btnCerrarMdl' class='btn btn-secondary' data-dismiss='modal'>Cerrar</button></div>");
    $(cfgModal.idModal).modal({
      keyboard: false,
      backdrop:backdrop_value,
      show:true
    });
    try {
		mandar_ajax({
			ruta:cfgModal.url,
			data:cfgModal.data,
			dataType:"HTML",
			success: function (res){
				$(cfgModal.idContent).html(res);
				$(cfgModal.idModal).modal({
					show:true,
				});
				if(cfgModal.hasOwnProperty('ini_modal')){
					cfgModal.ini_modal();
				}
			}
		});
    } catch (error) {
      console.log(error);
    }
}
let myDropzone;
function iniciarDropzone(data) {
    //console.log(data);
    myDropzone = new Dropzone("#" + data.idDropzone, {
        paramName: data.idInputFile, // The name that will be used to transfer the file
        maxFilesize: 50, // MB
        addRemoveLinks: true,
        autoProcessQueue: false,
        url: data.urlFake,
        uploadMultiple: false,
        //parallelUploads: 5,
        maxFiles: (data.maxFiles > 0) ? data.maxFiles : 1,
        //previewTemplate: document.getElementById('template-preview').innerHTML,
        //clickable: true,
        acceptedFiles: data.archivosPermitidos,
        // Language Strings
        dictFileTooBig: "Archivo muy grande ({{filesize}}mb). El maximo peso admitido es de {{maxFilesize}}mb",
        dictInvalidFileType: "Extension no permitida",
        dictCancelUpload: "Cancelar",
        dictRemoveFile: "Eliminar",
        dictMaxFilesExceeded: "Solo {{maxFiles}} archivos son permitidos.",
        accept: function(file, done) {
            if (file.name == "justinbieber.jpg") {
                done("Naha, you don't.");
            } else {
                done();
                $('.dz-progress').hide();
            }
        },
        /*ELIMINAMOS ARCHIVOS*/
        removedfile: function(file) {
            if (file.idA > 0) {
                show_swal({
					title: "¿Esta seguro que desea eliminar archivo " + file.name + "?",
					text: "",
					type:"question",
					showCancelButton:true,
					confirmButtonText: 'Sí',
					cancelButtonText: 'No',
					aceptar:function(){
						///mandar ajax
                        var formData = new FormData();
                        formData.append('id', file.idA);
                        //formData.append('tipo', file.tipo);
                        //formData.append('name', file.name);
                        //formData.append('ruta', file.ruta);
						mandar_ajax({
							ruta:urls.removeImage,
							data:formData,
							btn:$(".dz-remove"),
							success:function(res){
								if(res.respuesta==1){
									//alert("asasdasdsad");
									var _ref;
									(_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
									//confirmSwal("Se elimino documento " + file.name + " correctamente", "success");
								}
								else{
									console.log("No se pudo eliminar documento " + file.name, "error");
								}
							},
						});
					},
					cancelar:function(){
						//console.log("no");
					}
				});
            } else {
                //alert("asdasd");
                var _ref;
                (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
            }
        },
        /*OBTENEMOS FILES EN EDITAR*/
        init: function() {
            let thisDropzone = this;
            // console.log("entre antes");
            if ((data.urlObtener != '' && data.modulo == 'M')) {
				mandar_ajax({
					ruta:data.urlObtener,
					data:data.formData,
					set_time:false,
					success: function(response) {
						$.each(response, function(key, value) {
							var mockFile = {
                                name: value.name,
                                tipo: value.tipo,
                                size: value.size,
                                idA: value.idA,
                                ruta: value.ruta,
                                rutaStorage: value.rutaStorage,
                                // required if using 'MaxFiles' option
							};
                            thisDropzone.files.push(mockFile); // add to files array
                            thisDropzone.emit("addedfile", mockFile);
                            thisDropzone.emit("thumbnail", mockFile, value.server);
                            thisDropzone.emit("complete", mockFile);
                        });
                    },
				});
            }
        },
        error: function(file, message) {
            show_swal({
				title: "¡UPS, Error al cargar imágenes!",
				text: ""+message,
				type: "error",
			});
            try {
                var _ref;
                (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
            } catch (error) {}
        },
        //change the previewTemplate to use Bootstrap progress bars
    });
    myDropzone.on("addedfile", function(file) {
        /*if (this.files.length > 1) {
          this.removeFile(this.files[1]);
         }*/
        file.previewElement.addEventListener("click", function() {
            if (file.ruta != "" && file.ruta != "undefined" && file.ruta != null) {
                console.log(file.ruta);
                var f = window.open(file.ruta, "_blank");
            }
        });
    });
}
function eliminar_reg(id){
    var datos= new FormData();
    datos.append("id_reg",id);
    accion_registros({
        accion:"Eliminar",
        btn:$("btnDelete_"+id),
        data:datos,
        ruta:urls.eliminar,
        success:function(){
            location.reload(true);
        },
        /*validaciones: function(){
            return true;
        },*/
    });
}
$(document).ready(function() {
	$("#btnNew").click(function (){
        $(location).attr('href',urls.nuevo);
    });
	$("#btnRegresar").click(function () {
        $(location).attr('href',urls.listado);
    });
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
    });
	$(".telefono").inputmask({
        "mask": "(999) 999-9999"
    });
	$('.letras').on('input', function() {
        //console.log(this.value);
        this.value = this.value.replace(/[^A-Z]/g, '');
    });
	$(".correo").inputmask({
		'alias':"email",
	});
	//$(".selectpicker").selectpicker();
});