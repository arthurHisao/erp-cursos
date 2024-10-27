@extends('template.template')

@section('content')
<div class="container">
    <div class="text-space"></div>
    <div class="form-pd">
        <div class="text-white login-form">
            @if(isset($Instructor))
            <h2 class="text-center mt-3 mb-5">Cadastre as suas informações</h2>
            <form class="form-register" action="{{route('user.store')}}" method="POST">
                @csrf
                @if($errors->all())
                @foreach($errors->all() as $error)
                <div class="alert alert-danger">{{$error}}</div>
                @endforeach
                @endif
                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" class="register form-control" name="name" placeholder="Digite o seu nome"
                        autocomplete="on" data-js="name">
                </div>
                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" class="register form-control" name="email" placeholder="Digite o seu e-mail"
                        data-js="email">
                </div>

                <div class="form-group">
                    <label>Senha</label>
                    <input type="password" class="register form-control" name="password"
                        placeholder="Digite a sua senha">
                </div>

                <a class="text-white" href="{{route('instructor.login')}}">Caso já tenha uma conta faça login aqui</a>
                <div class="text-space"></div>
                <div id="msg" class="text-center alert"></div>
                <button type="submit" class="btn blue btn-size">Cadastrar</button>
        </div>
        </form>
        @else
        <h2 class="text-center mt-3 mb-5">Cadastre as suas informações</h2>
        <form class="form-register" action="{{route('user.store')}}" method="POST">
            @csrf
            @if($errors->all())
            @foreach($errors->all() as $error)
            <div class="alert alert-danger">{{$error}}</div>
            @endforeach
            @endif
            <div class="form-group">
                <label>Nome</label>
                <input type="text" class="register form-control" name="name" placeholder="Digite o seu nome"
                    autocomplete="on" data-js="name" required>
            </div>
            <div class="form-group">
                <label>E-mail</label>
                <input type="email" class="register form-control" name="email" placeholder="Digite o seu e-mail"
                    data-js="email" required>
            </div>

            <div class="form-group">
                <label>Senha</label>
                <input type="password" class="register form-control" name="password" placeholder="Digite a sua senha"
                    data-js="password" required>
            </div>
            <div class="form-group">
                <label>CPF</label>
                <input type="text" class="register input-mask form-control" placeholder="000.000.000-00" name="cpf"
                    autocomplete="on" data-js="cpf" required>
            </div>
            <div class="form-group">
                <label>Data de aniversário</label>
                <input type="text" class="register input-mask form-control" placeholder="00/00/0000" name="birthday"
                    autocomplete="on" data-js="birthday" required>
            </div>

            <div class="form-group">
                <label>Telefone / Celular</label>
                <input type="text" class="register input-mask form-control" placeholder="(00) 00000-0000" name="phone"
                    autocomplete="on" data-js="phone" required>
            </div>
            <div class="form-group">
                <label class="label">Selecione o estado que mora</label>
                <select class="form-control" name="state">
                    <option>Selecione o estado</option>
                    <option value="AC">Acre</option>
                    <option value="AL">Alagoas</option>
                    <option value="AP">Amapá</option>
                    <option value="AM">Amazonas</option>
                    <option value="BA">Bahia</option>
                    <option value="CE">Ceará</option>
                    <option value="DF">Distrito Federal</option>
                    <option value="ES">Espírito Santo</option>
                    <option value="GO">Goiás</option>
                    <option value="MA">Maranhão</option>
                    <option value="MT">Mato Grosso</option>
                    <option value="MS">Mato Grosso do Sul</option>
                    <option value="MG">Minas Gerais</option>
                    <option value="PA">Pará</option>
                    <option value="PB">Paraíba</option>
                    <option value="PR">Paraná</option>
                    <option value="PE">Pernambuco</option>
                    <option value="PI">Piauí</option>
                    <option value="RJ">Rio de Janeiro</option>
                    <option value="RN">Rio Grande do Norte</option>
                    <option value="RS">Rio Grande do Sul</option>
                    <option value="RO">Rondônia</option>
                    <option value="RR">Roraima</option>
                    <option value="SC">Santa Catarina</option>
                    <option value="SP">São Paulo</option>
                    <option value="SE">Sergipe</option>
                    <option value="TO">Tocantins</option>
                </select>
            </div>

            <a class="text-white" href="{{route('user.login')}}">Caso já tenha uma conta faça login aqui</a>
            <div class="text-space"></div>
            <div id="msg" class="text-center alert"></div>
            <button type="submit" class="btn blue btn-size">Cadastrar</button>
    </div>
    </form>
    @endif
</div>
</div>
<div class="text-space"></div>

<script src="{{url('assets/js/utils/InputMask.js')}}"></script>
<script src="{{url('assets/js/register.js')}}"></script>
@endsection