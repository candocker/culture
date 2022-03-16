<?php
declare(strict_types = 1);

namespace ModuleCulture\Services;

use Swoolecan\Foundation\Helpers\DatetimeTool;

class CultureArticleService extends AbstractService
{
    public function getListInfos($modelCode, $where, $withPage = false)
    {
        $query = $this->getModelObj($modelCode);
        if ($where) {
            $query->where($where);
        }
        $infos = $query->get();
        $data = [];
        foreach ($infos as $info) {
            $data[] = $info->formatForBlog();
        }
        if (empty($withPage)) {
            return $data;
        }
        return [
            'data' => $data,
            'pagination' => $this->getPageData(),
        ];
    }

    public function getArticleList($where = null, $withPage = false)
    {
        $query = $this->getModelObj('cultureArticle');
    }

    public function getArticleCalendar()
    {
        $datetimeTool = new DatetimeTool();
        $now = $datetimeTool->getNow();
        for ($i = 1; $i < 30; $i++) {
            $date = $now->subDays(rand(2, 5))->format('Y-m-d');
            $datas[] = ['date' => $date, 'count' => rand(3, 10)];
        }
        return $datas;
    }

    public function getCategoryInfos()
    {
        return [
            [
                //'_id' => '589e07c04a4ad562430953d0',
                'id' => 1,
                'name' => '啥啊',
                'slug' => 'insight',
                'description' => '不知道啊',
                'extends' => [
                    ['name' => 'icon', 'value' => 'icon-thinking'],
                    ['name' => 'background', 'value' => 'https://static.surmon.me/thumbnail/heart-sutra.jpg'],
                ],
                'pid' => NULL,
                //'__v' => 0,
                'create_at' => '2017-02-10T18:34:40.680Z',
                'update_at' => '2021-12-11T06:12:16.084Z',
            ],
        ];
    }

    public function getTagInfos()
    {
        return [
            [
              '_id' => '58a497c813edac2b82566cb3',
              'id' => 29,
              'name' => '见地',
              'slug' => 'opinion',
              'description' => '刹那无常',
              'extends' => [
                  ['name' => 'icon', 'value' => 'icon-thinking'],
              ],
              '__v' => 0,
              'create_at' => '2017-02-15T18:02:48.778Z',
              'update_at' => '2022-03-02T06:00:47.645Z',
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

    public function getPageData()
    {
        return [
            'total' => 156,
            'current_page' => 1,
            'per_page' => 16,
            'total_page' => 10,
        ];
    }
}
