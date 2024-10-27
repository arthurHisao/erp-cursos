@extends('template.template')

@section('content')
<!--<a href='https://br.freepik.com/fotos/negocio'>Negócio foto criado por rawpixel.com - br.freepik.com</a>-->
<section>
    <div class="bg-banner-about">
        <div class="box-text">
            <h2 class="text-center title text-white">Sobre nós</h2>
        </div>
    </div>
</section>

<div class="container">
    <div class="content text-center">
        <p class="bold-p text-white">
            A ERP-CURSOS surgiu recentemente no dia 20/04/2021.
        </p>

        <p class="text-left text-white">
            O nosso objetivo é ajudar diversos profissionais com a sua carreira, acreditamos no potencial de cada um,
            somos capazes de conseguir tudo que queremos, basta acreditar em si mesmo, estudar e praticar o que
            aprendemos.
        </p>
        <button class="m-3 btn btn-vlight-orange">Conheça os nosso cursos</button>
    </div>

    <div class="animation-reveal content text-center">
        <div class="row">
            <div class="m-2 border col-sm-12 col-md column-setting">
                <h3 class="p-3 text-white">Missão</h3>
                <p class="text-left text-white">
                    Nós garantimos o seu aprendizado, junto a nossa equipe queremos que você aproveite o máximo
                    da nossa plataforma.
                    Temos o compromisso com você em ajudar a sua carreira a decolar
                </p>
            </div>
            <div class="border col-sm-12 col-md column-setting">
                <h3 class="p-3 text-white">Visão</h3>
                <p class="text-left text-white">
                    Se tornar uma plataforma lider de ensino, ajudar diversos profissionais crescerem na carreira
                </p>
            </div>
            <div class="m-2 border col-sm-12 col-md column-setting">
                <h3 class="p-3 text-white">Valores</h3>
                <p class="text-left text-white">
                    Diversos profissionais apaixonados por suas carreiras, este tipo de profissional é importante
                    para nossa carreira, é muito comum nós espelharmos as qualidade boa daquele profissional que
                    admiramos.
                </p>
            </div>
        </div>
    </div>


    <div class="animation-reveal content text-center">
        <h2 class="text-white mb-5">Conheça os nossos professores</h2>
        <div class="row">
            <div class="col-sm-12 col-lg-4 mb-5">
                <img src="{{url('assets/images/professor-terrence.jpg')}}" class="circle">
                <div class="m-4 text-left">
                    <h5 class="text-white">Professor(a) Jackson</h5>
                    <p class="text-white">
                        Professor a 15 anos, formado em ciência da computação, especialista em Java,
                        Phyton, Spring Boot e diversas tecnologias.
                    </p>
                </div>
            </div>
            <div class="col-sm-12 col-lg-4 mb-5">
                <img src="{{url('assets/images/professora-giulia.jpg')}}" class="circle">
                <div class="m-4 text-left">
                    <h5 class="text-white">Professor(a) Giulia</h5>
                    <p class="text-white">
                        Professora Giulia, formada em Análise e desenvolvimento de sistemas,
                        apaixonada por tecnologias, especialista em desenvolvimento Front-End.
                    </p>
                </div>
            </div>
            <div class="col-sm-12 col-lg-4 mb-5">.
                <!--<a href='https://br.freepik.com/fotos/fundo'>Fundo foto criado por freepik - br.freepik.com</a>-->
                <img src="{{url('assets/images/professor-marcos.jpg')}}" class="circle">
                <div class="m-4 text-left">
                    <h5 class="text-white">Professor(a) Marcos</h5>
                    <p class="text-white">
                        Especialista em tecnologias e ferramentas de Gestão integrado de Sistemas como ERP, SAP, Nomus
                        entre outras ferramentas.
                        Graduado na USP, fez diversas faculdades como Administração e Sistema da Informação.
                    </p>
                </div>
            </div>
        </div>
    </div>



    <div class="animation-reveal text-center mb-5">
        <h2 class="p-4 text-white">Faça parte do nosso time!</h2>
        <p class="text-white">Estamos procurando por profissionais apaixonados pela tecnologias! Se você respira tecnologias como nós venha fazer parte do nosso time</p>
        <button class="m-3 btn btn-vlight-orange">
            Cadastre-se
            <!-- <a class="text-white text-decoration-none" href="{{route('instructor.create')}}">Cadastre-se</a> -->
        </button>
    </div>
</div>
@endsection