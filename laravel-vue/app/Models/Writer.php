<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany; // Importante para o relacionamento

class Writer extends Authenticatable
{
    use HasFactory, Notifiable;

    // Tabela personalizada
    protected $table = 'escritores';

    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'bio', 
        'avatar', 
        'role'
    ];

    protected $hidden = [
        'password', 
        'remember_token',
    ];

    /**
     * Relacionamento: Um escritor possui muitas matérias.
     */
    public function materias(): HasMany
    {
        // O segundo parâmetro 'writer_id' é a chave estrangeira na tabela 'materias'
        return $this->hasMany(Materia::class, 'writer_id');
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}