


<h3>
    Student H-Drive Utility
</h3>

<?php

use System\App\Forms\Form;

$form = new Form();
$form->buildTextInput('Username', 'username')
        ->medium()
        ->addToNewRow()
        ->buildDropDownInput('', 'action', ['query' => 'Query', 'fix' => 'Fix Permissions'])
        ->small()
        ->addToNewRow()
        ->buildSubmitButton('Submit')
        ->addToNewRow();


echo $form->getFormHTML();
