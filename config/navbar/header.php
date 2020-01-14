<?php

global $di;

$session = $di->get("session");

if (! $session->has('user') || is_null($session->get('user'))) {
    /**
     * Supply the basis for the navbar as an array.
     */
    return [
        // Use for styling the menu
        "wrapper" => null,
        "class" => "my-navbar rm-default rm-desktop",

        // Here comes the menu items
        "items" => [
            [
                "text" => "Overview",
                "url" => "start",
                "title" => "Start page.",
            ],
            [
                "text" => "Forum",
                "url" => "forum",
                "title" => "Forum page.",
            ],
            [
                "text" => "Tags",
                "url" => "tags",
                "title" => "Forum tags.",
            ],
            [
                "text" => "Users",
                "url" => "user/all-users",
                "title" => "All users.",
            ],
            [
                "text" => "About",
                "url" => "about",
                "title" => "About this site.",
            ],
            [
                "text" => "Login",
                "url" => "user/login",
                "title" => "Start page.",
            ],
        ],
    ];
} else {
    /**
     * Supply the basis for the navbar as an array.
     */
    return [
        // Use for styling the menu
        "wrapper" => null,
        "class" => "my-navbar rm-default rm-desktop",

        // Here comes the menu items
        "items" => [
            [
                "text" => "Overview",
                "url" => "start",
                "title" => "Start page.",
            ],
            [
                "text" => "Forum",
                "url" => "forum",
                "title" => "Forum page.",
            ],
            [
                "text" => "Tags",
                "url" => "tags",
                "title" => "Forum tags.",
            ],
            [
                "text" => "Users",
                "url" => "user/all-users",
                "title" => "All users.",
            ],
            [
                "text" => "About",
                "url" => "about",
                "title" => "About this site.",
            ],
            [
                "text" => "Profile",
                "url" => "user/profile",
                "title" => "User profile.",
            ],
            [
                "text" => "Logout",
                "url" => "user/logout",
                "title" => "Logout page.",
            ],
        ],
    ];
}
