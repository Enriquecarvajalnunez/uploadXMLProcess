<?php
namespace App;

use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Upload extends Model
{
                
    public function __construct($rutaArchivo, $filename, $options, $pedido)
    {             
        
        //aqui en options lo recorre con un foreach y dependiendo si es mar, currier se realiza la accion necesaria
        $rutaArchivo = storage_path('app/' . $rutaArchivo);
        
        // Cargas el archivo desde el sistema de archivos de Laravel con PhpSpreadsheet
        $documento = IOFactory::load($rutaArchivo);

        $worksheet = $documento->getActiveSheet();//obtiene hoja activa
        $Header = '››' .$this->espacios(3).'809224'.$this->espacios(49).'PA01'.$pedido. $this->espacios(22).'Y33Y'.$this->espacios(22);
        $Piepagina_currier = $this->espacios(30).'END'. $this->espacios(57). '››END'.$this->espacios(55); 
		$Piepagina_Mar = 'END'. $this->espacios(57). '››END'.$this->espacios(55); //XS -- lo tenia se quito
		$Piepagina_aereo = $this->espacios(30).'END'. $this->espacios(57). '››END'.$this->espacios(55); //XD-- no lo tenia

        $celda = '';
        $int = 1;

        if($options[0] == "currier")
        {
            $Header = '››' .$this->espacios(3).'809224'.$this->espacios(49).'PA01'.$pedido. $this->espacios(22).'Y11Y'.$this->espacios(22);
            foreach($worksheet->getRowIterator(1) as $row)//iterados de filas comienza en fila 1
            {
                $cellIterator = $row->getCellIterator();//Iterador de celdas recorre las celdas
                //Imprime contenido de celdas
                $i=1; //itera entre columnas en excel inicia desde el indice 1, variable bandera
                foreach ($cellIterator as $cell) //columnas
                {
                    if($i==1)
                    {
                            $Header.= str_pad('P'.$cell->getValue(),18,chr(32),STR_PAD_RIGHT);
                            $i++;
                    }else
                        {
                            $Header.=str_pad($cell->getValue(), 4, '0', STR_PAD_LEFT) .$this->espacios(8);
                        }
                }
				$Header.= $Piepagina_currier;        
				$report_output = 'E:/Sites/uploadXMLProcess/storage/app/'.$filename.'.txt';  		
				file_put_contents($report_output,$Header);
            }
        }elseif($options[0] == "aereo"){
			//XD -> aéreo
            $Header = '››' .$this->espacios(3).'809224'.$this->espacios(49).'PA01'.$pedido. $this->espacios(22).'Y22Y'.$this->espacios(22);
            foreach($worksheet->getRowIterator(1) as $row)//iterados de filas comienza en fila 1
            {
                $cellIterator = $row->getCellIterator();//Iterador de celdas recorre las celdas
                //Imprime contenido de celdas
                $i=1; //itera entre columnas en excel inicia desde el indice 1, variable bandera
                foreach ($cellIterator as $cell) //columnas
                {
                    if($i==1)
                    {
                        $Header.= str_pad('P'.$cell->getValue(),18,chr(32),STR_PAD_RIGHT);
                        $i++;
                    }else
                    {
                        $Header.=str_pad($cell->getValue(), 4, '0', STR_PAD_LEFT) .$this->espacios(8);
                    }
                }				
            }
			
			$Header.= $Piepagina_aereo;        
			$report_output = 'E:/Sites/uploadXMLProcess/storage/app/'.$filename.'.txt';  		
			file_put_contents($report_output,$Header);
			
        }elseif($options[0] == "mar"){
			//XS -> maritimo
            $Header = '››' .$this->espacios(3).'809224'.$this->espacios(49).'PA01'.$pedido. $this->espacios(22).'Y33Y'.$this->espacios(22);			
            foreach($worksheet->getRowIterator(1) as $row)//iterados de filas comienza en fila 1
            {
                $cellIterator = $row->getCellIterator();//Iterador de celdas recorre las celdas
                //Imprime contenido de celdas
                $i=1; //itera entre columnas en excel inicia desde el indice 1, variable bandera
                foreach ($cellIterator as $cell) //columnas
                {
                    if($i==1)
                    {
                        $Header.= str_pad('P'.$cell->getValue(),18,chr(32),STR_PAD_RIGHT);
                        $i++;
                    }else
                    {
                        $Header.=str_pad($cell->getValue(), 4, '0', STR_PAD_LEFT) .$this->espacios(8);
                    }
                }
            }

			$Header.= $Piepagina_Mar;        
			$report_output = 'E:/Sites/uploadXMLProcess/storage/app/'.$filename.'.txt';  		
			file_put_contents($report_output,$Header);  
        }
        /*        
        $Header.= $Piepagina;        
        $report_output = 'E:/Sites/uploadXMLProcess/storage/app/'.$filename.'.txt';  		
        file_put_contents($report_output,$Header);  
                
        echo '<script language="javascript">alert("Proceso terminado satisfactoriamente !!");</script>';
		*/
    }
    
    //Concatenar espacios
    function espacios($nespacios)
    {
        return str_pad(chr(32), $nespacios, chr(32), STR_PAD_RIGHT);
    } 
    
}