@extends('template.template')

@section('content')
<div class="container">
    <div class="text-space"></div>
    <div class="form-pd">
        <div class="text-white login-form">
            <h2 class="title text-center mt-3 mb-5">Boleto Bancário</h2>
            <form method="POST" id="form-buy">
                @csrf
                <div id="msg" class="alert alert-danger" style="display: none;"></div>
                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" class="form-control" name="name" placeholder="Seu nome">
                </div>

                <div class="form-group">
                    <label>CPF</label>
                    <input type="text" class="register input-mask form-control" placeholder="000.000.000-00" name="cpf"
                        autocomplete="on" data-js="cpf">
                </div>

                <div class="form-group">
                    <label>Selecione os planos</label>
                    <select class="form-control" name="plans">
                        <option>Selecione os planos</option>
                        <option value="Bronze">Bronze</option>
                        <option value="Prata">Prata</option>
                        <option value="Ouro">Ouro</option>
                    </select>
                </div>
                <button type="submit" class="mt-3 btn blue btn-size">Gerar boleto</button>
            </form>
        </div>
    </div>
</div>

<!--=====Espacamento======= -->
<div class="text-space"></div>
<!--=====fim======= -->

<script src="{{url('assets/js/utils/InputMask.js')}}"></script>
<script src="{{url('assets/js/Plan.js')}}"></script>
@endsection