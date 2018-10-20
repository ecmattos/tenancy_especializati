<?php

namespace App\Presenters;

use App\Transformers\TrashTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class TrashPresenter.
 *
 * @package namespace App\Presenters;
 */
class TrashPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new TrashTransformer();
    }
}
