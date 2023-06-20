<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadImageRequest;
use App\Main\Services\AvatarService;
use App\Main\Services\ImageService;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    protected ImageService $service;
    protected AvatarService $avatarService;

    public function __construct(
        ImageService  $service,
        AvatarService $avatarService

    )
    {
        $this->service = $service;
        $this->avatarService = $avatarService;
    }

    public function store(UploadImageRequest $request)
    {
        $name = $request->file('image')->getClientOriginalName();
        $path = $request->file('image')->storeAs('public/images', $name);
        $pt = url(Storage::url($path));
        $data = [
            'data' =>
                [
                    'url' => $pt,
                ],

        ];
        return $this->service->save($data);
    }

    public function updateAvatar(UploadImageRequest $request)
    {
        $result = $this->store($request);
        if ($result->status() == 200) {

            $userId = $request->user()->id;
            $js = json_decode($result->content(), true);
            $avatarId = $js['data']['id'];
            return $this->avatarService->save(
                $userId, $avatarId
            );
        }
        return $result;
    }

}
