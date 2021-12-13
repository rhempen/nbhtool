<?php include('_requesttitle.php') ?>
<?php include('_requestnav.php') ?>
    <nav class="navbar navbar-default navbar-sub">
        <ul class="nav navbar-nav">
            <li>
                <a href="<?=
                \Layout\Html\Tools::url('request/add_alt_contact',['request_id'=> $request->id()]) ?>">
                    alternative Kontaktperson zuweisen
                </a>
            </li>
        </ul>
    </nav>
    <?php \Layout\Html\Tools::widget(
    'form/input-hidden',
    [
        "id" => "request_id",
        "data" => $request_id,
    ]) ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Klient</h3>
        </div>
        <div class="panel-body">
            <?php \Layout\Html\Tools::widget(
            'person-card',
            [
                "person" => $request->client()->person(),
            ]) 
            ?>
        </div>
    </div>

    <?php if($request->contact_person()->is()): ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-4">
                    <h3 class="panel-title">Alternative Kontaktperson</h3>
                </div>
                <div class="col-md-8">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="<?=
                        \Layout\Html\Tools::url('request/details',['request_id' => $request_id, 'remove_contact_person' => 1]) ?>" class="">Entfernen</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <?php \Layout\Html\Tools::widget(
            'person-card',
            [
                "person" => $request->contact_person(),
            ]) 
            ?>
        </div>
    </div>
    <?php endif; ?>


    <div class="row">
        <div class="col-md-6"> 
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Kategorie der Anfrage</h3>
                </div>
                <div class="panel-body">
                    <?= $request->service()->field('text')->data(); ?>
                </div>
            </div>
        </div>
        <div class="col-md-6"> 
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">T&auml;tigkeiten</h3>
                </div>
                <div class="panel-body">
                    <ul>
                    <?php foreach($request->sub_services() as $sub_service): ?>
                        <li><?= $sub_service->field('text')->data() ?></li>
                    <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading nav navbar-default">
            <div class="row">
                <div class="col-md-4">
                    <h3 class="panel-title">Detailbeschreibung</h3>
                </div>
                <div class="col-md-8">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#" class="" onclick="$('#display-note').hide(); $('#form-edit-note').show(); return false;">&Auml;ndern</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div id="form-edit-note" class="start-invisible">
                <form enctype="multipart/form-data" method="post" action="<?= \Layout\Html\Tools::url('request/details', ['request_id' => $request_id ]) ?>">
                    <?php \Layout\Html\Tools::widget(
                    'form/input-textarea',
                    [
                        "title" => "",
                        "id" => "note",
                        "data" => $request->field('note')->data(),
                        "rows" => 6,
                    ]) ?>
                    <button name="form_submit_edit_note" type="submit" class="btn btn-primary">speichern</button>
                    <button name="form_cancel_edit_note" type="button" class="btn btn-default" onclick="$('#display-note').show(); $('#form-edit-note').hide(); return false;">abbrechen</button>
                </form>
            </div>
            <div id="display-note">
                <?= \Layout\Html\Tools::w_br_enc($request->field('note')->data()); ?>
            </div>
        </div>
    </div>
