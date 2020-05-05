<?php
declare(strict_types=1);

namespace App\Queries\Comment;

use App\Models\Comment;
use Illuminate\Database\Connection;

class CommentsQuery
{
    /** @var Comment */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function fetchAll()
    {
       $select = [
           'id',
           'post_id',
           'parent_id',
           'author_name',
           'text',
           'created_at',
           'updated_at'
       ];

       $qb = $this->connection
                ->table('comments')
                ->select($select)

            ->whereRaw('parent_id IS NULL')->get();

       return $qb;
    }
}
