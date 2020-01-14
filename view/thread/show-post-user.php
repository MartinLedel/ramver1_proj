<?php

namespace Anax\View;

/**
 * View to display all users.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

$urlToCreate = url("forum");

?><h1><?= $openingPost["0"]->topic ?></h1>

<p>
    <a href="<?= $urlToCreate ?>"><i class="fas fa-arrow-left"></i> Back</a>
</p>
<div class="thread-col columns">
<p>
    OP: <a href="../../user/common/<?= $openingPost["0"]->id_user ?>"><?= $openingPost["0"]->acronym ?></a> Created: <?= $openingPost["0"]->created ?>
</p>
<p>
    <?= $openingPost["0"]->content ?>
</p>
<a href="../../comment/create-comment/<?= $openingPost["0"]->id ?>/0">Create comment</a>
<a href="../../thread/create-post/<?= $openingPost["0"]->id ?>">Create post</a>
Tags: <?= $openingPost["0"]->tags ?>
</div>
<?php foreach ($openingPost["0"]->comments as $comment) : ?>
    <div class="thread-comment columns">
    <p>
        Commenter: <a href="../../user/common/<?= $comment->id_user ?>"><?= $comment->acronym ?></a> Created: <?= $comment->created ?>
    </p>
    <p>
        <?= $comment->content ?>
    </p>
    </div>
<?php endforeach; ?>

<?php foreach ($threadPosts as $post) : ?>
    <div class="thread-post columns">
    <p>
        <?php if ($post->answer == "Yes") : ?>
            <a href="../../thread/answer/<?= $post->id ?>"><i class="fas fa-check" style="color:green"></i></a>
            Poster: <a href="../../user/common/<?= $post->id_user ?>"><?= $post->acronym ?></a> Created: <?= $post->created ?>
        <?php else : ?>
            <a href="../../thread/answer/<?= $post->id ?>"><i class="fas fa-check" style="color:black"></i></a>
            Poster: <a href="../../user/common/<?= $post->id_user ?>"><?= $post->acronym ?></a> Created: <?= $post->created ?>
        <?php endif; ?>
    </p>
    <p>
        <?= $post->content ?>
    </p>
    <a href="../../comment/create-comment/<?= $post->id_forum ?>/<?= $post->id ?>">Create comment</a>
    </div>
    <?php foreach ($post->comments as $comment) : ?>
    <div class="thread-comment columns">
        <p>
            Commenter: <a href="../../user/common/<?= $comment->id_user ?>"><?= $comment->acronym ?></a> Created: <?= $comment->created ?>
        </p>
        <p>
            <?= $comment->content ?>
        </p>
    </div>
    <?php endforeach; ?>
<?php endforeach; ?>
