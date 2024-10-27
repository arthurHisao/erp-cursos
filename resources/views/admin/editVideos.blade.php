@extends('template.templateAdmin')

@section('content')
    <div class="container"> 
        <div class="desktop content">
            <h2 class="text-center mb-5">Editar vídeos</h2>
                <div class="row">
                    <div class="col-sm">
                        <button class="btn alter-tab mb-5">
                            <img src="{{url('assets/images/edit.png')}}"/>
                            <span class="text-white">Editar descrição do vídeo</span>
                        </button>
                        <button class="btn alter-tab mb-5">
                            <img src="{{url('assets/images/upload.png')}}"/>
                            <span class="text-white">Fazer upload da imagem</span>
                        </button>
                    </div>
                </div>

                <form id="form-edit-video" method="post">
                    @csrf
                    <div class="form-group mb-4">
                        <label>Insira um título para o vídeo</label>
                        <input type="text" class="form-control" name="title" placeholder="Título do video">
                    </div>

                    <div class="form-group mb-4">
                        <label>Insira um nome do link</label>
                        <input type="text" class="form-control" name="link" placeholder="Link do seu video">
                    </div>

                    <div class="form-group mb-4">
                        <label>Categoria do vídeo</label>
                        <select class="form-control" name="categories" >
                            <option>Selecione uma categoria</option>
                            <option value="ERP">ERP</option>
                            <option value="Desenvolvimento de Softwares">Desenvolvimento de Softwares</option>
                            <option value="Design">Design</option>
                            <option value="Outros">Outros</option>
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label>Insira uma descrição do vídeo</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
                    </div>

                    <div class="text-center">
                        <a class="text-white delete" href="{{route('admin.delete.video', $videoId->id)}}">
                            Deletar este vídeo
                        </a>
                    </div>

                    <div class="text-center">
                        <p id="msg" class="alert"></p>
                        <button class="btn btn-vlight-orange">Salvar</button>
                    </div>
                </form>


                <form id="form-upload-image" method="post">
                    @csrf
                    <div class="text-center drop-area mb-3">
                        <div id="img-container"></div>
                        <p class="message">Insira ou arraste um arquivo</p>
                        <input type="file" id="file" name="file">
                    </div>                    
                    
                    <div class="text-center">
                        <div id="progress" class="mb-3"></div>
                        <p class="success-message"></p>
                        <button id="btn-image" class="btn btn-vlight-orange">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    <script src="{{url('assets/js/EditVideos.js')}}"></script>
    <script src="{{url('assets/js/utils/DropImages.js')}}"></script>
    <script src="{{url('assets/js/utils/Delete.js')}}"></script>
@endsection