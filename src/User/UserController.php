<?php

namespace Anax\User;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\User\HTMLForm\CreateForm;
use Anax\User\HTMLForm\LoginForm;
use Anax\User\HTMLForm\UpdateForm;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class UserController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    public $model;

    public function initialize()
    {
        $this->model = new UserHandlerModel($this->di);
    }

    /**
     * Show all users.
     *
     * @return object as a response object
     */
    public function indexAction() : object
    {
        $page = $this->di->get("page");
        $user = new User();
        $user->setDb($this->di->get("dbqb"));

        $page->add("index/overview", [
            "users" => $user->findAllLimit("3"),
        ]);

        return $page->render([
            "title" => "Overview",
        ]);
    }

    /**
     * Handler with form to create a new item.
     *
     * @return object as a response object
     */
    public function allUsersAction() : object
    {
        $page = $this->di->get("page");
        $user = new User();
        $user->setDb($this->di->get("dbqb"));

        $page->add("user/all-users", [
            "users" => $user->findAll(),
        ]);

        return $page->render([
            "title" => "All users",
        ]);
    }

    /**
     * Handler with form to create a new item.
     *
     * @return object as a response object
     */
    public function commonAction(int $id) : object
    {
        $page = $this->di->get("page");
        $user = new User();
        $user->setDb($this->di->get("dbqb"));

        $page->add("user/common-user", [
            "user" => $user->find("id", $id),
            "forumPosts" => $this->model->forumPostsQuery($id),
        ]);

        return $page->render([
            "title" => "User",
        ]);
    }

    /**
     * Handler with form to create a new item.
     *
     * @return object as a response object
     */
    public function loginAction() : object
    {
        // $this->model->checkUserLogin($this->di);
        $this->model->checkUser("login");
        $page = $this->di->get("page");
        $form = new LoginForm($this->di);
        $form->check();

        $page->add("user/login", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Login",
        ]);
    }

    /**
     * Handler with form to create a new item.
     *
     * @return object as a response object
     */
    public function logoutAction() : object
    {
        // $this->model->checkUserLogout($this->di);
        $this->model->checkUser("logout");
        $this->model->logoutUser();
    }

    /**
     * Handler with form to create a new item.
     *
     * @return object as a response object
     */
    public function profileAction() : object
    {
        $this->model->checkUser("profile");
        $page = $this->di->get("page");

        $page->add("user/profile", [
            "user" => $this->di->get("session")->get("user"),
        ]);

        return $page->render([
            "title" => "User profile",
        ]);
    }

    /**
     * Handler with form to update an item.
     *
     * @param int $id the id to update.
     *
     * @return object as a response object
     */
    public function createUserAction() : object
    {
        $page = $this->di->get("page");
        $form = new CreateForm($this->di);
        $form->check();

        $page->add("user/create", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Create user",
        ]);
    }

    /**
     * Handler with form to update an item.
     *
     * @param int $id the id to update.
     *
     * @return object as a response object
     */
    public function updateUserAction(int $id) : object
    {
        $this->model->checkUser("update");
        $page = $this->di->get("page");
        $form = new UpdateForm($this->di, $id);
        $form->check();

        $page->add("user/update", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Update user",
        ]);
    }
}
