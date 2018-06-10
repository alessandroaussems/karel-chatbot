setInterval(function()
{
    var xmlhttp;
    xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "./pulse/", true);
    xmlhttp.send();
}, 60000);