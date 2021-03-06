<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Comment
 * @package App\Models
 *
 * @property int     $id
 * @property int     $post_id
 * @property Comment $replies
 * @property string  $author_name
 * @property string  $text
 * @property string  $created_at
 * @property string  $updated_at
 * @property string  $deleted_at
 */
class Comment extends Model
{
    use SoftDeletes;

    protected $table = 'comments';

    protected $fillable = [
        'post_id',
        'parent_id',
        'author_name',
        'text',
        'replies'
    ];

    protected $dates = ['deleted_at'];

    protected $softCascade = ['replies'];

    public function replies()
    {
        return $this->hasMany(Comment::class,  'parent_id');
    }
}
