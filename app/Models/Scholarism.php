<?php

declare(strict_types = 1);

namespace ModuleCulture\Models;

class Scholarism extends AbstractModel
{
    protected $table = 'scholarism';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function book()
    {
        return $this->hasOne(Book::class, 'code', 'book_code');
    }
}
