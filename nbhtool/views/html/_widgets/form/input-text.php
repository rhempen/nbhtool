<?php
$id = isset($id) ? $id : 'undef';
$error = '';
if(is_object($data))
{
    $id = $id == 'undef' ? $data->id() : $id;
    $error = $data->error();
    $data = $data->data();
}
else if(!is_string($data))
{
    $data = '';
}

?>
<div id="<?=$id?>-div" class="form-group<?= isset($error) && $error != '' ? ' has-error' : '' ?>">
    <?php if(isset($title)): ?><label class="control-label" for="<?= $id ?>"><?= $title ?></label><?php endif; ?>
    <input type="text" class="form-control" value="<?= \Layout\Html\Tools::enc($data) ?>" name="<?=
    $id ?>" id="<?= $id ?>"<?= isset($size) ? "size=$size" : ''?>>
    <?php if(!isset($no_help_block)): ?>
        <span id="helpBlock2" class="help-block"><?= isset($error) ? $error : '' ?></span>
    <?php endif; ?>
</div>
