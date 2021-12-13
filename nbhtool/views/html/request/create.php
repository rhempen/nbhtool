<h1><span class="db-id">Anfrage: </span>Neue Anfrage erfassen</h1>
<form enctype="multipart/form-data" method="post" action="<?= \Layout\Html\Tools::url('request/save') ?>">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Anfragende/-r Klient/-in</h3>
        </div>
        <div class="panel-body">
            <p>Diese Anfrage wird von dieser/-m Klienten/-in eingereicht</p>
            <?php if(isset($client)): ?>
            <?php \Layout\Html\Tools::widget(
            'person-card',
            [
                "person" => $client->person(),
                "menu" => 'select_as_client'
            ]) 
            ?>
            <?php \Layout\Html\Tools::widget(
            'form/input-hidden',
            [
                "id" => "client_id",
                "data" => $client->field('id')->data(),
            ]) ?>
            <?php else: ?>
            <?php \Layout\Html\Tools::widget(
            'person-search',
            [
                "async_url" => \Layout\Html\Tools::url('async/clientsearch')
            ]) ?>
            <?php endif; ?>
        </div>
    </div>
    <?php if(isset($client)): ?>
    <div class="row">
        <div class="col-md-6"> 
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Kategorie der Anfrage</h3>
                </div>
                <div class="panel-body">
                    <p>Die Kategorie der Anfrage entspricht</p>
                    <?php \Layout\Html\Tools::widget(
                    'form/input-select',
                    [
                        "title" => "",
                        "id" => "service_id",
                        "data" => \RT::$params->get('service_id'),
                        "empty_first" => "Bitte w&auml;hlen...",
                        "list" => $service_list,
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6"> 
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Hauptt&auml;tigkeiten</h3>
                </div>
                <div class="panel-body">
                    <p>Was sind die Hauptt&auml;tigkeiten innerhalb der Anfragekategorie</p>
                    <div id="sub-service-form">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Detailbeschreibung</h3>
        </div>
        <div class="panel-body">
            <?php \Layout\Html\Tools::widget(
            'form/input-textarea',
            [
                "title" => "",
                "id" => "note",
                "data" => \RT::$params->get('note'),
                "rows" => 6,
            ]) ?>
        </div>
    </div>
    <button name="form_submitd_request" type="submit" class="btn btn-primary">Erfassen</button>
    <?php endif; ?>
</form>

<!-- Local Javascript -->

    <script type="text/javascript">
        $( document ).ready(function() {
            $('#service_id').on('change', function() {
                $.get(
                    "<?= \Layout\Html\Tools::url('async/subserviceform') ?>?service_id=" + $('#service_id').find(":selected").val(), function(data) {
                        $('#sub-service-form').html(data);
                    }
                );
            });
        })

        $( document ).ready(function() {
            $('#person_search').on('input', function() {
                if($('#person_search').val().length > 0)
                {
                    $.get(
                        "<?= \Layout\Html\Tools::url('async/clientsearch') ?>?person_search_string=" + $('#person_search').val(), function(data) {
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
