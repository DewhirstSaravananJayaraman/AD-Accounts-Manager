


<h3>
    Student Account Lock/Unlock Manager
</h3>

<?php

use System\App\Forms\Form;
use System\App\Forms\FormButton;
use System\App\Forms\FormText;
use System\App\Forms\FormDropdown;

$actionArray = [["Unlock", "unlock"]];
if ($this->user->privilege >= \App\Models\User\Privilege::TECH) {
    $actionArray[] = ["Lock", "lock"];
}
$form = new Form();

$form->buildUserSearchInput()
        ->addToNewRow()
        ->buildDropDownInput('Action', 'action', $actionArray)
        ->small()
        ->addToNewRow()
        ->buildSubmitButton('Submit')
        ->addToNewRow();


//echo $form->getFormHTML();
$form = new Form("/students/account-status-change", "StudentAccountStatusChange");
$button = new FormButton("Submit");
$button->small();
$textBox = new FormText("Username", "Can also enter first or last name to search for username.", "username");
$textBox->autoCompleteStudentUsername()
        ->appendIcon('<i class="fas fa-search"></i>');
$action = new FormDropdown("Action", '', "action");
$action->createOption("Unlock", "unlock")
        ->createOption("Lock", "lock");
if ($this->user->privilege >= \App\Models\User\Privilege::ADMIN) {
    $action->createOption("Enable", "enable")
            ->createOption("Disable", "disable");
}
$form->addElementToNewRow($textBox)
        ->addElementToNewRow($action)
        ->addElementToNewRow($button);
echo $form->print();
