$( document ).ready(function() {

    $('#username').on('input',function(event){
        var username= event.target.value;
        $(event.target).removeClass('is-invalid');
        if(username.length > 3){
            $.ajax({
                method: 'GET',
                url: '/blogger/ajax/checkUser.php?name='+username
            }).done(function(result){
                if(result.hasUser){
                    $(event.target).addClass('is-invalid');
                }
                else{
                    $(event.target).removeClass('is-invalid');
                }
            });
        }

    });

    $('#email').on('input',function(event){
        var email= event.target.value;
        $(event.target).removeClass('is-invalid');
        if(username.length > 3){
            $.ajax({
                method: 'GET',
                url: '/blogger/ajax/checkUser.php?email='+email
            }).done(function(result){
                if(result.hasEmail){
                    $(event.target).addClass('is-invalid');
                }
                else{
                    $(event.target).removeClass('is-invalid');
                }
            });
        }

    });



});
