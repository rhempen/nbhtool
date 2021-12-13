<?php include('_persontitle.php') ?>
<?php include('_personnav.php') ?>
<p></p>
<?php if($confirmed): ?>
    
<?php else: ?>
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title">L&ouml;schen der Person best&auml;tigen</h3>
            </div>
            <div class="panel-body">
                <p>Durch die Best&auml;tigung dieser Meldung wird die Person
                <strong><?= $person->display_name() ?></strong>
                unwiederruflich gel&ouml;scht. Bei Bedarf muss die
                Person neu im System angelegt werden. Bei Vermittlungen oder
                in Reports kann diese Person jedoch zur Wahrung der Statistik immer noch erscheinen.</p>
                <a href="<?= \Layout\Html\Tools::url('person/delete/confirmed',['person_id'=> $person->id()]) ?>" class="btn btn-primary">Ja, Person l&ouml;schen</button>
                <a href="<?= \Layout\Html\Tools::url('person/details',['person_id'=> $person->id()]) ?>" class="btn btn-default" role="button">Abbrechen</a>
            </div>
        </div>
<?php endif; ?>


<!-- Local Javascript -->

    <script type="text/javascript">
    </script>
