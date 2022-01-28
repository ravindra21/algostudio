<aside class="border-end bg-white vh-100 position-fixed" style="min-width: 250px;">
    <div class="sidebar-heading border-bottom bg-light">Sistem Penjualan</div>
    <div class="list-group list-group-flush">
        <a 
        class="list-group-item list-group-item-action list-group-item-light p-3 {{\Route::current()->getName() == 'view.dashboard' ? 'active' : '' }}" 
        href="{{\Route::current()->getName() == 'view.dashboard' ?  '#' : route('view.dashboard') }}">
            Dashboard
        </a>
        <a 
        class="list-group-item list-group-item-action list-group-item-light p-3 {{\Route::current()->getName() == 'view.penjualan' ? 'active' : '' }}"
        href="{{\Route::current()->getName() == 'view.penjualan' ? '#' : route('view.penjualan') }}">
            Penjualan
        </a>
    </div>
</aside>