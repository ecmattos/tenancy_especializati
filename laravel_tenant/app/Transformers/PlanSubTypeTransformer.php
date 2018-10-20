<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\PlanSubType;

/**
 * Class PlanSubTypeTransformer.
 *
 * @package namespace App\Transformers;
 */
class PlanSubTypeTransformer extends TransformerAbstract
{
    /**
     * Transform the PlanSubType entity.
     *
     * @param \App\Entities\PlanSubType $model
     *
     * @return array
     */
    public function transform(PlanSubType $model)
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
