<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 13.11.16
 * Time: 14.07
 */
spl_autoload_register(function ($class) {
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    require_once '../'.$file;
});
?>

<div style="margin: 0 auto; width: 60%;">

    <h1>This is my test page</h1>

    <div>
        <h1> Please submit tour data</h1>
        <?php formCreator\Application::printForm('myForm'); ?>

        <pre> data
                data .......
        </pre>
    </div>
</div>
<a href="/">main page</a>