<?php

namespace Anax\Comments\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\Comments\Comments;
use Anax\User\User;

/**
 * Form to create an item.
 */
class CreateCommentForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Add a comment to post",
            ],
            [
                "id-thread" => [
                    "type"        => "hidden",
                    "value" => $di->get("session")->get("threadId"),
                ],

                "id-post" => [
                    "type"        => "hidden",
                    "value" => $di->get("session")->get("postId"),
                ],

                "id-user" => [
                    "type"        => "hidden",
                    "value" => $di->get("session")->get("user")["id"],
                ],

                "content" => [
                    "type"        => "textarea",
                    "validation" => ["not_empty"],
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Create comment",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        $comments = new Comments();
        $comments->setDb($this->di->get("dbqb"));
        // Get values from the submitted form
        $comments->id_user       = $this->form->value("id-user");
        $comments->id_forum      = $this->form->value("id-thread");
        $comments->id_thread     = $this->form->value("id-post");
        $comments->content       = $this->form->value("content");
        $comments->save();

        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("id", $this->form->value("id-user"));
        $user->points = $user->points + 1;
        $user->save();

        return true;
    }



    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        $threadId = $this->di->get("session")->get("threadId");
        $this->di->get("response")->redirect("thread/show-post/$threadId")->send();
    }



    // /**
    //  * Callback what to do if the form was unsuccessfully submitted, this
    //  * happen when the submit callback method returns false or if validation
    //  * fails. This method can/should be implemented by the subclass for a
    //  * different behaviour.
    //  */
    // public function callbackFail()
    // {
    //     $this->di->get("response")->redirectSelf()->send();
    // }
}
