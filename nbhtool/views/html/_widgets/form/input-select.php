<?php
    if(!isset($id_key))
    {
        $id_key = 'id';
    }
    if(!isset($display_key))
    {
        $display_key = 'text';
    }
    if(is_object($data))
    {
        $id = isset($id) ? $id : $data->id();
        $error = $data->error();
        $data = $data->data();
    }
?>
<div class="form-group<?= isset($error) && $error != '' ? ' has-error' : '' ?>">
    <?php if(isset($title)): ?><label class="control-label" for="<?= $id ?>"><?= $title ?></label><?php endif; ?>
    <select class="form-control" name="<?= $id ?>" id="<?= $id ?>">
    <?php if(isset($empty_first)): ?>
        <option value="empty"><?= $empty_first ?></option>
    <?php endif; ?>
    <?php foreach($list as $option):
        if(is_object($option)): ?>
        <option value="<?= $option->field($id_key)->data() ?>"<?= (isset($data) && $data == $option->field($id_key)->data() ? ' selected': '') ?>><?= $option->field($display_key)->data() ?></option>
        <?php Else: ?>
        <option value="<?= $option[$id_key] ?>"<?= (isset($data) && $data == $option[$id_key] ? ' selected': '') ?>><?= $option[$display_key] ?></option>
        <?php Endif; ?>
    <?php endforeach; ?>
    </select>
    <?php if(!isset($no_help_block)): ?>
        <span id="helpBlock2" class="help-block"><?= isset($error) ? $error : '' ?></span>
    <?php endif; ?>
</div>
