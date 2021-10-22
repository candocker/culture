<?php

declare(strict_types = 1);

namespace ModuleCulture\Models;

class CultureCategory extends AbstractModel
{
    protected $table = 'culture_category';
    protected $fillable = ['name'];

    public function parentElem()
    {
        return $this->hasOne('ModuleCulture\Models\CultureCategory', 'code', 'parent_code');
    }

    public function getUrl()
    {
        $url = $this->getResource()->getPointDomain('cultureDomain') . 'list/' . $this->code;
        return $url;
    }
}
