<?php

namespace Anax\View;

use Anax\User\UserHandlerModel;

// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

$model = new UserHandlerModel;

?><h1>User <?= $user->acronym ?></h1>

<table>
    <tr>
        <th>Avatar</th>
        <th>Username</th>
        <th>Email</th>
    </tr>
    <tr>
        <td><img src="<?= $model->getGravatar($user->email) ?>"></td>
        <td><?= $user->acronym ?></td>
        <td><?= $user->email ?></td>
    </tr>
</table>
<i class="fas fa-check" style="color:green"></i> = answered.
<table>
    <tr>
        <th>Thread topic</th>
        <th>Tags</th>
    </tr>
    <?php foreach ($forumPosts as $forum) : ?>
    <tr>
        <?php if ($forum->answered == "Yes") : ?>
            <td><a href="thread/show-post/<?= $forum->id ?>"><?= $forum->topic ?></a> <i class="fas fa-check" style="color:green"></i></td>
        <?php else : ?>
            <td><a href="thread/show-post/<?= $forum->id ?>"><?= $forum->topic ?></a> <i class="fas fa-check"></i></td>
        <?php endif; ?>
        <td><?= $forum->tags ?></td>
    </tr>
    <?php endforeach; ?>
</table>
