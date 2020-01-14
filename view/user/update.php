<?php

namespace Anax\View;

/**
 * View to create a new book.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());
// Create urls for navigation
$urlToCreate = url("user/profile");



?><h1>Update user</h1>

<p>
    <a href="<?= $urlToCreate ?>"><i class="fas fa-arrow-left"></i> Back</a>
</p>

<?= $form ?>
