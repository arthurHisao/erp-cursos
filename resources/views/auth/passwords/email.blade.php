@extends('template.template')

@section('content')
    <div class="container">
        <div class="text-space"></div>
        <div class="form-pd">
            <div class="login-form">
                <h2 class="text-white text-center mt-3 mb-5">Validar o email</h2>
                @if (session()->has('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <form method="POST" action="{{route('user.send.email') }}">
                    @if($errors->all())
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">{{$error}}</div>
                        @endforeach
                    @endif
                    
                    @csrf
                    <div class="form-group">
                        <label class="text-white" for="exampleInputEmail1">E-mail</label>
                        <input type="email" class="mb-3 form-control" name="email" placeholder="Digite o seu e-mail">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <button type="submit" class="mb-3 btn blue btn-size">Entrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="text-space"></div>
@endsection