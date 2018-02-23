var messagelist=document.getElementById("messagelist");
function sendMessage(e)
{
    if(event.key === 'Enter')
    {
        var usermessageitem = document.createElement("li");
        usermessageitem.className = "usermessage";
        var usermessage = document.createTextNode(e.value);
        e.value = "";
        usermessageitem.appendChild(usermessage);
        messagelist.appendChild(usermessageitem);
    }

}
$(document).ready(function(){
 //JSCODE HERE!
});