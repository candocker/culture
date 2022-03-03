<?php

declare(strict_types = 1);

namespace ModuleCulture\Models;

class Graphic extends AbstractModel
{
    protected $table = 'graphic';
    protected $guarded = ['id'];

    public function formatResultDatas($code, $extcode, $params)
    {
        $method = "_{$code}FormatDatas";
        return $this->$method($extcode, $params);
    }

    public function _figureFormatDatas($extcode, $params)
    {
        $figures = $this->getModelObj('culture-figure')->limit(200)->get();
        $repository = $this->getRepositoryObj('culture-figure');
        $datas = [];
        foreach ($figures as $info) {
            $datas[] = $this->getResourceObj('culture-figure', ['resource' => $info, 'scene' => 'frontBase', 'repository' => $repository, 'simpleResult' => false])->toArray();
        }
        return [
            [
                'view' => 'simple',
                'title' => '人物列表',
                'fields' => ['code', 'name', 'ageStr', 'photoUrl', 'description'],
                'theadData' => [
                    ['style' => '', 'colspan' => '1', 'name' => '代码', 'url' => ''], 
                    ['style' => '', 'colspan' => '1', 'name' => '名称', 'url' => ''],
                    ['style' => 'width:200px;', 'colspan' => '1', 'name' => '生卒日期', 'url' => ''],
                    ['style' => '', 'colspan' => '1', 'name' => '头像', 'url' => ''],
                    ['style' => '', 'colspan' => '1', 'name' => '描述', 'url' => ''],
                ],
                'infos' => $datas,
            ],
        ];
    }

    public function _bookFormatDatas($extcode, $params)
    {
        $books = $this->getModelObj('culture-book')->limit(200)->get();
        $repository = $this->getRepositoryObj('culture-book');
        $datas = [];
        foreach ($books as $info) {
            $datas[] = $this->getResourceObj('culture-book', ['resource' => $info, 'scene' => 'frontBase', 'repository' => $repository, 'simpleResult' => false])->toArray();
        }
        //print_r($datas);exit();
        return [
            [
                'view' => 'simple',
                'title' => '书籍列表',
                'fields' => ['code', 'name', 'coverUrl', 'description'],
                'theadData' => [
                    ['style' => '', 'colspan' => '1', 'name' => '代码', 'url' => ''], 
                    ['style' => '', 'colspan' => '1', 'name' => '名称', 'url' => ''],
                    ['style' => '', 'colspan' => '1', 'name' => '封面', 'url' => ''],
                    ['style' => '', 'colspan' => '1', 'name' => '描述', 'url' => ''],
                ],
                'infos' => $datas,
            ],
        ];
    }

    protected function _scholarismFormatDatas($extcode, $params)
    {
        $repository = $this->getRepositoryObj('culture-scholarism');
        $infos = $this->getModelObj('culture-scholarism')->where('sort', $extcode)->get();
        $baseElem = [
            'view' => 'simple',
            'title' => '表格入口',
            'fields' => ['code', 'name', 'description'],
            'theadData' => [
                ['style' => '', 'colspan' => '1', 'name' => '类别', 'url' => ''], 
                ['style' => '', 'colspan' => '1', 'name' => '名称', 'url' => ''],
                ['style' => '', 'colspan' => '1', 'name' => '描述', 'url' => ''],
            ],
        ];
        $sorts = $repository->getKeyValues('sort');
        $volumes = $repository->_volumeKeyDatas($extcode);
        $sortName = $sorts[$extcode];
        $datas = [];
        foreach ($infos as $info) {
            $resource = $this->getResourceObj('culture-scholarism', ['resource' => $info, 'scene' => 'frontBase', 'repository' => $repository, 'simpleResult' => false]);
            $rData = $resource->toArray();
            $rData['colspan'] = 1;
            $datas[$info['volume']][] = $rData;
        }
        $results = [];
        foreach ($volumes as $key => $volume) {
            if (!isset($datas[$key])) {
                echo $volume;exit();
            }
            $infos = $baseElem;
            $infos['title'] = $sortName . '-' . $volume;
            $infos['infos'] = $datas[$key];
            $results[] = $infos;
        }
        return $results;
    }

    protected function _luxunFormatDatas($extcode, $params)
    {
    }

    protected function _homeFormatDatas($extcode, $params)
    {
        return [
            [
                'view' => 'simple',
                'title' => '表格入口',
                'fields' => ['code', 'name', 'description'],
                'theadData' => [
                    ['style' => '', 'colspan' => '1', 'name' => '类别', 'url' => ''], 
                    ['style' => '', 'colspan' => '1', 'name' => '名称', 'url' => ''],
                    ['style' => '', 'colspan' => '1', 'name' => '描述', 'url' => ''],
                ],
                'infos' => [
                    ['colspan' => '1', 'code' => 'luxun', 'name' => '鲁迅', 'description' => '鲁迅著作表', 'style' => ''],
                ],
            ],
        ];
    }

    public function getFooterLinks()
    {
        $repository = $this->getRepositoryObj('culture-scholarism');
        $sorts = $repository->getKeyValues('sort');
        $datas = [
            ['code' => 'luxun', 'name' => '鲁迅作品集'],
            ['code' => 'figure', 'name' => '人物列表'],
            ['code' => 'book', 'name' => '书籍列表'],
            ['code' => 'dynastry', 'name' => '中国朝代列表'],
        ];
        foreach ($sorts as $key => $sort) {
            $datas[] = ['code' => 'scholarism-' . $key, 'name' => '学术名著-' . $sort];
        }
        return $datas;
    }
}
