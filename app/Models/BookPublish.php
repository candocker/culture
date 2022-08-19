<?php

declare(strict_types = 1);

namespace ModuleCulture\Models;

class BookPublish extends AbstractModel
{
    protected $table = 'book_publish';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function book()
    {
        return $this->belongsTo(Book::class, 'code', 'book_code');
    }
}
