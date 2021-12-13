<?php foreach($subservices_list as $service): ?>
 <div class="checkbox">
     <label>
           <input type="checkbox" value="<?= $service->id() ?>" name="selected_sub_services[]"><?= $service->field('text')->data() ?> </input>
     </label>
 </div>
<?php endforeach; ?>
