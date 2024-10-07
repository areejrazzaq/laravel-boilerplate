<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\AddResourceRequest;
use App\Http\Requests\API\UpdateResourceRequest;
use Illuminate\Http\Request;

class ResourceController extends AppBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->sendSuccess('Index function is calleed');
    }
    
    /**
     * Store a newly created resource in storage.
     * 1. Validate the request data
     * 2. If validation passes; add resource
     * 3. else send error
     * @param \App\Http\Requests\API\UpdateResourceRequest $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AddResourceRequest $request)
    {
        return $this->sendSuccess('Store function is calleed');
    }
    
    /**
     * Display the specified resource.
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id)
    {
        return $this->sendSuccess('Show function is calleed');
    }

    /**
     * Update the specified resource in storage.
     * 1. check if resource exists
     * 2. Validate the request data
     * 2. If not; send 404 error
     * 3. else; remove the resource
     * @param \App\Http\Requests\API\UpdateResourceRequest $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateResourceRequest $request, string $id)
    {
        return $this->sendSuccess('Update function is calleed');
    }
    
    /**
     * Remove the specified resource from storage.
     * 1. check if resource exists
     * 2. If not; send 404 error
     * 3. else; remove the resource
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {    
        return $this->sendSuccess('Destroy function is called');
    }
}
