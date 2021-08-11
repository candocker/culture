<?php

declare(strict_types = 1);

namespace ModuleCulture\Controllers;

class ShelfBookController extends AbstractController
{
    public function record()
    {
        $repository = $this->getRepositoryObj();
        $request = $this->getPointRequest('record', $repository);
        $bookCode = $request->input('book_code');
        $type = $request->input('type');
        $repository->record($bookCode, $type);

        return $this->success();
    }

    public function updata()
    {
        $repository = $this->getRepositoryObj();
        $request = $this->getPointRequest('', $repository);
        $params = $request->input('shelfList');
        //$params = '{"shelfList":[{\"shelf_id\":-1,\"type\":2,\"title\":\"最爱\",\"itemList\":[{\"id\":258,\"shelf_id\":1,\"type\":1},{\"id\":1,\"shelf_id\":2,\"type\":1}]},{\"id\":7,\"shelf_id\":2,\"type\":1},{\"id\":268,\"shelf_id\":3,\"type\":1},{\"id\":3,\"shelf_id\":4,\"type\":1},{\"shelf_id\":-1,\"type\":2,\"title\":\"ffffffff\",\"itemList\":[{\"id\":7,\"shelf_id\":1,\"type\":1},{\"id\":3,\"shelf_id\":2,\"type\":1}]}]}';
        //$params = str_replace('\\', '', $params);
        $params = json_decode($params, true);
        $repository->updataShelf($params);
        //$repository->updataShelf($params['shelfList']);
        //print_r($params);exit();
        return $this->success();

        $userData = $this->resource->getCurrentUser();
        $data = $this->getRepositoryObj('shelf')->getMylist($userData);
        return $this->success($data);
    }
}
