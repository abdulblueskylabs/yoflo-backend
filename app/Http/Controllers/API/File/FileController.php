<?php

  namespace App\Http\Controllers\API\File;

  use App\Http\Controllers\Controller;
  use App\Http\Traits\ResponseTrait;
  use App\Models\File;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;
  use Illuminate\Support\Facades\Storage;

  class FileController extends Controller
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
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store (Request $request)
    {
      $request->validate(
        [
          'node_id' => 'required',
          'file'   => 'required',
          'file.*' => 'required|mimes:png,jpg,jpeg,mp4,ogx,oga,ogv,ogg,webm,qt| max: 524288',
        ]);


       $file=$request->file('file');
        $disk = Storage::disk('gcs');
        $path = $disk->put(Auth::id(), $file);

        File::create(
          [
            'type'      =>$file->getMimeType(),
            'node_id'   => $request->node_id,
            'name'      => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'path'      => $path,
            'size'      => bytesToMegaBytes($file->getSize()), //Converting to MB
            'url'       => $disk->url($path),
            'extension' => $file->getClientOriginalExtension(),
            'user_id'   => Auth::id(),

          ]);


      return $this->sendResponse(['message' => 'data saved ']);
    }

    /**
     * Display the specified resource.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show ($id)
    {
      //
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit ($id)
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

      $request->validate(
        [
          'name' => 'required',
        ]);

      $file_belongs = File::where('id', $id)->where('user_id', Auth::id())->first();
      if (!$file_belongs) {
        return $this->sendError(['message' => 'No data']);
      }
      File::findorfail($id)->update(['name' => $request->name]);

      $payload = ['name' => $request->name];
      return $this->sendResponse($payload);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy ($id)
    {
      $file_belongs = File::where('id', $id)->where('user_id', Auth::id())->first();

      if (!$file_belongs) {
        return $this->sendError(['message' => 'No data']);
      }

      $disk = Storage::disk('gcs');
      if($disk->delete($file_belongs->path)) {
        $file_belongs->delete();
        return $this->sendResponse(['Message' => 'Delete success']);
      }
      return $this->sendError(['Message' => 'Unabale to Delete']);

    }
  }
