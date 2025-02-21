@extends('layouts.app')
@section('content')
    <section class="practitioner-profile">
        <div class="container">
            @include('layouts.partitioner_sidebar')
            <div class="row">
                @include('layouts.partitioner_nav')
                <div class="earning-wrrpr mt-5">
                    <div class="container">
                        <div class="row mb-5">
                            <div class="col-sm-12 col-md-9 col-lg-9">
                                <label class="d-block" for="start-date">Start Date</label>
                                <div class="d-flex mb-4">
                                    <input type="date">
                                    <button class="update-btn">Update</button>
                                </div>
                                <label class="d-block" for="end-date">End Date</label>
                                <div class="d-flex ">
                                    <input type="date">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3 col-lg-3">
                                <button class="export-btn">Export Earning</button>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="earnings-section">
                                <h2>Earnings Due</h2>
                                <table>
                                    <tbody>
                                    <tr class="border-bottom">
                                        <td>Offerings</td>
                                        <td>$0.00</td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td>Tax</td>
                                        <td>$0.00</td>
                                    </tr>
                                    <tr>
                                        <td class="font-semibold">Totals</td>
                                        <td>$0.00</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="earnings-section">
                                <h2>Earnings paid</h2>
                                <table>
                                    <tbody>
                                    <tr class="border-bottom">
                                        <td>Offerings</td>
                                        <td>$0.00</td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td>Tax</td>
                                        <td>$0.00</td>
                                    </tr>
                                    <tr>
                                        <td class="font-semibold">Totals</td>
                                        <td>$0.00</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="earnings-section">
                        <h2>Gross Sales Report</h2>
                        <table>
                            <tbody>
                            <tr class="border-bottom">
                                <td>Total Order</td>
                                <td>0</td>
                            </tr>
                            <tr class="border-bottom">
                                <td>Total Product Sold</td>
                                <td>0</td>
                            </tr>
                            <tr class="border-bottom">
                                <td>Total Gross Sales</td>
                                <td>$0.00</td>
                            </tr>
                            <tr class="border-bottom">
                                <td>Total Earning</td>
                                <td>$0.00</td>
                            </tr>
                            <tr>
                                <td>Net REvenue</td>
                                <td>$0.00</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="earnings-section w-100">
                        <h2>Booking Total (0)</h2>
                        <p style="text-align: start;">No orders for this period. Adjust your dates above andd click updates,
                            or list new products for customers to buy</p>
                    </div>
                    <div class="earnings-section w-100">
                        <h2>Total (0)</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
