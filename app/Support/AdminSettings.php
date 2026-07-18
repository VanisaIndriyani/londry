<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class AdminSettings
{
    private const FILE = 'admin-settings.json';

    public static function defaults(): array
    {
        return [
            'laundry_name' => 'FreshPress Laundry',
            'address' => 'Samarinda, Kalimantan Timur',
            'whatsapp' => '+62 812 3456 7890',
            'operational_hours' => '08.00 - 21.00',
            'email' => 'hello@freshpress.id',
            'instagram' => '@freshpresslaundry',
            'facebook' => 'FreshPress Laundry',
            'logo' => null,
        ];
    }

    public static function all(): array
    {
        if (!Storage::disk('local')->exists(self::FILE)) {
            return self::defaults();
        }

        $stored = json_decode(Storage::disk('local')->get(self::FILE), true) ?: [];

        return array_merge(self::defaults(), $stored);
    }

    public static function store(array $settings): void
    {
        Storage::disk('local')->put(self::FILE, json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public static function logoUrl(?string $logo): ?string
    {
        if (!$logo) {
            return null;
        }

        return asset('storage/' . ltrim($logo, '/'));
    }

    public static function waMeNumber(?string $whatsapp): string
    {
        $number = preg_replace('/\D+/', '', (string) $whatsapp);

        if ($number === '') {
            return '6281234567890';
        }

        if (str_starts_with($number, '0')) {
            return '62' . substr($number, 1);
        }

        if (!str_starts_with($number, '62')) {
            return '62' . ltrim($number, '0');
        }

        return $number;
    }
}
