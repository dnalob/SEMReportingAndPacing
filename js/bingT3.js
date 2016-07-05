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


// POPULATE CAMPIAGNS


	$(function ()     
	  	{
	  	$.ajax({                                      
			url: 'includes/T3_reg_accounts_bing.php',                  //the script to call to get data          
			data: "",                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
			dataType: 'json',                //data format      
			success: function(data)          //on recieve of reply
	      	{
	        	var html = "<ul class=\"scrollable-menu\" role=\"menu\">";
	        	$.each(data, function(index,value) {
				    if (value.formula != 1) {
		              var checkedBox = "";
		            }
		            else {
		              var checkedBox = " checked";
		            }
	            	html+="<li class=\"campaign-event-bing\" data-id=\""+value.id+"\" id=\"record-"+$.trim(value.name)+"\"><span class=\"text-left\"><a href='#' class=\"ajax-edit-bing ajax-edit-name\">"+$.trim(value.name)+"</a></span><span><a href='#' class=\"ajax-edit-bing ajax-edit-code\">"+$.trim(value.code)+"</a></span><span class=\"text-left\"><a href='#' class=\"ajax-edit-bing ajax-edit-filter\">"+$.trim(value.filter)+"</a></span><span><input id=\"formulaCheckBing\" type=\"checkbox\" "+checkedBox+"></span><span class=\"lastSpan\"><a href=\"?reg_delete="+$.trim(value.id)+"\" class=\"T3_bing_delete\"><i class=\"fa fa-times fa-2x\"></i></a></span></li>";
	        	});
	        	html+="</ul><div class=\"lastRow\"><span><label for=\"input1\">Account Name</label><input required=\"required\" id=\"input1\" class=\"T3Binginput1 form-control\"></input></span><span><label for=\"input2\">Account ID</label><input required=\"required\" id=\"input2\" class=\"T3Binginput2 form-control\"></input></span><span><label for=\"input3\">Filter</label><input id=\"input3\" class=\"T3Binginput3 pull-left form-control\"></input></span><span class=\"checkInput\"><label><input class=\"T3Binginput4\" type=\"checkbox\" value=\"1\" name=\"formula\">&fpartint;</label></span><span class=\"lastSpan\"><button class=\"btn btn-primary\" id=\"T3Bing_reg_submit\">Submit</button></span></div>";
	        	$("#regT3TableBing").append(html);
			}
	    })
	});



/////////////////////////////////////////////////////////

//Formula checkbox

/////////////////////////////////////////////////////////



	$(document.body).on('click', '#formulaCheckBing' ,function(e) {
	  	e.preventDefault()
	    var id = $(this).closest('li').attr('data-id');
	    if (this.checked){
	        $.ajax({
	            cache: false,
	            type: "POST",
	            url: "index.php",
	            data: "regT3BingFormula=" + 1 + "&regT3BingFormulaId=" + id,
	            dataType: "text",
	            success: function (data) {
	                console.log('success',data);
	            },
	            error: function (xhr, ajaxOptions, thrownError) {
	                console.log('error',thrownError);
	            }
	        });
	    }
	    else {
	      	$.ajax({
	            cache: false,
	            type: "POST",
	            url: "index.php",
	            data: "regT3BingFormula=" + 0 + "&regT3BingFormulaId=" + id,
	            dataType: "text",
	            success: function (data) {
	                console.log('success',data);
	            },
	            error: function (xhr, ajaxOptions, thrownError) {
	                console.log('error',thrownError);
	            }
	        });
	    }
	});

	$(document.body).on('click', '#formulaCheckBing' ,function(e) {
  		$('#regT3TableBing ul').remove();
		$('#regT3TableBing div').remove();
		$.ajax({
			url: 'includes/T3_reg_accounts_bing.php',                  //the script to call to get data          
			data: "",                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
			dataType: 'json',                //data format      
			success: function(data)          //on recieve of reply
			{

        	var html = "<ul class=\"scrollable-menu\" role=\"menu\">";

        	$.each(data, function(index,value) {
		    	if (value.formula != 1) {
            		var checkedBox = "";
            	}
            	else {
            		var checkedBox = " checked";
            	}
		    	html+="<li class=\"campaign-event-bing\" data-id=\""+value.id+"\" id=\"record-"+$.trim(value.name)+"\"><span class=\"text-left\"><a href='#' class=\"ajax-edit-bing ajax-edit-name\">"+$.trim(value.name)+"</a></span><span><a href='#' class=\"ajax-edit-bing ajax-edit-code\">"+$.trim(value.code)+"</a></span><span class=\"text-left\"><a href='#' class=\"ajax-edit-bing ajax-edit-filter\">"+$.trim(value.filter)+"</a></span><span><input id=\"formulaCheckBing\" type=\"checkbox\" "+checkedBox+"></span><span class=\"lastSpan\"><a href=\"?reg_delete="+$.trim(value.id)+"\" class=\"T3_bing_delete\"><i class=\"fa fa-times fa-2x\"></i></a></span></li>";
        	});
        	html+="</ul><div class=\"lastRow\"><span><label for=\"input1\">Account Name</label><input required=\"required\" id=\"input1\" class=\"T3Binginput1 form-control\"></input></span><span><label for=\"input2\">Account ID</label><input required=\"required\" id=\"input2\" class=\"T3Binginput2 form-control\"></input></span><span><label for=\"input3\">Filter</label><input id=\"input3\" class=\"T3Binginput3 pull-left form-control\"></input></span><span class=\"checkInput\"><label><input class=\"T3Binginput4\" type=\"checkbox\" value=\"1\" name=\"formula\">&fpartint;</label></span><span class=\"lastSpan\"><button class=\"btn btn-primary\" id=\"T3Bing_reg_submit\">Submit</button></span></div>";
        	$("#regT3TableBing").append(html);

      		}
    	});
  	})



//CLICK ON LIST ITEM HANDLER FOR GUI ACCOUNT LIST



	$(document.body).on('click', 'li.campaign-event-bing' ,function(e) {
		e.preventDefault()

		var accountID = $(this).children("span:nth-child(2)").text();
		var filter = $(this).children("span:nth-child(3)").text();
		var name = $(this).children("span:first-child").text();

		$(this).siblings().css('background-color', '');
		$(this).css('background-color', '#ededed');

		$.ajax({                                      
			url: 'includes/T3_reg_campaigns_bing.php',                  //the script to call to get data          
			data: "",                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
			dataType: 'json',                //data format      
			success: function(data)
		    {
		        $('#T3Bingcampaignlist').empty();
		        var i = 0;
		        $.each(data, function(index,value) {
		           	if((accountID === value.code) && (filter === value.filter)) {

						var campaignList = "<h4 class=\"text-center\"><u>"+name+"</u></h4><br/><br/><ul>";

						if (value.campaign1 != "") {
							campaignList += "<li class=\""+value.code+"_C1\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign1+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign1)+"\" class=\"T3Bing_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
						}
						if (value.campaign2 != "") {
							campaignList += "<li class=\""+value.code+"_C2\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign2+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign2)+"\" class=\"T3Bing_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
						}
						if (value.campaign3 != "") {
							campaignList += "<li class=\""+value.code+"_C3\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign3+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign3)+"\" class=\"T3Bing_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
						}
						if (value.campaign4 != "") {
							campaignList += "<li class=\""+value.code+"_C4\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign4+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign4)+"\" class=\"T3Bing_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
						}
						if (value.campaign5 != "") {
							campaignList += "<li class=\""+value.code+"_C5\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign5+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign5)+"\" class=\"T3Bing_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
						}
						if (value.campaign6 != "") {
							campaignList += "<li class=\""+value.code+"_C6\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign6+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign6)+"\" class=\"T3Bing_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
						}
						if (value.campaign7 != "") {
							campaignList += "<li class=\""+value.code+"_C7\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign7+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign7)+"\" class=\"T3Bing_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
						}
						if (value.campaign8 != "") { 
						  campaignList += "<li class=\""+value.code+"_C8\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign8+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign8)+"\" class=\"T3Bing_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
						}
						if (value.campaign9 != "") {
							campaignList += "<li class=\""+value.code+"_C9\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign9+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign9)+"\" class=\"T3Bing_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
						}
						if (value.campaign10 != "") {
							campaignList += "<li class=\""+value.code+"_C10\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign10+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign10)+"\" class=\"T3Bing_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
						}

						campaignList+="</ul><br/><br/><div class=\"lastCampaignRow\"><span class=\""+name+"\"><label for=\"campaignInput1\">Campaign Name</label><input required=\"required\" id=\"campaignInput1\" class=\"T3BingCampaignInput1 form-control\"></input></span><span id=\"" + filter +"\" class=\"lastCampaignSpan\"><button class=\"btn btn-primary\" id=\"T3Bing_campaign_submit\" data-submit=\""+value.code+"\">Submit</button></span></div>";
						$("#T3Bingcampaignlist").append(campaignList); 

						i++;
		        	}
		    	});
		    
		    	if (i == 0) {
	        		var createCampaignList = "<h4 class=\"text-center\"><u>"+name+"</u></h4><br/><br/><div class=\"lastCampaignRow\"><span class=\""+name+"\" id=\"record-"+accountID+"\"><a href=\"?create_campaigns="+accountID+"\" class=\"T3Bing_add_campaigns btn btn-primary center-block\" id=" + filter +"><i class=\"fa fa-cogs fa-2x pull-left\"></i>Add Campaigns</a></span></div>";
	        		$("#T3Bingcampaignlist").append(createCampaignList); 
		    	}       
			}
		});
	});



//DELETE LIST ITEM



	$(document.body).on('click', 'a.T3_bing_delete' ,function(e) {
		e.preventDefault()

	    var id = $(this).attr('href').replace('?reg_delete=','');
	    var parent = $(this).closest('li');
        $.ajax({
            type: 'get',
            url: 'index.php',
            data: 'ajax=1&bing_T3_reg_delete=' + id,
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

	$(document.body).on('click', 'a.T3Bing_campaign_delete' ,function(e) {
		e.preventDefault()
		var parent = $(this).closest('li');
			         
        $.ajax({
            type: 'get',
            url: 'index.php',
            data: 'ajax=1&bing_T3_campaign_delete=' + parent.attr('class') + '&bing_T3_campaign_delete_2=' + parent.attr('id').replace('record-',''),
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



/////////////////////////////////////////////////////////

//CREATE CAMPAIGNS BUTTON

/////////////////////////////////////////////////////////



	$(document.body).on('click', 'a.T3Bing_add_campaigns' ,function(e) {
		e.preventDefault()
		var parent = $(this).closest('span');
		var filter = $(this).attr('id');
			         
		$.ajax({
            cache: false,
            type: "POST",
            url: "index.php",

            data: 'bing_T3_add_campaigns=' + parent.attr('id').replace('record-','') + '&filter=' + filter,
            success: function (data) {
                console.log('success',data);
               

            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log('error',thrownError);
            }
        });
    });

	$(document.body).on('click', 'a.T3Bing_add_campaigns' ,function(e) {
		e.preventDefault()
		var accountID = $(this).attr("href").replace('?create_campaigns=','');
		var name = $('.lastCampaignRow').children("span:first-child").attr('class');
		var filter = $(this).attr('id');
		$.ajax({                                      
			url: 'includes/T3_reg_campaigns_bing.php',                  //the script to call to get data          
			data: "",                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
			dataType: 'json',                //data format      
			success: function(data)
			{
				$('#T3Bingcampaignlist').empty();
				var thisForm = "<h4 class=\"text-center\"><u>"+name+"</u></h4><br/><br/><div class=\"lastCampaignRow\"><span class=\""+name+"\"><label for=\"campaignInput1\">Campaign Name</label><input required=\"required\" id=\"campaignInput1\" class=\"T3BingCampaignInput1 form-control\"></input></span><span id=\"" + filter +"\" class=\"lastCampaignSpan\"><button class=\"btn btn-primary\" id=\"T3Bing_campaign_submit\" data-submit=\""+accountID+"\">Submit</button></span></div>";
				$("#T3Bingcampaignlist").append(thisForm); 
			}
		});
	});



//INSERT LIST ITEM



	$(document.body).on('click', '#T3Bing_reg_submit' ,function() {
		var content1 = $('.T3Binginput1').val();
		var content2 = $('.T3Binginput2').val();
		var content3 = $('.T3Binginput3').val();
		var content4 = $('input.T3Binginput4:checked').val();
		
		if (content4 != "1") {
			var content4 = "0";
		}

		if (alphanumeric(content1) == true) {
			if (alphanumeric(content2) == true) {
				if (alphanumeric(content3) == true) {
				    $.ajax({
			            cache: false,
			            type: "POST",
			            url: "index.php",
			            data: "regT3BingContent1=" + content1 + "&regT3BingContent2=" + content2 + "&regT3BingContent3=" + content3 + "&regT3BingContent4=" + content4,
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

	$(document.body).on('click', '#T3Bing_reg_submit' ,function() {
		$('#regT3TableBing ul').remove();
		$('#regT3TableBing div').remove();
		$.ajax({
			url: 'includes/T3_reg_accounts_bing.php',                  //the script to call to get data          
			data: "",                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
			dataType: 'json',                //data format      
			success: function(data)          //on recieve of reply
			{
		        var html = "<ul class=\"scrollable-menu\" role=\"menu\">";
		        $.each(data, function(index,value) {

					if (value.formula != 1) {
			            var checkedBox = "";
			        }
			        else {
			            var checkedBox = " checked";
			        }

		    		html+="<li class=\"campaign-event-bing\" data-id=\""+value.id+"\" id=\"record-"+$.trim(value.name)+"\"><span class=\"text-left\"><a href='#' class=\"ajax-edit-bing ajax-edit-name\">"+$.trim(value.name)+"</a></span><span><a href='#' class=\"ajax-edit-bing ajax-edit-code\">"+$.trim(value.code)+"</a></span><span class=\"text-left\"><a href='#' class=\"ajax-edit-bing ajax-edit-filter\">"+$.trim(value.filter)+"</a></span><span><input id=\"formulaCheckBing\" type=\"checkbox\" "+checkedBox+"></span><span class=\"lastSpan\"><a href=\"?reg_delete="+$.trim(value.id)+"\" class=\"T3_bing_delete\"><i class=\"fa fa-times fa-2x\"></i></a></span></li>";
		    	});

		        html+="</ul><div class=\"lastRow\"><span><label for=\"input1\">Account Name</label><input required=\"required\" id=\"input1\" class=\"T3Binginput1 form-control\"></input></span><span><label for=\"input2\">Account ID</label><input required=\"required\" id=\"input2\" class=\"T3Binginput2 form-control\"></input></span><span><label for=\"input3\">Filter</label><input id=\"input3\" class=\"T3Binginput3 pull-left form-control\"></input></span><span class=\"checkInput\"><label><input class=\"T3Binginput4\" type=\"checkbox\" value=\"1\" name=\"formula\">&fpartint;</label></span><span class=\"lastSpan\"><button class=\"btn btn-primary\" id=\"T3Bing_reg_submit\">Submit</button></span></div>";
		        $("#regT3TableBing").append(html);
			}
		})  
	});



//INSERT CAMPAIGN



	$(document.body).on('click', '#T3Bing_campaign_submit' ,function() {
		var content1 = $('.T3BingCampaignInput1').val();
		var content2 = $(this).attr("data-submit");
		var content3 = $(this).parent().attr('id');

		$.ajaxSetup({async: false});
		$.ajax({
            cache: false,
            type: "POST",
            url: "index.php",
            data: "regT3BingCampaignContent1=" + content1 + "&regT3BingCampaignContent2=" + content2 + "&regT3BingCampaignContent3=" + content3,
            dataType: "text",
            success: function (data) {
                console.log('success',data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log('error',thrownError);
            }
    	});
	});

	$(document.body).on('click', '#T3Bing_campaign_submit' ,function() {
        var accountID = $(this).attr("data-submit");
        var name = $('.lastCampaignRow').children("span:first-child").attr('class');
        var filter = $(this).parent().attr('id');

		$('#T3Bingcampaignlist').empty();

		$.ajaxSetup({async: false});
		$.ajax({                                      
			url: 'includes/T3_reg_campaigns_bing.php',                  //the script to call to get data          
			data: "",                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
			dataType: 'json',                //data format      
			success: function(data)          //on recieve of reply
			{
				var i = 0;
				
				$.each(data, function(index,value) {

					if((accountID === value.code) && (filter === value.filter)) {

						var campaignList = "<h4 class=\"text-center\"><u>"+name+"</u></h4><br/><br/><ul>";

						if (value.campaign1 != "") {
						    campaignList += "<li class=\""+value.code+"_C1\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign1+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign1)+"\" class=\"T3Bing_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
						}
						if (value.campaign2 != "") {					  
						    campaignList += "<li class=\""+value.code+"_C2\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign2+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign2)+"\" class=\"T3Bing_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
						}
						if (value.campaign3 != "") {					  
						    campaignList += "<li class=\""+value.code+"_C3\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign3+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign3)+"\" class=\"T3Bing_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
						}
						if (value.campaign4 != "") {					 
						    campaignList += "<li class=\""+value.code+"_C4\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign4+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign4)+"\" class=\"T3Bing_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
						}
						if (value.campaign5 != "") {					  
						    campaignList += "<li class=\""+value.code+"_C5\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign5+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign5)+"\" class=\"T3BingBing_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
						}
						if (value.campaign6 != "") {					 
						    campaignList += "<li class=\""+value.code+"_C6\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign6+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign6)+"\" class=\"T3Bing_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
						}
						if (value.campaign7 != "") {
						    campaignList += "<li class=\""+value.code+"_C7\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign7+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign7)+"\" class=\"T3Bing_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
						}
						if (value.campaign8 != "") {					  
						    campaignList += "<li class=\""+value.code+"_C8\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign8+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign8)+"\" class=\"T3Bing_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
						}
						if (value.campaign9 != "") {					  
						    campaignList += "<li class=\""+value.code+"_C9\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign9+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign9)+"\" class=\"T3Bing_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
						}
						if (value.campaign10 != "") {					  
						    campaignList += "<li class=\""+value.code+"_C10\" id=\"record-"+$.trim(value.filter)+"\"><span>"+value.campaign10+"</span><span><a href=\"?reg_delete="+$.trim(value.campaign10)+"\" class=\"T3Bing_campaign_delete\"><i class=\"fa fa-times fa-lg\"></i></a></span></li>";
						}

						campaignList+="</ul><br/><br/><div class=\"lastCampaignRow\"><span class=\""+name+"\"><label for=\"campaignInput1\">Campaign Name</label><input required=\"required\" id=\"campaignInput1\" class=\"T3BingCampaignInput1 form-control\"></input></span><span id=\"" + filter +"\" class=\"lastCampaignSpan\"><button class=\"btn btn-primary\" id=\"T3Bing_campaign_submit\" data-submit=\""+value.code+"\">Submit</button></span></div>";
						$("#T3Bingcampaignlist").append(campaignList);

						i++;
					}
				});

		        if (i == 0) {
		          var createCampaignList = "<h4 class=\"text-center\"><u>"+name+"</u></h4><br/><br/><div class=\"lastCampaignRow\"><span class=\""+name+"\" id=\"record-"+accountID+"\"><a href=\"?create_campaigns="+accountID+"\" class=\"T3Bing_add_campaigns btn btn-primary center-block\" id=" + filter +"><i class=\"fa fa-cogs fa-2x pull-left\"></i>Add Campaigns</a></span></div>";
		          $("#T3Bingcampaignlist").append(createCampaignList); 
		        }
			}
		});
	});

});  
