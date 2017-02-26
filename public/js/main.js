(function() {
    var $email = document.getElementById('email');
    var $copyEmail = document.getElementById('copyemail');
    var $password = document.getElementById('password');
    var $copyPassword = document.getElementById('copypassword');
    var $submit = document.getElementById('submit');
    var $dialog = document.getElementById('dialog');
    var cache = {};
    var timeOut;
    var registeredMail = false;
    var errors = {};
    var wait = false;

    var checkEmailIsAvailable = function() {
        var email = $email.value;

        removeFieldError('email');
        registeredMail = false;

        if (!isEmail(email))
            return;

        var errorMessage = 'O e-mail informado já foi registado';
        var $loading = document.getElementById('loading');
        $loading.style.visibility = 'visible';

        if(cache.hasOwnProperty(email)) {
            if(true === cache[email]) {
                registeredMail = true;
                addFieldError('email', errorMessage);
            }
            $loading.style.visibility = 'hidden';
            return;
        }

        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/register/exist?email=' + email);
        xhr.onload = function() {
            if (xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);
                cache[email] = data.exist;
                $loading.style.visibility = 'hidden';

                if(true === data.exist) {
                    registeredMail = true;
                    addFieldError('email', errorMessage);
                }
            }
        };
        xhr.send();
    };

    var compareFields = function(id) {
        var $field = document.getElementById(id);
        var $copyField = document.getElementById('copy' + id);

        if($field.value !== $copyField.value) {
            var message = 'O valor inserido não coincide';

            addFieldError('copy' + id, message);
            errors['copy' + id] = message;

        } else {
            removeFieldError('copy' + id);
        }
    };

    var checkPasswordStrength = function() {
        var password = $password.value;
        var $barStatus = document.getElementById('bar__status');

        $barStatus.removeAttribute('class');

        if(password.length == 0)
            return;

        var regex = ['[A-Z]', '[a-z]', '[0-9]', '[$@$!%*#?&]'];
        var level = 0;

        for (var i = 0; i < regex.length; i++)
            if (new RegExp(regex[i]).test(password))
                level++;

        if (level > 2 && password.length > 8)
            level++;

        $barStatus.className += ' l' + level;
    };

    function isEmail(email) {
        var pattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return pattern.test(email);
    }

    function addFieldError(id, message) {
        var $error = document.getElementById(id + '--error');
        var $input = document.getElementById(id);

        $error.innerHTML = message;
        $input.className += ' input--error';
    }

    function addAllFieldErrors() {
        Object.keys(errors).map(function(key) {
            addFieldError(key, errors[key]);
        });
    }

    function removeFieldError(id) {
        var $error = document.getElementById(id + '--error');
        var $input = document.getElementById(id);

        $error.innerHTML = '';
        $input.classList.remove('input--error');
    }

    function removeAllFieldErrors() {
        Object.keys(errors).map(function(key) {
            removeFieldError(key);
        });
    }
    
    function save() {
        if(!wait) {
            changeFormStatus(true);
            removeAllFieldErrors();

            if (!valid()) {
                changeFormStatus(false);
                addAllFieldErrors();
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/register/save');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 201) {
                    var messageHtml = 'Registo efeturado com sucesso.<br/><br/><a href="/register">Ok</a>';
                    openDialog(
                        'Novo registo',
                        messageHtml
                    );

                }

                changeFormStatus(false);
            };
            xhr.send(toString());
        }
    }
    
    function changeFormStatus(inprocess) {
        wait = inprocess;
        $submit.innerHTML = inprocess ? 'Aguarde' : 'Registo'
    }
    
    function valid() {
        errors = {};

        if(!isEmail(get('email')))
            errors['email'] = 'E-mail inválido';

        compareFields('email');

        var firstname = get('firstname');
        if(firstname.trim() == '' || firstname.length < 4)
            errors['firstname'] = 'Nome inválido';

        var lastname = get('lastname');
        if(lastname.trim() == '' || lastname.length < 4)
            errors['lastname'] = 'Apelido inválido';

        if(get('password').trim() == '')
            errors['password'] = 'Password inválida';

        compareFields('password');

        var nif = get('nif');
        if (nif.trim() != '' && (isNaN(nif) || nif.length!=9))
            errors['nif'] = 'NIF inválido';

        var zipcode = get('zipcode');
        var zipcodePattern = /^[0-9]{4}-[0-9]{3}$/;
        if (zipcode.trim() != '' && !zipcodePattern.test(zipcode))
            errors['zipcode'] = 'Código postal inválido';

        var country = get('country');
        var countries = ['PT','BR','ES','NL'];
        if (country.trim() != '' && -1 === countries.indexOf(country))
            errors['country'] = 'País inválido';

        var phone = get('phone');
        var phonePattern = /^(?:9[1-36][0-9]|2[12][0-9]|2[35][1-689]|24[1-59]|26[1-35689]|27[1-9]|28[1-69]|29[1256])[0-9]{6}$/;
        if(country.trim() == 'PT' && phone.trim() != '' && !phonePattern.test(phone))
            errors['phone'] = 'Telefone inválido';

        return 0===Object.keys(errors).length;
    }
    
    function get(id) {
        var $element = document.getElementById(id);
        return $element.value;
    }
    
    function toString() {
        var form = document.getElementById("register");
        var string = '';

        for (var i = 0; i < form.elements.length; i++) {
            string += string == '' ? '' : '&';
            string += encodeURI(form.elements[i].id +'='+ form.elements[i].value);
        }

        return string;
    }

    function execute(f) {
        clearTimeout(timeOut);
        timeOut = setTimeout(function(){
            f();
        }, 500);
    }

    function openDialog(title, message) {
        var $title = document.getElementById("dialog__title");
        var $text = document.getElementById("dialog__text");

        $title.innerHTML = title;
        $text.innerHTML = message;
        $dialog.style.display = 'block';
    }

    $email.addEventListener("keyup", function(){execute(checkEmailIsAvailable)});
    $email.addEventListener("keydown", function(){execute(checkEmailIsAvailable)});
    $copyEmail.addEventListener("keyup", function(){compareFields('email')});
    $copyEmail.addEventListener("keydown", function(){compareFields('email')});
    $password.addEventListener("keyup", checkPasswordStrength);
    $password.addEventListener("keydown", checkPasswordStrength);
    $copyPassword.addEventListener("keyup", function(){compareFields('password')});
    $copyPassword.addEventListener("keydown", function(){compareFields('password')});
    $submit.addEventListener("click", save);
    document.addEventListener("keypress", function(e){
        var key = e.which || e.keyCode;
        if (key === 13)
            save();
    });
})();
