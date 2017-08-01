// all achieved by Yuan Ji to display the likes with topic id
		function like(tid){
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
					document.getElementById("liketid"+tid).innerHTML=x.responseText;
				}
			}
			x.open("POST","../backend/like.php",true);
			x.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        	x.send("tid="+tid);
		}

		function dislike(tid){
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
					document.getElementById("disliketid"+tid).innerHTML=x.responseText;
				}
			}
			x.open("POST","../backend/dislike.php",true);
			x.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        	x.send("tid="+tid);
		}