<?php
/**
 * Supply the basis for the navbar as an array.
 */
$user = isset($_SESSION["user"]) ? $_SESSION["user"] : null;
return [
    // Use for styling the menu
    "wrapper" => null,
    "class" => "my-navbar rm-default rm-desktop",
 
    // Here comes the menu items
    "items" => [
        [
            "text" => "Hem",
            "url" => "",
            "title" => "",
        ],
        [
            "text" => "Om",
            "url" => "om",
            "title" => "",
        ],
        [
            "text" => "Questions",
            "url" => "questions",
            "title" => "",
        ],
        [
            "text" => "Tags",
            "url" => "tags",
            "title" => "",
        ],
        // [
        //     "text" => "Sign up",
        //     "url" => "user/register",
        //     "title" => "Sign up",
        // ],
        ($user ? ["text" => "Profile", "url" => "user/profile/{$user}", "title" => "Profile"] : ["text" => "Sign up", "url" => "user/register", "title" => "Sign up"])
    ],
];
