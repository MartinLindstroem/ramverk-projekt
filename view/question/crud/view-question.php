<?php

namespace Anax\View;

$filters = ["bbcode", "clickable", "shortcode", "markdown"];
$questionUser = new \Marty\User\User();
$questionUser->setdB($di->get("dbqb"));
$questionPostedBy = $questionUser->find("username", $question->posted_by);
$avatar = $questionPostedBy->avatar;
?>
<div>
    <p>Asked: <?= $item->posted ?></p>
    <p>Asked by: <a href= <?= url("user/profile/{$item->posted_by}"); ?>><?= $item->posted_by ?></a> <img src=<?= $avatar ?> alt=""></p>
    
    <?php if ($item->updated) : ?>
        <p>Last edited: <?= $item->updated ?></p>
    <?php
        endif;
    ?>
    <p><a href=<?= url("questions/update/{$item->id}"); ?>> Edit</a></p>
    <div class="content">
        <h1><?= $item->title ?></h1>
        <?= $textfilter->doFilter($item->content, $filters) ?>
    </div>
    <h2>comments</h2>
    <div class="comments">
        <?php foreach ($comments as $comment) : ?>
            <div class="comment">
                <?= $textfilter->doFilter($comment->content, $filters) ?>
                <a href= <?= url("user/profile/{$comment->posted_by}"); ?>><?= $comment->posted_by ?></a>
                <br>
                <?= $comment->posted ?>
            </div>
        <?php endforeach; ?>
    </div>
    <?php if($user) : ?>
        <div>
            <?= $questionCommentForm ?>
        </div>
    <?php endif; ?>
</div>

<h2><?= count($answers) ?> Answers</h2>
<?php $comment->setDb($di->get("dbqb")); ?>
<?php foreach ($answers as $answer) : ?>
    <?php
        $formId += 1;
        $answerComments = $comment->findAllWhere("answer_id = ?", $answer->id);
        $answerCommentForm = new \Marty\Comment\HTMLForm\CreateForm($this->di, $answer->id, "answer", $formId);
        $answerCommentForm->check();

        $answerUser = new \Marty\User\User();
        $answerUser->setdB($di->get("dbqb"));
        $answerPostedBy = $answerUser->find("username", $answer->posted_by);
        $avatar = $answerPostedBy->avatar;
    ?><div class="answer">
        <a name=<?= $answer->id ?>></a>
        <div class="content">
            <?= $textfilter->doFilter($answer->content, $filters) ?>
        </div>
        <div class="info">
            <div class="user">
                <span>
                <p>Answered by: <a href= <?= url("user/profile/{$answer->posted_by}"); ?>><?= $answer->posted_by ?></a></p>
                <img src=<?= $avatar ?> alt="avatar">
                </span>
                
            </div>
            <p>Answered: <?= $answer->posted ?></p>
            <?php if($answer->updated) : ?>
                <p>Last edited: <?= $answer->updated ?></p>
            <?php endif; ?>
            <?php if($user == $answer->posted_by) : ?>
                <p>
                    <a href= <?= url("answer/update/{$answer->id}"); ?>>edit</a>
                    <!-- <a href= <?= url("answer/delete/{$answer->id}"); ?>>delete</a> -->
                </p>
            <?php endif; ?>
        </div>
        <h2>comments</h2>
        <div class="comments">
            <?php foreach ($answerComments as $answerComment) : ?>
                <div class="comment">
                    <?= $textfilter->doFilter($answerComment->content, $filters) ?>
                    <p><a href= <?= url("user/profile/{$answerComment->posted_by}"); ?>><?= $answerComment->posted_by ?></a></p>
                    <!-- <img src=<?= $an ?> alt=""> -->
                </div>
            <?php endforeach; ?>
        </div>
        <?php if ($user) : ?>
            <div>
                <?= $answerCommentForm->getHTML() ?>
            </div>
        <?php endif; ?>
    </div>
    <br>
    <?php endforeach; ?>
<br>
<div>
<?php if($user) : ?>
    <?= $form ?>
<?php else : ?>
    <p>Log in to post an answer to this question</p>
<?php endif; ?>
</div>
