$(function(){
   $('#checkall').click(function(){
       if($(this).attr('checked')=='checked'){
           $('.delbtn').show();
           $('.check').attr('checked',true);
       } else {
           $('.delbtn').hide();
           $('.check').attr('checked',false);
       }
   });
   
   $('.check').click(function(){
       if($('.check:checked').length>0){
           $('.delbtn').show();
       } else {
           $('.delbtn').hide();
       }
   });
   
    $('tr.lightbox:odd').addClass('odd');
    $('tr.lightbox:even').addClass('even');

    $('tr.lightbox').mouseover(function(){
    	$(this).addClass('selected');
    });

    $('tr.lightbox:odd').mouseout(function(){
    	if(!$(this).hasClass('clicked')){
    		$(this).removeClass('selected');
    		$(this).addClass('odd');
    	}
    });

    $('tr.lightbox:even').mouseout(function(){
    	if(!$(this).hasClass('clicked')){
    		$(this).removeClass('selected');
    		$(this).addClass('even');
    	}
    });

    $('tr.lightbox').click(function(){
    	$('tr.lightbox').removeClass('selected');
    	$('tr.lightbox').removeClass('clicked');
        $(this).addClass('selected');
    	$(this).addClass('clicked');
    });
    
    $('[name=is_card]').click(function(){
        $('.tr_remark').hide();
        if($(this).val()==1){
            $('.tr_remark').show();
        } 
    });
});