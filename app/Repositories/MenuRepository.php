<?php

namespace App\Repositories;

use App\Models\Menu;
use App\Models\Media;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use App\Traits\UploaderTrait;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Storage;

/**
 * Class MenuRepository
 * @package App\Repositories
 * @version November 6, 2018, 9:09 am UTC
 *
 * @method MenuRepository findWithoutFail($id, $columns = ['*'])
 * @method MenuRepository find($id, $columns = ['*'])
 * @method MenuRepository first($columns = ['*'])
 */
class MenuRepository extends BaseRepository
{
    use UploaderTrait;
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'category_id',
        'name',
        'slug',
        'price',
        'description',
        'menu_type',
        'discount_type',
        'discount',
        'status'
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
        return Menu::class;
    }

    /**
     * Create a  Service
     *
     * @param Request $request
     *
     * @return Menu
     */
    public function createService($request)
    {
        $request['slug'] = Str::slug($request->name);
        $input = collect($request->all());
        $service = Menu::create($input->only($request->fillable('menus'))->all());

        if($request->has('file')){
            $this->uploadFile($request, $service);
        }
        return $service;
    }

    /**
     * Update the Service
     *
     * @param Request $request
     *
     * @return Menu
     */
    
    public function updateService($id, $request)
    {
       $service = Menu::findOrFail($id);
       $request['slug'] = $request->has('name') ? Str::slug($request->name) :$service->slug;
       $input = collect($request->all());
       $service->update($input->only($request->fillable('menus'))->all());
       $image = Media::where('table_id',$service->id)->where('table_name', 'menus')->first();
        
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
				$input['table_name']  = "menus";
				$input['type']        = \File::extension($this->getFile($media['path']));
				$media                = Media::create($input);
		}
	  }
	}

    // Search Menus
    public function searchServices($search, $category)
    {
       
        $result = Service::where('menus.category_id', $category)
                         ->select('menus.*')
                         ->join('menu_categories', 'menu_categories.id', '=', 'menus.category_id')
                         ->where('menu_categories.name', 'LIKE', '%' . $search . '%')
                         ->orWhere('menus.name', 'LIKE', '%' . $search . '%')
                         ->orWhere('menus.slug', 'LIKE', '%' . $search . '%')
                         ->orWhere('menus.description', 'LIKE', '%' . $search . '%')
                         ->orWhere('menus.price', 'LIKE', '%' . $search . '%')
                         ->orWhere('menus.menu_type', 'LIKE', '%' . $search . '%')
                         ->orWhere('menus.discount_type', 'LIKE', '%' . $search . '%')
                         ->get();
                         
   
        return $result;

   
                        
    }

    // Menu By Category
    public function getMenuByCategory($id)
    {
        return Menu::where('category_id', $id)->get();
    }

    // Popular Foods
    public function getPopularFoods($id)
    {
        $orderId  = Order::where('restaurant_id', $id)->pluck('id');
        $subQuery = OrderItem::whereIn('order_id', $orderId)
                    ->select('menu_id', DB::raw('count(*) as total'))->orderBy('total', 'DESC')
                    ->take(4)->groupBy('menu_id');
                    
        $query   = Menu::rightJoinSub($subQuery, 'total_count', function($join){
                    $join->on('menus.id', '=' ,'total_count.menu_id');
                })->where('status', 'active')->orderBy('total_count.total', 'DESC')->get(['menus.*', 'total_count.total']);
        
       
       return $query;
    }
}
