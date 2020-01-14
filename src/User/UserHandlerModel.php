<?php

namespace Anax\User;

use Anax\Forum\Forum;
use Anax\PostsWithTags\PostsWithTagsHandlerModel;

/**
 * Showing off a standard class with methods and properties.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class UserHandlerModel
{
    public $forum;
    public $user;
    public $pwtModel;
    private $di;

    public function __construct($di=null)
    {
        $this->di = $di;
        if(isset($this->di)) {
            $this->pwtModel = new PostsWithTagsHandlerModel($this->di);
        }
        $this->user = new User();
        if(isset($this->di)) {
            $this->user->setDb($this->di->get("dbqb"));
        }
        $this->forum = new Forum();
        if(isset($this->di)) {
            $this->forum->setDb($this->di->get("dbqb"));
        }
    }


    /*
    * Method for $di
    */
    public function getGravatar($email, $sss = 80, $ddd = 'mp', $rrr = 'g', $img = false, $atts = array())
    {
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$sss&d=$ddd&r=$rrr";
        if ($img) {
            $url = '<img src="' . $url . '"';
            foreach ($atts as $key => $val) {
                $url .= ' ' . $key . '="' . $val . '"';
            }
            $url .= ' />';
        }
        return $url;
    }

    public function forumPostsQuery($id)
    {
        $selectCondition = "F.id, F.id_user, U.acronym, F.topic, F.content, F.answered, F.created";
        $fromCondition = " AS F";
        $tableCondition = "User AS U";
        $joinCondition = "U.id = F.id_user";
        $where = "F.id_user = ?";
        $forumPost = $this->forum->joinOneTableWhere($selectCondition, $fromCondition, $tableCondition, $joinCondition, $where, $id);
        $forumPost = $this->pwtModel->getPwtIdQuery($forumPost);

        return $forumPost;
    }

    public function getActiveUsersLimit($limit)
    {
        $selectCon = "U.id, U.acronym, U.email, (COUNT(F.id_user) + COUNT(T.id_user) + COUNT(C.id_user)) AS activity";
        $fromCon = " AS U";
        $tOneCon = "Forum AS F";
        $jOneCon = "F.id_user = U.id";
        $tTwoCon = "Thread AS T";
        $jTwoCon = "T.id_user = U.id";
        $tThreeCon = "Comments AS C";
        $jThreeCon = "C.id_user = U.id";
        $groupbyCon = "U.acronym";
        $orderbyCon = "activity DESC";
        $res = $this->user->joinThreeTableGroupByOrderByLimit($selectCon, $fromCon, $tOneCon, $jOneCon, $tTwoCon, $jTwoCon, $tThreeCon, $jThreeCon, $groupbyCon, $orderbyCon, $limit);

        return $res;
    }

    public function calculateRank($user)
    {
        $points = $user->points;
        if ($points == 20) {
            $user->rank = "Low rank";
        } elseif($points == 40) {
            $user->rank = "High rank";
        } elseif($points == 60) {
            $user->rank = "Master rank";
        } else {
            $user->rank = "New user";
        }

        return $user;
    }

    public function checkUser($route)
    {
        $session = $this->di->get("session");

        switch ($route) {
            case "login":
                if ($session->has('user')) {
                    $this->di->get("response")->redirect("user/logout")->send();
                }
                break;
            case "logout":
                if (! $session->has('user') || is_null($session->get('user'))) {
                    $this->di->get("response")->redirect("user/login")->send();
                }
                break;
            case "profile":
                if (! $session->has('user') || is_null($session->get('user'))) {
                    $this->di->get("response")->redirect("user/login")->send();
                }
                break;
            case "update":
                if (! $session->has('user') || is_null($session->get('user'))) {
                    $this->di->get("response")->redirect("user/login")->send();
                }
                break;
        }
    }

    public function logoutUser()
    {
        $this->di->get("session")->set("user", null);
        $this->di->get("response")->redirect("user/login")->send();
    }
}
