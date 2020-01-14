<?php

namespace Anax\PostsWithTags;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model using the Active Record design pattern.
 */
class PostsWithTags extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "PostsWithTags";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
     public $id;
     public $id_forum;
     public $id_tags;
}
