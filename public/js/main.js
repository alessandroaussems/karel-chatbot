var messagelist=document.getElementById("messagelist");
var errormessage="Whoops! Dat heb ik niet verstaan!";
function sendMessage(e)
{
    if(event.key === 'Enter')
    {
        var message=e.value;
        CreateUserMessage(message);
        e.value = "";

            var xmlhttp;
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function(){
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
                    var response = this.responseText;
                    if(response=="ERROR")
                    {
                        CreateBotMessage(errormessage);
                    }
                    else
                    {
                        CreateBotMessage(response);
                    }
                }
            }
            xmlhttp.open("GET", "./chat/"+message, true);
            xmlhttp.send();
    }

}
function CreateUserMessage(message)
{
    var listitem=document.createElement("li");
    listitem.className="usermessage";
    message=document.createTextNode(message);
    listitem.appendChild(message);
    messagelist.appendChild(listitem);
}
function CreateBotMessage(message)
{
    var listitem=document.createElement("li");
    listitem.className="botmessage";
    message=document.createTextNode(message);
    listitem.appendChild(message);
    messagelist.appendChild(listitem);
}
$(document).ready(function(){
 //JSCODE HERE!
});