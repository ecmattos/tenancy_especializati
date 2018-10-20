<?php

namespace App\Presenters;

use App\Transformers\CompanyPositionTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CompanyPositionPresenter.
 *
 * @package namespace App\Presenters;
 */
class CompanyPositionPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CompanyPositionTransformer();
    }
}
