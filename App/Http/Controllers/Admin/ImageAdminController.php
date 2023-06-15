<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadImageRequest;
use App\Main\Config\AppConst;

use App\Main\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ImageAdminController extends Controller
{
    protected $service;

    public function __construct(
        ImageService $service
    )
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $page = (int)$request->page;
        $data = [
            'page' => !empty($page) ? abs($page) : 1,
            'limit' => !empty($request->limit) ? (int)$request->limit : AppConst::PAGE_LIMIT,

        ];
        return $this->service->getAll($data);
    }

    public function store(UploadImageRequest $request)
    {

        $name = $request->file('image')->getClientOriginalName();
        $path = $request->file('image')->storeAs('public/images',$name);
        $pt = url(Storage::url($path));
        $data = [
            'data' =>
                [
                    'url' => $pt,
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

    public function update(UploadImageRequest $request, $id)
    {

        $name = $request->file('image')->getClientOriginalName();
        $path = $request->file('image')->store('public/images');
        $pt = Storage::url($name);
        $data = [
            'id' => $id,
            'data' =>
                [
                    'url' => $pt,
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
