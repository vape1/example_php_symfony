$(function(){
	
    var $img_add = $('<img class="img_add" style="cursor:pointer;margin-left:3px;" src="/bundles/zkinterface/images/new.png" title="Add fliter" alt="Add fliter" />');
    var $img_del = $('<img class="img_del" style="cursor:pointer;margin-left:3px;" src="/bundles/zkinterface/images/delete.png" title="Delete fliter" alt="Delete fliter" />');
    var $td = $('#filter_table td');
    $td.find('ul:first').css('margin-left','75px');
    $td.find('ul:not(:first)').append($img_del).filter(function(){
        return $(this).find('input,select').eq(2).val() == '' &&
               ( !$(this).find('select').eq(1).val().match("NULL") );
    }).hide();
    $td.filter(function(){return $(this).find('ul').length > 1}).find('ul:first').append($img_add);
    
    $('.img_add').click(function(e){
        e.preventDefault();
        var $thisTd = $(this).parent().parent();
        $thisTd.find('ul:hidden:first').show();
        if( $thisTd.find('ul:hidden').length == 0 ) {
            $(this).hide();
        }
    });
    
    $('.img_del').click(function(e){
        e.preventDefault();
        $(this).parent().find('input,select').val('');
        $(this).parent().hide();
        $(this).parent().parent().find('ul:first .img_add').show();
    });
});