<?php

declare(strict_types = 1);

namespace ModuleCulture\Models;

class ShelfBook extends AbstractModel
{
    protected $table = 'shelf_book';
    //protected $guarded = ['id'];

    public function book()
    {
        return $this->hasOne(Book::class, 'code', 'book_code');
    }
}
