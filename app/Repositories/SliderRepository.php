<?php

namespace App\Repositories;

use App\Models\Media;
use App\Models\Slider;
use App\Traits\HelperTrait;
use Illuminate\Support\Str;
use App\Traits\UploaderTrait;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Storage;

/**
 * Class SliderRepository
 * @package App\Repositories
 * @version November 6, 2018, 9:09 am UTC
 *
 * @method SliderRepository findWithoutFail($id, $columns = ['*'])
 * @method SliderRepository find($id, $columns = ['*'])
 * @method SliderRepository first($columns = ['*'])
 */
class SliderRepository extends BaseRepository
{
    use UploaderTrait, HelperTrait; 
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'position',
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Slider::class;
    }

    /**
     * Create a  Slider
     *
     * @param Request $request
     *
     * @return Slider
     */
    public function createSlider($request)
    { 
        $input = collect($request->all());
        $service = Slider::create($input->only($request->fillable('sliders'))->all());

        if($request->has('file')){
            $this->uploadFile($request, $service);
        }
        return $service;
    }

    /**
     * Update the Slider
     *
     * @param Request $request
     *
     * @return Slider
     */
    
    public function updateSlider($id, $request)
    {
       $service = Slider::findOrFail($id);
       
       $input = collect($request->all());
       $service->update($input->only($request->fillable('sliders'))->all());
       $image = Media::where('table_id',$service->id)->where('table_name', 'sliders')->first();
        
        // Upload File
        if($request->has('file')){
            if (!empty($image)) { // Delete Existing.
				Storage::disk('public')->delete($image->path);
				$image->delete();
			}
            $this->uploadFile($request, $service);
        }
        return $service;
    }

    // File upload.
	public function uploadFile($request, $service)
	{
		if ($request->has('file')) {
			if($request->input('file')){
				$media                = $this->base64FileUpload($request->input('file'), 'menus');
				$input['name']        = $media['name'];
				$input['path']        = $media['path'];
				$input['table_id']    = $service->id;
				$input['table_name']  = "sliders";
				$input['type']        = \File::extension($this->getFile($media['path']));
				$media                = Media::create($input);
		}
	  }
	}

    // Search Menus
    public function searchServices($search, $position)
    {
        $result = Slider::where('menus.position', $position)->get();
        return $result;
    }

    // Get slider by restaurant id.
    public function getSlider($request)
    {
        $result = Slider::where('restaurant_id', $request->restaurant_id)->get();
        $restaurant = $this->getRestaurant($request->restaurant_id);
        $slider['top'] = [];
        $slider['middle'] = [];
        $slider['bottom'] = [];
        if(!empty($result)){
            foreach ($result as $item) {
           
                if(isset($slider[$item['position']])){
                    $temp['id'] = $item->id;
                    $temp['restaurant_id'] = $item->restaurant_id;
                    $temp['restaurant_name'] = !empty($restaurant) ?  $restaurant->name : "";
                    $temp['image'] = $this->getSliderImage($item->id);
                    $slider[$item['position']][] = $temp;
                }else{
                    $temp['id'] = $item->id;
                    $temp['restaurant_id'] = $item->restaurant_id;
                    $temp['restaurant_name'] = !empty($restaurant) ?  $restaurant->name : "";
                    $temp['image'] = $this->getSliderImage($item->id);
                    $slider[$item['position']][] = $temp; 
                }
            }
        }
       
        return $slider;
    }
}
