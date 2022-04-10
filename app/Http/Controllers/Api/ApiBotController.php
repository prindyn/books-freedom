<?php

namespace App\Http\Controllers\Api;

use App\Contracts\BotFather;
use App\Http\Requests\ApiHandleBotRequest;

class ApiBotController extends BaseController
{
    public function register(ApiHandleBotRequest $request, BotFather $botfather)
    {
        $validated = $this->validateWith($this->validator, $request);

        $result = $botfather->new($validated);

        return response()->json($result, isset($result['errors']) ? 424 : 200);
    }
}
