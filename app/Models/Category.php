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

}
