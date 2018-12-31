@extends('demo.base')
@section('style')
    <link href="{{ URL::asset('css/demo/demo.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">    
@endsection
@section('script-head')
    <script src="{{ URL::asset('vendor/jquery/jquery.js')}}"></script>
    <!--<script src="{{ URL::asset('js/demo/r&d.js')}}"></script>-->
    <script src="{{ URL::asset('js/echart/echarts.min.js')}}"></script>
@endsection

@section('content')
<div class="container">
	<nav class="navbar" role="navigation">
        <div class="container-fluid"> 
        <div class="navbar-header">
            <a class="navbar-brand" href="#">北京邮电大学知识图谱网站</a>
        </div>
        <form class="navbar-form navbar-left" role="search" style="position:relative;">
            <div class="form-group">
                <input type="text" onkeyup="test(this.vlaue,event)" onblur="inputonblur()" id="multiName" autocomplete="off" class="form-control" placeholder="教师姓名或者课程关键字">
            </div>
            <button type="button" id="submit_multi_teacher" class="btn btn-primary">搜索教师</button>
            <button type="button" id="submit_multi_teachers" class="btn btn-primary">搜索多名教师</button>
            <button type="button" id="submit_multi_class" class="btn btn-primary">搜索课程</button>
            <button type="button" id="submit_rd" class="btn btn-primary">搜索研究方向</button>
            <select  multiple="multiple" id="sel" onchange="test2()" style="width:100%;display:none;color:gray;position:absolute;left:0;z-index:999;"></select>
        </form>
        </div>
    </nav>
	<div class="row clearfix">
		<div class="col-md-9 column">
            <div class="row" id="app" style="width:calc( 100% - 1px ); height:600px; left:1px; box-shadow:0 0 5px #d3d3d3;">
            </div>
        </div>
        <div class="col-md-3 column">
            <div class="row" id="app_research" style="font-family:Microsoft YaHei,微软雅黑,MicrosoftJhengHei,华文细黑,STHeiti,MingLiu">
                <div class="col-12">
                    搜索到</br>
                    <span class="glyphicon glyphicon-list-alt" style="padding-right:3px"></span>含
                    <strong>{{$name}}</strong>
                    关键词的研究方向：
                    {{$nbarr['research']}}
                    个
                    </br>
                    @foreach($research as $rd)
                        <span class="glyphicon glyphicon-user" style="padding-right:3px"></span>研究
                        <strong>{{$rd}}</strong>
                        方向的教师：
                        {{$nbarr['nbresearchteacher'][$rd]}}
                        名
                        </br>
                    @endforeach
                    <span class="glyphicon glyphicon-user" style="padding-right:3px">共计教师
                    {{$nbarr['teacher']}}
                    名
                </div>
            </div>
        </div>
    </div>
	<div class="row clearfix">
        <div style="padding-top: 10px; padding-bottom: 10px; padding-left: 0;" class="col-12">
            <ul class="footer-socials list-inline">
                <li class="ng-binding"><p style="color:gray">
                    </p>2018-2019 © 北京邮电大学  地址:北京市西土城路10号  邮编:100876</li>
                <li><a href="#" style="color:#428bca" class="tooltips ng-binding">About</a></li>
                <li><a href="#" style="color:#428bca" class="tooltips ng-binding">Contact</a></li>
                <li><a href="#" style="color:#428bca" class="tooltips ng-binding">Terms of Use</a></li>
                <li><a href="#" style="color:#428bca" class="tooltips ng-binding">Privacy Policy</a></li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('script-foot')
    <script type="text/javascript">
        var graph = "{{ $graph }}"
        //将转义字符转换回来 转换成正常的json字符串
        var reg = new RegExp("\&quot;","g");
        graph = graph.replace(reg,'"');
        console.log('graph',graph);
    </script>
    <script src="{{ URL::asset('js/echart/demoresearch.js')}}"></script>
    <script src="{{ URL::asset('js/actual/actual.js')}}"></script>
@endsection
