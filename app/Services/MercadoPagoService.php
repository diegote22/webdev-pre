<?php

namespace App\Services;

use MercadoPago\SDK;
use MercadoPago\Item;
use MercadoPago\Preference;

class MercadoPagoService
{
    public function __construct()
    {
        SDK::setAccessToken(config('mercadopago.access_token'));
    }

    /**
     * Crea una preferencia de pago para un curso.
     * @param array $courseData ['id'=>int,'title'=>string,'price'=>float]
     * @param array $options ['back_urls'=>[success, failure, pending], 'auto_return'=>'approved']
     */
    public function createCoursePreference(array $courseData, array $options = []): Preference
    {
        $item = new Item();
        $item->id = 'course-' . $courseData['id'];
        $item->title = $courseData['title'];
        $item->quantity = 1;
        $item->currency_id = 'ARS'; // Ajustar según necesidad
        $item->unit_price = (float) $courseData['price'];

        $preference = new Preference();
        $preference->items = [$item];
        if (!empty($options['back_urls'])) {
            $preference->back_urls = $options['back_urls'];
        }
        $preference->auto_return = $options['auto_return'] ?? 'approved';
        $preference->statement_descriptor = 'WebDev Cursos';
        $preference->external_reference = 'course-' . $courseData['id'];
        $preference->save();
        return $preference;
    }
}
