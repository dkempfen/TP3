
$(document).ready(function(){
    $('#loginUsuario').on('click',function(){
        loginUsuario();
    });
    $('#loginProf').on('click',function(){
        loginProf();
    });
    $('#loginAlumn').on('click',function(){
        loginAlumn();
    });
})

function loginUsuario(){
    var login = $('#usuario').val();
    var pass = $('#pass').val();

    $.ajax({
        URL: '/sistemas/instituto/Includes/loginAdman.php',
        method:'POST',
        data:{
            login:login,
            pass:pass
        },
        success: function(data){
            $('#messageUsuario').html(data);

            if(data.indexOf('Redirecting')>=0){
                window.location ='/sistemas/instituto/Adman/';
            }
        }
    })
}

function loginProf(){
    var login = $('#usuarioProfesor').val();
    var pass = $('#passProfesor').val();

    $.ajax({
        URL: '/sistemas/instituto/Includes/loginProf.php',
        method: 'POST',
        data:{
            login:login,
            pass:pass
        },
        success: function(data){
            $('#messsageProf').html(data);

            if(data.indexOf('Redirecting')>=0){
                window.location ='Adman/';
            }
        }
    })
}

function loginAlumn(){
    var login = $('#usuarioAlumno').val();
    var pass = $('#passAlumno').val();

    $.ajax({
        URL: '/sistemas/instituto/Includes/loginAlumn.php',
        method: 'POST',
        data:{
            login:login,
            pass:pass
        },
        success: function(data){
            $('#messsageAlumn').html(data);

            if(data.indexOf('Redirecting')>=0){
                window.location ='Adman/';
            }
        }
    })
}