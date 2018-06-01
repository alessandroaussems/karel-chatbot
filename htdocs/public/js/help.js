var next=document.getElementById("next");
var previous=document.getElementById("previous");
var helpitems=["Mijn meldingen","Dagmenu","Afwezige docenten","Printen","Mijn punten", "Prikbord","Wie is","Medewerker","Mijn campus"];
function slide(direction)
{
    var currentindex=0;
    var helplength=helpitems.length;
    var next=0;
    for (var i=0;i<helplength;i++)
    {
        if(helpitems[i]===document.getElementById("currenthelptext").innerHTML)
        {
            currentindex=i;
        }
    }
    if(direction==="forward")
    {
        if(currentindex!=helplength-1)
        {
            next=currentindex+1;
        }
        else
        {
            next=0;
        }
    }
    if(direction==="backwards")
    {
        if(currentindex!=0)
        {
            next=currentindex-1;
        }
        else
        {
            next=helplength-1;
        }
    }
    document.getElementById("currenthelptext").innerHTML=helpitems[next];
}
function showHelp(event)
{
    if(document.getElementById("help").classList.contains("showhelp"))
    {
        document.getElementById("help").classList.add("hidehelp");
        document.getElementById("help").classList.remove("showhelp");
    }
    else
    {
        document.getElementById("help").classList.add("showhelp");
        document.getElementById("help").classList.remove("hidehelp");
    }
}