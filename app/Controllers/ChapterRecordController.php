<?php

declare(strict_types = 1);

namespace ModuleCulture\Controllers;

class ChapterRecordController extends AbstractController
{
    public function record()
    {
        $repository = $this->getRepositoryObj();
        $request = $this->getPointRequest('record', $repository);
        $params = $request->all();

        $serial = $params['serial'] ?? 0;
        $bookCode = $params['book_code'] ?? '';
        $info = $this->getModelObj('chapter')->where(['book_code' => $bookCode, 'serial' => $serial])->first();
        if (empty($info)) {
            $this->resource->throwException('参数有误');
        }
        $service = $this->getServiceObj('record');

        $service->recordChapter($info, $params['type']);
        return $this->success();
    }
}
