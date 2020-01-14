<?php

namespace Anax\View;

// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Create urls for navigation
$urlToCreate = url("start");

?><h1>Create user</h1>

<?= $form ?>

<p>
    <a href="<?= $urlToCreate ?>"><i class="fas fa-arrow-left"></i> Back</a>
</p>
