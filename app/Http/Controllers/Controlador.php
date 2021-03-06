<?php

namespace App\Http\Controllers;
use App\FormUpload;
use App\Upload;

use Illuminate\Http\Request;

class Controlador extends Controller
{
    public function create(){          
        $formUpload = new FormUpload();

        if($formUpload->getRutaArchivo() != null && $formUpload->getFilename() != null){
            $filename = isset($_POST["filename"]) ? $_POST["filename"] : explode('.', $formUpload->getFilename())[0];
            new Upload($formUpload->getRutaArchivo(), $filename);
        }
    }        
}


