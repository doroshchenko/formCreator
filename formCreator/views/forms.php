<div class="main-block">
    <div class="new-form">
        <h2>New Form</h2>
        <form method="post" name ='new-form' action="../form/add">
            <p><label> form name:</label><input type="text"  name="form[name]" /></p>
            <p><label> form action:</label><input type="text"  name='form[action]' /></p>
            <p><label> form method:</label>
                <select name ="form[method]">
                    <? foreach (formCreator\entities\Form::$method_definition as $method => $definition) {?>
                        <option> <? echo $method;?></option>
                    <?}?>
                </select>
            </p>
            <p><label> form enctype:</label>
                <select name ='form[enctype]'>
                    <? foreach (formCreator\entities\Form::$enctype_definition as $type) {?>
                        <option><? echo $type;?></option>
                    <?}?>
                </select>
            </p>
            <div class="new-element">
                <h4>new element</h4>
                <p>name <input name="form[element][i][name]" type="text"></p>
                <p>
                    <select name="form[element][i][type]">
                        <? foreach (formCreator\entities\FormElement::$type_definition as $type => $definition) {?>
                            <option><? echo $type;?></option>
                        <?}?>
                    </select>
                </p>
            </div>
            <button>add element</button>
            <button>create</button>
        </form>
    </div>
    <div class="forms-block">
        <?php foreach ($forms as $form) { ?>
            <div class="form" >
                <h2><? echo $form->getName(); ?></h2>
                <p><label> form name:</label><input type="text"  name="form[][name]" value ='<? echo $form->getName(); ?>' /></p>
                <p><label> form action:</label><input type="text"  name='form[][action]' value ='<? echo $form->getAction(); ?>'/></p>
                <p><label> form method:</label>
                    <select>
                        <? foreach ($form::$method_definition as $method => $definition) {?>
                            <option <? if ($form->getMethod() == $method) { echo 'selected = "selected"';}?>> <? echo $method;?></option>
                        <?}?>
                    </select>
                </p>
                <p><label> form enctype:</label>
                    <select name =''>
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
    </div>
</div>
<form>
</form>