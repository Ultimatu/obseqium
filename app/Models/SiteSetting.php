<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $primaryKey = 'key';

    protected $keyType = 'string';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = ['key', 'value', 'group'];

    public static function getAllCached(): Collection
    {
        $cached = Cache::get('site_settings');

        if (! $cached instanceof Collection) {
            Cache::forget('site_settings');
            $cached = static::all()->pluck('value', 'key');
            Cache::forever('site_settings', $cached);
        }

        return $cached;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return static::getAllCached()->get($key, $default);
    }

    public static function set(string $key, mixed $value, string $group = 'general'): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value, 'group' => $group]);
        Cache::forget('site_settings');
    }

    public static function setMany(array $data): void
    {
        foreach ($data as $key => $value) {
            static::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        Cache::forget('site_settings');
    }
}
