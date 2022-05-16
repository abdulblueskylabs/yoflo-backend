<?php

  namespace App\Http\Controllers\API\Folder;

  use App\Http\Controllers\Controller;
  use App\Models\Folder;
  use Illuminate\Http\Request;
  use \App\Http\Traits\ResponseTrait;
  use Illuminate\Support\Facades\Auth;
  use Illuminate\Validation\Rule;

  class FolderController extends Controller
  {
    use ResponseTrait;

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index ()
    {
      $user = Auth::user();

      $root_folders = Folder::where('user_id', $user->id)->where('parent_folder_id', null)->get();
      if (!$root_folders) {
        $error = ['message' => 'No folder found'];
        $this->sendError($error);
      }

      $payload = $root_folders;
      return $this->sendResponse($payload);
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store (Request $request)
    {
      $user = Auth::user();
      $request->validate(
        [
          'name' => 'required',
        ]);
      $folder=Folder::where('parent_folder_id',$request->parent_folder_id )->where('user_id',Auth::id())->first();
      if(!$folder) {

        if (!$request->parent_folder_id) {
          $folder = Folder::create(
            [
              'user_id' => $user->id,
              'name'    => $request->name ?: 'default',
            ]);

        } else {
          $folder = Folder::create(
            [
              'user_id'          => $user->id,
              'name'             => $request->name ?: 'default',
              'parent_folder_id' => $request->parent_folder_id,
            ]);
        }

        $payload = ['id' => $folder->id];
        return $this->sendResponse($payload);
      }
      return $this->sendError(['message'=>'folder Already exists']);
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update (Request $request, $id)
    {
      $user = Auth::user();


        $folder = Folder::create(
          [
            'user_id'          => $user->id,
            'name'             => $request->name ?: 'default',
            'parent_folder_id' => $request->parent_folder_id,
          ]);


      $payload = ['id' => $folder->id];
      return $this->sendResponse($payload);
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
