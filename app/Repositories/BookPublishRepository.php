<?php

declare(strict_types = 1);

namespace ModuleCulture\Repositories;

class BookPublishRepository extends AbstractRepository
{
    protected function _sceneFields()
    {
        return [
            'list' => ['id', 'name'],
            'listSearch' => ['id', 'name'],
            'add' => ['name'],
            'update' => ['name'],
        ];
    }

    public function getShowFields()
    {
        return [
            //'type' => ['valueType' => 'key'],
        ];
    }

    public function getSearchFields()
    {
        return [
            //'type' => ['type' => 'select', 'infos' => $this->getKeyValues('type')],
        ];
    }

    public function getFormFields()
    {
        return [
            //'type' => ['type' => 'select', 'infos' => $this->getKeyValues('type')],
        ];
    }

    protected function _statusKeyDatas()
    {
        return [
            0 => '未激活',
            1 => '使用中',
            99 => '锁定',
        ];
    }

    protected function _sortKeyDatas()
    {
        return [
            'philosophy' => '哲学',//（橘黄色）',
            'history' => '历史·地理',//（黄色）',
            'politics' => '政治·法律·社会',//（绿色）',
            'economics' => '经济',//（蓝色）',
            'language' => '语言·文艺理论',//（棕黄色）',
        ];
    }

    public function _volumeKeyDatas($sort = '')
    {
        $datas = [
            'one' => '第一辑',
            'two' => '第二辑',
            'three' => '第三辑',
            'four' => '第四辑',
            'five' => '第五辑',
            'six' => '第六辑',
            'seven' => '第七辑',
            'eight' => '第八辑',
            'nine' => '第九辑',
            'ten' => '第十辑',
            'eleven' => '第十一辑',
            'twelve' => '第十二辑',
            'thirteen' => '第十三辑',
            'fourteen' => '第十四辑',
            'fifteen' => '第十五辑',
            'sixseventeen' => '第十六、十七辑',
            'eighteen' => '第十八辑',
            'nineteen' => '第十九辑',
        ];
        if ($sort == 'language') {
            return [
                'onefifteen' => '第一到十五辑',
                'sixseventeen' => '第十六、十七辑',
                'eighteen' => '第十八辑',
                'nineteen' => '第十九辑',
            ];
        }
        return $datas;
        /*return [
            'philosophy' => [
                'one' => '（一）1981年起',
                'two' => '（二）1982年起',
                'three' => '（三）1985年起',
                'four' => '（四）1986年起',
                'five' => '（五）1989年起',
                'six' => '（六）1991年起',
                'seven' => '（七）1996年起',
                'eight' => '（八）1999年起',
                'nine' => '（九）2001年起',
            ],
            'history' => [
                'one' => '（一）1981年起',
                'two' => '（二）1982年起',
                'three' => '（三）1985年起',
                'four' => '（四）1986年起',
                'five' => '（五）1989年起',
                'six' => '（六）1991年起',
                'seven' => '（七）1995-96年',
                'eight' => '（八）1999-2001年',
            ],
            'politics' => [
                'one' => '（一）1981年起',
                'two' => '（二）1982年起',
                'three' => '（三）1985年起',
                'four' => '（四）1986年起',
                'five' => '（五）1989年起',
                'six' => '（六）1991年起',
                'seven' => '（七）1996年起',
                'eight' => '（八）1999年起',
                'nine' => '（九）2001年起',
            ],
            'economics' => [
                'one' => '（一）1981年起',
                'two' => '（二）1983年起',
                'three' => '（三）1985年起',
                'four' => '（四）1986年起',
                'five' => '（五）1989年起',
                'six' => '（六）1991年起',
                'seven' => '（七）1996年起',
                'eight' => '（八）1999年起',
                'nine' => '（九）2001年起',
            ],
            'language' => [
                'one' => '（一）1999年起',
                'two' => '（二）1999-2001年',
            ],
        ];*/
    }

    public function getCategoryDatas($currentSort = 'philosophy')
    {
        $results = [];
        $datas = $this->_sortKeyDatas();
        $currentSort = $currentSort ?: 'philosophy';
        $volumeDatas = $this->_volumeKeyDatas($currentSort);
        //$volumeDatas = $volumeDatas[$currentSort];
        $infos = $this->getModelObj('bookPublish')->where(['sort' => $currentSort])->orderBy('serial', 'asc')->get();
        $books = [];
        foreach ($infos as $book) {
            $books[$book['volume']][] = $book->toArray();
        }
        foreach ($datas as $key => $name) {
            $results[$key]['name'] = $name;
            $results[$key]['isCurrent'] = $currentSort == $key ? 1 : 0;
        }
        return ['sorts' => $results, 'volumes' => $volumeDatas, 'books' => $books];
    }
}
