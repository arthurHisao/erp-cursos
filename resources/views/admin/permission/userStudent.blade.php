@extends('template.templateAdmin')

@section('content')
<div class="container-fluid">
    <div class="container text-center">
        <div class="text-white config-form">
            <h1 class="p-4 text-center">Usúarios</h1>
            
            <div class="p-3">
                @if(Request::segment(3) === "social")
                    <a class="text-white" href="{{route('admin.list.students')}}">Clique aqui para listar usuários</a>
                @else
                    <a class="text-white" href="{{route('admin.list.socialite')}}">Clique aqui para listar usuários logados com redes sociais</a>
                @endif
            </div>

            <div id="tb">
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nome</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Status do Pagamento</th>
                            <th scope="col">Alterar status do pagamento</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <th class="user-id" scope="row">{{$user->id}}</th>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->payment_status === "NULL" ? "Pagamento não efetuado" : "ok"}}</td>
                            <td> 
                            @if(Request::segment(3) === "social")
                                <a class="text-white" href="{{route('student.socialite.permission', $user->id)}}">
                                    Clique aqui para alterar
                                </a>
                            @else
                                <a class="text-white" href="{{route('student.permission', $user->id)}}">
                                    Clique aqui para alterar
                                </a>
                            @endif    
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$users->links()}}
            </div>
        </div>
    </div>
</div>
@endsection