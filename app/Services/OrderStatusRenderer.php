<?php

namespace App\Services;


use App\OrderStatus;

class OrderStatusRenderer
{
    /**
     * Get the HTML representation of the order status with color and icon
     *
     * @param OrderStatus $status
     * @param bool $showText
     * @return string
     */
    public function render(OrderStatus $status, bool $showText = true): string
    {
        $config = $this->getStatusConfig($status);

        $html = '<span class="' . $config['class'] . '">';
        $html .= '<i class="' . $config['icon'] . '"></i>';

        if ($showText) {
            $html .= ' <span>' . $config['text'] . '</span>';
        }

        $html .= '</span>';

        return $html;
    }

    /**
     * Get status as badge
     *
     * @param OrderStatus $status
     * @return string
     */
    public function badge(OrderStatus $status): string
    {
        $config = $this->getStatusConfig($status);

        return '<span class="badge ' . $config['badgeClass'] . '">
                <i class="' . $config['icon'] . ' me-1"></i>
                ' . $config['text'] . '
            </span>';
    }

    public function icon(OrderStatus $status): string
    {
        $config = $this->getStatusConfig($status);

        return '<i class="' . $config['icon'] . ' ' . $config['textColorClass'] . '"></i>';
    }

    /**
     * Get dot indicator with status color
     *
     * @param OrderStatus $status
     * @return string
     */
    public function dot(OrderStatus $status): string
    {
        $config = $this->getStatusConfig($status);

        return '<span class="status-dot ' . $config['bgColorClass'] . '"
                style="display: inline-block; width: 10px; height: 10px; border-radius: 50%;"></span>';
    }

    private function getStatusConfig(OrderStatus $status): array
    {
        return match ($status) {
            OrderStatus::Pending => [
                'text' => 'Pending',
                'icon' => 'uil uil-clock',
                'class' => 'text-warning',
                'textColorClass' => 'text-warning',
                'bgColorClass' => 'bg-warning',
                'badgeClass' => 'bg-warning text-dark',
            ],
            OrderStatus::Processing => [
                'text' => 'Processing',
                'icon' => 'uil uil-process',
                'class' => 'text-info',
                'textColorClass' => 'text-info',
                'bgColorClass' => 'bg-info',
                'badgeClass' => 'bg-info',
            ],
            OrderStatus::Shipped => [
                'text' => 'Shipped',
                'icon' => 'uil uil-truck',
                'class' => 'text-primary',
                'textColorClass' => 'text-primary',
                'bgColorClass' => 'bg-primary',
                'badgeClass' => 'bg-primary',
            ],
            OrderStatus::Delivered => [
                'text' => 'Delivered',
                'icon' => 'uil uil-check-circle',
                'class' => 'text-success',
                'textColorClass' => 'text-success',
                'bgColorClass' => 'bg-success',
                'badgeClass' => 'bg-success',
            ],
            OrderStatus::Cancelled => [
                'text' => 'Cancelled',
                'icon' => 'uil uil-times-circle',
                'class' => 'text-danger',
                'textColorClass' => 'text-danger',
                'bgColorClass' => 'bg-danger',
                'badgeClass' => 'bg-danger',
            ],
        };
    }
}
