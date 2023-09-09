<?php

namespace Moawiaab\LaravelTheme\Models;

use App\Models\User;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Moawiaab\LaravelTheme\Support\HasAdvancedFilter;

class FinancialClient extends Model
{
    use HasFactory;
    use HasAdvancedFilter;
    use SoftDeletes;

    public const TYPE_SELECT = [
        ['value' => '1', 'label' => 'نقداً'],
        ['value' => '2', 'label' => 'بنكك'],
        ['value' => '3', 'label' => 'بطاقة صراف'],
        ['value' => '4', 'label' => 'مبلغ فاتورة'],
        ['value' => '5', 'label' => 'شيك'],
        ['value' => '6', 'label' => 'اخرى'],
    ];

    public const STATUS_RADIO = [
        ['value' => '0',  'label' => 'اضافة مبلغ الى العميل'],
        ['value' => '1',  'label' => 'خصم مبلغ الى العميل'],
    ];

    public $table = 'financial_clients';

    public $orderable = [
        'id',
        'amount',
        'take',
        'export',
        'details',
        'user.name',
        'created_at'
    ];

    public $filterable = [
        'id',
        'amount',
        'take',
        'export',
        'details',
        'type',
        'user.name'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'amount',
        'take',
        'export',
        'details',
        'type',
        'status',
        'payment',
    ];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }

    public function getTypeLabelAttribute()
    {
        return collect(static::TYPE_SELECT)->firstWhere('value', $this->type)['label'] ?? '';
    }

    public function scopeClient($query, $id)
    {
        return $query->where('client_id', $id)->paginate(request('limit', 10));
    }

    public function getStatusLabelAttribute($value)
    {
        return static::STATUS_RADIO[$this->status] ?? null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
