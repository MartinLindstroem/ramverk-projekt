<?php

namespace Anax\View;

/**
 * View to display all books.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;

// Create urls for navigation
$urlToCreate = url("questions/create");


?><h1>Questions</h1>

<?php if($user) : ?>
<p>
    <a href="<?= $urlToCreate ?>">Ask a question</a>
</p>
<?php endif; ?>

<?php if (!$items) : ?>
    <p>There are no questions to show.</p>
<?php
    return;
endif;
?>

<?php 
// usort($items, function($a, $b) {return strcmp(strtotime($b->posted), strtotime($a->posted));}); 
// var_dump($items)
?>

<?php foreach ($items as $item) : ?>
<div class="question">
    <h3><a href= <?= url("questions/question/{$item->id}"); ?>><?= $item->title ?></a></h3>
    <?php if (strlen($item->content) > 150) : ?>
        <p><?= substr($item->content, 0, 150) ?>...</p>
    <?php else : ?>
        <p><?= $item->content ?></p>
    <?php endif; ?>
</div>
<?php endforeach; ?>
