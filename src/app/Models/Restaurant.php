<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'detail',
        'img_url',
        'genre_id',
        'area_id',
        'manager_id',
    ];

    public function favoredBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function area()
    {
        return $this->belongsTo('App\Models\Area');
    }

    public function genre()
    {
        return $this->belongsTo('App\Models\Genre');
    }

    public function scopeAreaSearch($query, $areaId)
    {
        if (!empty($areaId)) {
            return $query->where('area_id', $areaId);
        }
        return $query;
    }

    public function scopeGenreSearch($query, $genreId)
    {
        if (!empty($genreId)) {
            return $query->where('genre_id', $genreId);
        }
        return $query;
    }

    public function scopeKeywordSearch($query, $keyword)
    {
        if (!empty($keyword)) {
            return $query->where('name', 'LIKE', '%' . $keyword . '%');
        }
        return $query;
    }

    public function bookings()
    {
        return $this->hasMany(Restaurant::class);
    }
}
