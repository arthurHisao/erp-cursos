<!DOCTYPE html>
<html lang="pt-br">    
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="{{url('assets/css/emailTemplate.css')}}">
        <link rel="stylesheet" href="{{url('assets/css/bootsrap/bootstrap.min.css')}}">
        <script src="{{url('assets/js/jquery/jquery.min.js')}}"></script>
        <script src="{{url('assets/js/bootsrap/bootstrap.min.js')}}"></script>
    </head>

    <body>
        <div class="email-body">
            <div class="text-center text-white">
                <h3>ERP-CURSOS</h3>
                <p>Prezado(a) Aluno(a) <b>{{ $user->name}}</b> </p>
                <p>Clique no Botão Abaixo para Redefinir a Senha</p>
                
                <a class="no-decoration" href="{{$url}}">
                    <button class="p-2 btn btn-email">Redefinir a Senha</button>
                </a>
                <p class="p-3">Atenciosamente, Equipe ERP-CURSOS</p>
            </div>
        </div>
    </body>
</html>