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
        <form class="navbar-form navbar-left" role="search" style="position:relative;">
            <div class="form-group" style="position:relative">
                <input type="text" id="multiName" autocomplete="off" onkeyup="test(this.vlaue,event)" onblur="inputonblur()" class="form-control" placeholder="教师姓名或课程关键字">
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
        <div width="100%" class="col-md-5">
            <div style="margin-bottom:10px; padding:15px; box-shadow:0 0 5px #d3d3d3;">
                @foreach($teachers as $teacher)
                    <span class="glyphicon glyphicon-user" style="padding-right:3px"></span>教师姓名：
                    @if(isset($teacher['name'])) 
                        {{$teacher['name']}}
                    @else
                        未知 
                    @endif
                    </br >
                    <span class="glyphicon glyphicon-adjust" style="padding-right:3px"></span>教师性别：
                    @if(isset($teacher['sex']))
                        {{$teacher['sex']}}
                    @else
                        未知
                    @endif
                    </br>
                    <span class="glyphicon glyphicon-header" style="padding-right:3px"></span>民族：
                    @if(isset($teacher['nationality']))
                        {{$teacher['nationality']}}
                    @else
                        未知
                    @endif
                    
                    </br>
                    <span class="glyphicon glyphicon-floppy-disk" style="padding-right:3px"></span>教师职称：
                    @if(isset($teacher['professional_title']))
                        {{$teacher['professional_title']}}
                    @else
                        未知
                     @endif
                     </br>
                    <span class="glyphicon glyphicon-tower" style="padding-right:3px"></span>教师类型:
                    @if(isset($teacher['teacher_type']))
                       {{$teacher['teacher_type']}}
                    @else
                        未知
                    @endif
                
                    </br >
                    <span class="glyphicon glyphicon-book" style="padding-right:3px"></span>研究方向：
                    @if(isset($teacher['directions']))
                       {{$teacher['directions']}}
                    @else
                        未知
                    @endif
                    </br>
                    <span class="glyphicon glyphicon-subtitles" style="padding-right:3px"></span>教师职务：
                    @if(isset($teacher['position_level']))
                        {{$teacher['position_level']}}
                    @else
                        未知
                    @endif
                    </br>
                    <span class="glyphicon glyphicon-log-out" style="padding-right:3px"></span>在职状态：
                    @if(isset($teacher['status']))
                        {{$teacher['status']}}
                    @else
                        未知
                    @endif
                    </br >
                    <span class="glyphicon glyphicon-sound-dolby" style="padding-right:3px"></span>所在院系：
                    @if(isset($teacher['department']))
                        {{$teacher['department']}}
                    @else
                        未知
                    @endif
                    </br>
                    <span class="glyphicon glyphicon-home" style="padding-right:3px"></span>办公地点：
                    @if(isset($teacher['office_location']))
                        {{$teacher['office_location']}}
                    @else
                        未知
                    @endif

                    </br>
                    <span class="glyphicon glyphicon-phone-alt" style="padding-right:3px"></span>办公电话:
                    @if(isset($teacher['telephone']))
                       {{$teacher['telephone']}}
                    @else
                        未知
                    @endif
                    </br>  
                    <span class="glyphicon glyphicon-envelope" style="padding-right:3px"></span>邮箱：
                    @if(isset($teacher['email']))
                       {{$teacher['email']}}
                    @else
                        未知
                    @endif
                    </br>
                    <span class="glyphicon glyphicon-hd-video" style="padding-right:3px"></span>所在中心：
                    @if(isset($teacher['centre']))
                        {{$teacher['centre']}}
                    @else
                        未知
                    @endif
                    </br>
                    <span class="glyphicon glyphicon-sound-stereo" style="padding-right:3px"></span>所在团队：
                    @if(isset($teacher['team']))
                        {{$teacher['team']}}
                    @else
                        未知
                    @endif
                    </br>
                    </br>
                @endforeach
            </div>
            <div id="app_research" style="margin-bottom:10px; padding:15px; width:calc( 100% - 1px ); height:300px; left:1px; box-shadow:0 0 5px #d3d3d3;">
            </div>
        </div>
        <div class="col-md-7">
            <div id="app" style="margin-bottom:10px; padding:15px; width:calc( 100% - 1px ); height:640px; left:1px; box-shadow:0 0 5px #d3d3d3;">
            </div>
        </div>
    </div>
    
    <div class="row clearfix">
        <div class="col-md-2 column">
            <hr class="no-padding no-margin">
        </div>
    </div>
    
    <div class="row clearfix">
        <div class="col-2 column">
            <ul class="nav nav-tabs nav-stacked navbar-nav" width="100%">
                <li class="active">
                    <a href="#panel-element-202" data-toggle="tab">论文</a>
                </li>
                <li>
                    <a href="#panel-element-203" data-toggle="tab">专著专利</a>
                </li>
				<li>
					<a href="#panel-element-204" data-toggle="tab">项目</a>
				</li>
                <li>
                    <a href="#panel-element-205" data-toggle="tab">课程</a>
                </li>
            </ul>
        </div>
        <div class="col-10 column" style="box-shadow:0 0 5px #d3d3d3;">
            <div class="tabbable" id="tabs-19467">
                <div class="tab-content">
                    <div id="panel-element-202" class="tab-pane active panel-collapse in">
                        <div class="panel-body">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                     <a href="#panel-301" data-toggle="tab">年份</a>
                                </li>
                                <li>
                                     <a href="#panel-302" data-toggle="tab">引用量</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="panel-301">
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                             <a href="#panel-400" data-toggle="tab">全部</a>
                                        </li>
                                        @foreach($years_by_paper as $each_year)
                                        <li>
                                             <a href="#panel-400-{{$each_year}}" data-toggle="tab">{{$each_year}}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="panel-400">
                                            <div class="list-group">
                                                @foreach($papers as $paper)
                                                <div class="list-group-item">
                                                    <h5>
                                                        @if(isset($paper['title']))
                                                            {{$paper['title']}}
                                                        @else
                                                            <span>--</span>
                                                        @endif
                                                        <span class="badge">
                                                        @if(isset($paper['publication_type']))
                                                            {{$paper['publication_type']}}
                                                        @else
                                                            <span>--</span>
                                                        @endif
                                                        </span>
                                                    </h5>
                                                    <p>
                                                        <span>
                                                        @if(isset($paper['author']))
                                                            {{$paper['author']}}
                                                        @else
                                                            <span>--</span>
                                                        @endif
                                                        </span>
                                                    </p>
                                                    <p>
                                                        <span>
                                                        @if(isset($paper['department']))
                                                            {{$paper['department']}}
                                                        @else
                                                            <span>--</span>
                                                        @endif
                                                        </span>
                                                        <span>
                                                        @if(isset($paper['publication_date']))
                                                            {{$paper['publication_date']}}
                                                        @else
                                                            <span>--</span>
                                                        @endif
                                                        </span>
                                                    </p>
                                                    <p>
                                                        <span>
                                                        @if(isset($paper['keywords']))
                                                            {{$paper['keywords']}}
                                                        @else
                                                            <span>--</span>
                                                        @endif
                                                        </span>
                                                    </p>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @foreach($years_by_paper as $index=>$each_year)
                                        <div class="tab-pane" id="panel-400-{{$each_year}}">
                                            <div class="list-group">
                                                @foreach($papers_all_year[$index] as $paper)
                                                <div class="list-group-item">
                                                    <h5>
                                                        @if(isset($paper['title']))
                                                            {{$paper['title']}}
                                                        @else
                                                            <span>--</span>
                                                        @endif
                                                        <span class="badge">
                                                        @if(isset($paper['publication_type']))
                                                            {{$paper['publication_type']}}
                                                        @else
                                                            <span>--</span>
                                                        @endif
                                                        </span>
                                                    </h5>
                                                    <p>
                                                        <span>
                                                        @if(isset($paper['author']))
                                                            {{$paper['author']}}
                                                        @else
                                                            <span>--</span>
                                                        @endif
                                                        </span>
                                                    </p>
                                                    <p>
                                                        <span>
                                                        @if(isset($paper['department']))
                                                            {{$paper['department']}}
                                                        @else
                                                            <span>--</span>
                                                        @endif
                                                        </span>
                                                        <span>
                                                        @if(isset($paper['publication_date']))
                                                            {{$paper['publication_date']}}
                                                        @else
                                                            <span>--</span>
                                                        @endif
                                                        </span>
                                                    </p>
                                                    <p>
                                                        <span>
                                                        @if(isset($paper['keywords']))
                                                            {{$paper['keywords']}}
                                                        @else
                                                            <span>--</span>
                                                        @endif
                                                        </span>
                                                    </p>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="tab-pane" id="panel-302">
                                    <p>
                                        Howdy, I'm in 引用量.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="panel-element-203" class="tab-pane panel-collapse collapse">
                        <div class="panel-body">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                     <a href="#panel-303" data-toggle="tab">年份</a>
                                </li>
                                <li>
                                     <a href="#panel-304" data-toggle="tab">引用量</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="panel-303">
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                             <a href="#panel-401" data-toggle="tab">全部</a>
                                        </li>
                                        @foreach($years_by_book as $each_year)
                                        <li>
                                             <a href="#panel-401-{{$each_year}}" data-toggle="tab">{{$each_year}}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="panel-401">
                                            <div class="list-group">
                                                @foreach($books as $book)
                                                <div class="list-group-item">
                                                    <h5>
                                                        @if(isset($book['title']))
                                                            {{$book['title']}}
                                                        @else
                                                            <span>--</span>
                                                        @endif
                                                        <span class="badge">
                                                        @if(isset($book['publication_type']))
                                                            {{$book['publication_type']}}
                                                        @else
                                                            <span>--</span>
                                                        @endif
                                                        </span>
                                                    </h5>
                                                    <p>
                                                        <span>
                                                        @if(isset($book['author']))
                                                            {{$book['author']}}
                                                        @else
                                                            <span>--</span>
                                                        @endif
                                                        </span>
                                                    </p>
                                                    <p>
                                                        <span>
                                                        @if(isset($book['department']))
                                                            {{$book['department']}}
                                                        @else
                                                            <span>--</span>
                                                        @endif
                                                        </span>
                                                        <span>
                                                        @if(isset($book['publication_date']))
                                                            {{$book['publication_date']}}
                                                        @else
                                                            <span>--</span>
                                                        @endif
                                                        </span>
                                                    </p>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @foreach($years_by_book as $index=>$each_year)
                                        <div class="tab-pane" id="panel-401-{{$each_year}}">
                                            <div class="list-group">
                                                @foreach($books_all_year[$index] as $book)
                                                <div class="list-group-item">
                                                    <h5>
                                                        @if(isset($book['title']))
                                                            {{$book['title']}}
                                                        @else
                                                            <span>--</span>
                                                        @endif
                                                        <span class="badge">
                                                        @if(isset($book['publication_type']))
                                                            {{$book['publication_type']}}
                                                        @else
                                                            <span>--</span>
                                                        @endif
                                                        </span>
                                                    </h5>
                                                    <p>
                                                        <span>
                                                        @if(isset($book['author']))
                                                            {{$book['author']}}
                                                        @else
                                                            <span>--</span>
                                                        @endif
                                                        </span>
                                                    </p>
                                                    <p>
                                                        <span>
                                                        @if(isset($book['department']))
                                                            {{$book['department']}}
                                                        @else
                                                            <span>--</span>
                                                        @endif
                                                        </span>
                                                        <span>
                                                        @if(isset($book['publication_date']))
                                                            {{$book['publication_date']}}
                                                        @else
                                                            <span>--</span>
                                                        @endif
                                                        </span>
                                                    </p>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="tab-pane" id="panel-304">
                                    <p>
                                        Howdy, I'm in 引用量.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
					<div id="panel-element-204" class="tab-pane panel-collapse collapse">
                        <div class="panel-body">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                     <a href="#panel-305" data-toggle="tab">年份</a>
                                </li>
                                <li>
                                     <a href="#panel-306" data-toggle="tab">引用量</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="panel-305">
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                             <a href="#panel-402" data-toggle="tab">全部</a>
                                        </li>
                                        @foreach($years_by_project as $each_year)
                                        <li>
                                             <a href="#panel-402-{{$each_year}}" data-toggle="tab">{{$each_year}}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="panel-402">
                                            <div class="list-group">
                                                @foreach($projects as $project)
                                                <div class="list-group-item">
                                                    <h5>
                                                        @if(isset($project['name']))
                                                            {{$project['name']}}
                                                        @else
                                                            <span>--</span>
                                                        @endif
                                                        <span class="badge">
                                                        项目
                                                        </span>
                                                    </h5>
                                                    <p>
                                                        <span>
                                                        @if(isset($project['date_begin']))
                                                            {{$project['date_begin']}}
                                                        @else
                                                            <span>none</span>
                                                        @endif
                                                        </span>
														<span>--</span>
                                                        <span>
                                                        @if(isset($project['date_finish']))
                                                            {{$project['date_finish']}}
                                                        @else
                                                            <span>none</span>
                                                        @endif
                                                        </span>
                                                    </p>
													<p>
                                                        <span>
                                                        @if(isset($project['department']))
                                                            {{$project['department']}}
                                                        @else
                                                            <span>--</span>
                                                        @endif
                                                        </span>
                                                        <span>
                                                        @if(isset($project['date_setup']))
                                                            {{$project['date_setup']}}
                                                        @else
                                                            <span>--</span>
                                                        @endif
                                                        </span>
                                                    </p>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @foreach($years_by_project as $index=>$each_year)
                                        <div class="tab-pane" id="panel-402-{{$each_year}}">
                                            <div class="list-group">
                                                @foreach($projects_all_year[$index] as $project)
                                                <div class="list-group-item">
                                                    <h5>
                                                        @if(isset($project['name']))
                                                            {{$project['name']}}
                                                        @else
                                                            <span>--</span>
                                                        @endif
                                                        <span class="badge">
                                                        项目
                                                        </span>
                                                    </h5>
                                                    <p>
                                                        <span>
                                                        @if(isset($project['date_begin']))
                                                            {{$project['date_begin']}}
                                                        @else
                                                            <span>none</span>
                                                        @endif
                                                        </span>
														<span>--</span>
                                                        <span>
                                                        @if(isset($project['date_finish']))
                                                            {{$project['date_finish']}}
                                                        @else
                                                            <span>none</span>
                                                        @endif
                                                        </span>
                                                    </p>
													<p>
                                                        <span>
                                                        @if(isset($project['department']))
                                                            {{$project['department']}}
                                                        @else
                                                            <span>--</span>
                                                        @endif
                                                        </span>
                                                        <span>
                                                        @if(isset($project['date_setup']))
                                                            {{$project['date_setup']}}
                                                        @else
                                                            <span>--</span>
                                                        @endif
                                                        </span>
                                                    </p>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="tab-pane" id="panel-306">
                                    <p>
                                        Howdy, I'm in 引用量.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="panel-element-205" class="tab-pane panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            课程
                                        </th>
                                        <th>
                                            英文名
                                        </th>
                                        <th>
                                            编号
                                        </th>
                                        <th>
                                            学院
                                        </th>
                                        <th>
                                            专业
                                        </th>
                                        <th>
                                            年级
                                        </th>
                                        <th>
                                            学期
                                        </th>
                                        <th>
                                            年份
                                        </th>
                                        <th>
                                            学分
                                        </th>
                                        <th>
                                            学科
                                        </th>
                                    </tr>
                                </thead>
                                @foreach($courses as $course)
                                    <tr>
                                        <td>
                                            @if(isset($course['name']))
                                                {{$course['name']}}
                                            @else
                                                <span>--</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($course['enname']))
                                                {{$course['enname']}}
                                            @else
                                                <span>--</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($course['nid']))
                                                {{$course['nid']}}
                                            @else
                                                <span>--</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($course['faculty']))
                                                {{$course['faculty']}}
                                            @else
                                                <span>--</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($course['major']))
                                                {{$course['major']}}
                                            @else
                                                <span>--</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($course['grade']))
                                                {{$course['grade']}}
                                            @else
                                                <span>--</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($course['term']))
                                                {{$course['term']}}
                                            @else
                                                <span>--</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($course['year']))
                                                {{$course['year']}}
                                            @else
                                                <span>--<span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($course['credit']))
                                                {{$course['credit']}}
                                            @else
                                                <span>--</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($course['knowledge']))
                                                {{$course['knowledge']}}
                                            @else
                                                <span>--</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    
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
        graph = graph.replace(reg,'"')
        console.log('graph',graph)

        var teachers = "{{ $teacherss }}"
        //将转义字符转换回来 转换成正常的json字符串
        teachers = teachers.replace(reg,'"')
        console.log('teachers',teachers)

        var DateCount = "{{ $DateCount }}"
        DateCount = DateCount.replace(reg,'"')
        console.log('DateCount',DateCount)
    </script>
    <script src="{{ URL::asset('js/echart/final.js')}}"></script>
    <script src="{{ URL::asset('js/actual/actual.js')}}"></script>
@endsection
