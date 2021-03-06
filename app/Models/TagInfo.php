<?php

namespace ModuleCulture\Models;

class TagInfo extends AbstractModel
{
    protected $table = 'tag_info';
    protected $guarded = ['id'];

    public function tag()
    {
        return $this->hasOne(Tag::class, 'code', 'tag_code');
    }
	/*public $name;

    public function rules()
    {
        return [
			[['tag_code', 'info_id'], 'required'],
			[['orderlist'], 'default', 'value' => 0],
            [['info_type'], 'safe'],
        ];
    }

	public function getInfoTypeInfos()
	{
		return [
		];
	}

    protected function _getTemplatePointFields()
    {
        return [
			//'login_url' => ['type' => 'inline', 'method' => '_getLoginUrl', 'formatView' => 'raw'],
        ];
    }

	public function createRecord($tags, $baseData)
	{
		$result = self::updateAll(['status' => 0], $baseData);
		$tagModel = $this->getPointModel('tag-' . $this->_infocmsCode());
		print_r($tags);
		foreach ($tags as $tag) {
			$tInfo = $tagModel->createRecord(trim($tag));

			$data = $baseData;
			$data['tag_code'] = $tInfo['code'];
			$exist = $this->getInfo(['where' => $data]);
			if (empty($exist)) {
			    $data['status'] = 1;
				$this->addInfo($data);
			} else {
				$exist->status = 1;
				$exist->update(false);
			}
		}
		return true;
    }*/
}
