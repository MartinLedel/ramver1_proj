<?php

namespace Anax\Forum;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\Forum\HTMLForm\CreateThreadForm;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class ForumController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public $model;

    public function initialize()
    {
        $this->model = new ForumHandlerModel($this->di);
    }

    /**
     * Show all users.
     *
     * @return object as a response object
     */
    public function indexAction() : object
    {
        $page = $this->di->get("page");

        //Shows two different pages depending if user is logged in or not.
        $page = $this->model->pageHandler($page);

        return $page->render([
            "title" => "Forum start page",
        ]);
    }

    /**
     * Handler with form to create a new item.
     *
     * @return object as a response object
     */
    public function createThreadAction() : object
    {
        $this->model->checkUser("create-thread");
        $page = $this->di->get("page");
        $form = new CreateThreadForm($this->di);
        $form->check();

        $page->add("forum/create-thread", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Create thread",
        ]);
    }
}
