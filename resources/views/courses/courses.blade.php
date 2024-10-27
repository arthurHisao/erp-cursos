@extends('template.template')

@section('content')
    @if(isset($courses))
        <div class="pd-top">
            <h2 class="text-white text-center">Resultado da pesquisa</h2>

            <div class="container">
                <div class="content">
                    <div class="text-white row">
                        @foreach($courses as $course)
                        <div class="col-sm-7 col-md-6 col-lg-4 mb-4">
                            <a href="{{url('/detalhes/' .$course->video_link_name)}}">
                                <img class="course-thumb" src="{{url($course->video_thumbnail)}}">
                            </a>
                            <div class="course-content">
                                <h6 class="m-3">{{$course->video_name}}<h6>
                                <p class="m-3">
                                    <span>Categoria: {{$course->category}}</span>
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center">
                        {!! $courses->appends(['search' => $search])->links() !!}
                    </div>
                </div>
            </div>
        </div>
    @elseif(isset($error))
        <div class="pd-top">
            <h2 class="text-white text-center">Resultado da pesquisa</h2>
            <div class="container">
                <div class="content">
                    <h5 class="text-white text-center">{{$error}}</h5>
                </div>
            </div>
        </div> 
    @else
        <!--<span>Photo by <a href="https://unsplash.com/@heykellybrito?utm_source=unsplash&amp;utm_medium=referral&amp;utm_content=creditCopyText">J. Kelly Brito</a> on <a href="https://unsplash.com/s/photos/study?utm_source=unsplash&amp;utm_medium=referral&amp;utm_content=creditCopyText">Unsplash</a></span>-->
        <div class="pd-top">
            <h2 class="text-white text-center">Conheça os nossos cursos</h2>
            <div class="container">
                <div class="content">
                    <div class="text-white row justify-content-center">
                        @foreach($videos as $video)
                        <div class="col-sm-7 col-md-6 col-lg-4 mb-4">
                            <a href="{{url('/detalhes/' .$video->video_link_name)}}"><img class="course-thumb" src="{{$video->video_thumbnail}}" alt="cursos"></a>
                            <div class="course-content">
                                <h6 class="m-3">{{$video->video_name}}<h6>
                                <span class="course-description m-3">Curso de desenvolvimento</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $videos->links() }}
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection