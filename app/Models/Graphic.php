<?php

declare(strict_types = 1);

namespace ModuleCulture\Models;

class Graphic extends AbstractModel
{
    protected $table = 'graphic';
    protected $guarded = ['id'];

    public function formatResultDatas($params)
    {
        $method = '_' . $this->code . 'FormatDatas';
        return $this->$method($params);
    }

    protected function _scholarismFormatDatas($params)
    {
        $repository = $this->getRepositoryObj('culture-scholarism');
        $infos = $this->getModelObj('culture-scholarism')->get();
        $datas = [];
        foreach ($infos as $info) {
            $resource = $this->getResourceObj('culture-scholarism', ['resource' => $info, 'scene' => 'frontDetail', 'repository' => $repository, 'simpleResult' => false]);
            $datas[] = $resource->toArray();
        }
        return $resource;
    }

    protected function _luxunFormatDatas($params)
    {
    }

    protected function _homeFormatDatas($params)
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
}
