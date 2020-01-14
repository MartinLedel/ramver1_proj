<?php

namespace Anax\Comments;

/**
 * Showing off a standard class with methods and properties.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class CommentsHandlerModel
{
    private $di;

    public function __construct($di)
    {
        $this->di = $di;
    }

    public function checkUser($route)
    {
        $session = $this->di->get("session");

        switch ($route) {
            case "create-comment":
                if (! $session->has('user') || is_null($session->get('user'))) {
                    $this->di->get("response")->redirect("user/login")->send();
                }
                break;
        }
    }
}
