function clearInputErrors() {
    var errors = document.querySelectorAll(".input-error");
    for (var i = 0; i < errors.length; i++) {
        errors[i].style.display = 'none';
    }
}

function validateUser() {
    var usr = document.forms['reg_form']['username'].value;
    clearInputErrors();

    if (usr.length == 0) {
        document.getElementById('empty-usr').style.display = 'block';
        return false;
    }
    else if (!usr.match(/^[A-Za-z0-9_]{4,25}$/)) {
        document.getElementById('bad-usr').style.display = 'block';
        return false;
    }
    return true;
}

function validatePassword() {
    var psw = document.forms['reg_form']['password'].value;
    clearInputErrors();

    if (psw.length == 0) {
        document.getElementById('empty-psw').style.display = 'block';
        return false;
    }
    else if (!psw.match(/^[A-Za-z0-9_]{4,25}$/)) {
        document.getElementById('bad-psw').style.display = 'block';
        return false;
    }
    return true;
}

function validateCode() {
    var code = document.forms['reg_form']['pin'].value;
    clearInputErrors();

    if (code.length == 0) {
        document.getElementById('empty-code').style.display = 'block';
        return false;
    }
    else if (code != localStorage.getItem('pin')) {
        document.getElementById('bad-code').style.display = 'block';
        return false;
    }
    return true;
}

function validateForm() {
    if (validateUser() && validatePassword() && validateCode())
        return true;
    
    return false;
}