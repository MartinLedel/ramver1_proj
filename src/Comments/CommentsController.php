<?php

namespace Anax\Comments;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\Comments\HTMLForm\CreateCommentForm;
use Anax\Forum\Forum;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class CommentsController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public $model;

    public function initialize()
    {
        $this->model = new CommentsHandlerModel($this->di);
    }

    /**
     * Handler with form to create a new item.
     *
     * @return object as a response object
     */
    public function createCommentAction(int $threadId, int $postId) : object
    {
        $this->model->checkUser($this->di, "create-comment");
        $this->di->get("session")->set("postId", $postId);
        $this->di->get("session")->set("threadId", $threadId);
        $page = $this->di->get("page");
        $form = new CreateCommentForm($this->di);
        $form->check();

        $page->add("thread/create-post", [
            "threadId" => $threadId,
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Create comment",
        ]);
    }
}
