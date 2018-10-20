<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\CompanyPosition;

/**
 * Class CompanyPositionTransformer.
 *
 * @package namespace App\Transformers;
 */
class CompanyPositionTransformer extends TransformerAbstract
{
    /**
     * Transform the CompanyPosition entity.
     *
     * @param \App\Entities\CompanyPosition $model
     *
     * @return array
     */
    public function transform(CompanyPosition $model)
    {
        return [
            'id' => (int) $model->id,

            'company_position_code' => $model->code,
            'company_position_descripion' => $model->description,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
