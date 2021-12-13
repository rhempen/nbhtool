<table class="table" >
    <thead>
        <tr>
            <th>#</th>
            <th>Art der Anfrage</th>
            <th>Klient/-in</th>
            <th>Offen seit</th>
            <th>Zuletzt bearbeitet durch</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($data as $request): ?>
        <tr>
            <td><a href="<?= \Layout\Html\Tools::url('request/details', ['request_id' => $request->field('id')->data() ]) ?>"><?= $request->field('id')->data() ?></a></td>
            <td><a href="<?= \Layout\Html\Tools::url('request/details',
            ['request_id' => $request->field('id')->data() ]) ?>"><?= $request->service()->field('text')->data(); ?></a></td>
            <td><a href="<?= \Layout\Html\Tools::url('person/details', ['person_id' => $request->client()->person()->field('id')->data() ]) ?>"><?= $request->client()->person()->display_name() ?></a></td>
            <td><?= date("d.m.Y, H:i", $request->current_state()->field('timestamp')->data()) ?></td>
            <td><?= $request->current_state()->person()->display_name() ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
