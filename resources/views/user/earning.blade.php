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
                                    <button class="update-btn">Clear</button>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3 col-lg-3">
                                <button class="export-btn">Export Earning</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">Order ID</th>
                                    <th scope="col">Offerings</th>
                                    <th scope="col">Earnings</th>
                                    <th scope="col">Shipped</th>
                                    <th scope="col">Order Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>#9720</td>
                                    <td>1 x <strong>Test my offer</strong></td>
                                    <td>$0.00</td>
                                    <td>No</td>
                                    <td>January 29, 2025</td>
                                </tr>
                                <tr>
                                    <td>#9716</td>
                                    <td>1 x <strong>Test my offer</strong></td>
                                    <td>$0.00</td>
                                    <td>No</td>
                                    <td>January 28, 2025</td>
                                </tr>
                                <tr>
                                    <td>#9710</td>
                                    <td>1 x <strong>Test my offer</strong></td>
                                    <td>$0.00</td>
                                    <td>No</td>
                                    <td>January 28, 2025</td>
                                </tr>
                                <tr>
                                    <td>#9705</td>
                                    <td>1 x <strong>Test my offer</strong></td>
                                    <td>$0.00</td>
                                    <td>No</td>
                                    <td>January 27, 2025</td>
                                </tr>
                                <tr>
                                    <td>#9702</td>
                                    <td>1 x <strong>Test my offer</strong></td>
                                    <td>$0.00</td>
                                    <td>No</td>
                                    <td>January 26, 2025</td>
                                </tr>
                                <tr>
                                    <td>#9699</td>
                                    <td>1 x <strong>Test my offer</strong></td>
                                    <td>$0.00</td>
                                    <td>NA</td>
                                    <td>January 26, 2025</td>
                                </tr>
                                <tr>
                                    <td>#9696</td>
                                    <td>1 x <strong>Test my offer</strong></td>
                                    <td>$0.00</td>
                                    <td>No</td>
                                    <td>January 26, 2025</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="noteModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h3>Add Note</h3>
                        <p id="selectedDate"></p>
                        <label for="time">Select Time:</label>
                        <input type="time" id="time" required>
                        <label for="note">Note:</label>
                        <textarea id="note" rows="2" placeholder="Enter your note..."></textarea>
                        <button id="saveNote">Save Note</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
