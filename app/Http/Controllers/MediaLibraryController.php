<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Media;
use App\Models\MediaModel;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;

class MediaLibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->wantsJson()) {

            $mime = $request->mimeType;
            $search = $request->search;

            return Media::orderByDesc('id')
                ->where('collection_name', 'library')
                ->when($search && !empty($search), function ($query) use ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%')->orWhere('file_name', 'like', '%' . $search . '%');
                    });
                })->when($mime && !empty($mime), function ($query) use ($mime) {
                    $query->where('mime_type', 'like', $mime . '%');
                })->paginate(30)->withQueryString();
        }

        $this->authorize('viewAny', Media::class);

        return Inertia('MediaLibrary/Index', [
            'medias' => Media::orderByDesc('id')
                ->where('collection_name', 'library')
                ->when($request->input('search'), function ($query, $search) {
                    $query->where('name', 'like', '%' . $search . '%')->orWhere('file_name', 'like', '%' . $search . '%');
                })->paginate(30),
            'filters' => $request->only(['search', 'field', 'direction', 'mime'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->authorize('create', Media::class);

        if ($request->hasFile('files')) {

            try {

                $model = MediaModel::first();

                foreach ($request->file('files') as $key => $file) {

                    if ($file->isValid()) {

                        $file_org_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                        $file_ext = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);

                        $width = '';
                        $height = '';

                        if ($file_ext == 'svg') {

                            $parsed_xml     = simplexml_load_string(file_get_contents($file->getPathName()));
                            $svg_attributes = $parsed_xml->attributes();
                            $width = Str::replace('px', '', (string) $svg_attributes->width);
                            $height = Str::replace('px', '', (string) $svg_attributes->height);

                            $svgContent = file_get_contents($file->getPathName());
                            $parsedXml = simplexml_load_string($svgContent);
                            $svgAttributes = $parsedXml->attributes();

                            $width = Str::replace('px', '', (string) $svg_attributes->width);
                            $height = Str::replace('px', '', (string) $svg_attributes->height);

                            if (empty($width) || empty($height)) {
                                if (!empty($svgAttributes->viewBox)) {
                                    list(,, $viewBoxWidth, $viewBoxHeight) = explode(' ', (string) $svgAttributes->viewBox);
                                    if (empty($width)) {
                                        $width = $viewBoxWidth;
                                    }
                                    if (empty($height)) {
                                        $height = $viewBoxHeight;
                                    }
                                }
                            }
                        } else if (in_array($file_ext, ['JPEG', 'JPG', 'jpeg', 'jpg', 'PNG', 'png', 'GIF', 'gif', 'webp', 'WEBP'])) {

                            $height = Image::read($file)->height();
                            $width = Image::read($file)->width();
                        }

                        $media = $model->addMedia($file)
                            ->usingFileName(Str::slug($file_org_name) . '.' . $file_ext)
                            ->withCustomProperties([
                                'ext' => $file_ext,
                                'width' => $width,
                                'height' => $height,
                            ])
                            ->toMediaCollection('library', 'media'); //iilki collection name, ikincisi filesystem. ikincisi olmazsa default env dakini kullaniyor.

                        //optimize icin with height girelim
                        $opImagePath = Str::replace([config('app-ea.app_url').'/','/'],['','\\'],$media->getUrl('op'));
                        $imageOp = Image::read(public_path($opImagePath));
                        $media->setCustomProperty('op_width',$imageOp->width());
                        $media->setCustomProperty('op_height',$imageOp->height());
                        
                        //thumbnail icin with height girelim
                        $thImagePath = Str::replace([config('app-ea.app_url').'/','/'],['','\\'],$media->getUrl('th'));
                        $imageTh = Image::read(public_path($thImagePath));
                        $media->setCustomProperty('th_width',$imageTh->width());
                        $media->setCustomProperty('th_height',$imageTh->height());

                        //save
                        $media->save();

                    }
                }

                return response()->json([
                    'status' => 'done',
                ]);
            } catch (\Throwable $th) {

                return response()->json([
                    'status' => 'error',
                    'message' => $th->getMessage()
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Media $media)
    {
        $this->authorize('viewAny', Media::class);

        return $media->toArray();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Media $media)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Media $media)
    {

        $this->authorize('update', Media::class);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'file_name' => ['required', 'string', 'max:255'],
        ]);

        $file_name = Str::slug($request->file_name);
        $media->name = $request->name;
        $media->file_name = $file_name . '.' . $media->custom_properties['ext'];
        $media->save();

        return back()->with('flash', [
            'type' => 'success',
            'message' => "Seçilen medya güncellendi!"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Media $media)
    {
        $this->authorize('foreDelete', Media::class);

        self::resetAvatar($media);
        $media->delete();
        return back();
    }


    //BULK
    public function bulkDelete(Request $request)
    {
        $this->authorize('forceDelete', Media::class);

        $medias = Media::whereIn('id', $request->items)->get();
        foreach ($medias as $key => $media) {

            self::resetAvatar($media);
            $media->delete();
        }
        return back()->with('flash', [
            'type' => 'success',
            'message' => "Seçilen dokümanlar silindi!"
        ]);
    }


    //avatarlari silinince null yap
    public function resetAvatar(Media $media)
    {

        User::withoutTrashed()->where('avatar', $media->original_url)->update([
            'avatar' => null,
            'avatar_preview_url' => null
        ]);
    }
}
