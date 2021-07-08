<?php

namespace ModuleCulture\Models;

class Book extends AbstractModel
{
    protected $table = 'book';
    protected $primaryKey = 'code';
    protected $keyType = 'string';

    public function chapters()
    {
        return $this->hasMany(Chapter::class, 'book_code', 'code')->orderBy('serial', 'asc');
    }

    public function tagInfos()
    {
        return $this->hasMany(TagInfo::class, 'info_id', 'id')->where('info_type', 'book');
    }

    public function authorInfo()
    {
        return $this->hasOne(Figure::class, 'code', 'author');
    }

	/*public $cover;
	public $tag;

    public function rules()
    {
        return [
			[['code', 'name'], 'required'],
            [['status'], 'default', 'value' => ''],
            [['publish_at'], 'default', 'value' => 0],
            [['position', 'tag', 'cover', 'title', 'author', 'note', 'publish_at', 'description'], 'safe'],
        ];
    }

	public function _afterSaveOpe($insert, $changedAttributes)
	{
		if (empty($this->tag)) {
			return true;
		}
		$tags = is_array($this->tag) ? $this->tag : explode(',', $this->tag);
		foreach ($tags as $tag) {
			$data = ['name' => $tag, 'info_type' => 'book', 'info_id' => $this->id];
			$this->getPointModel('tag-info-culture')->createRecord($data);
		}
		return true;
	}

	public function _getSingleAttachments()
	{
		return ['cover'];
	}

    protected function _getTemplatePointFields()
    {
        return [
            'plat' => ['type' => 'key'],
			'login_url' => ['type' => 'inline', 'method' => '_getLoginUrl', 'formatView' => 'raw'],
            //'note' => ['type' => 'change', 'formatView' => 'raw', 'width' => '50'],
            //'author' => ['type' => 'change', 'formatView' => 'raw', 'width' => '50'],
            'position' => ['type' => 'changedown'],
			'extFields' => ['operation'],
			'listNo' => [
				'updated_at', 'description'
			],
        ];
    }

	public function getCoverUrl()
	{
		return $this->_getThumb('cover');
    }

	public function getAuthorName()
	{
		return $this->getPointName('figure', ['code' => $this->author]);
    }

	public function getTagDatas()
	{
		return $this->getInfoTags($this->id, 'culture', 'book');
	}

	public function _sceneFields()
	{
		return [
			'base' => ['id', 'code', 'author', 'name', 'description', 'coverUrl', 'tagDatas', 'authorName'],
			'ext' => ['coverUrl', 'tagDatas', 'authorName'],
		];
	}

    public function formatOperation($view)
    {
        $menuCodes = [
            'culture_chapter_listinfo' => '',
        ];
        return $this->_formatMenuOperation($view, $menuCodes, ['book_code' => 'code']);
    }

	public function formatToArray($withChapters = false)
	{
		$data = $this->_restBaseData('list');
		if ($withChapters) {
			$chapters = $this->getPointInfos('chapter', ['indexName' => 'serial', 'where' => ['book_code' => $this->code], 'orderBy' => ['serial' => SORT_ASC]]);
			$data['chapters'] = $chapters;
			$data['chapterNum'] = count($chapters);
		}
		return $data;
    }*/
}
