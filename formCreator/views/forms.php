<div class="main-block">
    <div class="new-form">

    </div>
    <div class="forms-block">
        <?php foreach ($forms as $form) { ?>
            <div id="form_<? echo $form->id_form?>">
                <h4><? echo $form->getName(); ?></h4>
                <form  name="<? echo $form['name']?>" action="<? echo $form['action']?>" type="<? echo $form['type']?>" method="<? echo $form['method']?>">
                    <? foreach ($form['form_elements'] as $element) {

                    }
                    ?>
                </form>
                <? echo $form['id_form']; ?>
            </div>
        <?php } ?>
    </div>
</div>
<form>
</form>