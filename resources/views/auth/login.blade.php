@extends('template.template')

@section('content')

<div class="container">
    <div class="text-space"></div>
    <div class="form-pd">
        <div class="text-white login-form">
            @if(isset($Instructor))
            <h2 class="title text-center mt-3 mb-5">Faça login aqui</h2>
            <form action="{{route('user.do.login')}}" method="POST">
                @csrf
                @if($errors->all())
                @foreach($errors->all() as $error)
                <div class="alert alert-danger">{{$error}}</div>
                @endforeach
                @endif
                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" class="form-control" name="email"
                        placeholder="Digite o seu e-mail">
                </div>

                <div class="form-group">
                    <label>Senha</label>
                    <input type="password" class="form-control" name="password"
                        placeholder="Digite a sua senha">
                </div>

                <a class="text-white mr-1" href="{{route('instructor.create')}}">Crie sua conta aqui</a>|
                <a class="text-white mr-1" href="{{route('admin.reset')}}">Esqueci a minha senha</a>
                <div class="text-space"></div>
                <button type="submit" class="mb-3 btn blue btn-size">Entrar</button>
            </form>
            @else
            <h2 class="title text-center mt-3 mb-1">Caso seja um aluno</h2>
            <p class="subtitle text-center mb-5">Faça login aqui</p>
            <form action="{{route('user.do.login')}}" method="POST">
                @csrf
                @if($errors->all())
                @foreach($errors->all() as $error)
                <div class="alert alert-danger">{{$error}}</div>
                @endforeach
                @endif
                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" class="form-control" name="email"
                        placeholder="Digite o seu e-mail">
                </div>

                <div class="form-group">
                    <label>Senha</label>
                    <input type="password" class="form-control" name="password"
                        placeholder="Digite a sua senha">
                </div>

                <a class="text-white mr-1" href="{{route('user.create')}}">Crie sua conta aqui</a>|
                <a class="text-white mr-1" href="{{route('user.reset')}}">Esqueci a minha senha</a>
                <div class="text-space"></div>
                <button type="submit" id="login" class="mb-3 btn blue btn-size">Entrar</button>
            </form>
            <!--Botao login com redes sociais-->
            <a href="{{route('user.login.google')}}">
                <button type="submit" id="login-google" class="mb-3 btn btn-size">Entrar com Google</button>
            </a>
            <a href="{{route('user.login.facebook')}}">
                <button type="submit" id="login-facebook" class="mb-3 btn btn-size">Entrar com Facebook</button>
            </a>
            @endif
        </div>
    </div>
</div>
    
<script src="{{url('assets/js/login.js')}}"></script>
@endsection