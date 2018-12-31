    $('#submit_teacher').click(function(){
        var search_value_teacher=$('#teacherName').val().trim()
        location.href='actual/detail?name='+search_value_teacher
    })    
    $('#submit_class').click(function(){
        var search_value_class=$('#className').val().trim()
        location.href='actual/class?name='+search_value_class
    })    
    $('#submit_teachers').click(function(){
        var search_value_teachers=$('#teachersName').val().trim()
        location.href='actual/teachers?name='+search_value_teachers
    })    

    $('#submit_multi_teacher').click(function(){
        var multi_name=$('#multiName').val().trim()
        location.href='http://10.3.55.50/laravel/public/index.php/actual/detail?name='+multi_name
    })    
    $('#submit_multi_class').click(function(){
        var multi_name=$('#multiName').val().trim()
        location.href='http://10.3.55.50/laravel/public/index.php/actual/class?name='+multi_name
    })    
    $('#submit_multi_teachers').click(function(){
        var multi_name=$('#multiName').val().trim()
        location.href='http://10.3.55.50/laravel/public/index.php/actual/teachers?name='+multi_name
    })    
    $('#submit_rd').click(function(){
        var search_value=$('#multiName').val().trim()
        location.href='http://10.3.55.50/laravel/public/index.php/actual/rdetail?name='+search_value
    })   
