<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Sppg extends Model
{
    protected $fillable = ['name','code','address'];
    public function schools(): BelongsToMany { return $this->belongsToMany(School::class)->withTimestamps(); }
    public function reports(): HasMany { return $this->hasMany(Report::class); }
}
