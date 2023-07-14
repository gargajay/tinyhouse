<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ImageController extends Controller
{
    public function upload_image(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;

        try {
            if ($request->hasFile('images')) {
                $images = uploadImages($request->file('images'), IMAGE_UPLOAD_PATH);
            }

            if ($request->hasFile('image')) {
                $image = uploadSingleImage($request->file('image'), IMAGE_UPLOAD_PATH);
            }

            if ($request->hasFile('imagekey')) {
                $imagekey = uploadImagesKey($request->file('imagekey'), $request->keys, IMAGE_UPLOAD_PATH);
            }

            $data['images'] = $images ?? '';
            $data['image'] = $image ?? '';
            $data['imagekey'] = $imagekey ?? '';

            $response['data'] = $data;
            $response['message'] = 'Images upload successfully';
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }

        return response()->json($response, $response['status']);
    }
}
