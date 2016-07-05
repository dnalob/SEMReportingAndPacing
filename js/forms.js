//SEND SUBMITTED GOOGLE SHEET INFO



function changeID(value, id) {

    $.ajax({
        cache: false,
        type: "POST",
        url: "index.php",
        data: "id_value=" + value + "&id_id=" + id,
        success: function (data) {
            console.log('success',data);
            console.log(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log('error',thrownError);
        }
    });

    var html = "<div class=\"alert alert-success remove-it\"><strong>Saved!</strong></div>";
    $('#savedAlert').append(html);
    $('.remove-it').fadeOut(4000,function() {
        this.remove();
    });
}



//send submitted columns data 



function sendColumnsG2(columns) {
    var json = columns;
    var obj = JSON.parse(json);

    $.ajax({
        cache: false,
        type: "POST",
        url: "index.php",
        data: "g2_column1=" + obj[0] + "&g2_column2=" + obj[1] + "&g2_column3=" + obj[2] + "&g2_column4=" + obj[3],
        success: function (data) {
            console.log('success',data);
            console.log(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log('error',thrownError);
        }
    });
}

function sendColumnsB2(columns) {
    var json = columns;
    var obj = JSON.parse(json);

    $.ajax({
        cache: false,
        type: "POST",
        url: "index.php",
        data: "b2_column1=" + obj[0] + "&b2_column2=" + obj[1] + "&b2_column3=" + obj[2] + "&b2_column4=" + obj[3],
        success: function (data) {
            console.log('success',data);
            console.log(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log('error',thrownError);
        }
    });
}

function sendColumnsY2(columns) {
    var json = columns;
    var obj = JSON.parse(json);

    $.ajax({
        cache: false,
        type: "POST",
        url: "index.php",
        data: "y2_column1=" + obj[0] + "&y2_column2=" + obj[1] + "&y2_column3=" + obj[2] + "&y2_column4=" + obj[3],
        success: function (data) {
            console.log('success',data);
            console.log(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log('error',thrownError);
        }
    });
}

function sendColumnsG3(columns) {
    var json = columns;
    var obj = JSON.parse(json);

    $.ajax({
        cache: false,
        type: "POST",
        url: "index.php",
        data: "g3_column1=" + obj[0] + "&g3_column2=" + obj[1] + "&g3_column3=" + obj[2],
        success: function (data) {
            console.log('success',data);
            console.log(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log('error',thrownError);
        }
    });
}


function sendColumnsB3(columns) {
    var json = columns;
    var obj = JSON.parse(json);

    $.ajax({
        cache: false,
        type: "POST",
        url: "index.php",
        data: "b3_column1=" + obj[0] + "&b3_column2=" + obj[1] + "&b3_column3=" + obj[2],
        success: function (data) {
            console.log('success',data);
            console.log(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log('error',thrownError);
        }
    });
}

function sendColumnsSEIM(columns) {

    var json = columns;
    var obj = JSON.parse(json);

    $.ajax({
        cache: false,
        type: "POST",
        url: "index.php",
        data: "seim_column1=" + obj[0] + "&seim_column2=" + obj[1] + "&seim_column3=" + obj[2] + "&seim_column4=" + obj[3] + "&seim_column5=" + obj[4],
        success: function (data) {
            console.log('success',data);
            console.log(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log('error',thrownError);
        }
    });
}



// HASH PASSWORD



function formhash(form, password) {
    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement("input");
 
    // Add the new element to our form. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
 
    // Make sure the plaintext password doesn't get sent. 
    password.value = "";
 
    // Finally submit the form. 
    form.submit();
}



// HASH PASSWORD ON REGISTER USER


 
function regformhash(form, uid, email, password, conf) {
     // Check each field has a value
    if (uid.value == ''         || 
        email.value == ''     || 
        password.value == ''  || 
        conf.value == '') {
 
        alert('You must provide all the requested details. Please try again');
        return false;
    }
 
    // Check the username
 
    re = /^\w+$/; 
    if(!re.test(form.username.value)) { 
        alert("Username must contain only letters, numbers and underscores. Please try again"); 
        form.username.focus();
        return false; 
    }
    

   // CHECK EMAIL FOR SPECIFIC DOMAIN NAME

    re = /^\s*[\w\-\+_]+(\.[\w\-\+_]+)*\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$/; 
    if(!re.test(form.email.value)) {
        alert("Username must contain only letters, numbers and underscores. Please try again"); 
        form.email.focus();
        return false; 
    }
    else {
        if (form.email.value.indexOf('', form.email.value.length - '@'.length) !== -1){
        } else {
            alert('Error regarding email address domain.');
            return false
        }
    }
      
    // Check that the password is sufficiently long (min 6 chars)
    // The check is duplicated below, but this is included to give more
    // specific guidance to the user
    if (password.value.length < 6) {
        alert('Passwords must be at least 6 characters long.  Please try again');
        form.password.focus();
        return false;
    }
 
    // At least one number, one lowercase and one uppercase letter 
    // At least six characters 
 
    var re = /(?=.*\d)(?=.*[a-z]).{6,}/; 
    if (!re.test(password.value)) {
        alert('Passwords must contain at least one number, one lowercase and one uppercase letter.  Please try again');
        return false;
    }
 
    // Check password and confirmation are the same
    if (password.value != conf.value) {
        alert('Your password and confirmation do not match. Please try again');
        form.password.focus();
        return false;
    }
 
    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement("input");
 
    // Add the new element to our form. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
 
    // Make sure the plaintext password doesn't get sent. 
    password.value = "";
    conf.value = "";
 
    // Finally submit the form. 
    form.submit();
    return true;
}



// HASH PASSWORD FOR RECOVER PASSWORD FUNCTION



function recformhash(form, email) {
     // Check each field has a value
    if (email.value == '') {
 
        alert('You must provide all the requested details. Please try again');
        return false;
    }
    
    // Finally submit the form. 
    form.submit();
    return true;
}



// REGULAR PASSWORD HASH



function passformhash(form, token, email, password, conf) {
     // Check each field has a value
    if (token.value == ''     ||
        email.value == ''     ||
        password.value == ''  || 
        conf.value == '') {
 
        alert('You must provide all the requested details. Please try again');
        return false;
    }
 
    // Check that the token is sufficiently long (min 6 chars)
    // The check is duplicated below, but this is included to give more
    // specific guidance to the user
    if (token.value.length < 128) {
        alert('tokens must be at least 128 characters long.  Please try again');
        // form.password.focus();
        return false;
    }
    
    // Only alpha numeric
    // At least six characters 
 
    var re = /^[a-zA-Z0-9]{6,}$/; 
    if (!re.test(token.value)) {
        alert('Error: Invalid token.  Please try again');
        return false;
    }
    
    // Check that the password is sufficiently long (min 6 chars)
    // The check is duplicated below, but this is included to give more
    // specific guidance to the user
    if (password.value.length < 6) {
        alert('Passwords must be at least 6 characters long.  Please try again');
        form.password.focus();
        return false;
    }
 
    // At least one number, one lowercase letter
    // At least six characters 
 
    var re = /(?=.*\d)(?=.*[a-z]).{6,}/; 
    if (!re.test(password.value)) {
        alert('Passwords must contain at least one number, one lowercase and one uppercase letter.  Please try again');
        return false;
    }
 
    // Check password and confirmation are the same
    if (password.value != conf.value) {
        alert('Your password and confirmation do not match. Please try again');
        form.password.focus();
        return false;
    }
 
    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement("input");
 
    // Add the new element to our form. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
 
    // Make sure the plaintext password doesn't get sent. 
    password.value = "";
    conf.value = "";
 
    // Finally submit the form. 
    form.submit();
    return true;
}