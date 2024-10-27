@extends('template.templateAdmin')

@section('content')
<div class="container-fluid">
    <div class="container text-center">
        <div class="config-form">
            <!--formulario de video-->
            <div class="upload-form">
                <h1 class="text-white text-center">Cofiguração de perfil</h1>
                <form class="drop-form" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($image->file_name))
                    <img id="user-image-circle" class="m-3 user-image-big"
                        src="{{url('/user-profile/' .$userId.'/'. $image->file_name)}}">

                    <!--foto-->
                    <div id="image-preview"></div>

                    <div>
                        <div class="text-white text-center mb-4 px-2">
                            <h4 class="user-name">{{ Auth::guard('userAdmin')->user()->name }}</h4>
                            <h6>{{$users->permission}}</h6>
                        </div>

                        <div class="list-group border-light custom-width">
                            <a class="text-white list-group-item list-group-item-action bg-dark" href="#myModal"
                                data-toggle="modal" data-target="#myModal" data-backdrop="static" id="open-modal">
                                Alterar foto
                            </a>

                            <a class="text-white list-group-item list-group-item-action bg-dark" data-toggle="modal"
                                data-target="#exampleModal">
                                Alterar Nome ou E-mail
                            </a>

                            <a class="text-white list-group-item list-group-item-action bg-dark"
                                href="{{route('user.logout')}}">
                                Sair da conta
                            </a>
                        </div>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

<script src="{{url('assets/js/AdminProfile.js')}}"></script>
@endsection