var pusher = new Pusher('d1252be87affbc8ff537', {cluster: 'eu', encrypted: false});
function startPusherListening()
{
    pusher.subscribe("newchat").bind('newchatid', function(data)
    {
        createNewChat(data.id);
    });
    pusher.subscribe("newchat").bind('oldchatid', function(data)
    {
        removeOldChat(data.id);
    });
}
function createNewChat(id)
{
    //ADDING THE USER'S MESSAGE TO THE DOM
    var listitem=document.createElement("li");
    var link=document.createElement("a");
    link.setAttribute('href',"/livechat/"+id)
    link.innerHTML=id;
    listitem.appendChild(link);
    document.getElementsByClassName("options")[0].appendChild(listitem);
}
function removeOldChat(id)
{
    console.log("executed");
    var listitems=document.getElementsByTagName("li");
    for(var i=0;i<listitems.length;i++)
    {
        if(listitems[i].innerHTML==id)
        {
            listitems[i].parentNode.removeChild(listitems[i]);
        }
    }
}
document.addEventListener("DOMContentLoaded", function(event) {
    startPusherListening();
});