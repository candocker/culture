<?php

declare(strict_types = 1);

namespace ModuleCulture\Models;

class CultureCategory extends AbstractModel
{
    protected $table = 'culture_category';
    protected $fillable = ['name'];
    protected $guarded = ['id'];

    public function parentElem()
    {
        return $this->hasOne('ModuleCulture\Models\CultureCategory', 'code', 'parent_code');
    }

    public function getUrl()
    {
        $url = $this->getResource()->getPointDomain('cultureDomain') . 'list/' . $this->code;
        return $url;
    }

    public function formatForBlog()
    {
        return [
            [
                //'_id' => '589e07c04a4ad562430953d0',
                'id' => 1,
                'name' => $this->name,
                'slug' => $this->code,
                'description' => '不知道啊',
                'extends' => [
                    ['name' => 'icon', 'value' => 'icon-thinking'],
                    ['name' => 'background', 'value' => 'https://static.surmon.me/thumbnail/heart-sutra.jpg'],
                ],
                'pid' => NULL,
                //'__v' => 0,
                //'create_at' => '2017-02-10T18:34:40.680Z',
                //'update_at' => '2021-12-11T06:12:16.084Z',
            ],
        ];
    }
}
