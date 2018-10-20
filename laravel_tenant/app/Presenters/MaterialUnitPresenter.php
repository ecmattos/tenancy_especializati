<?php

namespace App\Presenters;

use App\Transformers\MaterialUnitTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class MaterialUnitPresenter.
 *
 * @package namespace App\Presenters;
 */
class MaterialUnitPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new MaterialUnitTransformer();
    }
}
