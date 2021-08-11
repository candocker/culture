<?php

declare(strict_types = 1);

namespace ModuleCulture\Controllers;

class RecordController extends AbstractController
{
    public function myRecord()
    {
        $repository = $this->getRepositoryObj();
        $request = $this->getPointRequest('myRecord', $repository);
        $book = $this->getModelObj('book')->find($request->input('book_code'));
        $data = $repository->getMyRecords($book);
        return $this->success($data);
    }

}
