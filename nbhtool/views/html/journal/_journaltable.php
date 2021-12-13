<table class="table">
    <thead>
        <th>Zeitpunkt</th> 
        <th>Vermittler/-in</th> 
        <th>Betroffen</th> 
        <th>Aktion und Mitteilung</th> 
        <th></th>
    </thead>
    <tbody>
    <?php foreach($agent_journal as $entry): ?>
      <tr>
        <td><?= date("d.m.Y H:i", $entry->field('start')->data()); ?></td>
        <td><?= $entry->agent()->display_name(); ?></td>
        <td style="width: 40%;">
            <?php $first_line = True ?>
            <?php if($entry->person()->is()): ?>
            <?= $first_line === True ? '' : '<br>'; ?>
            <?= $first_line = False; ?>
            Person: <a href="<?= \Layout\Html\Tools::url('person/details',['person_id' => $entry->person()->id()]) ?>"><?= $entry->person()->display_name(); ?></a>
            <?php endif; ?>
            <?php if($entry->request()->is()): ?>
            <?= $first_line === True ? '' : '<br>'; ?>
            <?= $first_line = False; ?>
            Anfrage: <a href="<?= \Layout\Html\Tools::url('request/details',['request_id' => $entry->request()->id()]) ?>">#<?= $entry->request()->display_name(); ?> <?= $entry->request()->service()->field('text')->data(); ?></a>
            <?php endif; ?>
            <?php if($entry->client()->is()): ?>
            <?= $first_line === True ? '' : '<br>'; ?>
            <?= $first_line = False; ?>
            <?= $entry->client()->person()->gender_text('Klientin', 'Klient', 'Klient/in') ?>: <a href="<?= \Layout\Html\Tools::url('person/client',['person_id' => $entry->client()->person()->id()]) ?>"><?= $entry->client()->person()->display_name(); ?></a>
            <?php endif; ?>
            <?php if($entry->volunteer()->is()): ?>
            <?= $first_line === True ? '' : '<br>'; ?>
            <?= $first_line = False; ?>
            <?= $entry->volunteer()->person()->gender_text('Freiwillige',
            'Freiwilliger', 'Freiwillige/r') ?>: <a href="<?= \Layout\Html\Tools::url('person/volunteer',['person_id' => $entry->volunteer()->person()->id()]) ?>"><?= $entry->volunteer()->person()->display_name(); ?></a>
            <?php endif; ?>
            <?php if($entry->group()->is()): ?>
            <?= $first_line === True ? '' : '<br>'; ?>
            <?= $first_line = False; ?>
            Gruppe: <a href="<?= \Layout\Html\Tools::url('group/details',['person_group_id' => $entry->group()->id()]) ?>"><?= $entry->group()->display_name(); ?></a>
            <?php endif; ?>
        </td>
        <td style="width: 40%;">
            <?= \Layout\Html\Tools::w_br_enc($entry->field('text')->data()); ?>
            <?php if($entry->field('note')->data()): ?><div id="note-<?= $entry->id()?>" class="alert alert-success" role="alert"><?= \Layout\Html\Tools::w_br_enc($entry->field('note')->data()); ?></div><?php endif; ?>
            <div id="form-note-<?= $entry->id()?>" class="start-invisible">
                <form enctype="multipart/form-data" method="post" action="<?= \Layout\Html\Tools::url('journal/index/addcomment') ?>">
                    <?php \Layout\Html\Tools::widget(
                    'form/input-textarea',
                    [
                        "title" => "",
                        "id" => "journal_note",
                        "data" => $entry->field('note')->data(),
                        "rows" => 6,
                    ]) ?>
                    <?php \Layout\Html\Tools::widget(
                    'form/input-hidden',
                    [
                        "id" => "journal_id",
                        "data" => $entry->id(),
                    ]) ?>
                    <button name="form_submit_edit_note" type="submit" class="btn btn-primary">speichern</button>
                    <button name="form_cancel_edit_note" type="button"
                    class="btn btn-default" onclick="$('#form-note-<?= $entry->id()?>').hide(); $('#note-<?= $entry->id()?>').show(); return false;">abbrechen</button>
                </form>
            </div>
        </td>
        <td>
            <a href="#" onclick="$('#form-note-<?= $entry->id()?>').show(); $('#note-<?= $entry->id()?>').hide(); return false;">kommentieren</a><br>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
</table>
