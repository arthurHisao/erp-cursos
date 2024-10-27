@extends('template.template')

@section('content')
<!-- ============ inicio modal ============= -->
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModal" aria-hidden="true">
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
                    @if(isset($userId))
                        <div calss="form-group">
                            <label class="float-sm-left">Nome</label>
                            <input type="text" class="form-control mb-4" name="name" value="{{Auth::user()->name}}"
                                placeholder="Seu None">
                        </div>

                        <div calss="form-group">
                            <label class="float-sm-left">E-mail</label>
                            <input type="text" class="form-control mb-4" name="email" value="{{Auth::user()->email}}"
                                placeholder="Seu E-mail">
                        </div>

                        <div class="mb-3">
                            @if(isset(auth()->user()->id))
                            <a class="delete" href="{{route('user.delete', auth()->user()->id)}}">Deletar a conta atual</a>
                            @endif
                        </div>
                        <button type="submit" id="btn-update-socialite" class="btn btn-primary">Atualizar os Dados</button>
                    @endif
                    <div class="msg alert"></div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--=================== fim do modal====================== -->

<div class="container">
    <div class="pd-top">
        <!-- alerta -->
        @if(isset($error) && $error == "Verificamos que ainda não efetuou o pagamento")
            <div class="content">
                <div class="text-center text-white">
                    <h2 class="mb-4">{{$error}}</h2>
                    <p>Caso tenha efetuado o pagamento aguarde alguns dias que em breve será liberado acesso para o curso.
                    </p>

                    <!-- Acordiao  -->
                    <div id="accordion">
                        <div class="card bg-dark">
                            <div class="card-header" id="headingThree">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed" data-toggle="collapse"
                                        data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        <span class="text-white">Veja como gerar boleto clicando aqui</span>
                                    </button>
                                </h5>
                            </div>

                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                data-parent="#accordion">
                                <div class="card-body">
                                    <!-- Primeira imagem -->
                                    <li>Para efetuar o pagamento clique em <b>Pagar Curso</b></li>
                                    <div class="text-space"></div>
                                    <img class="img-tutorial" src="{{url('assets/images/info.png')}}">
                                    <div class="text-space"></div>

                                    <!--Segunda imagem -->
                                    <li>Em seguida será redirecionado para página de pagamento, selecione o plano desejado</li>
                                    <div class="text-space"></div>
                                    <img class="img-tutorial" src="{{url('assets/images/payment.png')}}">
                                    <div class="text-space"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center text-white text-space">
                        <h6>Caso tenha dúvidas ligue para nós</h6>
                        <span>Telefone: (11)3807-9211 - Whatsapp: (11)98357-4102</span>
                    </div>
                </div>
            </div>
        </div>
        <!--============== erro  quando nao encontrar o curso =================-->
        @elseif(isset($error))
            <h2 class="text-white text-center">Resultado da pesquisa</h2>
            <div class="container">
                <div class="content">
                    <!--pesquisar-->
                    <div class="d-flex justify-content-center p-3">
                        <form class="form-inline" action="{{route('student.search.courses')}}" method="get" role="search">
                            <input type="search" name="search" id="input-search" class="input-search mb-3 mr-3"
                                aria-label="Pesquisar" required="">
                            <label class="placeholder">Procurar cursos</label>
                            <button class="btn btn-search mb-3 p-1" type="submit">
                                <!--Icons made by <a href="https://www.flaticon.com/authors/those-icons" title="Those Icons">Those Icons</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a>-->
                                <img src="{{url('assets/images/search.png')}}">
                            </button>                        
                        </form>
                    </div>
                    <!-- ======= Menssagem de erro ==========-->
                    <div class="text-center text-white">
                        <h5>{{$error}}</h5>
                    </div>
                </div>
            </div>

        <!-- ======= inicializando os cursos ========== -->
        @elseif(isset($courses))
            <h2 class="text-white text-center mb-5">Meus cursos</h2>
            <!--pesquisar-->
            <div class="d-flex justify-content-center p-3">
                <form class="form-inline" action="{{route('student.search.courses')}}" method="get" role="search">
                    <input type="search" name="search" id="input-search" class="input-search mb-3 mr-3" aria-label="Pesquisar"
                        required="">
                    <label class="placeholder">Procurar cursos</label>
                    <button class="btn btn-search mb-3 p-1" type="submit">
                        <!--Icons made by <a href="https://www.flaticon.com/authors/those-icons" title="Those Icons">Those Icons</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a>-->
                        <img src="{{url('assets/images/search.png')}}">
                    </button>
                </form>
            </div>
        </div>

        <div class="row justify-content-center mt-5">
            @foreach($courses as $course)
                <div class="col-8 col-sm-7 col-md-6 col-lg-4 mb-5">
                @if($course->video_link_name === "-")
                    <a href="#">
                        <img class="course-thumb" src="{{url('assets/images/camera.png')}}" alt="{{$course->title}}">
                        <div class="course-content">
                            <h5 class="text-white">vídeo indisponível<h5>
                        </div>
                    </a>
                @else
                    <a href="{{url('/aula/' .$course->video_link_name .'/'. $course->id)}}">
                        <img class="course-thumb" src="{{$course->video_thumbnail}}" alt="{{$course->title}}">
                    </a>
                    <div class="course-content">
                        <h5 class="text-white">{{$course->video_name}}<h5>
                        <span class="course-description text-white">{{$course->category}}</span>
                    </div>
                @endif
            </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center">
            {{ isset($search) ? $courses->appends(['search' => $search])->links() : $courses->links()}}
        </div>
        <script src="{{url('assets/js/effect/inputSearch.js')}}"></script>
    @endif
    </div>
</div>

<script src="{{url('assets/js/plugin/croppie.min.js')}}"></script>
<script src="{{url('assets/js/utils/Photo.js')}}"></script>
<script src="{{url('assets/js/utils/Delete.js')}}"></script>
<script src="{{url('assets/js/utils/InputMask.js')}}"></script>
<script src="{{url('assets/js/StudentPage.js')}}"></script>
@endsection