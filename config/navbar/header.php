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
            "text" => "Home",
            "url" => "home",
            "title" => "",
        ],
        // [
        //     "text" => "About",
        //     "url" => "about",
        //     "title" => "",
        // ],
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
        [
            "text" => "About",
            "url" => "about",
            "title" => "",
        ],
        ($user ? ["text" => "Profile", "url" => "user/profile/{$user}", "title" => "Profile"] : ["text" => "Sign up", "url" => "user/register", "title" => "Sign up"])
    ],
];
