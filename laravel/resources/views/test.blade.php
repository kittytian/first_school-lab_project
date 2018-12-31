@extends('demo.base')
@section('style')
    <link href="{{ URL::asset('css/demo/demo.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css"> 
@endsection

@section('script-head')
    <script src="{{ URL::asset('vendor/jquery/jquery.js')}}"></script>
    <script src="{{ URL::asset('js/echart/echarts.min.js')}}"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
@endsection

@section('content')
<div class="container">
    <nav class="navbar" role="navigation">
        <div class="container-fluid"> 
        <div class="navbar-header">
            <a class="navbar-brand" href="#">北京邮电大学知识图谱网站</a>
        </div>
        <form class="navbar-form navbar-left" role="search">
            <div class="form-group">
                <input type="text" id="multiName" class="form-control" placeholder="教师姓名或者课程关键字">
            </div>
            <button type="button" id="submit_multi_teacher" class="btn btn-primary">搜索教师</button>
            <button type="button" id="submit_multi_teachers" class="btn btn-primary">搜索多名教师</button>
            <button type="button" id="submit_multi_class" class="btn btn-primary">搜索课程</button>
            <button type="button" id="submit_rd" class="btn btn-primary">搜索研究方向</button>
        </form>
        </div>
    </nav>
    <div class="row clearfix">
        <div width="100%" class="col-md-5">
			<!--<div>{{$years_by_project}}</div>-->
			<!--<div>{{$projects_all_year}}</div>-->
		</div>
	</div>
</div>
@endsection

@section('script-foot')
    <script src="{{ URL::asset('js/actual/actual.js')}}"></script>
@endsection
