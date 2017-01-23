<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Repositories\FileRepo;
use Illuminate\Http\Request;

class FilesController extends Controller
{
    
    function __construct(FileRepo $fileRepo) {
        $this->middleware('auth');
    	$this->fileRepo = $fileRepo;
    }

    /**
     * Store a newly created resource in storage.
     * POST /photos
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data['client_id'] = $request->input('id');
        $data['file'] = $_FILES['file'];

        return $this->fileRepo->store($data);;
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /photos/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        return $this->fileRepo->destroy($id);;
    }
    

   
   

}
