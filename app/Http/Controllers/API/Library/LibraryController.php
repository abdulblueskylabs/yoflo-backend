<?php

  namespace App\Http\Controllers\API\Library;

  use App\Http\Controllers\Controller;
  use App\Http\Resources\LibraryCollection;
  use App\Http\Resources\LibraryResource;
  use App\Http\Traits\ResponseTrait;
  use App\Models\File;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;

  class LibraryController extends Controller
  {
    use ResponseTrait;

    /**
     * Display a listing of the files associated with users.
     * @return \Illuminate\Http\Response
     */
    public function index (Request $request)
    {

      $user = Auth::user();
      $files = File::whereBelongsTo($user)->get();
      if ($files->isEmpty()) {
        $this->sendError(['message' => 'No file Found']);
      }
      return $this->sendResponse(new LibraryCollection($files));

    }

    /**
     * Display a specfic file record associated with users.
     * @return \Illuminate\Http\Response
     */
    public function show ($id)
    {

      $user = Auth::user();
      $file = File::where('id', $id)->where('user_id', $user->id)->firstorfail();
      if (!$file) {
        $this->sendError(['message' => 'No file Found']);
      }
      return $this->sendResponse(new LibraryResource($file));

    }

  }
