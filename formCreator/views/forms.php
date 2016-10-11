<div class="main-block">
    <div class="new-form">

    </div>
    <div class="forms-block">
        <?php foreach ($forms as $form) { ?>
            <div id="form_<?php echo $form->getID()?>">
                <h4><?php echo $form->getName(); ?></h4>
                <!--<form  name="<?/* echo $form['name']*/?>" action="<?/* echo $form['action']*/?>" type="<?/* echo $form['type']*/?>" method="<?/* echo $form['method']*/?>">
                    <?php /*foreach ($form['form_elements'] as $element) {

                    }
                    */?>
                </form>-->

            </div>
        <?php } ?>
    </div>
</div>
<form>
</form>