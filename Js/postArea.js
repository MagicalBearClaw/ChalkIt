var g = {};

function Initialize()
{
	// creates the modal dialog used to create a sticky.
	$("#dialog-form").dialog({
    modal: true,
    draggable: false,
    resizable: false,
    show: 'blind',
    hide: 'blind',
    width: 400,
    autoOpen: false,
    dialogClass: 'ui-dialog-osx',
    buttons: {
        "Create Sticky": function() 
        {
        	// do validation of what was put in the text area.
        	// if any validation errors then display errors.
        	var text = $("#createSticky").val();
        	if(validateText(text))
        	{
        		CreateSticky(text);
            	$(this).dialog("close");
            	$("#createSticky").val("");
        	}
        	else
        	{
				$("#textError").removeClass("hide");
				$("#errorBtn").click(function()
				{
					// here we need to rebuild the bootstrap alert because on dismiss
					// it removes it from the html.
					$("#createStickyForm").prepend($('<div/>')
				    .attr("id", "textError")
				    .addClass("hide alert alert-danger alert-dismissible")
				    .attr("role", "alert").append($('<button></button>').attr('id','errorBtn').attr('type', 'button')
				    	.attr("data-dismiss","alert").attr('aria-label','close').addClass('close')
				    	.append($('<span/>').attr('aria-hidden','true').html('&times'))));

					$("#textError").append($("<strong>Error!</strong>"));
				 	$("#textError").append( document.createTextNode("The text cannot be empty or be greater than 280 charecters."));
				});
        	}

        },
        "Cancel": function()
        {
        	// just set the textarea with an empty string.
            $("#createSticky").val("");
        	$(this).dialog("close");
        }
    }
	});

	g.postItBoard = document.getElementById("postIt-container");
	g.createBtn = document.getElementById("createBtn");
	g.createBtn.addEventListener('click',OpenDialog);
	// Creates all stickies that were retrieved from the databse.
	CreateAllStickies();
}

/// validates text for the text area.
function validateText(text)
{
	if(text != "" && text.length <= 280)
	{
		return true;
	}
	return false;
}


function CreateAllStickies()
{
	var xhttpReq = new XMLHttpRequest();
	xhttpReq.onreadystatechange = function() 
	{
	    if (xhttpReq.readyState == 4 && xhttpReq.status == 200) 
	    {
	    	var stickyResponse = JSON.parse(xhttpReq.responseText);
	    	// if we are ok to create stickies.
	    	if(stickyResponse.msg == "SUCCESS")
	    	{
	    		var zindex = 1;
	    		var stickies = stickyResponse.stickies;
				for (var i = 0; i < stickies.length; i++) 
				{
					// Creates a sticky from scatch.
					var newSticky = document.createElement("div");
					newSticky.classList.add("chalk-text");
					newSticky.classList.add("postIt-note");
					newSticky.classList.add("ui-widget-content");
					newSticky.style.zIndex = zindex.toString();
					newSticky.setAttribute("id", stickies[i].id);

					// creates the delete button for the sticky.
					var button =  document.createElement("button");
					button.setAttribute("id", "closeBtn");
					button.setAttribute("type", "button");
					button.setAttribute("data-dismiss", "alert");
					button.setAttribute("aria-label", "close");
					button.classList.add("close");
					// creates the actualy 'x' for the button
					var text = document.createElement("span");
					text.setAttribute("aria-hidden", "true");
					text.innerHTML= "&times";
					text.classList.add("close-button");
					button.appendChild(text);
					newSticky.appendChild(button);
					var br = document.createElement("br");
					newSticky.appendChild(br);
					// creates the p tag and add the text for sticky..
					var text = document.createElement("p");
					text.innerHTML = stickies[i].text;
					newSticky.appendChild(text);
					newSticky.appendChild(text);
					var id = stickies[i].id;
					g.postItBoard.appendChild(newSticky);

					// add the event handler for delteing a sticky.
					$("#"+ id + "> #closeBtn").click(function(e)
					{
						var clickedId = $(this).parent().attr("id")
						DeleteSticky(clickedId);
					});

					// handle the default postiion, and make the sticky draggable.
					$("#" + id).offset({ top: stickies[i].top, left: stickies[i].left });
					$("#" + id).draggable({ containment: "#postIt-container", scroll: false });
					
					// add the event handler for the updating of a 
					// sticky when the user stops dragging the sticky.
					$( "#" + id).draggable({
					  stop: function( event, ui ) 
					  {
					  	 var eventId = event.target.id;
					  	 var el = $( "#" + eventId);
					  	 var pos = el.position();
					  	 UpdateSticky(eventId, pos.top, pos.left);
					  }
					});

					zindex++;
				}
	    	}
	    	
    	}
  }
	xhttpReq.open("POST", "getStickies.php", true);
	xhttpReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttpReq.send();
}

// opens the modal dialog for creating a sticky.
function OpenDialog()
{
	$( "#dialog-form").removeClass("hide");
	$( "#dialog-form").dialog( "open" );
}

// creates a new sticky
function CreateSticky(actualText)
{	
	var args = "top=" + 103 + "&left=" +  15 + "&text=" + actualText;
	var xhttpReq = new XMLHttpRequest();
	xhttpReq.onreadystatechange = function() 
	{
	    if (xhttpReq.readyState == 4 && xhttpReq.status == 200) 
	    {
	    	var stickyResponse = JSON.parse(xhttpReq.responseText);
	    	if(stickyResponse.msg == "FAILED")
	    	{
	    		// something hasd gone wrong redirect to the index.
	    		window.location.replace("index.php");
	    	}
	    	if(stickyResponse.msg == "SUCCESS")
	    	{
	    		$("#postIt-container").empty();
	    		CreateAllStickies();
	    	}
    	}
  	}
	xhttpReq.open("POST", "createSticky.php", true);
	xhttpReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttpReq.send(args);
}
// update a sticky given its id, top and left position.
function UpdateSticky(id, top, left)
{
	var args = "id=" + id + "&top=" + top + "&left=" + left;
	var xhttpReq = new XMLHttpRequest();
	xhttpReq.open("POST", "updateSticky.php", true);
	xhttpReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttpReq.send(args);
}
// delete a sticky given its id.
function DeleteSticky(id)
{
	console.log("this id is:" + id);
	var args = "id=" + id;
	var xhttpReq = new XMLHttpRequest();
	xhttpReq.open("POST", "deleteSticky.php", true);
		xhttpReq.onreadystatechange = function() 
	{
	    if (xhttpReq.readyState == 4 && xhttpReq.status == 200) 
	    {
	    	var stickyResponse = JSON.parse(xhttpReq.responseText);
	    	if(stickyResponse.msg == "FAILED")
	    	{
	    		// something hasd gone wrong redirect to the index.
	    		window.location.replace("index.php");
	    	}
	    	else if(stickyResponse.msg == "SUCCESS")
	    	{
	    		$("#postIt-container").empty();
	    		CreateAllStickies();
	    	}
    	}
  	}
	xhttpReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttpReq.send(args);
}

window.onload = Initialize;