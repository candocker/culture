<?php

declare(strict_types = 1);

namespace ModuleCulture\Controllers;

class RubbingController extends AbstractController
{
    use TmpOperationTrait;

    public function tmp()
    {
        //$this->updateDate();
        $this->updateFigure();
        exit();
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
