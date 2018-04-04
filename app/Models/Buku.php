<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Buku
 * @package App\Models
 * @version April 3, 2018, 9:05 am UTC
 */
class Buku extends Model
{
    use SoftDeletes;

    public $table = 'bukus';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'judul',
        'deskripsi',
        'isi'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'judul' => 'string',
        'deskripsi' => 'string',
        'isi' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
