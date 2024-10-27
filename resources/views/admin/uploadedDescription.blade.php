@extends('template.templateAdmin')

@section('content')
<div class="container">
    <h1 class="p-4 text-center">Detalhes da vídeo Aula</h1>
    <div class="content">
        @if(isset($lessons))
        <div class="text-white row">
            @foreach($lessons as $lesson)
            <div class="col-sm-7 col-md-6 col-lg-4  mb-5">
                @if(isset($lesson->video_thumbnail))
                    <img class="course-thumb" src="{{url($lesson->video_thumbnail)}}">
                @else
                    <img class="course-thumb" src="{{url('assets/images/camera.png')}}">
                @endif
                <div class="course-content">
                    <h6 class="m-3">{{$lesson->video_name}}<h6>
                    <p class="m-3">
                        @if(isset($lesson->video_description))
                            <span>Categoria: {{$lesson->category}}</span>
                        @endif
                    </p>
                    <!--adicionar titulo-->
                    <p class="m-3">
                        <a class="text-white" href="{{route('instructor.edit.videos', $lesson->id)}}">
                            Editar
                        </a>
                    </p>
                </div>
            </div>
            @endforeach
        </div>
        {{$lessons->links()}}
        @else
        <div class="text-white row">
            <div class="col">
                <div class="course-content">
                    <h6>Faça upload das aulas para visualizar<h6>
                </div>
            </div>
            <div class="col">
                <div class="course-content">
                    <h6>Faça upload das aulas para visualizar<h6>
                </div>
            </div>
            <div class="col">
                <div class="course-content">
                    <h6>Faça upload das aulas para visualizar<h6>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection