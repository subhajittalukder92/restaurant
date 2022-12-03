<?php

namespace App\Repositories;

use App\Models\Media;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class MediaRepository
 * @package App\Repositories
 * @version June 11, 2020, 9:08 am UTC
*/

class MediaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'name',
        'path',
        'type',
        'table_name',
        'table_id',
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
        return Media::class;
    }
}
