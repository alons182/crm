<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    
    function __construct() {
        
        $this->middleware('auth');

    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	/*$clients = $this->clientRepo->getTotal();
    	$sellers = $this->sellerRepo->getTotal();
        $properties = $this->propertyRepo->getTotal();*/

        return View('dashboard.index');//->with(compact('clients','sellers','properties'));
    }

   
}
