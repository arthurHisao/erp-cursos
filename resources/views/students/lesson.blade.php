@extends('template.template')

@section('content')
<div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div class="bg-dark" id="sidebar-wrapper">
        <div class="text-white sidebar-heading">
            <h2>{{$courseInfo->title}}</h2><hr>
        </div>

        <div class="list-group list-group-flush">
            <strong class="text-white list-group-item list-group-item-action bg-dark selected">Aula atual: {{$courseInfo->video_name}}</strong>
        
            @foreach($courses as $course)
                <!--=====Exibindo os cursos=====-->
                <a href="{{url('aula/' .$course->video_link_name .'/'. $course->id)}}"
                    class="text-white list-group-item list-group-item-action bg-dark">{{$course->video_name}}</a>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            <a href="{{url()->previous()}}">
                <button class="btn btn-vlight-orange">Voltar página</button>
            </a>
        </div>
    </div>

    <!-- /#sidebar-wrapper -->
    <!-- Page Content -->
    <div id="page-content-wrapper">
    <button class="text-white btn m-1" id="menu-toggle">☰</button>

        <div class="container">
            <div class="parent d-flex justify-content-center mb-5">
                <img id="fake-video" src="{{url('assets/images/pulse-loading.gif')}}" alt="Fake video player icon">
            </div>
        </div>
        <div class="space"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/artplayer/dist/artplayer.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(function() {
            /*obtendo os elementos dentro do documento*/
            let newEl = document.createElement('div'),
                parentContainer = document.querySelector('.parent'),
                fakePlayer = document.querySelector('#fake-video');
                
            /*ocultando player falso e exibindo o verdadeiro player*/
            newEl.classList.add('artplayer-app');
            newEl.id = "player-size";
            parentContainer.appendChild(newEl);
            fakePlayer.remove();

            new Artplayer({
                container: ".artplayer-app",
                url: '{{route("student.video", ["link" => request()->segment(2), "token" => session()->get("url-token")])}}',            
                poster: '{{$courseInfo->video_thumbnail}}',
                fullscreen: true,
                autoplay: false,
                isLive: false,
                setting: true,
                aspectRatio: true,
                playbackRate: true,
                    quality: [{
                        default: true,
                        name: "SD 480P",
                        url: '{{route("student.video", ["link" => request()->segment(2), "token" => session()->get("url-token")])}}'
                    }, {
                        name: "HD 720P",
                        url: '{{route("student.video", ["link" => request()->segment(2), "token" => session()->get("url-token")])}}'
                    }]
            })
        }, 2000)
    });
</script>
<script src="{{url('assets/js/effect/Selected.js')}}"></script>
<script src="{{url('assets/js/utils/LeftSideBar.js')}}"></script>

@endsection