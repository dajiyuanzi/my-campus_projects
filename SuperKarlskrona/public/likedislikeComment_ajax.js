// all achieved by Yuan Ji to display the likes with topic id
		function likeComment(cid){
			if (window.XMLHttpRequest)
			{
				// IE7+, Firefox, Chrome, Opera, Safari
				x=new XMLHttpRequest();
			}
			else
			{
				//IE6, IE5
				x=new ActiveXObject("Microsoft.XMLHTTP");
			}
			x.onreadystatechange=function()
			{
				if (x.readyState==4 && x.status==200)
				{
					document.getElementById("likecid"+cid).innerHTML=x.responseText;
				}
			}
			x.open("POST","../backend/likeComment.php",true);
			x.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        	x.send("cid="+cid);
		}

		function dislikeComment(cid){
			if (window.XMLHttpRequest)
			{
				// IE7+, Firefox, Chrome, Opera, Safari
				x=new XMLHttpRequest();
			}
			else
			{
				//IE6, IE5
				x=new ActiveXObject("Microsoft.XMLHTTP");
			}
			x.onreadystatechange=function()
			{
				if (x.readyState==4 && x.status==200)
				{
					document.getElementById("dislikecid"+cid).innerHTML=x.responseText;
				}
			}
			x.open("POST","../backend/dislikeComment.php",true);
			x.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        	x.send("cid="+cid);
		}
