<?php

namespace ModuleCulture\Models;

class Figure extends AbstractModel
{
    protected $table = 'figure';
    protected $guarded = ['id'];

    public function afterSave()
    {
        $request = request();
        $othername = $request->input('othername');
        if (is_null($othername)) {
            return ;
        }

        return $this->getModelObj('figureTitle')->recordTitle($othername);
    }
}
