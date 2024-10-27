<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>
    <link rel="stylesheet" href="{{url('assets/css/bootsrap/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/adminPage.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/croppie.css')}}">
    <script src="{{url('assets/js/jquery/jquery.min.js')}}"></script>
    <script src="{{url('assets/js/bootsrap/bootstrap.min.js')}}"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="mobile" href="{{route('admin.list.users')}}">
            <img src="{{url('assets/images/title.png')}}" class="img-logo d-inline-block align-top" alt="">
        </a>

        <div class="m-3 collapse navbar-collapse" id="navbarNavDropdown">
            <!--logo-->
            <a href="{{route('admin.list.users')}}">
                <img src="{{url('assets/images/title.png')}}" class="img-logo d-inline-block align-top" alt="">
            </a>
        </div>

        <div class="dropdown">
            <button class="btn dropdown-toggle text-white" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                @if(isset($userId))
                <b class="user-name">{{Auth::guard('userAdmin')->user()->name }}</b>
                @endif

                @if(isset($image->file_name))
                <img class="m-3 user-image" src="{{url('/user-profile/' .$userId.'/'. $image->file_name)}}">
                @endif
            </button>

            <div class="dropdown-menu bg-dark" aria-labelledby="dropdownMenuButton">
                <a class="text-white dropdown-item" id="logout" href="{{route('user.logout')}}">Sair</a>
            </div>
        </div>
        </div>
    </nav>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Alterar fotos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body text-center">
                    <form method="post" id="form" enctype="multipart/form-data">
                        <button for="file" id="btn-img" class="btn">
                            <input name="input_file" id="file" type="file">
                            <img class="select-img" src="{{url('assets/images/photo.png')}}">
                            <small>Selecione uma foto</small>
                        </button>

                        <button id="btn-save" class="btn">
                            <img class="select-img" src="{{url('assets/images/save.png')}}">
                            <small>Salvar alterações<small>
                        </button>

                        <!--foto-->
                        <div id="image-preview"></div>
                    </form>
                </div>
                <!--mensagem do modal-->
                <div id="message" class="text-center alert"></div>
            </div>
        </div>
    </div>


    <!-- Modal update -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Seus Dados</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <form id="form-update" method="POST">
                        <div calss="form-group">
                            <label class="float-sm-left">Nome</label>
                            <input type="text" class="form-control mb-4" name="name"
                                value="{{Auth::guard('userAdmin')->user()->name}}" placeholder="Seu None">
                        </div>

                        <div calss="form-group">
                            <label class="float-sm-left">E-mail</label>
                            <input type="text" class="form-control mb-4" name="email"
                                value="{{Auth::guard('userAdmin')->user()->email}}" placeholder="Seu E-mail">
                        </div>
                        <button type="submit" id="btn-update" class="btn btn-primary">Atualizar os Dados</button>
                        <div class="msg alert"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="text-white d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="mg-1 bg-dark" id="sidebar-wrapper">
            <div class="sidebar-heading p-4">Painel administrativo</div>
            <div class="list-group list-group-flush">
                <a href="{{route('admin.list.users')}}"
                    class="text-white list-group-item list-group-item-action bg-dark">Listar Usuário interno</a>
                <a href="{{route('admin.list.students')}}"
                    class="text-white list-group-item list-group-item-action bg-dark">Listar Alunos</a>
                <a href="{{route('admin.list.socialite')}}"
                    class="text-white list-group-item list-group-item-action bg-dark">Listar Alunos logado com redes
                    sociais</a>
                <a href="{{route('admin.profile')}}"
                    class="text-white list-group-item list-group-item-action bg-dark">Configuração</a>
                <a href="{{route('instructor.upload')}}"
                    class="text-white list-group-item list-group-item-action bg-dark">Fazer upload de vídeos</a>
                <a href="{{route('instructor.videos')}}"
                    class="text-white list-group-item list-group-item-action bg-dark">Detalhes da vídeo aula</a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <button class="text-white btn" id="menu-toggle">☰</button>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            @yield('content')

        </div>
    </div>

    <footer>
        <div class="footer text-center">
            <div class="social-media-column">
                <span class="footer-title">Nossa Redes Sociais</span>
                <div>
                    <!--a href="https://icons8.com/icon/ARy6tFUfwclb/github">GitHub icon by Icons8</a-->
                    <img src="{{url('assets/images/git4.png')}}" class="icon-effects" />
                    <!--a href="https://icons8.com/icon/118502/facebook">Facebook icon by Icons8</a-->
                    <img src="{{url('assets/images/facebook-icon.png')}}" class="icon-effects" />
                    <!--<a href="https://icons8.com/icon/3861/twitter">Twitter icon by Icons8</a>-->
                    <img src="{{url('assets/images/twitter-icon.png')}}" class="icon-effects" />
                </div>
                <hr class="hline">
                </hr>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-md-4 mb-4">
                        <a href="{{route('user.index')}}">
                            <img src="{{url('assets/images/title.png')}}" class="footer-logo">
                        </a>
                        <!--span class="footer-title">ERP CURSOS</span-->
                    </div>
                    <div class="col-xs-12 col-md-4 mb-4">
                        <span class="footer-title">Menu</span>
                        <div class="menu-column">
                            <ul class="navbar-nav">
                                <li>
                                    <a class="footer-links" href="{{route('user.login')}}">Entrar</a>
                                </li>
                                <li>
                                    <a class="footer-links" href="{{route('user.create')}}">Cadastrar</a>
                                </li>
                                <li>
                                    <a class="footer-links" href="{{route('user.about')}}">Sobre Nós</a>
                                </li>
                                <li>
                                    <a class="footer-links" href="{{route('user.courses')}}">Cursos</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4 mb-4">
                        <span class="footer-title">Entre em contato</span>
                        <div class="contact-column">
                            <!--<a href="https://icons8.com/icon/AltfLkFSP7XN/whatsapp">WhatsApp icon by Icons8</a>-->
                            <img src="{{url('assets/images/whatsapp.png')}}" />
                            <a class="footer-links" href="#">(11)98357-4102</a>
                        </div>
                        <div class="contact-column">
                            <!--<div>Icons made by <a href="https://smashicons.com/" title="Smashicons">Smashicons</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div>-->
                            <img src="{{url('assets/images/phone.png')}}" />
                            <a class="footer-links" href="#">(11)3807-9211</a>
                        </div>
                    </div>
                </div>
            </div>
    </footer>
</body>
<script src="{{url('assets/js/utils/LeftSideBar.js')}}"></script>
<script src="{{url('assets/js/effect/Selected.js')}}"></script>
<script src="{{url('assets/js/plugin/croppie.min.js')}}"></script>
<script src="{{url('assets/js/utils/Photo.js')}}"></script>

</html>