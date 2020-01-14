<?php

namespace Anax\View;

/**
 * View to display all users.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

?><h1>All avaible tags</h1>

<table>
    <tr>
        <th>Tags</th>
        <th>Nr of threads</th>
    </tr>
    <?php foreach ($tags as $tag) : ?>
    <tr>
        <td><a href="tags/show-tag/<?= $tag->id ?>"><?= $tag->tag ?></a></td>
        <td style="text-align:center"><?= $tag->nr_th ?></a></td>
    </tr>
    <?php endforeach; ?>
</table>
