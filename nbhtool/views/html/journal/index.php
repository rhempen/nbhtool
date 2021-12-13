<h1><span class="db-id">Journal: </span><?= \RT::$auth->info()->person()->agent()->selected_branch()->field('name')->data() ?></h1>
<?php include('_journalnav.php') ?>
<nav class="navbar navbar-default navbar-sub">
    <ul class="nav navbar-nav">
        <li>
                    <form class="navbar-form navbar-left" enctype="multipart/form-data" method="post" action="<?= \Layout\Html\Tools::url('journal/index') ?>">
                    <?php \Layout\Html\Tools::widget('form/input-date',
                    [
                        "title" => "von",
                        "id" => "filter_start_date",
                        "data" => $filter_start_date ? $filter_start_date : ''
                    ]) ?>
                    <?php \Layout\Html\Tools::widget('form/input-date',
                    [
                        "title" => "bis",
                        "id" => "filter_end_date",
                        "data" => $filter_end_date ? $filter_end_date : ''
                    ]) ?>
                    <button name="filter" type="submit" class="btn btn-primary navbar-btn">filtern</button>
                    </form>
        </li>
    </ul>
</nav>
<?php include('_journaltable.php') ?>

<!-- Local Javascript -->

    <script type="text/javascript">
    </script>
