$(function() {
      
      $('input[type=checkbox], input[type=radio]').iCheck({
            checkboxClass: 'icheckbox_flat-red',
            radioClass: 'iradio_flat-red'
        });
        
    $('.cpf-mask').mask('000.000.000-00', {reverse: true});
          
        $('#login-form-link').click(function(e) {
            $("#login-form").delay(100).fadeIn(100);
                    $("#cadastro-form").fadeOut(100);
                    $('#cadastro-form-link').removeClass('active');
                    $(this).addClass('active');
                    $('#cadastro-form')[0].reset();
                     $('#usuario-nome').val('');
                    $('#usuario-email').val('');
                    $('#usuario-ra').val('');
                    $('#usuario-cpf').val('');
                    e.preventDefault();
            });
	$('#cadastro-form-link').click(function(e) {
		$("#cadastro-form").delay(100).fadeIn(100);
 		$("#login-form").fadeOut(100);
		$('#login-form-link').removeClass('active');
		$(this).addClass('active');
                $('#cadastro-form')[0].reset();
                  $('#usuario-nome').val('');
                    $('#usuario-email').val('');
                    $('#usuario-ra').val('');
                    $('#usuario-cpf').val('');
		e.preventDefault();
	});
        
     

});
