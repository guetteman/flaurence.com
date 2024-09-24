<?php

use App\Enums\FlowOutputTypeEnum;
use App\Models\Flow;
use Illuminate\Database\Eloquent\Casts\ArrayObject;

describe('Flow model', function () {
    it('it should cast input_schema to array', function () {
        $flow = Flow::factory()->create([
            'input_schema' => ['foo' => 'bar'],
        ]);

        expect($flow->input_schema)->toBeInstanceOf(ArrayObject::class);
    });

    it('it should cast output_type to FlowOutputTypeEnum', function () {
        $flow = Flow::factory()->create([
            'output_type' => FlowOutputTypeEnum::Markdown->value,
        ]);

        expect($flow->output_type)->toBeInstanceOf(FlowOutputTypeEnum::class);
    });
});
