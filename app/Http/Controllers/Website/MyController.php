<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Facades\OrderStatusHelper;
use App\Services\Repositories\ModelRepositories\OrderRepository;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class MyController extends Controller
{
    public function __construct(protected OrderRepository $orderRepository)
    {
    }

    public function profile()
    {
        $user = Auth::user();
        return view('website.my.profile', compact('user'));
    }

    public function orders()
    {
        return view('website.my.order');
    }

    public function getOrdersListAjax()
    {
        $userId = Auth::user()->id;
        $query = $this->orderRepository->getByUserIdQuery($userId);
        return DataTables::of($query)
            ->editColumn('status', function (Order $order) {
                return OrderStatusHelper::badge($order->status);
            })
            ->addColumn('amount', function (Order $order) {
                $originalAmount = $order->total_amount + $order->discount_amount;
                $html = '<div class="price-container">';

                if ($order->discount_amount > 0) {
                    $html .= '<div class="original-price text-muted text-decoration-line-through">$' . number_format($originalAmount, 2) . '</div>';
                    $html .= '<div class="final-price fw-bold text-success">$' . number_format($order->total_amount, 2) . '</div>';
                    $html .= '<small class="savings text-success">You saved $' . number_format($order->discount_amount, 2) . '</small>';
                } else {
                    $html .= '<div class="final-price fw-bold text-dark">$' . number_format($order->total_amount, 2) . '</div>';
                }

                $html .= '</div>';
                return $html;
            })
            ->editColumn('created_at', function (Order $order) {
                return '<div class="date-container">
                    <div class="order-date fw-medium">' . $order->created_at->format('M d, Y') . '</div>
                    <small class="text-muted">' . $order->created_at->format('h:i A') . '</small>
                    <small class="text-muted d-block">' . $order->created_at->diffForHumans() . '</small>
                </div>';
            })
            ->editColumn('tracking_code', function (Order $order) {
                return '<div class="tracking-container">
                        <div class="tracking-code">
                            <i class="fas fa-shipping-fast text-primary me-2"></i>
                            <code class="tracking-number">' . $order->tracking_code . '</code>
                        </div>
                    </div>';
            })
            ->addColumn('actions', function (Order $order){
                $buttons = '<div class="action-buttons">';

                $buttons .= '<button type="button" class="btn btn-outline-primary btn-sm view-order" data-id="' . $order->id . '">
                    <i class="fas fa-eye me-1"></i> View Details
                </button>';

                $buttons .= '</div>';
                return $buttons;
            })
            ->rawColumns(['status', 'amount', 'tracking_code', 'created_at', 'actions'])
            ->make(true);
    }
}
