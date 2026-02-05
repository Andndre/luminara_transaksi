<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvitationPage extends Model
{
    protected $fillable = [
        'template_id',
        'title',
        'slug',
        'groom_name',
        'bride_name',
        'event_date',
        'published_status',
        'meta_data',
        'created_by'
    ];

    protected $casts = [
        'meta_data' => 'array',
        'event_date' => 'datetime'
    ];

    public function template()
    {
        return $this->belongsTo(InvitationTemplate::class);
    }

    public function sections()
    {
        return $this->hasMany(InvitationSection::class)->orderBy('order_index');
    }

    public function assets()
    {
        return $this->hasMany(InvitationAsset::class);
    }

    public function rsvpResponses()
    {
        return $this->hasMany(InvitationRsvpResponse::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
