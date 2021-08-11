<?php

declare(strict_types = 1);

namespace ModuleCulture\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ShelfBook extends AbstractModel
{
    use SoftDeletes;
    protected $table = 'shelf_book';
    protected $guarded = ['id'];

    public function shelf()
    {
        return $this->hasOne(Shelf::class, 'id', 'shelf_id');
    }

    public function book()
    {
        return $this->hasOne(Book::class, 'code', 'book_code');
    }
}
