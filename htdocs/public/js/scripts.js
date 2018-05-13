var messageList=document.getElementById("messagelist");
var BOTTHINKINGTIME=3000;
var welcomemessage="Hallo ik ben Karel! Stel je vragen maar!";
var allowToSend=true;
function sendMessage(value,event)
{
    if(event.keyCode == 13 || value=="getit")//IF ENTER KEY IS PRESSED OR SEND BUTTON
    {
        if(value="getit")
        {
            var message=document.getElementsByClassName("userinput")[0].value;
        }
        else
        {
            var message=value;
        }
        createUserMessage(message);
        document.getElementsByClassName("userinput")[0].value="";
        //MAKE SURE TYPEICON IS ALWAYS @ THE BOTTOM
        removeTypeIcon();//REMOVE OLD TYPE ICON
        createTypeIcon();//CREATE NEW TYPE ICON
        if(allowToSend)//CHECK IF NO PREVIOUS REQUEST IS STILL EXECUTING
        {
            allowToSend=false; // BECAUSE WE START EXECUTING A NEW REQUEST
            //AJAX CALL TO OUR API
            var xmlhttp;
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function(){
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
                    createAnswer(this.responseText);
                }
                if(xmlhttp.readyState == 4 && xmlhttp.status == 500)
                {
                    createAnswer("<p>Whoops er ging iets fout. Je mag nu een mail sturen naar <a href='mailto:alessandro.aussems@student.kdg.be'>alessandro.aussems@student.kdg.be</a></p>");
                }
            };
            xmlhttp.open("GET", "./chat/"+message, true);
            xmlhttp.send();
        }
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
}
function createAnswer(message)
{
        //WAIT BOTTHIKNINGTIME THEN REMOVE TYPING ICON AND CREATE RESPONSE
        setTimeout(function(){
            removeTypeIcon();
            var listitem=document.createElement("li");
            listitem.className="botmessage";
            //message=document.createTextNode(message);
            listitem.innerHTML=message;
            messageList.appendChild(listitem);
            allowToSend=true; // THIS REQUEST IS FINISHED SO THE NEXT ONE IS NOW ALLOWED
        }, BOTTHINKINGTIME);
}
function createTypeIcon()
{
    //CREATING TYPING ICON HERE
    var listitem=document.createElement("li");
    listitem.className="typing-indicator botmessage";
    for(var i=0;i<3;i++)
    {
        var span=document.createElement("span");
        listitem.appendChild(span);
    }
    messageList.appendChild(listitem);
}
function removeTypeIcon()
{
    var typingindicator=document.getElementsByClassName("typing-indicator")[0];
    if(typingindicator)//IF THE ELEMENT EXISTS THEN REMOVE
    {
        messageList.removeChild(typingindicator);
    }
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
function doKdGLogin(event)
{
    var login=document.getElementById("login").value;
    var password=document.getElementById("password").value;
    var button=document.getElementById("loginbutton");
    var sessionid=getCookie("chatsession");
    button.disabled=true;
    var xmlhttp;
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
            if(this.responseText)
            {
                document.getElementById("overlay").classList.remove("display");
                document.getElementById("kdgconnect").classList.add("nodisplay");
                createAnswer("Dankjewel om je KdG-account te koppelen! Ik kan je nu nog beter helpen!")
            }
            if(!this.responseText)
            {
                button.disabled=false;
                document.getElementById("loginerror").classList.add("display");
            }
        }
    }
    xmlhttp.open('PUT', "./kdglogin/", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("login="+login+"&password="+password+"&chatsession="+sessionid);

}
function showLoginForm(event)
{
    document.getElementById("overlay").classList.add("display");
}
function hideLoginForm(event)
{
    document.getElementById("overlay").classList.remove("display");
}
document.addEventListener("DOMContentLoaded", function(event) {
    if(getCookie("visits")!="" && getCookie("visits")==1)//CHECK IF COOKIE VISITS EXISTS AND IF FIRST TIME USER VISITS PAGE
    {
        setTimeout(function(){
            createTypeIcon();
            createAnswer(welcomemessage);
        }, 1000);
    }
});