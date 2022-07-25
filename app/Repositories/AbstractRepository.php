<?php
declare(strict_types = 1);

namespace ModuleCulture\Repositories;

use Framework\Baseapp\Repositories\AbstractRepository as AbstractRepositoryBase;

class AbstractRepository extends AbstractRepositoryBase
{
    public function getDefaultShowFields()
    {
        return array_merge(parent::getDefaultShowFields(), [
            //'user_id' => ['valueType' => 'common'],
        ]);
    }

    public function _readStatusKeyDatas()
    {
        return [
            0 => '阅读中',
            1 => '已阅',
        ];
    }

    protected function getAppcode()
    {
        return 'culture';
    }

    public function _calligraphyStyleKeyDatas()
    {
        return [
            'seal' => '篆',
            'a' => '',
            'offical' => '隶',
            'cursive' => '草',
            'running' => '行',
            'regular' => '楷',
        ];
    }

    public function _dynastyKeyDatas()
    {
        return [
            'preqin' => '先秦',
            'qinhan' => '秦汉',
            'weijin' => '魏晋南北朝',
            'suitang' => '隋唐五代',
            'b' => '',
            'songlj' => '宋辽金',
            'yuan' => '元',
            'ming' => '明',
            'qing' => '清',
            'modern' => '近现代',
            'contemporary' => '当代',
            'union' => '合辑',

        ];
    }

    public function _categoryKeyDatas()
    {
        return $this->getPointCaches('category', 'tree');
    }

    public function tmpThumb($model, $field = '', $pointField = 'extfield')
    {
        $url = $model->$pointField;
        $url = strpos($url, 'htt') !== false ? $url : 'https://zsbt-1254153797.cos.ap-shanghai.myqcloud.com/' . $url;
        //$url = strpos($url, 'htt') !== false ? $url : 'bts.liupinshuyuan.com/' . $url;
        if (strpos($url, '?') !== false) {
            $url = substr($url, 0, strpos($url, '?'));
        }
        if ($field == 'url') {
            return $url;
        }

        return "<a href='{$url}' target='_blank'><img src='{$url}' width='150px' height='150px' /></a>";
    }

    protected function _eraTypeKeyDatas()
    {
        return [
            '' => '公元',
            'bc' => '公元前',
        ];
    }

    protected function _eraKeyDatas()
    {
        return [
            '' => '',
            'ancient' => '古代',
            'recent' => '近代',
            'modern' => '现代',
            'contemporary' => '当代',
        ];
    }

    protected function _publishHouseKeyDatas()
    {
        return [
            'peoplesliterature' => '人民文学出版社',
            'commercialpress' => '商务印书馆',
            'shanghairevival' => '上海复社',
            'nationallbrarypress' => '国家图书馆出版社',
        ];
    }

    protected function _accurateKeyDatas()
    {
        return [
            '' => '精准',
            'unknown' => '未知',
            'probably' => '大概',
            'running' => '至今',
        ];
    }

    protected function _ftitleKeyDatas()
    {
        return [
            'penname' => '笔名',
            'temple' => '谥号',
            'dynastic' => '庙号',
            'englishname' => '英文名',
            'englishfull' => '英文全名',
            'usedbefore' => '曾用名',
        ];
    }
}
