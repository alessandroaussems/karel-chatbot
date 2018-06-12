setInterval(function()
{
    var xmlhttp;
    xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "/adminpulse/", true);
    xmlhttp.send();
}, 60000);