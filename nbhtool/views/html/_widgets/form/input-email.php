<?php

if(is_object($data))
{
    $id = $data->id();
    $error = $data->error();
    $data = $data->data();
}

?>
<div class="form-group<?= isset($error) && $error != '' ? ' has-error' : '' ?>">
    <label class="control-label" for="<?= $id ?>"><?= $title ?></label>
    <input type="email" class="form-control" value="<?= $data ?>" name="<?= $id ?>" id="<?= $id ?>">
    <span id="helpBlock2" class="help-block"><?= isset($error) ? $error : '' ?></span>
</div>
