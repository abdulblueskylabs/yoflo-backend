<?php

  namespace App\Http\Controllers\API\Node;

  use App\Http\Controllers\Controller;
  use App\Models\Node;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;

  class NodeController extends Controller
  {
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
      // Active node
      if ($request->hasFile('fileName')) {
        $request->validate(
          [
            'yoflo_id'          => 'required',
            'title'             => 'required',
            'unity_coordinates' => 'required',
          ]);

        Node::create(
          [
            'title'=>$request->title,
            'description'=>$request->description,
            'user_id'=>Auth::id(),
            'unity_coordinates'=>$request->unity_coordinates,

          ]);
      }
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
