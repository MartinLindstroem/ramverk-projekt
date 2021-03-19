<?php

namespace Anax\View;

?>

<h1>Questions tagged <?= $tag ?></h1>

<?php foreach ($questions as $question) : ?>
    <div class="question">
    <h3><a href= <?= url("questions/question/{$question->id}"); ?>><?= $question->title ?></a></h3>
    <?= $question->content ?>
    </div>
<?php endforeach; ?>