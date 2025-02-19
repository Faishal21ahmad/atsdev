<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FileMainten extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'maintenance_id',
        'nameFile',
        'type',
    ];

    // Relasi ke Maintenance
    public function maintenances()
    {
        return $this->belongsTo(Maintenance::class);
    }

    public static function getFileByIdMainten($id){
        return self::where('maintenance_id', $id)
        ->whereNull('deleted_at')
        ->get();
    }

    public static function getFileProblem($idMainten){
        return self::where('maintenance_id', $idMainten)
        ->where('type', 1)
        ->get();
    }
    public static function getFileRepaire($idMainten){
        return self::where('maintenance_id', $idMainten)
        ->where('type', 2)
        ->get();
    }
}
