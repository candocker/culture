<?php
declare(strict_types = 1);

namespace ModuleCulture\Services;

class RecordService extends AbstractService
{
    public function recordBook($info, $type) 
    {
        $user = $this->resource->getCurrentUser();

    }

    public function recordChapter($info, $type) 
    {
        $recordModel = $this->getModelObj('record');
        $userData = $this->userData();
        $where = ['user_id' => $userData['id'], 'chapter_id' => $info['id'], 'book_code' => $info['book_code'], 'read_status' => 0];
        $exist = $recordModel->where($where)->first();
        if ($type == 'start') {
            if (!empty($exist)) {
                return $this->resource->throwException(400, '您已于' . $exist->start_at . '开始阅读，请继续您的阅读');
            }
            $bookRecord = $this->getModelObj('bookRecord')->where(['user_id' => $userData['id'], 'book_code' => $info['book_code']])->first();
            $bookNum  = empty($bookRecord) ? 0 : $bookRecord->read_num;
            $data = $where;
            $data['start_at'] = date('Y-m-d H:i:s');
            $data['book_num'] = $bookNum;
            $recordModel->create($data);
            return true;
        }
        if (empty($exist)) {
            return $this->resource->throwException(400, '您还没开始阅读本章节');
        }
        $exist->read_status = 1;
        $exist->finish_at = date('Y-m-d H:i:s');
        $exist->save();
        return true;
    }

    public function userData()
    {
        return $this->resource->getCurrentUser();
    }
}
