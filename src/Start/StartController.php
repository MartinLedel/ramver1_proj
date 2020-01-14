<?php

namespace Anax\Start;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\User\UserHandlerModel;
use Anax\Forum\ForumHandlerModel;
use Anax\Tags\TagsHandlerModel;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class StartController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public $userModel;
    public $forumModel;
    public $tagsModel;

    public function initialize()
    {
        $this->userModel = new UserHandlerModel($this->di);
        $this->forumModel = new ForumHandlerModel($this->di);
        $this->tagsModel = new TagsHandlerModel($this->di);
    }

    /**
     * Show all users.
     *
     * @return object as a response object
     */
    public function indexAction() : object
    {
        $page = $this->di->get("page");

        $page->add("index/overview", [
            "users" => $this->userModel->getActiveUsersLimit("4"),
            "threads" => $this->forumModel->findLatestThreadLimit("4"),
            "tags" => $this->tagsModel->getPopularTagsLimit("4"),
        ]);

        return $page->render([
            "title" => "Overview",
        ]);
    }
}
