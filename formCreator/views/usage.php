<?php if(isset($form) && count($form)) {?>
<h3><? echo $form['name'];?></h3>
<form name="<? echo $form['name']?>" action="<? echo $form['action'];?>" method="<? echo $form['method'];?>" <? if (!empty($form['enctype'])){ echo 'enctype="' . $form['enctype'] . '"';}?>>
   <? if (isset($form['elements'])) {?>
   <? foreach ($form['elements'] as $element) {?>
           <? switch ($element['type']) {
               case 'text': ?>
                   <p>
                       <label><? echo $element['label'];?></label><input type="text" name="<? echo $element['name']; ?>">
                   </p>
                   <?break; ?>
               <? case 'textarea': ?>
               <p>
                   <label><? echo $element['label'];?></label><textarea  name="<? echo $element['name']; ?>"></textarea>
               </p>
                    <? break;?>
               <? case 'dropdown': ?>
               <p>
                   <label><? echo $element['label'];?></label>
                   <select  name="<? echo $element['name']; ?>">
                       <? foreach ($element['values'] as $value) {?>
                           <option><? echo $value['value']; ?></option>
                       <? }?>
                   </select>
               </p>
                   <? break;?>
               <? case 'multiselect': ?>
               <p>
                   <label><? echo $element['label'];?></label>
                   <select  name="<? echo $element['name']; ?>" multiple>
                       <? foreach ($element['values'] as $value) {?>
                           <option ><? echo $value['value']; ?></option>
                       <? }?>
                   </select>
               </p>
               <? break;?>
               <? case 'radio': ?>
               <p>
                   <label><? echo $element['label'];?></label>
                       <? foreach ($element['values'] as $value) {?>
                           <input type="radio"  value="<?echo $value['value'];?>" name="<? echo $element['name'];?>"/> <?echo $value['value'];?>
                       <? }?>
               </p>
               <? break;?>
               <? case 'file': ?>
               <p>
                   <label><? echo $element['label'];?></label>
                       <input type="file"   name="<? echo $element['name'];?>"/>
               </p>
               <? break;?>
               <? case 'checkbox': ?>
               <p>
                   <label><? echo $element['label'];?></label>
                   <? foreach ($element['values'] as $value) {?>
                       <input type="checkbox"  value="<?echo $value['value'];?>" name="<? echo $element['name'];?>"/> <?echo $value['value'];?>
                   <? }?>
               </p>
               <? break;?>
               <? case 'hidden': ?>
               <p>
                   <input type="hidden"   name="<? echo $element['name'];?>"/>
               </p>
               <? break;?>
               <?}?>
       <?}?>
       <input type="submit" value="submit"/>
   <? }?>
</form>
<?php } else {
    echo 'form doesn\'t exist';
 }?>
