<?php

use Cake\ORM\TableRegistry;

$ipAddressesTable = TableRegistry::getTableLocator()->get('ip_addresses');
$ip = $this->request->clientIp();

$existingIP = $ipAddressesTable->find()
    ->where(['ip' => $ip])
    ->count();
$settingsTable = TableRegistry::getTableLocator()->get('settings');

if ($existingIP == 0) {
    // Insert the new IP address
    $ipAddressesTable->save($ipAddressesTable->newEntity(['ip' => $ip]));

    // Increment the visitor count
    $updator = $settingsTable->find()->where(['`key`' => 'Site.visitor'])->first();
    $updator->value += 1;
    $settingsTable->save($updator);
} else {
    // Display the visitor count
    $updateCount = $settingsTable->find()->where(['`key`' => 'Site.visitor'])->first()->value;
    $formattedNumber = str_pad($updateCount, 7, '0', STR_PAD_LEFT);
    foreach (str_split($formattedNumber) as $digit) {
        echo '<div class="box">' . $digit . '</div>';
    }
}
?>

<style>
    .counter {
        font-weight: 900;
    }

    .counter .h6 {
        color: darkred;
        font-weight: 800;
        letter-spacing: 3px;
    }

    .box {
        display: inline-block;
        height: auto;
        padding-left: 3px;
        padding-right: 3px;
        background-color: #f2f2f2;
        border: 1px solid #ccc;
        text-align: center;
        margin-right: 1px;
        font-weight: bold;
    }
</style>