<?php

namespace Anax\View;

// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());
$urlToCreate = url("forum");

?><h1>Create post</h1>

<?= $form ?>

<p>
    <a href="<?= $urlToCreate ?>"><i class="fas fa-arrow-left"></i> Back</a>
</p>
