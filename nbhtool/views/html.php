<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="NBH Business Solution Tool">
    <meta name="author" content="Orbnet.ch">
    <meta name="robots" content="noindex, nofollow">
    <meta http-equiv="Cache-Control" content="no-cache">
    <title>NBH Web Tool</title>

    <link href="<?= \Layout\Html\Tools::web("/assets/bootstrap/css/bootstrap.min.css") ?>" rel="stylesheet">
    <link href="<?= \Layout\Html\Tools::web("/assets/bootstrap-table/bootstrap-table.min.css") ?>" rel="stylesheet">
    <link href="<?= \Layout\Html\Tools::web("/assets/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css") ?>" rel="stylesheet">
    <link href="<?= \Layout\Html\Tools::web("/css/nbhtool2.css") ?>" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="<?= \Layout\Html\Tools::web("/assets/html5shiv/html5shiv.min.js") ?>"></script>
    <script src="<?= \Layout\Html\Tools::web("/assets/respond/respond.min.js") ?>"></script>
    <![endif]-->
    <script src="<?= \Layout\Html\Tools::web("/assets/jquery/jquery.min.js") ?>"></script>
    <?php if(\RT::$request->controller() == 'report'): ?>
    <script src="<?= \Layout\Html\Tools::web("/assets/nvd3/js/d3.min.js") ?>"></script>
    <script src="<?= \Layout\Html\Tools::web("/assets/nvd3/js/nv.d3.min.js") ?>"></script>
    <link href="<?= \Layout\Html\Tools::web("/assets/nvd3/css/nv.d3.css") ?>" rel="stylesheet">
    <?php endif; ?>
</head>
<body>

<div class="wrap">
    <!-- User Control Panel -->
    <?php if(\RT::$auth->check()): ?>
    <div class="container-fluid">
<div class="modal fade" id="user-prefs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h3><?= \RT::$auth->check() ? \RT::$auth->info()->person()->display_name() : '' ?></h3>
    </div>
    <div class="modal-body">
        <a class="btn btn-primary" href="<?= \Layout\Html\Tools::url('auth/logout') ?>">logout</a>
    </div>
    <?php if(count(\RT::$auth->info()->person()->agent()->branches()) > 1): ?>
    <div class="modal-body">
        <h4>Vermittlungsstelle wechseln</h4>
        <form id="change_branch" method="post" action="<?= \Layout\Html\Tools::url('profile/switch_branch') ?>">
            <?php \Layout\Html\Tools::widget(
            'form/input-select',
            [
            "title" => "",
            "data" => \RT::$auth->info()->person()->agent()->selected_branch()->field('id'),
            "list" => \RT::$auth->info()->person()->agent()->branches(),
            "id" => "branch",
            "display_key" => "name"
            ]) ?>
            <button type="submit" class="btn btn-primary">wechseln</button>
        </form>
    </div>
    <?php endif; ?>
    <?php if(\RT::$auth->check()): ?>
    <div class="modal-body">                     
        <h4>Password &auml;ndern (letzte &Auml;nderung <?= date("d.m.Y, H:i", \RT::$auth->info()->person()->account()->field('pw_change_timestamp')->data()) ?>)</h4>
        <form id="change-pw" method="post" action="<?= \Layout\Html\Tools::url('profile/change_pw') ?>">
            <?php \Layout\Html\Tools::widget(
            'form/input-password',
            [
            "title" => "Neues Passwort",
            "data" => "",
            "id" => "new_pw_1",
            ]) ?>
            <?php \Layout\Html\Tools::widget(
            'form/input-password',
            [
            "title" => "Neues Passwort wiederholen",
            "data" => "",
            "id" => "new_pw_2",
            ]) ?>
            <button type="submit" class="btn btn-primary">&auml;ndern</button>
        </form>
    </div>
    </div>
    </div>
    </div>
    </div>
    <?php endif; ?>                                      
    <?php endif; ?>
    <!-- End of User Control Panel -->

    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?= \Layout\Html\Tools::web("") ?>">
                    <img src="<?= \Layout\Html\Tools::web("/img/org-logo.png") ?>" alt="">
                </a>
                <p class="navbar-brand navbar-text">
                    <a href="<?= \Layout\Html\Tools::url('home/index') ?>">
                    <?php if(\RT::$auth->check() && \RT::$auth->info()->person()->agent()): ?>
                    <?= \RT::$auth->info()->person()->agent()->selected_branch()->field('name')->data() ?>
                    <?php else: ?>
                    NBH-Tool
                    <?php endif; ?>
                    </a>
                </p>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <?php if(\RT::$auth->check()): ?>
            <?php include('html/_main_menu.php'); ?>
            <?php endif; ?>
                <ul class="nav navbar-nav navbar-right">
                    <?php if(\RT::$auth->check()): ?>
                    <li>
                        <p class="navbar-text fake-link" data-toggle="modal"
                        data-target="#user-prefs"><?= \RT::$auth->info()->person()->display_name() ?></p>
                    </li>
                    <?php else: ?>
                        <li><a href="<?= \Layout\Html\Tools::url('auth/login') ?>">login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
    <?php if(\RT::$error->is_error() && ! \RT::$error->is_error_fatal()): ?>
    <div class="panel panel-danger">
        <div class="panel-heading">
            <h3 class="panel-title">Fehler</h3>
        </div>
        <div class="panel-body">
            <ul>
                <?php foreach(\RT::$error->get_error_stack() as $error): ?>
                <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <?php endif; ?>
    <?php include $view ?>
</div>

<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <p class="text-muted">Nachbarschaftshilfe Z&uuml;rich</p>
            </div>
            <div class="col-sm-6">
                <p class="text-muted text-right">Version <a href="<?= \Layout\Html\Tools::url('doc/changelog') ?>">0.10.41-b1</a></p>
            </div>
        </div>
    </div>
</footer>
    <script src="<?= \Layout\Html\Tools::web("/assets/ie10-viewport-bug-workaround/ie10-viewport-bug-workaround.js") ?>"></script>
    <script src="<?= \Layout\Html\Tools::web("/assets/bootstrap/js/bootstrap.min.js") ?>"></script>
    <script src="<?= \Layout\Html\Tools::web("/assets/bootstrap/js/transition.js") ?>"></script>
    <script src="<?= \Layout\Html\Tools::web("/assets/bootstrap/js/collapse.js") ?>"></script>
    <script src="<?= \Layout\Html\Tools::web("/assets/moment/moment-with-locales.js") ?>"></script>
    <script src="<?= \Layout\Html\Tools::web("/assets/bootstrap-table/bootstrap-table.min.js") ?>"></script>
    <script src="<?= \Layout\Html\Tools::web("/assets/bootstrap-table/locale/bootstrap-table-de-DE.min.js") ?>"></script>
    <script src="<?= \Layout\Html\Tools::web("/assets/bootstrap-table/extensions/mobile/bootstrap-table-mobile.min.js") ?>"></script>
    <script src="<?= \Layout\Html\Tools::web("/assets/bootstrap-table/extensions/export/bootstrap-table-export.min.js") ?>"></script>
    <script src="<?= \Layout\Html\Tools::web("/assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js") ?>"></script>
    <script src="<?= \Layout\Html\Tools::web("/js/user-control-panel.js") ?>"></script>
    <script type="text/javascript">
        <?php if(!\RT::$params->exists('agent-news-dissmissed') ||
        count(\RT::$auth->info()->person()->agent()->news_inbox()) > 0): ?>
        $(document).ready(function () {$('#agent-news').modal('show');});
        <?php endif; ?>
    </script>
</body>
</html>
