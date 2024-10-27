@extends('template.templateAdmin')

@section('content')
<div class="container-fluid">
    <div class="container text-center">
        <div class="text-white config-form">
            <h1 class="p-4 text-center">Usúarios</h1>
            <div id="tb">
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nome</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Tipo de permissão</th>
                            <th scope="col">Alterar Permissão</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            @if(isset($user->id) && $user->id === 1)
                            <th class="user-id" scope="row">{{$user->id}}</th>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->permission}}</td>
                            <td>
                                <span class="soft-red">-</span>
                            </td>
                            @else
                            <th class="user-id" scope="row">{{$user->id}}</th>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->permission}}</td>
                            <td>
                                <a class="text-white" href="{{route('admin.edit.permission', $user->id)}}">
                                    Clique aqui para alterar
                                </a>
                            </td>
                            @endif
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