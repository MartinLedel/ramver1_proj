<?php

namespace Anax\Tags;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\Forum\ForumModelHandler;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class TagsController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public $model;

    public function initialize()
    {
        $this->model = new TagsHandlerModel($this->di);
    }

    /**
     * Show all users.
     *
     * @return object as a response object
     */
    public function indexAction() : object
    {
        $page = $this->di->get("page");

        $page->add("tags/all-tags", [
            "tags" => $this->model->tagsAndCount(),
        ]);

        return $page->render([
            "title" => "Overview",
        ]);
    }

    /**
     * Show all users.
     *
     * @return object as a response object
     */
    public function showTagAction(int $id) : object
    {
        $page = $this->di->get("page");

        $page->add("tags/show-tag", [
            "threads" => $this->model->tagAndPostsQuery($id),
        ]);

        return $page->render([
            "title" => "Threads under tag",
        ]);
    }
}
