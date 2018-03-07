var MESSAGELIST=document.getElementById("messagelist");
var BOTTHINKINGTIME=3000;
var errormessage="Whoops! Dat heb ik niet verstaan!";
function sendMessage(value,event)
{
    console.log(event);
    //IF ENTER KEY IS PRESSED
    if(event.keyCode == 13)
    {
        var message=value;
        CreateUserMessage(message);
        document.getElementsByClassName("userinput")[0].value="";
            //AJAX CALL TO OUR API
            var xmlhttp;
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function(){
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
                    var response = this.responseText;
                    if(response=="ERROR")
                    {
                        CreateAnswer(errormessage);
                    }
                    else
                    {
                        CreateAnswer(response);
                    }
                }
            }
            xmlhttp.open("GET", "./chat/"+message, true);
            xmlhttp.send();
    }

}
function CreateUserMessage(message)
{
    //ADDING THE USER'S MESSAGE TO THE DOM
    var listitem=document.createElement("li");
    listitem.className="usermessage";
    message=document.createTextNode(message);
    listitem.appendChild(message);
    MESSAGELIST.appendChild(listitem);
}
function CreateAnswer(message)
{
        //CREATING TYPING ICON HERE
        var listitem=document.createElement("li");
        listitem.className="typing-indicator botmessage";
        for(var i=0;i<3;i++)
        {
            var span=document.createElement("span");
            listitem.appendChild(span);
        }
        MESSAGELIST.appendChild(listitem);
        //WAIT BOTTHIKNINGTIME THEN REMOVE TYPING ICON AND CREATE RESPONSE
        setTimeout(function(){
            MESSAGELIST.removeChild(document.getElementsByClassName("typing-indicator")[0]);
            var listitem=document.createElement("li");
            listitem.className="botmessage";
            message=document.createTextNode(message);
            listitem.appendChild(message);
            MESSAGELIST.appendChild(listitem);
        }, BOTTHINKINGTIME);
}
$(document).ready(function(){
 //JSCODE HERE!
});