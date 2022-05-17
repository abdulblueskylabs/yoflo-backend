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
    public function index ($id)
    {
      $user = Auth::user();

      $root_folders = Folder::where('user_id', $user->id)->where('parent_folder_id', null)->get();
      if ($root_folders->isEmpty()) {
        $error = ['message' => 'No folder found'];
       return  $this->sendError($error);
      }

      return $this->sendResponse($root_folders);
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

      // Check whether folder exists on same level
      $folder = Folder::where('parent_folder_id', $request->parent_folder_id)
        ->where('user_id', Auth::id())
        ->where('name', $request->name)
        ->first();
      if ($folder->isEmpty()) {

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
      return $this->sendError(['message' => 'Folder already exists']);
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update (Request $request, $id)
    {
      $request->validate(
        [
          'name' => 'required',
        ]);

      // Check whether folder exists on same level
      $folder = Folder::where('parent_folder_id', $request->parent_folder_id)
        ->where('user_id', Auth::id())
        ->where('name', $request->name)
        ->first();

      if ($folder->isEmpty()) {

        Folder::findorfail($id)->update(['name'=> $request->name]);

        $payload = ['id' => $id];
        return $this->sendResponse($payload);
      }
      return $this->sendError(['message' => 'Folder already exists']);
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
