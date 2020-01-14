<?php

namespace Anax\PostsWithTags;

use Anax\Tags\Tags;

/**
 * Showing off a standard class with methods and properties.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class PostsWithTagsHandlerModel
{
    public $pwt;
    public $tagsModel;
    private $di;

    public function __construct($di)
    {
        $this->di = $di;
        $this->pwt = new PostsWithTags();
        $this->pwt->setDb($this->di->get("dbqb"));
        $this->tags = new Tags();
        $this->tags->setDb($this->di->get("dbqb"));
    }

    public function getPwtIdQuery($threads)
    {
        foreach($threads as $thread) {
            $tagIdArr = [];
            $tagArr = [];
            $selectCondition = "id, id_forum, id_tags";
            $whereCondition = "id_forum = ?";
            $tagIdArr[] = $this->pwt->findTableWhere($selectCondition, $whereCondition, $thread->id);
            foreach($tagIdArr["0"] as $tagId) {
                $selectCondition = "id, tag";
                $whereCondition = "id = ?";
                $tagArr[] = $this->tags->findTableWhere($selectCondition, $whereCondition, $tagId->id_tags)["0"]->tag;
            }
            $thread->tags = implode(",", $tagArr);
        }

        return $threads;
    }
}
