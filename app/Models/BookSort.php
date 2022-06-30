<?php

declare(strict_types = 1);

namespace ModuleCulture\Models;

class BookSort extends AbstractModel
{
    protected $table = 'book_sort';
    public $incrementing = false;
    protected $primaryKey = 'code';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function getBookNumAttribute()
    {
        return Book::query()->where('category', $this->code)->count();
    }
}
