<!DOCTYPE html>
<html>
    <head>
        <title>教师名搜索</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!-- 引入 Bootstrap -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
 
        <!-- HTML5 Shiv 和 Respond.js 用于让 IE8 支持 HTML5元素和媒体查询 -->
        <!-- 注意： 如果通过 file://  引入 Respond.js 文件，则该文件无法起效果 -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-3 column">
                    <ul class="nav nav-tabs nav-stacked">
                        <li class="active">
                            <a href="#panel-element-201" data-toggle="tab">课程</a>
                        </li>
                        <li>
                            <a href="#panel-element-202" data-toggle="tab">论文</a>
                        </li>
                        <li>
                            <a href="#panel-element-203" data-toggle="tab">专著专利</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-9 column" style="box-shadow:0 0 5px #d3d3d3;">
                    <div class="tabbable" id="tabs-19467">
                        <div class="tab-content">
                            <div id="panel-element-201" class="tab-pane active panel-collapse in">
                                <div class="panel-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>
                                                    name
                                                </th>
                                                <th>
                                                    enname
                                                </th>
                                                <th>
                                                    nid
                                                </th>
                                                <th>
                                                    faculty
                                                </th>
                                                <th>
                                                    major
                                                </th>
                                                <th>
                                                    grade
                                                </th>
                                                <th>
                                                    term
                                                </th>
                                                <th>
                                                    credit
                                                </th>
                                                <th>
                                                    knowledge
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
                            <div id="panel-element-202" class="tab-pane panel-collapse collapse">
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
                            
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </body>
</html>


