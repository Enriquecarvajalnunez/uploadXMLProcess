<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormUpload extends Model
{
    //Define var
    private $filename;
    private $rutaArchivo;          

    public function __construct()
    {    
        // Check if the form was submitted
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            // Check if file was uploaded without errors
            if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0){
                $allowed = array('xls' => 'application/vnd.ms-excel', 'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                $this->filename = $_FILES["photo"]["name"];
                $filetype = $_FILES["photo"]["type"];
                $filesize = $_FILES["photo"]["size"];
            
                // Verify file extension
                $ext = pathinfo($this->filename, PATHINFO_EXTENSION);
                if(!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");
            
                // Verify file size - 5MB maximum
                $maxsize = 5 * 1024 * 1024;
                if($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");
                
                // Verify MYME type of the file
                if(in_array($filetype, $allowed)){
                    $this->rutaArchivo = "C:/xampp/htdocs/mini-master/archivos/" . $this->filename;
                    // Check whether file exists before uploading it
                    if(file_exists($this->rutaArchivo)){
                        echo $this->filename . " is already exists.";
                    } else{
                        move_uploaded_file($_FILES["photo"]["tmp_name"], $this->rutaArchivo);
                        echo "El archivo fué cargado satisfactoriamente !!";
                    } 
                } else{
                    echo "Error: There was a problem uploading your file. Please try again."; 
                }                

            } else{
                echo "Error: " . $_FILES["photo"]["error"];
            }
        }
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
