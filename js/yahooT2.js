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
            url: 'includes/T2_reg_accounts_yahoo.php',                  //the script to call to get data          
            data: "",                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
            dataType: 'json',                //data format      
            success: function(data)          //on recieve of reply
            {
                var html = "<ul class=\"scrollable-menu\" role=\"menu\">";
                $.each(data, function(index,value) {
                    html+="<li data-id=\""+value.id+"\" id=\"record-"+$.trim(value.name)+"\"><span class=\"text-left\"><a href='#' class=\"ajax-edit-yahoo ajax-edit-name\">"+$.trim(value.name)+"</a></span><span><a href='#' class=\"ajax-edit-yahoo ajax-edit-code\">"+$.trim(value.code)+"</a></span><span class=\"text-left\"><a href='#' class=\"ajax-edit-yahoo ajax-edit-filter\">"+$.trim(value.filter)+"</a></span><span class=\"lastSpan\"><a href=\"?reg_delete="+$.trim(value.id)+"\" class=\"yahoo_reg_delete\"><i class=\"fa fa-times fa-2x\"></i></a></span></li>";
                });
                html+="</ul><div class=\"lastRow\"><span><label for=\"yahoo_input1\">Account Name</label><input required=\"required\" id=\"yahoo_input1\" class=\"form-control\"></input></span><span><label for=\"yahoo_input2\">Account ID</label><input required=\"required\" id=\"yahoo_input2\" class=\"form-control\"></input></span><span><label for=\"yahoo_input3\">Filter</label><input id=\"yahoo_input3\" class=\"pull-left form-control\"></input></span><span class=\"lastSpan\"><button class=\"btn btn-primary\" id=\"yahoo_reg_submit\">Submit</button></span></div>";
                $("#regTableYahoo").append(html);
            }
        })

        $.ajax({                                      
            url: 'includes/T2_lux_accounts_yahoo.php',                  //the script to call to get data          
            data: "",                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
            dataType: 'json',                //data format      
            success: function(data)
            {
                var html = "<ul class=\"scrollable-menu\" role=\"menu\">";
                $.each(data, function(index,value) {
                    html+="<li data-id=\""+value.id+"\" id=\"record-"+$.trim(value.name)+"\"><span class=\"text-left\"><a href='#' class=\"ajax-edit-yahoo-lux ajax-edit-name\">"+$.trim(value.name)+"</a></span><span><a href='#' class=\"ajax-edit-yahoo-lux ajax-edit-code\">"+$.trim(value.code)+"</a></span><span class=\"text-left\"><a href='#' class=\"ajax-edit-yahoo-lux ajax-edit-filter\">"+$.trim(value.filter)+"</a></span><span class=\"text-left\"><a href='#' class=\"ajax-edit-yahoo-lux ajax-edit-campaign1\">"+$.trim(value.lux_campaign_1)+"</a></span><span class=\"text-left\"><a href='#' class=\"ajax-edit-yahoo-lux ajax-edit-campaign2\">"+$.trim(value.lux_campaign_2)+"</a></span><span class=\"lastSpan\"><a href=\"?lux_delete="+$.trim(value.id)+"\" class=\"yahoo_lux_delete\"><i class=\"fa fa-times fa-2x\"></i></a></span></li>";
                });
                html+="</ul><div class=\"lastRow\"><span><label for=\"yahoo_lux_input1\">Account Name</label><input required=\"required\" id=\"yahoo_lux_input1\" class=\"form-control\"></input></span><span><label for=\"yahoo_lux_input2\">Account ID</label><input required=\"required\" id=\"yahoo_lux_input2\" class=\"form-control\"></input></span><span><label for=\"yahoo_lux_input3\">Filter</label><input id=\"yahoo_lux_input3\" class=\"pull-left form-control\"></input></span><span><label for=\"yahoo_lux_input4\">Campaign ID</label><input id=\"yahoo_lux_input4\" class=\"pull-left form-control\"></input></span><span><label for=\"yahoo_lux_input5\">Campaign ID</label><input id=\"yahoo_lux_input5\" class=\"pull-left form-control\"></input></span><span class=\"lastSpan\"><button class=\"btn btn-primary\" id=\"yahoo_lux_submit\">Submit</button></span></div>";
                $("#luxTableYahoo").append(html);
            }
        })
    });



//DELETE ACCOUNT



    $(document.body).on('click', 'a.yahoo_reg_delete' ,function(e) {
        e.preventDefault()
        var id = $(this).attr('href').replace('?reg_delete=','');
        var parent = $(this).closest('li');
         
        $.ajax({
            type: 'get',
            url: 'index.php',

            data: 'ajax=1&yahoo_reg_delete=' + id,
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


    $(document.body).on('click', 'a.yahoo_lux_delete' ,function(e) {
        e.preventDefault()
        var id = $(this).attr('href').replace('?lux_delete=','');
        var parent = $(this).closest('li');
         
        $.ajax({
            type: 'get',
            url: 'index.php',

            data: 'ajax=1&yahoo_lux_delete=' + id,
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



    $(document.body).on('click', '#yahoo_reg_submit' ,function(e) {
        e.preventDefault()
        var content1 = $('#yahoo_input1').val();
        var content2 = $('#yahoo_input2').val();
        var content3 = $('#yahoo_input3').val();

        if (alphanumeric(content1) == true) {
            if (alphanumeric(content2) == true) {
                if (alphanumeric(content3) == true) {
                    $.ajax({
                        cache: false,
                        type: "POST",
                        url: "index.php",
                        data: "regYahooContent1=" + content1 + "&regYahooContent2=" + content2 + "&regYahooContent3=" + content3,
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

    $(document.body).on('click', '#yahoo_reg_submit' ,function(e) {
        e.preventDefault()
        $('#regTableYahoo ul').remove();
        $('#regTableYahoo div.lastRow').remove();

        $.ajax({                                      
            url: 'includes/T2_reg_accounts_yahoo.php',                  //the script to call to get data          
            data: "",                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
            dataType: 'json',                //data format      
            success: function(data)          //on recieve of reply
            {
                var html = "<ul class=\"scrollable-menu\" role=\"menu\">";
                $.each(data, function(index,value) {
                    html+="<li data-id=\""+value.id+"\" id=\"record-"+$.trim(value.name)+"\"><span class=\"text-left\"><a href='#' class=\"ajax-edit-yahoo ajax-edit-name\">"+$.trim(value.name)+"</a></span><span><a href='#' class=\"ajax-edit-yahoo ajax-edit-code\">"+$.trim(value.code)+"</a></span><span class=\"text-left\"><a href='#' class=\"ajax-edit-yahoo ajax-edit-filter\">"+$.trim(value.filter)+"</a></span><span class=\"lastSpan\"><a href=\"?reg_delete="+$.trim(value.id)+"\" class=\"yahoo_reg_delete\"><i class=\"fa fa-times fa-2x\"></i></a></span></li>";
                });
                html+="</ul><div class=\"lastRow\"><span><label for=\"yahoo_input1\">Account Name</label><input required=\"required\" id=\"yahoo_input1\" class=\"form-control\"></input></span><span><label for=\"yahoo_input2\">Account ID</label><input required=\"required\" id=\"yahoo_input2\" class=\"form-control\"></input></span><span><label for=\"yahoo_input3\">Filter</label><input id=\"yahoo_input3\" class=\"pull-left form-control\"></input></span><span class=\"lastSpan\"><button class=\"btn btn-primary\" id=\"yahoo_reg_submit\">Submit</button></span></div>";
                $("#regTableYahoo").append(html);
            }
        })
    });

    $(document.body).on('click', '#yahoo_lux_submit' ,function(e) {
        e.preventDefault()
        var content1 = $('#yahoo_lux_input1').val();
        var content2 = $('#yahoo_lux_input2').val();
        var content3 = $('#yahoo_lux_input3').val();
        var content4 = $('#yahoo_lux_input4').val();
        var content5 = $('#yahoo_lux_input5').val();
       
        if (alphanumeric(content1) == true) {
            if (alphanumeric(content2) == true) {
                if (alphanumeric(content3) == true) {
                    if (alphanumeric(content4) == true) {
                        if (alphanumeric(content5) == true) {
                            $.ajax({
                                cache: false,
                                type: "POST",
                                url: "index.php",
                                data: "luxYahooContent1=" + content1 + "&luxYahooContent2=" + content2 + "&luxYahooContent3=" + content3 + "&luxYahooContent4=" + content4 + "&luxYahooContent5=" + content5,
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
            }
        }
    });

    $(document.body).on('click', '#yahoo_lux_submit' ,function(e) {
        e.preventDefault()
        $('#luxTableYahoo ul').remove();
        $('#luxTableYahoo div.lastRow').remove();

        $.ajax({                                      
            url: 'includes/T2_lux_accounts_yahoo.php',                  //the script to call to get data          
            data: "",                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
            dataType: 'json',                //data format      
            success: function(data)
            {
                var html = "<ul class=\"scrollable-menu\" role=\"menu\">";
                $.each(data, function(index,value) {
                    html+="<li data-id=\""+value.id+"\" id=\"record-"+$.trim(value.name)+"\"><span class=\"text-left\"><a href='#' class=\"ajax-edit-yahoo-lux ajax-edit-name\">"+$.trim(value.name)+"</a></span><span><a href='#' class=\"ajax-edit-yahoo-lux ajax-edit-code\">"+$.trim(value.code)+"</a></span><span class=\"text-left\"><a href='#' class=\"ajax-edit-yahoo-lux ajax-edit-filter\">"+$.trim(value.filter)+"</a></span><span class=\"text-left\"><a href='#' class=\"ajax-edit-yahoo-lux ajax-edit-campaign1\">"+$.trim(value.lux_campaign_1)+"</a></span><span class=\"text-left\"><a href='#' class=\"ajax-edit-yahoo-lux ajax-edit-campaign2\">"+$.trim(value.lux_campaign_2)+"</a></span><span class=\"lastSpan\"><a href=\"?lux_delete="+$.trim(value.id)+"\" class=\"yahoo_lux_delete\"><i class=\"fa fa-times fa-2x\"></i></a></span></li>";
                });
                html+="</ul><div class=\"lastRow\"><span><label for=\"yahoo_lux_input1\">Account Name</label><input required=\"required\" id=\"yahoo_lux_input1\" class=\"form-control\"></input></span><span><label for=\"yahoo_lux_input2\">Account ID</label><input required=\"required\" id=\"yahoo_lux_input2\" class=\"form-control\"></input></span><span><label for=\"yahoo_lux_input3\">Filter</label><input id=\"yahoo_lux_input3\" class=\"pull-left form-control\"></input></span><span><label for=\"yahoo_lux_input4\">Campaign ID</label><input id=\"yahoo_lux_input4\" class=\"pull-left form-control\"></input></span><span><label for=\"yahoo_lux_input5\">Campaign ID</label><input id=\"yahoo_lux_input5\" class=\"pull-left form-control\"></input></span><span class=\"lastSpan\"><button class=\"btn btn-primary\" id=\"yahoo_lux_submit\">Submit</button></span></div>";
                $("#luxTableYahoo").append(html);
            }
        })
    });

}); 