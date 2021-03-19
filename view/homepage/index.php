<?php

?>
<div class="region-main has-sidebar-right has-sidebar">
    <h1>Latest posts</h1>
    <?php foreach ($latestQuestions as $question) : ?>
    <div class="question">
    <h2><a href= "questions/question/<?= $question->id ?>"><?= $question->title ?></a></h2>
    <?php if (strlen($question->content) > 150) : ?>
        <p><?= substr($question->content, 0, 150) ?>...</p>
    <?php else : ?>
        <p><?= $question->content ?></p>
    <?php endif; ?>
    </div>
    <?php endforeach; ?>
    
</div>
<div class="wrap-sidebar region-sidebar-right">
    <div class="block top-tags">
        <h3>Top tags</h3>

        <?php foreach (array_slice($frequentTags, 0, 3) as $tagName => $value) : ?>
        <p><a href="questions/tagged/<?= $tagName ?>"><?= $tagName ?></a></p>
        <?php endforeach; ?>
    </div>

    <div class="block active-users">
        <h3>Recently active users</h3>

        <?php foreach (array_slice($activeUsers, 0, 4) as $username => $active) : ?>
        <p><a href="user/profile/<?= $username ?>"><?= $username ?></a></p>
        <?php endforeach; ?>
    </div>
</div>


