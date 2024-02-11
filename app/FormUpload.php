<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FormUpload extends Model
{
    //Define var
    private $filename;
    private $rutaArchivo;          

    public function __construct()
    {    
        // Check if the form was submitted
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $this->handleFileUpload();
        }
    }

    private function handleFileUpload(){
        if(request()->hasFile('photo') && request()->file('photo')->isValid()){
            $extensions = ['xls', 'xlsx'];
            $uploadFile = request()->file('photo');

            $verify = $uploadFile->getClientOriginalExtension();
            if(!in_array($verify, $extensions)){
                print_r("error en el formato del archivo");exit();
            }

            $maxSize = 5 * 1024 * 1024;
            if($uploadFile->getSize() > $maxSize){
                print_r("error en el tamaño del archivo");exit();
            }
            $this->informationStorage($uploadFile);
        }        
    }
              
    public function informationStorage($uploadFile){
        $this->filename    = $uploadFile->getClientOriginalName();
        $this->rutaArchivo = "archivos/" .Str::random(10) . $this->filename;            
        Storage::put($this->rutaArchivo, file_get_contents($uploadFile->getRealPath()));
        echo "archivo cargado con exito";
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function getRutaArchivo()
    {
        return $this->rutaArchivo;
    }
}
