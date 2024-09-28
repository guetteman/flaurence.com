<?php

use App\Http\Resources\FlowResource;
use App\Models\Flow;

covers(FlowResource::class);

describe('FlowResource', function () {
    it('should format a flow', function () {
        $flow = Flow::factory()->create();

        $resource = FlowResource::make($flow);

        expect($resource->resolve())->toMatchArray([
            'id' => $flow->id,
            'name' => $flow->name,
            'short_description' => $flow->short_description,
            'description' => $flow->description,
            'version' => $flow->version,
            'input_schema' => $flow->input_schema,
        ]);
    });
});
