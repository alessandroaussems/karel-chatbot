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
        if(!/[a-zA-Z]/.test(message))
        {
            return
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
            xmlhttp.open("GET", "/sendliveresponse/"+encodeURIComponent(message)+"/sessionid/"+getSessionidFromUrl(), true);
            xmlhttp.send();
    }

}
function getSessionidFromUrl()
{
    return window.location.pathname.split("/")[2];
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
function startPusherListening()
{
    pusher.subscribe(getSessionidFromUrl()).bind('usermessage', function(data)
    {
        if(data.message=="stop")
        {
            confirm("De gebruiker heeft de sessie beïndigd. Dit betekend dat hij niet langer hulp nodig heeft van een KdG medewerker. Je wordt omgeleid naar de overzichtspagina.");
            window.location="/livechats";
        }
        createAnswer(data.message)
    });
}
document.addEventListener("DOMContentLoaded", function(event) {
    startPusherListening();
});