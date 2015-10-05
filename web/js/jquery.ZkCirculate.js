(function($) {
    
    $.fn.ZkCirculate = function( settings ) {
	
	settings = $.extend({}, $.fn.ZkCirculate.defaults, settings );
	
	$('#see_new').hide();
	
	var generalDiv = $(this)
	    .css({
		'width':  settings.allWidth,
		'padding-bottom': '30px'
	    });
	    
	var animDuration = 100;
	
	var seeMain  = $('<div/>')
            .css({
		'width':  settings.imgWidth * 4,
		'height': settings.imgHeight * 4,
		'float': 'left',
                'padding': 0,
                'margin': 0,
                'position': 'relative'
	    })
        ;
	
	var rm = 180, rb = 255, dm = rm*2, db = rb*2;
	var h0 = 0, h1 = 6, h2 = 14, h3 = 32, h4 = 50, h5 = 76, h6 = 100, h7 = 132, h8 = 180;
	var w0 = 255, w1 = 300, w2 = 347, w3 = 390, w4 = 422, w5 = 452, w6 = 480, w7 = 500, w8 = 510;
	
	var positions = [];
	    //positions[0] = [ [360,255], [350,190],  [330,115], [300,75],  [270,45],   [225,20],  [195,10],  [180,0]   ];
	    //positions[1] = [ [180,0],   [165,10],   [135,20],  [90,45],    [60,95],   [30,115],  [10,220],  [0,255]   ];
	    //positions[2] = [ [0,255],   [10,320],   [30,395],  [60,435],   [90,465],  [135,490], [165,500], [180,510] ];
	    //positions[3] = [ [180,510], [195,500],  [225,490], [270,465],  [300,435], [330,395], [350,320], [360,255] ];//
	    positions[0] = [ [dm,w0], [(dm-h1),(rb-(w1-rb))], [(dm-h2),(rb-(w2-rb))], [(dm-h3),(rb-(w3-rb))], [(dm-h4),(rb-(w4-rb))], [(dm-h5),(rb-(w5-rb))], [(dm-h6),(rb-(w6-rb))], [(dm-h7),(rb-(w7-rb))], [h8,(w0-w0)] ];
	    positions[1] = [ [h8,(w0-w0)], [h7,(db-w7)], [h6,(db-w6)], [h5,(db-w5)], [h4,(db-w4)], [h3,(db-w3)], [h2,(db-w2)], [h1,(db-w1)], [h0,w0] ];
	    positions[2] = [ [h0,w0], [h1,w1], [h2,w2], [h3,w3], [h4,w4], [h5,w5], [h6,w6], [h7,w7], [h8,w8] ];
	    positions[3] = [ [h8,w8], [(h8+h8-h7),w7], [(h8+h8-h6),w6], [(h8+h8-h5),w5], [(h8+h8-h4),w4], [(h8+h8-h3),w3], [(h8+h8-h2),w2], [(h8+h8-h1),w1], [(h8+h8),w0] ];
	
	var image0 = $('<div/>')
	    .addClass('imgs')
	    .mouseenter( function(){
		if(!$(this).hasClass('img-active')){
		    $(this).css({'background':'url(' + settings.imgActive[0] + ')'});
		}
	    })
	    .mouseleave( function(){
		if(!$(this).hasClass('img-active')){
		    $(this).removeClass('img-active').css({'background':'url(' + settings.img[0] + ')'});
		}
	    })
	    .click(imgClick)
	    .attr('data-url','tablet')
	    .attr('data-act', 'url(' + settings.imgActive[0] + ')')
	    .attr('data-deact', 'url(' + settings.img[0] + ')')
	    .css({
	        'width':  settings.imgWidth,
	        'height': settings.imgHeight,
		'background': 'url(' + settings.img[0] + ')',
                'cursor': 'pointer',
		'top': positions[0][0][0],
		'left': positions[0][0][1],
		'position': 'absolute',
	    })
        ;
	
	var image1 = $('<div/>')
	    .addClass('imgs')
	    .mouseenter( function(){
		if(!$(this).hasClass('img-active')){
		    $(this).css({'background':'url(' + settings.imgActive[1] + ')'});
		}
	    })
	    .mouseleave( function(){
		if(!$(this).hasClass('img-active')){
		    $(this).removeClass('img-active').css({'background':'url(' + settings.img[1] + ')'});
		}
	    })
	    .click(imgClick)
	    .attr('data-url','pc')
	    .attr('data-act', 'url(' + settings.imgActive[1] + ')')
	    .attr('data-deact', 'url(' + settings.img[1] + ')')
	    .css({
	        'width':  settings.imgWidth,
	        'height': settings.imgHeight,
		'background': 'url(' + settings.img[1] + ')',
                'cursor': 'pointer',
		'top': positions[1][0][0],
		'left': positions[1][0][1],
		'position': 'absolute',
	    })
        ;
	var image2 = $('<div/>')
	    .addClass('imgs')
	    .mouseenter( function(){
		if(!$(this).hasClass('img-active')){
		    $(this).css({'background':'url(' + settings.imgActive[2] + ')'});
		}
	    })
	    .mouseleave( function(){
		if(!$(this).hasClass('img-active')){
		    $(this).removeClass('img-active').css({'background':'url(' + settings.img[2] + ')'});
		}
	    })
	    .click(imgClick)
	    .attr('data-url','tv')
	    .attr('data-act', 'url(' + settings.imgActive[2] + ')')
	    .attr('data-deact', 'url(' + settings.img[2] + ')')
	    .css({
	        'width':  settings.imgWidth,
	        'height': settings.imgHeight,
		'background': 'url(' + settings.img[2] + ')',
                'cursor': 'pointer',
		'top': positions[2][0][0],
		'left': positions[2][0][1],
		'position': 'absolute',
	    })
        ;
	var image3 = $('<div/>')
	    .addClass('imgs')
	    .mouseenter( function(){
		if(!$(this).hasClass('img-active')){
		    $(this).css({'background':'url(' + settings.imgActive[3] + ')'});
		}
	    })
	    .mouseleave( function(){
		if(!$(this).hasClass('img-active')){
		    $(this).removeClass('img-active').css({'background':'url(' + settings.img[3] + ')'});
		}
	    })
	    .click(imgClick)
	    .attr('data-url','phone')
	    .attr('data-act', 'url(' + settings.imgActive[3] + ')')
	    .attr('data-deact', 'url(' + settings.img[3] + ')')
	    .css({
	        'width':  settings.imgWidth,
	        'height': settings.imgHeight,
		'background': 'url(' + settings.img[3] + ')',
                'cursor': 'pointer',
		'top': positions[3][0][0],
		'left': positions[3][0][1],
		'position': 'absolute',
	    })
        ;
	
	var logo = $('<img src="/img/logo_rodina.png">').css({'position':'absolute','top': 197,'left': 290.5});
	
	seeMain.append(image0).append(image1).append(image2).append(image3).append(logo);
	generalDiv.append(seeMain).append($('#see_main_descr').clone());
	
	var panelInfo = $('<div/>')
	    .attr('id','img2div')
	    .css({
		'clear': 'both',
		'padding-top': '20px',
		'width':  settings.imgWidth * 4,
		'display': 'none',
		'float': 'left',
	    })
	;
	
	var panelInfoItems = {
	    'tablet':[],
	    'tablet_right_panel':[],
	    'tablet_table':[],
	    'pc':[],
	    'pc_right_panel':[],
	    'pc_table':[],
	    'tv':[],
	    'tv_right_panel':[],
	    'tv_table':[],
	    'phone':[],
	    'phone_right_panel':[],
	    'phone_table':[]
	};
	
	var template = $('<div/>')
	    .addClass('img2')
	    .css({
		'width':  settings.imgWidth * 4 / 3,
		'height': settings.imgHeight,
                'cursor': 'pointer',
		'float': 'left',
	    })
	;
	
	var template2 = $('<div/>')
	    .css({
		'width':  settings.allWidth - settings.imgWidth * 4 - 30,
		'float': 'left',
		'padding': '5px 15px'
	    })
	;
	
	var template3 = $('<div/>')
	    .css({
		'clear': 'both',
		'width':  settings.imgWidth * 4,
	    })
	;
	
	var temp = ['tablet','pc','tv','phone'];
	
	for (var i = 0; i < temp.length; i++) {
	    for (var j = 1; j < 4; j++) {
		panelInfoItems[temp[i]][j] = template.clone().attr('data-num',j).attr('data-url',temp[i]);
		//panelInfoItems[(temp[i]+'_right_panel')][j] = template2.clone().html($('#h_'+temp[i]+'_'+j+'_right_panel').val());
		//panelInfoItems[(temp[i]+'_table')][j] = template3.clone().html($('#h_'+temp[i]+'_'+j+'_table').val());
	    }
	}
	
	//panelInfoTv.append(panelInfoTvImg1).append(panelInfoTvImg2).append(panelInfoTvImg3).append(panelInfoTvDescr);
	generalDiv.append('<div style="clear:both;"/><br><br>').append(panelInfo);

	function imgClick(){
	    $('.imgs').each(function(){
		$(this).css({'background':$(this).data('deact')}).removeClass('img-active');
	    });
	    $(this).css({'background':$(this).data('act')}).addClass('img-active');
	    
	    var count = 0;
	    
	    if ($(this).css('top') == (positions[1][0][0]+'px') && $(this).css('left') == (positions[1][0][1]+'px')) {
		count = 3;
	    } else if ($(this).css('top') == (positions[2][0][0]+'px') && $(this).css('left') == (positions[2][0][1]+'px')) {
		count = 2;
	    } else if ($(this).css('top') == (positions[3][0][0]+'px') && $(this).css('left') == (positions[3][0][1]+'px')) {
		count = 1;
	    }
	    if (!count)
	    {
		imgShowTable($(this).data('url'));
		return;
	    }
	    imgTrans(image0,count,$(this).data('url'));
	    imgTrans(image1,count,$(this).data('url'));
	    imgTrans(image2,count,$(this).data('url'));
	    imgTrans(image3,count,$(this).data('url')); 
	}
	
	function imgTrans(image,count,url) {
	    $.each(positions,function(key,val){
		if (image.css('top') == (this[0][0]+'px') && image.css('left') == (this[0][1]+'px')) {
		    var j = key != 3 ? key+1 : 0;
		    image
		    .animate({top:  this[1][0],left: this[1][1]},animDuration)
		    .animate({top:  this[2][0],left: this[2][1]},animDuration)
		    .animate({top:  this[3][0],left: this[3][1]},animDuration)
		    .animate({top:  this[4][0],left: this[4][1]},animDuration)
		    .animate({top:  this[5][0],left: this[5][1]},animDuration)
		    .animate({top:  this[6][0],left: this[6][1]},animDuration)
		    .animate({top:  this[7][0],left: this[7][1]},animDuration)
		    .animate({top:  this[8][0],left: this[8][1]},{
			duration: animDuration,
			complete:  function() {
			    if(count > 1) imgTrans(image,(count-1),url);
			    else if(image.attr('data-url') == url){
				imgShowTable(url);
			    }
			}
		    });
		    return;
	        }
	    });
	}
	
	function imgShowTable(url) {
	    if (panelInfo.html()) {
		panelInfo.fadeTo(300,0.5).html('').html(panelInfoItems[url]).append(template3.clone());
		imgClick2(url,2,false);
		panelInfo.show(1000).fadeTo(500,1);
	    } else { 
		panelInfo.html(panelInfoItems[url]).append(template3.clone());
		panelInfo.after(template2.clone());
		imgClick2(url,2,true);
		panelInfo.slideToggle("slow");
	    }
	}
	
	function imgClick2(url,num,is) {  //alert(panelInfoItems[url+'_right_panel'][num].html());
	    $('#img2div .img2').each(function(k,v){
		if ((k+1) != num) {
		    $(this).css({"background":"url('/img/see_new/"+url+"_"+(k+1)+"_0.png') no-repeat center center"});
		    $(this).hover(
		        function(){$(this).css("background","url('/img/see_new/"+url+"_"+(k+1)+"_1.png') no-repeat center center")},
		        function(){$(this).css("background","url('/img/see_new/"+url+"_"+(k+1)+"_0.png') no-repeat center center")}
		    );
		    $(this).click(imgClickEvent);
		} else {
		    $(this).hover(function(){$(this).css("background","url('/img/see_new/"+url+"_"+(k+1)+"_1.png') no-repeat center center")});
		    $(this).css({"background":"url('/img/see_new/"+url+"_"+(k+1)+"_1.png') no-repeat center center"});
		}
	    });
	    
	    $('#img2div').stop(true,true).next().hide().html($('#h_'+url+'_'+num+'_right_panel').val()).show();
	    $('#img2div').find('div:last').html($('#h_'+url+'_'+num+'_table').val());
	}
	
	function imgClickEvent() { //alert($(this).data('num'));
	    var u = $(this).data('url');
	    var n = $(this).data('num');
	    imgClick2(u,n,false);
	}
	
    }
    
    
    $.fn.ZkCirculate.defaults = {
        img: [$('<img/>'),$('<img/>'),$('<img/>'),$('<img/>')],
        imgActive: [$('<img/>'),$('<img/>'),$('<img/>'),$('<img/>')],
	imgWidth: 0,
        imgHeight: 0,
	allWidth: 0,
    };
    
})(jQuery);
