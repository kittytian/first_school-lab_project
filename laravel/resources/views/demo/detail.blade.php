@extends('demo.base')
@section('style')
    <link href="{{ URL::asset('css/demo/demo.css') }}" rel="stylesheet"/>
@endsection
@section('script-head')
    <script src="{{ URL::asset('vendor/jquery/jquery.js')}}"></script>
    <script src="{{ URL::asset('js/demo/demo.js')}}"></script>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <div class="nav flex-column nav-pills jumbotron" role="tablist" aria-orientation="vertical">
                <a class="nav-link active   " data-toggle="pill" role="tab" aria-controls="v-pills-home" aria-selected="true">基本属性</a>
                <a class="nav-link tab-hover" href="{{URL::asset('/')}}demo/detail?name={{$name}}&type=1" data-toggle="pill" role="tab" aria-controls="v-pills-home" aria-selected="true">合作关系</a>
                <a class="nav-link tab-hover" href="{{URL::asset('/')}}demo/detail?name={{$name}}&type=2" data-toggle="pill" role="tab" aria-controls="v-pills-home" aria-selected="true">课程/论文/著作</a>
                <a class="nav-link tab-hover" href="{{URL::asset('/')}}demo/detail?name={{$name}}&type=3" data-toggle="pill" role="tab" aria-controls="v-pills-home" aria-selected="true">研究方向</a>
            </div>
        </div>
        <div class="col-md-10">
            <div class="row jumbotron">
                @foreach($teachers as $teacher)
                    教师姓名：
                    @if(isset($teacher['name'])) 
                        {{$teacher['name']}}
                    @else
                        未知 
                    @endif
                    </br >
                    教师性别：
                    @if(isset($teacher['sex']))
                        {{$teacher['sex']}}
                    @else
                        未知
                    @endif
                    </br>
                    教师ID：
                    @if(isset($teacher['nid']))
                        {{$teacher['nid']}}
                    @else
                        未知
                    @endif
                    </br>
                    教师职称：
                    @if(isset($teacher['professional_title']))
                        {{$teacher['professional_title']}}
                    @else
                        未知
                    @endif
                    </br >
                    在职状态：
                    @if(isset($teacher['teacher_status']))
                        {{$teacher['teacher_status']}}
                    @else
                        未知
                    @endif
                    </br >
                    所在院系：
                    @if(isset($teacher['department']))
                        {{$teacher['department']}}
                    @else
                        未知
                    @endif
                    </br>
                    所在实验室：
                    @if(isset($teacher['lab']) and $teacher['lab']!='UNK')
                        {{$teacher['lab']}}
                    @else
                        未知
                    @endif
                    </br>
                    所在中心：
                    @if(isset($teacher['centre']))
                        {{$teacher['centre']}}
                    @else
                        未知
                    @endif
                    </br>
                    所在团队：
                    @if(isset($teacher['team']))
                        {{$teacher['team']}}
                    @else
                        未知
                    @endif
                    </br>
                    </br>
    
                @endforeach

            </div>
        </div>
    </div>
</div>
@endsection

