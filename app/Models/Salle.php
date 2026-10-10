<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Salle extends Model
    {
    protected $fillable = [
        'code',
        'nom',
        'batiment',
        'etage',
        'capacite',
        'type',
        'statut',
        'description',
    ];

    protected static function booted(): void
    {
        static::created(function (Salle $salle) {
            if (empty($salle->code)) {
                $salle->code = 'SAL-' .
                str_pad(
                    (string) $salle->id,
                    4,
                    '0',
                    STR_PAD_LEFT
                );

                $salle->saveQuietly();
            }
        });
    }
}