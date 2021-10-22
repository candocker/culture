<?php

declare(strict_types = 1);

namespace ModuleCulture\Controllers;

class RubbingController extends AbstractController
{
    public function tmp()
    {
        $str = file_get_contents('/tmp/text/j.json');
        //return $str;
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
