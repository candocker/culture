<?php
declare(strict_types = 1);

namespace ModuleCulture\Repositories;

class BookRepository extends AbstractRepository
{
    protected function _sceneFields()
    {
        return [
            'list' => ['id', 'code', 'cover', 'name', 'title', 'author', 'position', 'orderlist', 'note', 'description', 'created_at', 'updated_at', 'publish_at', 'status'],
            'listSearch' => ['id', 'code', 'title', 'author', 'name'],
            'add' => ['code', 'cover', 'name', 'title', 'author', 'position', 'orderlist', 'note', 'description', 'publish_at', 'status'],
            'update' => ['code', 'cover', 'name', 'title', 'author', 'position', 'orderlist', 'note', 'description', 'publish_at', 'status'],
        ];
    }

    public function getFormFields()
    {
        return [
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

    public function getDefaultSort()
    {
        return ['id' => 'desc'];
    }
}
