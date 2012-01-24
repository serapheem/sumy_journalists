var ajax = {
	initialize: function(url, options){
		this.transport = this.getTransport();
		this.postBody = options.postBody || '';
		this.method = options.method || 'post';
		this.onComplete = options.onComplete || null;
		this.update = $(options.update) || null;
		this.request(url);
	},

	request: function(url){
		this.transport.open(this.method, url, true);
		this.transport.onreadystatechange = this.onStateChange.bind(this);
		if (this.method == 'post') {
			this.transport.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			if (this.transport.overrideMimeType) this.transport.setRequestHeader('Connection', 'close');
		}
		this.transport.send(this.postBody);
	},

	onStateChange: function(){
		if (this.transport.readyState == 4 && this.transport.status == 200) {
			if (this.onComplete) 
				setTimeout(function(){this.onComplete(this.transport);}.bind(this), 10);
			if (this.update)
				setTimeout(function(){this.update.innerHTML = this.transport.responseText;}.bind(this), 10);
			this.transport.onreadystatechange = function(){};
		}
	},

	getTransport: function() {
		if (window.ActiveXObject) return new ActiveXObject('Microsoft.XMLHTTP');
		else if (window.XMLHttpRequest) return new XMLHttpRequest();
		else return false;
	}
};

function addEvent(element, type, fn, useCapture) {
	if (element.addEventListener)
		element.addEventListener(type, fn, useCapture);
	else if (element.attachEvent)
		return element.attachEvent('on' + type, fn);
	else
		element['on' + type] = fn;
}

function tableRibs() {
	var tables = document.getElementsByTagName('table');
	
	for(var t = 0; t < tables.length; t++) {
		if(tables[t].className.indexOf('no-ribs') > -1)
			continue;
		
		var rows = tables[t].getElementsByTagName('tr');
		
		for(var i = 0; i < rows.length; i += 2)
			rows[i].className += ' odd';
		
	}
}

function listMenu() {
	if (document.all && document.getElementById) {
		var menu = document.getElementById('menu');
		
		for (i = 0; i < menu.childNodes.length; i++) {
			var node = menu.childNodes[i];
			
			if (node.nodeName == "LI") {
				addEvent(node, 'mouseover', function(){
					this.className += ' over';
				});
				addEvent(node, 'mouseout', function(){
					this.className = this.className.replace(' over', '');
				});
			}
		}
	}
}

function selectAll() {
	var parent = this;

	for(var i = 0; i < 100; i++) {
		if(parent = parent.parentNode)
		{
			if(parent.tagName.toLowerCase() == 'table')
			{
				break;
			}
		}
		else
			return;
	}

	var boxs = parent.getElementsByTagName('input');
	
	for(var i = 0; i < boxs.length; i++) {
		if(boxs[i].type == 'checkbox')
			boxs[i].checked = this.checked;
	}
}

function selectAllBoxs() {
	var boxs = document.getElementsByTagName('input');
	
	for(var i = 0; i < boxs.length; i++) {
		if(boxs[i].type == 'checkbox' && boxs[i].value == 'selectAll')
			boxs[i].onclick = selectAll;
	}
}

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

function externalLink()
{
	var links = document.getElementsByTagName('a');
	
	for(var i = 0; i < links.length; i++) {
		if(links[i].getAttribute('rel') == 'external')
			links[i].target = '_blank';
	}
}

addEvent(window, 'load', listMenu, false);
addEvent(window, 'load', tableRibs, false);
addEvent(window, 'load', externalLink, false);
addEvent(window, 'load', selectAllBoxs, false);