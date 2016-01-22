<?php

namespace App\Http\Controllers;

use App\Role;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Repositories\SellerRepo;
use App\Http\Controllers\Controller;
use App\Http\Requests\SellerRequest;
use Illuminate\Support\Facades\View;
use App\Http\Requests\SellerEditRequest;

class SellersController extends Controller
{
    function __construct(SellerRepo $sellerRepo) {
        $this->middleware('auth');

        $this->sellerRepo = $sellerRepo;
        View::share('roles', Role::pluck('label', 'id')->all());


    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(! auth()->user()->can('create_sellers'))
            return Redirect()->route('dashboard');

        $search = $request->all();
        $search['q'] = (isset($search['q'])) ? trim($search['q']) : '';
       
        $sellers = $this->sellerRepo->getAll($search);

        return View('sellers.index')->with([
            'sellers'         => $sellers,
            'search'           => $search['q'] 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('sellers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SellerRequest $request)
    {
        $input = $request->all();//only('name', 'email', 'password', 'password_confirmation', 'role');
        
        $this->sellerRepo->store($input);

        Flash('Seller created');

        return Redirect()->route('sellers');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(! auth()->user()->can('edit_sellers'))
            return Redirect()->route('dashboard');


        $seller = $this->sellerRepo->findById($id);
        $selectedRoles = $seller->roles()->select('roles.id AS id')->lists('id')->all();
        return View('sellers.edit')->with(compact('seller', 'selectedRoles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SellerEditRequest $request, $id)
    {
        $input = $request->all();//only('name', 'email', 'password', 'password_confirmation','role');

        $this->sellerRepo->update($id, $input);

        Flash('Seller updated');

        return Redirect()->route('sellers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $this->sellerRepo->destroy($id);

        Flash('Seller Deleted');

        return Redirect()->route('sellers');
    }

      /**
     * List of sellers for the modal view in seller sections
     * @param Request $request
     * @return mixed
     */
    public function list_sellers(Request $request)
    {
        return $this->sellerRepo->list_sellers($request->input('exc_id'), $request->input('key'));
    }
}
