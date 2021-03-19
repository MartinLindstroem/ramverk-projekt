<?php

namespace Marty\Comment;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model using the Active Record design pattern.
 */
class Comment extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Comment";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $question_id;
    public $answer_id;
    public $content;
    public $posted_by;
    public $posted;
    public $updated;
    public $deleted;
}
