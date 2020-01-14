<?php

namespace Anax\Thread;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\Thread\HTMLForm\CreatePostForm;
use Anax\MyTextFilter\MyTextFilterModel;


// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class ThreadController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public $model;
    public $textFilter;

    public function initialize()
    {
        $this->model = new ThreadHandlerModel($this->di);
        $this->textFilter = new MyTextFilterModel($this->di);
    }

    /**
     * Show all users.
     *
     * @return object as a response object
     */
    public function showPostAction(int $id) : object
    {
        $page = $this->di->get("page");
        $page = $this->model->pageHandler($page, $id);

        return $page->render([
            "title" => "Thread #$id",
        ]);
    }



    /**
     * Handler with form to create a new item.
     *
     * @return object as a response object
     */
    public function createPostAction(int $id) : object
    {
        $this->model->checkUser("create-post");
        $this->di->get("session")->set("postId", $id);
        $page = $this->di->get("page");
        $form = new CreatePostForm($this->di);
        $form->check();

        $page->add("thread/create-post", [
            "threadId" => $id,
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Create forum post",
        ]);
    }

    /**
     * Handler with form to create a new item.
     *
     * @return object as a response object
     */
    public function answerAction(int $id) : object
    {
        $this->model->checkAnswer($id);

        $this->di->get("response")->redirect("thread/show-post/$id")->send();
    }
}
