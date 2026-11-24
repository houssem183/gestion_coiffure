<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalonSetting extends Model
{
    protected $table = 'salon_settings';

    protected $fillable = [
        // Profil & Coordonnées
        'salon_name', 'slogan', 'description', 'telephone', 'telephone2',
        'email', 'adresse', 'ville', 'code_postal',
        // Horaires
        'horaire_lun_ven', 'horaire_samedi', 'horaire_dimanche', 'ferme_dimanche',
        // Réservations
        'duree_min_rdv', 'delai_annulation_h', 'nb_fauteuils',
        'inscription_ouverte', 'rdv_en_ligne', 'max_rdv_par_jour',
        // Finance
        'devise', 'tva', 'prefixe_facture', 'tva_applicable',
        // Fidélité
        'programme_fidelite', 'points_par_visite', 'points_pour_reduction', 'valeur_point',
        // Notifications
        'notif_sms', 'notif_email', 'rappel_rdv_h', 'sms_expediteur',
        // Réseaux Sociaux
        'facebook', 'instagram', 'google_maps',
        // Sécurité
        'mode_maintenance', 'message_maintenance',
    ];

    protected $casts = [
        'ferme_dimanche'      => 'boolean',
        'inscription_ouverte' => 'boolean',
        'rdv_en_ligne'        => 'boolean',
        'tva_applicable'      => 'boolean',
        'programme_fidelite'  => 'boolean',
        'notif_sms'           => 'boolean',
        'notif_email'         => 'boolean',
        'mode_maintenance'    => 'boolean',
        'tva'                 => 'decimal:2',
        'valeur_point'        => 'decimal:3',
    ];

    /**
     * Récupère les paramètres du salon (singleton — toujours la ligne 1).
     */
    public static function current(): self
    {
        return self::firstOrCreate(
            ['id' => 1],
            ['salon_name' => 'SalonTime • Les Berges du Lac']
        );
    }
}
