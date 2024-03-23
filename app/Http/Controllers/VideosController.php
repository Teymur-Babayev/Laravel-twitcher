<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\VideoCategories;
use App\Models\VideoSales;
use App\Notifications\NewVideoSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File as FileFacade;
use Illuminate\Http\File;

class VideosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')
                ->except(['browse', 'videoPage', 'increaseViews']);
    }

    public function myVideos(Request $request)
    {
        $videos = $request->user()
                        ->purchasedVideos()
                        ->with('streamer');

        if ($request->has('search_term')) {
            $videos->where('title', 'LIKE', '%'.$request->search_term.'%');
        }

        $videos = $videos->paginate(4);

        return Inertia::render('Videos/OrderedVideos', compact('videos'));
    }

    public function videoPage(Video $video, String $slug, Request $request)
    {
        $video->load('streamer');

        return Inertia::render('Videos/SingleVideo', compact('video'));
    }

    public function unlockVideo(Video $video, Request $request)
    {
        $video->load('streamer');

        if ($video->canBePlayed) {
            return back()->with('message', __('You already have access to this video'));
        }


        return Inertia::render('Videos/Unlock', compact('video'));
    }

    public function purchaseVideo(Video $video, Request $request)
    {
        // check if user already bought
        if ($video->canBePlayed) {
            return back()->with('message', __('You already have access to this video'));
        }

        // record order
        $videoSale = new VideoSales();
        $videoSale->video_id = $video->id;
        $videoSale->streamer_id = $video->user_id;
        $videoSale->user_id = $request->user()->id;
        $videoSale->price = $video->price;
        $videoSale->save();

        // notify streamer of this sale (on platform)
        $video->streamer->notify(new NewVideoSale($videoSale));

        // redirect to my videos
        return redirect(route('videos.ordered'))->with('message', __("Thank you, you can now play the video!"));
    }

    public function increaseViews(Video $video, Request $request)
    {
        $sessionName = ip2long($request->ip()) . '_' . $video->id . '_viewed';

        if (!$request->session()->has($sessionName)) {
            // only increase views if the user didn't already play the video this session
            $video->increment('views');

            // set the session to avoid increasing again
            $request->session()->put($sessionName, date('Y-m-d H:i:s'));

            // return the result
            return response()->json(['result' => 'INCREASED', 'session' => $sessionName]);
        } else {
            return response()->json(['result' => 'ALREADY VIEWED THIS SESSION, NOT INCREASING VIEW COUNT']);
        }
    }

    public function browse(VideoCategories $videocategory = null, String $slug = null)
    {
        $request = request();

        if (!$videocategory) {
            $videos = Video::with(['category', 'streamer']);
        } else {
            $videos = $videocategory->videos()->with(['category', 'streamer']);
        }

        switch ($request->sort) {
            case 'Most Viewed':
            default:
                $videos = $videos->orderByDesc('views');
                break;

            case 'Recently Uploaded':
                $videos = $videos->orderByDesc('created_at');
                break;

            case 'Older Videos':
                $videos = $videos->orderBy('created_at');
                break;

            case 'Highest Price':
                $videos = $videos->orderByDesc('price');
                break;

            case 'Lowest Price':
                $videos = $videos->orderBy('price');
                break;

            case 'Only Free':
                $videos = $videos->where('price', 0)->orderByDesc('views');
                break;
        }

        // if keyword
        if ($request->filled('search')) {
            $videos->where('title', 'LIKE', '%' . $request->search . '%');
        }

        // case categories
        if ($request->filled('selectedCategories')) {
            $videos->whereHas('category', function ($query) use ($request) {
                $query->whereIn('category_id', $request->selectedCategories);
            });
        }

        // fetch videos
        $videos = $videos->paginate(12)->appends($request->query());

        // the image
        $exploreImage = asset('images/browse-videos-icon.png');

        // all video categories
        $categories = VideoCategories::orderBy('category')->get();

        // assing to simple category
        $category = $videocategory;


        // render the view
        return Inertia::render('Videos/BrowseVideos', compact('videos', 'category', 'exploreImage', 'categories'));
    }

    public function videosManager(Request $request)
    {
        Gate::authorize('channel-settings');

        $videos = $request->user()->videos()
                            ->with('category')
                            ->withSum('sales', 'price')
                            ->orderByDesc('id')
                            ->paginate(9);


        return Inertia::render('Videos/MyVideos', compact('videos'));
    }

    public function uploadVideos(Request $request)
    {
        Gate::authorize('channel-settings');

        $video = ['id' => null,
                    'title' => '',
                    'category_id' => '',
                    'price' => 0,
                    'free_for_subs' => 'no'];

        $categories = VideoCategories::orderBy('category')->get();

        return Inertia::render('Videos/Partials/UploadVideo', compact('video', 'categories'));
    }

    public function editVideo(Video $video)
    {
        Gate::authorize('channel-settings');

        $categories = VideoCategories::orderBy('category')->get();

        return Inertia::render('Videos/Partials/UploadVideo', compact('video', 'categories'));
    }

    public function save(Request $request)
    {
        Gate::authorize('channel-settings');

        $request->validate([
            'title' => 'required|min:2',
            'price' => 'required|numeric',
            'free_for_subs' => 'required|in:yes,no',
            'thumbnail' => 'required|mimes:png,jpg',
            'video_file' => 'required',
            'category_id' => 'required|exists:video_categories,id'
        ]);

        // resize & upload thumbnail
        $thumbnail = Image::make($request->file('thumbnail'))->fit(640, 320)->stream();
        $thumbFile = 'thumbnails/' . uniqid() . '-' . auth()->id() . '.' . $request->file('thumbnail')->getClientOriginalExtension();
        Storage::disk(env('FILESYSTEM_DISK'))->put($thumbFile, $thumbnail);
        Storage::disk(env('FILESYSTEM_DISK'))->setVisibility($thumbFile, 'public');

        // create video entry
        $request->user()->videos()->create([
            'title' => $request->title,
            'price' => $request->price,
            'free_for_subs' => $request->free_for_subs,
            'thumbnail' => $thumbFile,
            'video' => $request->video_file,
            'disk' => env('FILESYSTEM_DISK'),
            'category_id' => $request->category_id
    ]);


        return to_route('videos.list')->with('message', __('Video successfully uploaded'));
    }


    public function updateVideo(Video $video, Request $request)
    {
        Gate::authorize('channel-settings');

        $request->validate([
            'title' => 'required|min:2',
            'price' => 'required|numeric',
            'free_for_subs' => 'required|in:yes,no',
            'category_id' => 'required|exists:video_categories,id'
        ]);

        if ($request->user()->id !== $video->user_id) {
            abort(403, __("You do not seem to be the owner of this video"));
        }

        if ($request->filled('video_file')) {
            $video->video = $request->video_file;
            $video->save();
        }

        // resize & upload thumbnail
        if ($request->hasFile('thumbnail')) {
            $thumbnail = Image::make($request->file('thumbnail'))->fit(640, 320)->stream();
            $thumbFile = 'thumbnails/' . uniqid() . '-' . auth()->id() . '.' . $request->file('thumbnail')->getClientOriginalExtension();

            Storage::disk(env('FILESYSTEM_DISK'))->put($thumbFile, $thumbnail);
            Storage::disk(env('FILESYSTEM_DISK'))->setVisibility($thumbFile, 'public');

            $video->thumbnail = $thumbFile;
            $video->save();
        }

        // create video entry
        $video->update([
            'title' => $request->title,
            'price' => $request->price,
            'free_for_subs' => $request->free_for_subs,
            'disk' => env('FILESYSTEM_DISK'),
            'category_id' => $request->category_id
        ]);


        return back()->with('message', __('Video successfully updated'));
    }

     // attach video upload
     public function uploadChunkedVideo(Request $request)
     {
         $file = $request->file;
         $is_last = $request->is_last;

         // temp chunks path
         $path = Storage::disk('public')->path("chunks/{$file->getClientOriginalName()}");

         // filename without .part in it
         $withoutPart = basename($path, '.part');

         // set file name inside path without .part
         $renamePath = public_path('chunks/' . $withoutPart);

         // set allowed extensions
         $allowedExt = ['ogg', 'wav', 'mp4', 'webm', 'mov', 'qt'];
         $fileExt = explode('.', $withoutPart);
         $fileExt = end($fileExt);
         $fileExt = strtolower($fileExt);

         // preliminary: validate allowed extensions
         // we're validating true mime later, but just to avoid the effort if fails from the begining
         if (!in_array($fileExt, $allowedExt)) {
             Storage::disk('public')->delete($renamePath);
             throw new \Exception('Invalid extension');
         }

         // build allowed mimes
         $allowedMimes = [
                            'video/mp4',
                            'video/webm',
                            'video/mov',
                            'video/ogg',
                            'video/qt',
                            'video/quicktime'
                        ];

         // append chunk to the file
         FileFacade::append($path, $file->get());


         // finally, let's make the file complete
         if ($is_last == "true") {
             // rename the file to original name
             FileFacade::move($path, $renamePath);

             // set a ref to local file
             $localFile = new File($renamePath);

             try {
                 // first, lets get the mime type
                 $finfo = new \finfo();
                 $mime = $finfo->file($renamePath, FILEINFO_MIME_TYPE);
             } catch(\Exception $e) {
                 $mime = null;
             }

             // validate allowed mimes
             if ($mime) {
                 if (!in_array($mime, $allowedMimes) && $mime != 'application/octet-stream') {
                     throw new \Exception('Invalid file type: ' . $mime);
                 }

                 // this is from chunks, keep it as it passed the other validation
                 if ($mime == 'application/octet-stream') {
                     $mime = 'video';
                 }
             } else {
                 $mime = 'video';
             }


             // set file destination
            $fileDestination = 'videos';

             // Move this thing
             $fileName = Storage::disk(env('FILESYSTEM_DISK'))->putFile($fileDestination, $localFile, 'public');

             // remove it from chunks folder
             FileFacade::delete($renamePath);

             //  $video->video = $fileName;
             //  $video->restore();

             return response()->json(['result' => $fileName]);
         }// if is_last
     }

     public function delete(Request $request)
     {
         Gate::authorize('channel-settings');

         // find video
         $video = $request->user()->videos()->findOrFail($request->video);

         // delete file from disk
         Storage::disk($video->disk)->delete($video->video);
         Storage::disk($video->disk)->delete($video->thumbnail);

         // delete video sales
         $video->sales()->delete();

         // delete video
         $video->delete();

         return back()->with('message', __('Video removed'));
     }
}
