<?php

declare(strict_types = 1);

namespace ModuleCulture\Models;

class Rubbing extends AbstractModel
{
    protected $table = 'rubbing';
    protected $guarded = ['id'];

    public function calligrapher()
    {
        return $this->hasOne(Calligrapher::class, 'code', 'calligrapher_code');
    }
}
