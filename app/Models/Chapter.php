<?php

namespace ModuleCulture\Models;

class Chapter extends AbstractModel
{
    protected $table = 'chapter';
    protected $guarded = ['id'];

    public function tagInfos()
    {
        return $this->hasMany(TagInfo::class, 'info_id', 'id')->where('info_type', 'book');
    }

    public function book()
    {
        return $this->hasOne(Book::class, 'code', 'book_code');
    }

    public function author()
    {
        return $this->hasOne(Figure::class, 'code', 'author');
    }

	public function getContent()
	{
		return $this->getChapterFile($this);
	}

    /*public function rules()
    {
        return [
			[['name'], 'required'],
            [['status'], 'default', 'value' => ''],
            [['description'], 'safe'],
        ];
    }

    protected function _getTemplatePointFields()
    {
        return [
            'plat' => ['type' => 'key'],
			'login_url' => ['type' => 'inline', 'method' => '_getLoginUrl', 'formatView' => 'raw'],
			'listNo' => [
				'updated_at', 'description'
			],
        ];
    }

	public function _relateDataInfos()
	{
		return ['book'];
	}

	public function _sceneFields()
	{
		return [
			'show' => ['id', 'name', 'serial', 'content'],
			'ext' => ['content'],
			'list' => ['id', 'name', 'code', 'serial'],
			'listNo' => ['content'],
		];
    }*/
}
