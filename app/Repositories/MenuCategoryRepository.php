<?php

namespace App\Repositories;

use App\Models\Media;
use Illuminate\Support\Str;
use App\Traits\UploaderTrait;
use App\Models\MenuCategory;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Storage;



/**
 * Class MenuCategoryRepository
 * @package App\Repositories
 * @version November 6, 2018, 9:09 am UTC
 *
 * @method MenuCategoryRepository findWithoutFail($id, $columns = ['*'])
 * @method MenuCategoryRepository find($id, $columns = ['*'])
 * @method MenuCategoryRepository first($columns = ['*'])
 */
class MenuCategoryRepository extends BaseRepository
{
    use UploaderTrait;
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'slug',
        'description',
        'status',
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
        return MenuCategory::class;
    }

    
    /**
     * Create a  Menu Category
     *
     * @param Request $request
     *
     * @return MenuCategory
     */
    public function createMenuCategory($request)
    {
        $request['slug'] = Str::slug($request->name);
        $input = collect($request->all());
        $serviceCategory = MenuCategory::create($input->only($request->fillable('menu_categories'))->all());

        if($request->has('file')){
            $this->uploadFile($request, $serviceCategory);
        }
        return $serviceCategory;
    }

    /**
     * Update the Menu Category
     *
     * @param Request $request
     *
     * @return MenuCategory
     */
    
    public function updateMenuCategory($id, $request)
    {
        $serviceCategory = MenuCategory::findOrFail($id);
        $request['slug'] = $request->has('name') ? Str::slug($request->name) : $serviceCategory->slug;
        $input = collect($request->all());
        $serviceCategory->update($input->only($request->fillable('menu_categories'))->all());
        $image = Media::where('table_id', $serviceCategory->id)->where('table_name', 'menu_categories')->first();
        
        // Upload File
        if($request->has('file')){
            if (!empty($image)) { // Delete Existing.
				Storage::disk('public')->delete($image->path);
				$image->delete();
			}
            $this->uploadFile($request, $serviceCategory);
        }
        return $serviceCategory;
    }

    // File upload.
	public function uploadFile($request, $serviceCategory)
	{
		if ($request->has('file')) {
			if($request->input('file')){
				$media                = $this->base64FileUpload($request->input('file'), 'menu_categories');
				$input['name']        = $media['name'];
				$input['path']        = $media['path'];
				$input['table_id']    = $serviceCategory->id;
				$input['table_name']  = "menu_categories";
				$input['type']        = \File::extension($this->getFile($media['path']));
				$media                = Media::create($input);
		}
	  }
	}
}
