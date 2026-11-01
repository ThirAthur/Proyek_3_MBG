<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
class School extends Model
{
    protected $fillable = ['name','address'];
    public function sppgs(): BelongsToMany { return $this->belongsToMany(Sppg::class)->withTimestamps(); }
    public function reports(): HasMany { return $this->hasMany(Report::class); }
}
