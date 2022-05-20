<?php

  namespace App\Http\Controllers\API\Node;

  use App\Http\Controllers\Controller;
  use App\Models\Node;
  use App\Models\NodeType;
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
            'yoflo_id'    => 'required',
            'title'       => 'required',
            'coordinates' => 'required',
          ]);

        $nodetye = NodeType::where('name', 'active')->first();
        $node = Node::create(
          [
            'title'        => $request->title,
            'description'  => $request->description,
            'user_id'      => Auth::id(),
            'coordinates'  => $request->coordinates,
            'node_type_id' => $nodetye->id,
            'yoflo_id'     => $request->yoflo_id,
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
