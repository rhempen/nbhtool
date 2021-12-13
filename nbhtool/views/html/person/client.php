<?php include('_persontitle.php') ?>
<?php include('_personnav.php') ?>
<nav class="navbar navbar-default navbar-sub">
    <ul class="nav navbar-nav">
        <li>
            <a href="<?= \Layout\Html\Tools::url('request/create',['client_id'=> $person->client()->id()]) ?>">
                Neue Anfrage erfassen
            </a>
        </li>
    </ul>
</nav>
<?php if($person->client()->is()): ?>
    <div class="panel panel-default">
        <div class="panel-heading nav navbar-default">
            <div class="row">
                <div class="col-md-4">
                    <h3 class="panel-title">Notizen</h3>
                </div>
                <div class="col-md-8">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#" onclick="$('#display-note').hide(); $('#form-edit-note').show(); return false;">&Auml;ndern</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div id="form-edit-note" class="start-invisible">
                <form enctype="multipart/form-data" method="post" action="<?= \Layout\Html\Tools::url('person/client', ['person_id' => $person->id() ]) ?>">
                    <?php \Layout\Html\Tools::widget(
                    'form/input-textarea',
                    [
                        "title" => "",
                        "id" => "note",
                        "data" => $person->client()->field('note')->data(),
                        "rows" => 6,
                    ]) ?>
                    <button name="form_submit_edit_note" type="submit" class="btn btn-primary">speichern</button>
                    <button name="form_cancel_edit_note" type="button" class="btn btn-default" onclick="$('#display-note').show(); $('#form-edit-note').hide(); return false;">abbrechen</button>
                </form>
            </div>
            <div id="display-note">
                <?= \Layout\Html\Tools::w_br_enc($person->client()->field('note')->data()); ?>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Erfassen</h3>
        </div>
        <div class="panel-body">
            <form enctype="multipart/form-data" method="post" action="<?= \Layout\Html\Tools::url('person/client',['person_id'=> $person->id()]) ?>">
                <p>
                <?= $person->gender()->field('text')->data() ?> <?= $person->display_name() ?> als 
                <?= $person->gender_text('Klientin', 'Klient', 'Klient/in') ?> erfassen?
                </p>
                <button name="form_submit_client_enable" type="submit" class="btn btn-primary">Erfassen</button>
                <a href="<?= \Layout\Html\Tools::url('person/details',['person_id'=> $person->id()]) ?>" class="btn btn-default" role="button">Abbrechen</a>
            </form>
        </div>
    </div>
<?php endif; ?>


<!-- Local Javascript -->

    <script type="text/javascript">
    </script>
