<?php

namespace App\Http\Controllers;

use App\Media;
use App\Tool;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    /**
     * Upload the file.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function fileUpload(Request $request)
    {
        $mimes = explode(',', str_replace('.', '', Media::FILE_ALLOWED));

        $this->validate($request, [
            // 'file' => 'required|file|mimes:' . $mimes . '|max:' . Media::FILE_MAX_SIZE
            'file' => [
                'required',
                'file',
                'max:'.Media::FILE_MAX_SIZE,
                function ($attribute, $value, $fail) use ($mimes) {
                    if (! in_array($value->getClientOriginalExtension(), $mimes)) {
                        $fail("The {$attribute} must be a file of type: ".implode(', ', $mimes).'.');
                    }
                },
            ],
        ]);

        $uniqid = uniqid();
        $path = 'upload/';
        $name = $uniqid.'.'.$request->file->getClientOriginalExtension();
        if (empty($request->file->storeAs($path, $name, 'public'))) {
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
        $path = '/storage/'.$path.$name;

        return response()->json([
            'path' => $path,
            'thumbnail' => Tool::mimeToUrl($path, $request->file->getClientMimeType()),
            'uniqid' => $uniqid,
        ], 202);
    }

    /**
     * Upload the image.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function imageUpload(Request $request)
    {
        $mimes = str_replace('.', '', Media::IMAGE_ALLOWED);

        $this->validate($request, [
            'file' => 'required|mimes:'.$mimes.'|max:'.Media::IMAGE_MAX_SIZE,
        ]);

        $uniqid = uniqid();
        $path = 'upload/';
        $name = $uniqid.'.'.$request->file->getClientOriginalExtension();
        if (empty($request->file->storeAs($path, $name, 'public'))) {
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
        $path = '/storage/'.$path.$name;

        return response()->json([
            'path' => $path,
            'uniqid' => $uniqid,
        ], 202);
    }

    /**
     * Get location by address.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function mapSearch(Request $request)
    {
        $this->validate($request, [
            'address' => 'required|string',
        ]);

        $address = $request->get('address');

        $location = false;
        try {
            $url = 'https://maps.google.com/maps/api/geocode/json?address='.urlencode(utf8_encode($address)).'&key='.config('commonlandsnet.google_key_geocoding');
            $data = @file_get_contents($url);

            $res = json_decode($data, true);
            if ($res['status'] != 'OK') {
                return response()->json(['message' => 'Not Found.'], 404);
            }

            $location = [
                'latitude' => $res['results'][0]['geometry']['location']['lat'] ?? null,
                'longitude' => $res['results'][0]['geometry']['location']['lng'] ?? null,
            ];

            if ($location['latitude'] && $location['longitude']) {
                return response()->json(['data' => $location]);
            }
        } catch (\Exception $e) {
            $location = false;
        }

        return response()->json(['message' => 'Not Found.'], 404);
    }
}
