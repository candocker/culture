<?php

declare(strict_types = 1);

namespace ModuleCulture\Controllers;

class ShelfBookController extends AbstractController
{
    public function record()
    {
        $repository = $this->getRepositoryObj();
        $request = $this->getPointRequest('', $repository);
        $params = $request->input('shelfList');
        $params = json_decode($params, true);
        print_r($params);
        return $this->success();
        print_R($params);exit();

        $attachmentIds = (array) $data['attachment_id'];
        unset($data['attachment_id']);
        $attachmentModel = $this->getModelObj('attachment');
        $attachmentInfoModel = $this->getModelObj('attachmentInfo');
        $attachmentInfoModel->where($data)->delete();
        $message = '';
        foreach ($attachmentIds as $attachmentId) {
            if (empty($attachmentModel->find($attachmentId))) {
                continue;
            }
            $data['attachment_id'] = $attachmentId;
            $exist = $attachmentInfoModel->where($data)->withTrashed()->first();
            if (!empty($exist)) {
                $exist->restore();
                continue;
            }
            $result = $repository->create($data);
        }
        return $this->success([]);
    }
}
