<h1>Es trat ein Fehler auf</h1>
<p>Der Fehler wurde aufgezeichnet und wird analysiert werden. Versuchen Sie
bitte auf die <a href="<?= \Layout\Html\Tools::url('/') ?>">Startseite</a>
des Tools zur&uuml;ck zukehren und die Aktion zu wiederholen. Sollten sie
weiterhin den Fehler erhalten, informieren Sie bitte die zust&auml;ndige Stelle
innerhalb Ihrer Organisation</p>
<div class="panel panel-danger">
    <div class="panel-heading">
        <h3 class="panel-title">Fehler Details</h3>
    </div>
        <div class="panel-body">
        <?php foreach(\RT::$error->get_error_stack() as $error): ?>
        <p><?= $error ?><p>
        <?php endforeach; ?>
    </div>
</div>
