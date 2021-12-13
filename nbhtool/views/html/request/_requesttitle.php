<h1><span class="db-id">Anfrage#<?= $request->field('id')->data() ?>:</span> <?=
$request->client()->person()->display_name(); ?> &ndash; <?= $request->service()->field('text')->data(); ?> <span class="badge color-state-<?= $request->current_state()->state()->field('id')->data() ?>"><?= $request->current_state()->state()->field('text')->data() ?></span></h1>
