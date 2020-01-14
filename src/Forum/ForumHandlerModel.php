<?php

namespace Anax\Forum;

use Anax\PostsWithTags\PostsWithTagsHandlerModel;

/**
 * Showing off a standard class with methods and properties.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class ForumHandlerModel
{
    public $forum;
    public $pwtModel;
    private $di;

    public function __construct($di)
    {
        $this->di = $di;
        $this->forum = new Forum();
        $this->forum->setDb($this->di->get("dbqb"));
        $this->pwtModel = new PostsWithTagsHandlerModel($this->di);
    }

    public function pageHandler($page)
    {
        $session = $this->di->get("session");
        $selectCondition = "F.id, F.id_user, U.acronym, F.topic, F.content, F.answered, F.created";
        $fromCondition = " AS F";
        $tableCondition = "User AS U";
        $joinCondition = "U.id = F.id_user";
        if (! $session->has('user') || is_null($session->get('user'))) {
            $threads = $this->forum->joinOneTable($selectCondition, $fromCondition, $tableCondition, $joinCondition);
            $threads = $this->pwtModel->getPwtIdQuery($threads);
            $page->add("forum/overview-common", [
                "threads" => $threads,
            ]);
        } else {
            $threads = $this->forum->joinOneTable($selectCondition, $fromCondition, $tableCondition, $joinCondition);
            $threads = $this->pwtModel->getPwtIdQuery($threads);
            $page->add("forum/overview-user", [
                "threads" => $threads,
            ]);
        }

        return $page;
    }

    public function findPostInfo($user, $created ,$topic)
    {
        $whereCondition = "id_user = ? AND created = ? AND topic = ?";
        $values = [$user, $created ,$topic];
        $post = $this->forum->findWhere($whereCondition, $values);

        return $post->id;
    }

    public function findLatestThreadLimit($limit)
    {
        $selectCondition = "F.id, U.acronym, F.topic, F.answered, F.created";
        $fromCondition = " AS F";
        $tableCon = "User AS U";
        $joinCon = "U.id = F.id_user";
        $orderByCon = "created DESC";
        $res = $this->forum->joinOneTableOrderbyLimit(
            $selectCondition,
            $fromCondition,
            $tableCon,
            $joinCon,
            $orderByCon,
            $limit
        );
        $res = $this->pwtModel->getPwtIdQuery($res);

        return $res;
    }

    public function checkUser($route)
    {
        $session = $this->di->get("session");

        switch ($route) {
            case "create-thread":
                if (! $session->has('user') || is_null($session->get('user'))) {
                    $this->di->get("response")->redirect("user/login")->send();
                }
                break;
        }
    }
}
