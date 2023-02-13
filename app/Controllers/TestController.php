<?php

declare(strict_types = 1);

namespace ModuleCulture\Controllers;

use Swoolecan\Foundation\Helpers\CommonTool;
use Carbon\Carbon;

class TestController extends AbstractController
{
	use DealBookTrait;

    public function test()
    {
        $request = $this->request;
        $inTest = config('app.inTest');
        if (empty($inTest)) {
            return $this->error(400, '非法请求');
        }
        $method = ucfirst($request->input('method', ''));
        $method = "_test{$method}";
        $this->$method($request);
        exit();
    }

    public function _testSearch()
    {
        $info = $this->getModelObj('book')->where('id', 13)->first();
        $infos = $this->getModelObj('book')->limit(35)->get();
        $infos->searchable();exit();
        $content = '文集';//$this->request->input('content');
        $list = $this->getModelObj('book')->search($content)->where('query', ['*user_name*', '*user_email*'])->paginate(20)->toArray();
        //$list = $this->getModelObj('book')->search($content)->where('query', ['*user_name*', '*user_email*'])->orderBy('user_created_at.date.keyword', 'desc')->paginate(20)->toArray();
        print_r($list->toArray());exit();
        //$res = Address::search($content)->where('query', ['*address_home*', '*address_company*'])->orderBy('address_created_at.date.keyword', 'desc')->paginate(20)->toArray();
    }   

    public function _test()
    {
        return true;
    }
}
