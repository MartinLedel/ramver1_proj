<?php

namespace Anax\View;

// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Create urls for navigation
$urlToCreate = url("forum");

?><h1>Create thread</h1>

<?= $form ?>

<p>
    <a href="<?= $urlToCreate ?>"><i class="fas fa-arrow-left"></i> Back</a>
</p>
