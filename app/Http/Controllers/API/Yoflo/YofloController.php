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
      //
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create ()
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
