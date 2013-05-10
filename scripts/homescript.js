function addpic()
{
//			var newWindow=window.open("addpic.php","addpicwindow","width=400,height=200,left=400,top=300");
	var link=document.getElementById("addpiccover");
	link.style.visibility="hidden";
	var browsefile=document.getElementById("browsefile");
	html="<form name=\"picform\" id=\"picform\" method=\"POST\" action=\"addpic.php\" enctype=\"multipart/form-data\"><label for=\"add pic\">Add:</label><input type=\"file\" name=\"filename\" id=\"filename\" size=\"8\"><input type=\"submit\" name=\"picbtn\" value=\"Done\"></form>";
	browsefile.innerHTML=html;
}


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


