<!DOCTYPE html>
<html lang="en">

@include('include.header')

<body>
    <div class="overlay"></div>
    <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
    <source src="{{ asset('asset/mp4/Honda CB190R.mp4') }}">	
  </video>

  <div class="masthead">
        <div class="masthead-bg"></div>
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-12 my-auto">
                    <div class="masthead-content text-white py-5 py-md-0">
                        <h1 class="mb-3">Procesamiento de datos !</h1>
                        <p class="mb-5">Procese los datos del archivo de excel a archivo de texto plano !</p>
                            
                        <!--Formulario para subir archivos -->
                        <form action="{{ action('Controlador@create') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="fileSelect">Filename:</label>
                                <input type="file" name="photo" id="fileSelect" onchange="nombre(this.value)" class="form-control-file">
                            </div>

                            <div class="form-group">
                                <label for="filename">Rename file</label>
                                <input type="text" name="filename" id="filename" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Formas de transporte:</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="mar" name="formatos[]" value="mar">
                                    <label class="form-check-label" for="mar">marítimo</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="currier" name="formatos[]" value="currier">
                                    <label class="form-check-label" for="currier">Currier</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="aereo" name="formatos[]" value="aereo">
                                    <label class="form-check-label" for="aereo">Aereo</label>
                                </div>
                            </div>
                            <div class="form-group">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary btn-block btn-sm" type="submit">PROCESAR!</button>
                                    </div>
                            </div>


                            <p><strong>Note:</strong> únicamente formatos .xls peso máximo de 5 MB.</p>
                        </form>
                    </div>
                </div>
            </div>
        </div>        
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('asset/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('asset/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Custom scripts for this template -->
    <script src="{{ asset('asset/js/coming-soon.min.js') }}"></script>
    <script>
        function nombre(fic) {
            fic = fic.split('\\');
            document.getElementById('filename').value = fic[fic.length-1].split('.')[0];
        }
    </script>
</body>

</html>