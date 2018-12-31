<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Landing Page - Start Bootstrap Theme</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ URL::asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Custom fonts for this template -->
    <link href="{{ URL::asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('vendor/simple-line-icons/css/simple-line-icons.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link href="{{ URL::asset('css/landing-page.min.css')}}" rel="stylesheet">
    <script src="{{ URL::asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <style type="text/css">
        .container-header {
          width: 100%;
          display: flex;
          flex-direction: row;
          justify-content: space-between;
          align-items: center;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#submit").click(function(){
                let teacherName = $("#teacherName").val();
                $.get("/laravel/public/index.php/neo4j/search?teacherName="+ teacherName,
                    function(data,status){
                        $("#output").html(data);
                });
            });
        });

    </script>
  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-light bg-light static-top">
      <div class="container-header">
        <img src="{{ URL::asset('img/bupt-logo.png')}}" style="width: 300px; height: 80px">
        <a class="btn btn-primary" href="#">登陆</a>
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
      </div>
    </header>
    <section class="features-icons bg-light text-center">
      <div class="container">
        <div id="output" class="row">
        </div>
      </div>
    </section>
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
    </footer>

    <!-- Bootstrap core JavaScript -->


  </body>

</html>
