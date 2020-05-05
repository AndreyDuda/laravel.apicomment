<?php
declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    static $max = 0;
    $parentId = $faker->numberBetween($min = 0, $max++);
    return [
        'parent_id'   => $parentId ? $parentId : null,
        'author_name' => $faker->name,
        'comment'     => $faker->sentence(3, 15)
    ];
});
