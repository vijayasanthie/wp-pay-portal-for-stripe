<?php

namespace Stripe;

/**
 * Class UsageRecord
 *
 * @package Stripe
 *
 * @property string $id
 * @property string $object
 * @property string $invoice
 * @property bool $livemode
 * @property mixed $period
 * @property string $subscription_item
 * @property int $total_usage
 */
class UsageRecordSummary extends ApiResource
{
    const OBJECT_NAME = "usage_record_summary";

    use ApiOperations\All;
    // use ApiOperations\Create;
    // use ApiOperations\Delete {
    //     delete as protected _delete;
    // }
    // use ApiOperations\Retrieve;
    // use ApiOperations\Update;
    
}
