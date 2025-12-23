<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employe extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'poste',
        'salaire',
        'date_embauche',
        'departement_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_embauche' => 'date',
        'salaire' => 'decimal:2',
    ];

    /**
     * Get the department that owns the employee.
     */
    public function departement(): BelongsTo
    {
        return $this->belongsTo(Departement::class);
    }
}
