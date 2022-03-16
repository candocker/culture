<?php

namespace ModuleCulture\Models;

//use baseapp\models\TagTrait;

class Tag extends AbstractModel
{
    protected $table = 'tag';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function formatForBlog()
    {
        return [
              //'_id' => '58a497c813edac2b82566cb3',
              'id' => $this->id,
              'name' => $this->name,
              'slug' => $this->code,
              'description' => '刹那无常',
              'extends' => [
                  ['name' => 'icon', 'value' => 'icon-thinking'],
              ],
              //'__v' => 0,
              //'create_at' => '2017-02-15T18:02:48.778Z',
              //'update_at' => '2022-03-02T06:00:47.645Z',
        ];
        return [
            [
            ],
            [
              '_id' => '621a91b8c22be1bb38e51437',
              'name' => '形而上',
              'slug' => 'metaphysical',
              'description' => '回归本源',
              'extends' => [
                  ['name' => 'icon', 'value' => 'icon-taichi'],
              ],
              'create_at' => '2022-02-26T20:46:48.467Z',
              'update_at' => '2022-02-26T21:10:14.573Z',
              'id' => 55,
              '__v' => 0,
            ],
        ];
    }

	//use TagTrait;
	/*public $add_mul;

    public function rules()
    {
        return [
			[['name'], 'required'],
            ['name', 'unique', 'targetClass' => get_called_class(), 'message' => '该标签已存在'],
            [['name'], 'checkTagCode'],
			[['orderlist', 'status'], 'default', 'value' => 0],
            [['add_mul', 'description', 'sort', 'code'], 'safe'],
        ];
    }

	public function checkTagCode()
	{
		if (empty($this->code)) {
			$this->code = $this->_createCode($this->name);
		}
		return true;
	}

	public function addMul()
	{
		$datas = array_filter(explode("\n", $this->add_mul));
		$num = 0;
		foreach ($datas as $data) {
			$data = str_replace([' ', "\t"], ' ', $data);
			$info = explode(' ', $data);
			$name = isset($info[0]) ? trim($info[0]) : '';
			$orderlist = isset($info[1]) ? intval($info[1]) : '';
			if (empty($name)) {
				continue;
			}
			$model = self::findOne(['name' => $name]);
			if ($model) {
				$model->orderlist = $orderlist;
			} else {
				$num++;
			    $model = new self(['name' => $name]);
			}
			$model->save();
		}
		return ['status' => 200, 'message' => '成功添加了' . $num . '条标签'];
	}	

    protected function _getTemplatePointFields()
    {
        return [
			'status' => ['type' => 'changedown'],
			'listNo' => ['description'],
        ];
    }

	public function getSortInfos()
	{
		return [
		];
	}

	public function _sceneFields()
	{
		return [
			'base' => ['id', 'code', 'name'],
		];
	}

	public function createRecord($tag)
	{
		$exist = $this->getInfo($tag, 'name');
		if ($exist) {
			return $exist;
		}
		$code = $this->_createCode($tag);
		$data = ['code' => $code, 'name' => $tag];
		return $this->addInfo($data);
	}

	protected function _createCode($tag)
	{
        $code = Pinyin::trans($tag, ['delimiter' => '', 'accent' => false]);
		$info = $this->getInfo($code, 'code');
		$code = empty($info) ? $code : $code . $info['id'];
		return $code;
    }*/
}
