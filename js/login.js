$(document).ready(function() {
  var remember = $.cookie('remember');
  if (remember == 'true') {
      var email = $.cookie('login');
      var password = $.cookie('password');

      $('#login').val(email);
      $('#password').val(password);
      $('#remember').prop('checked', true);
  }
  
  $(document).on('submit', '#login_form', function(){
    
    var login_form = $(this);
    var form_data = JSON.stringify(login_form.serializeObject());
    
    $.ajax({
        url: "api/auth.php",
        type : "POST",
        contentType : 'application/json',
        data : form_data,
        success : function(data){

            if ($('#remember').is(':checked')) {
                var login = $('#login').val();
                var password = $('#password').val();

                $.cookie('login', login, { expires: 14 });
                $.cookie('password', password, { expires: 14 });
                $.cookie('remember', true, { expires: 14 });                
            }else{
                $.cookie('login', null);
                $.cookie('password', null);
                $.cookie('remember', null);
            }
            if(data.login){
                window.location.href = "list.html";
            }
        },
        error: function(xhr, resp, text){
            $('#response').html("<div class='alert alert-danger'>login or password incorrect</div>");
            login_form.find('input').val('');
        }
    });
    return false;
  });
});