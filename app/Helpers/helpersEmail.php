<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

function sendEmail($config,$data,$view,$files='',$dataPdf='',$dataXml=''){  
    //dd($files);
     Mail::send($view, ["data"=>$data], function($message) use ($config, $files,$dataPdf,$dataXml)
     {
         $message->from($config["from"],$config["from_name"])
         ->to($config["to"])
         ->subject($config["subject"]);
         if(!empty($config["cc"])){
            $message->cc($config["cc"]);
         }
        
        if(!empty($files) and is_array($files)){
             foreach ($files as $file){
               ;
                 $message->attach($file['file'], [
                     'as' => $file['name'],
                     'mime' => 'application/pdf',
                ]);
             }
         }
        //dd($dataPdf);
        if(!empty($dataPdf) and is_array($dataPdf)){
            foreach ($dataPdf as $arpdf){
                //dd($arpdf);
                $pdf=generarPDf($arpdf["view"],$arpdf['data'],'',"Content");
                $message->attachData($pdf,$arpdf["name"], [
                    'as' => $arpdf["name"],
                    'mime' => 'application/pdf',
                ]);
            }
            
        }  
        if(!empty($dataXml) and is_array($dataXml)){
            foreach ($dataXml as $arpdf){
                //dd($arpdf);
                $pdf=$arpdf["xml"];
                $message->attachData($pdf,$arpdf["name"], [
                    'as' => $arpdf["name"],
                    'mime' => 'application/xml',
                ]);
            }
            
        }          
             
     });
    
 }


function sendError($request,$e,$factura=false,$obFactura=[]){  
    Log::error($e);
    $action = app('request')->route()->getAction();  
    $controller = class_basename($action['controller']);
    $data=[        
        "Subject"=>'Error En '.$controller,
        "User"=>Auth::user()->id." - ".Auth::user()->name,
        "Request"=>$request,
        "Action"=>$action,              
        "Message"=>$e->getMessage(),
        //"Error"=>base64_encode($e),               
    ];
    $xml=[];
    $subject='Error En '.$controller;
    if($factura){
        //$data["Factura"]=$obFactura;
        foreach ($obFactura as $key => $value) {
            if($key=="xml"){
                foreach($value as $x){
                    $data["Factura"]["InfoError"][]=(string)$x;  
                }
            }else if($key=="xmlTemp"){
                $xml=[[
                    "name"=>"xml_factura.xml",
                    "xml"=>$value
                ]];
            }else{
                $data["Factura"][$key]=$value;  
            }
        }
        $infoS=getInfoSucursal();
        $subject='Error al Facturar en '.$infoS->name." Serie ".$infoS->serie;
    }
    $config=[
        "to"=>explode(",",env("MAIL_CC_ADDRESS")),
        "cc"=>explode(",",env("MAIL_CC_ADDRESS")),
        "from" => env("MAIL_FROM_ADDRESS"),
        "from_name"=>env("APP_NAME")." ". session("sucursal_name"),
        "subject"=>$subject,  
    ];
    $view='mail.error';
    sendEmail($config,$data,$view,'','',$xml);
       
}