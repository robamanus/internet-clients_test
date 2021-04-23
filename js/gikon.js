$(document).ready(function() {
	$("#login-button").click( function() {
		if(($("input[name='usr']").val()!=false)&&($("input[name='psw']").val()!=false)){
			if(($("input[name='usr']").val().length >= 3)&&($("input[name='usr']").val().length < 64)&&($("input[name='psw']").val().length >= 3)&&($("input[name='psw']").val().length < 64)){
				$.ajax({
					type: "POST",
					url: "http://gikon.ru/controllers/acc",
					data: {usr:$("input[name='usr']").val(),psw:$("input[name='psw']").val()},
					dataType: "html",
					//beforeSend: function(){$("#result_list").remove();},
					success: function(data){
						if((data!=false) && (data != '1')){
							alert(data);
						}
						location.reload();
					}
						
				});
			}
		}
		else{
			alert('Введите логин и пароль');
		}
	});
	$("#logout").click( function() {
		$.ajax({
			type: "POST",
			url: "http://gikon.ru/controllers/logout",
			dataType: "html",
			success: function(data){
				location.reload();
			}
		});
	});
	function Plus(){
		$( ".plus" ).unbind( "click", Plus ); 
		var id = $(this).attr('id');
		$('#'+id).children().css('display', 'block');
		$('#'+id).toggleClass( "plus minus" );
		$(".plus").bind('click', Plus);
	}
	$(".plus").bind('click', Plus);
});