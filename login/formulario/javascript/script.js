function validate_password() {
    var password = document.getElementById('psw').value;
    var cpf = document.getElementById('cpf')
    count = check_password(password);
    const reg = /([0-9]{2}[\.]?[0-9]{3}[\.]?[0-9]{3}[\/]?[0-9]{4}[-]?[0-9]{2})|([0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2})/;
      if (count==4) {

        var hash = CryptoJS.SHA256($('#psw').val()).toString();

        $('#senha_hash').val(hash);

        var data = $("#form").serialize();

        var chave = CryptoJS.enc.Utf8.parse("1234567887654321");

        var iv = "1234567890";

        var mensagem = JSON.stringify(data).toString();

        var criptografado = CryptoJS.AES.encrypt(mensagem, chave, {
            iv: CryptoJS.enc.Utf8.parse(iv),
            mode: CryptoJS.mode.CBC,
            padding: CryptoJS.pad.ZeroPadding
        });

        $.ajax({
            url     : "../formulario/php/register.php",
            type    : "POST",
            data    : {"message":criptografado.toString()},
            success : function(data){

            console.log(data);

            var response = JSON.parse(data);

            console.log(JSON.parse(data));
            if(response.success == true) {
                //window.location.assign(response.url);        
            } else{
               $('#form')[0].reset();
               //window.location.assign(response.url);
            }
            }
        });
      }
}
function validate_number(){
    const number = /\d\d\d\d/;
    var validated = 0;
    var code = document.getElementById('verification_code').value;
    if (code.match(number)) {
        validated++;
        $.ajax({
            url     : "php/auth.php",
            type    : "POST",
            data    : $("#form").serialize(),
            success : function(data){

                console.log(data);

                var response = JSON.parse(data);
    
                console.log(JSON.parse(data));
                if(response.success == true) {
                    window.location.assign(response.url);        
                } else{
                   $('#form')[0].reset();
                   window.location.assign(response.url);
                }
            }
        });
    }
    else{
        alert('O número tem no máximo 4 digitos');
    }
}
function login(){
    var password = document.getElementById('psw').value;
    var count = check_password(password);
      if (count == 4) {

        var hash = CryptoJS.SHA256($('#psw').val());

        $('#senha_hash').val(hash);

        $.ajax({
            url     : "../login/formulario/php/login.php",
            type    : "POST",
            data    : $("#form").serialize(),
            success : function(data){

                var response = JSON.parse(data);
                
                if(response.sucess == true){
                    window.location.assign(response.url);
                }
                else{
                    $('#form')[0].reset();
                    alert('Usuário e/ou senha incorretos');
                }
            }
        })
      }
}
function check_password(password){
    const UpperCase = /[A-Z]/g;
    const LowerCase = /[a-z]/g;
    const number = /[0-9]/g;
      var validated = 0;
      if (password.length >= 8) {
          validated++;
      }
      if (password.match(number)) {
          validated++;
      }
      if (password.match(UpperCase)) {
          validated++;
      }
      if (password.match(LowerCase)) {
          validated++;
      }
      if (validated == 4) {
            return validated;
      }
}
/*function check(cpf){
    const reg = /([0-9]{2}[\.]?[0-9]{3}[\.]?[0-9]{3}[\/]?[0-9]{4}[-]?[0-9]{2})|([0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2})/;
    if(cpf.match(reg)){
        return 1;
    }
}*/
function recover(){
    var psw= document.getElementById('psw').value;
    var psw2 = document.getElementById('psw2').value;
    var count = check_password(psw)
    count += check_password(psw2)
    if(count == 8){
        var hash = CryptoJS.SHA256($('#psw').val());
        $('#psw_hash').val(hash);

        hash = CryptoJS.SHA256($('#psw2').val());
        $('#new_hash').val(hash);
        $.ajax({
            url     : "../login/formulario/php/recovery.php",
            type    : "POST",
            data    : $("#form").serialize(),
            success : function(data){

                var response = JSON.parse(data);
    
                console.log(JSON.parse(data));
                if(response.success == true) {
                    console.log('oi')
                    window.location.assign(response.url);        
                } else{
                    console.log('io')
                   $('#form')[0].reset();
                   window.location.assign(response.url);
                }
                //window.location.assign('http://localhost/Mercadon-v2/Mercadon/login/index.html');
            }
        });
    }
}

function logout(){
        $.ajax({
            url     : "login/formulario/php/logout.php",
            type    : "POST",
            success : function(data){
                window.location.assign('http://localhost/Mercadon-v2/Mercadon/index.html');    
            }
        });
}