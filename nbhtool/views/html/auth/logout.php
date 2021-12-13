<form class="form-signin" method="post" action="<?= \RT::$request->origin_path() ?>">
    <h2 class="form-signin-heading">Abgemeldet</h2>
    <p>Sie wurden abgemeldet. <a href="<?=
    \Layout\Html\Tools::url('auth/login') ?>">Klicken Sie hier</a>, um sich
    erneut anzumelden.</p>
</form>
