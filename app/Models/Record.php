<?php

declare(strict_types = 1);

namespace ModuleCulture\Models;

class Record extends AbstractModel
{
    protected $table = 'record';
    protected $guarded = ['id'];

    public function onCreated()
    {
        return $this->_record('start');
    }

    public function onCreated()
    {
        return $this->_record('finish');
    }

    protected function _record($operation)
    {
        $type = $this->type;
        $modelCode = $this->type == 'chapter' ? 'chapterRecord' : 'bookRecord';
        $model = $this->getModelObj($modelCode);
        return $model->record($this, $operation);
    }
}
