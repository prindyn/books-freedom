<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ApiHandleBotRequest;

class BaseController extends Controller
{
    /**
     * @var array
     */
    protected $rules = [];

    /**
     * @var array
     */
    protected $messages = [];

    /**
     * @var array
     */
    protected $customAttributes = [];

    /**
     * @var \Illuminate\Contracts\Validation\Validator
     */
    protected $validator = null;

    /**
     * Api BaseController constructor
     * 
     * @var \App\Http\Requests\ApiHandleBotRequest $request
     */
    public function __construct(ApiHandleBotRequest $request)
    {
        $key = $this->clearRouteName();

        $this->rules = $request->rules()[$key] ?? [];

        $this->validator = Validator::make(
            $request->all(),
            $this->rules,
            $this->messages,
            $this->customAttributes
        );
    }

    protected function clearRouteName()
    {
        $fullname = explode('-', Route::currentRouteName());

        return end($fullname);
    }
}
