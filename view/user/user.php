<?php

namespace Anax\View;

?>

<h1 style="border-bottom: none;"><?= $user->username ?> <img src=<?= $user->avatar ?> alt=""></h1>
<a href= <?= url("user/update/{$user->username}") ?>>Edit profile</a>
<br>
<a href=<?= url("user/logout") ?>>Sign Out</a>
<div>
    <p>Joined: <?= $user->created ?></p>
</div>
<p>Posts</p>
<div class="posts">
<?php foreach ($questions as $question) : ?>
    <p>Q: <a href= <?= url("questions/question/{$question->id}"); ?>><?= $question->title ?></a></p>
<?php endforeach; ?>
<?php foreach ($answers as $answer) : ?>
    <?php
        $question = new \Marty\Question\Question();
        $question->setDb($di->get("dbqb"));
        $questionAnswer = $question->findWhere("id = ?", $answer->question_id);
    ?>
    <p>A: <a href= <?= url("questions/question/{$answer->question_id}#{$answer->id}"); ?>><?= $questionAnswer->title ?></a></p>
<?php endforeach; ?>
</div>