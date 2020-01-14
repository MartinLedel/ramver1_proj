<?php

namespace Anax\View;

/**
 * View to display all users.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

?><h1>All posts associated with that tag</h1>

<table>
    <tr>
        <th>Thread name</th>
    </tr>
    <?php foreach ($threads as $thread) : ?>
    <tr>
        <td><a href="../../thread/show-post/<?= $thread->id_forum ?>"><?= $thread->topic ?></a></td>
    </tr>
    <?php endforeach; ?>
</table>
