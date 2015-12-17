<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Repositories\ClientRepo;
use App\Repositories\SellerRepo;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    
    function __construct(ClientRepo $clientRepo, SellerRepo $sellerRepo) {
    	$this->clientRepo = $clientRepo;
    	$this->sellerRepo = $sellerRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$clients = $this->clientRepo->getTotal();
    	$sellers = $this->sellerRepo->getTotal();

        return View('dashboard.index')->with(compact('clients','sellers'));
    }

   
}
