<h1><span class="db-id">Berichte: </span>Freiwillige</h1>
<?php include('_reportnav.php') ?>
<!--
<nav class="navbar navbar-default navbar-sub">
    <ul class="nav navbar-nav">
        <li>
            <form class="navbar-form navbar-left" enctype="multipart/form-data" method="post" action="<?= \Layout\Html\Tools::url('report/'.\RT::$request->action(), ['selected_report_year' => $selected_report_year]) ?>">
        <?php
         $report_branch_list = array();
         foreach(\RT::$auth->info()->person()->agent()->branches() as $branch)
         {
            array_push($report_branch_list,
            [
                'id' => $branch->id(),
                'name' => $branch->field('name')->data(),
            ]
            );
         }
        array_push($report_branch_list,
        [
            'id' => 0,
            'name' => 'Alle',
        ]
        );
        if(count(RT::$auth->info()->person()->agent()->branches()) > 1): ?>
            <?php \Layout\Html\Tools::widget(
            'form/input-select',
            [
                "title" => "",
                "data" => \RT::$auth->info()->person()->agent()->selected_branch()->field('id'),
                "list" => $report_branch_list,
                "id" => "report_branch",
                "display_key" => "name"
            ]) ?>
        <?php endif; ?>
        <button name="filter" type="submit" class="btn btn-primary navbar-btn">aktualisieren</button>
        </form>
        </li>
    </ul>
</nav>
-->
<p></p>
    <div class="panel panel-default">
        <div class="panel-heading nav navbar-default">
            <h3 class="panel-title">Reporting Freiwillige <?= \Layout\Html\Tools::enc($selected_report_year) ?></h3>
        </div>
        <div class="panel-body">
        <dl class="dl-horizontal">
            <h4>Jahrestotal  <?= \Layout\Html\Tools::enc($selected_report_year) ?>:</h4>
            <dt>Zeitaufwand (h)</dt>
            <dd><?= \Layout\Html\Tools::enc($total_time/60/60) ?></dd>
            <dt>Eins&auml;tze</dt>
            <dd><?= \Layout\Html\Tools::enc($total_visits) ?></dd>
            <dt>Fahrstrecke (km)</dt>
            <dd><?= \Layout\Html\Tools::enc($total_km) ?></dd>
        </dl>
        <?php \Layout\Html\Tools::widget('table', [
            'id' => 'volunteer_sum_report',
            'data' => $volunteer_sum_report,
            'columns' => [
                'Name' => ['field' => 'name'],
                'Vermittlungsstelle' => ['field' => 'branch'],
                'Automarke' => ['field' => 'car_model'],
                'Autonummer' => ['field' => 'car_register_number'],
                'Eins&auml;tze' => ['field' => 'visits'],
                'Fahrstrecke (Km)' => ['field' => 'km'],
                'Zeitaufwand (h)' => ['field' => 'time']
            ]
        ])
        ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading nav navbar-default">
            <h3 class="panel-title">Freiwillige per Monat <?= \Layout\Html\Tools::enc($selected_report_year) ?></h3>
        </div>
        <div class="panel-body">
            <ul class="data-graph-toggle nav nav-tabs">
                <li class="tab-1 active"><a href="javascript:" onclick="
                    $('#data-table').show();
                    $('#data-graph').hide();
                    $('ul.data-graph-toggle > li.tab-1').addClass('active');
                    $('ul.data-graph-toggle > li.tab-2').removeClass('active');
                    return false;
                ">Daten</a></li>
                <li class="tab-2"><a href="javascript:" onclick="
                    $('#data-table').hide();
                    $('#data-graph').show();
                    $('ul.data-graph-toggle > li.tab-1').removeClass('active');
                    $('ul.data-graph-toggle > li.tab-2').addClass('active');
                    return false;
                ">Grafik</a></li>
            </ul>
            <div id="data-table">
            <?php \Layout\Html\Tools::widget('table', [
                'data' => $volunteer_monthly_report,
                'columns' => [
                    'Monat' => ['field' => 'month'],
                    'Eins&auml;tze' => ['field' => 'visits'],
                    'Fahrstrecke (Km)' => ['field' => 'km'],
                    'Zeitaufwand (h)' => ['field' => 'time']
                ]
            ]) ?>
            </div>
            <div id="data-graph">
            </div>
        </div>
    </div>


<!-- Local Javascript -->

    <script type="text/javascript">
    </script>
