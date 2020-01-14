<?php

namespace Anax\View;

// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

?><h1>Create comment</h1>

<?= $form ?>

<p>
    <a href="thread/show-post/<?= $threadId ?>"><i class="fas fa-arrow-left"></i> Back</a>
</p>
