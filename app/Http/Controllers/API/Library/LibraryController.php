<?php

  namespace App\Http\Controllers\API\Library;

  use App\Http\Controllers\Controller;
  use App\Http\Resources\LibraryCollection;
  use App\Http\Traits\ResponseTrait;
  use App\Models\File;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;

  class LibraryController extends Controller
  {
    use ResponseTrait;

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index (Request $request)
    {
      $request->validate(
        [
          'node_id' => 'required',
        ]);

      $user = Auth::user();
      $files = File::whereBelongsTo($user)->where('node_id', $request->node_id)->paginate();
      if ($files->isEmpty()) {
        $this->sendError(['message' => 'No file Found']);
      }
      return $this->sendResponse(new LibraryCollection($files));

    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store (Request $request)
    {

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
