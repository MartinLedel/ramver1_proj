<?php

namespace Anax\View;

/**
 * View to display all users.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

$urlToCreate = url("forum/create-thread");

?><h1>All threads</h1>
<p>
    <a href="<?= $urlToCreate ?>">Create thread</a>
</p>
<i class="fas fa-check" style="color:green"></i> = answered.
<table>
    <tr>
        <th>Topic</th>
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
        <td><a href="user/common/<?= $thread->id_user ?>"><?= $thread->acronym ?></a></td>
        <td><?= $thread->tags ?></td>
    </tr>
    <?php endforeach; ?>
</table>
