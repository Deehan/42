$(document).ready(function(){

	$('div.player.one ul.list.show li').hover(function(){
		var id = $(this).attr('ship');
		$('#board div.ship#'+id).css('background', 'rgba(255,0,0,0.6)').css('border-color:rgba(255,0,0,0.8)');
		$(this).finish().animate({ left: '+=100' }, 200);
	}, function() {
		var id = $(this).attr('ship');
		$('#board div.ship#'+id).css('background', 'rgba(255,0,0,0.2)').css('border-color:rgba(255,0,0,0.4)');;
		$(this).finish().animate({ left: '-=100' }, 200);
	});
	$('div.player.two ul.list.show li').hover(function(){
		$(this).finish().animate({ right: '+=90' }, 200);
	}, function() {
		$(this).finish().animate({ right: '-=90' }, 200);
	});

	$('div.player.one ul.list li').click(function()
	{
		var ul = $(this).parent('ul');
		if (!$(ul).hasClass('show'))
			return false;
		var id = $(this).children('input[type=hidden]').val();
		$.ajax({	url: './index.php',
				 	method: "GET",
				 	dataType: "json",
				  	data: { controller:'infos', action:'ship_infos', 'player':1, 'ship':id},
		}).done(function(json) {
			fillpanel('one', json);
		});

		$(ul).removeClass('show').children('li:not(.title)').each(function()
		{
			$(this).finish().animate({left: '-=250'}, 500, function() {});
		});

    	$('div.action.one').finish().animate({top: '+=700'}, 700, function(){
    		var div = $(this);
    		display_onglet('pp');
    		$(div).find('ul.onglets li.maneuvers').bind('click', function()
    			{
    				$(this).unbind('click');
    				display_onglet('maneuvers');
    				loadmaneuvers(div);
    				$(this).next('li').bind('click', function()
    				{
    					playaction(div);
    					$(this).unbind('click');
    					display_onglet('shoots');
    				});
    			});
    		$(div).find('input[type=text]').val('0');
    		$(div).children('input#shipid').val(id);
    		$(div).children('input').bind('click', function()
			{
				$(this).unbind('click');
		    	$(div).finish().animate({top: '-=700'}, 1000, function(){
					$(ul).addClass('show').children('li:not(.title)').each(function()
					{
						$(this).finish().animate({left: '+=250'}, 500);
					});
		    	});
			});
    	});
	});

	$('div.action div.onglet.pp div.attrib input.plus').click(function(){incrementPP(this);});
	$('div.action div.onglet.pp div.attrib input.minus').click(function(){decrementPP(this);});
});

function playaction(div)
{
	var list = [];
	$(div).find('div.onglet.maneuvers ul.moves li').each(function()
	{
		list[list.length] = {key:$(this).attr('class'), free:parseInt($(this).attr('free')), compul:parseInt($(this).attr('compul')), count:$(this).children('span').html()};
	});
	var id = $(div).children('input#shipid').val();
	var player = $(div).children('input#playerid').val();	

	$.ajax({	url: './index.php',
			 	method: "GET",
			 	dataType: "json",
			  	data: { controller:'action', action:'moves', 'player':player, 'ship':id, 'moves':JSON.stringify(list)},
	}).done(function(json) {
		//alert(json);
		$.each(json, function(k, v)
		{
			$('div.ship#p'+player+'s'+v.id).css('width', v.w+'px').css('height', v.h+'px').css('top', v.newpos.y+'px').css('left', v.newpos.x+'px');
		});
	});
}


function loadmaneuvers(div)
{
	var list = [];
	$(div).find('div.onglet.maneuvers ul.moves li').each(function()
	{
		list[list.length] = {key:$(this).attr('class'), free:parseInt($(this).attr('free')), compul:parseInt($(this).attr('compul')), count:$(this).children('span').html()};
	});
	var id = $(div).children('input#shipid').val();
	var player = $(div).children('input#playerid').val();	

	$.ajax({	url: './index.php',
			 	method: "GET",
			 	dataType: "json",
			  	data: { controller:'infos', action:'ship_maneuvers', 'player':player, 'ship':id, 'moves':JSON.stringify(list)},
	}).done(function(json) {
		var ul = $(div).find('div.onglet.maneuvers ul.allmaneuvers');
		$(ul).html('');
		$.each(json, function(k, v)
		{
			var li = $('<li>').addClass(v.key).append('<span>'+v.count+'</span>');
			li.bind('click', function()
			{
				if($(this).text() > 0)
				addmaneuver(div,v.key,(v.free | 0),(v.compul | 0));
				loadmaneuvers(div);
			});
			$(ul).append(li);
		});
	});
}

function addmaneuver(div, key, free, compul)
{
	var ul = $(div).find('div.onglet.maneuvers ul.moves');
	var last = $(ul).children('li').last();
	if($(last).hasClass(key))
	{
		$(last).children('span').html(parseInt($(last).children('span').html()) + 1);
	}
	else
	{
		var li = $('<li>').addClass(key).attr('free', free).attr('compul', 0).append('<span>1</span>');			
		$(li).bind('click', function()
		{
			var val = $(this).children('span').html() - 1;
			if (val < 1)
			{
				var next = $(this).next('li');
				var prev = $(this).prev('li');
				if ($(next).attr('class') == $(prev).attr('class'))
				{
					$(prev).children('span').html( parseInt($(prev).children('span').html()) + parseInt($(next).children('span').html()) );
					$(next).remove();
				}
				$(this).remove();
			}
			else
				$(this).children('span').text(val);

			loadmaneuvers(div);
		});
		$(ul).append(li);
	}
}

function fillpanel(player, json)
{
	var div = $('div.action.'+player);
	$(div).children('p.title').html(json.name);
	$(div).children('img.ship').attr('src', json.image);
	$(div).find('div.spec span.hp').css('width', (json.hp / json.hpmax) * 180).html((json.hp / json.hpmax) * 100+'%');
	$(div).find('div.spec span.sp').css('width', (json.sp / json.spmax) * 180).html((json.sp / json.spmax) * 100+'%');
	$(div).find('div.spec span.maxpp').text(json.power);
	$(div).find('div.spec span.pp').text(json.power);
	$(div).find('div.onglet.pp input[name=ppool]').val(json.power);
	$(div).find('li.temp').remove();
    $.each(json.weapons, function(k, v) {
    	var li = $('<li class="temp"></li>');
       	var plus = $('<input type="button" value="+" class="plus" />').bind('click', function(){incrementPP(this)});
       	var minus = $('<input type="button" value="-" class="minus" />').bind('click', function(){decrementPP(this)});;
       	$(li).append('<span>'+v+' : </span>').append(plus).append(' <input type="text" value="0" name="pp[weapon]['+v+'][]" readonly="readonly" /> ').append(minus);
		$(div).find('div.onglet.pp ul').append(li);
    });	
}

function incrementPP(button)
{
	var input = $(button).next('input[type=text]');
	var value = $(input).val();
	var pp = $(button).parents('div.onglet.pp').find('input[name=ppool]');

	if ($(pp).val() > 0)
	{
		$(input).val(parseInt(value) + 1);
		$(pp).val(parseInt($(pp).val()) - 1);
		$(button).parents('div.action').find('span.pp').text($(pp).val());
	}
}

function decrementPP(button)
{
	var input = $(button).prev('input[type=text]');
	var value = $(input).val();
	var pp = $(button).parents('div.onglet.pp').find('input[name=ppool]');

	if ($(input).val() > 0)
	{
		$(input).val(parseInt(value) - 1);
		$(pp).val(parseInt($(pp).val()) + 1);
		$(button).parents('div.action').find('span.pp').text($(pp).val());
	}
}

function display_onglet(name)
{
	$('div.action div.onglet').addClass('hidden').css('display', 'none');
	$('div.action div.onglet.'+name).removeClass('hidden').css('display', 'block');
}
