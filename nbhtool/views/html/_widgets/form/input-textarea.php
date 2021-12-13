<?php

if(is_object($data))
{
    $id = $data->id();
    $error = $data->error();
    $data = $data->data();
}

?>
<div class="form-group<?= isset($error) && $error != '' ? ' has-error' : '' ?>">
    <?php if($title): ?><label class="control-label" for="<?= $id ?>"><?= $title ?></label><?php endif; ?>
    <textarea rows="<?= ($rows ? $rows : 3) ?>" class="form-control" value="<?= \Layout\Html\Tools::enc($data) ?>" name="<?= $id ?>" id="<?= $id ?>"><?= $data ?></textarea>
    <span id="helpBlock2" class="help-block"><?= isset($error) ? $error : '' ?></span>
</div>
