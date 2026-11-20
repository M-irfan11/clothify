@extends('layout.master')

@section('content')
<div class="mx-auto flex w-full flex-col gap-4 px-3 py-3 pb-8">
  <!-- <div class="flex flex-wrap items-end justify-between gap-2 px-1">
    <div>
      <h1 class="mb-1 text-xl font-semibold text-[#344767]">Dashboard</h1>
      <p class="mb-0 text-sm text-[#8a94a6]">Your business overview at a glance.</p>
    </div>
    <span class="mt-2 text-xs text-[#8a94a6]">Clothify overview</span>
  <!-- </div> -->

  <div class="grid grid-cols-2 gap-3">
    <article class="flex min-h-[116px] flex-col justify-center rounded-md bg-[#4b75e8] px-4 py-4 text-white">
      <p class="mb-1 text-[0.78rem] font-medium text-white">Total Raw Materials</p>
      <h2 class="mb-1 text-[1.35rem] font-bold text-white">12,500 kg</h2>
      <small class="text-[0.65rem] opacity-90">Available Stock</small>
    </article>
    <article class="flex min-h-[116px] flex-col justify-center rounded-md bg-[#a16dca] px-4 py-4 text-white">
      <p class="mb-1 text-[0.78rem] font-medium text-white">Finished Goods</p>
      <h2 class="mb-1 text-[1.35rem] font-bold text-white">8,450 pcs</h2>
      <small class="text-[0.65rem] opacity-90">Ready for Shipmen</small>
    </article>
    <article class="flex min-h-[116px] flex-col justify-center rounded-md bg-[#4b75e8] px-4 py-4 text-white">
      <p class="mb-1 text-[0.78rem] font-medium text-white">Active Production</p>
      <h2 class="mb-1 text-[1.35rem] font-bold text-white">12 Orders</h2>
      <small class="text-[0.65rem] opacity-90">In Progress</small>
    </article>
    <article class="flex min-h-[116px] flex-col justify-center rounded-md bg-[#a16dca] px-4 py-4 text-white">
      <p class="mb-1 text-[0.78rem] font-medium text-white">Pending Buyer Orders</p>
      <h2 class="mb-1 text-[1.35rem] font-bold text-white">18 Orders</h2>
      <small class="text-[0.65rem] opacity-90">Awaiting Processing</small>
    </article>
  </div>

  <div class="grid grid-cols-1 gap-3 lg:grid-cols-4">
    <div class="min-w-0 lg:col-span-2">
      <section class="h-full rounded-lg bg-white p-4 shadow-sm">
        <div class="flex flex-wrap items-start justify-between gap-2">
          <div>
            <h2 class="mb-1 text-[0.82rem] font-semibold leading-6 tracking-normal text-[#344767]">AP and AR Balance</h2>
            <p class="mb-0 text-[0.7rem] text-[#8a94a6]">Avg. $5,309</p>
          </div>
          <div class="flex gap-2">
            <button class="cursor-pointer rounded border border-[#e9edf3] px-2 py-1 text-xs text-[#667085] transition-colors hover:border-[#a16dca] hover:bg-[#a16dca] hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#a16dca]" type="button">Monthly</button>
            <button class="cursor-pointer rounded border border-[#e9edf3] px-2 py-1 text-xs text-[#667085] transition-colors hover:border-[#a16dca] hover:bg-[#a16dca] hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#a16dca]" type="button">Last Year</button>
          </div>
        </div>
        <svg class="mt-2 block h-auto w-full" viewBox="0 0 700 285" role="img" aria-label="Monthly AP and AR balance chart">
          <g class="stroke-[#e9edf3] [stroke-width:1]">
            <line x1="52" y1="35" x2="650" y2="35" />
            <line x1="52" y1="80" x2="650" y2="80" />
            <line x1="52" y1="125" x2="650" y2="125" />
            <line x1="52" y1="170" x2="650" y2="170" />
            <line x1="52" y1="215" x2="650" y2="215" />
          </g>
          <g class="fill-[#7b8496] font-sans text-[11px]">
            <text x="12" y="39">800</text>
            <text x="12" y="84">600</text>
            <text x="12" y="129">400</text>
            <text x="12" y="174">200</text>
            <text x="20" y="219">0</text>
          </g>
          <g class="fill-[#a16dca] opacity-90">
            <rect x="76" y="130" width="27" height="85" rx="1" />
            <rect x="119" y="105" width="27" height="110" rx="1" />
            <rect x="162" y="125" width="27" height="90" rx="1" />
            <rect x="205" y="155" width="27" height="60" rx="1" />
            <rect x="248" y="95" width="27" height="120" rx="1" />
            <rect x="291" y="170" width="27" height="45" rx="1" />
            <rect x="334" y="138" width="27" height="77" rx="1" />
            <rect x="377" y="160" width="27" height="55" rx="1" />
            <rect x="420" y="85" width="27" height="130" rx="1" />
            <rect x="463" y="135" width="27" height="80" rx="1" />
            <rect x="506" y="150" width="27" height="65" rx="1" />
            <rect x="549" y="174" width="27" height="41" rx="1" />
            <rect x="592" y="185" width="27" height="30" rx="1" />
          </g>
          <polyline
            points="89,145 132,64 175,95 218,120 261,58 304,142 347,162 390,102 433,150 476,169 519,190 562,205 605,184"
            class="fill-none stroke-[#a16dca] stroke-[5] opacity-85 [stroke-linecap:round] [stroke-linejoin:round]"
          />
          <g class="fill-[#7b8496] font-sans text-[11px]">
            <text x="68" y="246">Jan '01</text>
            <text x="160" y="246">03 Jan</text>
            <text x="250" y="246">05 Jan</text>
            <text x="342" y="246">07 Jan</text>
            <text x="434" y="246">09 Jan</text>
            <text x="526" y="246">11 Jan</text>
          </g>
        </svg>
      </section>
    </div>

    <div class="min-w-0 lg:col-span-1">
      <section class="flex h-full flex-col rounded-lg bg-white p-4 shadow-sm">
        <h2 class="mb-3 text-[0.82rem] font-semibold leading-6 tracking-normal text-[#344767]">% of Income Budget</h2>
        <div class="relative mx-auto mb-3 grid aspect-square w-[min(108px,86%)] place-items-center" role="img" aria-label="67 percent of income budget">
          <svg class="absolute inset-0 h-full w-full -rotate-90" viewBox="0 0 100 100" aria-hidden="true">
            <circle cx="50" cy="50" r="45" fill="none" stroke-width="8" class="stroke-[#e9edf4]" />
            <circle cx="50" cy="50" r="45" fill="none" stroke-width="8" stroke-dasharray="189 283" class="stroke-[#537be8]" />
          </svg>
          <span class="relative text-center text-base font-bold leading-tight text-[#344767]">67%<small class="block text-[0.62rem] font-normal text-[#8a94a6]">Budget</small></span>
        </div>
        <div class="mb-3 flex justify-between text-xs text-[#8a94a6]">
          <span>Balance</span>
          <span>$18,570</span>
        </div>
        <a class="mt-auto block border-t border-[#eef0f4] pt-3 text-center text-[0.68rem] text-[#4b75e8] no-underline transition-colors hover:text-[#a16dca] hover:underline" href="{{ route('products.index') }}">View Full Report</a>
      </section>
    </div>

    <div class="min-w-0 lg:col-span-1">
      <section class="flex h-full flex-col rounded-lg bg-white p-4 shadow-sm">
        <h2 class="mb-3 text-[0.82rem] font-semibold leading-6 tracking-normal text-[#344767]">% of Expenses Budget</h2>
        <div class="relative mx-auto mb-3 grid aspect-square w-[min(108px,86%)] place-items-center" role="img" aria-label="48 percent of expenses budget">
          <svg class="absolute inset-0 h-full w-full -rotate-90" viewBox="0 0 100 100" aria-hidden="true">
            <circle cx="50" cy="50" r="45" fill="none" stroke-width="8" class="stroke-[#e9edf4]" />
            <circle cx="50" cy="50" r="45" fill="none" stroke-width="8" stroke-dasharray="136 283" class="stroke-[#a16dca]" />
          </svg>
          <span class="relative text-center text-base font-bold leading-tight text-[#344767]">48%<small class="block text-[0.62rem] font-normal text-[#8a94a6]">Profit</small></span>
        </div>
        <div class="mb-3 flex justify-between text-xs text-[#8a94a6]">
          <span>Balance</span>
          <span>$31,430</span>
        </div>
        <a class="mt-auto block border-t border-[#eef0f4] pt-3 text-center text-[0.68rem] text-[#4b75e8] no-underline transition-colors hover:text-[#a16dca] hover:underline" href="{{ route('materials.index') }}">View Full Report</a>
      </section>
    </div>
  </div>

  <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
    <section class="min-w-0 rounded-lg bg-white p-4 shadow-sm lg:col-span-2">
      <div class="flex flex-wrap items-center justify-between gap-3">
        <h2 class="text-sm font-semibold leading-6 tracking-normal text-[#344767]">Monthly Income stats for November 2020</h2>
        <div class="flex gap-1 rounded bg-[#f3f6fb] p-1 text-[0.65rem] text-[#667085]">
          <button class="cursor-pointer rounded px-2 py-1 transition-colors hover:bg-[#a16dca] hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#a16dca]" type="button">Today</button>
          <button class="cursor-pointer rounded bg-white px-2 py-1 font-medium shadow-sm transition-colors hover:bg-[#a16dca] hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#a16dca]" type="button">Weekly</button>
          <button class="cursor-pointer rounded px-2 py-1 transition-colors hover:bg-[#a16dca] hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#a16dca]" type="button">Monthly</button>
        </div>
      </div>

      <svg class="mt-4 block h-auto w-full" viewBox="0 0 700 300" role="img" aria-label="Monthly income with yearly comparison">
        <g class="stroke-[#e9edf3] [stroke-width:1]">
          <line x1="48" y1="35" x2="680" y2="35" />
          <line x1="48" y1="80" x2="680" y2="80" />
          <line x1="48" y1="125" x2="680" y2="125" />
          <line x1="48" y1="170" x2="680" y2="170" />
          <line x1="48" y1="215" x2="680" y2="215" />
        </g>
        <g class="fill-[#7b8496] font-sans text-[11px]">
          <text x="12" y="39">45</text>
          <text x="12" y="84">36</text>
          <text x="12" y="129">27</text>
          <text x="12" y="174">18</text>
          <text x="18" y="219">9</text>
        </g>
        <g class="fill-[#a16dca] opacity-95">
          <rect x="54" y="145" width="12" height="70" rx="1" />
          <rect x="102" y="53" width="12" height="162" rx="1" />
          <rect x="150" y="110" width="12" height="105" rx="1" />
          <rect x="198" y="123" width="12" height="92" rx="1" />
          <rect x="246" y="145" width="12" height="70" rx="1" />
          <rect x="294" y="48" width="12" height="167" rx="1" />
          <rect x="342" y="152" width="12" height="63" rx="1" />
          <rect x="390" y="180" width="12" height="35" rx="1" />
          <rect x="438" y="101" width="12" height="114" rx="1" />
          <rect x="486" y="132" width="12" height="83" rx="1" />
          <rect x="534" y="145" width="12" height="70" rx="1" />
          <rect x="582" y="197" width="12" height="18" rx="1" />
          <rect x="630" y="176" width="12" height="39" rx="1" />
        </g>
        <polyline
          points="60,132 108,76 156,101 204,62 252,139 300,102 348,77 396,101 444,61 492,134 540,91 588,151 636,173"
          class="fill-none stroke-[#a16dca] stroke-[3] [stroke-linecap:round] [stroke-linejoin:round]"
        />
        <g class="fill-[#7b8496] font-sans text-[11px]">
          <text x="48" y="239">Jan</text>
          <text x="96" y="239">Feb</text>
          <text x="144" y="239">Mar</text>
          <text x="192" y="239">Apr</text>
          <text x="240" y="239">May</text>
          <text x="288" y="239">Jun</text>
          <text x="336" y="239">Jul</text>
          <text x="384" y="239">Aug</text>
          <text x="432" y="239">Sep</text>
          <text x="480" y="239">Oct</text>
          <text x="528" y="239">Nov</text>
          <text x="576" y="239">Dec</text>
        </g>
      </svg>

      <div class="mt-2 grid grid-cols-1 gap-3 border-t border-[#eef0f4] pt-3 text-xs sm:grid-cols-3">
        <div>
          <p class="mb-1 font-medium text-[#344767]">$12,253 <span class="text-[#4b75e8]">↗ 2.2%</span></p>
          <p class="mb-0 text-[0.65rem] text-[#8a94a6]">This month</p>
        </div>
        <div>
          <p class="mb-1 font-medium text-[#344767]"><span class="mr-1 text-[#a16dca]">●</span>This Year: $34,254 <span class="text-[#4b75e8]">↗ 2.1%</span></p>
          <p class="mb-0 text-[0.65rem] text-[#8a94a6]">Year to date</p>
        </div>
        <div>
          <p class="mb-1 font-medium text-[#344767]"><span class="mr-1 text-[#a16dca]">●</span>Previous Year: $32,695</p>
          <p class="mb-0 text-[0.65rem] text-[#8a94a6]">Last year</p>
        </div>
      </div>
    </section>

    <section class="rounded-lg bg-white p-2 shadow-sm">
      <h2 class="sr-only">Listing summary</h2>
      <div class="flex h-full flex-col divide-y divide-[#eef0f4]">
        <div class="flex flex-1 flex-col justify-center px-4 py-3">
          <strong class="text-lg font-bold text-[#4b75e8]">50 +</strong>
          <span class="text-xs text-[#8a94a6]">Total categories</span>
        </div>
        <div class="flex flex-1 flex-col justify-center px-4 py-3">
          <strong class="text-lg font-bold text-[#4b75e8]">100 +</strong>
          <span class="text-xs text-[#8a94a6]">Total Listing</span>
        </div>
        <div class="flex flex-1 flex-col justify-center px-4 py-3">
          <strong class="text-lg font-bold text-[#4b75e8]">20 +</strong>
          <span class="text-xs text-[#8a94a6]">Claimed Listing</span>
        </div>
        <div class="flex flex-1 flex-col justify-center px-4 py-3">
          <strong class="text-lg font-bold text-[#4b75e8]">10 +</strong>
          <span class="text-xs text-[#8a94a6]">Reported Listing</span>
        </div>
      </div>
    </section>
  </div>

  <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
    <section class="rounded-lg bg-white p-4 shadow-sm">
      <h2 class="mb-4 text-sm font-semibold leading-6 tracking-normal text-[#344767]">Users according to packages</h2>
      <div class="overflow-x-auto">
        <table class="w-full border-collapse text-left text-xs">
          <thead>
            <tr class="bg-[#f3f7fd] text-[#8393b7]">
              <th class="rounded-l-lg px-4 py-3 font-medium">Package Name</th>
              <th class="rounded-r-lg px-4 py-3 text-right font-medium">No. Of Users</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-[#f1f3f7] text-[#8a94a6]">
            <tr>
              <td class="px-4 py-3">Free package</td>
              <td class="px-4 py-3 text-right">2556</td>
            </tr>
            <tr>
              <td class="px-4 py-3">Free package</td>
              <td class="px-4 py-3 text-right">2556</td>
            </tr>
            <tr>
              <td class="px-4 py-3">Free package</td>
              <td class="px-4 py-3 text-right">2556</td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>

    <section class="rounded-lg bg-white p-4 shadow-sm">
      <h2 class="mb-5 text-sm font-semibold leading-6 tracking-normal text-[#344767]">Overview</h2>
      <div class="space-y-5">
        <div class="flex items-center gap-3">
          <span class="w-24 shrink-0 text-xs text-[#667085]">Active Listings</span>
          <div class="relative h-1.5 flex-1 rounded-full bg-[#f1f3f7]">
            <div class="h-full w-[85%] rounded-full bg-[#4b8cf5]"></div>
            <span class="absolute -top-4 right-0 text-[0.6rem] text-[#8a94a6]">85%</span>
          </div>
        </div>
        <div class="flex items-center gap-3">
          <span class="w-24 shrink-0 text-xs text-[#667085]">Claimed Listings</span>
          <div class="relative h-1.5 flex-1 rounded-full bg-[#f1f3f7]">
            <div class="h-full w-[76%] rounded-full bg-[#a16dca]"></div>
            <span class="absolute -top-4 right-0 text-[0.6rem] text-[#8a94a6]">76%</span>
          </div>
        </div>
        <div class="flex items-center gap-3">
          <span class="w-24 shrink-0 text-xs text-[#667085]">Reported Listings</span>
          <div class="relative h-1.5 flex-1 rounded-full bg-[#f1f3f7]">
            <div class="h-full w-[55%] rounded-full bg-[#4b8cf5]"></div>
            <span class="absolute -top-4 right-0 text-[0.6rem] text-[#8a94a6]">55%</span>
          </div>
        </div>
        <div class="flex items-center gap-3">
          <span class="w-24 shrink-0 text-xs text-[#667085]">Pending Listings</span>
          <div class="relative h-1.5 flex-1 rounded-full bg-[#f1f3f7]">
            <div class="h-full w-[25%] rounded-full bg-[#a16dca]"></div>
            <span class="absolute -top-4 right-0 text-[0.6rem] text-[#8a94a6]">25%</span>
          </div>
        </div>
      </div>
    </section>
  </div>

  <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
    <section class="rounded-xl border border-[#eef0f4] bg-white p-5 shadow-sm">
      <div class="flex items-start justify-between gap-3">
        <div>
          <h2 class="mb-1 text-sm font-semibold leading-6 tracking-normal text-[#344767]">Revenue by Category</h2>
          <p class="mb-0 text-xs text-[#8a94a6]">Sales breakdown this month</p>
        </div>
        <button class="cursor-pointer rounded-lg border border-[#e9edf3] px-3 py-1.5 text-xs text-[#667085] transition-colors hover:border-[#a16dca] hover:bg-[#a16dca] hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#a16dca]" type="button">Monthly</button>
      </div>
      <div class="flex flex-col items-center gap-5 py-5 sm:flex-row sm:justify-center sm:gap-8">
        <div class="relative grid place-items-center" style="width: 160px; height: 160px; flex: 0 0 160px;" role="img" aria-label="Revenue of $39,070: clothing 65 percent, footwear 35 percent">
          <svg width="160" height="160" viewBox="0 0 100 100" style="position: absolute; inset: 0; transform: rotate(-90deg);" aria-hidden="true">
            <circle cx="50" cy="50" r="43" fill="none" stroke="#eef0f4" stroke-width="10" />
            <circle cx="50" cy="50" r="43" fill="none" stroke="#4b75e8" stroke-width="10" stroke-dasharray="175.6 270.2" />
            <circle cx="50" cy="50" r="43" fill="none" stroke="#a16dca" stroke-width="10" stroke-dasharray="94.6 270.2" stroke-dashoffset="-175.6" />
          </svg>
          <span class="relative text-center text-lg font-bold leading-tight text-[#344767]">$39,070<small class="block text-xs font-normal text-[#8a94a6]">Revenue</small></span>
        </div>
        <div class="flex flex-wrap justify-center gap-x-4 gap-y-3 text-xs text-[#667085] sm:flex-col">
          <span><span class="mr-1 text-[#4b75e8]">●</span>Clothing <strong class="font-medium">65%</strong></span>
          <span><span class="mr-1 text-[#a16dca]">●</span>Footwear <strong class="font-medium">35%</strong></span>
        </div>
      </div>
    </section>

    <section class="rounded-xl border border-[#eef0f4] bg-white p-5 shadow-sm">
      <div class="mb-2 flex items-center justify-between gap-3">
        <div>
          <h2 class="mb-1 text-sm font-semibold leading-6 tracking-normal text-[#344767]">New Customers</h2>
          <p class="mb-0 text-xs text-[#8a94a6]">Your latest customers</p>
        </div>
        <a class="text-xs font-medium text-[#4b75e8] no-underline transition-colors hover:text-[#a16dca] hover:underline" href="{{ route('users.index') }}">View all</a>
      </div>
      <div class="divide-y divide-[#eef0f4]">
        <div class="flex items-center gap-3 py-2.5">
          <span class="grid shrink-0 place-items-center bg-[#4b75e8] text-xs font-semibold text-white" style="width: 36px; height: 36px; flex: 0 0 36px; border-radius: 50%;" aria-hidden="true">ST</span>
          <div class="min-w-0 flex-1">
            <p class="mb-0 truncate text-xs font-medium text-[#344767]">Shams Tabrizi</p>
            <p class="mb-0 truncate text-[0.68rem] text-[#8a94a6]">shams.tabrizi@example.com</p>
          </div>
          <span class="rounded-full border border-[#4b75e8] px-2.5 py-1 text-[0.65rem] text-[#4b75e8] transition-colors hover:border-[#a16dca] hover:bg-[#a16dca] hover:text-white">Regular</span>
        </div>
        <div class="flex items-center gap-3 py-2.5">
          <span class="grid shrink-0 place-items-center bg-[#a16dca] text-xs font-semibold text-white" style="width: 36px; height: 36px; flex: 0 0 36px; border-radius: 50%;" aria-hidden="true">DA</span>
          <div class="min-w-0 flex-1">
            <p class="mb-0 truncate text-xs font-medium text-[#344767]">Daniyal Arham</p>
            <p class="mb-0 truncate text-[0.68rem] text-[#8a94a6]">daniyal.r@example.com</p>
          </div>
          <span class="rounded-full border border-[#a16dca] px-2.5 py-1 text-[0.65rem] text-[#a16dca] transition-colors hover:border-[#a16dca] hover:bg-[#a16dca] hover:text-white">Wholesale</span>
        </div>
        <div class="flex items-center gap-3 py-2.5">
          <span class="grid shrink-0 place-items-center bg-[#4b75e8] text-xs font-semibold text-white" style="width: 36px; height: 36px; flex: 0 0 36px; border-radius: 50%;" aria-hidden="true">MM</span>
          <div class="min-w-0 flex-1">
            <p class="mb-0 truncate text-xs font-medium text-[#344767]">Muhammad Murshi</p>
            <p class="mb-0 truncate text-[0.68rem] text-[#8a94a6]">Murshi.s@example.com</p>
          </div>
          <span class="rounded-full border border-[#4b75e8] px-2.5 py-1 text-[0.65rem] text-[#4b75e8] transition-colors hover:border-[#a16dca] hover:bg-[#a16dca] hover:text-white">Regular</span>
        </div>
        <div class="flex items-center gap-3 py-2.5">
          <span class="grid shrink-0 place-items-center bg-[#a16dca] text-xs font-semibold text-white" style="width: 36px; height: 36px; flex: 0 0 36px; border-radius: 50%;" aria-hidden="true">KW</span>
          <div class="min-w-0 flex-1">
            <p class="mb-0 truncate text-xs font-medium text-[#344767]">Khaled bin Walid</p>
            <p class="mb-0 truncate text-[0.68rem] text-[#8a94a6]">khaled.r@example.com</p>
          </div>
          <span class="rounded-full border border-[#a16dca] px-2.5 py-1 text-[0.65rem] text-[#a16dca] transition-colors hover:border-[#a16dca] hover:bg-[#a16dca] hover:text-white">Walk-in</span>
        </div>
      </div>
    </section>
  </div>

  <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
    <article class="rounded-xl border border-[#eef0f4] border-t-4 border-t-[#4b75e8] bg-white p-5 shadow-sm">
      <div class="mb-4 flex items-center gap-3">
        <span class="grid place-items-center bg-[#4b75e8] text-lg font-bold text-white" style="width: 42px; height: 42px; flex: 0 0 42px; border-radius: 50%;" aria-hidden="true">✓</span>
        <h2 class="mb-0 text-sm font-semibold leading-6 tracking-normal text-[#344767]">Completed Payments</h2>
      </div>
      <div class="space-y-2">
        <p class="mb-0 flex items-center gap-1.5 text-xs text-[#8a94a6]">Revenue: <strong class="text-[#4b75e8]">$55,000</strong></p>
        <p class="mb-0 text-3xl font-bold leading-tight text-[#4b75e8]">200</p>
        <p class="mb-0 text-xs leading-5 text-[#8a94a6]">Since last week</p>
      </div>
    </article>
    <article class="rounded-xl border border-[#eef0f4] border-t-4 border-t-[#a16dca] bg-white p-5 shadow-sm">
      <div class="mb-4 flex items-center gap-3">
        <span class="grid place-items-center bg-[#a16dca] text-lg font-bold text-white" style="width: 42px; height: 42px; flex: 0 0 42px; border-radius: 50%;" aria-hidden="true">!</span>
        <h2 class="mb-0 text-sm font-semibold leading-6 tracking-normal text-[#344767]">Pending Payments</h2>
      </div>
      <div class="space-y-2">
        <p class="mb-0 flex items-center gap-1.5 text-xs text-[#8a94a6]">Revenue: <strong class="text-[#a16dca]">$35,000</strong></p>
        <p class="mb-0 text-3xl font-bold leading-tight text-[#a16dca]">40</p>
        <p class="mb-0 text-xs leading-5 text-[#8a94a6]">Since last week</p>
      </div>
    </article>
    <article class="rounded-xl border border-[#eef0f4] border-t-4 border-t-[#4b75e8] bg-white p-5 shadow-sm">
      <div class="mb-4 flex items-center gap-3">
        <span class="grid place-items-center bg-[#4b75e8] text-lg font-bold text-white" style="width: 42px; height: 42px; flex: 0 0 42px; border-radius: 50%;" aria-hidden="true">×</span>
        <h2 class="mb-0 text-sm font-semibold leading-6 tracking-normal text-[#344767]">Failed Payments</h2>
      </div>
      <div class="space-y-2">
        <p class="mb-0 flex items-center gap-1.5 text-xs text-[#8a94a6]">Revenue: <strong class="text-[#4b75e8]">$27,000</strong></p>
        <p class="mb-0 text-3xl font-bold leading-tight text-[#4b75e8]">5</p>
        <p class="mb-0 text-xs leading-5 text-[#8a94a6]">Since last week</p>
      </div>
    </article>
  </div>
</div>
@endsection
