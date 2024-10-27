@extends('template.templateAdmin')

@section('content')
<div class="container">
    <div class="text-white">
        @if(isset($users))
            <h2 class="title text-center mb-5">Configuração de conta do usuário</h2>
            <form id="form-update" method="POST">
                @csrf
                @method('PUT')
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Email</th>
                            <th scope="col">Name</th>
                            <th scope="col">Status do pagamento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">
                                <span id="user-id">{{$users->id}}</span>
                            </th>
                            <td>{{$users->email}}</td>
                            <td>{{$users->name}}</td>
                            <td>
                                <select class="no-outline" name="status">
                                    <option>Selecione</option>
                                    <option value="ok">Ok</option>
                                    <option value="NULL">Não pago</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="text-center">
                    <button class="btn btn-vlight-orange" name="btn-save">Salvar alterações</button>
                </div>
            </form>
        
        @else
            <p class="bold-p text-center m-5 p-5">O Registro ainda não existe!</span>
        @endif
    </div>
</div>
</div>
</div>
<script src="{{url('assets/js/studentPermissions.js')}}"></script>
<script src="{{url('assets/js/utils/Delete.js')}}"></script>
@endsection