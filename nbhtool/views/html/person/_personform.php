<form enctype="multipart/form-data" method="post" action="<?= \Layout\Html\Tools::url('person/save') ?>">
    <?php if($person->exists): ?>
    <?php \Layout\Html\Tools::widget(
    'form/input-hidden',
    [
        "id" => "person_id",
        "data" => $person->field('id'),
    ]) ?>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-6"> 
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Name</h3>
                </div>
                <div class="panel-body">
                    <?php \Layout\Html\Tools::widget(
                    'form/input-select',
                    [
                        "title" => "Anrede",
                        "data" => $person->field('gender_id'),
                        "list" => $gender_list,
                    ]) ?>
                    <?php \Layout\Html\Tools::widget(
                    'form/input-select',
                    [
                        "title" => "Titel",
                        "data" => $person->field('title_id'),
                        "list" => $title_list,
                    ]) ?>
                    <?php \Layout\Html\Tools::widget(
                    'form/input-text',
                    [
                        "title" => "Vorname",
                        "data" => $person->field('firstname')
                    ]) ?>
                    <?php \Layout\Html\Tools::widget(
                    'form/input-text',
                    [
                        "title" => "Nachname",
                        "data" => $person->field('lastname')
                    ]) ?>
                    <?php \Layout\Html\Tools::widget(
                    'form/input-text',
                    [
                        "title" => "Organisation",
                        "data" => $person->field('organization'),
                    ]) ?>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Adresse</h3>
                </div>
                <div class="panel-body">
                    <?php \Layout\Html\Tools::widget(
                    'form/input-text',
                    [
                        "title" => "Strasse",
                        "data" => $person->field('address_line1'),
                    ]) ?>
                    <?php \Layout\Html\Tools::widget(
                    'form/input-text',
                    [
                        "title" => "Addresszusatz",
                        "data" => $person->field('address_line2'),
                    ]) ?>
                    <?php \Layout\Html\Tools::widget(
                    'form/input-text',
                    [
                        "title" => "Postfach",
                        "data" => $person->field('postbox'),
                    ]) ?>
                    <?php \Layout\Html\Tools::widget(
                    'form/input-text',
                    [
                        "title" => "Postleitzahl",
                        "data" => $person->field('zip_code'),
                    ]) ?>
                    <?php \Layout\Html\Tools::widget(
                    'form/input-text',
                    [
                        "title" => "Ort",
                        "data" => $person->field('city'),
                    ]) ?>
                    <?php \Layout\Html\Tools::widget(
                    'form/input-text',
                    [
                        "title" => "Land",
                        "data" => $person->field('country'),
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6"> 
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Email und Telefon</h3>
                </div>
                <div class="panel-body">
                    <?php \Layout\Html\Tools::widget(
                    'form/input-email',
                    [
                        "title" => "E-Mail-Adresse",
                        "data" => $person->field('email_address'),
                    ]) ?>
                    <?php \Layout\Html\Tools::widget(
                    'form/input-text',
                    [
                        "title" => "Private Rufnummer",
                        "data" => $person->field('phone_home'),
                    ]) ?>
                    <?php \Layout\Html\Tools::widget(
                    'form/input-text',
                    [
                        "title" => "Mobile Rufnummer",
                        "data" => $person->field('phone_mobile'),
                    ]) ?>
                    <?php \Layout\Html\Tools::widget(
                    'form/input-text',
                    [
                        "title" => "Gesch&auml;tliche Rufnummer",
                        "data" => $person->field('phone_work'),
                    ]) ?>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Sonstige Personalien</h3>
                </div>
                <div class="panel-body">
                    <?php \Layout\Html\Tools::widget(
                    'form/input-date',
                    [
                        "title" => "Geburtstag",
                        "id" => "date_of_birth",
                        "data" =>  $person->field('date_of_birth')->data() ?  date("d.m.Y", $person->field('date_of_birth')->data()) : ''
                    ]) ?>
                    <?php \Layout\Html\Tools::widget(
                    'form/input-select',
                    [
                        "title" => "Nationalit&aumlt",
                        "data" => $person->field('nationality_id'),
                        "list" => $nationality_list,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
    <button name="form_submit_person" type="submit" class="btn btn-primary">Speichern</button>
</form>
