<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "id_user"=>"sometimes|nullable",
            "nombre"=>"required|max:50|string",
            "username"=>[
                "required",
                $this->getUniqueRequest(),
            ],
            "correo"=>[
                "required",
                $this->getUniqueRequest("correo"),
            ],
            "telefono"=>"sometimes|nullable|regex:/^[\\(\\)\\-0-9 ]+$/i",
            "direccion"=>"sometimes|nullable",
            "password"=>"sometimes|nullable|min:8",
            "repetir_password"=>"sometimes|nullable|same:password",
        ];
    }
    public function getUniqueRequest($type="username"){
        $modulo=$this->get("modulo");
        $usuario=User::find($this->get("id_user"));
        if($modulo=="E"){
            if($type=="username")
                Rule::unique(User::class,'username')->ignore($usuario->id);
            else if($type=="correo")
                return Rule::unique(User::class,'email')->ignore($usuario->id);;
        }
        else{
            if($type=="username")
                return "unique:users,username";
            else if($type=="correo")
                return "unique:users,email";
        }
    }
    public function messages(){
        return [
            'id_user.sometimes' => 'No se pudo obtener información',
            'name.required' => 'El campo nombre es obligatorio',
            'name.max' => 'El campo nombre no debe ser mayor a 50 caracteres',
            'correo.email' => 'No es un correo electrónico valido',
            'correo.required' => 'El campo correo electrónico es obligatorio',
            'password.required' => 'El campo password es obligatorio',
            'telefono.regex' => 'El campo teléfono solo permite numeros',
            'correo.unique' => 'Email ya se encuentra en uso.',
            'direccion.required' => 'El campo direccion es obligatorio',
            'direccion.max' => 'El campo direccion no debe ser mayor a 50 caracteres',
            'direccion.regex' => 'El campo direccion solo permite  letras',
        ];
    }
}
