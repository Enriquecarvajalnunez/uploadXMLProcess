<?php

namespace App;

use PhpOffice\PhpSpreadsheet\IOFactory;//IOFactory adivina el tipo de plantilla con la que se trabaja
use PhpOffice\PhpSpreadsheet\Spreadsheet;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
                
    public function __construct($rutaArchivo, $filename)
    {     
        $documento = IOFactory::load($rutaArchivo);//lectura del archivo

        $worksheet = $documento->getActiveSheet();//obtiene hoja activa
        $Header = '››' .$this->espacios(3).'809224'.$this->espacios(49).'PA01XS0317A0'.$this->espacios(22).'Y33Y'.$this->espacios(22);
        $Piepagina = 'END'. $this->espacios(57). '››END'.$this->espacios(55); 

        $celda = '';
        $int = 1;
        
        foreach($worksheet->getRowIterator(2) as $row)//iterados de filas comienza en fila 2    
        {   
            
            $cellIterator = $row->getCellIterator();//Iterador de celdas recorre las celdas                                              
                                                                                            
            /*Imprime contenido de celdas*/
            $i=1; //itera entre columnas en excel inicia desde el indice 1, variable bandera
            foreach ($cellIterator as $cell) //columnas
            {             
            
            if($i==1)
                {                        
                    $Header.= str_pad('P0'.$cell->getValue(),18,chr(32),STR_PAD_RIGHT); //obtiene valor de la celda                
                    $i++;
                
                }else
                {
                    $Header.=str_pad($cell->getValue(), 4, '0', STR_PAD_LEFT) .$this->espacios(8); //obtiene valor de la celda                                     
                }                         
            }
            
        }

        $Header.= $Piepagina;        
        $report_output = 'C:/xampp/htdocs/mini-master/archivos/'.$filename.'.txt';
        file_put_contents($report_output,$Header);  
        
        echo 'PROCESO FINALIZADO CON EXITO !!';
    }
    
    //Función para concatenar espacios
    function espacios($nespacios)
    {
        return str_pad(chr(32), $nespacios, chr(32), STR_PAD_RIGHT);
    }
    
}
