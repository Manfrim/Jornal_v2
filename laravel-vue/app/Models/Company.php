<?php
// app/Models/Company.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Company extends Model
{
    protected $fillable = ['writer_id', 'name', 'logo_path', 'is_active', 'order'];

    // Relacionamento com o escritor
    public function writer()
    {
        return $this->belongsTo(Writer::class, 'writer_id');
    }

    // Accessor para pegar a URL pronta no Blade -> $company->logo_url
    public function getLogoUrlAttribute()
    {
        return Storage::url($this->logo_path);
    }
}