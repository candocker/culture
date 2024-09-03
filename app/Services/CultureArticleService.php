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
        $datas = $this->formatForBlog($infos);
        if (empty($withPage)) {
            return $datas;
        }
        return [
            'data' => $datas,
            'pagination' => $this->getPageData(),
        ];
    }

    public function getInfoRelate($modelCode, $id)
    {
        $model = $this->getModelObj($modelCode);
        $info = $model->where([['id', '>', 200]])->first();
        $preInfo = $model->preInfo(['where' => [['id', '<', $id]]]);
        $nextInfo = $model->preInfo(['where' => [['id', '>', $id]]]);
        $relateInfos = $model->relateDatas(8, []);

        return [
            'prev_article' => $preInfo ? $preInfo->formatForBlog() : null,
            'next_article' => $nextInfo ? $nextInfo->formatForBlog() : null,
            'related_articles' => $this->formatForBlog($relateInfos),
        ];
    }

    public function getInfoDetail($modelCode, $where, $throw = true)
    {
        $model = $this->getModelObj($modelCode);
        $info = $model->where($where)->first();
        if (empty($info)) {
            \Log::info('iii');
            return $throw ? $this->resource->throwException(404, '信息不存在') : false;
        }
        return $info->formatForBlog('detail');
    }

    public function getArticleCalendar()
    {
        $datetimeTool = new DatetimeTool();
        $now = $datetimeTool->getCarbonObj();
        for ($i = 1; $i < 30; $i++) {
            $date = $now->subDays(rand(2, 5))->format('Y-m-d');
            $datas[] = ['date' => $date, 'count' => rand(3, 10)];
        }
        return $datas;
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

    protected function formatForBlog($infos)
    {
        $datas = [];
        foreach ($infos as $info) {
            $datas[] = $info->formatForBlog();
        }
        return $datas;
    }
}
