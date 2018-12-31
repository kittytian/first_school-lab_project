<div class="container">
    <div class="row clearfix">
        <div class="col-md-12 column">
            <div class="panel-group" id="panel-100">
                <div class="panel panel-default">
                    <div class="panel-heading">
                         <a class="panel-title" data-toggle="collapse" data-parent="#panel-100" href="#panel-element-200">课程</a>
                    </div>
                    <div id="panel-element-200" class="panel-collapse in">
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
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                         <a class="panel-title collapsed" data-toggle="collapse" data-parent="#panel-100" href="#panel-element-201">论文</a>
                    </div>
                    <div id="panel-element-201" class="panel-collapse collapse">
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
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                         <a class="panel-title collapsed" data-toggle="collapse" data-parent="#panel-100" href="#panel-element-202">专著专利</a>
                    </div>
                    <div id="panel-element-202" class="panel-collapse collapse">
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
