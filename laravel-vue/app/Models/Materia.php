<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Materia extends Model
{
    protected $table = 'materias'; // Define o nome da tabela manualmente se necessário

    protected $fillable = [
        'writer_id',
        'titulo',
        'slug',
        'conteudo',
        'capa',
        'categoria',
        'status'
    ];

    // Relacionamento: Uma matéria pertence a um escritor
    public function autor(): BelongsTo
    {
        return $this->belongsTo(Writer::class, 'writer_id');
    }
}