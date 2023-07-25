<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdvisoryRequest;
use App\Main\Services\AdvisoryService;
use Illuminate\Http\Response;

class AdvisoryController extends Controller
{
    protected $service;

    public function __construct(
        AdvisoryService $service
    )
    {
        $this->service = $service;
    }

    public function store(AdvisoryRequest $request)
    {

        $data = [
            'data' =>
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'content' => $request['content'],
                    'status'=>0,
                ],

        ];

        return $this->service->save($data);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return $this->service->getById($id);
    }

    public function update(AdvisoryRequest $request, $id)
    {
        $data = [
            'id' => $id,
            'data' =>
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'content' => $request['content'],
                    'status'=>$request['status'],
                ],
        ];

        return $this->service->save($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}
