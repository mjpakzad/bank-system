<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'card_type',
        'card_number',
    ];

    public function account() :BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function transactionFrom(): HasMany
    {
        return $this->hasMany(Transaction::class, 'from_card_id');
    }

    public function transactionTo(): HasMany
    {
        return $this->hasMany(Transaction::class, 'to_card_id');
    }
}
