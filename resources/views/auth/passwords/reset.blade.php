@extends('template.template')

@section('content')
    <div class="container">
        <div class="text-space"></div>
        <div class="form-pd">
            <div class="login-form">
                <h2 class="text-white text-center mt-3 mb-5">Resetar</h2>
                @if (session()->has('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <form action="{{route('user.reset.password')}}" method="post">
                    @csrf
                    @if($errors->all())
                            @foreach($errors->all() as $error)
                                <div class="alert alert-danger">{{$error}}</div>
                            @endforeach
                    @endif
                    <div class="form-group">
                        <label class="text-white">E-mail</label>
                        <input type="email" value="arthur.onaya@gmail.com" class="form-control" name="email" placeholder="Digite o seu e-mail">
                    </div>
                    <div class="form-group">
                        <label class="text-white">Senha</label>
                        <input type="password" class="form-control" name="password" placeholder="Digite a sua senha">
                    </div>
                    <div class="form-group">
                        <label class="text-white">Confirmar senha</label>
                        <input type="password" class="form-control" name="confirm" placeholder="Digite a sua senha">
                    </div>
                    <button type="submit" class="mt-3 btn blue btn-size">Alterar senha</button>
                </form>
            </div>
        </div>
    </div>
    <div class="text-space"></div>
@endsection