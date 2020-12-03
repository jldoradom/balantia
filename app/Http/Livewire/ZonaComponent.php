<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Providers\FileHelperProvider;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ZonaComponent extends Component
{
    public $archivo,$csv,$acciones=false,$path,$filename,
    $csvs = [],
    $ids = [],
    $fechasdesde = [],
    $fechashasta = [],
    $fechasmostrardesde = [],
    $fechasmostrarhasta = [],
    $idscomprobar = [],
    $fechasrepetidasdesde = [],
    $fechasrepetidashasta = [],
    $zonas = [],
    $zonasrepetidas = [],
    $leeido= false,
    $idInsertado,$desde,$hasta,$cadena_fechas,$cantidadfechas,$cantidadrepetidos,$filenmae;


    protected $listeners = [
        'file_upload_end' => 'handleFileUploaded',
        'csvhandleFileUploaded'
    ];

    public function render()
    {
        return view('livewire.zona-component');
    }

    public function csvhandleFileUploaded($file){
        $this->csvs[] = $file;
    }



    // Funcion para subir los csv
    public function subirCsv(){
        if(!$this->csvs){
            return null;
        }

        foreach($this->csvs as $csv){
            try{
                // Obtenemos los datos del csv
                $info = FileHelperProvider::getFileInfo($csv['data']);
                $this->filename = $csv['filename'];
                $path = "public/csv/{$this->filename}";
                // Almacenamos el csv
                Storage::put($path, $info['decoded_file']);

            } catch(\Exception $e) {
                dd($e->getMessage());
            }
        }



    }


    // Funcion para leer el archivo csv y encontrar los registros por un id pasado por el front
    public function leercsv(){
        // Abrimos el archivo csv
        $url =  "../public/storage/csv/". $this->filename;
        if (($gestor = fopen($url, "r")) !== FALSE) {
            // Pasamos por cada linea del archivo
            while (($datos = fgetcsv($gestor, ",")) !== FALSE) {
                $numero = count($datos);
                for ($i=0; $i < $numero; $i++) {
                    // Sacamos los datos de cada linea
                    $datoslinea = explode(";", $datos[$i]);
                    // Eliminamos la cabecera comprobando que el primer datos sea numerico
                    if(is_numeric($datoslinea[$i])){
                        $id = $datoslinea[$i];
                        $desde = $datoslinea[2];
                        $hasta = $datoslinea[3];
                        // Arrays con todos los datos del archivo
                        $this->ids []  = $id;
                        $this->fechasdesde []  = $desde;
                        $this->fechashasta []  = $hasta;
                    }
                }
            }
            $this->cantidadfechas = 0;
            // Bucle sobre todo el archivo
            for($i = 0; $i < count($this->ids) ; $i++){
                // si el id coincide con el id insertado por el usuario obtenemos los datos de la fila
                if($this->ids[$i] === $this->idInsertado){
                    $this->fechasmostrardesde [] = $this->fechasdesde [$i];
                    $this->fechasmostrarhasta [] = $this->fechashasta [$i];
                    $this->cantidadfechas++;
                }


            }

            fclose($gestor);
        }

    }
    // Funcion que busca los registros duplicados
    public function duplicados(){
        // Abrimos el archivo csv
        $url =  "../public/storage/csv/". $this->filename;
        if (($gestor = fopen(  $url, "r")) !== FALSE) {
            // Pasamos por cada linea del archivo
            while (($datos = fgetcsv($gestor, ",")) !== FALSE) {
                $numero = count($datos);
                for ($i=0; $i < $numero; $i++) {
                    // Sacamos los datos de cada linea
                    $datoslinea = explode(";", $datos[$i]);
                    // Eliminamos la cabecera comprobando que el primer datos sea numerico
                    if(is_numeric($datoslinea[$i])){
                        $id = $datoslinea[$i];
                        $zona = $datoslinea[1];
                        $desde = $datoslinea[2];
                        $hasta = $datoslinea[3];
                        // Arrays con todos los datos del archivo
                        $this->ids []  = $id;
                        $this->zonas []  = $zona;
                        $this->fechasdesde []  = $desde;
                        $this->fechashasta []  = $hasta;
                    }
                }
            }

            // Agrupo los valores del array
            $resultado = array_count_values($this->ids);
            $claves=[];
            foreach($resultado as $clave => $valor){
                // Si el valor es mayor de 1 significa que hay mas de un registro con el mismo id
                if($valor > 1){
                    $claves [] = $clave;
                }
            }
            // Bucle sobre los ids del archivo
            for($i=0; $i < count($this->ids) ; $i++){
                // Si la clave este en el array significa que esta repetido
                if(in_array( $this->ids[$i], $claves)){
                    $this->idscomprobar [] =  $this->ids[$i];
                    $this->fechasrepetidasdesde [] = $this->fechasdesde [$i];
                    $this->fechasrepetidashasta [] = $this->fechashasta [$i];
                    $this->zonasrepetidas [] = $this->zonas [$i];

                }
            }

            fclose($gestor);
        }

    }

}
