var hideMsg=function(){
	$('#tipMsg').fadeOut();
};

var addNew=function(){
  $('#addNew').toggle();
};
	
$(function(){
	$('tr.lightbox:odd').addClass('odd');
	$('tr.lightbox:even').addClass('even');

	$('tr.lightbox').mouseover(function(){
		$(this).addClass('selected');
    });

    $('tr.lightbox:odd').mouseout(function(){
		$(this).removeClass('selected');
		$(this).addClass('odd');
    });

    $('tr.lightbox:even').mouseout(function(){
		$(this).removeClass('selected');
		$(this).addClass('even');
    });
		
$('#selectall').click(function(){
	    $('[type=checkbox]').attr('checked' , true);
});

$('#selectall2').click(function(){
	var op=$(this).attr('checked');
	if(op=='checked'){
	    $('[type=checkbox]').attr('checked',true);
	} else {
	    $('[type=checkbox]').attr('checked',false);
	}
});

$('.selectAllCheckbox').click(function(){
	var op=$(this).attr('checked');
	if(op=='checked'){
	    $('[type=checkbox]').attr('checked',true);
	} else {
	    $('[type=checkbox]').attr('checked',false);
	}
});

$('#unselectall').click(function(){
    $('[type=checkbox]').each(function(){
        if(this.checked){
            $(this).attr('checked' , false);
        } else {
            $(this).attr('checked' , true);
        }
    });
});
});

var page_jump=function(url){
    var page=$('[name=page_options]').val();
	window.location.href=url+page;
};