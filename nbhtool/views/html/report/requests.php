<h1><span class="db-id">Berichte: </span>Anfragen und Vermittlungen</h1>
<?php include('_reportnav.php') ?>
<p></p>
    <div class="panel panel-default">
        <div class="panel-heading nav navbar-default">
            <h3 class="panel-title">Anfragen im Jahr <?= \Layout\Html\Tools::enc($selected_report_year) ?></h3>
        </div>
        <div class="panel-body">
        <dl class="dl-horizontal">
            <h4>Jahrestotal  <?= \Layout\Html\Tools::enc($selected_report_year) ?>:</h4>
            <dt>Anzahl Anfragen</dt>
            <dd><?= \Layout\Html\Tools::enc($request_yearly_total) ?></dd>
        </dl>
            <ul class="graph-requests-toggle nav nav-tabs">
                <li class="tab-1 active"><a href="javascript:" onclick="
                    $('#table-requests').show();
                    $('#graph-requests').hide();
                    $('ul.graph-requests-toggle > li.tab-1').addClass('active');
                    $('ul.graph-requests-toggle > li.tab-2').removeClass('active');
                    return false;
                ">Daten</a></li>
                <li class="tab-2"><a href="javascript:" onclick="
                    $('#table-requests').hide();
                    $('#graph-requests').show();
                    $('ul.graph-requests-toggle > li.tab-1').removeClass('active');
                    $('ul.graph-requests-toggle > li.tab-2').addClass('active');
                    return false;
                ">Grafik</a></li>
            </ul>
            <div id="table-requests">
            <?php \Layout\Html\Tools::widget('table', [
                'data' => $request_monthly_report,
                'columns' => [
                    'Kategorie' => ['field' => 'service'],
                    'Jan.' => ['field' => '1'],
                    'Feb.' => ['field' => '2'],
                    'M&auml;rz' => ['field' => '3'],
                    'Apr.' => ['field' => '4'],
                    'Mai' => ['field' => '5'],
                    'Jun.' => ['field' => '6'],
                    'Jul.' => ['field' => '7'],
                    'Aug.' => ['field' => '8'],
                    'Sept.' => ['field' => '9'],
                    'Okt.' => ['field' => '10'],
                    'Nov.' => ['field' => '11'],
                    'Dez.' => ['field' => '12'],
                    'Total' => ['field' => 'total', 'template' => '<strong>{total}</strong>'],
                ]
            ]) ?>
            </div>
            <div id="graph-requests" class="start-invisible">
                <svg style='height:700px;width:900px'></svg>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading nav navbar-default">
            <h3 class="panel-title">Etablierte Vermittlungen im Jahr <?= \Layout\Html\Tools::enc($selected_report_year) ?></h3>
        </div>
        <div class="panel-body">
        <dl class="dl-horizontal">
            <h4>Jahrestotal  <?= \Layout\Html\Tools::enc($selected_report_year) ?>:</h4>
            <dt>Anzahl Vermittlungen</dt>
            <dd><?= \Layout\Html\Tools::enc($established_request_yearly_total) ?></dd>
        </dl>
            <ul class="graph-etablished-requests-toggle nav nav-tabs">
                <li class="tab-1 active"><a href="javascript:" onclick="
                    $('#table-established-requests').show();
                    $('#graph-established-requests').hide();
                    $('ul.graph-established-requests-toggle > li.tab-1').addClass('active');
                    $('ul.graph-established-requests-toggle > li.tab-2').removeClass('active');
                    return false;
                ">Daten</a></li>
                <li class="tab-2"><a href="javascript:" onclick="
                    $('#table-established-requests').hide();
                    $('#graph-established-requests').show();
                    $('ul.graph-established-requests-toggle > li.tab-1').removeClass('active');
                    $('ul.graph-established-requests-toggle > li.tab-2').addClass('active');
                    return false;
                ">Grafik</a></li>
            </ul>
            <div id="table-established-requests">
            <?php \Layout\Html\Tools::widget('table', [
                'data' => $established_request_monthly_report,
                'columns' => [
                    'Kategorie' => ['field' => 'service'],
                    'Jan.' => ['field' => '1'],
                    'Feb.' => ['field' => '2'],
                    'M&auml;rz' => ['field' => '3'],
                    'Apr.' => ['field' => '4'],
                    'Mai' => ['field' => '5'],
                    'Jun.' => ['field' => '6'],
                    'Jul.' => ['field' => '7'],
                    'Aug.' => ['field' => '8'],
                    'Sept.' => ['field' => '9'],
                    'Okt.' => ['field' => '10'],
                    'Nov.' => ['field' => '11'],
                    'Dez.' => ['field' => '12'],
                    'Total' => ['field' => 'total', 'template' => '<strong>{total}</strong>'],
                ]
            ]) ?>
            </div>
            <div id="graph-established-requests" class="start-invisible">
                <svg style='height:700px;width:900px'></svg>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading nav navbar-default">
            <h3 class="panel-title">Stundenaufwand pro Kategorie im Jahr <?= \Layout\Html\Tools::enc($selected_report_year) ?></h3>
        </div>
        <div class="panel-body">
        <dl class="dl-horizontal">
            <h4>Jahrestotal  <?= \Layout\Html\Tools::enc($selected_report_year) ?>:</h4>
            <dt>geleistete Stunden</dt>
            <dd><?= \Layout\Html\Tools::enc($request_yearly_work_total) ?>h</dd>
        </dl>
            <ul class="graph-work-toggle nav nav-tabs">
                <li class="tab-1 active"><a href="javascript:" onclick="
                    $('#table-work').show();
                    $('#graph-work').hide();
                    $('ul.graph-work-toggle > li.tab-1').addClass('active');
                    $('ul.graph-work-toggle > li.tab-2').removeClass('active');
                    return false;
                ">Daten</a></li>
                <li class="tab-2"><a href="javascript:" onclick="
                    $('#table-work').hide();
                    $('#graph-work').show();
                    $('ul.graph-work-toggle > li.tab-1').removeClass('active');
                    $('ul.graph-work-toggle > li.tab-2').addClass('active');
                    return false;
                ">Grafik</a></li>
            </ul>
            <div id="table-work">
            <?php \Layout\Html\Tools::widget('table', [
                'data' => $request_monthly_work_report,
                'columns' => [
                    'Kategorie' => ['field' => 'service'],
                    'Jan.' => ['field' => '1'],
                    'Feb.' => ['field' => '2'],
                    'M&auml;rz' => ['field' => '3'],
                    'Apr.' => ['field' => '4'],
                    'Mai' => ['field' => '5'],
                    'Jun.' => ['field' => '6'],
                    'Jul.' => ['field' => '7'],
                    'Aug.' => ['field' => '8'],
                    'Sept.' => ['field' => '9'],
                    'Okt.' => ['field' => '10'],
                    'Nov.' => ['field' => '11'],
                    'Dez.' => ['field' => '12'],
                    'Total' => ['field' => 'total', 'template' => '<strong>{total}h</strong>'],
                ]
            ]) ?>
            </div>
            <div id="graph-work" class="start-invisible">
                <svg style='height:700px;width:900px'></svg>
            </div>
        </div>
    </div>


<!-- Local Javascript -->

    <script type="text/javascript">
        nv.addGraph(function() {
          var chart = nv.models.pieChart()
              .x(function(d) { return d.service })
              .y(function(d) { return d.total })
              .showLabels(true);

            d3.select("#graph-requests svg")
                .datum(request_monthly_report_data())
                .transition().duration(350)
                .call(chart);

            d3.select("#graph-established-requests svg")
                .datum(established_request_monthly_report_data())
                .transition().duration(350)
                .call(chart);

            d3.select("#graph-work svg")
                .datum(work_monthly_report_data())
                .transition().duration(350)
                .call(chart);

          return chart;
        });

        function request_monthly_report_data() {
          return [
            <?php foreach($request_monthly_report as $request_total): ?>
                { 
                    "service": "<?= $request_total['service'] ?> (<?= $request_total['total_precent'] ?>%)",
                    "total": "<?= $request_total['total'] ?>"
                },
            <?php endforeach ?>
            ];
        }

        function established_request_monthly_report_data() {
          return [
            <?php foreach($established_request_monthly_report as $established_request_total): ?>
                { 
                    "service": "<?= $established_request_total['service'] ?> (<?= $established_request_total['total_precent'] ?>%)",
                    "total": "<?= $established_request_total['total'] ?>"
                },
            <?php endforeach ?>
            ];
        }

        function work_monthly_report_data() {
          return [
            <?php foreach($request_monthly_work_report as $request_monthly_work_total): ?>
                { 
                    "service": "<?= $request_monthly_work_total['service'] ?> (<?= $request_monthly_work_total['total'] ?>h/<?= $request_monthly_work_total['total_precent'] ?>%)",
                    "total": "<?= $request_monthly_work_total['total'] ?>"
                },
            <?php endforeach ?>
            ];
        }
    </script>
