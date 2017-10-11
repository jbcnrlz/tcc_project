

window.onbeforeunload = function() {
    Pace.start();
//    $.skylo('set', 50);
};
Pace.restart();
//$.skylo('set', 50);
$(window).load(function() {
    Pace.stop();
});

////window.onload = function() {
////    document.querySelector('#btnZoomIn').addEventListener('click', function(){
////        alert("dasd");
////        cropper.zoomIn();
////    })
////    document.querySelector('#btnZoomOut').addEventListener('click', function(){
////        cropper.zoomOut();
////    })
//}

$(document).ajaxStart(function() { Pace.restart(); }); 
   
$(document).ready(function () {
    
          $('#enviarNotificacao').on('click', function () {
          $(this).button('loading');
     });
  
      $('.sidebar-toggle').on('click', function(event) {
            event.preventDefault();    
          if (Boolean(sessionStorage.getItem('sidebar-toggle-collapsed'))) {
              sessionStorage.setItem('sidebar-toggle-collapsed', '');
               $(this).find('i').removeClass('fa fa-indent').addClass('fa fa-dedent'); 
               
           } else {
               sessionStorage.setItem('sidebar-toggle-collapsed', '1');
              
              $(this).find('i').removeClass('fa fa-dedent').addClass('fa fa-indent'); 
           }
    });

     
     
     $('.content-wrapper').on('click',function(){
         if($('aside').hasClass('control-sidebar-open')){
            $('aside').removeClass('control-sidebar-open');
         }
     });
     
     

     if($('body').hasClass('sidebar-collapse')){
         $('.sidebar-toggle').html("<i class='fa fa-indent' style='font-size: 20px;'></i>"); 
      }else{
          $('.sidebar-toggle').html("<i class='fa fa-dedent' style='font-size: 20px;'></i>");
          
     }

    $('[data-toggle="tooltip"]').tooltip();   
    
    $('[data-toggle="popover"]').popover();
      
    $('.somente-numero').mask('0000000000000');
    
      $('.somente-numero-5').mask('000000');
    
    $('#projeto-protocolo').mask('9999/9999');
    
    $('.nota').mask('90.00', {reverse: true});
 
    $('.cpf-mask').mask('000.000.000-00', {reverse: true});

    $('[autocomplete="off"]').each(function (index, item) {
		var readonly = $(this).attr("readonly");
		if (typeof readonly !== "undefined") {
			if (readonly) {
				$(this).attr("default-readonly", "");
			} else {
				$(this).prop('readonly', true);
			}
		} else {
			$(this).prop('readonly', true);
		}
	});

	setTimeout(function () {
		$('[autocomplete="off"]').each(function (index, item) {
			var readonly = $(this).attr("readonly");
			var defaultReadonly = $(this).attr("default-readonly");
			if (typeof readonly !== "undefined") {
				if (typeof defaultReadonly === "undefined") {
					$(this).prop('readonly', false);
				}
			}
		});
	}, 300);
    
    $(document).on('icheck', function(){
        $('input[type=checkbox]:not(".not-icheck input[type=checkbox]"), input[type=radio]').iCheck({
            checkboxClass: 'icheckbox_flat-red',
            radioClass: 'iradio_flat-red'
        });
        $('.select-on-check-all').on('ifChecked', function(event) {
            $('.simple').iCheck('check');
        });
        $('.select-on-check-all').on('ifUnchecked', function(event) {
            $('.simple').iCheck('uncheck');
        });

        $('.select-on-check-all').on('ifChanged', function(event){
            if(!this.changed) {
                this.changed=true;
                $('.select-on-check-all').iCheck('check');
            } else {
                this.changed=false;
                $('.select-on-check-all').iCheck('uncheck');
            }
            $('.select-on-check-all').iCheck('update');
        });
    }).trigger('icheck');

       $(document).on('pjax:end', function(e) {
        $(document).trigger('icheck');
        $('.pesquisar').val('');


    });

    $('#btnFullscreen').on('click',function(e) {
        e.preventDefault();
        toggleFullscreen();
    });
    $(window).bind('webkitfullscreenchange mozfullscreenchange fullscreenchange', function(e) {
        var state = document.fullScreen || document.mozFullScreen || document.webkitIsFullScreen;
        var event = state ? 'FullscreenOn' : 'FullscreenOff';
        if(event == "FullscreenOn"){
            $('#btnFullscreen').html("<i class='glyphicon glyphicon-resize-small'></i>");
        }else{
            $('#btnFullscreen').html("<i class='glyphicon glyphicon-fullscreen'></i>");
        }
    });

    ////////////////////////index//////////////////////////

    $('.isDisabled').on("click",function(e) {
       if ($(this).is("[disabled]")) {
            e.preventDefault();
            bootbox.alert({
                title: "Permissão negada?",
                message: "<span class='text-center'>Você não tem permissão para executar está acão.<br>Entre em contato com seu administrado!<span></span>",
                size: 'small',
                buttons:{
                    ok:{
                        className: 'btn-warning',
                    }
                }

            });
            return false;
        }
    });
    
    $(".designado-conf").on("click",function(e){
       
        if (!$(this).is("[disabled]")) {
            e.preventDefault();
            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            var url = $(this).attr("href");
            var tema = $(this).attr("data-tema");
            var id = $(this).attr("data-id");
            var acao = $(this).attr("data-acao");
            if(acao == "aceitar"){
                 bootbox.dialog({
                        animate: true,
                        closeButton: true,
                        title: "Aceitar Projeto?",
                        message: "Tem certeza que deseja aceitar o projeto com o tema:<br><br><p class='text-center'><strong>"+tema+"</strong></p>",
                        buttons: {
                            cancel: {
                                label: '<i class="fa fa-ban"></i> Cancelar',

                            },
                            confirm: {
                                className: 'btn-warning',
                                label: '<i class="fa fa-check"></i> Aceitar',
                                callback: function () {
                                    $.ajax({
                                        type: "POST",
                                        url: url,
                                        data: {_csrf: yii.getCsrfToken(),id:id,acao:acao},
                                        dataType: "json",
                                        success: function (data) {
                                          
                                            location.href = '/projeto/projeto-designado';
                                        }
                                    });
                                }
                            }
                        }
                    })
            }else{
                 bootbox.dialog({
                        animate: true,
                        closeButton: true,
                        title: "Recusar Projeto?",
                        message: "Tem certeza que deseja recusar o projeto com o tema:<p class='text-center'><strong>"+tema+"</strong></p>",
                        buttons: {
                            cancel: {
                                label: '<i class="fa fa-ban"></i> Cancelar',

                            },
                            confirm: {
                                className: 'btn-warning',
                                label: '<i class="fa fa-check"></i> Recusar',
                                callback: function () {
                                    $.ajax({
                                        type: "POST",
                                        url: url,
                                       data: {_csrf: yii.getCsrfToken(),id:id,acao:acao},
                                        dataType: "json",
                                        success: function (data) {
                                            location.href = '/projeto/projeto-designado';
                                        }
                                    });
                                }
                            }
                        }
                    })
            }
           
            return false;

        }
        return false;
    });

    $(".delete-conf").on("click",function(e){
        if (!$(this).is("[disabled]")) {
            e.preventDefault();


            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            var url = $(this).attr("href");
            var id = $(this).attr("data-id");
            bootbox.dialog({
                animate: true,
                closeButton: true,
                title: "Deletar?",
                message: "Tem certeza que deseja deletar os registros selecionados?",
                buttons: {
                    cancel: {
                        label: '<i class="fa fa-ban"></i> Cancelar',

                    },
                    confirm: {
                        className: 'btn-warning',
                        label: '<i class="fa fa-check"></i> Deletar',
                        callback: function () {
                            $.ajax({
                                type: "POST",
                                url: url,
                                data: {_csrf: yii.getCsrfToken()},
                                dataType: "json",
                                success: function () {
                                    location.href = window.location.href;
                                }
                            });
                        }
                    }
                }
            })
            return false;

        }
        return false;
    });
    
    
    $("#gridDataMatricula").on('click','.ajaxDelete', function(e) {
       
        if (!$(this).is("[disabled]")) {
            e.preventDefault();
            var deleteUrl = $(this).attr('delete-url');
            var msgReg = $(this).attr('delete-msg-reg');
            var pjaxContainer = $(this).attr('pjax-container');
            bootbox.dialog({
                animate: true,
                closeButton: true,
                title: "Deletar?",
                message: "Tem certeza que deseja deletar este registro?<br>"+msgReg,
                buttons: {
                    cancel: {
                        label: '<i class="fa fa-ban"></i> Cancelar',

                    },
                    confirm: {
                        className: 'btn-warning',
                        label: '<i class="fa fa-check"></i> Deletar',
                        callback: function () {
                            $.ajax({
                                                        url: deleteUrl,
                                                        type: 'post',
                                                        error: function(xhr, status, error) {
                                                             alert('Houve um erro nesta solicitação.' + xhr.responseText);
                                                        }
                                        }).done(function(data) {                                               
                                               $.pjax.reload({container: '#' + $.trim(pjaxContainer),async:false});
                                              
                                        });
                        }
                    }
                }
            })
            return false;

        }
        return false;
        
               
    });

    $(document).on("click","#deleteSelected",function(){
        var array = "";
        $(".simple").each(function(index){
            if($(this).prop("checked")){
                array += $(this).val()+",";
            }
        })
        if(array==""){
            bootbox.dialog({
                animate: true,
                closeButton: true,
                title: "Ops...",
                message: "Nenhum registro selecionado!",
                buttons: {
                    confirm: {
                        className: "btn-warning",
                        label: '<i class="fa fa-check"></i> Ok'
        }
        },
        });
        } else {
            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            bootbox.dialog({

                animate: true,
                closeButton: true,
                title: "Deletar?",
                message: "Tem certeza que deseja deletar os registros selecionados?",
                buttons: {
                    cancel: {
                        label: '<i class="fa fa-ban"></i> Cancelar'
        },
            confirm: {
                className: 'btn-warning',
                label: '<i class="fa fa-check"></i> Deletar',
                callback: function (){
                    var str = window.location.href;
                    var href = str.replace('/index','');
                    $.ajax({
                        type:"POST",
                        url: href+"/delete?id=",
                        data :{pk:array, _csrf: yii.getCsrfToken()},
                        success:function(){
                            location.href=href;
                        }
                    });
                }
            }
        },

        });

        }
    });
    ///////////////////cadastrar//////////////////////
    $(document).on("click","#cancelar",function(){
        var urlBack = $(this).attr('back-url');
        bootbox.dialog({

            closeButton: false,
            title: "Cancelar",
            message: "Tem certeza que deseja descatar a edição do Registro",
            onEscape: function(){
                return false;
            },
            buttons: {

                cancel: {
                    label: '<i class="fa fa-ban"></i> Descartar',
        callback: function (){
            if(urlBack!=""){
                 window.location=urlBack;
            }else{
                window.location='index';
            }
           
        }

    },
        confirm: {
            className: 'btn-warning',
            label: '<i class="fa fa-check"></i> Continuar Editando'

        }
    },


    });
    });
});



function toggleFullscreen(elem) {
    elem = elem || document.documentElement;
    if (!document.fullscreenElement && !document.mozFullScreenElement &&
        !document.webkitFullscreenElement && !document.msFullscreenElement) {
        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.msRequestFullscreen) {
            elem.msRequestFullscreen();
        } else if (elem.mozRequestFullScreen) {
            elem.mozRequestFullScreen();
        } else if (elem.webkitRequestFullscreen) {
            elem.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
        }

    } else {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        }

    }
}


