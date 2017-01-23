<?php namespace App\Repositories;


use App\File as Adjunto;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FileRepo extends DbRepo{



	/**
     * @param Client $model
     */
    function __construct(Adjunto $model)
    {
        $this->model = $model;
        $this->limit = 10;
    }

   /**
     * Save a photo in the DB
     * @param $data
     * @return mixed
     */
    public function store($data)
    {
        $cant = count($this->getFiles($data['client_id']));
        $data['name'] = ($data['file']) ? $this->storeFile($data['file'], ++ $cant, 'clients/' . $data['client_id'].'/files') : '';
      

        $file = $this->model->create($data);

        return $file;
    }

    /**
     * Delete a client by ID
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $file = $this->findById($id);
        $file_delete = $file->name;
        $client_id = $file->client_id;
        $file->delete();

        if(File::exists(dir_photos_path('clients') .$client_id.'/files/'. $file_delete))
            File::delete(dir_photos_path('clients') .$client_id.'/files/'. $file_delete);
       
       

        return $file;
    }


    /**
     * Get the photos from one product
     * @param $id
     * @return mixed
     */
    public function getFiles($id)
    {
        return $this->model->where('client_id', '=', $id)->get();
    }

    /**
     * Save the photo in the server
     * @param $file
     * @param $name
     * @param $directory
     * @param null $width
     * @param null $height
     * @param $thumbWidth
     * @param null $thumbHeight
     * @param null $watermark
     * @return string
     */
    public function storeFile($file, $name, $directory)
    {
        $extension = pathinfo($file["name"], PATHINFO_EXTENSION);
        $filename = Str::slug($file["name"].'_'.$name) . '.' . $extension;
        $path = dir_photos_path($directory);
        //$file = Image::make($file["tmp_name"]);
        //dd($file);
        File::exists($path) or File::makeDirectory($path, 0775, true);
        
        if ( ! File::copy($file["tmp_name"], $path . $filename))
        {
            die("Couldn't copy file");
        }
        /*$image->interlace();

        // IF THE FILE SIZE IS BIGGER(1MB+) RESIZE
        if($image->filesize() >= 1048576)
        {
            if ($width)
            {
                if ($image->width() > $image->height())
                {
                    if ($image->width() >= $width)
                    {
                        $image->resize($width, $height, function ($constraint)
                        {
                            $constraint->aspectRatio();
                        });
                    } else
                    {
                        $image->resize($image->width(), $height, function ($constraint)
                        {
                            $constraint->aspectRatio();
                        });
                    }

                } else
                {
                    if ($image->height() >= $width)
                    {
                        $image->resize($height, $width, function ($constraint)
                        {
                            $constraint->aspectRatio();
                        });
                    } else
                    {
                        $image->resize($image->height(), $width, function ($constraint)
                        {
                            $constraint->aspectRatio();
                        });
                    }
                }
            }
        }
        if($watermark) $image->insert('img/logo.png','center');
        $image->save($path . $filename, 60)->resize($thumbWidth, $thumbHeight, function ($constraint)
        {
            $constraint->aspectRatio();
        })->interlace()->save($path . 'thumb_' . $filename, 60);
        */
        return $filename;
    }
    
}
