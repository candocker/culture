<?php

declare(strict_types = 1);

namespace ModuleCulture\Models;

class Category extends AbstractModel
{
    protected $table = 'category';
    public $incrementing = false;
    protected $primaryKey = 'code';
    public $timestamps = false;
    //protected $guarded = ['id'];

    public function getBookNumAttribute()
    {
        return Book::query()->orWhere('category_first', $this->code)->orWhere('category_second', $this->code)->orWhere('category_third', $this->code)->count();
    }
}
