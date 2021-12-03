<?php

namespace App\Models;

use App\Mail\AccountActivated;
use App\Mail\AccountDeactivated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LoyaltyAccount extends Model
{
    protected $table = 'loyalty_account';

    protected $fillable = [
        'phone',
        'card',
        'email',
        'email_notification',
        'phone_notification',
        'active',
    ];

    const ALLOWED_TYPES = [
        'email', 'phone', 'card'
    ];

    public function loyaltyPointsTransactions(): HasMany
    {
        return $this->hasMany(LoyaltyPointsTransaction::class, 'account_id');
    }

    public function notCanceledLoyaltyPointTransactions(): HasMany {
        return $this->loyaltyPointsTransactions()->notCanceled();
    }
}
