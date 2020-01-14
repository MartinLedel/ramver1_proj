<?php

namespace Anax\Comments;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model using the Active Record design pattern.
 */
class Comments extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Comments";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
     public $id;
     public $id_user;
     public $id_forum;
     public $id_thread;
     public $content;
     public $created;
}
