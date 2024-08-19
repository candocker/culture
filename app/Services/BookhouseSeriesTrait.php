<?php

declare(strict_types = 1);

namespace ModuleCulture\Services;

trait BookhouseSeriesTrait
{
    public function _getSeries($bigsort)
    {
        $bigsorts = [
            'foreign' => ['scholarism' => '学术名著', 'luxun' => '鲁迅'],
            //'chinese' => [],
        ];
        $sorts = $bigsorts[$bigsort];
        $sortCodes = array_keys($sorts);
        $infos = $this->getModelObj('culture-series')->whereIn('sort', $sortCodes)->orderBy('orderlist', 'desc')->get();
        $results = [];
        foreach ($infos as $info) {
            $sort = $info['sort'];
            if (isset($results[$sort])) {
                $results[$sort]['subSorts'][] = ['code' => $info['code'], 'name' => $info['name']];
            } else {
                $results[$sort] = ['code' => $sort, 'name' => $sorts[$sort], 'subSorts' => []];
            }
        }
        return array_values($results);
    }

    public function getVolumeBooks($bigsort, $sort)
    {
        $volumes = $this->getModelObj('culture-seriesVolume')->where(['series_code' => $sort])->orderBy('orderlist', 'asc')->get();
        $results = $tabList = [];
        foreach ($volumes as $volume) {
            $vId = $volume['id'];
            $vNameBase = $volume['name'];
            $vName = $vNameBase . $volume['brief'];
            $vName .= $volume['book_num'] ? '( ' . $volume['book_num'] . ' )' : '';
            $vData = [
                'id' => $vId,
                'name' => $vNameBase,
                'title' => $vName,
                'description' =>$volume['description'],
            ];
            $tabList[] = $vData;
            $books = $this->getModelObj('culture-bookPublish')->where(['series_volume_id' => $vId])->orderBy('serial', 'asc')->get();
            $bookDatas = [];
            foreach ($books as $book) {
                $bookDatas[] = [
                    'name' => $book['name'],
                    'author' => $book['author'],
                    'nationality' => $book['nationality'],
                    'baidu_url_value' => $book->book ? $book->book['baidu_url'] : '',
                    'baidu_url' => $book->book && $book->book['baidu_url'] ? '百度百科' : '',
                    'onlineread' => $book->book && $book->book->type == 'epub' ? '在线阅读' : '',
                    'onlineread_value' => '/pages/book/info?book_code=' . $book['book_code'],
                    'brief' => $book['brief'],
                ];
            }
            $vData['bookDatas'] = $bookDatas;
            $results[] = $vData;
        }
        $datas = [
            'tableHeader' => $this->getTableHeaderDatas('book'),
            'tableDatas' => $results,
            'tabList' => $tabList,
        ];
        return $datas;
    }

    public function getTableHeaderDatas($type)
    {
        $datas = [
            'book' => [
                ['label' => '书名', 'key' => 'name', 'width' => 280, 'isFixed' => true, 'filter' => []], // 'filter' => ['labele' => '书名', 'key' => 'name']
                ['label' => '作者', 'key' => 'author', 'width' => 150, 'isFixed' => false, 'filter' => []],
                ['label' => '国籍', 'key' => 'nationality', 'width' => 80, 'isFixed' => false, 'filter' => []],
                ['label' => '在线阅读', 'key' => 'onlineread', 'width' => 100, 'isRoute' => true, 'isFixed' => false, 'filter' => []],
                ['label' => '下载阅读', 'key' => 'pdffile', 'width' => 100, 'isFixed' => false, 'filter' => []],
                ['label' => '百科', 'key' => 'baidu_url', 'width' => 100, 'isUrl' => true, 'isFixed' => false, 'filter' => []],
                ['label' => '简介', 'key' => 'brief', 'width' => 100, 'isFixed' => false, 'filter' => []],
                //['label' => '', 'key' => '', 'width' => 100, 'isFixed' => false, 'filter' => []],
            ],
        ];
        return $datas[$type];
    }
}