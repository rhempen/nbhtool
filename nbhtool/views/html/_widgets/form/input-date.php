<?php

if(is_object($data))
{
    $id = $data->id();
    $error = $data->error();
    $data = $data->data();
}

?>
        <div class="form-group">
        <label for="<?= $id ?>"><?= $title ?></label>
        <div class='input-group date' id='dateofbirthpicker_<?= $id ?>'>
            <input type="text" class="form-control" value="<?= $data ?>" name="<?= $id ?>" id="<?= $id ?>">
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
        <script type="text/javascript">
            $(function () {
                $('#dateofbirthpicker_<?= $id ?>').datetimepicker({
                    locale: 'de',
                    format: 'DD.MM.YYYY',
                });
            });
        </script>
        </div>
