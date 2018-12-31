@extends('demo.base')
@section('style')
    <link href="{{ URL::asset('css/demo/demo.css') }}" rel="stylesheet"/>
@endsection
@section('script-head')
    <script src="{{ URL::asset('vendor/jquery/jquery.js')}}"></script>
    <script src="{{ URL::asset('js/demo/demo.js')}}"></script>
    <script src="{{ URL::asset('js/echart/echarts.min.js')}}"></script>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <div class="nav flex-column nav-pills jumbotron" role="tablist" aria-orientation="vertical">
                    <a class="nav-link tab-hover" href="{{URL::asset('/')}}demo/detail?name={{$name}}&type=0" data-toggle="pill" role="tab" aria-controls="v-pills-home" aria-selected="true">基本属性</a>
                    <a class="nav-link tab-hover" href="{{URL::asset('/')}}demo/detail?name={{$name}}&type=1" data-toggle="pill" role="tab" aria-controls="v-pills-home" aria-selected="true">合作关系</a>
                    <a class="nav-link active   " data-toggle="pill" role="tab" aria-controls="v-pills-home" aria-selected="true">课程/论文/著作</a>
                    <a class="nav-link tab-hover" href="{{URL::asset('/')}}demo/detail?name={{$name}}&type=3" data-toggle="pill" role="tab" aria-controls="v-pills-home" aria-selected="true">研究方向</a>
                </div>
            </div>
            <div class="col-md-10">
                <div class="row jumbotron">
                    name:{{$name}}</br >
                    type:{{$type}}
                </div>
            </div>
        </div>
    </div>
@endsection

