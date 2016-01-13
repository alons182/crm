<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Repositories\ClientRepo;
use App\Repositories\SellerRepo;
use App\Repositories\PropertyRepo;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    
    function __construct(ClientRepo $clientRepo, SellerRepo $sellerRepo, PropertyRepo $propertyRepo) {
        
        $this->middleware('auth');

    	$this->clientRepo = $clientRepo;
    	$this->sellerRepo = $sellerRepo;
        $this->propertyRepo = $propertyRepo;
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
