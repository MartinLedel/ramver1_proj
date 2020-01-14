<?php

namespace Anax\Thread\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\Thread\Thread;

/**
 * Form to create an item.
 */
class CreatePostForm extends FormModel
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
                "legend" => "Add a post to thread #" . $di->get("session")->get("postId"),
            ],
            [
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
                    "value" => "Create post",
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
        $thread = new Thread();
        $thread->setDb($this->di->get("dbqb"));
        // Get values from the submitted form
        $thread->id_user       = $this->form->value("id-user");
        $thread->id_forum      = $this->form->value("id-post");
        $thread->content       = $this->form->value("content");
        $thread->answer        = "No";

        $thread->save();

        return true;
    }



    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        $postId = $this->di->get("session")->get("postId");
        $this->di->get("response")->redirect("thread/show-post/$postId")->send();
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
