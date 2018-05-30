<div id="notify">
        <h5>Nieuw chatbericht:</h5>
        <p id="message">Hier komt een voorbeeld van het bericht</p>
        <a href="#" id="view">Bekijk</a>
</div>
<script type='text/javascript'>
    <?php
    echo "var sessions = ". json_encode($livechats) . ";\n";
    ?>
</script>
<script src="{{asset('js/notify.js')}}"></script>