// JavaScript Document


function showHide(shID) {
	if (document.getElementById(shID)) {
		if (document.getElementById(shID+'-show').style.display != 'none') {
			document.getElementById(shID+'-show').style.display = 'none';
			document.getElementById(shID).style.display = 'block';
		}
		else {
			document.getElementById(shID+'-show').style.display = 'inline';
			document.getElementById(shID).style.display = 'none';
		}
	}
}



function displayRow() 
{ 
    var loc=document.form1; 
    var c=loc.selectMenu.options[loc.selectMenu.selectedIndex].value; 
    if (c=="AGENT") 
    { 
        document.getElementById('optionRow').style.display=""; 
    } 
	else if (c=="NETAGENT") 
    { 
        document.getElementById('optionRow').style.display=""; 
    } 
	
    else
    { 
        document.getElementById('optionRow').style.display="none"; 
    } 
} 