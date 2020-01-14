<?php

namespace Anax\View;

use Anax\User\UserHandlerModel;

/**
 * View to display all users.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

$model = new UserHandlerModel;

?>
<div class="index-flex">
<div class="index-col1 columns">
<h1>Most active users</h1>
<table>
    <tr>
        <th>Avatar</th>
        <th>Username</th>
        <th>Email</th>
    </tr>
    <?php foreach ($users as $user) : ?>
    <tr>
        <td><img src="<?= $model->getGravatar($user->email) ?>"></td>
        <td><a href="user/common/<?= $user->id ?>"><?= $user->acronym ?></a></td>
        <td><?= $user->email ?></td>
    </tr>
    <?php endforeach; ?>
</table>
</div>

<div class="index-col1 has-user columns">
<h1>Popular tags</h1>

<table>
    <tr>
        <th>Name</th>
    </tr>
    <?php foreach ($tags as $tag) : ?>
    <tr>
        <td><a href="tags/show-tag/<?= $tag->id ?>"><?= $tag->tag ?></a></td>
    </tr>
    <?php endforeach; ?>
</table>
</div>
</div>

<div class="col columns">
<h1>Newly created threads</h1>
<i class="fas fa-check" style="color:green"></i> = answered.
<table>
    <tr>
        <th>Thread name</th>
        <th>Made by</th>
        <th>Tags</th>
    </tr>
    <?php foreach ($threads as $thread) : ?>
    <tr>
    <?php if ($thread->answered == "Yes") : ?>
        <td><a href="thread/show-post/<?= $thread->id ?>"><?= $thread->topic ?></a> <i class="fas fa-check" style="color:green"></i></td>
    <?php else : ?>
        <td><a href="thread/show-post/<?= $thread->id ?>"><?= $thread->topic ?></a> <i class="fas fa-check"></i></td>
    <?php endif; ?>
        <td><?= $thread->acronym ?></td>
        <td><?= $thread->tags ?></td>
    </tr>
    <?php endforeach; ?>
</table>
</div>
