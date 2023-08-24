$(document).ready(function() {
    inicia_Datatable("#table_rol");
    $("#btnGuardar").click(function () {
        var seleccionados = [];
        $(".chkpermisos").each(function(index, element) {
            // element == this
            if ($(this).is(":checked")) {
                seleccionados.push({
                    id:this.id,
                    tipo:1
                });
            }
        });
        
        $(".chkmenus").each(function(index, element) {
            // element == this
            if ($(this).is(":checked")) {
                seleccionados.push({
                    id:this.id,
                    tipo:0
                });
            }
        });
        //console.log(jsonAcceso);
        
        var datos= new FormData(document.getElementById("frm_rol"));
        datos.append("seleccionados", JSON.stringify(seleccionados));
        accion_registros({
            frm:"frm_rol",
            btn:$(this),
            data:datos,
            ruta:urls.guardar,
            success:function(){
                location.reload(true);
            },
            Text_error_validator: "Debe seleccionar al menos un permiso",
            validaciones: function(){
                if (seleccionados.length === 0) {
                   return false;
                }
                else{
                    return true;
                }
            }
        });
        
    });
 /*
    $('#treecheckbox').jstree({
        'core' : {
            'themes' : {
                'responsive': false
            },
            'data': {
                'url': function(node) {
                    return urls.permisos; // Demo API endpoint -- Replace this URL with your set endpoint
                },
                'data': function(node) {
                    return {
                        'parent': node.id,
                        'type':node.type
                    };
                }
            }
        },
        'types' : {
            'default' : {
                'icon' : 'fa fa-folder-o font-theme'
            },
            'file' : {
                'icon' : 'fa fa-file-text-o font-dark'
            }
        },
        'plugins' : ['types', 'checkbox']
    })
*/
    $(".caret").click(function (e) { 
        e.preventDefault();
        $("li", this.parentElement).toggleClass("oculto activo");   
        $("i", this).toggleClass("icofont icofont-caret-right icofont icofont-caret-down");
    });
    $('#treePuesto').on('change', 'input[type=checkbox]', onChange);
});
var topNodes = function(chkbx) {
    return $(chkbx).closest('ul').closest('li');
  };
  
  var markTopNodes = function(nodes) {
    if (!nodes.length) return;
    var chkbx = nodes.children('input').eq(0); //parent checkbox
    //get the immediate li's of the node
    var lis = nodes.children('ul').children('li');
    //get count of un-checked checkboxes
    var count = lis.children('input[type=checkbox]:not(:checked)').length;
    //mark if count is 0
    //chkbx.prop('checked', !(count));
    chkbx.prop('checked', true);
    //recursive call for other top nodes
    markTopNodes(topNodes(chkbx));
  };
  
  var onChange = function(e) {
    //for child nodes, checked state = current checkbox checked state
    $(this).closest('li').find('input[type=checkbox]').prop('checked', this.checked);
    //for parent nodes, checked if immediate childs are checked, but recursively
    markTopNodes(topNodes(this));
  };