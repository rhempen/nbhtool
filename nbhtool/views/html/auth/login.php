<form class="form-signin" method="post" action="<?= \Layout\Html\Tools::url('home/index') ?>">
    <h2 class="form-signin-heading">Benutzeranmeldung</h2>
    <?php if(\RT::$auth->error()): ?>
    <div class="alert alert-danger"><?= \RT::$auth->error() ?></div>
    <?php endif; ?>
    <label for="inputUsername" class="sr-only">Benutzername</label>
    <input name="username" type="text" id="inputUsername" class="form-control" placeholder="Benutzername" required autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Anmelden</button>
</form>
