var messageList=document.getElementById("messagelist");
var pusher = new Pusher('d1252be87affbc8ff537', {cluster: 'eu', encrypted: false});
function sendMessage(value,event)
{
    if(event.keyCode === 13 || value==="getit")//IF ENTER KEY IS PRESSED OR SEND BUTTON
    {
        if(value==="getit")
        {
            var message=document.getElementsByClassName("userinput")[0].value;
        }
        else
        {
            var message=value;
        }
        createUserMessage(message);
        document.getElementsByClassName("userinput")[0].value="";
            var xmlhttp;
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function(){
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                {

                }
            };
            xmlhttp.open("GET", "../../sendliveresponse/"+message, true);
            xmlhttp.send();
    }

}
function createUserMessage(message)
{
    //ADDING THE USER'S MESSAGE TO THE DOM
    var listitem=document.createElement("li");
    listitem.className="usermessage";
    message=document.createTextNode(message);
    listitem.appendChild(message);
    messageList.appendChild(listitem);
    messageList.scrollIntoView(false);
}
function createAnswer(message)
{
        var listitem=document.createElement("li");
        listitem.className="botmessage";
        //message=document.createTextNode(message);
        listitem.innerHTML=message;
        messageList.appendChild(listitem);
        messageList.scrollIntoView(false);
}
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
function startPusherListening()
{
    pusher.subscribe(getCookie("chatsession")).bind('chatmessage', function(data)
    {
        createAnswer(data.message)
    });
}
document.addEventListener("DOMContentLoaded", function(event) {

});