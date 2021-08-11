<?php
declare(strict_types = 1);

namespace ModuleCulture\Repositories;

class ChapterRecordRepository extends AbstractRepository
{
    public function getMyRecords($book)
    {
        $datas = [];
        $chapters = $book->chapters;
        $userData = $this->resource->getCurrentUser();
        $chapterRecords = $this->model->where(['book_code' => $book->code, 'user_id' => $userData['id']])->get();
        $chapterRecords = $chapterRecords->keyBy('chapter_id');

        foreach ($chapters as $chapter) {
            $data = $chapter->toArray();
            if (isset($chapterRecords[$chapter['id']])) {
                $readRecord = $chapterRecords[$chapter['id']]->toArray();
                $readRecord['readStatus'] = $this->getKeyValues('read_status', $readRecord['read_status']);
            } else {
                $readRecord = ['readStatus' => '未开始', 'read_status' => ''];
            }

            $data['readRecord'] = $readRecord;
            $datas[$chapter['serial']] = $data;
        }
        return $datas;
    }

    protected function _statusKeyDatas()
    {
        return [
        ];
    }

    protected function _sceneFields()
    {
        return [
            'list' => ['id', 'name'],
            'listSearch' => ['id', 'name'],
            'add' => ['name'],
            'update' => ['name'],
        ];
    }

    public function getFormFields()
    {
        return [
        ];
    }

    public function getSearchFields()
    {
        return [
        ];
    }

    public function getSearchDealFields()
    {
        return [
        ];
    }

    public function _getFieldOptions()
    {
        return [
        ];
    }
}
