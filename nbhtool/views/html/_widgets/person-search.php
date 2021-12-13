<div class="input-group">
    <input id="person_search" class="form-control input-lg" type="text" placeholder="Suchen nach Personen" data-provide="typeahead" autocomplete="off">
    <span class="input-group-btn">
        <button class="btn btn-default btn-lg" type="button">Suchen</button>
    </span>
</div>
<div class="list-group" id="person_search_result"></div>

<script type="text/javascript">
$( document ).ready(function() {
    $('#person_search').on('input', function() {
        if($('#person_search').val().length > 0)
        {
            $.get(
                "<?= $async_url ?><?= (preg_match("/\/$/", $async_url) ? '?' : '&') ?>person_search_string=" + $('#person_search').val() , function(data) {
                    $('#person_search_result').html(data);
                }
            );
        }
        else
        {
            $('#person_search_result').html('');
        }
    });
})
</script>
