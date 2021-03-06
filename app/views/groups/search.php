<?php

use System\App\Forms\Form;
use System\App\Forms\FormButton;
use System\App\Forms\FormText;

$createButton = new FormButton("<i class=\"fas fa-plus\"></i>");
$createButton->tiny()
    ->setTheme("white")
    ->setTooltip('Create a new group')
    ->setId('create_new_group_button')
//    ->removeInputClasses(["w-100"])
    ->addInputClasses("text-success right")
    ->addElementClasses(" right pr-5 d-inline h-100 ");
$createModal = new \App\Models\View\Modal();
$createModal->setBody($this->view('/groups/create'))
    ->setId('createGroup')
    ->setTitle("Create New Group");
$createButton->addModal($createModal);
?>

    <div class="col mb-2">
        <h3 class=" d-inline card-title text-center">
            Group Search
        </h3>

        <?php
        if (\App\Models\User\PermissionHandler::hasGroupPermissions(\App\Models\User\PermissionLevel::GROUP_ADD)) {
            echo $createButton->print();
        }
        ?>
    </div>
<?php
$form = new Form("/groups/search", "GroupSearch");
$button = new FormButton("Search");
$button->small();
$groupSearchBox = new FormText("Group", "Can search by name, email, or description", "group");
$groupSearchBox->autoCompleteGroupName()
    ->autofocus()
    ->setId("group")
// ->appendIcon('<i class="fas fa-search"></i>')
    ->medium();
$appendImg = new \System\App\Forms\FormHTML();
$appendImg->setHtml('<i class="fas fa-search"></i>')
    ->addInputClasses('input-group-text text-center');

$inputGroup = new \System\App\Forms\FormElementGroup("Group", "Can search by name, email, or description");
$inputGroup->addElementToGroup($appendImg)
    ->addElementToGroup($groupSearchBox)
    ->medium();
$form
    ->addElementToNewRow($inputGroup)
    ->addElementToNewRow($button)
    ->setActionVariable($groupSearchBox);
echo $form->print();





