<?php

namespace Anax\Thread;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model using the Active Record design pattern.
 */
class Thread extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Thread";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
     public $id;
     public $id_user;
     public $id_forum;
     public $content;
     public $answer;
     public $created;
}
