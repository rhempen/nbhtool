<?php include('_requesttitle.php') ?>
<?php include('_requestnav.php') ?>
    <nav class="navbar navbar-default navbar-sub">
        <ul class="nav navbar-nav">
            <li>
                <a href="<?=
                \Layout\Html\Tools::url('request/add_log',['request_id'=> $request->id()]) ?>">
                    Neue Bemerkung oder Status &auml;ndern
                </a>
            </li>
        </ul>
    </nav>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Logbuch</h3>
        </div>
        <div class="panel-body">
            <table class="table">
                <tbody>
                <?php foreach($request->log() as $log): ?>
                  <tr>
                    <td class="color-state-<?= $log->state()->field('id')->data(); ?>"><?= $log->state()->field('text')->data(); ?></td>
                    <td><?= date("d.m.Y, H:i", $log->field('timestamp')->data()); ?></td>
                    <td><?= $log->person()->display_name(); ?></td>
                    <td style="width: 60%;"><?= \Layout\Html\Tools::w_br_enc($log->field('note')->data()); ?></td>
                  </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
