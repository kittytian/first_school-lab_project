    $('#submit_teacher').click(function(){
        var search_value_teacher=$('#teacherName').val().trim()
        location.href='/laravel/public/index.php/actual/detail?name='+search_value_teacher
    })    
    $('#submit_class').click(function(){
        var search_value_class=$('#className').val().trim()
        location.href='/laravel/public/index.php/actual/class?name='+search_value_class
    })    
    $('#submit_teachers').click(function(){
        var search_value_teachers=$('#teachersName').val().trim()
        location.href='/laravel/public/index.php/actual/teachers?name='+search_value_teachers
    })    

    $('#submit_multi_teacher').click(function(){
        var multi_name=$('#multiName').val().trim()
        location.href='/laravel/public/index.php/actual/detail?name='+multi_name
    })    
    $('#submit_multi_class').click(function(){
        var multi_name=$('#multiName').val().trim()
        location.href='/laravel/public/index.php/actual/class?name='+multi_name
    })    
    $('#submit_multi_teachers').click(function(){
        var multi_name=$('#multiName').val().trim()
        location.href='/laravel/public/index.php/actual/teachers?name='+multi_name
    })    
    $('#submit_rd').click(function(){
        var search_value=$('#multiName').val().trim()
        location.href='/laravel/public/index.php/actual/rdetail?name='+search_value
    })   
    $('#submit_my').click(function(){
        var search_value=$('#multiName').val().trim()
        location.href='/laravel/public/index.php/actual/roma?entity='+search_value
    })   
    
    //存储查询类型
    var globalsearch = 'detail'
    function test(keyword,event){  
                
        //定义全局变量  
        var keyword = $("#multiName").val();   
        var sel = document.getElementById("sel"); 
        var regExp = new RegExp(keyword, "g");//创建正则表达式，g表示全局的，如果不用g，则查找到第一个就不会继续向下查找了；
        $.getJSON(       
                "/laravel/public/index.php/actual/presearch",//url  
                "keyword="+ keyword,//发送的数据  
                function(res){//获取响应回来的数据  
                    console.log('res',res);
                    var data = res.data;
                    if(res.type){
                        switch(res.type){
                            case 0:globalsearch='detail';break;
                            case 1:globalsearch='teachers';break;
                        }
                    }
                    document.getElementById("sel").innerHTML="";  
                    /* var arr = new Array;  
                       var arr = data.split("#");//将响应回来的数据按#拆分成数组           

                       for(var i=0;i<arr.length;i++){//循环每一个满足条件的记录  
                    //将当前循环满足条件的商品名称生成一个下拉的选项  
                    sel.options[i]=new Option(arr[i],i);  
                    }  */
                    for(var i=0;i<data.length;i++){
                        //将当前循环满足条件的商品名称生成一个下拉的选项  
                        //sel.options[i]=new Option(data[i].showWords,i);
                        $('#sel').append("<option data-num='"+data[i].tnumber+"' data-name='"+data[i].teacherName+"'>"+data[i].showWords+"</option>");

                    }
                    //自动设置高度
                    sel.size=data.length;
                    //判断是否有满足条件的商品  
                    if(data.length>0){  
                        sel.style.display='block';  
                    }else{  
                        sel.style.display='none';  
                    }  
                    //当用户按下上下键时获取相应的值  
                    if(event.keyCode==40){  
                        sel.focus();  
                    }     
                    //搜索到的关键字加粗
                    $("#sel option").each(function()//遍历文章；
                            {  //遍历所有option  
                                var txt = $(this).html();   //获取option值 
                                var newHtml = txt.replace(regExp, "<strong style='color:black'>"+keyword+"</strong>");//将找到的关键字替换，加上highlight属性；
                                $(this).html(newHtml);//更新文章；
                            });
                }); 
    };
    //失焦事件
    function inputonblurs(){
        var sel = document.getElementById("sel"); 
        sel.innerHTML="";  
        sel.style.display='none';  

    }
    function test2(){  
        //输入回车，获取输入框内容焦点  
        /* $("#sel").keypress(function(){  
           $("#search_input").focus();  
           $("#sel").css("display","none");  
           }); */ 
        //双击，获取输入框内容焦点  
        $("#sel").click(function(){  
            $("#search_input").focus();  
            $("#sel").css("display","none");
            /* var keyword=$("#search_input").val();
               location.href="/blog/user/search?searchid="+keyword;*/
        });  
        //将选中的下拉列表中的内容添加到输入框中  
        $("#search_input").val($("option:selected").text());
    }   
    //选择下拉框的点击事件
    $('#sel').on('change',function(){
        var name=$("option:selected",this).data('name');
        var tnumber=$("option:selected",this).data('num');
        window.location.href="/laravel/public/index.php/actual/"+globalsearch+"?name="+name+"&tnumber="+tnumber;
    });
