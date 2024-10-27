@extends('template.template')

@section('content')
    <div class="container">
        <div class="pd-top text-white">
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6 mb-4">
                    <h2 class="mb-4">Descrição do vídeo</h2>
                    <p>{{$details->video_description}}</p>

                    <p><strong>Categoria: {{$details->category}}</strong></p>
                    <p><strong>Instrutor: {{$details->user_name}}</strong></p>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-6">
                    <img style="width: 500px; height: 300px;" src="{{$details->video_thumbnail}}">
                </div>
            </div>
        </div>

        <div class="text-center text-space">
            <a href="{{route('user.create')}}">
                <button class="btn btn-vlight-orange">Matricule-se já</button>
            </a>
        </div>

        <div class="space"></div>
    </div>
@endsection