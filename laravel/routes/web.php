<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('actual.test');
});
Route::get('/class', function () {
    return view('demo.class');
});

Route::get('/teachers', function () {
    return view('demo.teachers');
});
Route::get('neo4j/search', "Neo4jController@search");
Route::get('neo4j/index', "Neo4jController@index");
Route::get('search', 'TeacherController@search');
Route::get('index', function(){
        return view('search');
    });



Route::group(['prefix'=>'actual'],function(){
    Route::get('/',function(){
        return view('actual.index');
    });
    //搜索教师
    Route::get('detail','ActualController@index');
    //搜索课程
    Route::get('class','DemoCourseController@index');
    //搜索多名教师
    Route::get('teachers','DemoController@teachers');
    //重名预搜索
    Route::get('presearch','ActualController@presearch');
    //研究方向详情页
    Route::get('rdetail','ResearchController@rdetail');
    //漫游图
    Route::group(['prefix'=>'roma'],function(){
        Route::get('/',function(){
            return view('actual.roma');
        });
        Route::get('/getdata','RomaController@getdata');
        Route::get('/getconcepts','RomaController@getconcepts');
    });
});



Route::group(['prefix'=>'demo'],function(){
    Route::get('/',function(){
        return view('demo.index');
    });
    Route::get('detail','DemoController@index');
    //搜索课程
    Route::get('class','DemoCourseController@index');
    //搜索多名教师
    Route::get('teachers','DemoController@teachers');
    //研究方向
    Route::get('r&d',function(){
        return view('demo.researchDire');
    });
    //研究方向详情页
    Route::get('rdetail','DemoController@rdetail');
});


Route::get('echart', 'DemoController@echart');
