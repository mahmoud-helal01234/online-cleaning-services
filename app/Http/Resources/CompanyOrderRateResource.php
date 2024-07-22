<?php

namespace App\Http\Resources;

use App\Http\Traits\ImagesTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyOrderRateResource extends JsonResource
{
    use ImagesTrait;

    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "company_id" => $this->company_id,
            "category_id" => $this->category_id,
            "name_ar" => $this->company->name_ar,
            "name_en" => $this->company->name_en,
            "cover_path" => $this->company->cover_path,
            "logo_path" => $this->company->logo_path,
            "rate_count" => $this->ordersWithRate($this->company)->count(),
            "avrage_rate" => $this->averageRate($this->ordersWithRate($this->company)),
            "created_at" => $this->created_at,
            'categories' => $this->company->categories->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name_ar' => $category->name_ar,
                    'name_en' => $category->name_en,
                    'img_path' => $category->img_path,
                ];
            }),
        ];
    }
    private function ordersWithRate($company)
    {
        $orders = $company->clientOrders()->has('rate')->get();
        return $orders;

    }
    private function averageRate($orders)
    {
        $orderCount = $orders->count();
        $totalValue = 0;

        foreach ($orders as $order) {
            foreach ($order->rate as $rate) {
                $totalValue += $rate->value;
            }
            //$totalValue += $order->rate->value;
        }
        return $orderCount > 0 ? $totalValue / $orderCount : 0;
    }
}
