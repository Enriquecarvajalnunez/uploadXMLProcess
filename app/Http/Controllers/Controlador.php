<?php

namespace App\Http\Controllers;
use App\FormUpload;
use App\Upload;

use Illuminate\Http\Request;

class Controlador extends Controller
{
    public function create(Request $request){          
        $filename = $request->input('filename');
        $opciones = $request->input('formatos');

        $formUpload = new FormUpload();

        if($formUpload->getRutaArchivo() != null && $formUpload->getFilename() != null){
            $filename = isset($_POST["filename"]) ? $_POST["filename"] : explode('.', $formUpload->getFilename())[0];
            new Upload($formUpload->getRutaArchivo(), $filename, $opciones);
        }
        return redirect()->route('download',[$filename.'.txt']);
    }  

    //funcion para descarga de archivo
    public function download($filename){              
        $formUpload = new FormUpload();
        $path = storage_path('app/' . $formUpload->getRutaArchivo() . '/'.$filename);        
        return response()->download($path);        
    }   
    
}


