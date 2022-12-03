<?php

namespace App\Repositories;

use App\Models\Media;
use App\Models\Reward;
use Illuminate\Support\Str;
use App\Traits\UploaderTrait;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Storage;

/**
 * Class RewardRepository
 * @package App\Repositories
 * @version November 6, 2018, 9:09 am UTC
 *
 * @method RewardRepository findWithoutFail($id, $columns = ['*'])
 * @method RewardRepository find($id, $columns = ['*'])
 * @method RewardRepository first($columns = ['*'])
 */
class RewardRepository extends BaseRepository
{
    use UploaderTrait;
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'amount',
        'coins',
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
        return Reward::class;
    }

    /**
     * Create a  Reward
     *
     * @param Request $request
     *
     * @return Reward
     */
    public function createReward($request)
    { 
        $input = collect($request->all());
        $service = Reward::create($input->only($request->fillable('rewards'))->all());

        if($request->has('file')){
            $this->uploadFile($request, $service);
        }
        return $service;
    }

    /**
     * Update the Reward
     *
     * @param Request $request
     *
     * @return Reward
     */
    
    public function updateReward($id, $request)
    {
       $service = Reward::findOrFail($id);
       
       $input = collect($request->all());
       $service->update($input->only($request->fillable('rewards'))->all());
       $image = Media::where('table_id',$service->id)->where('table_name', 'rewards')->first();
        
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
				$media                = $this->base64FileUpload($request->input('file'), 'rewards');
				$input['name']        = $media['name'];
				$input['path']        = $media['path'];
				$input['table_id']    = $service->id;
				$input['table_name']  = "rewards";
				$input['type']        = \File::extension($this->getFile($media['path']));
				$media                = Media::create($input);
		}
	  }
	}

    // Search Reward
    public function searchReward($search, $position)
    {
        $result = Reward::where('amount', 'LIKE', '%' . $search . '%')
        ->orWhere('coin', 'LIKE', '%' . $search . '%')
        ->get();
        
        return $result;
    }
}
