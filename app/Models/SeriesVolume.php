<?php

declare(strict_types = 1);

namespace ModuleCulture\Models;

class SeriesVolume extends AbstractModel
{
    protected $table = 'series_volume';
    protected $guarded = ['id'];

    public function series()
    {
        return $this->belongsTo(Series::class, 'series_code', 'code');
    }
}
