<div class="main-block">
    <div class="form new-form">
        <h2>New Form</h2>
        <form method="post" name ='new-form' action="../form/add">
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
            <div class="new-element">
                <h4>new element</h4><button class="remove-new-element">delete element</button>
                <p>name <input  class="form-element" name="form[element][i][name]" type="text"></p>
                <p>
                    <select class="form-element-type change-element-type" name="form[element][i][type]">
                        <? foreach (formCreator\entities\FormElement::$type_definition as $type => $definition) {?>
                            <option value="<? echo $type;?>"><? echo $type;?></option>
                        <?}?>
                    </select>
                    <div class="new-element-values">
                        <input class="new-element-value" type="text" name="form[element][i][value][]"> <button id="delete_value">delete value</button>
                        <button id="add_new_value">add value</button>
                    </div>
                </p>
            </div>
            <button class="add-element">add element</button>
            <button class="save-form">save form</button>
        </form>
    </div>
    <?php if(count($forms)) { ?>
    <div class="forms-block">
        <form method="post">
        <?php foreach ($forms as $form) { ?>
            <div class="form" >
                <h2><? echo $form->getName(); ?></h2>
                <p><label> form name:</label><input type="text"  name="form[][name]" value ='<? echo $form->getName(); ?>' /></p>
                <p><label> form action:</label><input type="text"  name='form[][action]' value ='<? echo $form->getAction(); ?>'/></p>
                <p><label> form method:</label>
                    <select  class="form-method change-form-method">
                        <? foreach ($form::$method_definition as $method => $definition) {?>
                            <option <? if ($form->getMethod() == $method) { echo 'selected = "selected"';}?>> <? echo $method;?></option>
                        <?}?>
                    </select>
                </p>
                <p><label> form enctype:</label>
                    <select class="form-enctype" name =''>
                        <? foreach ($form::$enctype_definition as $enctype) {?>
                            <option <? if ($form->getEnctype() == $enctype) { echo 'selected = "selected"';}?>><? echo $enctype;?></option>
                        <?}?>
                    </select>
                </p>
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
            <input class='save-all-button' type="submit" value="SAVE">
        </form>
    </div>
    <?php }?>
</div>

<script>
    var formCreator = new formCreator();
    formCreator.init();
</script>