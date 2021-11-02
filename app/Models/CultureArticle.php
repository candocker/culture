<?php

declare(strict_types = 1);

namespace ModuleCulture\Models;

class CultureArticle extends AbstractModel
{
    protected $table = 'culture_article';
    //protected $fillable = ['name', 'content'];
    protected $guarded = ['id'];

    public function cultureCategory()
    {
        return $this->hasOne('ModuleCulture\Models\CultureCategory', 'code', 'category_code');
    }

    public function getUrl()
    {
        $url = $this->getResource()->getPointDomain('cultureDomain') . 'show-' . $this->id;
        return $url;
    }
}
