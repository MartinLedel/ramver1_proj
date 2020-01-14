<?php

namespace Anax\Thread;

use Anax\Forum\Forum;
use Anax\Comments\Comments;
use Anax\MyTextFilter\MyTextFilterModel;
use Anax\PostsWithTags\PostsWithTagsHandlerModel;

/**
 * Showing off a standard class with methods and properties.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class ThreadHandlerModel
{
    public $forum;
    public $thread;
    public $comments;
    public $textFilter;
    public $pwtModel;
    private $di;

    public function __construct($di)
    {
        $this->di = $di;
        $this->textFilter = new MyTextFilterModel($this->di);
        $this->pwtModel = new PostsWithTagsHandlerModel($this->di);
        $this->forum = new Forum();
        $this->forum->setDb($this->di->get("dbqb"));
        $this->thread = new Thread();
        $this->thread->setDb($this->di->get("dbqb"));
        $this->comments = new Comments();
        $this->comments->setDb($this->di->get("dbqb"));
    }

    public function pageHandler($page, $id)
    {
        $session = $this->di->get("session");
        $openingPost = $this->openingPostAndCommentsQuery($id);
        $openingPost = $this->textFilter->loopText($openingPost);
        $openingPost = $this->pwtModel->getPwtIdQuery($openingPost);

        $threadPosts = $this->threadPostsAndCommentsQuery($id);
        $threadPosts = $this->textFilter->loopText($threadPosts);

        if ($session->get('user')["id"] == $openingPost["0"]->id_user) {
            $page->add("thread/show-post-user", [
                "openingPost" => $openingPost,
                "threadPosts" => $threadPosts,
            ]);
        } else {
            $page->add("thread/show-post", [
                "openingPost" => $openingPost,
                "threadPosts" => $threadPosts,
            ]);
        }

        return $page;
    }

    public function openingPostAndCommentsQuery($id)
    {
        $selectCondition = "F.id, F.id_user, U.acronym, F.topic, F.content, F.answered, F.created";
        $fromCondition = " AS F";
        $tableCondition = "User AS U";
        $joinCondition = "U.id = F.id_user";
        $where = "F.id = ?";
        $openingPost = $this->forum->joinOneTableWhere($selectCondition, $fromCondition, $tableCondition, $joinCondition, $where, $id);

        $commentPosts = $this->commentPostsQuery($id);

        foreach($openingPost as $post) {
            $combinedComments = [];
            foreach($commentPosts as $comment) {
                if ($post->id == $comment->id_forum && $comment->id_thread == 0) {
                    $combinedComments[] = $comment;
                }
            }
            $post->comments = $combinedComments;
        }

        return $openingPost;
    }

    public function threadPostsAndCommentsQuery($id)
    {
        $selectCondition = "T.id, T.id_user, T.id_forum, U.acronym, T.content, T.answer, T.created";
        $fromCondition = " AS T";
        $tableCondition = "User AS U";
        $joinCondition = "U.id = T.id_user";
        $where = "T.id_forum = ?";
        $threadPosts = $this->thread->joinOneTableWhere($selectCondition, $fromCondition, $tableCondition, $joinCondition, $where, $id);

        $commentPosts = $this->commentPostsQuery($id);

        foreach($threadPosts as $post) {
            $combinedComments = [];
            foreach($commentPosts as $comment) {
                if ($post->id == $comment->id_thread) {
                    $combinedComments[] = $comment;
                }
            }
            $post->comments = $combinedComments;
        }

        return $threadPosts;
    }

    public function commentPostsQuery($id)
    {
        $selectCondition = "C.id, C.id_user, C.id_forum, C.id_thread, U.acronym, C.content, C.created";
        $fromCondition = " AS C";
        $tableCondition = "User AS U";
        $joinCondition = "U.id = C.id_user";
        $where = "C.id_forum = ?";
        $commentPosts = $this->comments->joinOneTableWhere($selectCondition, $fromCondition, $tableCondition, $joinCondition, $where, $id);

        return $commentPosts;
    }

    public function checkAnswer($id)
    {
        $res = $this->getForumAndThread($id);

        if ($res[0]->answer == "Yes") {
            $this->thread->answer = "No";
            $this->forum->answered = "No";
        } elseif($res[0]->answer == "No") {
            $this->thread->answer = "Yes";
            $this->forum->answered = "Yes";
        }

        $this->thread->id = $res[0]->id;
        $this->thread->id_user = $res[0]->id_user;
        $this->thread->id_forum = $res[0]->id_forum;
        $this->thread->content = $res[0]->t_data;
        $this->thread->created = $res[0]->t_time;
        $this->thread->save();

        $this->forum->id = $res[0]->id_forum;
        $this->forum->id_user = $res[0]->id_user;
        $this->forum->topic = $res[0]->topic;
        $this->forum->content = $res[0]->f_data;
        $this->forum->created = $res[0]->f_time;
        $this->forum->save();
    }

    public function getForumAndThread($id)
    {
        $select = "T.id, T.id_user, T.id_forum, T.content AS t_data, T.answer, T.created AS t_time, F.topic, F.content AS f_data, F.answered, F.created AS f_time";
        $from = " AS T";
        $table = "Forum AS F";
        $join = "F.id = T.id_forum";
        $where = "T.id = ?";
        $res = $this->thread->joinOneTableWhere($select, $from, $table, $join, $where, $id);

        return $res;
    }

    public function checkUser($route)
    {
        $session = $this->di->get("session");

        switch ($route) {
            case "create-post":
                if (! $session->has('user') || is_null($session->get('user'))) {
                    $this->di->get("response")->redirect("user/login")->send();
                }
                break;
        }
    }
}
