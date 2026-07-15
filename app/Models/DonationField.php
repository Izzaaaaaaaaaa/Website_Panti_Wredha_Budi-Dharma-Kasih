<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationField extends Model
{
    protected $fillable = [
        'name',
        'label',
        'type',
        'options',
        'is_required',
        'form_type',
        'order'
    ];
