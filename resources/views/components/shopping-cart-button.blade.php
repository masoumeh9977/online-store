<button type="button" class="btn btn-icon btn-soft-primary position-relative me-2" aria-haspopup="true"
        aria-expanded="false">
    <i class="uil uil-shopping-cart align-middle icons"></i>
    @if($cartItemCount)
        <span class="position-absolute top-0 start-100
                translate-middle badge rounded-pill bg-danger">
            {{$cartItemCount}}
        <span class="visually-hidden">items in cart</span>
    </span>
    @endif
</button>
