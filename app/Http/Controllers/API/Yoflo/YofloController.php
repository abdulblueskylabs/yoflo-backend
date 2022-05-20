<?php

  namespace App\Http\Controllers\API\Yoflo;

  use App\Http\Controllers\Controller;
  use App\Http\Traits\ResponseTrait;
  use App\Models\Yoflo;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;
  use Illuminate\Validation\Rule;

  class YofloController extends Controller
  {

    use ResponseTrait;

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index ()
    {
      $yoflos = Yoflo::where('user_id', Auth::id())->get();
      if ($yoflos->isEmpty()) {
        $error = ['message' => 'No data'];
        return $this->sendError($error);
      }
      return $this->sendResponse($yoflos);

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
          'folder_id' => 'required',
          'title'     => Rule::unique('yoflos')->where(function ($query) {
            return $query->where('user_id', Auth::id());
          }),
        ]);

      $user = Auth::user();

      $yoflo = Yoflo::create(
        [
          'user_id'     => $user->id,
          'title'       => $request->title,
          'description' => $request->description,
          'folder_id'   => $request->folder_id,
        ]);

      $payload = ['id' => $yoflo->id];
      return $this->sendResponse($payload);

    }

    /**
     * Provide the specified resource.
     * @param int $folder_id
     * @return \Illuminate\Http\Response
     */
    public function show ($folder_id)
    {
      $yoflo = Yoflo::where('user_id', Auth::id())->where('folder_id', $folder_id)->get();

      if ($yoflo->isEmpty()) {
        $error = ['message' => 'No data'];
        return $this->sendError($error);
      }
      return $this->sendResponse($yoflo);

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
          'title' => ['required', Rule::unique('yoflos')->where(function ($query) {
            return $query->where('user_id', Auth::id());
          }),],
        ]);

      $yoflo=Yoflo::where('user_id','=',Auth::id())->where('id','=',$id)->first();

      if(!$yoflo)
        return $this->sendError(['message'=>'No data']);

      $yoflo->update(['title' => $request->title]);

      $payload = ['id' => $id];
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
