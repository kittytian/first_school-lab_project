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
    <div class="row" id="app" style="width: 600px;height:400px;">
    </div>
</div>
@endsection

@section('script-foot')
    <script type="text/javascript">
        var test = "{{ $test }}"
        //将转义字符转换回来 转换成正常的json字符串
        var reg = new RegExp("\&quot;","g");
        test = test.replace(reg,'"')
        console.log('test',test)
    </script>
    <script src="{{ URL::asset('js/echart/myecharts.js')}}"></script>
@endsection
