<?php

namespace App\Repositories;

use App\Models\Buku;
use InfyOm\Generator\Common\BaseRepository;

class BukuRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'judul',
        'deskripsi',
        'isi'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Buku::class;
    }
}
