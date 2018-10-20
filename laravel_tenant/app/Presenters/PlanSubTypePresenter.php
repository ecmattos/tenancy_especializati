<?php

namespace App\Presenters;

use App\Transformers\PlanSubTypeTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class PlanSubTypePresenter.
 *
 * @package namespace App\Presenters;
 */
class PlanSubTypePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PlanSubTypeTransformer();
    }
}
