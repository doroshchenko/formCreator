<div class="main-block">
    <div class="new-form">

    </div>
    <div class="forms-block">
        <?php foreach ($forms as $form) { ?>
            <div id="form_<? echo $form->getID()?>">
                <h2><? echo $form->getName(); ?></h2>
                    <p><label> form name:</label><input type="text"  name="form[][name]" value ='<? echo $form->getName(); ?>'/></p>
                    <p><label> form action:</label><input type="text"  name='form[][action]' value ='<? echo $form->getAction(); ?>'/></p>
                    <p><label> form type:</label><input type="text"  name='form[][action]' value ='<? echo $form->getType(); ?>'/></p>
                    <p><label> form method:</label><input type="text"  name='form[][action]' value ='<? echo $form->getmethod(); ?>'/></p>
                    <div class="form_elements">
                        <h3> Elements </h3>
                        <? $elements = ($form->getElements()) ? $form->getElements() : array(); ?>
                        <? foreach ($elements as $element) {?>
                            <p>     <? var_dump(\formCreator\entities\FormElement::$definition);?>
                                <label> element name:</label><input type="text"  name="form[][element][name]" value ='<? echo $element->getName(); ?>'/>
                                <label> element type:</label><input type="<?echo $element->getType();?>"  name="form[][element][name]" value ='<? echo $element->getName(); ?>'/>
                            </p>
                        <?}?>
                    </div>
            </div>
        <?php } ?>
    </div>
</div>
<form>
</form>