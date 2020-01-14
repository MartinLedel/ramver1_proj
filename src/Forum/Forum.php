<?php

namespace Anax\Forum;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model using the Active Record design pattern.
 */
class Forum extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Forum";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
     public $id;
     public $id_user;
     public $topic;
     public $content;
     public $answered;
     public $created;
}
