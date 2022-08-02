<?php

declare(strict_types = 1);

namespace ModuleCulture\Models;

class Series extends AbstractModel
{
    protected $table = 'series';
    protected $guarded = ['id'];

    public function volumes()
    {
        return $this->hasMany(SeriesVolume::class, 'series_code', 'code')->orderBy('orderlist', 'asc');
    }
}
