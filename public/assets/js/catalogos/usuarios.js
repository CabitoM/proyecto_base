$(document).ready(function() {
    $(".selectpicker").selectpicker();
    $("#btnGuardar").click(function () {
        var datos= new FormData(document.getElementById("frm_usuario"));
        var jsonAcceso = [];
        $(".perfil_sucursal").each(function(index, elemento) {
            var ar_id_elemento = this.id.split("_");
            var id_sucursal = ar_id_elemento[0];
            var rol_sucursal = this.value;
            if (rol_sucursal > 0) {
                var acceso="N";
                if($("#"+id_sucursal + "-chk-acceso").is(':checked')){
                    acceso="Y";
                }
                jsonAcceso.push({
                    id_sucursal: id_sucursal,
                    id_rol: rol_sucursal,
                    acceso: acceso,
                });
            }
        });
        var roles=false;
        $(".chk").each(function(index, elemento) {
            if($(this).is(':checked')){
                roles=true;
                return true;
            }
        });
        datos.append("jsonAcceso", JSON.stringify(jsonAcceso));
        accion_registros({
            frm:"frm_usuario",
            btn:$(this),
            data:datos,
            ruta:urls.guardar,
            rules:{
                correo: {
                    email: true
                },
                password: {
                    minlength:8
                },
                repetir_password: {
                    equalTo: "#password",
                }
            },
            success:function(){
                location.reload(true);
            },
            Text_error_validator:"Revise que tenga al menos un Rol seleccionado y un Acceso",
            validaciones: function(){
                if (jsonAcceso.length>0 && roles) {
					return true;
				}else{
					return false;
				}
            },
        });

    });
    $("#btn_pass").click(function(){
		mostrar_pass({
            input_pass:$("#password"),
            btn:$(this),
        });
	});
	$("#btn_pass2").click(function(){
        mostrar_pass({
            input_pass:$("#repetir_password"),
            btn:$(this),
        });
	});

});
function mostrar_pass(data){
    if(data.input_pass.attr("type")=="password"){
        data.input_pass.attr('type', 'text');
        data.btn.removeClass('fa-eye').addClass('fa-eye-slash');
    }
    else if(data.input_pass.attr("type")=="text"){
        data.input_pass.attr('type', 'password');
        data.btn.removeClass('fa-eye-slash').addClass('fa-eye');
    }
}
function eliminar_usuario(id) {
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
function ver_usuario(id){
    var datos = new FormData();
    datos.append("id",id);
    getModal({
        url:urls.ver,
        data:datos,
        idContent:'#modalResultado',
        idModal:'#myModal',
        size:'modal-lg',//modal-lg modal-sm modal-md
        backdrop:true,
        ini_modal:function(){
            console.log("sadsadsad");
            $("#input_prueba").focus();
        },
    });
}
