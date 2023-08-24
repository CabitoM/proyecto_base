<div class="form-row">
    <input type="hidden" id="modulo" name="modulo" value="{{ !empty($modulo)? $modulo : '' }}"> 
    <input type="hidden" id="id_user" name="id_user" value="{{ !empty($usuario->id)? ($usuario->id): '' }}">  
     <div class="col-md-4 mb-3">
        <label for="name">Nombre*</label>
        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Escriba nombre" value="{{ !empty($usuario->name)? $usuario->name :'' }}" required>
     </div>
     <div class="col-md-4 mb-3">
        <label for="username">Usuario*</label>
        <input type="text" autocomplete="off" class="form-control" id="username" name="username" placeholder="Escriba username" value="{{ !empty($usuario->username)? $usuario->username :'' }}" required>
     </div>
     <div class="col-md-4 mb-3">
        <label for="email">Correo electrónico</label>
        <input type="email" class="form-control" id="correo" name="correo" placeholder="Escriba Correo electrónico" value="{{ !empty($usuario->email)? $usuario->email: '' }}" autocomplete="off" >
     </div>
     <div class="col-md-4 mb-3">
        <label for="telefono">Teléfono*</label>
        <input type="text" class="telefono form-control" id="telefono" name="telefono" placeholder="Escriba telefono" value="{{ !empty($usuario->telefono)? $usuario->telefono :'' }}">
     </div>
     <div class="col-md-4 mb-3">
        <label for="direccion">Dirección*</label>
        <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Escriba direccion" value="{{ !empty($usuario->direccion)? $usuario->direccion :'' }}" >
     </div>
     <div class="col-md-12"></div>
     <div class="col-md-4 mb-3 ">
        <label for="password">Contraseña de Acceso*</label>
        <div class="input-group">
          <input type="password" class="form-control" id="password" name="password" placeholder="Escriba Contraseña" autocomplete="new-password"  {{ ($modulo=="A") ? 'required' : '' }}>
          <div class="input-group-append">
             <span class="input-group-text"><i class="fa fa-eye" id="btn_pass"></i></span>
         </div>
        </div>
     </div>
     <div class="col-md-4 mb-3">
       <label for="repetir_password">Repetir Contraseña de Acceso*</label>
       <div class="input-group"> 
          <input type="password" autocomplete="new-password"  class="form-control" id="repetir_password" name="repetir_password" placeholder="Escriba repita Contraseña"  {{ ($modulo=="A") ? 'required' : '' }}>
          <div class="input-group-append">
             <span class="input-group-text"><i class="fa fa-eye" id="btn_pass2"></i></span>
          </div>
       </div>

     </div>
 </div>