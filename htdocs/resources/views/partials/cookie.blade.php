@if(!isset($_COOKIE["cookienotice"]))
<div id="cookie">
    <p>{{ config('app.name') }} maakt gebruik van <a href="https://cookiesandyou.com/" target="_blank">cookies</a> om je surfervaring te verbeteren.</p>
    <span id="closecookie" onclick="closeCookienotice()">Oke!</span>
</div>
@endif