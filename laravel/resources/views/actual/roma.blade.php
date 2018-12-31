<!DOCTYPE html>
<html style="overflow: hidden;" lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta charset="UTF-8">
  <title>校园知识图谱</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="{{ URL::asset('KGGraph_files/d3.js')}}"></script>
  <script src="{{ URL::asset('KGGraph_files/jquery.js')}}"></script>
  <script src="{{ URL::asset('KGGraph_files/velocity.js')}}"></script>
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('KGGraph_files/semantic.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('KGGraph_files/dropdown.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('KGGraph_files/graph_d3.css')}}">
  <script src="{{ URL::asset('KGGraph_files/semantic.js')}}"></script>
  <script src="{{ URL::asset('KGGraph_files/dropdown.js')}}"></script>

</head>
<body>
<div class="kg-graph">
  <svg width="1536" height="740"><g class="canvas" transform="translate(768,370)"><g id="spiral-container"></g><g id="relation-container"></g><g id="node-container"></g><g id="concept-container"></g><path style="fill: rgb(96, 92, 98);" d="M17.67766952966369,-17.67766952966369A25,25,0,0,1,3.528000201496679,24.749812415011135L3.2457601853769447,22.769827421810245A23,23,0,0,0,16.263455967290593,-16.263455967290593Z" id="loadingCurve" visibility="hidden"></path></g></svg>
  <div class="tooltip" style="opacity: 0">
    <div class="tooltip-in">
      <div class="result-poster named-entity">
        <div class="result-img img-circle">
          <a style="background-image: url('about:black'); background-color: rgb(26, 172, 164);"></a>
        </div>
      </div>
      <div class="result-definition">
        <h3><a class="title"></a></h3>
        <div class="line-clamp-3"><p class="des"></p></div>
      </div>
    </div>
  </div>
  <div class="navigation-bar" style="visibility: hidden; height: 540px;"></div>
  <div class="legend" style="visibility: hidden;">
    <div class="li">
      <div class="circle small" style="background-color:#13a89e"></div>
      <div class="text">已知关系</div>
    </div>
    <div class="li">
      <div class="circle small" style="background-color:#5d3fd5"></div>
      <div class="text">潜在关系</div>
    </div>

  </div>
  <div class="nodes-history"></div>
  <div class="dummy"></div>
  <div class="dummy2"></div>
  <div class="predicate-filter" style="visibility: hidden;">
    <select class="" id="predicate-select">
      <option value="" selected="selected">筛选关系</option>
    </select>
  </div>

</div>
<script src="{{ URL::asset('KGGraph_files/graphd3.js')}}"></script>

</body></html>
