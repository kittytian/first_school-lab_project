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
    <div class="row justify-content-md-center g-bottom">
        <div class="col-md-3">
            <div class="row g-sider-2">
                <div class="container jumbotron g-c-title">
                    <div class="row g-title">
                        <p>基本属性</p>
                    </div>
                    <div class="row g-content">
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
            <div class="row g-sider-2">
                <div class="container jumbotron g-c-title">
                    <div class="row g-title">
                        <p>年份趋势</p>
                    </div>
                    <div class="row g-content4" id="app_research">
        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="container jumbotron">
                <div class="row g-title">
                    <p>合作关系</p>
                </div>
                <div class="row g-content2" id="app">
                    
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-md-center g-bottom">
        <div class="col-md-6">
            <div class="container jumbotron g-c-title">
                <div class="row g-title">
                    <p>课程/论文/著作</p>
                </div>
                <div class="row g-content4">
                    @include('demo.cpl')
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="container jumbotron">
                <div class="row g-title">
                    <p>研究方向</p>
                </div>
                <div class="row g-content4" >
                    
                </div>
            </div>
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
    </script>
    <script src="{{ URL::asset('js/echart/final.js')}}"></script>
@endsection
