<?php

declare(strict_types = 1);

namespace ModuleCulture\Models;

class Record extends AbstractModel
{
    protected $table = 'record';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function onCreated()
    {
        return $this->_record('finish');
    }

    public function onUpdated()
    {
        return $this->_record('finish');
    }

    protected function _record($operation)
    {
        $this->getModelObj('chapterRecord')->record($this, $operation);
        return $this->getModelObj('bookRecord')->record($this, $operation);
    }
}
