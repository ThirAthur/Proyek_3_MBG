<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Report extends Model
{
    protected $fillable = ['user_id','reporter_name','student_name','school_id','sppg_id','incident_date','evidence','status'];
    protected function casts(): array { return ['incident_date' => 'date']; }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function school(): BelongsTo { return $this->belongsTo(School::class); }
    public function sppg(): BelongsTo { return $this->belongsTo(Sppg::class); }
}
