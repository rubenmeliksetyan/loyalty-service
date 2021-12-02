<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoyaltyPointsTransaction extends Model
{
    protected $table = 'loyalty_points_transaction';

    protected $fillable = [
        'account_id',
        'points_rule',
        'points_amount',
        'description',
        'payment_id',
        'payment_amount',
        'payment_time',
    ];

    public function scopeNotCanceled(Builder $builder): Builder
    {
        return $builder->where('canceled', 0);
    }

    public static function performPaymentLoyaltyPoints($account_id, $points_rule, $description, $payment_id, $payment_amount, $payment_time)
    {
        $points_amount = 0;

        if ($pointsRule = LoyaltyPointsRule::where('points_rule', '=', $points_rule)->first()) {
            $points_amount = match ($pointsRule->accrual_type) {
                LoyaltyPointsRule::ACCRUAL_TYPE_RELATIVE_RATE => ($payment_amount / 100) * $pointsRule->accrual_value,
                LoyaltyPointsRule::ACCRUAL_TYPE_ABSOLUTE_POINTS_AMOUNT => $pointsRule->accrual_value
            };
        }

        return LoyaltyPointsTransaction::create([
            'account_id' => $account_id,
            'points_rule' => $pointsRule?->id,
            'points_amount' => $points_amount,
            'description' => $description,
            'payment_id' => $payment_id,
            'payment_amount' => $payment_amount,
            'payment_time' => $payment_time,
        ]);
    }

    public static function withdrawLoyaltyPoints($account_id, $points_amount, $description) {
        return LoyaltyPointsTransaction::create([
            'account_id' => $account_id,
            'points_rule' => 'withdraw',
            'points_amount' => -$points_amount,
            'description' => $description,
        ]);
    }

    public function loyaltyAccount(): BelongsTo
    {
        return $this->belongsTo(LoyaltyAccount::class);
    }
}
