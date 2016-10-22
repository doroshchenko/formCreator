<div class="main-block">
    <div class="new-form">
        <p><label> form name:</label><input type="text"  name="form[][name]" /></p>
        <p><label> form action:</label><input type="text"  name='form[][action]' /></p>
        <p><label> form type:</label><input type="text"  name='form[][action]' /></p>
        <p><label> form method:</label><input type="text"  name='form[][action]'/></p>
        <button>create</button>
    </div>
    <div class="forms-block">
        <?php foreach ($forms as $form) { ?>
            <div class="form" >
                <h2><? echo $form->getName(); ?></h2>
                    <p><label> form name:</label><input type="text"  name="form[][name]" value ='<? echo $form->getName(); ?>'/></p>
                    <p><label> form action:</label><input type="text"  name='form[][action]' value ='<? echo $form->getAction(); ?>'/></p>
                    <p><label> form type:</label><input type="text"  name='form[][action]' value ='<? echo $form->getType(); ?>'/></p>
                    <p><label> form method:</label><input type="text"  name='form[][action]' value ='<? echo $form->getmethod(); ?>'/></p>
                    <div class="form_elements">
                        <h3> Elements </h3>
                        <? $elements = ($form->getElements()) ? $form->getElements() : array(); ?>
                        <? foreach ($elements as $element) {?>
                            <p>
                                <label> element name:</label><input type="text"  name="form[][element][name]" value ='<? echo $element->getName(); ?>'/>
                                <label> element type:</label>
                                <select>
                                    <? foreach ($element::$type_definition as $type => $definition) {?>
                                        <option <? if($element->getType() == $type) { echo 'selected = "selected"';}?>><? echo $type;?></option>
                                        <? if (in_array('values', $definition)) {?>
                                            <? foreach ($element->getValues() as $value) {?>
                                                <label>value</label>
                                                <input name="form[][element][]" value=""/>
                                            <?}?>
                                        <?}?>
                                    <?}?>
                                </select>
                            </p>
                        <?}?>
                    </div>
            </div>
        <?php } ?>
    </div>
</div>
<form>
</form>