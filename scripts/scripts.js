function handler()
				{
					if(xmlhttp.readyState==4)		
						{
							if(xmlhttp.status==200)
								{
									document.getElementById("main_right").style.display="none";
									var ele=document.getElementById("rightcolm");
									ele.innerHTML=xmlhttp.responseText;
								}
							else
								{
									alert("error");
								}								
						}	
				}

//t							
function getXmlRequest()
	{
		var xmlhttp=null;
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

function submitLoginForm()
	{
		xmlhttp= new getXmlRequest();
		if(xmlhttp==null)
			{
				alert("ajax is not supported by your browser");
			}
		var xform=document.getElementById("auth_form");
		var xformbody=getFormBody(xform);
		xmlhttp.open("POST","parseAjaxForm.php",true);
		xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		xmlhttp.onreadystatechange=function() 
			{
				if(xmlhttp.readyState==4)
					{
						if(xmlhttp.status==200)
							{
								displayResponseText1(xmlhttp.responseText);
							}
						else
							{
								displayResponseText1(xmlhttp.statusText);
							}
					}
			}
		xmlhttp.send(xformbody);
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

function displayResponseText1(output)
	{
		document.getElementById("formcover").style.display="none";
		document.getElementById("formheader").style.display="none";
		var ele=document.getElementById("display_new_form");
		ele.innerHTML=output;
	}

//homescript.js
function submitPost()
	{
		var xmlhttp=getXmlRequest();
		if(xmlhttp!=null)
		{
			var value=document.getElementById("share_ta").value;
			if(value.match(/\S/))
			{
				var ele=encodeURIComponent(document.getElementById("share_ta").name);
				var txt=encodeURIComponent(value);
				var tosend=ele+"="+txt;
				xmlhttp.open("POST","submitpost.php",true);
				xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xmlhttp.setRequestHeader("Content-length", tosend.length);
				xmlhttp.send(tosend);
				xmlhttp.onreadystatechange=function()
					{
						if(xmlhttp.readyState==4)
							{
								if(xmlhttp.status==200)
									{
										//alert(xmlhttp.responseText);
										var li=document.createElement("li");
										li.innerHTML=xmlhttp.responseText;
										//li.className="li_items";																	Also works well
										li.setAttribute("class","li_items");
										var ul=document.getElementById("post_list");
										ul.insertBefore(li,ul.firstChild);
										document.getElementById("share_ta").value="";
										/*var ele=ul.firstChild;
										ul.firstChild=li;
										li.nextSibling=ele;*/
									}
							}
					}
			}
		}
	}


//common.js
function showNewPosts()
	{
		xmlhttp=getXmlRequest();
		if(xmlhttp!=null)
			{
				xmlhttp.open("GET","getnewfeed.php","true");
				xmlhttp.send();
				xmlhttp.onreadystatechange=function()
					{
						if(xmlhttp.readyState==4)
							{
								if(xmlhttp.status==200)
									{
//alert(xmlhttp.responseText);
										var li=document.createElement("li");
										li.innerHTML=xmlhttp.responseText;
										//li.className="li_items";																	Also works well
										li.setAttribute("class","li_items");
										var parentNode=document.getElementById("post_list");
									 var referenceNode=parentNode.firstChild;
										referenceNode.parentNode.insertBefore(li,referenceNode);
									}
							}
					}
			}
	}
			
//common.js
function callHomeFeed()
	{
		xmlhttp=getXmlRequest();
		if(xmlhttp!=null)
			{
				xmlhttp.open("GET","homefeed_default.php","true");
				xmlhttp.send();
				xmlhttp.onreadystatechange=function()
					{
						if(xmlhttp.readyState==4)
							{
								if(xmlhttp.status==200)
									{
										var li=document.createElement("li");
										li.innerHTML=xmlhttp.responseText;
										li.setAttribute("class","li_items");
										var parentNode=document.getElementById("post_list");
										var referenceNode=document.getElementById("post_list_fc");
										referenceNode.parentNode.insertBefore(li,referenceNode);
									}
							}
					}
			}
	}

//common.js
function showOlderPosts()
	{
		xmlhttp=getXmlRequest();
		if(xmlhttp!=null)
			{
				xmlhttp.open("GET","homefeed_older.php","true");
				xmlhttp.send();
				xmlhttp.onreadystatechange=function()
					{
						if(xmlhttp.readyState==4)
							{
								if(xmlhttp.status==200)
									{
										var li=document.createElement("li");
										var response=xmlhttp.responseText;
										li.innerHTML=xmlhttp.responseText;
										li.setAttribute("class","li_items");
										var parentNode=document.getElementById("post_list");
										var referenceNode=parentNode.lastChild;
										referenceNode.parentNode.insertBefore(li,referenceNode.nextSibling);
										if(response.match("No Older Posts"))
										{
											var ele=document.getElementById("showolderpostscover");
											ele.style.visibility="hidden";
										}										
									}
							}
					}
			}
	}

/*function savepic()
	{
document.write("hello");

		xmlhttp=getXmlRequest();
		if(xmlhttp!=null)
			{
				var ele=encodeURIComponent(document.getElementByName("picname").name);
				var txt=encodeURIComponent(document.getElementByName("picname").value);;
				var tosend=ele+"="+txt;
				newWindow.document.close();
				newWindow.close();
				xmlhttp.open("POST","addpic.php",true);
				xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xmlhttp.setRequestHeader("Content-length", tosend.length);
				xmlhttp.send(tosend);
				xmlhttp.onreadystatechange=function()
					{
						if(xmlhttp.readyState==4)
							{
								if(xmlhttp.status==200)
									{
										document.write(xmlhttp.responseText);
									}
							}
					}
			}
	}
*/
function showProfilePosts(id)
	{
		xmlhttp=getXmlRequest();
		if(xmlhttp!=null)
			{
				xmlhttp.open("GET","showprofileposts1.php?id="+id,"true");
				xmlhttp.send();
				xmlhttp.onreadystatechange=function()
					{
						if(xmlhttp.readyState==4)
							{
								if(xmlhttp.status==200)
									{
										var div=document.getElementById("showmtposts");
										div.innerHTML=xmlhttp.responseText;
									}
							}
					}
			}
	}
//common.js
function savecomment(num)
{

	xmlhttp=getXmlRequest();
	if(xmlhttp!=null)
	{
		var capture="commentta"+num;
		var txtarea="commentta";
		var id=encodeURIComponent("postid");
		var	value=encodeURIComponent(num);
		var send1=id+"="+value;
		var comment=encodeURIComponent(txtarea);
		var value=document.getElementById(capture).value;
		var txt=encodeURIComponent(value);
		if(value.match(/\S/))
		{
			var send2=comment+"="+txt;
			var tosend=send1+"&"+send2;

			xmlhttp.open("POST","submitcomment.php",true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.setRequestHeader("Content-length",tosend.length);
			xmlhttp.send(tosend);
			xmlhttp.onreadystatechange=function()
			{
				if(xmlhttp.readyState==4)
				{
					if(xmlhttp.status==200)
					{
						var capture2="commentlist"+num;
						var li=document.createElement("li");
						li.innerHTML=xmlhttp.responseText;
						var parentNode=document.getElementById(capture2);
					 var referenceNode=parentNode.firstChild;
						referenceNode.parentNode.insertBefore(li,referenceNode);
						document.getElementById(capture).value="";
					}
				}
			}
		}			
	}
}

//common.js
function showMtPosts(mtvalue)
{
	
	var xmlhttp=getXmlRequest();
	if(xmlhttp!=null)
	{
		xmlhttp.open("GET","getmtposts.php?mtype="+mtvalue,"true");
		xmlhttp.send();
		xmlhttp.onreadystatechange=function()
		{
			if(xmlhttp.readyState==4)
			{
				if(xmlhttp.status==200)
				{
					var ele=document.getElementById("main_right");
					ele.innerHTML=xmlhttp.responseText;
//					document.getElementById("homepagecontent").style.visibility="hidden";
				}
			}
		}
	}
}
