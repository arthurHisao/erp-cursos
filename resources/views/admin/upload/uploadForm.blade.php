@extends('template.templateAdmin')

@section('content')
<div class="container-fluid">
    <div class="container text-center">
        <div class="text-white config-form">
            <!--formulario de video-->
            <div class="text-white upload-form">
                <h1 class="p-4 text-center">Fazer upload de vídeos</h1>
                <form class="drop-form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="text-center drop-area">
                        <div id="img-container"></div>
                        <p class="message">Insira ou arraste um arquivo</p>
                        <input type="file" id="file" name="file" multiple>
                    </div>

                    <div class="p-4 text-center">
                        <div class="p-3 text-center">
                            <div id="progress" class="mb-3"></div>
                            <p class="success-msg"></p>
                        </div>
                        <button class="btn btn-upload">Fazer Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="{{url('assets/js/utils/DropVideos.js')}}"></script>
@endsection