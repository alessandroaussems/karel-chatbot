var messageList=document.getElementById("messagelist");
var BOTTHINKINGTIME=3000;
var welcomemessage="Hallo ik ben Karel! Stel je vragen maar! Weet je niet wat vragen? Dan kan je altijd 'Help' typen!";
var allowToSend=true;
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
        if(getCookie("listen")!="true")
        {
            //MAKE SURE TYPEICON IS ALWAYS @ THE BOTTOM
            removeTypeIcon();//REMOVE OLD TYPE ICON
            createTypeIcon();//CREATE NEW TYPE ICON
        }
        if(allowToSend)//CHECK IF NO PREVIOUS REQUEST IS STILL EXECUTING
        {
            if(getCookie("listen")!="true")
            {
                allowToSend=false; // BECAUSE WE START EXECUTING A NEW REQUEST
            }
            //AJAX CALL TO OUR API
            var xmlhttp;
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function(){
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                {
                    if(this.responseText=="<p> <p>Oke! No hard feelings...Vanaf nu ben je aan het chatten met een medewerken van KdG. Stel je vragen maar! Om de sessie te beeïndigen kan je altijd 'Medewerker stop' ingeven.</p> </p>")
                    {
                        startPusherListening();
                    }
                    if(this.responseText=="<p>Hopelijk heeft de KdG-Medewerker je kunnen helpen...Vanaf nu kan je al je vragen weer gewoon aan mij stellen, Karel dé chatbot van KdG!</p>")
                    {
                        stopPusherListening();
                    }
                    if(this.responseText!="live")
                    {
                        createAnswer(this.responseText);
                    }
                }
                if(xmlhttp.readyState == 4 && xmlhttp.status == 500)
                {
                    createAnswer("<p>Whoops er ging iets fout. Je mag nu een mail sturen naar <a href='mailto:alessandro.aussems@student.kdg.be'>alessandro.aussems@student.kdg.be</a></p>");
                }
            };
            xmlhttp.open("GET", "./chat/"+encodeURIComponent(message), true);
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
    messageList.scrollIntoView(false);
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
        messageList.scrollIntoView(false);
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
    messageList.scrollIntoView(false);
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
    var loader=document.getElementById("loading");
    var sessionid=getCookie("chatsession");
    button.disabled=true;
    button.classList.add("nodisplay");
    loader.classList.add("display");
    var xmlhttp;
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
            var response =JSON.parse(this.responseText);
            if(response)
            {
                document.getElementById("overlay").classList.remove("display");
                document.getElementById("kdgconnect").classList.add("nodisplay");
                createAnswer("Dankjewel om je KdG-account te koppelen! Ik kan je nu nog beter helpen!")
            }
            if(!response)
            {
                button.disabled=false;
                button.classList.remove("nodisplay");
                loader.classList.remove("display");
                document.getElementById("loginerror").classList.add("display");
            }
        }
    };
    xmlhttp.open('PUT', "./kdglogin", true);
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
function startPusherListening()
{
    pusher.subscribe(getCookie("chatsession")).bind('chatmessage', function(data)
    {
        createAnswer(data.message)
    });
}
function stopPusherListening()
{
    pusher.subscribe(getCookie("chatsession")).unbind("chatsession");
}
document.addEventListener("DOMContentLoaded", function(event) {
    if(getCookie("visits")!="" && getCookie("visits")==1)//CHECK IF COOKIE VISITS EXISTS AND IF FIRST TIME USER VISITS PAGE
    {
        setTimeout(function(){
            createTypeIcon();
            createAnswer(welcomemessage);
        }, 1000);
    }
    if(getCookie("listen")==="true")
    {
        startPusherListening();
    }
});