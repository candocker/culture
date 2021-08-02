<?php

namespace ModuleCulture\Models;

class BookRecord extends AbstractModel
{
    protected $table = 'book_record';


    public function record($record)
    {
        $where = ['uid' => $record['user_id'], 'book_code' => $record['book_code']);
        $exist = $this->where()->first();
        if (empty($exist)) {
            $data = $where;
            $data['read_first'] = date('Y-m-d H:i:s');
            $data['read_last'] = date('Y-m-d H:i:s');
            $data['read_num'] = intval($record['status']);
            $data['read_status'] = $record['status'];
            $this->create($data);
            return true;
        }

        $exist->read_last = date('Y-m-d H:i:s');
        $exist->status = $record['status'];
        $exist->read_num += intval($record['status']);
        $exist->save();
        return true;
    }
}
