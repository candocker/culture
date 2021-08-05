<?php

declare(strict_types = 1);

namespace ModuleCulture\Models;

class Shelf extends AbstractModel
{
    protected $table = 'shelf';
    protected $guarded = ['id'];

    public function books()
    {
        return $this->hasMany(ShelfBook::class, 'shelf_id', 'id')->orderBy('id', 'desc');
    }
}
