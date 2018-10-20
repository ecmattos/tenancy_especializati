<?php

namespace App\Presenters;

use App\Transformers\PlanTypeTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class PlanTypePresenter.
 *
 * @package namespace App\Presenters;
 */
class PlanTypePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PlanTypeTransformer();
    }
}
