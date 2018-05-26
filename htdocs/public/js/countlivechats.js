var pusher = new Pusher('d1252be87affbc8ff537', {cluster: 'eu', encrypted: false});
function startPusherListening()
{
    pusher.subscribe("newchat").bind('chatcount', function(data)
    {
       changeChatnumber(data.number);
    });
}
function changeChatnumber(number)
{
    document.getElementById("chatnumber").innerHTML=number;
}
document.addEventListener("DOMContentLoaded", function(event) {
    startPusherListening();
});