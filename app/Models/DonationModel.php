<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['id_donation', 'amount', 'status', 'created_at', 'user_id'])]
class DonationModel extends Model
{
    protected $table = 'tb_donations';
    protected $primaryKey = 'id_donation';
    public $incrementing = false;
    public $timestamps = false;
}
