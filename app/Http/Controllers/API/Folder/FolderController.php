<?php

  namespace App\Http\Controllers\API\Folder;

  use App\Http\Controllers\Controller;
  use App\Models\Folder;
  use Illuminate\Http\Request;
  use \App\Http\Traits\ResponseTrait;
  use Illuminate\Support\Facades\Auth;

  class FolderController extends Controller
  {
    use ResponseTrait;

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index ()
    {
      //
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create (Request $request)
    {
      //

    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store (Request $request)
    {
      $user = Auth::user();
      if (!$request->parent_folder_id) {
        $folder = Folder::create(
          [
            'user_id' => $user->id,
            'name'    => $request->name ?: 'default',
          ]);

      } else {
        $folder = Folder::create(
          [
            'user_id'   => $user->id,
            'name'      => $request->name ?: 'default',
            'parent_folder_id' => $request->parent_folder_id,
          ]);
      }
      $payload = ['id' => $folder->id];
      return $this->sendResponse($payload);
    }

    /**
     * Display the specified resource.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show ($id)
    {
      //
      $user = Auth::user();
      $root_folders=Folder::where('user_id',$user->id)->where('parent_folder_id')->get();
      if(!$root_folders)
      {
        $payload=$root_folders;
        return $this->sendResponse($payload );
      }
      $error=['message'=>'No folder found'];
      $this->sendError($error);

    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit ($id)
    {
      //
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update (Request $request, $id)
    {
      //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy ($id)
    {
      //
    }
  }
