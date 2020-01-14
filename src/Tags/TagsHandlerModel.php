<?php

namespace Anax\Tags;

use Anax\PostsWithTags\PostsWithTagsHandlerModel;

/**
 * Showing off a standard class with methods and properties.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class TagsHandlerModel
{
    public $tags;
    public $pwtModel;
    private $di;

    public function __construct($di)
    {
        $this->di = $di;
        $this->tags = new Tags();
        $this->tags->setDb($this->di->get("dbqb"));
        $this->pwtModel = new PostsWithTagsHandlerModel($this->di);
    }

    public function tagsForForm()
    {
        $groupbyCondition = "tag";
        $allTags = $this->tags->findAllGroupBy($groupbyCondition);
        $tagList = [];
        foreach ($allTags as $tag) {
            $tagList[] = $tag->tag;
        }

        return $tagList;
    }

    public function findTagInfo($tag)
    {
        $where = "tag = ?";
        $tagId = $this->tags->findWhere($where, $tag);

        return $tagId->id;
    }

    public function tagsAndCount()
    {
        $selectCondition = "Tg.id, Tg.tag, COUNT(PWT.id_forum) AS nr_th";
        $fromCondition = " AS Tg";
        $tOneCon = "PostsWithTags AS PWT";
        $jOneCon = "Tg.id = PWT.id_tags";
        $groupbyCon = "Tg.id";
        $res = $this->tags->joinOneTableGroupBy(
            $selectCondition,
            $fromCondition,
            $tOneCon,
            $jOneCon,
            $groupbyCon
        );

        return $res;
    }

    public function getPopularTagsLimit($limit)
    {
        $selectCondition = "Tg.id, Tg.tag, COUNT(PWT.id_forum) AS nr_th";
        $fromCondition = " AS Tg";
        $tOneCon = "PostsWithTags AS PWT";
        $jOneCon = "Tg.id = PWT.id_tags";
        $groupbyCon = "Tg.id";
        $orderbyCon = "nr_th DESC";
        $res = $this->tags->joinOneTableGroupByOrderByLimit(
            $selectCondition,
            $fromCondition,
            $tOneCon,
            $jOneCon,
            $groupbyCon,
            $orderbyCon,
            $limit
        );

        return $res;
    }

    public function tagAndPostsQuery($id)
    {
        $selectCondition = "Tg.id, PWT.id_forum, F.topic";
        $fromCondition = " AS Tg";
        $tOneCon = "PostsWithTags AS PWT";
        $jOneCon = "Tg.id = PWT.id_tags";
        $tTwoCon = "Forum AS F";
        $jTwoCon = "PWT.id_forum = F.id";
        $where = "Tg.id = ?";
        $res = $this->tags->joinTwoTableWhere(
            $selectCondition,
            $fromCondition,
            $tOneCon,
            $jOneCon,
            $tTwoCon,
            $jTwoCon,
            $where,
            $id
        );

        return $res;
    }
}
