//para modal de articulos
/*$(window).bind('beforeunload', function(){
    return '¿Estas seguro de salir de la página actual?';
});*/
window.needreload = 0;         
/*window.onbeforeunload = function(){
    if(window.needreload==0){
        return '¿Estas seguro de salir de la página actual?';
    }
};*/


$(document).on('show.bs.modal', '.modal', function() {
    /*if ($('.modal:visible').length) { 
        $('body').addClass('modal-open');
    }*/
    $('.modal:visible').length && $(document.body).addClass('modal-open');
    //$(document).off('focusin.modal');
});
$('#myModal').on('shown.bs.modal', function() {
    $(document).off('focusin.modal');
});
$(document).on('hidden.bs.modal', '.modal', function() {
    /*if ($('.modal:visible').length) { 
        $('body').addClass('modal-open');
    }*/
    $('.modal:visible').length && $(document.body).addClass('modal-open');
    if (this.id == "myModal") {
       // document.onkeydown = '';
        $("#modalContent").html("");
    } else if (this.id == "myModal2") {
      //  document.onkeydown = '';
        $("#modalContent2").html("");
    }
});
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    /*PREVENIR ENTER EN EL FORM*/
    $("input,select").keypress(function(e) {
        if (e.which == 13) {
            return false;
        }
    });
    window.addEventListener("keydown", function(e) {
        if ([ /*"Space",*/ "ArrowUp", "ArrowDown", /*"ArrowLeft", "ArrowRight"*/].indexOf(e.code) > -1) {
            e.preventDefault();
        }
    }, false);
    $("input,textarea").keypress(function(e) {
        if (e.which == 39) {
            return false;
        } else if (e.which == 34) {
            return false;
        } else if (e.which == 34) {
            return false;
        } else if (e.which == 38) {
            return false;
        } else if (e.which == 124) {
            return false;
        } else if (e.which == 92) {
            return false;
        }
      
    });
    iniciarFechas(".fechas");
    iniciarHoras(".horas");
    iniciarDecimal(".decimal");
    iniciarNumero(".numero");
    iniciarTelefono();
    iniciarDataTable('.tbl-basic');
    iniciarSelect2();

    //funciones para clave especial
    $("#aClaveEspecial").click(function (e) { 
        e.preventDefault();
        var formData = new FormData();
        var cfgModal = {
            url: urlGen.modalClaveEspecial,
            formData: formData,
            type: 'POST',
            idCargando: '#divCargando',
            divContent: '#modalContent',
            idModal: '#myModal',
            size: 'modal-md'
        };
        getModal(cfgModal);     
    });

});
//FUNCIONES ACTUALIZADAS
function initTelefono(id) {
    $(id).inputmask({
        "mask": "(999) 999-9999"
    });
}

function initSelect2(id,modal=false,nivel=1) {
 if(modal){
     if(nivel==1){
        $(id).select2({
            dropdownParent: $('#myModal .modal-content')
        });
     }else{
        $(id).select2({
            dropdownParent: $('#myModal2 .modal-content')
        });
     }
    
 }else{
    $(id).select2();
 }
}
function initDecimal(id) {
    $(id).on('keypress', function(event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
        var input = $(this).val();
        if ((input.indexOf('.') != -1) && (input.substring(input.indexOf('.')).length > 2)) {
            event.preventDefault();
        }
    });
}

function generatePassword() {
    var length = 4,
        charset = "0123456789",
        retVal = "";
    for (var i = 0, n = charset.length; i < length; ++i) {
        retVal += charset.charAt(Math.floor(Math.random() * n));
    }
    return retVal;
}

//TERMINA FUNCIONES ACTUALIZADAS


function initDataTableNormal(element) {
    $(element).DataTable({
        responsive: false,
        language: {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No hay información disponible para mostrar",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No existen registros",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "sSearch": "Buscar",
            paginate: {
                first: "Primero",
                previous: "Anterior",
                next: "Siguiente",
                last: "Ultimo"
            },
        },
        "dom": "t",
        //keys: true,
        scrollY: 200,
        order: [],
        paging: false,
        ordering: false
    });
}

function iniciarLetras() {
    $('.letras').on('input', function() {
        //console.log(this.value);
        this.value = this.value.replace(/[^A-Z]/g, '');
    });
}

function iniciarSelect2Modal() {
    $(".select2-normalM").select2({
        dropdownParent: $('#myModal .modal-content')
    });
}

function iniciarSelect2() {
    $(".select2-normal").select2({
        //dropdownParent: $("#myModal"),
    });
    /*$('select:not(.normal)').each(function () {
  $(this).select2({
      dropdownParent: $(this).parent()
  });
});*/
}

function iniciarSelect2ById(id) {
    $(id).select2({
        /// dropdownParent: $('#myModal .modal-content')
    });
}

function iniciarTelefono() {
    $(".telefono").inputmask({
        "mask": "(999) 999-9999"
    });
}

function iniciarMetodosValidate() {
    $.validator.addMethod("RFC", function(value, element) {
        if (value !== '') {
            var patt = new RegExp("^[A-Z,Ñ,&]{3,4}[0-9]{2}[0-1][0-9][0-3][0-9][A-Z,0-9]?[A-Z,0-9]?[0-9,A-Z]?$");
            return patt.test(value);
        } else {
            return false;
        }
    }, "Ingrese un RFC valido");
    $.validator.addMethod("CURP", function(value, element) {
        if (value !== '') {
            var patt = new RegExp("^[A-Z][A,E,I,O,U,X][A-Z]{2}[0-9]{2}[0-1][0-9][0-3][0-9][M,H][A-Z]{2}[B,C,D,F,G,H,J,K,L,M,N,Ñ,P,Q,R,S,T,V,W,X,Y,Z]{3}[0-9,A-Z][0-9]$");
            return patt.test(value);
        } else {
            return false;
        }
    }, "Ingrese una CURP valido");
    /*
      $.validator.addMethod("customemail", 
        function(value, element) {
            return  /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value);
        }, 
        "Ingrese un correo valido"
    );*/
}

function iniciarNumero(id) {
    $(id).on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
}

function iniciarDecimalById(id) {
    $(id).on('keypress', function(event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
        var input = $(this).val();
        if ((input.indexOf('.') != -1) && (input.substring(input.indexOf('.')).length > 2)) {
            event.preventDefault();
        }
    });
}

function iniciarDataTable(id) {
    $(id).DataTable({
        responsive: false,
        language: {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "zeroRecords": "No existen registros - ",
           // "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No existen registros",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "sSearch": "Buscar",
            paginate: {
                first: "Primero",
                previous: "Anterior",
                next: "Siguiente",
                last: "Ultimo"
            },
        },
        //"dom": "tf",
        "order": [],
        
    });
}

function iniciarFechasById(id) {
    $(id).datetimepicker({
        //format: 'L',
        format: 'DD/MM/YYYY'
    });
}

function iniciarHoras(id) {
    $(id).datetimepicker({
        format: 'LT'
    });
}

function verificarSiExiste(id) {
    if ($(id).length) {
        return verificarVariable($(id).val());
    } else {
        return false;
    }
}

function getValClean(valor,type='String'){

    if(type=="Float"){
        return verificarVariable(valor)?parseFloat(valor):0;
    }else if(type=="Int"){
        return verificarVariable(valor)?parseInt(valor):0;
    }else{
        return verificarVariable(valor)?valor:'';
    }
    
}

function verificarVariable(myVar) {
    //console.log(myVar);
   // console.log(!myVar.trim());
    //si la variable no existe
    if (typeof myVar === undefined) {
        return false;
        //si la variable no tiene valor
    } else if (myVar === null) {
        return false;
    } else if (myVar === '') {
        return false;
    } else if (!myVar) {
        return false;
    } else if (typeof string === "string" && !myVar.trim()) {
        return false;
    } else {
        //si tiene valor y existe
        return true;
    }
}

function iniciarFechas(fecha) {
    $('.fechas').datetimepicker({
        format: 'DD/MM/YYYY',
        // container: '#myModal modal-body'
    });
    $('.daterangepicker').css('z-index', '1600');
}

function modalCargando() {
    var html = '<div class="d-flex justify-content-center"><div class="loader-box" style="height: 90px !important;"><span class="rotate dashed colored"></span></div></div>';
    var letra = '<div class="d-flex justify-content-center"><h6 class="sub-title mb-4">Procesando información</h6></div>';
    return '<div class="modal-content digitos">' + '<div class="modal-header"></div>' + '<div class="modal-body">' + html + letra + '</div>' + '<div class="modal-footer"><button class="btn btn-danger btnCancelarAjax d-none" type="button" id="btnCancelarAjax">Cancelar</button></div></div>';
}

function modalError(errores) {
    var html = '<div class="alert alert-danger" role="alert">Error al obtener información. <br>' + errores + '</div>';
    return '<div class="modal-content digitos">' + '<div class="modal-header"></div>' + '<div class="modal-body">' + html + '</div>' + ' <div class="modal-footer"><button type="button" class="btn btn-danger button-rounded  text-white shadow-sm" data-dismiss="modal">Salir</button></div></div>';
}

function iniciarDecimal() {
    $('.decimal').on('keypress', function(event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            console.log(1);
            event.preventDefault();
        }
        var input = $(this).val();
        if ((input.indexOf('.') != -1) && (input.substring(input.indexOf('.')).length > 2)) {
            console.log(2);
            event.preventDefault();
        }
    });
}


function onError(response) {
    $(".divCargando").html("");
    $(".divCargandoModal").html("");
    $(".btnProceso").prop("disabled", false);
    //console.log(response.status);
    if (response.status === 0) {
        confirmSwal('No conectado, verificar la red.', 'error');
    } else if (response.status == 404) {
        confirmSwal('Página solicitada no se encuentra. [404]', 'error');
    } else if (response.status == 500) {
        confirmSwal('Error de servidor interno [500].', 'error');
    }
    /* else if (jqXHR.statusText === 'parsererror') {
          confirmSwal('Petición JSON fallida.', 'error');
      } else if (jqXHR.statusText === 'timeout') {
          confirmSwal('Error de tiempo de espera.', 'error');
      } else if (jqXHR.statusText === 'abort') {
          confirmSwal('Petición Ajax abortado.', 'error');
      }*/
    else {
        var string = "";
        $.each(response.responseJSON.errors, function(index, value) {
            string += value + ". \n";
        });
        confirmSwal(string, 'error', response.responseJSON.message);
        $(".divCargando").html("");
        $(".btnProceso").prop("disabled", false);
    }
}

function confirmSwal(text, icon, title = '', time = false) {
    if (time) {
        swal({
            title: title,
            text: text,
            icon: icon,
            timer: 2000,
            buttons: false,
        });
    } else {
        swal('' + title + '', '' + text + '', '' + icon + '');
    }
}

async function peticionAjax(dataAjax, callback) {
    
    if (dataAjax.hasOwnProperty('cargando')) {
        // cargando(1, dataAjax.elementoCargando); 
        $("#modalCargando").modal({
            keyboard: false,
            backdrop: 'static',
            show: true
        });
        $("#modalContentCargando").html(modalCargando());
    }
    let aj = $.ajax({
        type: dataAjax.type,
        data: dataAjax.data,
        dataType: dataAjax.dataType,
        processData: false,
        contentType: (dataAjax.hasOwnProperty('contentType'))?dataAjax.contentType:false,
        beforeSend: function(xhr) {},
        url: dataAjax.url,
        complete: function name(params) {        
        },
        success: function(response) {
            if (dataAjax.hasOwnProperty('cargando')) {             
                setTimeout(() => {                
                    $('#modalCargando').modal('hide');
                }, 1000);
            }
            return callback(response);
        },
        error: function(response) {    
            //console.log(response);   
            if (dataAjax.hasOwnProperty('cargando')) {             
                setTimeout(() => {            
                    $('#modalCargando').modal('hide');
                }, 1000);             
            }
            if (dataAjax.hasOwnProperty('retornar')) {
                return callback(response);
            } else {
                if (response.hasOwnProperty('responseJSON')) {
                    if (response.responseJSON.hasOwnProperty('errors')) {
                        onError(response);
                    }else if (response.responseJSON.hasOwnProperty('message')) {
                        var string = "";
                        /*$.each(response.responseJSON.errors, function(index, value) {
                            string += value + ". \n";
                        });**/
                        confirmSwal(response.responseJSON.message, 'error', string);
                        $(".divCargando").html("");
                        $(".btnProceso").prop("disabled", false);
                    } else {
                        return callback(response);
                    }
                } else {
                    return callback(response);
                }
            }     
        },
    });
   // return aj;
}

function getModal(cfgModal) {
    //   console.log(1);
    /* var dataAjax = {
            url: cfgModal.url,
            data: cfgModal.formData,
            type: cfgModal.type,
            modo: 'json'
        };*/
    var dataAjax = {
        url: cfgModal.url,
        data: cfgModal.formData,
        type: cfgModal.type,
        dataType: 'json',
        /*cargando:1,
        elementoCargando:'#divCargandoModal',*/
        retornar: 1,
    };
    try {
        $(cfgModal.divContent).html('');
        $(cfgModal.divContent).removeClass("modal-lg modal-sm modal-md");
        $(cfgModal.divContent).addClass(cfgModal.size);
        $(cfgModal.idModal).modal({
            keyboard: false,
            backdrop: 'static',
            show: true
        });
        
        $(cfgModal.divContent).html(modalCargando());
        peticionAjax(dataAjax, function(response) {
            if (response.success === 1) {
                $(cfgModal.divContent).html(response.html);
                $('[data-modulo="Modal"]').tooltip();
            } else {
                $(cfgModal.divContent).html(modalError(''));
            }
        });
    } catch (error) {}
}

function cargando(estado, id = '#divCargando') {
    //console.log("entre");
    var html = '<div class="d-flex justify-content-center"><div class="loader-box" style="height: 90px !important;"><span class="rotate dashed colored"></span></div></div>';
    var letra = '<div class="d-flex justify-content-center"><h6 class="sub-title mb-4">Procesando información</h6></div>';
    if (estado == 1) {
        $(id).html(html + "" + letra);
    } else {
        $(id).html('');
    }
}

function getBusquedaSelect2(idSelect, type, url, placeholder) {
    $("#" + idSelect).select2({
        // dropdownParent: $('#body-inner'),
        //minimumResultsForSearch: 10,
        placeholder: placeholder,
        allowClear: true,
        minimumInputLength: 1,
        ajax: {
            type: type,
            url: url,
            dataType: 'json',
            delay: 350,
            data: function(params) {
                return {
                    valor: params.term,
                    idSelect: idSelect
                };
            },
            processResults: function(data) {
                var results;
                results = [];
                if (idSelect == 'sat_producto') {
                    $.each(data, function(idx, item) {
                        // console.log(idSelect);
                        results.push({
                            'id': item.id,
                            'text': item.clave + ' - ' + item.descripcion
                        });
                    });
                } else {
                    $.each(data, function(idx, item) {
                        // console.log(idSelect);
                        results.push({
                            'id': item.id,
                            'text': item.nombre
                        });
                    });
                }
                return {
                    results: results
                };
            }
        },
        formatResult: function(element) {
            return element.text + ' (' + element.id + ')';
        },
        formatSelection: function(element) {
            return element.text + ' (' + element.id + ')';
        },
        escapeMarkup: function(m) {
            return m;
        }
    });
}

function checkCampo(valor, tipo) {
    var validate = false;
    if (tipo == "String") {
        if (valor == undefined || valor == null || valor == '') {
            validate = true;
        }
    }
    return validate;
}

function checkCheck(id) {
    return (($("#" + id).is(":checked")) ? '1' : '0');
}
let myDropzone;

function iniciarDropzone(datosDrop) {
    //console.log(datosDrop);
    myDropzone = new Dropzone("#" + datosDrop.idDropzone, {
        paramName: datosDrop.idInputFile, // The name that will be used to transfer the file
        maxFilesize: 50, // MB
        addRemoveLinks: true,
        autoProcessQueue: false,
        url: datosDrop.urlFake,
        uploadMultiple: false,
        //parallelUploads: 5,
        maxFiles: (datosDrop.maxFiles > 0) ? datosDrop.maxFiles : 1,
        //previewTemplate: document.getElementById('template-preview').innerHTML,
        //clickable: true,
        acceptedFiles: datosDrop.archivosPermitidos,
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
                swal({
                    title: "¿Esta seguro que desea eliminar archivo " + file.name + "?",
                    text: "",
                    icon: "warning",
                    buttons: ["Cancelar", "Eliminar"],
                    dangerMode: false,
                }).then((willDelete) => {
                    if (willDelete) {
                        console.log(file.name);
                        var formData = new FormData();
                        formData.append('id', file.idA);
                        formData.append('tipo', file.tipo);
                        formData.append('name', file.name);
                        formData.append('ruta', file.ruta);
                        $.ajax({
                            type: 'POST',
                            url: datosDrop.urlEliminar,
                            data: formData,
                            dataType: 'json',
                            processData: false,
                            contentType: false,
                            success: function(respuesta) {
                                // respuesta = JSON.parse(respuesta);
                                if (respuesta.success === 1) {
                                    //alert("asasdasdsad");
                                    var _ref;
                                    (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                                    //confirmSwal("Se elimino documento " + file.name + " correctamente", "success");
                                } else {
                                    //alert("asdasd");
                                    // confirmSwal("No se pudo eliminar documento " + file.name, "error");
                                }
                            },
                            error: function(response) {
                                console.log(response);
                                //onError(jqXHR, textStatus, errorThrown, 'btn');
                            },
                        });
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
            if ((datosDrop.urlObtener != '' && datosDrop.modulo == 'M')) {
                ///console.log(datosDrop.dataObtenerArchivos);
                //var formData=new FormData();
                /* formData.append('disk',datosDrop.dataObtenerArchivos.disk);   
                 formData.append('ruta',datosDrop.dataObtenerArchivos.ruta);
                 formData.append('name',datosDrop.dataObtenerArchivos.name);  */
                $.ajax({
                    url: datosDrop.urlObtener,
                    type: 'POST',
                    data: datosDrop.formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
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
                    error: function(jqXHR, textStatus, errorThrown) {
                        //onError(jqXHR, textStatus, errorThrown, 'btn');
                    },
                });
            }
        },
        error: function(file, message) {
            confirmSwal(message, "error");
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

function calcularEdad(fecha, campoEdad) {
    if (fecha != '') {
        var hoy = new Date();
        hoy = hoy.getFullYear() + "-" + ("0" + (hoy.getMonth() + 1)).slice(-2) + "-" + ("0" + hoy.getDate()).slice(-2);
        var fechaOriginal = fecha.toString();
        fechaOriginal = fechaOriginal.split('/');
        fecha = fechaOriginal[2] + "-" + fechaOriginal[1] + "-" + fechaOriginal[0];
        fecha1 = moment(fecha);
        var fecha2 = moment(hoy);
        $("#" + campoEdad).val(fecha2.diff(fecha1, 'years'));
    }
}

function AddDaysToDate(sDate, iAddDays, sSeperator) {
    //console.log(sDate);
    // var spl=sDate.split("-");
    // sDate=spl[2]+"/"+spl[1]+"/"+spl[0];
    //console.log(sDate);
    //Purpose: Add the specified number of dates to a given date.
    var date = new Date(sDate);
    //console.log(date);
    date.setDate(date.getDate() + parseInt(iAddDays) + 1);
    // console.log(date.getFullYear());
    var sEndDate = date.getFullYear() + sSeperator + LPad(date.getMonth() + 1, 2) + sSeperator + LPad(date.getDate(), 2);
    console.log(sEndDate);
    //var sEndDate =  LPad(date.getDate(), 2) +  sSeperator + LPad(date.getMonth() + 1, 2) +  sSeperator + date.getFullYear();
    return sEndDate;
}

function cargarSelect(dataSelect) {
    var formData = new FormData();
    formData.append("seleccionar", dataSelect.seleccionar);
    formData.append("idSelect", dataSelect.idSelect);
    formData.append("papa_id", dataSelect.papa_id);
    if (dataSelect.hasOwnProperty('filtros')) {
        for (var pair of dataSelect.filtros.entries()) {
            formData.append("" + pair[0], pair[1]);
        }
    }
    var dataAjax = {
        url: dataSelect.url,
        data: formData,
        type: "POST",
        dataType: 'json',
        //cargando: dataSelect.cargando,
        //elementoCargando: dataSelect.elementoCargando,
        retornar: 1,
    };
    //console.log(dataAjax);
    $(dataSelect.idSelect).html("<option value='' disabled selected>Cargando...</option>");
    peticionAjax(dataAjax, function(response) {
        //cargando(2);
        //console.log(response.opciones);
        if (response.success === 1) {
            $(dataSelect.idSelect).html(response.opciones);
            //$("#"+ idSelect).trigger('change');
        } else {
            // cargando(2);           
            //confirmSwal(response.error, "error");
        }
    });
}

function cargarTree(idTree, url, value) {
    var formData = new FormData();
    formData.append("value", value);
    /*var dataAjax = {
        url: url,
        data: formData,
        type: "POST",
        modo: 'json'
    };*/
    var dataAjax = {
        url: url,
        data: formData,
        type: "POST",
        dataType: 'json',
        cargando: 1,
        elementoCargando: '#' + idTree,
        retornar: 1,
    };
    //cargando(1, idTree);
    //$("#"+idSelect).html("<option value='' disabled selected>Cargando...</option>");
    peticionAjax(dataAjax, function(response) {
        //cargando(2, idTree);
        //console.log(response.opciones);
        if (response.success === 1) {
            $("#" + idTree).html(response.html);
            iniciarTreeView("#" + idTree);
        } else {
            //cargando(2, idTree);
            confirmSwal('No se pudo cargar informacion', "error");
        }
    });
}

function iniciarTreeView(id) {
    // $( id ).jstree(true).refresh();
    //$( id ).off();
    // $(id).jstree(true).refresh();
    //$(id).jstree("refresh");
    $(id).on('changed.jstree', function(e, data) {}).jstree({
        'core': {
            'themes': {
                'responsive': false
            },
            'multiple': false,
            'expand_selected_onload': true
        },
        /* 'types': {
             'submodulo': {
                 'icon': 'icofont icofont-ui-note font-info'
             },
             'modulo': {
                 'icon': 'icofont icofont-ui-folder font-warning'
             },
             'categoria': {
                 'icon': 'icofont icofont-ui-folder font-warning'
             }
         },*/
        'plugins': ['types', 'checkbox'],
        'checkbox': {
            'deselect_all': false,
            'three_state': false,
        }
    });
}

function iniciarTreeViewMultiple(id) {
    // $( id ).jstree(true).refresh();
    //$( id ).off();
    // $(id).jstree(true).refresh();
    //$(id).jstree("refresh");
    $(id).on('changed.jstree', function(e, data) {}).jstree({
        'core': {
            'themes': {
                'responsive': true
            },
            'multiple': true,
            'expand_selected_onload': true
        },
        /* 'types': {
             'submodulo': {
                 'icon': 'icofont icofont-ui-note font-info'
             },
             'modulo': {
                 'icon': 'icofont icofont-ui-folder font-warning'
             },
             'categoria': {
                 'icon': 'icofont icofont-ui-folder font-warning'
             }
         },*/
        'plugins': ['types', 'checkbox'],
        'checkbox': {
            'deselect_all': true,
            'three_state': true,
        }
    });
}
var treewe;
function initTreeView(id,multiple=true,expand_selected_onload=true,deselect_all=true,three_state=true) {   
    /* $(id).on('changed.jstree', function(e, data) {}).jstree({
         'core': {
             'themes': {
                 'responsive': false
             },
             'multiple': false,
             'expand_selected_onload': true
         },       
         'plugins': ['types', 'checkbox'],
         'checkbox': {
             'deselect_all': false,
             'three_state': false,
         }
     });
        $(id).on('changed.jstree', function(e, data) {}).jstree({
         'core': {
             'themes': {
                 'responsive': true
             },
             'multiple': true,
             'expand_selected_onload': true
         },        
         'plugins': ['types', 'checkbox'],
         'checkbox': {
             'deselect_all': true,
             'three_state': true,
         }
     });
     */
     treewe=$(id).on('changed.jstree', function(e, data) {}).jstree({
         'core': {
             'themes': {
                 'responsive': true
             },
             'multiple': multiple,
             'expand_selected_onload': expand_selected_onload
         },       
         'plugins': ['types', 'checkbox',/*'noclose'*/],
         'checkbox': {
             'deselect_all': deselect_all,
             'three_state': three_state,
            
         }
     });
 }