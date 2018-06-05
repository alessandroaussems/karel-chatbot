<div id="overlay">
    <div class="login">
        <span id="close" onclick="hideLoginForm(this.event)">n</span>
        <h3>Inloggen bij KdG</h3>
        <small>Log hier in met je KdG-account en Karel-Chatbot wordt nog slimmer!</small>
        <small id="loginerror">Whoops! Er iets fout gegaan! Ben je zeker dat al je gegevens juist zijn?</small>
        <input type="text" name="login" id="login">
        <input type="password" name="password" id="password">
        <span id="loading">k</span>
        <button type="submit" name="login" id="loginbutton" onclick="doKdGLogin(this.event)">Login</button>
    </div>
</div>