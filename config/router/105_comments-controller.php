<?php
/**
 * Routes for controller.
 */
return [
    "routes" => [
        [
            "info" => "Controller for comment managment.",
            "mount" => "comment",
            "handler" => "\Anax\Comments\CommentsController",
        ],
    ]
];
