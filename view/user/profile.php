<?php

namespace Anax\View;

use Anax\User\UserHandlerModel;

// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

$model = new UserHandlerModel;

$id = $user["id"];
$urlToCreate = url("user/update-user/$id");

?><h1>Your profile</h1>

<table>
    <tr>
        <th>Avatar</th>
        <th>Username</th>
        <th>Email</th>
    </tr>
    <tr>
        <td><img src="<?= $model->getGravatar($user["email"]) ?>"></td>
        <td><?= $user["acronym"] ?></td>
        <td><?= $user["email"] ?></td>
        <td><a href="<?= $urlToCreate ?>">Update user</a></td>
    </tr>
</table>
