<?php

namespace ModuleCulture\Controllers;

class TagController extends AbstractController
{
	public function actionNavDatas()
	{
		$where = ['status' => 'nav'];
		return ['status' => 200, 'message' => 'OK', 'datas' => $this->model->getBookDatas($where)];
	}

	public function home()
	{
        $repository = $this->getRepositoryObj();
        $positionBooks = $repository->getPositionBooks();
        $navBooks = $repository->getNavBooks();
        return $this->success(['positionBooks' => $positionBooks, 'navBooks' => $navBooks]);
	}
}
