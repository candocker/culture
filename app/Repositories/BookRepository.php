<?php
declare(strict_types = 1);

namespace ModuleCulture\Repositories;

class BookRepository extends AbstractRepository
{
    protected function _sceneFields()
    {
        return [
            'list' => ['id', 'code', 'sort', 'category', 'cover', 'name', 'creative', 'baidu_url_show', 'baidu_url', 'wiki_url', 'position', 'orderlist', 'note', 'description', 'updated_at', 'publish_at', 'status'],
            //'list' => ['id', 'code', 'sort', 'name', 'creative', 'baidu_url_show', 'baidu_url', 'description', 'publish_at'],
            'listSearch' => ['id', 'code', 'name'],
            'add' => ['code', 'cover', 'sort', 'name', 'creative', 'baidu_url', 'wiki_url', 'position', 'orderlist', 'note', 'description', 'publish_at', 'status'],
            'update' => ['code', 'cover', 'sort', 'name', 'creative', 'baidu_url', 'wiki_url', 'position', 'orderlist', 'note', 'description', 'publish_at', 'status'],

            'frontshow' => ['code', 'cover', 'sort', 'name', 'creative', 'baidu_url', 'wiki_url', 'position', 'orderlist', 'note', 'description', 'publish_at', 'status'],
        ];
    }

    public function getShowFields()
    {
        return [
            'category' => ['valueType' => 'select', 'showType' => 'select'],
            'sort' => ['valueType' => 'select', 'showType' => 'select', 'infos' => $this->getPointKeyValues('bookSort')],
            'creative' => ['valueType' => 'extinfo', 'extType' => 'creative'],
        ];
    }

    public function getFormFields()
    {
        return [
            'creative' => ['type' => 'complexSelectSearch', 'typeInfos' => $this->getKeyValues('creative'), 'searchResource' => 'figure'],
            'sort' => ['type' => 'select', 'infos' => $this->getPointKeyValues('bookSort')],
            'category' => ['type' => 'select', 'infos' => $this->getKeyValues('category')],
            //'user_id' => ['type' => 'selectSearch', 'require' => ['add'], 'searchResource' => 'user'],
            //'birthday' => ['type' => 'dateinfo', 'eraInfos' => $this->getKeyValues('eraType')],
        ];
    }

    public function getSearchFields()
    {
        return [
        ];
    }

    public function getSearchDealFields()
    {
        return [
        ];
    }

    public function _getFieldOptions()
    {
        return [
        ];
    }

	public function _positionKeyDatas()
	{
		return [
			'reading' => '在读书籍',
			'favor' => '排行榜',
		];
	}

	public function getNavBooks($number = 4)
	{
        $model = $this->getModelObj('tag');
        $navTags = $model->where(['status' => 'nav'])->orderBy('orderlist', 'desc')->get();
		$datas = [];
		foreach ($navTags as $tag) {
            $code = $tag['code'];
			$datas[$code] = $tag;
            $books = $this->getPointTagBooks($code, $number);
			$datas[$code]['books'] = $books;
		}
		return $datas;
	}

    public function getPositionBooks($number = 10)
    {
		$positions = $this->_positionKeyDatas();
		$datas = [];
        $model = $this->getModelObj();
		foreach ($positions as $position => $pName) {
            $number = $position == 'favor' ? 3 : $number;
			$data['name'] = $pName;
			$bDatas = $model->where(['position' => $position])->orderBy('orderlist', 'desc')->limit($number)->get();
            $bDatas = $this->getCollectionObj(null, ['resource' => $bDatas, 'scene' => 'frontInfo', 'repository' => $this]);
			$data['books'] = $bDatas;
			$datas[$position] = $data;
		}
        return $datas;
    }

	public function getPointTagBooks($tagCode, $number)
	{
        $model = $this->getModelObj();
        $infos = $model->whereHas('tagInfos', function ($query) use ($tagCode) {
            $query->where('tag_code', $tagCode);
        })->limit($number)->get();
        $infos = $this->getCollectionObj(null, ['resource' => $infos, 'scene' => 'frontInfo', 'repository' => $this]);
        return $infos;
	}

	public function _statusKeyDatas()
	{
		return [
			'0' => '录入',
			'1' => '完成',
            '99' => '下架',
		];
	}

	public function _creativeKeyDatas()
	{
		return [
			'author' => '作者',
            'editor' => '编者',
			'translator' => '译者',
            'correct' => '校正',
		];
	}

    public function _categoryKeyDatas()
    {
        return [
            'american' => '美国学术',
            //'assembly' => '汇编/综合',
            'britain' => '英国学术',
            'china' => '中国学术',
            //'classical' => '中华古典',
            'essence' => '精华',
            'france' => '法国学术',
            'germany' => '德国学术',
            //'history' => '历史',
            'kafka' => '卡夫卡',
            'lresearch' => '鲁迅研究',
            'luxun' => '鲁迅',
            'other' => '其他学术',
            //'philosophy' => '哲学',
            'scholarism' => '学术名著',
        ];
    }

    public function getDefaultSort()
    {
        return ['id' => 'desc'];
    }

    public function _sortKeyDatas()
    {
        return $this->getPointCaches('bookSort', 'tree');
    }

    public function _categoryDatas()
    {
        return $this->getPointCaches('category', 'tree');
    }

    public function getDetail($code)
    {
        $model = $this->getModelObj('book');
        $info = $model->where(['code' => $code])->first();

        $resource = $this->getResourceObj(null, ['resource' => $info, 'scene' => 'frontDetail', 'repository' => $this, 'simpleResult' => false]);
        return $resource;
    }
}
