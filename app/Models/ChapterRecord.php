<?php

namespace ModuleCulture\Models;

class ChapterRecord extends AbstractModel
{
    protected $table = 'chapter_record';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function record($record)
    {
        $where = ['user_id' => $record['user_id'],  'chapter_id' => $record['chapter_id'], 'book_code' => $record['book_code']];
        $exist = $this->where($where)->first();
        if (empty($exist)) {
            $data = $where;
            $data['read_first'] = date('Y-m-d H:i:s');
            $data['read_last'] = date('Y-m-d H:i:s');
            $data['read_num'] = intval($record['read_status']);
            $data['read_status'] = $record['read_status'];
            $this->create($data);
            return true;
        }

        $exist->read_last = date('Y-m-d H:i:s');
        $exist->read_status = $record['read_status'];
        $exist->read_num += intval($record['read_status']);
        $exist->save();
        return true;
    }
}
