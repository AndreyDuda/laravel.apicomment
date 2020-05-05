<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Comment
 * @package App\Models
 *
 * @property Comment $children
 * @property string  $author_name
 * @property string  $comment
 */
class Comment extends Model
{
    use SoftDeletes;

    protected $table = 'comments';

    protected $fillable = [
        'parent_id',
        'author_name',
        'comment'
    ];

    protected $dates = ['deleted_at'];

    public function children()
    {
        return $this->hasMany(Comment::class,  'parent_id');
    }
}
