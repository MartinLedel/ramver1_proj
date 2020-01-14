<?php

namespace Anax\Forum\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\Forum\Forum;
use Anax\Forum\ForumHandlerModel;
use Anax\Tags\Tags;
use Anax\Tags\TagsHandlerModel;
use Anax\PostsWithTags\PostsWithTags;

/**
 * Form to create an item.
 */
class CreateThreadForm extends FormModel
{
    public $postId;

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
                "legend" => "First thread post",
            ],
            [
                "id-user" => [
                    "type"        => "hidden",
                    "value" => $di->get("session")->get("user")["id"],
                ],

                "created" => [
                   "type" => "hidden",
                   "value" => date("Y-m-d H:i:s"),
               ],

                "topic" => [
                    "type"        => "text",
                    "validation" => ["not_empty"],
                ],

                "tags" => [
                    "type"        => "checkbox-multiple",
                    "values" => $this->getTags(),
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
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function getTags()
    {
        $model = new TagsHandlerModel($this->di);
        $allTags = $model->tagsForForm();

        return $allTags;
    }

    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        $forum = new Forum();
        $forum->setDb($this->di->get("dbqb"));
        // Get values from the submitted form
        $forum->id_user       = $this->form->value("id-user");
        $forum->created       = $this->form->value("created");
        $forum->topic         = $this->form->value("topic");
        $forum->content       = $this->form->value("content");
        $forum->answered      = "No";
        $forum->save();

        $forumModel = new ForumHandlerModel($this->di);
        $this->postId = $forumModel->findPostInfo(
            $this->form->value("id-user"),
            $this->form->value("created"),
            $this->form->value("topic")
        );

        $checkedTags = [];
        $checkedTags = $this->form->value("tags");
        if (empty($checkedTags)) {
            $checkedTags[] = "Other";
        }

        foreach ($checkedTags as $tag) {
            $tagModel = new TagsHandlerModel($this->di);
            $tagId = $tagModel->findTagInfo($tag);

            $pwt = new PostsWithTags();
            $pwt->setDb($this->di->get("dbqb"));
            $pwt->id_forum = $this->postId;
            $pwt->id_tags = $tagId;
            $pwt->save();
        }

        return true;
    }



    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("thread/show-post/$this->postId")->send();
    }
}
