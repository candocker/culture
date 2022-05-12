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

    public function formatForBlog($type = null)
    {
        $data = [
            //'_id' => '621aa63da251efe10b93f33f',
            //'ad' => 1,
            'slug' => 'peace-and-love',
            'title' => $this->name,//'战争与和平',
            'description' => $this->description,//'Peace & Love',
            'keywords' => ['关键', '啥也不是'],
            'thumb' => 'http://39.106.102.45/readme-markdown.jpg',
            'src' => 'http://39.106.102.45/readme-markdown.jpg',
            'state' => 1,
            'public' => 1,
            'origin' => 0,
            'lang' => 'zh',
            'disabled_comment' => false,
            'meta' => ['likes' => 18, 'views' => 925, 'comments' => 9],
            'extends' => [],
            'create_at' => $this->created_at,
            'update_at' => $this->updated_at,
            'id' => $this['id'],
            //'__v' => 0,
        ];
        $category = $this->getModelObj('cultureCategory')->find(2);
        $categoryData = $category->formatForBlog();
        $data['category'] = $categoryData;
        $tags = $this->getModelObj('tag')->limit(3)->get();
        $tagDatas = [];
        foreach ($tags as $tag) {
            $tagDatas[] = $tag->formatForBlog();
        }
        if ($type == 'detail') {
            $data['content'] = $this->content;
        }
        $data['tag'] = $tagDatas;
        return $data;
    }
}
