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
    <div class="row justify-content-md-center g-bottom">
        <div class="col-md-7">
            <div class="container jumbotron g-c-title">
                <div class="row g-title">
                    <p>关系</p>
                </div>
                <div class="row">
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="container jumbotron">
                <div class="row g-title">
                    <p>文本</p>
                </div>
                <div class="row g-content4" id="app_research">
                    
                </div>
            </div>
        </div>
    </div>
    <!--div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="row jumbotron">
            </div>
        </div>
    </div-->
</div>
@endsection

