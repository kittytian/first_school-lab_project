@extends('actual.base')

@section('style')
    <link href="{{ URL::asset('css/actual/actual.css') }}" rel="stylesheet"/>
    <link href="{{ URL::asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('vendor/simple-line-icons/css/simple-line-icons.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link href="{{ URL::asset('css/landing-page.min.css')}}" rel="stylesheet">
    <style type="text/css">
        .container-header {
          width: 100%;
          display: flex;
          flex-direction: row;
          justify-content: space-between;
          align-items: center;
        }
        .form-row{
            margin-bottom:5px;
        }
    </style>
@endsection

@section('script-head')
    <script src="{{ URL::asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('vendor/jquery/jquery.js')}}"></script>
@endsection

@section('content')
<!--div class="container">
    <div class="row">
        <div class="col-xl-9 mx-auto">
            <h1 class="mb-5">欢迎来到北京邮电大学知识图谱网站!</h1>
        </div>
        <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
            <form>
                <div class="form-row">
                    <div class="col-12 col-md-9 mb-2 mb-md-0">
                        <input type="text" id="teacherName" class="form-control form-control-lg" placeholder="输入教师姓名">
                    </div>
                    <div class="col-12 col-md-3">
                        <button type="button" id="submit" class="btn btn-block btn-lg btn-primary">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div-->
    <!-- Navigation -->
    <nav class="navbar navbar-light bg-light static-top">
      <div class="container-header">
            <img src="{{ URL::asset('img/bupt-logo.gif')}}" style="width: 300px; height: 80px">
            <img src="{{ URL::asset('img/bupt-logo.png')}}" style="width: 200px; height: 53px">
      </div>
    </nav>

    <!-- Masthead -->
    <header class="masthead text-white text-center">
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-xl-9 mx-auto">
            <h1 class="mb-5">欢迎来到北京邮电大学知识图谱网站!</h1>
          </div>
          <div class="col-12 mx-auto">
            <form>
              <div class="form-row">
                <div style="width:35%">
                  <input type="text" autocomplete="off" id="multiName" onkeyup="test(this.vlaue,event)" onblur="inputonblur()" class="form-control" placeholder="输入教师姓名、课程关键字、研究方向关键字">
                  <!--<select  multiple="multiple" id="sel" onchange="test2()" style="width:100%;display:none;color:gray;position:absolute;left:0"></select>-->
                </div>
                <div style="width:13%;padding-left:1%">
                  <button type="button" id="submit_multi_teacher" class="btn btn-block btn-primary">搜索教师</button>
                </div>
                <div style="width:13%;padding-left:1%">
                  <button type="button" id="submit_multi_teachers" class="btn btn-block btn-primary">搜索多名教师</button>
                </div>
                <div style="width:13%;padding-left:1%">
                  <button type="button" id="submit_multi_class" class="btn btn-block btn-primary">搜索课程</button>
                </div>
                <div style="width:13%;padding-left:1%">
                  <button type="button" id="submit_rd" class="btn btn-block btn-primary">搜索研究方向</button>
                </div>
                <div style="width:8%;padding-left:1%">
                  <button type="button" id="submit_my" class="btn btn-block btn-primary">漫游</button>
                </div>
              </div>
              <div class="row">
                <select  multiple="multiple" id="sel" onchange="test2()" style="width:100%;display:none;color:gray;position:absolute;left:0"></select>
              </div>
              <div class="form-row">
                <p style="margin: 0 auto;">
                    小贴士：</br>
                    搜索教师名后请点击下拉栏中的备选教师，否则将返回默认教师信息</br>
                    搜索多名教师时请以空格做分隔符，并点击下拉栏中的备选教师</br>
                    搜索课程时可输入通信原理、java等关键字</br>
                    搜索研究方向时可输入大数据、无线通信等关键字</br>
                </p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </header>
    <!-- Footer -->
    <footer class="footer bg-light">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 h-100 text-center text-lg-left my-auto">
            <ul class="list-inline mb-2">
              <li class="list-inline-item">
                <a href="#">About</a>
              </li>
              <li class="list-inline-item">&sdot;</li>
              <li class="list-inline-item">
                <a href="#">Contact</a>
              </li>
              <li class="list-inline-item">&sdot;</li>
              <li class="list-inline-item">
                <a href="#">Terms of Use</a>
              </li>
              <li class="list-inline-item">&sdot;</li>
              <li class="list-inline-item">
                <a href="#">Privacy Policy</a>
              </li>
            </ul>
            <p class="text-muted small mb-4 mb-lg-0">版权所有 © 北京邮电大学  地址:北京市西土城路10号  邮编:100876  </p>
          </div>
        </div>
        <!--<div class="row clearfix">
            <div class="col-md-12 column">
                <div id="output">
                </div>
            </div>
        </div>-->
      </div>
    </footer>

@endsection

@section('script-foot')
    <script src="{{ URL::asset('js/actual/actual.js')}}"></script>
@endsection
