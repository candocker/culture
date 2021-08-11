<?php

declare(strict_types = 1);

namespace ModuleCulture\Controllers;

class BookRecordController extends AbstractController
{
    public function myRecord()
    {
        $repository = $this->getRepositoryObj();
        $request = $this->getPointRequest('', $repository);
        $userData = $this->resource->getCurrentUser();

        $data = $repository->getMyRecord($userData);
        return $this->success($data);
    }
}
