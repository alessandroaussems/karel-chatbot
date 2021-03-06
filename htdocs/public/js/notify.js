function startListeningForNewChatMessage()
{
    for(var i=0;i<sessions.length;i++)
    {
        if(window.location.pathname.indexOf(sessions[i].session_id)<=-1)
        {
            pusher.subscribe(sessions[i].session_id).bind('usermessage', function(data)
            {
                if(data.message!="stop")
                {
                    document.getElementById("message").innerHTML=data.message.substr(0,200)+"...";
                    document.getElementById("view").href="./livechat/"+data.id;
                    document.getElementById("sessionlink").href="./livechat/"+data.id;
                    document.getElementById("sessionlink").innerHTML=data.id;
                    document.getElementById("notify").classList.remove("hidenotification");
                    document.getElementById("notify").classList.add("shownotification");
                    setTimeout(function(){
                        document.getElementById("notify").classList.remove("shownotification");
                        document.getElementById("notify").classList.add("hidenotification");
                    }, 5000);
                }
            });
        }
    }
}
document.addEventListener("DOMContentLoaded", function(event) {
    startListeningForNewChatMessage();
});