<?php
if(is_object($data))
{
    $id = $data->id();
    $error = $data->error();
    $data = $data->data();
}

$id = $id ? $id : '';
$error = isset($error) ? $error : NULL;
$data = $data ? $data : '';

?>
<div id="<?=$id?>-div" class="form-group<?= isset($error) && $error != '' ? ' has-error' : '' ?>">
    <label class="control-label" for="<?= $id ?>"><?= $title ?></label>
    <input type="password" class="form-control" value="<?= $data ?>" name="<?= $id ?>" id="<?= $id ?>">
    <span id="helpBlock2" class="help-block"><?= isset($error) ? $error : '' ?></span>
</div>
