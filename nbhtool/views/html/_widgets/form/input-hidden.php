<?php
$id = isset($id) ? $id : 'undef';

if(is_object($data))
{
    $id = $id == 'undef' ? $data->id() : $id;
    $error = $data->error();
    $data = $data->data();
}

?>
<input type="hidden" class="form-control" value="<?= $data ?>" name="<?= $id ?>" id="<?= $id ?>">
