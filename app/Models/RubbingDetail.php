<?php

declare(strict_types = 1);

namespace ModuleCulture\Models;

class RubbingDetail extends AbstractModel
{
    protected $table = 'rubbing_detail';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function rubbingInfo()
    {
        return $this->belongsTo(Rubbing::class, 'rubbing_id', 'id');
    }
}
