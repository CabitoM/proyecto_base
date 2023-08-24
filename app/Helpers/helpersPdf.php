<?php

use Illuminate\Support\Facades\App;

function generarPDf($data){
    $view="pruebas";//por default siempre el de inicio pa que no de error
    if(!empty($data["view"])){
        $view=$data["view"];
    }
    $datos=[];
    if(!empty($data["datos"])){
        $datos=$data["datos"];
    }
    $modo="D";
    if(!empty($data["modo"])){
        $modo=$data["modo"];
    }
    $ruta="";
    if(!empty($data["ruta"])){
        $ruta=$data["ruta"];
    }
    $paper="letter";//por dfault
    $orientacion="portrait";//Landscape
    if(!empty($data["orientacion"])){
        $orientacion=$data["orientacion"];
    }
    if(!empty($data["paper"])){
        $paper=$data["paper"];
    }
    $pdf = App::make('dompdf.wrapper');
    $pdf->getDomPDF()->set_option("enable_php", true);    
    $pdf->loadView($view,$datos);
    $pdf->setPaper($paper, $orientacion);
    if($modo=="S"){
        $path = public_path($ruta); // <--- folder to store the pdf documents into the server;
        $fileName =  time().'.'. 'pdf' ; // <--giving the random filename,
        if(!empty($data["filename"])){
            $fileName=$data["filename"];
        }
        $pdf->save($path . '/' . $fileName);
        //Storage::disk($disk)->put($ruta, File::get($image_path));
        $generated_pdf_link = url($ruta."/".$fileName);
          //return response()->json($generated_pdf_link);
        return $generated_pdf_link;
    }else if($modo=="C"){
        //$pdf->render();
        return $pdf->output();
    }else if($modo=="D"){
        return $pdf->stream();
    }else{
        return null;
    }
  
}


