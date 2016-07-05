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



// ACTIVATE EDITIBLE LIBRARY ON LINKS 



    $.fn.editable.defaults.send = "always";

    $('#SEIMTableGoogle').editable({
      selector: 'a.ajax-edit-seim'
    });

    $('#regT3TableBing').editable({
      selector: 'a.ajax-edit-bing'
    });

    $('#regT3TableGoogle').editable({
      selector: 'a.ajax-edit'
    });

    $('#regTableYahoo').editable({
      selector: 'a.ajax-edit-yahoo'
    });

    $('#luxTableYahoo').editable({
      selector: 'a.ajax-edit-yahoo-lux'
    });

    $('#regT2TableBing').editable({
      selector: 'a.ajax-edit-bing-t2'
    });

    $('#luxT2TableBing').editable({
      selector: 'a.ajax-edit-bing-t2-lux'
    });

    $('#regT2TableGoogle').editable({
      selector: 'a.ajax-edit-google-t2'
    });

    $('#luxT2TableGoogle').editable({
      selector: 'a.ajax-edit-google-t2-lux'
    });



//ENTER FOR FORM SUBMIT ON SIGN IN AND REGISTER PAGES


    
    $(function() {
        $("#login-submit").addClass("hidden").attr('onclick', 'formhash(this.form, this.form.password);');
        $("#register-submit").addClass("hidden").attr('onclick', 'return regformhash(this.form, this.form.username, this.form.email, this.form.password, this.form.confirmpwd);');
        $("#rec-submit").addClass("hidden").attr('onclick', 'return recformhash(this.form, this.form.email);');
        $("#new-pass-submit").addClass("hidden").attr('onclick', 'return passformhash(this.form, this.form.token, this.form.email, this.form.password, this.form.confirmpwd);');  
    });



//EDITIBLE GOOGLE T3 + SEIM



    $(document.body).on('click', '.editable-submit' ,function(e) {
        e.preventDefault()
        var id = $(this).closest('.campaign-event').attr('data-id');
        var content1 = $(this).parent().prev().children('input').val();

        if ($(this).closest('.campaign-event').find('a.ajax-edit-name').attr('class') == "ajax-edit ajax-edit-name editable editable-click editable-open") {
            var col = 'Name';

            if (alphanumeric(content1) == true) {
                $.ajax({
                    cache: false,
                    type: "POST",                                        
                    url: 'index.php',                  //the script to call to get data          
                    data: 'ajax=1&google_edit_id=' + id + "&google_edit_col=" + col + "&google_edit_content=" + content1,                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"     
                    success: function (data) {
                              console.log('success',data);
                          },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log('error',thrownError);
                    }
                });
            $(this).closest('.text-left').children('.ajax-edit-name').text(content1);
            $(this).closest('div.editable-container').remove();
            }
        }
        else if ($(this).closest('.campaign-event').find('a.ajax-edit-code').attr('class') == "ajax-edit ajax-edit-code editable editable-click editable-open") {
            var col = 'Account ID';

            if (alphanumeric(content1) == true) {
                $.ajax({
                    cache: false,
                    type: "POST",                                        
                    url: 'index.php',                  //the script to call to get data          
                    data: 'ajax=1&google_edit_id=' + id + "&google_edit_col=" + col + "&google_edit_content=" + content1,                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"     
                    success: function (data) {
                              console.log('success',data);
                          },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log('error',thrownError);
                    }
                });
            $(this).closest('span').children('.ajax-edit-code').text(content1);
            $(this).closest('div.editable-container').remove();
            } 
        }
        else if ($(this).closest('.campaign-event').find('a.ajax-edit-filter').attr('class') == "ajax-edit ajax-edit-filter editable editable-click editable-open") {
            var col = 'Filter';

            if (alphanumeric(content1) == true) {
                $.ajax({
                    cache: false,
                    type: "POST",                                        
                    url: 'index.php',                  //the script to call to get data          
                    data: 'ajax=1&google_edit_id=' + id + "&google_edit_col=" + col + "&google_edit_content=" + content1,                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
                    success: function (data) {
                              console.log('success',data);
                          },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log('error',thrownError);
                    }
                });
            $(this).closest('span').children('.ajax-edit-filter').text(content1);
            $(this).closest('div.editable-container').remove();
            } 
        }
        else if ($(this).closest('.campaign-event').find('a.ajax-edit-name').attr('class') == "ajax-edit-seim ajax-edit-name editable editable-click editable-open") {
            var col = 'Name';

            if (alphanumeric(content1) == true) {
                $.ajax({
                    cache: false,
                    type: "POST",                                        
                    url: 'index.php',                  //the script to call to get data          
                    data: 'ajax=1&seim_edit_id=' + id + "&seim_edit_col=" + col + "&seim_edit_content=" + content1,                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
                                 //data format      
                    success: function (data) {
                              console.log('success',data);
                          },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log('error',thrownError);
                    }
                });
            $(this).closest('.text-left').children('.ajax-edit-name').text(content1);
            $(this).closest('div.editable-container').remove();
            }
        }
        else if ($(this).closest('.campaign-event').find('a.ajax-edit-code').attr('class') == "ajax-edit-seim ajax-edit-code editable editable-click editable-open") {
            var col = 'Account ID';

            if (alphanumeric(content1) == true) {
                $.ajax({
                    cache: false,
                    type: "POST",                                        
                    url: 'index.php',                  //the script to call to get data          
                    data: 'ajax=1&seim_edit_id=' + id + "&seim_edit_col=" + col + "&seim_edit_content=" + content1,                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
                                 //data format      
                    success: function (data) {
                              console.log('success',data);
                          },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log('error',thrownError);
                    }
                });
            $(this).closest('span').children('.ajax-edit-code').text(content1);
            $(this).closest('div.editable-container').remove();
            } 
        }
        else if ($(this).closest('.campaign-event').find('a.ajax-edit-filter').attr('class') == "ajax-edit-seim ajax-edit-filter editable editable-click editable-open") {
            var col = 'Filter';

            if (alphanumeric(content1) == true) {
                $.ajax({
                    cache: false,
                    type: "POST",                                        
                    url: 'index.php',                  //the script to call to get data          
                    data: 'ajax=1&seim_edit_id=' + id + "&seim_edit_col=" + col + "&seim_edit_content=" + content1,                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
                                 //data format      
                    success: function (data) {
                              console.log('success',data);
                          },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log('error',thrownError);
                    }
                });
            $(this).closest('span').children('.ajax-edit-filter').text(content1);
            $(this).closest('div.editable-container').remove();
            } 
        } 
    });



//EDITIBLE YAHOO T2



    $(document.body).on('click', '.editable-submit' ,function(e) {
        e.preventDefault()

        var id = $(this).closest('li').attr('data-id');
        var content1 = $(this).parent().prev().children('input').val();

        if ($(this).closest('li').find('a.ajax-edit-name').attr('class') == "ajax-edit-yahoo ajax-edit-name editable editable-click editable-open") {
            var col = 'Name';

            if (alphanumeric(content1) == true) {
                $.ajax({
                    cache: false,
                    type: "POST",                                        
                    url: 'index.php',                  //the script to call to get data          
                    data: 'ajax=1&yahoo_edit_id=' + id + "&yahoo_edit_col=" + col + "&yahoo_edit_content=" + content1,                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"    
                    success: function (data) {
                              console.log('success',data);
                          },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log('error',thrownError);
                    }
                });
            $(this).closest('.text-left').children('.ajax-edit-name').text(content1);
            $(this).closest('div.editable-container').remove();
            }
        }
        else if ($(this).closest('li').find('a.ajax-edit-code').attr('class') == "ajax-edit-yahoo ajax-edit-code editable editable-click editable-open") {
            var col = 'Account ID';

            if (alphanumeric(content1) == true) {
                $.ajax({
                    cache: false,
                    type: "POST",                                        
                    url: 'index.php',                  //the script to call to get data          
                    data: 'ajax=1&yahoo_edit_id=' + id + "&yahoo_edit_col=" + col + "&yahoo_edit_content=" + content1,                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
                    success: function (data) {
                              console.log('success',data);
                          },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log('error',thrownError);
                    }
                });
            $(this).closest('span').children('.ajax-edit-code').text(content1);
            $(this).closest('div.editable-container').remove();
            } 
        }
        else if ($(this).closest('li').find('a.ajax-edit-filter').attr('class') == "ajax-edit-yahoo ajax-edit-filter editable editable-click editable-open") {
            var col = 'Filter';

            if (alphanumeric(content1) == true) {
                $.ajax({
                    cache: false,
                    type: "POST",                                        
                    url: 'index.php',                  //the script to call to get data          
                    data: 'ajax=1&yahoo_edit_id=' + id + "&yahoo_edit_col=" + col + "&yahoo_edit_content=" + content1,                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
                    success: function (data) {
                              console.log('success',data);
                          },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log('error',thrownError);
                    }
                });
            $(this).closest('span').children('.ajax-edit-filter').text(content1);
            $(this).closest('div.editable-container').remove();
            } 
        }
        else if ($(this).closest('li').find('a.ajax-edit-name').attr('class') == "ajax-edit-yahoo-lux ajax-edit-name editable editable-click editable-open") {
            var col = 'Name';

            if (alphanumeric(content1) == true) {
                $.ajax({
                    cache: false,
                    type: "POST",                                        
                    url: 'index.php',                  //the script to call to get data          
                    data: 'ajax=1&yahoolux_edit_id=' + id + "&yahoolux_edit_col=" + col + "&yahoolux_edit_content=" + content1,                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
                    success: function (data) {
                              console.log('success',data);
                          },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log('error',thrownError);
                    }
                });
            $(this).closest('.text-left').children('.ajax-edit-name').text(content1);
            $(this).closest('div.editable-container').remove();
            }
        }
        else if ($(this).closest('li').find('a.ajax-edit-code').attr('class') == "ajax-edit-yahoo-lux ajax-edit-code editable editable-click editable-open") {
            var col = 'Account ID';

            if (alphanumeric(content1) == true) {
                $.ajax({
                    cache: false,
                    type: "POST",                                        
                    url: 'index.php',                  //the script to call to get data          
                    data: 'ajax=1&yahoolux_edit_id=' + id + "&yahoolux_edit_col=" + col + "&yahoolux_edit_content=" + content1,                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
                                 //data format      
                    success: function (data) {
                              console.log('success',data);
                          },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log('error',thrownError);
                    }
                });
            $(this).closest('span').children('.ajax-edit-code').text(content1);
            $(this).closest('div.editable-container').remove();
            } 
        }
        else if ($(this).closest('li').find('a.ajax-edit-filter').attr('class') == "ajax-edit-yahoo-lux ajax-edit-filter editable editable-click editable-open") {
            var col = 'Filter';

            if (alphanumeric(content1) == true) {
                $.ajax({
                    cache: false,
                    type: "POST",                                        
                    url: 'index.php',                  //the script to call to get data          
                    data: 'ajax=1&yahoolux_edit_id=' + id + "&yahoolux_edit_col=" + col + "&yahoolux_edit_content=" + content1,                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
                    success: function (data) {
                              console.log('success',data);
                          },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log('error',thrownError);
                    }
                });
            $(this).closest('span').children('.ajax-edit-filter').text(content1);
            $(this).closest('div.editable-container').remove();
            } 
        }
        else if ($(this).closest('li').find('a.ajax-edit-campaign1').attr('class') == "ajax-edit-yahoo-lux ajax-edit-campaign1 editable editable-click editable-open") {
            var col = 'lux_campaign_1';

            if (alphanumeric(content1) == true) {
                $.ajax({
                    cache: false,
                    type: "POST",                                        
                    url: 'index.php',                  //the script to call to get data          
                    data: 'ajax=1&yahoolux_edit_id=' + id + "&yahoolux_edit_col=" + col + "&yahoolux_edit_content=" + content1,                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
                    success: function (data) {
                              console.log('success',data);
                          },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log('error',thrownError);
                    }
                });
            $(this).closest('span').children('.ajax-edit-campaign1').text(content1);
            $(this).closest('div.editable-container').remove();
            } 
        }
        else if ($(this).closest('li').find('a.ajax-edit-campaign2').attr('class') == "ajax-edit-yahoo-lux ajax-edit-campaign2 editable editable-click editable-open") {
            var col = 'lux_campaign_2';

            if (alphanumeric(content1) == true) {
                $.ajax({
                    cache: false,
                    type: "POST",                                        
                    url: 'index.php',                  //the script to call to get data          
                    data: 'ajax=1&yahoolux_edit_id=' + id + "&yahoolux_edit_col=" + col + "&yahoolux_edit_content=" + content1,                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
                                 //data format      
                    success: function (data) {
                              console.log('success',data);
                          },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log('error',thrownError);
                    }
                });
            $(this).closest('span').children('.ajax-edit-campaign2').text(content1);
            $(this).closest('div.editable-container').remove();
            } 
        }
    });







//EDITIBLE BING T3


    $(document.body).on('click', '.editable-submit' ,function(e) {
        e.preventDefault()

        var id = $(this).closest('.campaign-event-bing').attr('data-id');
        var content1 = $(this).parent().prev().children('input').val();

        if ($(this).closest('.campaign-event-bing').find('a.ajax-edit-name').attr('class') == "ajax-edit-bing ajax-edit-name editable editable-click editable-open") {
            var col = 'Name';

            if (alphanumeric(content1) == true) {
                $.ajax({
                    cache: false,
                    type: "POST",                                        
                    url: 'index.php',                  //the script to call to get data          
                    data: 'ajax=1&bing_edit_id=' + id + "&bing_edit_col=" + col + "&bing_edit_content=" + content1,                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
                    success: function (data) {
                              console.log('success',data);
                          },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log('error',thrownError);
                    }
                });
            $(this).closest('.text-left').children('.ajax-edit-name').text(content1);
            $(this).closest('div.editable-container').remove();
            }
        }
        else if ($(this).closest('.campaign-event-bing').find('a.ajax-edit-code').attr('class') == "ajax-edit-bing ajax-edit-code editable editable-click editable-open") {
            var col = 'Account ID';

            if (alphanumeric(content1) == true) {
                $.ajax({
                    cache: false,
                    type: "POST",                                        
                    url: 'index.php',                  //the script to call to get data          
                    data: 'ajax=1&bing_edit_id=' + id + "&bing_edit_col=" + col + "&bing_edit_content=" + content1,                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
                                 //data format      
                    success: function (data) {
                              console.log('success',data);
                          },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log('error',thrownError);
                    }
                });
            $(this).closest('span').children('.ajax-edit-code').text(content1);
            $(this).closest('div.editable-container').remove();
            } 
        }
        else if ($(this).closest('.campaign-event-bing').find('a.ajax-edit-filter').attr('class') == "ajax-edit-bing ajax-edit-filter editable editable-click editable-open") {
            var col = 'Filter';

            if (alphanumeric(content1) == true) {
                $.ajax({
                    cache: false,
                    type: "POST",                                        
                    url: 'index.php',                  //the script to call to get data          
                    data: 'ajax=1&bing_edit_id=' + id + "&bing_edit_col=" + col + "&bing_edit_content=" + content1,                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
                                 //data format      
                    success: function (data) {
                              console.log('success',data);
                          },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log('error',thrownError);
                    }
                });
            $(this).closest('span').children('.ajax-edit-filter').text(content1);
            $(this).closest('div.editable-container').remove();
            } 
        }
     });



//EDITIBLE BING T2



    $(document.body).on('click', '.editable-submit' ,function(e) {
        e.preventDefault()

        var id = $(this).closest('li').attr('data-id');
        var content1 = $(this).parent().prev().children('input').val();

        if ($(this).closest('li').find('a.ajax-edit-name').attr('class') == "ajax-edit-bing-t2 ajax-edit-name editable editable-click editable-open") {
            var col = 'Name';

            if (alphanumeric(content1) == true) {
                $.ajax({
                    cache: false,
                    type: "POST",                                        
                    url: 'index.php',                  //the script to call to get data          
                    data: 'ajax=1&bingt2_edit_id=' + id + "&bingt2_edit_col=" + col + "&bingt2_edit_content=" + content1,                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
                    success: function (data) {
                              console.log('success',data);
                          },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log('error',thrownError);
                    }
                });
            $(this).closest('.text-left').children('.ajax-edit-name').text(content1);
            $(this).closest('div.editable-container').remove();
            }
        }
        else if ($(this).closest('li').find('a.ajax-edit-code').attr('class') == "ajax-edit-bing-t2 ajax-edit-code editable editable-click editable-open") {
            var col = 'Account ID';

            if (alphanumeric(content1) == true) {
                $.ajax({
                    cache: false,
                    type: "POST",                                        
                    url: 'index.php',                  //the script to call to get data          
                    data: 'ajax=1&bingt2_edit_id=' + id + "&bingt2_edit_col=" + col + "&bingt2_edit_content=" + content1,                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
                                 //data format      
                    success: function (data) {
                              console.log('success',data);
                          },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log('error',thrownError);
                    }
                });
            $(this).closest('span').children('.ajax-edit-code').text(content1);
            $(this).closest('div.editable-container').remove();
            } 
        }
        else if ($(this).closest('li').find('a.ajax-edit-filter').attr('class') == "ajax-edit-bing-t2 ajax-edit-filter editable editable-click editable-open") {
            var col = 'Filter';

            if (alphanumeric(content1) == true) {
                $.ajax({
                    cache: false,
                    type: "POST",                                        
                    url: 'index.php',                  //the script to call to get data          
                    data: 'ajax=1&bingt2_edit_id=' + id + "&bingt2_edit_col=" + col + "&bingt2_edit_content=" + content1,                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
                    success: function (data) {
                              console.log('success',data);
                          },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log('error',thrownError);
                    }
                });
            $(this).closest('span').children('.ajax-edit-filter').text(content1);
            $(this).closest('div.editable-container').remove();
            } 
        }
        else if ($(this).closest('li').find('a.ajax-edit-name').attr('class') == "ajax-edit-bing-t2-lux ajax-edit-name editable editable-click editable-open") {
            var col = 'Name';

            if (alphanumeric(content1) == true) {
                $.ajax({
                    cache: false,
                    type: "POST",                                        
                    url: 'index.php',                  //the script to call to get data          
                    data: 'ajax=1&bingt2lux_edit_id=' + id + "&bingt2lux_edit_col=" + col + "&bingt2lux_edit_content=" + content1,                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
                    success: function (data) {
                              console.log('success',data);
                          },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log('error',thrownError);
                    }
                });
            $(this).closest('.text-left').children('.ajax-edit-name').text(content1);
            $(this).closest('div.editable-container').remove();
            }
        }
        else if ($(this).closest('li').find('a.ajax-edit-code').attr('class') == "ajax-edit-bing-t2-lux ajax-edit-code editable editable-click editable-open") {
            var col = 'Account ID';

            if (alphanumeric(content1) == true) {
                $.ajax({
                    cache: false,
                    type: "POST",                                        
                    url: 'index.php',                  //the script to call to get data          
                    data: 'ajax=1&bingt2lux_edit_id=' + id + "&bingt2lux_edit_col=" + col + "&bingt2lux_edit_content=" + content1,                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
                    success: function (data) {
                              console.log('success',data);
                          },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log('error',thrownError);
                    }
                });
            $(this).closest('span').children('.ajax-edit-code').text(content1);
            $(this).closest('div.editable-container').remove();
            } 
        }
        else if ($(this).closest('li').find('a.ajax-edit-filter').attr('class') == "ajax-edit-bing-t2-lux ajax-edit-filter editable editable-click editable-open") {
            var col = 'Filter';

            if (alphanumeric(content1) == true) {
                $.ajax({
                    cache: false,
                    type: "POST",                                        
                    url: 'index.php',                  //the script to call to get data          
                    data: 'ajax=1&bingt2lux_edit_id=' + id + "&bingt2lux_edit_col=" + col + "&bingt2lux_edit_content=" + content1,                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
                    success: function (data) {
                              console.log('success',data);
                          },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log('error',thrownError);
                    }
                });
            $(this).closest('span').children('.ajax-edit-filter').text(content1);
            $(this).closest('div.editable-container').remove();
            } 
        }
    });



//EDITIBLE GOOGLE T2



    $(document.body).on('click', '.editable-submit' ,function(e) {
        e.preventDefault()
        var id = $(this).closest('li').attr('data-id');
        var content1 = $(this).parent().prev().children('input').val();

        if ($(this).closest('li').find('a.ajax-edit-name').attr('class') == "ajax-edit-google-t2 ajax-edit-name editable editable-click editable-open") {
            var col = 'Name';

            if (alphanumeric(content1) == true) {
                $.ajax({
                    cache: false,
                    type: "POST",                                        
                    url: 'index.php',                  //the script to call to get data          
                    data: 'ajax=1&googlet2_edit_id=' + id + "&googlet2_edit_col=" + col + "&googlet2_edit_content=" + content1,                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
                    success: function (data) {
                              console.log('success',data);
                          },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log('error',thrownError);
                    }
                });
            $(this).closest('.text-left').children('.ajax-edit-name').text(content1);
            $(this).closest('div.editable-container').remove();
            }
        }
        else if ($(this).closest('li').find('a.ajax-edit-code').attr('class') == "ajax-edit-google-t2 ajax-edit-code editable editable-click editable-open") {
            var col = 'Account ID';

            if (alphanumeric(content1) == true) {
                $.ajax({
                    cache: false,
                    type: "POST",                                        
                    url: 'index.php',                  //the script to call to get data          
                    data: 'ajax=1&googlet2_edit_id=' + id + "&googlet2_edit_col=" + col + "&googlet2_edit_content=" + content1,                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
                    success: function (data) {
                              console.log('success',data);
                          },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log('error',thrownError);
                    }
                });
            $(this).closest('span').children('.ajax-edit-code').text(content1);
            $(this).closest('div.editable-container').remove();
            } 
        }
        else if ($(this).closest('li').find('a.ajax-edit-filter').attr('class') == "ajax-edit-google-t2 ajax-edit-filter editable editable-click editable-open") {
            var col = 'Filter';

            if (alphanumeric(content1) == true) {
                $.ajax({
                    cache: false,
                    type: "POST",                                        
                    url: 'index.php',                  //the script to call to get data          
                    data: 'ajax=1&googlet2_edit_id=' + id + "&googlet2_edit_col=" + col + "&googlet2_edit_content=" + content1,                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
                    success: function (data) {
                              console.log('success',data);
                          },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log('error',thrownError);
                    }
                });
            $(this).closest('span').children('.ajax-edit-filter').text(content1);
            $(this).closest('div.editable-container').remove();
            } 
        }
        else if ($(this).closest('li').find('a.ajax-edit-name').attr('class') == "ajax-edit-google-t2-lux ajax-edit-name editable editable-click editable-open") {
            var col = 'Name';

            if (alphanumeric(content1) == true) {
                $.ajax({
                    cache: false,
                    type: "POST",                                        
                    url: 'index.php',                  //the script to call to get data          
                    data: 'ajax=1&googlet2lux_edit_id=' + id + "&googlet2lux_edit_col=" + col + "&googlet2lux_edit_content=" + content1,                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
                    success: function (data) {
                              console.log('success',data);
                          },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log('error',thrownError);
                    }
                });
            $(this).closest('.text-left').children('.ajax-edit-name').text(content1);
            $(this).closest('div.editable-container').remove();
            }
        }
        else if ($(this).closest('li').find('a.ajax-edit-code').attr('class') == "ajax-edit-google-t2-lux ajax-edit-code editable editable-click editable-open") {
            var col = 'Account ID';

            if (alphanumeric(content1) == true) {
                $.ajax({
                    cache: false,
                    type: "POST",                                        
                    url: 'index.php',                  //the script to call to get data          
                    data: 'ajax=1&googlet2lux_edit_id=' + id + "&googlet2lux_edit_col=" + col + "&googlet2lux_edit_content=" + content1,                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
                    success: function (data) {
                              console.log('success',data);
                          },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log('error',thrownError);
                    }
                });
            $(this).closest('span').children('.ajax-edit-code').text(content1);
            $(this).closest('div.editable-container').remove();
            } 
        }
        else if ($(this).closest('li').find('a.ajax-edit-filter').attr('class') == "ajax-edit-google-t2-lux ajax-edit-filter editable editable-click editable-open") {
            var col = 'Filter';

            if (alphanumeric(content1) == true) {
                $.ajax({
                    cache: false,
                    type: "POST",                                        
                    url: 'index.php',                  //the script to call to get data          
                    data: 'ajax=1&googlet2lux_edit_id=' + id + "&googlet2lux_edit_col=" + col + "&googlet2lux_edit_content=" + content1,                        //you can insert url argumnets here to pass to api.php                                      //for example "id=5&parent=6"
                                 //data format      
                    success: function (data) {
                              console.log('success',data);
                    
                          },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log('error',thrownError);
                    }
                });
            $(this).closest('span').children('.ajax-edit-filter').text(content1);
            $(this).closest('div.editable-container').remove();
            } 
        }
    });

});






