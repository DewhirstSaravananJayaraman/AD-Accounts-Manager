<?php

/*
 * The MIT License
 *
 * Copyright 2019 cjacobsen.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

use app\models\database\EmailDatabase;
use system\app\forms\Form;
use system\app\forms\FormText;
use system\app\forms\FormRadio;
use system\app\forms\FormButton;
use system\app\forms\FormHTML;

$email = new EmailDatabase();
$form = new Form('/settings/email');

$smtpServer = new FormText("SMTP Server", 'Enter the SMTP server address',
        'smtpServer', $email->getSMTPServer());

$smtpPort = new FormText('SMTP Port', 'Enter the SMTP server port', 'smtpPort', $email->getSMTPPort());

$useSMTPAuth = new FormRadio('Use SMTP Auth', 'Use SMTP user authentication', 'useSMTPAuth');
$useSMTPAuth->addOption('False', 0, !$email->getUseSMTPAuth());
$useSMTPAuth->addOption('True', 1, $email->getUseSMTPAuth());

$smtpUsername = new FormText("SMTP Username", 'SMTP Auth username',
        'smtpUsername', $email->getSMTPUsername());

$smtpPassword = new FormText("SMTP Password", 'SMTP Auth password',
        'smtpPassword', $email->getSMTPPassword());

$useSMTPSSL = new FormRadio('Use SMTP over SSL', 'Sends emails securly', 'useSMTPSSL');
$useSMTPSSL->addOption('False', 0, !$email->getUseSMTPSSL());
$useSMTPSSL->addOption('True', 1, $email->getUseSMTPSSL());

$replyAddress = new FormText("Reply-To Address", 'The reply-to address for emails sent from this app',
        'replyAddress', $email->getReplyToAddress());

$replyName = new FormText("Reply-To Name", 'The reply-to display name for emails sent from this app',
        'replyName', $email->getReplyToName());

$fromAddress = new FormText("From Address", 'The from address for emails sent from this app',
        'fromAddress', $email->getFromAddress());

$fromName = new FormText("From Name", 'The from display name for emails sent from this app',
        'fromName', $email->getFromName());









$saveButton = new FormButton('Save');
$saveButton->small()
        ->addAJAXRequest('/api/settings/email', 'settingsOutput', $form);

$form->addElementToNewRow($smtpServer)
        ->addElementToCurrentRow($smtpPort)
        ->addElementToNewRow($smtpUsername)
        ->addElementToCurrentRow($smtpPassword)
        ->addElementToNewRow($useSMTPAuth)
        ->addElementToCurrentRow($useSMTPSSL)
        ->addElementToNewRow($fromAddress)
        ->addElementToCurrentRow($fromName)
        ->addElementToNewRow($replyAddress)
        ->addElementToCurrentRow($replyName)
        ->addElementToNewRow($saveButton);
echo $form->print();

$form = new Form('', 'testEmail');
$action = new FormText('', '', 'action', 'test');
$action->hidden();
$testRecipient = new FormText("<br><br>Send Test Email", "Enter an address to send a test to.", "to");
$testResult = new FormHTML('', '', 'result');
$testResult->setId('emailTestOutput');
$testEmail = new FormButton("Test Email");
$testEmail->setType("button")
        ->small()
        ->addAJAXRequest('/api/email', $testResult, $form, true);
$form->addElementToNewRow($testResult)
        ->addElementToNewRow($action)
        ->addElementToNewRow($testRecipient)
        ->addElementToNewRow($testEmail);
echo $form->print();
?>

