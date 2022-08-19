<?php

declare(strict_types = 1);

namespace ModuleCulture\Models;

class Dynasty extends AbstractModel
{
    protected $table = 'dynasty';
    protected $guarded = ['id'];

    public function emperors()
    {
        return $this->hasMany(Emperor::class, 'dynasty', 'code');//->orderBy('serial', 'asc');
    }
}
