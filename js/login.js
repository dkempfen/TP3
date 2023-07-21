/*$(document).ready(function(){
    $('#loginUsuario').on('click',function(){
        loginUsuario();
    });
   /* $('#loginProfesor').on('click',function(){
        loginProfesor();
    });
})
*/
jQuery(function(){
    $('#loginUsuario').on('click',function(){
        loginUsuario();
    });
  
})

function loginUsuario(){
    var login = $('#usuario').val();
    var pass = $('#pass').val();
   

    $.ajax({
        URL: '/instituto/Includes/loginAdman.php',
        method:'POST',
        data: {
            login:login,
            pass:pass,
          
  
        },
        success: function(data){
            $('#messageUsuario').html(data);

            if(data.indexOf('Redirecting') >= 0){
                window.location = '/instituto';
            }
        }
    })

}

