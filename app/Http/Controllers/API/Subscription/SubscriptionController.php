<?php

namespace App\Http\Controllers\API\Subscription;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    //

  public function index()
  {

    $data=Subscription::where('is_active',1)->all();
    if(!$data)
      return $this->sendError('No data',404);
    else
      return $this->sendResponse($data);

  }
}
