		function submitForm()
							{
								var xmlhttp=null;
								xmlhttp= new getXmlRequest();
								if(xmlhttp==null)
									{
										alert("ajax is not supported by your browser");
									}
									var xform=document.getElementById("auth_form");
									var xformbody=getFormBody(xform);
									xmlhttp.open("POST","parseForm.php",true);
									xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
									xmlhttp.onreadystatechange=function() 
									{
										if(xmlhttp.readyState==4)
											{
												if(xmlhttp.status==200)
													{
														displayResponseText(xmlhttp.responseText);
													}
												else
													{
														displayResponseText(xmlhttp.statusText);
													}
											}
									}
									xmlhttp.send(xformbody);
								}
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
		return xmlhttp;
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
