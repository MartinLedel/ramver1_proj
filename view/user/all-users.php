<?php

namespace Anax\View;

use Anax\User\UserHandlerModel;

// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

$model = new UserHandlerModel;

?><h1>All users</h1>

<table>
    <tr>
        <th>Avatar</th>
        <th>Username</th>
        <th>Email</th>
    </tr>
    <?php foreach ($users as $user) : ?>
    <tr>
        <td><img src="<?= $model->getGravatar($user->email) ?>"></td>
        <td><a href="<?= url("user/common/$user->id") ?>"><?= $user->acronym ?></a></td>
        <td><?= $user->email ?></td>
    </tr>
    <?php endforeach; ?>
</table>
