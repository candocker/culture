<?php

declare(strict_types = 1);

namespace ModuleCulture\Models;

class FigureResume extends AbstractModel
{
    protected $table = 'figure_resume';
    protected $guarded = ['id'];

    public function figure()
    {
        return $this->hasOne(Figure::class, 'code', 'figure_code');
    }

    public function afterSave()
    {
        $request = request();
        foreach (['start', 'end'] as $elem) {
            $value = $request->input($elem);
            if (!is_null($value)) {
                $this->getModelObj('dateinfo')->recordDateinfo($elem, $value, 'figure_resume', $this->id);
            }
        }

        return true;
    }
}
