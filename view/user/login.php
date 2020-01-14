<?php

namespace Anax\View;

/**
 * View to display all books.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Create urls for navigation
$urlToCreate = url("user/create-user");

?><h1>Login</h1>

<?= $form ?>

<p>
    <a href="<?= $urlToCreate ?>">Create user</a>
</p>
