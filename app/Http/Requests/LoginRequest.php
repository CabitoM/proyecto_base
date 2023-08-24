<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
class LoginRequest extends FormRequest
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
            "username"=>"required",
            "password"=>"required",
        ];
    }
    public function getCredentials(){
        $usernanme=$this->get("username");
        $password=$this->get("password");
        if($this->esCorreo($usernanme)){
            return[
                "email"=>$usernanme,
                "password"=>$password,
                "status"=>"Activo"
            ];
        }
        //return $this->only("username","password");
        return[
            "username"=>$usernanme,
            "password"=>$password,
            "status"=>"Activo",
        ];
    }
    public function esCorreo($val){
        $factory = $this->container->make(ValidationFactory::class);
        return !$factory->make(['username' => $val],['username' => 'email'])->fails();
    }
}
