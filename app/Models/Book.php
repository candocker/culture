<?php

namespace ModuleCulture\Models;

class Book extends AbstractModel
{
    protected $table = 'book';
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    protected $guarded = ['id'];

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

    public function authorInfos($type = null)
    {
        $datas = [];
        $where = ['book_code' => $this->code];
        if (!is_null($type)) {
            $where['type'] = $type;
        }
        return BookFigure::where($where)->get();
    }

    public function formatAuthorData($return = 'name')
    {
        $infos = $this->authorInfos();
        if ($return == 'name') {
            $string = '';
            foreach ($infos as $info) {
                $string .= $info->figure ? $info->figure['name'] . '-' . $info->figure['name_code'] : '匿名';
            }
            return $string;
        }
    }

    public function getCoverUrlAttribute()
    {
        $url = $this->getRepositoryObj()->getAttachmentUrl(['info_table' => 'book', 'info_field' => 'cover', 'info_id' => $this->code]);
        $url = $url ? $url : 'http://ossfile.canliang.wang/book/0921a8be-f9e6-4a31-87e3-b31f023b96a0.jpg';
        return $url;
    }

    public function afterSave()
    {
        $request = request();
        $creative = $request->input('creative');
        if (!is_null($creative)) {
            $this->getModelObj('bookFigure')->recordCreative($creative, $this->code);
        }

        return true;
    }

    public function getCreative($type = 'all')
    {
        $infos = $this->getCreativeDatas();
        $repository = $this->getRepositoryObj('book');
        $creativeDatas = $repository->getKeyValues('creative');
        $result = [];
        foreach ($infos as $key => $value) {
            $kName = $creativeDatas[$key] ?? $key;
            foreach ($value as $fCode => $fName) {
                $result["{$key}:{$fCode}"] = "{$kName}:{$fName}";
            }
        }
        return ['source' => $result, 'show' => implode('||', $result)];
    }

    public function getCreativeDatas($type = null)
    {
        $where = ['book_code' => $this->code];
        $infos = $this->getModelObj('bookFigure')->where($where)->orderBy('type')->get();
        $results = [];
        foreach ($infos as $info) {
            $figure = $info->figure;
            $results[$info['type']][$figure['code']] = $figure['name'];
        }
        if (!is_null($type)) {
            return $results[$type] ?? [];
        }
        return $results;
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

	public function getTagDatas()
	{
		return $this->getInfoTags($this->id, 'culture', 'book');
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
