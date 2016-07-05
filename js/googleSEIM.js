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



/////////////////////////////////////////////////////////

//POPULATE TABLES

/////////////////////////////////////////////////////////



    $(function ()     
        {
        $.ajax({                                      
            url: 'includes/SEIM_reg_accounts_google.php',                  //the script to call to get data          
            data: "",                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
            dataType: 'json',                //data format      
            success: function(data)          //on recieve of reply
            {
            var html = "<ul class=\"scrollable-menu\" role=\"menu\">";
            $.each(data, function(index,value) {
                html+="<li class=\"campaign-event\" data-id=\""+value.id+"\" id=\"record-"+$.trim(value.name)+"\"><span class=\"text-left\"><a href='#' class=\"ajax-edit-seim ajax-edit-name\">"+$.trim(value.name)+"</a></span><span><a href='#' class=\"ajax-edit-seim ajax-edit-code\">"+$.trim(value.code)+"</a></span><span class=\"text-left\"><a href='#' class=\"ajax-edit-seim ajax-edit-filter\">"+$.trim(value.filter)+"</a></span><span class=\"lastSpan\"><a href=\"?reg_delete="+$.trim(value.id)+"\" class=\"SEIM_reg_delete\"><i class=\"fa fa-times fa-2x\"></i></a></span></li>";
            });
            html+="</ul><div class=\"lastRow\"><span><label for=\"input1\">Account Name</label><input required=\"required\" id=\"input1\" class=\"SEIMinput1 form-control\"></input></span><span><label for=\"input2\">Account ID</label><input required=\"required\" id=\"input2\" class=\"SEIMinput2 form-control\"></input></span><span><label for=\"input3\">Filter</label><input id=\"input3\" class=\"SEIMinput3 pull-left form-control\"></input></span><span class=\"lastSpan\"><button class=\"btn btn-primary\" id=\"SEIM_reg_submit\">Submit</button></span></div>";
                $("#SEIMTableGoogle").append(html);
            }
        })
    });



/////////////////////////////////////////////////////////

//POPULATE CAMPAIGNS
  
/////////////////////////////////////////////////////////



    $(document.body).on('click', 'li.campaign-event' ,function(e) {
        e.preventDefault()
        var accountID = $(this).children("span:nth-child(2)").text();
        var filter = $(this).children("span:nth-child(3)").text();
        var thisName = $(this).children("span:first-child").text();

        $(this).siblings().css('background-color', '');
        $(this).css('background-color', '#ededed');

        $.ajax({                                      
            url: 'includes/SEIM_reg_campaigns_google.php',                  //the script to call to get data          
            data: "",                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
            dataType: 'json',                //data format      
            success: function(data)
            {
                $('#SEIMGooglecampaignlist').empty();
                var i = 0;
                $.each(data, function(index,value) {

                    if(thisName === value.name) {

                        var campaignList = "<h4 class=\"text-center\"><u>"+thisName+"</u></h4><br/><br/><ul>";

                        if (value.campaign1 != "") {
                          campaignList += "<li class=\""+value.name+"_C1\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign1+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign1)+"\" class=\"SEIM_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
                        }
                        if (value.campaign2 != "") {
                          campaignList += "<li class=\""+value.name+"_C2\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign2+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign2)+"\" class=\"SEIM_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
                        }
                        if (value.campaign3 != "") {
                          campaignList += "<li class=\""+value.name+"_C3\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign3+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign3)+"\" class=\"SEIM_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
                        }
                        if (value.campaign4 != "") {
                          campaignList += "<li class=\""+value.name+"_C4\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign4+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign4)+"\" class=\"SEIM_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
                        }
                        if (value.campaign5 != "") {
                          campaignList += "<li class=\""+value.name+"_C5\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign5+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign5)+"\" class=\"SEIM_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
                        }
                        if (value.campaign6 != "") {
                          campaignList += "<li class=\""+value.name+"_C6\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign6+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign6)+"\" class=\"SEIM_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
                        }
                        if (value.campaign7 != "") {
                          campaignList += "<li class=\""+value.name+"_C7\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign7+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign7)+"\" class=\"SEIM_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
                        }
                        if (value.campaign8 != "") {
                          campaignList += "<li class=\""+value.name+"_C8\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign8+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign8)+"\" class=\"SEIM_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
                        }
                        if (value.campaign9 != "") {
                          campaignList += "<li class=\""+value.name+"_C9\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign9+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign9)+"\" class=\"SEIM_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
                        }
                        if (value.campaign10 != "") {
                          campaignList += "<li class=\""+value.name+"_C10\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign10+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign10)+"\" class=\"SEIM_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
                        }

                        campaignList+="</ul><br/><br/><div class=\"lastCampaignRow\"><span class=\""+name+"\"><label for=\"campaignInput1\">Campaign Name</label><input required=\"required\" id=\"campaignInput1\" class=\"SEIMCampaignInput1 form-control\"></input></span><span id=\"" + filter +"\" class=\"lastCampaignSpan\"><button class=\"btn btn-primary\" id=\"SEIM_campaign_submit\" data-submit=\""+value.name+"\">Submit</button></span></div>";
                        $("#SEIMGooglecampaignlist").append(campaignList); 
                
                        i++;
                    }
                });

                if (i == 0) {
                    var createCampaignList = "<h4 class=\"text-center\"><u>"+thisName+"</u></h4><br/><br/><div class=\"lastCampaignRow\"><span class=\""+thisName+"\" id=\"record-"+accountID+"\"><a href=\"?create_campaigns="+accountID+"\" class=\"SEIM_add_campaigns btn btn-primary center-block\" id=" + filter +"><i class=\"fa fa-cogs fa-2x pull-left\"></i>Add Campaigns</a></span></div>";
                    $("#SEIMGooglecampaignlist").append(createCampaignList); 
                } 
            }
        });
    });



/////////////////////////////////////////////////////////

//DELETE TABLE ITEMS

/////////////////////////////////////////////////////////



    $(document.body).on('click', 'a.SEIM_reg_delete' ,function(e) {
        e.preventDefault()
        var id = $(this).attr('href').replace('?reg_delete=','');
        var parent = $(this).closest('li');
             
        $.ajax({
            type: 'get',
            url: 'index.php',
            data: 'ajax=1&google_SEIM_reg_delete=' + id,
            beforeSend: function() {
                parent.animate({'backgroundColor':'#fb6c6c'},300);
            },
            success: function(data) {
                parent.fadeOut(400,function() {
                    parent.remove();
                    console.log(data);
                });
            }
        });
    });



//////////GOOGLE SEIM CAMPAIGNS



    $(document.body).on('click', 'a.SEIM_campaign_delete' ,function(e) {
        e.preventDefault()
        var parent = $(this).closest('li');
             
        $.ajax({
            type: 'get',
            url: 'index.php',

            data: 'ajax=1&google_SEIM_campaign_delete=' + parent.attr('class'),
            beforeSend: function() {
                parent.animate({'backgroundColor':'#fb6c6c'},300);
            },
            success: function(data) {
                parent.fadeOut(400,function() {
                    parent.remove();
                });
                console.log(data);
            }
        });
    });



/////////////////////////////////////////////////////////

//CREATE CAMPAIGNS BUTTON

/////////////////////////////////////////////////////////



    $(document.body).on('click', 'a.SEIM_add_campaigns' ,function(e) {
        e.preventDefault()
        var parent = $(this).closest('span');
        var filter = $(this).attr('id');
        var name = $(this).closest('span').attr('class');

        $.ajax({
            cache: false,
            type: "POST",
            url: "index.php",
            data: 'google_SEIM_add_campaigns=' + parent.attr('id').replace('record-','') + '&filter=' + filter + '&name=' + name,
            success: function (data) {
                console.log('success',data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log('error',thrownError);
            }
        });
    });



    $(document.body).on('click', 'a.SEIM_add_campaigns' ,function(e) {
        e.preventDefault()
        var parent = $(this).closest('span');
        var name = $(this).closest('span').attr('class');
        var filter = $(this).attr('id');

        $.ajax({                                      
            url: 'includes/SEIM_reg_campaigns_google.php',                  //the script to call to get data          
            data: "",                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
            dataType: 'json',                //data format      
            success: function(data)
            {
                $('#SEIMGooglecampaignlist').empty();
                var thisForm = "<h4 class=\"text-center\"><u>"+name+"</u></h4><br/><br/><div class=\"lastCampaignRow\"><span class=\""+parent.attr('id').replace('record-','')+"\"><label for=\"campaignInput1\">Campaign Name</label><input required=\"required\" id=\"campaignInput1\" class=\"SEIMCampaignInput1 form-control\"></input></span><span id=\""+filter+"\" class=\"lastCampaignSpan\"><button class=\"btn btn-primary\" id=\"SEIM_campaign_submit\" data-submit=\""+name+"\">Submit</button></span></div>";
                $("#SEIMGooglecampaignlist").append(thisForm); 
            }
        });
    });



/////////////////////////////////////////////////////////

//INSERT TABLE ITEMS

/////////////////////////////////////////////////////////



    $(document.body).on('click', '#SEIM_reg_submit' ,function() {
        var content1 = $('.SEIMinput1').val();
        var content2 = $('.SEIMinput2').val();
        var content3 = $('.SEIMinput3').val();

        if (alphanumeric(content1) == true) {
            if (alphanumeric(content2) == true) {
                if (alphanumeric(content3) == true) {
                    $.ajax({
                        cache: false,
                        type: "POST",
                        url: "index.php",
                        data: "regSEIMGoogleContent1=" + content1 + "&regSEIMGoogleContent2=" + content2 + "&regSEIMGoogleContent3=" + content3,
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

    $(document.body).on('click', '#SEIM_reg_submit' ,function() {
        $('#SEIMTableGoogle ul').remove();
        $('#SEIMTableGoogle div').remove();

        $.ajax({
            url: 'includes/SEIM_reg_accounts_google.php',                  //the script to call to get data          
            data: "",                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
            dataType: 'json',                //data format      
            success: function(data)          //on recieve of reply
            {
                var html = "<ul class=\"scrollable-menu\" role=\"menu\">";
                $.each(data, function(index,value) {
                    html+="<li class=\"campaign-event\" data-id=\""+value.id+"\" id=\"record-"+$.trim(value.name)+"\"><span class=\"text-left\"><a href='#' class=\"ajax-edit ajax-edit-name\">"+$.trim(value.name)+"</a></span><span><a href='#' class=\"ajax-edit ajax-edit-code\">"+$.trim(value.code)+"</a></span><span class=\"text-left\"><a href='#' class=\"ajax-edit ajax-edit-filter\">"+$.trim(value.filter)+"</a></span><span class=\"lastSpan\"><a href=\"?reg_delete="+$.trim(value.id)+"\" class=\"SEIM_reg_delete\"><i class=\"fa fa-times fa-2x\"></i></a></span></li>";
                });
                html+="</ul><div class=\"lastRow\"><span><label for=\"input1\">Account Name</label><input required=\"required\" id=\"input1\" class=\"SEIMinput1 form-control\"></input></span><span><label for=\"input2\">Account ID</label><input required=\"required\" id=\"input2\" class=\"SEIMinput2 form-control\"></input></span><span><label for=\"input3\">Filter</label><input id=\"input3\" class=\"SEIMinput3 pull-left form-control\"></input></span><span class=\"lastSpan\"><button class=\"btn btn-primary\" id=\"SEIM_reg_submit\">Submit</button></span></div>";
                $("#SEIMTableGoogle").append(html);
            }
        })  
    });



////////////GOOGLE SEIM CAMPAIGNS



    $(document.body).on('click', '#SEIM_campaign_submit' ,function() {
        var content1 = $('.SEIMCampaignInput1').val();
        var content2 = $(this).attr("data-submit");
        var content3 = $(this).parent().attr('id');

        $.ajaxSetup({async: false});
        $.ajax({
            cache: false,
            type: "POST",
            url: "index.php",
            data: "regSEIMGoogleCampaignContent1=" + content1 + "&regSEIMGoogleCampaignContent2=" + content2 + "&regSEIMGoogleCampaignContent3=" + content3,
            dataType: "text",
            success: function (data) {
                console.log('success',data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log('error',thrownError);
            }
        });
    });

    $(document.body).on('click', '#SEIM_campaign_submit' ,function() {
        var accountID = $(this).attr("data-submit");
        var thisName = $('.lastCampaignRow').children("span:first-child").attr('class');
        var filter = $(this).parent().attr('id');

        $('#SEIMGooglecampaignlist').empty();

        $.ajaxSetup({async: false});
        $.ajax({                                      
            url: 'includes/SEIM_reg_campaigns_google.php',                  //the script to call to get data          
            data: "",                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
            dataType: 'json',                //data format      
            success: function(data)          //on recieve of reply
            {
                $('#SEIMGooglecampaignlist').empty();
                var i = 0;

                $.each(data, function(index,value) {

                    if(thisName === value.name) {

                        var campaignList = "<h4 class=\"text-center\"><u>"+thisName+"</u></h4><br/><br/><ul>";

                        if (value.campaign1 != "") {
                          campaignList += "<li class=\""+value.name+"_C1\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign1+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign1)+"\" class=\"SEIM_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
                        }
                        if (value.campaign2 != "") {
                          campaignList += "<li class=\""+value.name+"_C2\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign2+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign2)+"\" class=\"SEIM_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
                        }
                        if (value.campaign3 != "") {
                          campaignList += "<li class=\""+value.name+"_C3\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign3+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign3)+"\" class=\"SEIM_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
                        }
                        if (value.campaign4 != "") {
                          campaignList += "<li class=\""+value.name+"_C4\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign4+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign4)+"\" class=\"SEIM_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
                        }
                        if (value.campaign5 != "") {
                          campaignList += "<li class=\""+value.name+"_C5\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign5+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign5)+"\" class=\"SEIM_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
                        }
                        if (value.campaign6 != "") {
                          campaignList += "<li class=\""+value.name+"_C6\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign6+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign6)+"\" class=\"SEIM_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
                        }
                        if (value.campaign7 != "") {
                          campaignList += "<li class=\""+value.name+"_C7\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign7+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign7)+"\" class=\"SEIM_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
                        }
                        if (value.campaign8 != "") {
                          campaignList += "<li class=\""+value.name+"_C8\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign8+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign8)+"\" class=\"SEIM_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
                        }
                        if (value.campaign9 != "") {
                          campaignList += "<li class=\""+value.name+"_C9\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign9+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign9)+"\" class=\"SEIM_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
                        }
                        if (value.campaign10 != "") {
                          campaignList += "<li class=\""+value.name+"_C10\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign10+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign10)+"\" class=\"SEIM_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
                        }

                        campaignList+="</ul><br/><br/><div class=\"lastCampaignRow\"><span class=\""+name+"\"><label for=\"campaignInput1\">Campaign Name</label><input required=\"required\" id=\"campaignInput1\" class=\"SEIMCampaignInput1 form-control\"></input></span><span id=\"" + filter +"\" class=\"lastCampaignSpan\"><button class=\"btn btn-primary\" id=\"SEIM_campaign_submit\" data-submit=\""+value.name+"\">Submit</button></span></div>";
                        $("#SEIMGooglecampaignlist").append(campaignList); 
                        i++;

                    }
                });
                
                if (i == 0) {
                    var createCampaignList = "<h4 class=\"text-center\"><u>"+thisName+"</u></h4><br/><br/><div class=\"lastCampaignRow\"><span class=\""+thisName+"\" id=\"record-"+accountID+"\"><a href=\"?create_campaigns="+accountID+"\" class=\"SEIM_add_campaigns btn btn-primary center-block\" id=" + filter +"><i class=\"fa fa-cogs fa-2x pull-left\"></i>Add Campaigns</a></span></div>";
                    $("#SEIMGooglecampaignlist").append(createCampaignList); 
                } 
            }
        });
    });

});  