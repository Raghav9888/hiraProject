<h1 style="text-transform: capitalize;" class="home-title mb-5">Welcome,<span
                            style="color: #ba9b8b;">{{ $user->first_name ?? 'User' }}  {{ $user->last_name ?? '' }}</span>
                </h1>
                <div class="col-sm-12 col-lg-5"></div>
                
<ul class="practitioner-profile-btns">
                    <li class="active">
                        <a href="{{ route('myprofile') }}">
                            My Profile
                        </a>
                    </li>
                    <li class="offering">
                        <a href="{{ route('offering') }}">
                            Offering
                        </a>
                        <div class="dropdown">
                            <a href="{{ route('discount') }}">
                                Discount
                            </a>
                        </div>
                    </li>
                    <li>
                        <a href="{{ route('appoinement') }}">
                            Appointment
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('calendar') }}">
                            Calendar
                        </a>
                    </li>
                    <li class="offering">
                        <a href="">
                            Accounting
                        </a>
                        <div class="dropdown">
                            <a href="{{ route('myprofile') }}">
                                Earnings
                            </a>
                            <a href="/refund-request.html">
                                Refund request
                            </a>
                        </div>
                    </li>
                </ul>