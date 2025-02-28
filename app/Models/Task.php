<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * Поля, которые можно массово заполнять.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'completed',
        'category_id',
    ];

    /**
     * Отношение "Задача принадлежит категории".
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
