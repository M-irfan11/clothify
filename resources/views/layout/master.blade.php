
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
  <title>Clothify | Dashboard</title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('assets/css/material-dashboard.css?v=3.2.0') }}" rel="stylesheet" />
  @vite('resources/css/sidebar.css')
  @yield('head')
</head>

<body class="g-sidenav-show bg-white-100">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand px-4 py-3 m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard " target="_blank">
        <img src="{{ asset('assets/img/logo-ct-dark.png') }}" class="navbar-brand-img" width="26" height="26" alt="main_logo">
        <span class="ms-1 text-sm text-dark">FebricFlow</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse !visible w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link group relative rounded-xl transition-all duration-200 before:absolute before:inset-y-0 before:left-0 before:z-10 before:my-auto before:h-6 before:w-1 before:rounded-r before:bg-orange-500 before:content-[''] before:transition-opacity focus-visible:before:opacity-100 focus-visible:!bg-[#a36ec7] focus-visible:!text-white {{ request()->routeIs('home') ? 'before:opacity-100 !bg-[#a36ec7] !text-white shadow-md shadow-purple-200' : 'before:opacity-0 hover:before:opacity-100 !text-slate-600 hover:!bg-[#a36ec7] hover:!text-white' }}" href="{{ route('home') }}">
            <i class="material-symbols-rounded opacity-5 {{ request()->routeIs('home') ? '!opacity-100 !text-white' : 'group-hover:!opacity-100 group-hover:!text-white' }}">dashboard</i>
            <span class="nav-link-text ms-1 {{ request()->routeIs('home') ? '!text-white' : 'group-hover:!text-white' }}">Dashboard</span>
          </a>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">Dashboard</a>
        </li> --}}

        {{-- @role('admin') --}}
        @hasrole('admin')
        <li class="nav-item">
            <a class="nav-link group relative rounded-xl transition-all duration-200 before:absolute before:inset-y-0 before:left-0 before:z-10 before:my-auto before:h-6 before:w-1 before:rounded-r before:bg-orange-500 before:content-[''] before:transition-opacity focus-visible:before:opacity-100 focus-visible:!bg-[#a36ec7] focus-visible:!text-white {{ request()->routeIs('users.*') ? 'before:opacity-100 !bg-[#a36ec7] !text-white shadow-md shadow-purple-200' : 'before:opacity-0 hover:before:opacity-100 !text-slate-600 hover:!bg-[#a36ec7] hover:!text-white' }}" href="{{ route('users.index') }}">
              <i class="material-symbols-rounded opacity-5 {{ request()->routeIs('users.*') ? '!opacity-100 !text-white' : 'group-hover:!opacity-100 group-hover:!text-white' }}">group</i>
              <span class="nav-link-text ms-1 {{ request()->routeIs('users.*') ? '!text-white' : 'group-hover:!text-white' }}">Manage Users</span>
            </a>
        </li>
        @endhasrole
        {{-- @endrole --}}

        @hasanyrole(['admin', 'editor'])
        <li class="nav-item">
            <a class="nav-link group relative rounded-xl transition-all duration-200 before:absolute before:inset-y-0 before:left-0 before:z-10 before:my-auto before:h-6 before:w-1 before:rounded-r before:bg-orange-500 before:content-[''] before:transition-opacity focus-visible:before:opacity-100 focus-visible:!bg-[#a36ec7] focus-visible:!text-white {{ request()->routeIs('warehouses.*') ? 'before:opacity-100 !bg-[#a36ec7] !text-white shadow-md shadow-purple-200' : 'before:opacity-0 hover:before:opacity-100 !text-slate-600 hover:!bg-[#a36ec7] hover:!text-white' }}" href="{{ route('warehouses.index') }}">
              <i class="material-symbols-rounded opacity-5 {{ request()->routeIs('warehouses.*') ? '!opacity-100 !text-white' : 'group-hover:!opacity-100 group-hover:!text-white' }}">warehouse</i>
              <span class="nav-link-text ms-1 {{ request()->routeIs('warehouses.*') ? '!text-white' : 'group-hover:!text-white' }}">Warehouses</span>
            </a>
        </li>
        @endhasanyrole

        @auth
        <li class="nav-item">
            <a class="nav-link group relative rounded-xl transition-all duration-200 before:absolute before:inset-y-0 before:left-0 before:z-10 before:my-auto before:h-6 before:w-1 before:rounded-r before:bg-orange-500 before:content-[''] before:transition-opacity focus-visible:before:opacity-100 focus-visible:!bg-[#a36ec7] focus-visible:!text-white {{ request()->routeIs('suppliers.*') ? 'before:opacity-100 !bg-[#a36ec7] !text-white shadow-md shadow-purple-200' : 'before:opacity-0 hover:before:opacity-100 !text-slate-600 hover:!bg-[#a36ec7] hover:!text-white' }}" href="{{ route('suppliers.index') }}">
              <i class="material-symbols-rounded opacity-5 {{ request()->routeIs('suppliers.*') ? '!opacity-100 !text-white' : 'group-hover:!opacity-100 group-hover:!text-white' }}">local_shipping</i>
              <span class="nav-link-text ms-1 {{ request()->routeIs('suppliers.*') ? '!text-white' : 'group-hover:!text-white' }}">Suppliers</span>
            </a>
        </li>
        @endauth

       @auth
        <li class="nav-item">
            <a class="nav-link group relative rounded-xl transition-all duration-200 before:absolute before:inset-y-0 before:left-0 before:z-10 before:my-auto before:h-6 before:w-1 before:rounded-r before:bg-orange-500 before:content-[''] before:transition-opacity focus-visible:before:opacity-100 focus-visible:!bg-[#a36ec7] focus-visible:!text-white {{ request()->routeIs('materials.*') ? 'before:opacity-100 !bg-[#a36ec7] !text-white shadow-md shadow-purple-200' : 'before:opacity-0 hover:before:opacity-100 !text-slate-600 hover:!bg-[#a36ec7] hover:!text-white' }}" href="{{ route('materials.index') }}">
              <i class="material-symbols-rounded opacity-5 {{ request()->routeIs('materials.*') ? '!opacity-100 !text-white' : 'group-hover:!opacity-100 group-hover:!text-white' }}">category</i>
              <span class="nav-link-text ms-1 {{ request()->routeIs('materials.*') ? '!text-white' : 'group-hover:!text-white' }}">Materials</span>
            </a>
        </li>
        @endauth

        <li class="nav-item group/product">
          {{-- প্যারেন্ট: Products --}}
          <a class="nav-link group group/expanded relative rounded-xl transition-all duration-200 after:!hidden before:absolute before:inset-y-0 before:left-0 before:z-10 before:my-auto before:h-6 before:w-1 before:rounded-r before:bg-orange-500 before:content-[''] before:transition-opacity focus-visible:before:opacity-100 focus-visible:!bg-[#a36ec7] focus-visible:!text-white group-hover/product:before:opacity-100 group-hover/product:!bg-[#a36ec7] group-hover/product:!text-white {{ request()->routeIs('products.*', 'product_variants.*') ? 'before:opacity-100 !bg-[#a36ec7] !text-white shadow-md shadow-purple-200' : 'before:opacity-0 hover:before:opacity-100 !text-slate-600 hover:!bg-[#a36ec7] hover:!text-white' }}"
            data-bs-toggle="collapse"
            href="#productsSubmenu"
            aria-controls="productsSubmenu"
            aria-expanded="{{ request()->routeIs('products.*', 'product_variants.*') ? 'true' : 'false' }}">
              <i class="material-symbols-rounded opacity-5 {{ request()->routeIs('products.*', 'product_variants.*') ? '!opacity-100 !text-white' : 'group-hover/product:!opacity-100 group-hover/product:!text-white group-focus-visible:!opacity-100' }}">inventory_2</i>
              <span class="nav-link-text ms-1 {{ request()->routeIs('products.*', 'product_variants.*') ? '!text-white' : 'group-hover/product:!text-white group-focus-visible:!text-white' }}">Products</span>
              <span class="material-symbols-rounded ms-auto text-base transition-transform duration-200 group-aria-expanded/expanded:rotate-90" aria-hidden="true">chevron_right</span>
          </a>

          {{-- সাবমেনু --}}
          <div class="collapse !visible {{ request()->routeIs('products.*', 'product_variants.*') ? 'show' : '' }}" id="productsSubmenu">
              <ul class="nav flex-column ms-4 mt-1 border-start border-slate-200 ps-2">
                  <li class="nav-item group/submenu-item">
                      <a class="nav-link group relative rounded-lg transition-all duration-200 before:absolute before:inset-y-0 before:left-0 before:z-10 before:my-auto before:h-5 before:w-1 before:rounded-r before:bg-orange-500 before:content-[''] before:transition-opacity focus-visible:before:opacity-100 focus-visible:!bg-[#a36ec7] focus-visible:!text-white group-hover/submenu-item:before:opacity-100 group-hover/submenu-item:!bg-[#a36ec7] group-hover/submenu-item:!text-white !py-2 !text-sm {{ request()->routeIs('products.*') ? 'before:opacity-100 !bg-[#a36ec7] !text-white shadow-sm shadow-purple-200' : 'before:opacity-0 hover:before:opacity-100 !text-slate-600 hover:!bg-[#a36ec7] hover:!text-white' }}" href="{{ route('products.index') }}">
                          All Products
                      </a>
                  </li>
                  <li class="nav-item group/submenu-item">
                      <a class="nav-link group relative rounded-lg transition-all duration-200 before:absolute before:inset-y-0 before:left-0 before:z-10 before:my-auto before:h-5 before:w-1 before:rounded-r before:bg-orange-500 before:content-[''] before:transition-opacity focus-visible:before:opacity-100 focus-visible:!bg-[#a36ec7] focus-visible:!text-white group-hover/submenu-item:before:opacity-100 group-hover/submenu-item:!bg-[#a36ec7] group-hover/submenu-item:!text-white !py-2 !text-sm {{ request()->routeIs('product_variants.*') ? 'before:opacity-100 !bg-[#a36ec7] !text-white shadow-sm shadow-purple-200' : 'before:opacity-0 hover:before:opacity-100 !text-slate-600 hover:!bg-[#a36ec7] hover:!text-white' }}" href="{{ route('product_variants.index') }}">
                          Product Variants
                      </a>
                  </li>
              </ul>
          </div>
      </li>
      <li class="nav-item">
            <a class="nav-link group relative rounded-xl transition-all duration-200 before:absolute before:inset-y-0 before:left-0 before:z-10 before:my-auto before:h-6 before:w-1 before:rounded-r before:bg-orange-500 before:content-[''] before:transition-opacity focus-visible:before:opacity-100 focus-visible:!bg-[#a36ec7] focus-visible:!text-white {{ request()->routeIs('bom_items.*') ? 'before:opacity-100 !bg-[#a36ec7] !text-white shadow-md shadow-purple-200' : 'before:opacity-0 hover:before:opacity-100 !text-slate-600 hover:!bg-[#a36ec7] hover:!text-white' }}" href="{{ route('bom_items.index') }}">
              <i class="material-symbols-rounded opacity-5 {{ request()->routeIs('bom_items.*') ? '!opacity-100 !text-white' : 'group-hover:!opacity-100 group-hover:!text-white' }}">list_alt</i>
              <span class="nav-link-text ms-1 {{ request()->routeIs('bom_items.*') ? '!text-white' : 'group-hover:!text-white' }}">Bom Items</span>
            </a>
        </li>

        <li class="nav-item group/inventory">
          <a class="nav-link group group/expanded relative rounded-xl transition-all duration-200 after:!hidden before:absolute before:inset-y-0 before:left-0 before:z-10 before:my-auto before:h-6 before:w-1 before:rounded-r before:bg-orange-500 before:content-[''] before:transition-opacity focus-visible:before:opacity-100 focus-visible:!bg-[#a36ec7] focus-visible:!text-white group-hover/inventory:before:opacity-100 group-hover/inventory:!bg-[#a36ec7] group-hover/inventory:!text-white {{ request()->routeIs('inventoryStocks.*', 'stock_movements.*') ? 'before:opacity-100 !bg-[#a36ec7] !text-white shadow-md shadow-purple-200' : 'before:opacity-0 hover:before:opacity-100 !text-slate-600 hover:!bg-[#a36ec7] hover:!text-white' }}"
            data-bs-toggle="collapse"
            href="#inventorySubmenu"
            aria-controls="inventorySubmenu"
            aria-expanded="{{ request()->routeIs('inventoryStocks.*', 'stock_movements.*') ? 'true' : 'false' }}">
              <i class="material-symbols-rounded opacity-5 {{ request()->routeIs('inventoryStocks.*', 'stock_movements.*') ? '!opacity-100 !text-white' : 'group-hover/inventory:!opacity-100 group-hover/inventory:!text-white group-focus-visible:!opacity-100' }}">inventory</i>
              <span class="nav-link-text ms-1 {{ request()->routeIs('inventoryStocks.*', 'stock_movements.*') ? '!text-white' : 'group-hover/inventory:!text-white group-focus-visible:!text-white' }}">Inventory</span>
              <span class="material-symbols-rounded ms-auto text-base transition-transform duration-200 group-aria-expanded/expanded:rotate-90" aria-hidden="true">chevron_right</span>
          </a>

          <div class="collapse !visible {{ request()->routeIs('inventoryStocks.*', 'stock_movements.*') ? 'show' : '' }}" id="inventorySubmenu">
              <ul class="nav flex-column ms-4 mt-1 border-start border-slate-200 ps-2">
                  <li class="nav-item group/submenu-item">
                      <a class="nav-link group relative rounded-lg transition-all duration-200 before:absolute before:inset-y-0 before:left-0 before:z-10 before:my-auto before:h-5 before:w-1 before:rounded-r before:bg-orange-500 before:content-[''] before:transition-opacity focus-visible:before:opacity-100 focus-visible:!bg-[#a36ec7] focus-visible:!text-white group-hover/submenu-item:before:opacity-100 group-hover/submenu-item:!bg-[#a36ec7] group-hover/submenu-item:!text-white !py-2 !text-sm {{ request()->routeIs('inventoryStocks.*') ? 'before:opacity-100 !bg-[#a36ec7] !text-white shadow-sm shadow-purple-200' : 'before:opacity-0 hover:before:opacity-100 !text-slate-600 hover:!bg-[#a36ec7] hover:!text-white' }}" href="{{ route('inventory_stocks.index') }}">
                          Inventory Stocks
                      </a>
                  </li>
                  <li class="nav-item group/submenu-item">
                      <a class="nav-link group relative rounded-lg transition-all duration-200 before:absolute before:inset-y-0 before:left-0 before:z-10 before:my-auto before:h-5 before:w-1 before:rounded-r before:bg-orange-500 before:content-[''] before:transition-opacity focus-visible:before:opacity-100 focus-visible:!bg-[#a36ec7] focus-visible:!text-white group-hover/submenu-item:before:opacity-100 group-hover/submenu-item:!bg-[#a36ec7] group-hover/submenu-item:!text-white !py-2 !text-sm {{ request()->routeIs('stock_movements.*') ? 'before:opacity-100 !bg-[#a36ec7] !text-white shadow-sm shadow-purple-200' : 'before:opacity-0 hover:before:opacity-100 !text-slate-600 hover:!bg-[#a36ec7] hover:!text-white' }}" href="{{ route('stock_movements.index') }}">
                          Stock Movements
                      </a>
                  </li>
              </ul>
          </div>
        </li>
        <li class="nav-item">
            <a class="nav-link group relative rounded-xl transition-all duration-200 before:absolute before:inset-y-0 before:left-0 before:z-10 before:my-auto before:h-6 before:w-1 before:rounded-r before:bg-orange-500 before:content-[''] before:transition-opacity focus-visible:before:opacity-100 focus-visible:!bg-[#a36ec7] focus-visible:!text-white {{ request()->routeIs('purchase_orders.*') ? 'before:opacity-100 !bg-[#a36ec7] !text-white shadow-md shadow-purple-200' : 'before:opacity-0 hover:before:opacity-100 !text-slate-600 hover:!bg-[#a36ec7] hover:!text-white' }}" href="{{ route('purchase_orders.index') }}">
                <i class="material-symbols-rounded opacity-5 {{ request()->routeIs('purchase_orders.*') ? '!opacity-100 !text-white' : 'group-hover:!opacity-100 group-hover:!text-white' }}">shopping_cart</i>
                <span class="nav-link-text ms-1 {{ request()->routeIs('purchase_orders.*') ? '!text-white' : 'group-hover:!text-white' }}">Purchase Orders</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link group relative rounded-xl transition-all duration-200 before:absolute before:inset-y-0 before:left-0 before:z-10 before:my-auto before:h-6 before:w-1 before:rounded-r before:bg-orange-500 before:content-[''] before:transition-opacity focus-visible:before:opacity-100 focus-visible:!bg-[#a36ec7] focus-visible:!text-white {{ request()->routeIs('purchase_order_items.*') ? 'before:opacity-100 !bg-[#a36ec7] !text-white shadow-md shadow-purple-200' : 'before:opacity-0 hover:before:opacity-100 !text-slate-600 hover:!bg-[#a36ec7] hover:!text-white' }}" href="{{ route('purchase_order_items.index') }}">
                <i class="material-symbols-rounded opacity-5 {{ request()->routeIs('purchase_order_items.*') ? '!opacity-100 !text-white' : 'group-hover:!opacity-100 group-hover:!text-white' }}">inventory_2</i>
                <span class="nav-link-text ms-1 {{ request()->routeIs('purchase_order_items.*') ? '!text-white' : 'group-hover:!text-white' }}">PO Items</span>
            </a>
        </li>
        <li class="nav-item group/production">
            <a class="nav-link group group/expanded relative rounded-xl transition-all duration-200 after:!hidden before:absolute before:inset-y-0 before:left-0 before:z-10 before:my-auto before:h-6 before:w-1 before:rounded-r before:bg-orange-500 before:content-[''] before:transition-opacity focus-visible:before:opacity-100 focus-visible:!bg-[#a36ec7] focus-visible:!text-white group-hover/production:before:opacity-100 group-hover/production:!bg-[#a36ec7] group-hover/production:!text-white {{ request()->routeIs('production-orders.*', 'production-order-materials.*') ? 'before:opacity-100 !bg-[#a36ec7] !text-white shadow-md shadow-purple-200' : 'before:opacity-0 hover:before:opacity-100 !text-slate-600 hover:!bg-[#a36ec7] hover:!text-white' }}"
            data-bs-toggle="collapse"
            href="#productionSubmenu"
            aria-controls="productionSubmenu"
            aria-expanded="{{ request()->routeIs('production-orders.*', 'production-order-materials.*') ? 'true' : 'false' }}">
                <i class="material-symbols-rounded opacity-5 {{ request()->routeIs('production-orders.*', 'production-order-materials.*') ? '!opacity-100 !text-white' : 'group-hover/production:!opacity-100 group-hover/production:!text-white group-focus-visible:!opacity-100' }}">factory</i>
                <span class="nav-link-text ms-1 {{ request()->routeIs('production-orders.*', 'production-order-materials.*') ? '!text-white' : 'group-hover/production:!text-white group-focus-visible:!text-white' }}">Production</span>
                <span class="material-symbols-rounded ms-auto text-base transition-transform duration-200 group-aria-expanded/expanded:rotate-90" aria-hidden="true">chevron_right</span>
            </a>

            <div class="collapse !visible {{ request()->routeIs('production-orders.*', 'production-order-materials.*') ? 'show' : '' }}" id="productionSubmenu">
                <ul class="nav flex-column ms-4 mt-1 border-start border-slate-200 ps-2">
                    <li class="nav-item group/submenu-item">
                        <a class="nav-link group relative rounded-lg transition-all duration-200 before:absolute before:inset-y-0 before:left-0 before:z-10 before:my-auto before:h-5 before:w-1 before:rounded-r before:bg-orange-500 before:content-[''] before:transition-opacity focus-visible:before:opacity-100 focus-visible:!bg-[#a36ec7] focus-visible:!text-white group-hover/submenu-item:before:opacity-100 group-hover/submenu-item:!bg-[#a36ec7] group-hover/submenu-item:!text-white !py-2 !text-sm {{ request()->routeIs('production-orders.index', 'production-orders.create', 'production-orders.show', 'production-orders.edit') ? 'before:opacity-100 !bg-[#a36ec7] !text-white shadow-sm shadow-purple-200' : 'before:opacity-0 hover:before:opacity-100 !text-slate-600 hover:!bg-[#a36ec7] hover:!text-white' }}" href="{{ route('production-orders.index') }}">
                            Production Orders
                        </a>
                    </li>
                    <li class="nav-item group/submenu-item">
                        @php($currentProductionOrder = request()->route('productionOrder'))
                        <a class="nav-link group relative rounded-lg transition-all duration-200 before:absolute before:inset-y-0 before:left-0 before:z-10 before:my-auto before:h-5 before:w-1 before:rounded-r before:bg-orange-500 before:content-[''] before:transition-opacity focus-visible:before:opacity-100 focus-visible:!bg-[#a36ec7] focus-visible:!text-white group-hover/submenu-item:before:opacity-100 group-hover/submenu-item:!bg-[#a36ec7] group-hover/submenu-item:!text-white !py-2 !text-sm {{ request()->routeIs('production-orders.materials.*', 'production-order-materials.*') ? 'before:opacity-100 !bg-[#a36ec7] !text-white shadow-sm shadow-purple-200' : 'before:opacity-0 hover:before:opacity-100 !text-slate-600 hover:!bg-[#a36ec7] hover:!text-white' }}" href="{{ $currentProductionOrder ? route('production-orders.materials.index', $currentProductionOrder) : route('production-order-materials.index') }}">
                            Production Order Materials
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link group relative rounded-xl transition-all duration-200 before:absolute before:inset-y-0 before:left-0 before:z-10 before:my-auto before:h-6 before:w-1 before:rounded-r before:bg-orange-500 before:content-[''] before:transition-opacity focus-visible:before:opacity-100 focus-visible:!bg-[#a36ec7] focus-visible:!text-white {{ request()->routeIs('quality_inspections.*') ? 'before:opacity-100 !bg-[#a36ec7] !text-white shadow-md shadow-purple-200' : 'before:opacity-0 hover:before:opacity-100 !text-slate-600 hover:!bg-[#a36ec7] hover:!text-white' }}" href="{{ route('quality_inspections.index') }}">
                <i class="material-symbols-rounded opacity-5 {{ request()->routeIs('quality_inspections.*') ? '!opacity-100 !text-white' : 'group-hover:!opacity-100 group-hover:!text-white' }}">fact_check</i>
                <span class="nav-link-text ms-1 {{ request()->routeIs('quality_inspections.*') ? '!text-white' : 'group-hover:!text-white' }}">Quality Inspections</span>
            </a>
        </li>



        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Account pages</h6>
        </li>
        @auth
        <li class="nav-item">
          <a class="nav-link group relative rounded-xl transition-all duration-200 before:absolute before:inset-y-0 before:left-0 before:z-10 before:my-auto before:h-6 before:w-1 before:rounded-r before:bg-orange-500 before:content-[''] before:transition-opacity focus-visible:before:opacity-100 focus-visible:!bg-[#a36ec7] focus-visible:!text-white {{ request()->routeIs('profile.*') ? 'before:opacity-100 !bg-[#a36ec7] !text-white shadow-md shadow-purple-200' : 'before:opacity-0 hover:before:opacity-100 !text-slate-600 hover:!bg-[#a36ec7] hover:!text-white' }}" href="{{ route('profile.edit') }}">
            <i class="material-symbols-rounded opacity-5 {{ request()->routeIs('profile.*') ? '!opacity-100 !text-white' : 'group-hover:!opacity-100 group-hover:!text-white' }}">person</i>
            <span class="nav-link-text ms-1 {{ request()->routeIs('profile.*') ? '!text-white' : 'group-hover:!text-white' }}">Profile</span>
          </a>
        </li>
        <li class="nav-item">
          <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="nav-link group relative w-100 rounded-xl border-0 bg-transparent text-start transition-all duration-200 before:absolute before:inset-y-0 before:left-0 before:z-10 before:my-auto before:h-6 before:w-1 before:rounded-r before:bg-orange-500 before:content-[''] before:opacity-0 before:transition-opacity hover:before:opacity-100 hover:!bg-[#a36ec7] hover:!text-white focus-visible:before:opacity-100 focus-visible:!bg-[#a36ec7] focus-visible:!text-white !text-slate-600">
              <i class="material-symbols-rounded opacity-5 group-hover:!opacity-100 group-hover:!text-white">logout</i>
              <span class="nav-link-text ms-1 group-hover:!text-white">Logout</span>
            </button>
          </form>
        </li>
        @else
        <li class="nav-item">
          <a class="nav-link text-dark" href="{{ route('login') }}">
            <i class="material-symbols-rounded opacity-5">login</i>
            <span class="nav-link-text ms-1">Sign In</span>
          </a>
        </li>
        @endauth
      </ul>
    </div>

  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      @yield('content')
  </main>
  <div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
      <i class="material-symbols-rounded py-2">settings</i>
    </a>
    <div class="card shadow-lg">
      <div class="card-header pb-0 pt-3">
        <div class="float-start">
          <h5 class="mt-3 mb-0">Material UI Configurator</h5>
          <p>See our dashboard options.</p>
        </div>
        <div class="float-end mt-4">
          <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
            <i class="material-symbols-rounded">clear</i>
          </button>
        </div>
        <!-- End Toggle Button -->
      </div>
      <hr class="horizontal dark my-1">
      <div class="card-body pt-sm-3 pt-0">
        <!-- Sidebar Backgrounds -->
        <div>
          <h6 class="mb-0">Sidebar Colors</h6>
        </div>
        <a href="javascript:void(0)" class="switch-trigger background-color">
          <div class="badge-colors my-2 text-start">
            <span class="badge filter bg-gradient-primary" data-color="primary" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-dark active" data-color="dark" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-success" data-color="success" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-warning" data-color="warning" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-danger" data-color="danger" onclick="sidebarColor(this)"></span>
          </div>
        </a>
        <!-- Sidenav Type -->
        <div class="mt-3">
          <h6 class="mb-0">Sidenav Type</h6>
          <p class="text-sm">Choose between different sidenav types.</p>
        </div>
        <div class="d-flex">
          <button class="btn bg-gradient-dark px-3 mb-2" data-class="bg-gradient-dark" onclick="sidebarType(this)">Dark</button>
          <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-transparent" onclick="sidebarType(this)">Transparent</button>
          <button class="btn bg-gradient-dark px-3 mb-2  active ms-2" data-class="bg-white" onclick="sidebarType(this)">White</button>
        </div>
        <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
        <!-- Navbar Fixed -->
        <div class="mt-3 d-flex">
          <h6 class="mb-0">Navbar Fixed</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed" onclick="navbarFixed(this)">
          </div>
        </div>
        <hr class="horizontal dark my-3">
        <div class="mt-2 d-flex">
          <h6 class="mb-0">Light / Dark</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version" onclick="darkMode(this)">
          </div>
        </div>
        <hr class="horizontal dark my-sm-4">
        <a class="btn bg-gradient-info w-100" href="https://www.creative-tim.com/product/material-dashboard-pro">Free Download</a>
        <a class="btn btn-outline-dark w-100" href="https://www.creative-tim.com/learning-lab/bootstrap/overview/material-dashboard">View documentation</a>
        <div class="w-100 text-center">
          <a class="github-button" href="https://github.com/creativetimofficial/material-dashboard" data-icon="octicon-star" data-size="large" data-show-count="true" aria-label="Star creativetimofficial/material-dashboard on GitHub">Star</a>
          <h6 class="mt-3">Thank you for sharing!</h6>
          <a href="https://twitter.com/intent/tweet?text=Check%20Material%20UI%20Dashboard%20made%20by%20%40CreativeTim%20%23webdesign%20%23dashboard%20%23bootstrap5&amp;url=https%3A%2F%2Fwww.creative-tim.com%2Fproduct%2Fsoft-ui-dashboard" class="btn btn-dark mb-0 me-2" target="_blank">
            <i class="fab fa-twitter me-1" aria-hidden="true"></i> Tweet
          </a>
          <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.creative-tim.com/product/material-dashboard" class="btn btn-dark mb-0 me-2" target="_blank">
            <i class="fab fa-facebook-square me-1" aria-hidden="true"></i> Share
          </a>
        </div>
      </div>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
  <script>
    var chartBars = document.getElementById("chart-bars");
    if (chartBars) {
    var ctx = chartBars.getContext("2d");

    new Chart(ctx, {
      type: "bar",
      data: {
        labels: ["M", "T", "W", "T", "F", "S", "S"],
        datasets: [{
          label: "Views",
          tension: 0.4,
          borderWidth: 0,
          borderRadius: 4,
          borderSkipped: false,
          backgroundColor: "#43A047",
          data: [50, 45, 22, 28, 50, 60, 76],
          barThickness: 'flex'
        }, ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5],
              color: '#e5e5e5'
            },
            ticks: {
              suggestedMin: 0,
              suggestedMax: 500,
              beginAtZero: true,
              padding: 10,
              font: {
                size: 14,
                lineHeight: 2
              },
              color: "#737373"
            },
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#737373',
              padding: 10,
              font: {
                size: 14,
                lineHeight: 2
              },
            }
          },
        },
      },
    });
    }

    var chartLine = document.getElementById("chart-line");
    if (chartLine) {
    var ctx2 = chartLine.getContext("2d");

    new Chart(ctx2, {
      type: "line",
      data: {
        labels: ["J", "F", "M", "A", "M", "J", "J", "A", "S", "O", "N", "D"],
        datasets: [{
          label: "Sales",
          tension: 0,
          borderWidth: 2,
          pointRadius: 3,
          pointBackgroundColor: "#43A047",
          pointBorderColor: "transparent",
          borderColor: "#43A047",
          backgroundColor: "transparent",
          fill: true,
          data: [120, 230, 130, 440, 250, 360, 270, 180, 90, 300, 310, 220],
          maxBarThickness: 6

        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          },
          tooltip: {
            callbacks: {
              title: function(context) {
                const fullMonths = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                return fullMonths[context[0].dataIndex];
              }
            }
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [4, 4],
              color: '#e5e5e5'
            },
            ticks: {
              display: true,
              color: '#737373',
              padding: 10,
              font: {
                size: 12,
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#737373',
              padding: 10,
              font: {
                size: 12,
                lineHeight: 2
              },
            }
          },
        },
      },
    });
    }

    var chartLineTasks = document.getElementById("chart-line-tasks");
    if (chartLineTasks) {
    var ctx3 = chartLineTasks.getContext("2d");

    new Chart(ctx3, {
      type: "line",
      data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
          label: "Tasks",
          tension: 0,
          borderWidth: 2,
          pointRadius: 3,
          pointBackgroundColor: "#43A047",
          pointBorderColor: "transparent",
          borderColor: "#43A047",
          backgroundColor: "transparent",
          fill: true,
          data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
          maxBarThickness: 6

        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [4, 4],
              color: '#e5e5e5'
            },
            ticks: {
              display: true,
              padding: 10,
              color: '#737373',
              font: {
                size: 14,
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [4, 4]
            },
            ticks: {
              display: true,
              color: '#737373',
              padding: 10,
              font: {
                size: 14,
                lineHeight: 2
              },
            }
          },
        },
      },
    });
    }
  </script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{ asset('assets/js/material-dashboard.min.js?v=3.2.0') }}"></script>
</body>

</html>
