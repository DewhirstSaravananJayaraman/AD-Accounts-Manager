<?php

use App\App\AppUpdater;
use App\Models\View\Toast;
use System\Updater;

?>
<h2>

    <?= $this->applicationName ?>
</h2>

<?php
echo $this->motd;
//echo phpinfo();

$updater = new AppUpdater();

if ($this->user->superAdmin && $updater->isUpdateAvailable()) {
    $toastBody = 'Version: ' . $updater->getLatestUpdateFromURL()->version . '<div><a href="/settings/update">Update
 here</a></div>';

    $toast = new Toast('New version available!', $toastBody, 10000);
    $toast->closable();
    echo $toast->printToast();
}

?>


