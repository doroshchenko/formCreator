<div class="main-block">
    <div>
        <form method="post" class ='form' name ='new-form' action="../form/add">
            <h2>New Form</h2>
            <p><label> form name:</label><input class="form-name" type="text"  name="form[name]" /></p>
            <p><label> form action:</label><input class="form-action" type="text"  name='form[action]' /></p>
            <p><label> form method:</label>
                <select class="form-method change-form-method" name ="form[method]">
                    <? foreach (formCreator\entities\Form::$method_definition as $method => $definition) {?>
                        <option> <? echo $method;?></option>
                    <?}?>
                </select>
            </p>
            <p><label> form enctype:</label>
                <select class="form-enctype" name ='form[enctype]'>
                    <? foreach (formCreator\entities\Form::$enctype_definition as $type) {?>
                        <option><? echo $type;?></option>
                    <?}?>
                </select>
            </p>
            <button class="form-element-add">add element</button>
            <button class="form-save">save form</button>
        </form>
    </div>
    <?php if(count($forms)) { ?>
    <div class="forms-block">
        <?php foreach ($forms as $form) { ?>
            <form method="post" class="form" id="<? echo $form->getIdForm();?>">
                <? $formId = $form->getIdForm();?>
                <h2><? echo $form->getName(); ?></h2>
                <p><label> form name:</label><input type="text"  name="form[<?echo $formId;?>][name]" value ='<? echo $form->getName(); ?>' /></p>
                <p><label> form action:</label><input type="text"  name='form[<?echo $formId;?>][action]' value ='<? echo $form->getAction(); ?>'/></p>
                <p><label> form method:</label>
                    <select  class="form-method change-form-method" name="form[<?echo $formId;?>][method]">
                        <? foreach ($form::$method_definition as $method => $definition) {?>
                            <option <? if ($form->getMethod() == $method) { echo 'selected = "selected"';}?>> <? echo $method;?></option>
                        <?}?>
                    </select>
                </p>
                <p><label> form enctype:</label>
                    <select class="form-enctype" name ="form[<?echo $formId;?>][enctype]">
                        <? foreach ($form::$enctype_definition as $enctype) {?>
                            <option <? if ($form->getEnctype() == $enctype) { echo 'selected = "selected"';}?>><? echo $enctype;?></option>
                        <?}?>
                    </select>
                </p>
                <div class="form_elements">
                    <h3> Elements </h3>
                    <? $elements = ($form->getElements()) ? $form->getElements() : array(); ?>
                    <? $elementNum = 0;?>
                    <? foreach ($elements as $element) {?>
                        <? $elementNum++; ?>
                        <div class="form-element" id="element_<? echo $element->getIdFormElement();?>">
                            <p>
                                <h4><? echo $element->getLabel();?></h4>
                                <label> element label:</label><input type="text"  name="form[<?echo $formId;?>][element][<?echo $elementNum;?>][label]" value ='<? echo $element->getLabel(); ?>'/>
                                <label> element name:</label><input type="text"  name="form[<?echo $formId;?>][element][<?echo $elementNum;?>][name]" value ='<? echo $element->getName(); ?>'/>
                                <label> element type:</label>
                                <select class="form-element-type" name="form[<?echo $formId;?>][element][<?echo $elementNum;?>][type]">
                                    <? foreach ($element::$type_definition as $type => $definition) {?>
                                        <? $hasValues = null; ?>
                                        <? if(in_array('values', $definition)) {
                                            $hasValues = true;
                                        }?>
                                        <option <? if($element->getType() == $type) { echo 'selected = "selected"'; if ($hasValues) { $selectedHasValues = true;}}?>
                                            <? echo $hasValues ? 'has-values' : '' ;?>>
                                            <? echo $type;?>
                                        </option>

                                    <?}?>
                                </select>
                                <button class="form-element-value-add<? echo isset($selectedHasValues) ? '' : ' hidden';?>">add value</button>
                            <? if ($element->getValues()) {?>
                                <? foreach ($element->getValues() as $value) {?>
                                    <div class="form-element-value">
                                        <label>value</label>
                                        <input name="form[<? echo $formId;?>][element][<? echo $elementNum;?>][value][]" value="<? echo $value['value'];?>"/>
                                        <button class="form-element-value-delete">delete</button>
                                    </div>
                                <?}?>
                            <?}?>
                                <button class="form-element-delete">delete element</button>

                            </p>
                        </div>
                    <?}?>
                </div>
                <button class="form-element-add">add element</button>
                <button class="form-save">save form</button>
            </form>
        <?php } ?>
            <input class='save-all-button' type="submit" value="SAVE">
    </div>
    <?php }?>
</div>

<script>
    var formCreator = new formCreator();
    formCreator.init();
</script>