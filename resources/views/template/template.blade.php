<!DOCTYPE html>
<html lang="pt-br">    
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link type="text/css" rel="stylesheet" href="{{url('assets/css/bootsrap/bootstrap.min.css')}}">
        <link type="text/css" rel="stylesheet" href="{{url('assets/css/style.css')}}">
        <link rel="stylesheet" href="{{url('assets/css/croppie.css')}}">
        <script src="{{url('assets/js/jquery/jquery.min.js')}}"></script>
        <script src="{{url('assets/js/plugin/scrollreveal.min.js')}}"></script>
        <script src="{{url('assets/js/bootsrap/bootstrap.min.js')}}"></script>
    </head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <!--logo-->
        <div class="mr-4">
            <a href="{{route('user.index')}}">
                <img src="{{url('assets/images/title.png')}}" class="img-logo d-inline-block align-top" alt="">
            </a>
        </div>

        <!-- ===========menu da pagina do aluno mobile =============== -->
        @if(isset($userId) || isset($socialId))
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav mobile">
                <li class="nav-item">
                    <a id="search-link" class="nav-link" href="#">Pesquisar</a>
                </li>
            @if(request()->is("aluno"))
                <li class="nav-item">
                    <a class="text-white dropdown-item" href="#myModal" data-toggle="modal" data-target="#myModal"
                        data-backdrop="static" id="open-modal">Alterar foto</a>
                </li>

                <li class="nav-item">
                    <a class="text-white dropdown-item" href="{{route('user.plan')}}">Pagar Curso</a>
                </li>

                @if(isset($socialId))
                    <li class="nav-item">
                        <a class="text-white dropdown-item delete" href="{{route('user.delete', $socialId)}}">Deletar a conta</a>
                    </li>
                
                @else
                    <li class="nav-item">
                        <a class="text-white dropdown-item" data-toggle="modal" href="updateModal"
                            data-target="#updateModal">
                            Alterar e-mail
                        </a>    
                    </li>
                @endif
                <a class="text-white dropdown-item" id="logout" href="{{route('user.logout')}}">Sair</a>
            @else
                <a class="text-white dropdown-item" id="logout" href="{{route('user.logout')}}">Sair</a>
            @endif

                <li class="nav-item p-4">
                @if(isset($image->file_name))
                    @if(isset($userId))
                        <img class="user-image" src="{{url('/user-profile/' .Auth::user()->id .'/'. $image->file_name)}}">
                    @elseif(isset($socialId))
                        <img class="user-image" src="{{url('/user-profile/socialite/'.$socialId .'/'. $image->file_name)}}">
                    @else
                        <img class="user-image" src="{{url('assets/images/no-user.png')}}">
                    @endif
                @endif

                @if(session()->has('name'))
                    <span class="text-white user-name">{{ $userName }}</span>
                @else
                    <span class="text-white user-name">{{ $userName }}</span>
                @endif
                </li>   
            </ul>
        </div>
        <!-- ============ fim do menu mobile pagina do aluno========= -->

        <!-- ========= menu da pagina do aluno desktop =============== -->
        <div class="dropdown desktop">
            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                @if(session()->has('name'))
                    <span class="text-white mr-2 user-name">{{ session()->get('name') }}</span>
                @else
                    <span class="text-white mr-2 user-name">{{ $userName }}</span>
                @endif

                @if(isset($image->file_name))
                    @if(isset($userId))
                        <img class="user-image" src="{{url('/user-profile/' .Auth::user()->id .'/'. $image->file_name)}}">
                    @elseif(isset($socialId))
                        <img class="user-image" src="{{url('/user-profile/socialite/'.$socialId .'/'. $image->file_name)}}">
                    @else
                        <img class="user-image" src="{{url('assets/images/no-user.png')}}">
                    @endif
                @endif
            </button>
            
            <!--link dropdown-->
            <div class="dropdown-menu bg-dark" aria-labelledby="dropdownMenuButton">
                @if(request()->is("aluno"))
                    <a class="text-white dropdown-item" href="#myModal" data-toggle="modal" data-target="#myModal"
                        data-backdrop="static" id="open-modal">Alterar foto</a>

                    <a class="text-white dropdown-item" href="{{route('user.plan')}}">Pagar Curso</a>
            
                    @if(isset($socialId))
                        <a class="text-white dropdown-item delete" href="{{route('user.delete', $socialId)}}">Deletar conta</a>
                    @else
                        <a class="text-white dropdown-item" data-toggle="modal" href="updateModal"
                            data-target="#updateModal">
                            Alterar e-mail
                        </a>    
                    @endif
                
                    <a class="text-white dropdown-item" id="logout" href="{{route('user.logout')}}">Sair</a>
                @else
                    <a class="text-white dropdown-item" id="logout" href="{{route('user.logout')}}">Sair</a>
                @endif
            </div>
        </div>
        <!--============= fim do menu ====================-->
        @else 
            <input id="search-mobile" class="form-control mb-4" type="search" placeholder="Procurar cursos" aria-label="Pesquisar" required>
            <div class="overlay"></div> 

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a id="search-link" class="nav-link" href="#">Pesquisar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('user.index')}}/#fourth-column">Planos<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('user.login')}}">Entrar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('user.create')}}">Cadastrar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('user.about')}}">Sobre nós</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('user.courses')}}">Cursos</a>
                    </li>
                    <li class="nav-item mb-4">
                        <!--pesquisar-->
                        <form class="form-inline mobile" action="{{route('user.search.courses')}}" method="get" role="search">
                            <input type="search" name="search" id="input-search" class="input-search" aria-label="Pesquisar" required="" placeholder="Procurar cursos">
                            <button class="btn btn-search m-3 my-2 my-sm-0" type="submit">
                                <!--Icons made by <a href="https://www.flaticon.com/authors/those-icons" title="Those Icons">Those Icons</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a>-->
                                <img src="{{url('assets/images/search.png')}}">
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

            <!--pesquisar-->
            <form class="form-inline desktop" action="{{route('user.search.courses')}}" method="get" role="search">
                <input type="search" name="search" id="input-search" class="input-search" aria-label="Pesquisar" required="">
                <label class="placeholder">Procurar cursos</label>
                <button class="btn btn-search m-3 my-2 my-sm-0" type="submit">
                    <!--Icons made by <a href="https://www.flaticon.com/authors/those-icons" title="Those Icons">Those Icons</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a>-->
                    <img src="{{url('assets/images/search.png')}}">
                </button>
            </form>
        @endif
        <!--botao do menu mobile-->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>   

    @yield('content')
    
    <footer>
        <div class="footer text-center">
            <div class="social-media-column">
                <span class="footer-title">Nossa Redes Sociais</span>
                <div>
                    <!--a href="https://icons8.com/icon/ARy6tFUfwclb/github">GitHub icon by Icons8</a--> 
                    <img src="{{url('assets/images/git4.png')}}" class="icon-effects"/>           
                    <!--a href="https://icons8.com/icon/118502/facebook">Facebook icon by Icons8</a-->
                    <img src="{{url('assets/images/facebook-icon.png')}}" class="icon-effects"/>        
                    <!--<a href="https://icons8.com/icon/3861/twitter">Twitter icon by Icons8</a>-->        
                    <img src="{{url('assets/images/twitter-icon.png')}}" class="icon-effects"/>    
                </div>
                <hr class="hline"></hr>
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
                            <img src="{{url('assets/images/whatsapp.png')}}"/>
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
    <!--scripts de effeitos-->
    <script src="{{url('assets/js/effect/UserNav.js')}}"></script>
    <script src="{{url('assets/js/effect/Animation.js')}}"></script>
</html>
