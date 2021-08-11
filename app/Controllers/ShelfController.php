<?php

declare(strict_types = 1);

namespace ModuleCulture\Controllers;

class ShelfController extends AbstractController
{
    public function mylist()
    {
        $repository = $this->getRepositoryObj();
        $request = $this->getPointRequest('record', $repository);
        $userData = $this->resource->getCurrentUser();

        $data = $repository->getMylist($userData);
        return $this->success($data);
    }

    public function create()
    {
        $repository = $this->getRepositoryObj();
        $request = $this->getPointRequest('create', $repository);
        $userData = $this->resource->getCurrentUser();
        $repository->createData($request->input('name'), $userData['id']);
        return $this->success();
    }
}
