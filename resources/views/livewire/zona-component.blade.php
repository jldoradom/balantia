<div class="mt-10 sm:mt-0">
    <div class="md:grid md:grid-cols-3 md:gap-6">
      <div class="md:col-span-1">
        <div class="px-4 sm:px-0">
          <h3 class="text-lg font-medium leading-6 text-gray-900">Subida de archivos csv</h3>
          <p class="mt-1 text-sm text-gray-600">
           Una vez subido el archivo se podrá acceder a las acciones sobre el archvio
          </p>
        </div>
      </div>
      <div class="mt-5 md:mt-0 md:col-span-2">
        <form wire:submit.prevent="subirCsv">
          <div class="shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 bg-white sm:p-6">
              <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-3">
                  <label for="archivo" class="block text-sm font-medium text-gray-700">Archivo</label>
                  <input type="file" accept=".csv" wire:change="$emit('file_upload_start')"  id="archivo" name="archivo"  autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                </div>

            </div>
            <div class="px-4 py-3  sm:px-6">
              <button wire:click="subirCsv"   class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Subir
              </button>
              @if($filename)
                  {{ $filename }}
              @endif
            </div>
          </div>
        </form>

      </div>
    </div>
</div>
@if($filename)
<div>
    <div class="md:grid md:grid-cols-3 md:gap-6 mt-5">
      <div class="md:col-span-1">
        <div class="px-4 sm:px-0">
          <h3 class="text-lg font-medium leading-6 text-gray-900">Fechas por Id</h3>
          <p class="mt-1 text-sm text-gray-600">
                Inserta el id para buscar en el archivo las fechas para ese id
          </p>
        </div>
      </div>
      <div class="mt-5 md:mt-0 md:col-span-2">
        <form wire:submit.prevent="leercsv">
          <div class="shadow sm:rounded-md sm:overflow-hidden">
            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">


              <div>
                <label for="idInsertado" class="block text-sm font-medium text-gray-700">
                  Id para buscar
                </label>
                <div class="mt-1">
                  <input wire:model="idInsertado" type="text" id="idInsertado" name="idInsertado"  class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md">
                </div>
              </div>


            </div>
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <button wire:click="leercsv"   class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Leer
                </button>
            </div>
            @if($cantidadfechas)
            <p>Fechas para id = {{ $idInsertado }}</p>
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        @for($i = 0; $i < $cantidadfechas; $i++)
                            @if(($cantidadfechas/2 )> $i)
                                <p>Desde:  {{ $fechasmostrardesde[$i] }}</p>
                            @endif
                        @endfor
                    </div>
                    <div class="col-6">
                        @for($i = 0; $i < $cantidadfechas; $i++)
                            @if(($cantidadfechas/2 )> $i)
                                <p>Hasta:  {{ $fechasmostrarhasta[$i] }}</p>
                            @endif
                        @endfor
                    </div>
                </div>
            </div>
        @endif
          </div>
        </form>
      </div>
    </div>
  </div>

  <div>
    <div class="md:grid md:grid-cols-3 md:gap-6 mt-5">
      <div class="md:col-span-1">
        <div class="px-4 sm:px-0">
          <h3 class="text-lg font-medium leading-6 text-gray-900">Buscar por id repetidos en el archivo</h3>
          <p class="mt-1 text-sm text-gray-600">

          </p>
        </div>
      </div>
      <div class="mt-5 md:mt-0 md:col-span-2">
        <form wire:submit.prevent="leercsv">
          <div class="shadow sm:rounded-md sm:overflow-hidden">
            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
            </div>
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <button wire:click="duplicados"   class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Buscar repetidos
                </button>
            </div>

                <p>Registros repetidos</p>
                <div class="container">
                    <div class="row">
                        <div class="col-3">
                            @foreach($idscomprobar as $id)
                                <p>ID:  {{ $id }}</p>
                            @endforeach
                        </div><div class="col-3">
                            @foreach($zonasrepetidas as $zona)
                                <p>Zona:  {{ $zona }}</p>
                            @endforeach
                        </div>
                        <div class="col-3">
                            @foreach($fechasrepetidasdesde as $desde)
                                <p>Desde:  {{ $desde }}</p>
                            @endforeach
                        </div>
                        <div class="col-3">
                            @foreach($fechasrepetidashasta as $hasta)
                                <p>Hasta:  {{ $hasta }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>

          </div>
        </form>
      </div>
    </div>
  </div>
  @endif


