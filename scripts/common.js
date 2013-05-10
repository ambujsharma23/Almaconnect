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

function callUpPart(pagetype)
	{
		if(pagetype=="home")
			{
				document.getElementById("rightupper").innerHTML="<div name=\"share_form_cover\" id=\"share_form_cover\"><form name=\"share_form\" id=\"share_form\" method=\"POST\" onsubmit=\"submitPost(); return false;\"><ul name=\"share_form_list\" id=\"share_form_list\" class=\"margintenpx\"><li><textarea name=\"share_ta\" id=\"share_ta\" rows=\"5\" cols=\"64\"></textarea></li><li><div name=\"share_btn_cover\" id=\"share_btn_cover\"><input type=\"submit\" value=\"submit\" name=\"share_btn\" id=\"share_btn\"/></div></li></ul></form></div>";
			}
		return;
	}

function callFeed(pagetype)
	{
			xmlhttp=getXmlRequest();
			if(xmlhttp!=null)
				{
					if(pagetype=="home")
						{
							xmlhttp.open("GET","homefeed_default.php","true");
						}
					else if(pagetype=="student" || pagetype=="alumini" || pagetype=="faculty")
						{
							xmlhttp.open("GET","getmtposts.php?mtype="+pagetype,"true");
						}
					xmlhttp.send();
					xmlhttp.onreadystatechange=function()
						{
							if(xmlhttp.readyState==4)
								{
									if(xmlhttp.status==200)
										{
//											var li=document.createElement("li");
//											li.innerHTML=xmlhttp.responseText;
//											li.setAttribute("class","li_items");
											var parentNode=document.getElementById("post_list");
											parentNode.innerHTML=xmlhttp.responseText;
//												var ele2=document.getElementById("toadd_111");
//	ele2.innerHTMl="bhai ambuj";
//											var referenceNode=document.getElementById("post_list_fc");
//											referenceNode.parentNode.insertBefore(li,referenceNode);
										}
								}
						}
				}
		
	}
//to check
function showNewPosts(pagetype)
	{
		xmlhttp=getXmlRequest();
		if(xmlhttp!=null)
			{
				if(pagetype=="home")
				{
					xmlhttp.open("GET","getnewfeed.php","true");
				}
				else if(pagetype=="student" || pagetype=="alumini" || pagetype=="faculty")
						{
							xmlhttp.open("GET","getnewmtposts.php?mtype="+pagetype,"true");
						}

				xmlhttp.send();
				xmlhttp.onreadystatechange=function()
					{
						if(xmlhttp.readyState==4)
							{
								if(xmlhttp.status==200)
									{
//alert(xmlhttp.responseText);
										if(xmlhttp.responseText!="")
										{
											var li=document.createElement("li");
											li.innerHTML=xmlhttp.responseText;
											//li.className="li_items";																	Also works well
											//li.setAttribute("class","li_items");
											var parentNode=document.getElementById("post_list");
										 var referenceNode=parentNode.firstChild;
											referenceNode.parentNode.insertBefore(li,referenceNode);
										}
										else
											return;
									}
							}
					}
			}
	}
//to check
function showOlderPosts(pagetype)
	{
		xmlhttp=getXmlRequest();
		if(xmlhttp!=null)
		{
			if(pagetype=="home")
			{
				xmlhttp.open("GET","homefeed_older.php","true");
			}
			else if(pagetype=="student" || pagetype=="alumini" || pagetype=="faculty")
			{
				xmlhttp.open("GET","getoldermtposts.php?mtype="+pagetype,"true");
			}
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

function savecomment(num)
{
	xmlhttp=getXmlRequest();
	if(xmlhttp!=null)
	{
		var capture="commentta_"+num;
		var id=encodeURIComponent("postid");
		var	value=encodeURIComponent(num);
		var send1=id+"="+value;
		var comment=encodeURIComponent("commentta");
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
						var capture2="commentlist_"+num;
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

function getNewComments(poid)
{
	var xmlhttp=getXmlRequest();
	if(xmlhttp!=null)
	{
		var postid=encodeURIComponent("postid");
		var postidvalue=encodeURIComponent(poid);
//		var tosend=postid+"="+postidvalue;
		xmlhttp.open("GET","getnewcomments.php?"+postid+"="+postidvalue,"true");
		xmlhttp.send();
		xmlhttp.onreadystatechange=function()
		{
			if(xmlhttp.readyState==4)
			{
				if(xmlhttp.status==200)
				{
					var capture2="commentlist_"+poid;
					var li=document.createElement("li");
					li.innerHTML=xmlhttp.responseText;
					var parentNode=document.getElementById(capture2);
				 var referenceNode=parentNode.firstChild;
					referenceNode.parentNode.insertBefore(li,referenceNode);
				}
			}
		}
	}
}

function getAll(pagetype)
{
	xmlhttp=getXmlRequest();
	if(xmlhttp!=null)
		{
			if(pagetype=="home")
			{
				xmlhttp.open("GET","getnewfeed.php","true");
			}
/*			else if(pagetype=="student" || pagetype=="alumini" || pagetype=="faculty")
			{
				xmlhttp.open("GET","getnewmtposts.php?mtype="+pagetype,"true");
			}
*/

			xmlhttp.send();

			xmlhttp.onreadystatechange=function()
				{
					if(xmlhttp.readyState==4)
						{
							if(xmlhttp.status==200)
								{
									if(xmlhttp.responseText!="")
									{
										var obj=JSON.parse(xmlhttp.responseText);
										for(key in obj.posts)
										{ 
											var li=document.createElement("li");
											li.innerHTML=obj.posts[key];
											var parentNode=document.getElementById("post_list");
										 var referenceNode=parentNode.firstChild;
											referenceNode.parentNode.insertBefore(li,referenceNode);
										}
									}
									else
										return;
								}
						}
				}
			}
}
