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

?><h1>Tags</h1>

<?php if (!$items) : ?>
    <p>There are no tags to show.</p>
<?php
    return;
endif;
?>
<?php foreach ($items as $item) : ?>
<div class="tag">
        <a href="<?= url("questions/tagged/{$item->tag_name}"); ?>"><?= $item->tag_name ?></a>
</div>
<?php endforeach; ?>
