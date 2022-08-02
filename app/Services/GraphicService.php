<?php

declare(strict_types = 1);

namespace ModuleCulture\Services;

class GraphicService extends AbstractService
{
    public function formatResultDatas($code, $extcode, $params)
    {
        $method = "_{$code}FormatDatas";
        return $this->$method($extcode, $params);
    }

    public function _apresidentFormatDatas($extcode, $params)
    {
        $figureResumes = $this->getModelObj('culture-figureResume')->where(['type' => 'usapresident'])->get();
        $repository = $this->getRepositoryObj('culture-figure');
        $datas = [];
        foreach ($figureResumes as $info) {
            $figureData = $this->getResourceObj('culture-figure', ['resource' => $info->figure, 'scene' => 'frontBase', 'repository' => $repository, 'simpleResult' => false])->toArray();
            $startEndInfo = $info->getStartEnd();
            $datas[] = array_merge($figureData, [
                'startEnd' => "{$startEndInfo['timeSpan']}<br />{$startEndInfo['startStr']}<br />{$startEndInfo['endStr']}",
                'party' => $info->party,
                'period' => $info->period,
                'term' => $info->term,
            ]);
        }
        return [
            [
                'view' => 'simple',
                'title' => '美国历届总统',
                'fields' => ['code', 'period', 'term', 'party', 'name', 'photoUrl', 'startEnd', 'description'],
                'theadData' => [
                    ['style' => '', 'colspan' => '1', 'name' => '代码', 'url' => ''], 
                    ['style' => '', 'colspan' => '1', 'name' => '届数', 'url' => ''],
                    ['style' => '', 'colspan' => '1', 'name' => '任数', 'url' => ''],
                    ['style' => '', 'colspan' => '1', 'name' => '政党', 'url' => ''],
                    ['style' => '', 'colspan' => '1', 'name' => '姓名', 'url' => ''],
                    ['style' => 'width:200px;', 'colspan' => '1', 'name' => '头像', 'url' => ''],
                    ['style' => 'width:200px;', 'colspan' => '1', 'name' => '任期时长', 'url' => ''],
                    ['style' => '', 'colspan' => '1', 'name' => '描述', 'url' => ''],
                ],
                'infos' => $datas,
            ],
        ];
    }

    public function _dynastyFormatDatas($extcode, $params)
    {
        $figures = $this->getModelObj('culture-dynasty')->limit(200)->get();
        $repository = $this->getRepositoryObj('culture-dynasty');
        $datas = [];
        foreach ($figures as $info) {
            $datas[] = $this->getResourceObj('culture-dynasty', ['resource' => $info, 'scene' => 'frontBase', 'repository' => $repository, 'simpleResult' => false])->toArray();
        }
        return [
            [
                'view' => 'simple',
                'title' => '朝代列表',
                'fields' => ['code', 'name', 'first_emperor', 'begin_end', 'description'],
                'theadData' => [
                    ['style' => '', 'colspan' => '1', 'name' => '代码', 'url' => ''], 
                    ['style' => '', 'colspan' => '1', 'name' => '名称', 'url' => ''],
                    ['style' => 'width:200px;', 'colspan' => '1', 'name' => '开国皇帝', 'url' => ''],
                    ['style' => '', 'colspan' => '1', 'name' => '起止时间', 'url' => ''],
                    ['style' => '', 'colspan' => '1', 'name' => '描述', 'url' => ''],
                ],
                'infos' => $datas,
            ],
        ];
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
        $bookFigures = $this->getModelObj('culture-bookFigure')->where(['figure_code' => 'luxun'])->get();
        $repositoryBook = $this->getRepositoryObj('culture-book');
        $repositoryFigure = $this->getRepositoryObj('culture-figure');
        $datas = [];
        foreach ($bookFigures as $info) {
            $book = $info->book;
            $figure = $info->figure;

            $bookData = $this->getResourceObj('culture-book', ['resource' => $info->book, 'scene' => 'frontBase', 'repository' => $repositoryBook, 'simpleResult' => false])->toArray();
            //$figureData = $this->getResourceObj('culture-figure', ['resource' => $info->figure, 'scene' => 'frontBase', 'repository' => $repositoryFigure, 'simpleResult' => false])->toArray();
            $datas[] = $bookData;
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

    protected function _homeFormatDatas($extcode, $params)
    {
        $footerLinks = $this->getFooterLinks();
        foreach ($footerLinks as & $footerLink) {
            $footerLink['name'] = "<a href='/{$footerLink['code']}' target='_blank'>{$footerLink['name']}</a>";
            $footerLink['colspan'] = 1;
        }
        print_r($footerLinks);exit();
        return [
            [
                'view' => 'simple',
                'title' => '表格入口',
                'fields' => ['code', 'name'],
                'infos' => $footerLinks,
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
            ['code' => 'dynasty', 'name' => '中国朝代列表'],
            ['code' => 'apresident', 'name' => '美国总统'],
        ];
        foreach ($sorts as $key => $sort) {
            $datas[] = ['code' => 'scholarism-' . $key, 'name' => '学术名著-' . $sort];
        }
        foreach ($datas as & $data) {
            $data['code'] = 'graphic-' . $data['code'];
        }
        return $datas;
    }
}
