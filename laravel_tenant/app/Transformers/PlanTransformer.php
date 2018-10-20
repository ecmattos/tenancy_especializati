<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Plan;

/**
 * Class PlanTransformer.
 *
 * @package namespace App\Transformers;
 */
class PlanTransformer extends TransformerAbstract
{
    /**
     * Transform the Plan entity.
     *
     * @param \App\Entities\Plan $model
     *
     * @return array
     */
    public function transform(Plan $model)
    {
        return [
            'id' => (int) $model->id,
            'code' => $model->code,
            'description' => $model->description,
            'details' => $model->details,
            'plan_type_id' => (int) $model->plan_type_id,
            'plan_type_code' => $model->plan_type->code,
            'plan_type_description' => $model->plan_type->description,
            'plan_sub_type_id' => (int) $model->plan_sub_type_id,
            'plan_sub_type_code' => $model->plan_sub_type->code,
            'plan_sub_type_description' => $model->plan_sub_type->description,
            'plan_status_id' => (int) $model->plan_status_id,
            'plan_status_code' => $model->plan_status->code,
            'plan_status_description' => $model->plan_status->description,
            'price' => $model->price,
            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    public function includePlanType(PlanType $model)
    {
        return $this->item($model->plan_type, new PlanTypeTransformer());
    }

    public function includePlanSubType(PlanSubType $model)
    {
        return $this->item($model->plan_sub_type, new PlanSubTypeTransformer());
    }
}
