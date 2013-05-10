function getXmlRequest()
	{
		if(window.XMLHttpRequest)
			{
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			}
		else if(window.ActiveXObject)
			{
				// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHttp");
			}
		return null;
	}

function getFormBody(xform)
	{
		var data=new Array();
		for(var i=0;i<xform.elements.length; i++)
			{
				var param=encodeURIComponent(xform.elements[i].name);
				param += "=";
				param += encodeURIComponent(xform.elements[i].value);
				data.push(param);
			} 
		return data.join("&");
	}

function displayResponseText(output)
	{
		var ele=document.getElementById("display_new_form");
		ele.innerHTML=output;
	}

