@extends('template.template')

@section('content')
<section>
    <!--<a href='https://br.freepik.com/fotos/computador'>Computador foto criado por drobotdean - br.freepik.com</a>-->
    <div class="bg-banner">
        <div class="text-center box">
            <div class="container">
                <div id="carouselContent" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active text-center p-4">
                            <h1 class="carousel-title">Estude e tenha sucesso na sua carreira!</h1>
                        </div>
                        <div class="carousel-item text-center p-4">
                            <h1 class="carousel-title">Venha estudar aqui na ERP CURSOS!</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================ coluna 1 categorias de cursos ================ -->
<div class="container">
    <section>
        <div class="p-5 content text-center">
            <h2 class="text-white">Plataforma de cursos online</h2>
            <p class="text-white p-4 align-to-left">
                A melhor plataforma de tecnologia brasileira,
                com diversos cursos de tecnologias e ERP
                como: SAP, Protheus, Nomus.
            </p>
            <div class="text-space row">
                <div class="col-xs-12 col-md-12 col-lg-4">
                    <div class="img-content">
                        <img id="animation-left" class="courses" src="assets/images/gestão-integrada.jpg"
                            alt="Cursos ERP">
                    </div>
                    <div class="text-space"></div>
                    <h5 class="text-white">Gestão integrado</h5>
                </div>
                <div class="col-xs-12 col-md-12 col-lg-4">
                    <div class="img-content">
                        <img id="animation-center" class="courses" src="assets/images/lohp-category-development.jpg"
                            alt="Cursos ERP">
                    </div>

                    <div class="text-space"></div>
                    <h5 class="text-white">Desenvolvimento</h5>
                    <div class="text-space"></div>
                </div>
                <div class="col-xs-12 col-md-12 col-lg-4">
                    <div class="img-content">
                        <img id="animation-right" class="courses" src="assets/images/lohp-category-design.jpg"
                            alt="Cursos ERP">
                    </div>

                    <div class="text-space"></div>
                    <h5 class="text-white">Design</h5>
                </div>
            </div>
    </section>
    <!-- fim da coluna 1 categorias de cursos -->

    <!-- ==============Segunda coluna 2 divulgacao=================== -->
    <section>
        <div class="animation-reveal margin-top-50">
            <div class="row text-center">
                <div class="border col-sm-12 col-md column-setting">
                    <img src="{{url('assets/images/rocket-white.png')}}" />
                    <h3 class="soft-red mt-4 mb-2">Acelere a aprendizagem</h3>
                    <p class="bold-p soft-red">Estude da forma correta, preparamos a sequência correta de estudos</p>
                </div>
                <div class="border col-sm-12 col-md middle-column-setting">
                    <img src="{{url('assets/images/headphone.png')}}" />
                    <h3 class="soft-red mt-4 mb-2">Tire as suas dúvidas</h3>
                    <p class="bold-p soft-red">Professores qualificados estão dispostos a tirar as suas dúvidas</p>
                </div>
                <div class="border col-sm-12 col-md column-setting">
                    <img src="{{url('assets/images/book.png')}}" />
                    <h3 class="soft-red mt-4 mb-2">Excercícios preparados</h3>
                    <p class="bold-p soft-red">Teste o seu aprendizado através dos exercicios</p>
                </div>
            </div>
        </div>

        <div class="margin-top-50">
            <div class="animation-reveal content text-center">
                <img class="m-4 bg-second-banner" src="{{url('assets/images/banner.png')}}">
                <h3 class="text-white">Estude de qualquer lugar</h3>
                <h4 class="text-white">e de qualquer dispositivo!</h4>
            </div>
        </div>
    </section>
    <!-- fim da segunda coluna -->

    <section>
        <!-- ========terceira coluna planos======= -->
        <div class="animation-reveal">
            <div class="content-column text-center">
                <h2 class="title text-white">Conheça os nossos planos</h2>
                <div class="text-space"></div>

                <div class="container" id="fourth-column">
                    <div class="row">
                        <!-- plano bronze -->
                        <div class="col-xs-12 col-lg-4">
                            <div class="text-white plan b-shadow">
                                <h4>Plano Bronze</h4>
                                <!--<a href="https://icons8.com/icon/60369/bronze-bars">Bronze Bars icon by Icons8</a>-->
                                <img src="assets/images/bronze-bars.png">
                                <div>
                                    <strong>R$50</strong>
                                    <p>à vista</p>
                                    <ul>
                                        <li>
                                            <p class="text-left">Acesso a varios cursos</p>
                                        </li>
                                        <li>
                                            <p class="text-left">Certificado de conclusão</p>
                                        </li>
                                        <li>
                                            <p class="text-left">Acompanhamento do gestor</p>
                                        </li>
                                        <li>
                                            <p class="text-left">Avaliação de desempenho</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- fim plano bronze  -->

                        <!-- inicio plano prata -->
                        <div class="col-xs-12 col-lg-4">
                            <div class="text-white plan b-shadow">
                                <h4 class="vivid-blue">Plano prata</h4>
                                <!--<a href="https://icons8.com/icon/60371/silver-bars">Silver Bars icon by Icons8</a>-->
                                <img src="assets/images/silver-bars.png" />
                                <div class="">
                                    <strong>R$80</strong>
                                    <p>à vista</p>
                                    <ul>
                                        <li>
                                            <p class="text-left">Acesso a varios cursos</p>
                                        </li>
                                        <li>
                                            <p class="text-left">Certificado de conclusão</p>
                                        </li>
                                        <li>
                                            <p class="text-left">Acompanhamento do gestor</p>
                                        </li>
                                        <li>
                                            <p class="text-left">Avaliação de desempenho</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- fim plano prata -->

                        <!-- inicio plano ouro -->
                        <div class="col-xs-12 col-lg-4">
                            <div class="text-white plan b-shadow">
                                <h4 class="vivid-blue">Plano ouro</h4>
                                <!--<a href="https://icons8.com/icon/21178/gold-bars">Gold Bars icon by Icons8</a>-->
                                <img src="assets/images/gold-bars.png" />
                                <div>
                                    <strong>R$150</strong>
                                    <p>à vista</p>
                                    <ul>
                                        <li>
                                            <p class="text-left">Acesso a varios cursos</p>
                                        </li>
                                        <li>
                                            <p class="text-left">Certificado de conclusão</p>
                                        </li>
                                        <li>
                                            <p class="text-left">Acompanhamento do gestor</p>
                                        </li>
                                        <li>
                                            <p class="text-left">Avaliação de desempenho</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- fim plano ouro -->

                    <div class="text-space">
                        <a href="{{route('user.create')}}"><button class="btn btn-vlight-orange">Cadastre-se já
                                já</button></a>
                        <div class="text-space"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection