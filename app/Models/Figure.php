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
        if (!is_null($othername)) {
            $this->getModelObj('figureTitle')->recordTitle($othername, $this->code);
        }
        foreach (['birthday', 'deathday'] as $elem) {
            $value = $request->input($elem);
            if (!is_null($value)) {
                $this->getModelObj('dateinfo')->recordDateinfo($elem, $value, 'figure', $this->code);
            }
        }

        return true;
    }
}
