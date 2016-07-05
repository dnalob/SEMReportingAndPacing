$(document).ready(function() {

    function alphanumeric(inputtxt)  
    {  
        var letterNumber = /^[A-Za-z\d\s\(\)\-\'\\]*$/;  
        if (inputtxt.match(letterNumber))   
        {  
            return true;  
        }  
        else  
        {   
            alert("No special characters");   
            return false;   
        }  
    }



//POPULATE ACCOUNTS



    $(function ()     
    {
        $.ajax({                                      
            url: 'includes/T2_reg_accounts_bing.php',                  //the script to call to get data          
            data: "",                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
            dataType: 'json',                //data format      
            success: function(data)          //on recieve of reply
            {
                var html = "<ul class=\"scrollable-menu\" role=\"menu\">";
                $.each(data, function(index,value) {
                    html+="<li data-id=\""+value.id+"\" id=\"record-"+$.trim(value.name)+"\"><span class=\"text-left\"><a href='#' class=\"ajax-edit-bing-t2 ajax-edit-name\">"+$.trim(value.name)+"</a></span><span><a href='#' class=\"ajax-edit-bing-t2 ajax-edit-code\">"+$.trim(value.code)+"</a></span><span class=\"text-left\"><a href='#' class=\"ajax-edit-bing-t2 ajax-edit-filter\">"+$.trim(value.filter)+"</a></span><span class=\"lastSpan\"><a href=\"?reg_delete="+$.trim(value.id)+"\" class=\"bing_reg_delete\"><i class=\"fa fa-times fa-2x\"></i></a></span></li>";
                });
                html+="</ul><div class=\"lastRow\"><span><label for=\"bing_input1\">Account Name</label><input required=\"required\" id=\"bing_input1\" class=\"form-control\"></input></span><span><label for=\"bing_input2\">Account ID</label><input required=\"required\" id=\"bing_input2\" class=\"form-control\"></input></span><span><label for=\"bing_input3\">Filter</label><input id=\"bing_input3\" class=\"pull-left form-control\"></input></span><span class=\"lastSpan\"><button class=\"btn btn-primary\" id=\"bing_reg_submit\">Submit</button></span></div>";
                $("#regT2TableBing").append(html);
            }
        })

        $.ajax({                                      
            url: 'includes/T2_lux_accounts_bing.php',                  //the script to call to get data          
            data: "",                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
            dataType: 'json',                //data format      
            success: function(data)
            {
                var html = "<ul class=\"scrollable-menu\" role=\"menu\">";
                $.each(data, function(index,value) {
                    html+="<li data-id=\""+value.id+"\" id=\"record-"+$.trim(value.name)+"\"><span class=\"text-left\"><a href='#' class=\"ajax-edit-bing-t2-lux ajax-edit-name\">"+$.trim(value.name)+"</a></span><span><a href='#' class=\"ajax-edit-bing-t2-lux ajax-edit-code\">"+$.trim(value.code)+"</a></span><span class=\"text-left\"><a href='#' class=\"ajax-edit-bing-t2-lux ajax-edit-filter\">"+$.trim(value.filter)+"</a></span><span class=\"lastSpan\"><a href=\"?lux_delete="+$.trim(value.id)+"\" class=\"bing_lux_delete\"><i class=\"fa fa-times fa-2x\"></i></a></span></li>";
                });
                html+="</ul><div class=\"lastRow\"><span><label for=\"bing_lux_input1\">Account Name</label><input required=\"required\" id=\"bing_lux_input1\" class=\"form-control\"></input></span><span><label for=\"bing_lux_input2\">Account ID</label><input required=\"required\" id=\"bing_lux_input2\" class=\"form-control\"></input></span><span><label for=\"bing_lux_input3\">Filter</label><input id=\"bing_lux_input3\" class=\"pull-left form-control\"></input></span><span class=\"lastSpan\"><button class=\"btn btn-primary\" id=\"bing_lux_submit\">Submit</button></span></div>";
                $("#luxT2TableBing").append(html);
            }
        })
    });



//DELETE ACCOUNT



    $(document.body).on('click', 'a.bing_reg_delete' ,function(e) {
        e.preventDefault()
    	var id = $(this).attr('href').replace('?reg_delete=','');
        var parent = $(this).closest('li');
         
        $.ajax({
            type: 'get',
            url: 'index.php',
            data: 'ajax=1&bing_reg_delete=' + id,
            beforeSend: function() {
                parent.animate({'backgroundColor':'#fb6c6c'},300);
            },
            success: function(data) {
                parent.fadeOut(400,function() {
                    parent.remove();
                });
            }
        });
    });

    $(document.body).on('click', 'a.bing_lux_delete' ,function(e) {
        e.preventDefault()
 		var id = $(this).attr('href').replace('?lux_delete=','');
        var parent = $(this).closest('li');

        $.ajax({
            type: 'get',
            url: 'index.php',
            data: 'ajax=1&bing_lux_delete=' + id,
            beforeSend: function() {
                parent.animate({'backgroundColor':'#fb6c6c'},300);
            },
            success: function(data) {
                parent.fadeOut(400,function() {
                    parent.remove();
                });
            }
        });
    });



//INSERT ACCOUNT



    $(document.body).on('click', '#bing_reg_submit' ,function(e) {
        e.preventDefault()
        var content1 = $('#bing_input1').val();
        var content2 = $('#bing_input2').val();
        var content3 = $('#bing_input3').val();

        if (alphanumeric(content1) == true) {
            if (alphanumeric(content2) == true) {
                if (alphanumeric(content3) == true) {
                    $.ajax({
                        cache: false,
                        type: "POST",
                        url: "index.php",
                        data: "regBingContent1=" + content1 + "&regBingContent2=" + content2 + "&regBingContent3=" + content3,
                        dataType: "text",
                        success: function (data) {
                            console.log('success',data);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            console.log('error',thrownError);
                        }
                    });
                }
            }
        }
    });

    $(document.body).on('click', '#bing_reg_submit' ,function(e) {
        e.preventDefault()
        $('#regT2TableBing ul').remove();
        $('#regT2TableBing div.lastRow').remove();

        $.ajax({                                      
            url: 'includes/T2_reg_accounts_bing.php',                  //the script to call to get data          
            data: "",                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
            dataType: 'json',                //data format      
            success: function(data)          //on recieve of reply
            {
                var html = "<ul class=\"scrollable-menu\" role=\"menu\">";
                $.each(data, function(index,value) {
                    html+="<li data-id=\""+value.id+"\" id=\"record-"+$.trim(value.name)+"\"><span class=\"text-left\"><a href='#' class=\"ajax-edit-bing-t2 ajax-edit-name\">"+$.trim(value.name)+"</a></span><span><a href='#' class=\"ajax-edit-bing-t2 ajax-edit-code\">"+$.trim(value.code)+"</a></span><span class=\"text-left\"><a href='#' class=\"ajax-edit-bing-t2 ajax-edit-filter\">"+$.trim(value.filter)+"</a></span><span class=\"lastSpan\"><a href=\"?reg_delete="+$.trim(value.id)+"\" class=\"bing_reg_delete\"><i class=\"fa fa-times fa-2x\"></i></a></span></li>";
                });
                html+="</ul><div class=\"lastRow\"><span><label for=\"bing_input1\">Account Name</label><input required=\"required\" id=\"bing_input1\" class=\"form-control\"></input></span><span><label for=\"bing_input2\">Account ID</label><input required=\"required\" id=\"bing_input2\" class=\"form-control\"></input></span><span><label for=\"bing_input3\">Filter</label><input id=\"bing_input3\" class=\"pull-left form-control\"></input></span><span class=\"lastSpan\"><button class=\"btn btn-primary\" id=\"bing_reg_submit\">Submit</button></span></div>";
                $("#regT2TableBing").append(html);
            }
        })
    });

    $(document.body).on('click', '#bing_lux_submit' ,function(e) {
        e.preventDefault()
        var content1 = $('#bing_lux_input1').val();
        var content2 = $('#bing_lux_input2').val();
        var content3 = $('#bing_lux_input3').val();
                 
        if (alphanumeric(content1) == true) {
            if (alphanumeric(content2) == true) {
                if (alphanumeric(content3) == true) {
                    $.ajax({
                        cache: false,
                        type: "POST",
                        url: "index.php",
                        data: "luxBingContent1=" + content1 + "&luxBingContent2=" + content2 + "&luxBingContent3=" + content3,
                        dataType: "text",
                        success: function (data) {
                            console.log('success',data);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            console.log('error',thrownError);
                        }
                    });
                }
            }
        }
    });

    $(document.body).on('click', '#bing_lux_submit' ,function(e) {
        e.preventDefault()
        $('#luxT2TableBing ul').remove();
        $('#luxT2TableBing div.lastRow').remove();

        $.ajax({                                      
            url: 'includes/T2_lux_accounts_bing.php',                  //the script to call to get data          
            data: "",                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
            dataType: 'json',                //data format      
            success: function(data)
            {
                var html = "<ul class=\"scrollable-menu\" role=\"menu\">";
                $.each(data, function(index,value) {
                    html+="<li data-id=\""+value.id+"\" id=\"record-"+$.trim(value.name)+"\"><span class=\"text-left\"><a href='#' class=\"ajax-edit-bing-t2-lux ajax-edit-name\">"+$.trim(value.name)+"</a></span><span><a href='#' class=\"ajax-edit-bing-t2-lux ajax-edit-code\">"+$.trim(value.code)+"</a></span><span class=\"text-left\"><a href='#' class=\"ajax-edit-bing-t2-lux ajax-edit-filter\">"+$.trim(value.filter)+"</a></span><span class=\"lastSpan\"><a href=\"?lux_delete="+$.trim(value.id)+"\" class=\"bing_lux_delete\"><i class=\"fa fa-times fa-2x\"></i></a></span></li>";
                });
                html+="</ul><div class=\"lastRow\"><span><label for=\"bing_lux_input1\">Account Name</label><input required=\"required\" id=\"bing_lux_input1\" class=\"form-control\"></input></span><span><label for=\"bing_lux_input2\">Account ID</label><input required=\"required\" id=\"bing_lux_input2\" class=\"form-control\"></input></span><span><label for=\"bing_lux_input3\">Filter</label><input id=\"bing_lux_input3\" class=\"pull-left form-control\"></input></span><span class=\"lastSpan\"><button class=\"btn btn-primary\" id=\"bing_lux_submit\">Submit</button></span></div>";
                $("#luxT2TableBing").append(html);
            }
        })
    });
    
}); 