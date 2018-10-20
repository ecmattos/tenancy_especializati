<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\PlanType;

/**
 * Class PlanTypeTransformer.
 *
 * @package namespace App\Transformers;
 */
class PlanTypeTransformer extends TransformerAbstract
{
    /**
     * Transform the PlanType entity.
     *
     * @param \App\Entities\PlanType $model
     *
     * @return array
     */
    public function transform(PlanType $model)
    {
        return [
            'id'         => (int) $model->id,

            'code' => $model->code,
            'description' => $model->description,

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
