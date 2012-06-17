function postSend(action, params)
{
	var form = document.createElement('form');
	form.setAttribute('method', 'post');
	form.setAttribute('action', action);

	for(var key in params) {
		var field = document.createElement("input");
		
		field.setAttribute('type', 'hidden');
		field.setAttribute('name', key);
		field.setAttribute('value', params[key]);
		
		form.appendChild(field);
	}
	
	document.body.appendChild(form);
	form.submit();
}
function initTableRibs() {
	var tables = document.getElementsByTagName('table');
	
	for(var t = 0; t < tables.length; t++) 
	{
		if(tables[t].className.indexOf('no-ribs') > -1)
			continue;
		
		var rows = tables[t].getElementsByTagName('tr');
		
		for(var i = 0; i < rows.length; i += 2)
			rows[i].className += ' odd';
	}
}
function initSelectAllBoxs() 
{
	var boxs = document.getElementsByTagName('input');
	
	for(var i = 0; i < boxs.length; i++) 
	{
		if(boxs[i].type == 'checkbox' && boxs[i].value == 'selectAll')
			boxs[i].onclick = selectAll;
	}
}
function selectAll() 
{
	var parent = this;

	for(var i = 0; i < 100; i++) 
	{
		if(parent = parent.parentNode)
		{
			if(parent.tagName.toLowerCase() == 'table')
				break;
		}
		else
			return;
	}

	var boxs = parent.getElementsByTagName('input');
	
	for(var i = 0; i < boxs.length; i++) 
	{
		if(boxs[i].type == 'checkbox')
			boxs[i].checked = this.checked;
	}
}
function initCheckRow()
{
	$("#admin-form").each(function(index)
	{
		$(this).find("tbody").find("tr").click(function(event)
		{
			if ( !$( event.target ).is("input") )
			{
				$(this).find( 'input[type=checkbox]' ).trigger( 'click' )
			}
		})
	});
}
function initExternalLink()
{
	var links = document.getElementsByTagName('a');
	
	for(var i = 0; i < links.length; i++) 
	{
		if(links[i].getAttribute('rel') == 'external')
			links[i].target = '_blank';
	}
}

function parseUrl( url )
{
	// TODO : save this to notebook
	var params = decodeURIComponent( url.substr( url.indexOf("?") + 1 ).replace("+", " ") );
	var data = {};
	params = params.split("&");
	for (var i=0; i < params.length; i++)
	{
		temp = params[i].split("=");
		data[temp[0]] = temp[1];
	}
	return data;
}
function updateAjaxRequest( id, options )
{
	if ( options.type.toLowerCase() == 'post' )
	{
		var data = parseUrl( options.url ), base_url = options.url.replace( /\?.*/, '', options.url );
		
		base_url += '?ajax=' + data.ajax;
		delete data.ajax; 
		
		options.data = data;
		options.url = base_url;
	}
}
/*
jQuery(function($) 
{
	// initTableRibs();
	initSelectAllBoxs();
	initCheckRow();
	initExternalLink();
});*/