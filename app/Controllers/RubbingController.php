<?php

declare(strict_types = 1);

namespace ModuleCulture\Controllers;

class RubbingController extends AbstractController
{
    public function tmp()
    {
        $model = $this->getModelObj('figure');
        $infos = $model->where('birthday', '<>', 0)->get();
        $dateinfoModel = $this->getModelObj('dateinfo');
        foreach ($infos as $info) {
            $birthday = strval($info['birthday']);

            $day = substr($birthday, -2);
            $month = substr($birthday, -4, 2); 
            $year = substr($birthday, 0, strlen($birthday) - 4);
            $dData = [
                'type' => 'birthday',
                'info_type' => 'figure',
                'info_key' => $info->code,
                'year' => $year,
                'month' => $month,
                'day' => $day,
            ];
            $dateinfoModel->create($dData);

            $deathday = strval($info['deathday']);
            $day = substr($deathday, -2);
            $month = substr($deathday, -4, 2); 
            $year = substr($deathday, 0, strlen($deathday) - 4);
            $dData = [
                'type' => 'deathday',
                'info_type' => 'figure',
                'info_key' => $info->code,
                'year' => $year,
                'month' => $month,
                'day' => $day,
            ];
            $dateinfoModel->create($dData);
        }
        echo count($infos);exit();
        $str = file_get_contents('/tmp/text/j.json');
        $data = json_decode($str, true);
        return $data;
    }

    public function category()
    {
        $str = file_get_contents('/tmp/text/category.json');
        //return $str;
        $data = json_decode($str, true);
        return $data;
    }

    public function dealCalligrapher()
    {
        $service = $this->getServiceObj('rubbing');
        //$service->dealCalligrapher();
        //$service->dealRubbing();
        //$service->dealRubbingDetails();
        $rubbingId = $this->request->input('rubbing_id');
        //$service->checkDetail($rubbingId);
        //$service->downRubbing();
        $service->downWord();
        //$service->dealRubbingAddWords();
    }
}
