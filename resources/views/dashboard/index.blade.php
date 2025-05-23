@extends('layouts.main')

@section('content')

    <!-- Loader -->
    <div id="loader" class="fixed inset-0 bg-gray-100/75 flex items-center justify-center z-50 transition-opacity duration-300">
        <div class="flex flex-col items-center">
            <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-600"></div>
            <p class="mt-3 text-sm font-medium text-gray-700">Loading dashboard...</p>
        </div>
    </div>

    <!-- Main Dashboard Container -->
    <div class="px-4 sm:px-6 py-6">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Sales Dashboard</h1>
                <p class="mt-1 text-sm text-gray-500">Overview of your sales performance</p>
            </div>
        </div>

        <!-- Seller and product Filter (Admin Only) -->
        <div class="flex flex-col gap-4 sm:flex-row w-full">
            <div class="sm:mb-8">
                <label for="seller-filter" class="block text-sm font-medium text-gray-700 mb-2">Period</label>
                <div class="relative">
                    <div class="relative w-60 sm:w-xs">
                        <select id="period-filter" name="period" class="border cursor-pointer border-gray-300 rounded-lg px-4 py-2 appearance-none w-full">
                            <option value="this_month">This Month</option>
                            <option value="last_month">Last Month</option>
                            <option value="this_quarter">This Quarter</option>
                            <option value="this_year">This Year</option>
                        </select>
                        <span class="material-symbols-outlined absolute top-1/2 -translate-y-1/2 right-3 text-gray-500 rotate-90 pointer-events-none">
                            chevron_right
                        </span>
                    </div>
                </div>
            </div>
            @if (auth()->user()->is_admin)
            <div class="mb-8">
                <label for="seller-filter" class="block text-sm font-medium text-gray-700 mb-2">Filter by Seller</label>
                <div class="relative w-60 sm:w-xs">
                    <div class="relative w-full">
                        <select id="seller-filter" name="sellerId" class="border cursor-pointer border-gray-300 rounded-lg px-4 py-2 appearance-none w-full">
                            <option value="">All Sellers</option>
                            @foreach ($sellers as $seller)
                                <option value="{{ $seller->id }}" {{ request('sellerId') == $seller->id ? 'selected' : '' }}>
                                    {{ $seller->business_name }}
                                </option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined absolute top-1/2 -translate-y-1/2 right-3 text-gray-500 rotate-90 pointer-events-none">
                            chevron_right
                        </span>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Overview Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 truncate">Total Sales</p>
                        <p class="mt-1 text-2xl font-semibold text-gray-900" id="total-sales">0</p>
                    </div>
                    <div class="bg-blue-50 p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="mt-2 text-xs text-gray-500 flex items-center" id="total-sales-change"></p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 truncate">Total Orders</p>
                        <p class="mt-1 text-2xl font-semibold text-gray-900" id="order-count">0</p>
                    </div>
                    <div class="bg-green-50 p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
                <p class="mt-2 text-xs text-gray-500 flex items-center" id="order-count-change"></p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 truncate">Avg. Order Value</p>
                        <p class="mt-1 text-2xl font-semibold text-gray-900" id="avg-order-value">0</p>
                    </div>
                    <div class="bg-purple-50 p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                </div>
                <p class="mt-2 text-xs text-gray-500 flex items-center" id="avg-order-change"></p>
            </div>

            <!-- <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 truncate">Conversion Rate</p>
                        <p class="mt-1 text-2xl font-semibold text-gray-900" id="conversion-rate">0%</p>
                    </div>
                    <div class="bg-blue-50 p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                </div>
                <p class="mt-2 text-xs text-gray-500 flex items-center" id="conversion-rate-change"></p>
            </div> -->
        </div>
        
        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 lg:col-span-2">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Sales Performance</h2>
                    <div class="flex space-x-2">
                        <button id="chart-daily" class="px-3 py-1 text-xs font-medium rounded-md bg-blue-100 text-blue-800 ">Daily</button>
                        <button id="chart-weekly" class="px-3 py-1 text-xs font-medium rounded-md text-gray-500 hover:bg-gray-50">Weekly</button>
                        <button id="chart-monthly" class="hidden px-3 py-1 text-xs font-medium rounded-md text-gray-500 hover:bg-gray-50">Monthly</button>
                    </div>
                </div>
                <div class="relative w-full h-80">
                    <canvas id="salesChart" class="w-full h-full"></canvas>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Top Products</h2>
                <div id="top-products" class="space-y-4">
                    <!-- Top products will be populated here -->
                </div>
            </div>
        </div>

        <!-- Sales Table -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Recent Orders</h2>
                <a href="{{ route('orders.list') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">View All</a>
            </div>
            <div class="overflow-x-auto bg-white shadow-md rounded-lg border border-gray-200">
                @php
                    $recent_header_table = ['Order ID', 'Customer', 'Amount', 'Payment', 'Date', 'Status'];
                @endphp
                <table class="min-w-full table-auto">
                    <thead class="bg-indigo-100 text-gray-700">
                        <tr>
                            @foreach ($recent_header_table as $header)
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ $header }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody id="recent-sales-body" class="divide-y divide-gray-200">
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                <div class="text-sm text-gray-500" id="pagination-info">Showing <span class="font-medium">1</span> to <span class="font-medium">5</span> of <span class="font-medium">0</span> results</div>
                <div class="flex space-x-2">
                    <button id="prev-page" class="cursor-pointer px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50" disabled>Previous</button>
                    <button id="next-page" class="cursor-pointer px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 disabled:opacity-50" disabled>Next</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        // Professional color palette
        const colors = {
            primary: {
                50: '#f0f9ff',
                100: '#e0f2fe',
                200: '#bae6fd',
                300: '#7dd3fc',
                400: '#38bdf8',
                500: '#0ea5e9',
                600: '#0284c7',
                700: '#0369a1',
                800: '#075985',
                900: '#0c4a6e',
            },
            gray: {
                50: '#f9fafb',
                100: '#f3f4f6',
                200: '#e5e7eb',
                300: '#d1d5db',
                400: '#9ca3af',
                500: '#6b7280',
                600: '#4b5563',
                700: '#374151',
                800: '#1f2937',
                900: '#111827',
            }
        };

        function showLoader() {
            document.getElementById('loader').classList.remove('hidden');
        }

        function hideLoader() {
            document.getElementById('loader').classList.add('hidden');
        }

        function showError(message) {
            Toastify({
                text: message,
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#ef4444",
                stopOnFocus: true,
            }).showToast();
        }

        function getStatusClass(status) {
            let statusClass;
            if (status === 'Pending') {
                statusClass = 'bg-orange-100 text-orange-600';
            } else if (status === 'Confirmed') {
                statusClass = 'bg-green-100 text-green-600';
            } else if (status === 'Processing') {
                statusClass = 'bg-blue-100 text-blue-800';
            } else if (status === 'Shipped') {
                statusClass = 'bg-purple-100 text-purple-800';
            } else if (status === 'Delivered') {
                statusClass = 'bg-green-100 text-green-800';
            } else if (status === 'Cancelled') {
                statusClass = 'bg-red-100 text-red-800';
            } else {
                statusClass = 'bg-gray-100 text-gray-800';
            }
            return statusClass;
        }

        function getQueryParams() {
            const sellerId = document.getElementById('seller-filter')?.value || '';
            const period = document.getElementById('period-filter').value;
            let params = sellerId ? `?seller_id=${sellerId}` : '';
            params += params ? `&period=${period}` : `?period=${period}`;
            return params;
        }

        async function fetchJsonData(url) {
            try {
                const response = await fetch(url, {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                const data = await response.json();
                console.log('API Response:', url, data);
                if (data.status !== 'success') {
                    throw new Error(data.message || 'API request failed');
                }
                return data;
            } catch (error) {
                console.error('Fetch Error:', error);
                showError(error.message);
                throw error;
            }
        }

        document.addEventListener('DOMContentLoaded', async () => {
            showLoader();

            try {
                const periodFilter = document.getElementById('period-filter');
                const sellerFilter = document.getElementById('seller-filter');
                const chartButtons = {
                    monthly: document.getElementById('chart-monthly'),
                    weekly: document.getElementById('chart-weekly'),
                    daily: document.getElementById('chart-daily')
                };
                let currentPage = 1;
                let chartPeriod = 'daily';

                function updateChartButtons(activePeriod) {
                    Object.keys(chartButtons).forEach(period => {
                        chartButtons[period].classList.toggle('bg-blue-100', period === activePeriod);
                        chartButtons[period].classList.toggle('text-blue-800', period === activePeriod);
                        chartButtons[period].classList.toggle('text-gray-500', period !== activePeriod);
                        chartButtons[period].classList.toggle('hover:bg-gray-50', period !== activePeriod);
                    });
                }

                periodFilter.addEventListener('change', async () => {
                    showLoader();
                    try {
                        await Promise.all([
                            loadOverview(getQueryParams()),
                            loadSalesChart(`${getQueryParams()}&period=${chartPeriod}`),
                            loadTopProducts(getQueryParams()),
                            loadRecentSales(getQueryParams(), currentPage)
                        ]);
                    } finally {
                        hideLoader();
                    }
                });

                if (sellerFilter) {
                    sellerFilter.addEventListener('change', async () => {
                        showLoader();
                        try {
                            await Promise.all([
                                loadOverview(getQueryParams()),
                                loadSalesChart(`${getQueryParams()}&period=${chartPeriod}`),
                                loadTopProducts(getQueryParams()),
                                loadRecentSales(getQueryParams(), currentPage)
                            ]);
                        } finally {
                            hideLoader();
                        }
                    });
                }

                Object.keys(chartButtons).forEach(period => {
                    chartButtons[period].addEventListener('click', async () => {
                        chartPeriod = period;
                        updateChartButtons(period);
                        showLoader();
                        try {
                            await loadSalesChart(`${getQueryParams()}&period=${chartPeriod}`);
                        } finally {
                            hideLoader();
                        }
                    });
                });

                document.getElementById('prev-page').addEventListener('click', async () => {
                    if (currentPage > 1) {
                        currentPage--;
                        showLoader();
                        try {
                            await loadRecentSales(getQueryParams(), currentPage);
                        } finally {
                            hideLoader();
                        }
                    }
                });

                document.getElementById('next-page').addEventListener('click', async () => {
                    currentPage++;
                    showLoader();
                    try {
                        await loadRecentSales(getQueryParams(), currentPage);
                    } finally {
                        hideLoader();
                    }
                });

                await Promise.all([
                    loadOverview(getQueryParams()),
                    loadSalesChart(`${getQueryParams()}&period=${chartPeriod}`),
                    loadTopProducts(getQueryParams()),
                    loadRecentSales(getQueryParams(), currentPage)
                ]);
            } catch (error) {
                console.error('Error loading dashboard:', error);
            } finally {
                hideLoader();
            }
        });

        async function loadRecentSales(params = '', page = 1) {
            try {
                const { data } = await fetchJsonData(`/api/admin/orders/recent${params}&page=${page}`);
                const tbody = document.getElementById('recent-sales-body');
                tbody.innerHTML = '';

                if (data.orders.length) {
                    data.orders.forEach((order, index) => {
                        const row = document.createElement('tr');
                        row.className = `${index%2 == 1 ? 'bg-white' : 'bg-gray-50'} hover:bg-indigo-50`;
                        row.innerHTML = `
                            <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium text-gray-900">${order.order_id}</td>
                            <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-500">${order.customer}</td>
                            <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-500">₹${order.amount.toLocaleString('en-IN', { minimumFractionDigits: 2 })}</td>
                            <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-500">${order.payment_method}</td>
                            <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-500">${new Date(order.date).toLocaleDateString('en-IN')}</td>
                            <td class="px-2 py-4 whitespace-nowrap text-center">
                                <span class="px-6 py-1 inline-flex text-xs leading-5 font-semibold rounded-full ${getStatusClass(order.status)}">${order.status}</span>
                            </td>
                        `;
                        tbody.appendChild(row);
                    });
                } else {
                    const row = document.createElement('tr');
                    row.className = `bg-white hover:bg-indigo-50`;
                    row.innerHTML = `
                        <td colspan="6" class="px-4 py-4 text-center text-sm text-gray-500">
                            No Order found.
                        </td>
                    `;
                    tbody.appendChild(row);
                }

                const paginationInfo = document.getElementById('pagination-info');
                paginationInfo.innerHTML = `Showing <span class="font-medium">${(data.page - 1) * data.per_page + 1}</span> to <span class="font-medium">${Math.min(data.page * data.per_page, data.total)}</span> of <span class="font-medium">${data.total}</span> results`;

                document.getElementById('prev-page').disabled = data.page === 1;
                document.getElementById('next-page').disabled = data.page * data.per_page >= data.total;
            } catch (error) {
                console.error('Error loading recent sales:', error);
            }
        }

        function formatChange(value, isPercentage = false) {
            const prefix = value >= 0 ? '+' : '';
            const color = value >= 0 ? 'text-green-600' : 'text-red-600';
            const icon = value >= 0
                ? `<svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>`
                : `<svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" /></svg>`;
            const formattedValue = isPercentage
                ? `${prefix}${value.toFixed(1)}%`
                : `₹${Math.abs(value).toLocaleString('en-IN')}`;
            return `<span class="${color} flex items-center">${icon}${formattedValue} from last period</span>`;
        }

        async function loadOverview(params = '') {
            try {
                const { data } = await fetchJsonData(`/api/admin/sales/overview${params}`);
                document.getElementById('total-sales').textContent = `₹${data.total_sales.toLocaleString('en-IN', { minimumFractionDigits: 2 })}`;
                document.getElementById('total-sales-change').innerHTML = formatChange(data.total_sales_change, true);
                document.getElementById('order-count').textContent = data.order_count.toLocaleString('en-IN');
                document.getElementById('order-count-change').innerHTML = formatChange(data.order_count_change, true);
                document.getElementById('avg-order-value').textContent = `₹${data.avg_order_value.toLocaleString('en-IN', { minimumFractionDigits: 2 })}`;
                document.getElementById('avg-order-change').innerHTML = formatChange(data.avg_order_change, true);
                // document.getElementById('conversion-rate').textContent = `${data.conversion_rate.toFixed(1)}%`;
                // document.getElementById('conversion-rate-change').innerHTML = formatChange(data.conversion_rate_change, true);
            } catch (error) {
                console.error('Error loading overview:', error);
            }
        }

        async function loadSalesChart(params = '') {
            try {
                const { data } = await fetchJsonData(`/api/admin/sales/over-time${params}`);
                const salesCtx = document.getElementById('salesChart').getContext('2d');

                if (window.salesChartInstance) {
                    window.salesChartInstance.destroy();
                }

                window.salesChartInstance = new Chart(salesCtx, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Sales (₹)',
                            data: data.sales,
                            borderColor: colors.primary[600],
                            backgroundColor: colors.primary[50],
                            fill: true,
                            tension: 0.3,
                            borderWidth: 2,
                            pointBackgroundColor: colors.primary[600],
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            pointHitRadius: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    color: colors.gray[700],
                                    font: {
                                        family: "'Inter', sans-serif",
                                        size: 13
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: colors.gray[800],
                                titleColor: 'white',
                                bodyColor: 'white',
                                borderColor: colors.gray[600],
                                borderWidth: 1,
                                padding: 12,
                                usePointStyle: true,
                                callbacks: {
                                    label: function (context) {
                                        return ` ₹${context.raw.toLocaleString('en-IN')}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: colors.gray[500]
                                }
                            },
                            y: {
                                grid: {
                                    color: colors.gray[100]
                                },
                                ticks: {
                                    color: colors.gray[500],
                                    callback: function (value) {
                                        return '₹' + value.toLocaleString('en-IN');
                                    }
                                }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        }
                    }
                });
            } catch (error) {
                console.error('Error loading sales chart:', error);
            }
        }

        async function loadTopProducts(params = '') {
            try {
                const { data } = await fetchJsonData(`/api/admin/sales/top-products${params}`);
                const container = document.getElementById('top-products');
                container.innerHTML = '';
                const icons = [
                    { color: 'indigo', path: 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4' },
                    { color: 'blue', path: 'M9 5l7 7-7 7' },
                    { color: 'green', path: 'M13 10V3L4 14h7v7l9-11h-7z' },
                    { color: 'purple', path: 'M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4' }
                ];

                data.forEach((product, index) => {
                    const icon = icons[index % icons.length];
                    const div = document.createElement('div');
                    div.className = 'flex items-start';
                    div.innerHTML = `
                        <div class="bg-${icon.color}-100 p-2 rounded-lg mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-${icon.color}-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${icon.path}" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-medium text-gray-900">${product.name}</h3>
                            <p class="text-xs text-gray-500">${product.percentage.toFixed(1)}% of total sales</p>
                            <div class="mt-1 w-full bg-gray-200 rounded-full h-1.5">
                                <div class="bg-${icon.color}-600 h-1.5 rounded-full" style="width: ${product.percentage}%"></div>
                            </div>
                        </div>
                        <span class="text-sm font-medium text-gray-900">₹${product.amount.toLocaleString('en-IN')}</span>
                    `;
                    container.appendChild(div);
                });
            } catch (error) {
                console.error('Error loading top products:', error);
            }
        }        
    </script>
@endsection