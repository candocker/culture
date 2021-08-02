<?php

namespace ModuleCulture\Models;

class BookRecord extends AbstractModel
{
    protected $table = 'book_record';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function book()
    {
        return $this->hasOne(Book::class, 'code', 'book_code');
    }

    public function record($record, $operation)
    {
        $where = ['user_id' => $record['user_id'], 'book_code' => $record['book_code']];
        $exist = $this->where($where)->first();
        if (empty($exist)) {
            $data = $where;
            $data['read_first'] = date('Y-m-d H:i:s');
            $data['read_last'] = date('Y-m-d H:i:s');
            $data['read_num'] = 0;
            $data['read_status'] = 0;
            $exist = $this->create($data);
        }
        if ($operation == 'start') {
            $exist->read_status = 0;
            $exist->save();
            return true;
        }
        $book = $exist->book;
        $recordModel = $this->getModelObj('record');
        $isFinish = true;
        foreach ($book->chapters as $chapter) {
            $where = ['chapter_id' => $chapter->id, 'user_id' => $record['user_id'], 'status' => 1, 'book_num' => $exist->read_num];
            $chapterExist = $recordModel->where($where)->first();
            if (empty($chapterExist)) {
                $isFinish = false;
                break;
            }
        }
        if (empty($isFinish)) {
            return true;
        }

        $exist->read_last = date('Y-m-d H:i:s');
        $exist->read_status = 1;
        $exist->read_num += 1;
        $exist->save();
        return true;
    }
}
