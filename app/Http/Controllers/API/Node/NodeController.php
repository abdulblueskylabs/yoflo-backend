<?php

  namespace App\Http\Controllers\API\Node;

  use App\Http\Controllers\Controller;
  use App\Http\Resources\LibraryCollection;
  use App\Http\Resources\NodeCollection;
  use App\Http\Resources\NodeResource;
  use App\Http\Traits\ResponseTrait;
  use App\Models\File;
  use App\Models\Node;
  use App\Models\NodeType;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;

  class NodeController extends Controller
  {
    use ResponseTrait;

    /**
     * Display a listing of the nodes assicated with users.
     * @return \Illuminate\Http\Response
     */
    public function index ()
    {
      $node=Node::where('user_id',Auth::id())->with('files')->get();
      if (!$node) {
        $this->sendError(['message' => 'No file Found']);
      }
      return $this->sendResponse(new NodeCollection($node));
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store (Request $request)
    {
      // Active node
      if (!$request->hasFile('files')) {
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
        return $this->sendResponse($node);

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
