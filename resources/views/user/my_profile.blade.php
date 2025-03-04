@extends('layouts.app')

@section('content')

    <section class="practitioner-profile">
        <div class="container">
            @include('layouts.partitioner_sidebar')
            <div class="row">
                @include('layouts.partitioner_nav')
                <div class="add-offering-dv">
                    <div class="container">
                        <div class="mb-4 mt-4">
                            <ul class="nav nav-tabs" id="tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="general-tab" data-bs-toggle="tab" href="#general"
                                       role="tab" aria-controls="general" aria-selected="true">My Profile</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="availability-tab" data-bs-toggle="tab" href="#availability"
                                       role="tab" aria-controls="availability" aria-selected="false">My Payment
                                        Integration</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="costs-tab" data-bs-toggle="tab" href="#costs" role="tab"
                                       aria-controls="costs" aria-selected="false">My Calendar Integration</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="clint-tab" data-bs-toggle="tab" href="#client" role="tab"
                                       aria-controls="client" aria-selected="false">Client Policy</a>
                                </li>
                            </ul>
                            <div class="tab-content mt-3" id="myTabContent">
                                <!-- General Tab Content -->
                                <div class="tab-pane fade show active" id="general" role="tabpanel"
                                     aria-labelledby="general-tab">

                                    <form method="post" action="{{ route('update_profile') }}"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <div style="position: relative;"
                                             class="d-flex justify-content-center flex-column align-items-center">
                                            <div class="mb-4" id="imageDiv">
                                                <p style="text-align: start;" class="text">Image</p>
                                                <input type="file" id="fileInput" name="image" class="hidden"
                                                       accept="image/*"
                                                       onchange="previewImage(event)" style="display: none;">

                                                @if(isset($image))
                                                    @php
                                                        $imageUrl = asset(env('media_path') . '/practitioners/' . $userDetails->id . '/profile/' . $image);
                                                    @endphp
                                                    <label class="image-preview" id="imagePreview"
                                                           style="border-radius: 50%; background-image: url('{{$imageUrl}}'); background-size: cover; background-position: center center;">
                                                        <i class="fas fa-trash text-danger fs-3"
                                                           data-image="{{ $image }}"
                                                           data-user-id="{{ $userDetails->id }}"
                                                           data-profile-image="true"
                                                           onclick="removeImage(this);" style="cursor: pointer;"></i>
                                                    </label>
                                                @else
                                                    <label onclick="document.getElementById('fileInput').click();"
                                                           class="image-preview" id="imagePreview"
                                                           style="border-radius: 50%;">
                                                        <span>+</span>
                                                    </label>

                                                @endif

                                                <div class="preview-div">
                                                    <img src="{{ url('/assets/images/Laptop.svg') }}" alt="">
                                                    <p>preview</p>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 col-lg-6 mb-3">
                                                <label for="first_name">First Name</label>
                                                <input type="text" class="form-control" id="first_name"
                                                       name="first_name"
                                                       value="{{ $user->first_name ?? '' }}">
                                                <input type="hidden" class="form-control" id="id" name="id"
                                                       value="{{ $user->id ?? '' }}">
                                            </div>
                                            <div class="col-sm-12 col-lg-6 mb-3">
                                                <label for="last_name">Last Name</label>
                                                <input type="text" class="form-control" id="last_name" name="last_name"
                                                       value="{{ $user->last_name ?? '' }}">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="company_name">Company Name</label>
                                            <input type="text" class="form-control" id="company" name="company"
                                                   value="{{ $userDetails->company ?? '' }}">
                                            <p style="text-align: start;">Your shop name is public and must be
                                                unique.</p>
                                        </div>

                                        <div class="mb-3">
                                            <label for="bio">Short Bio</label>
                                            <textarea class="form-control" id="bio"
                                                      name="bio">{{ $userDetails->bio ?? '' }}</textarea>
                                        </div>

                                        <div class="mb-4">
                                            <label for="location">Location</label>
                                            <select name="location[]" multiple="multiple" class="form-control select2">
                                                <option class="level-0"
                                                        value="370" {{ in_array('370', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Montreal
                                                </option>
                                                <option class="level-0"
                                                        value="386" {{ in_array('386', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Austin
                                                </option>
                                                <option class="level-0"
                                                        value="891" {{ in_array('891', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Mississauga, ON
                                                </option>
                                                <option class="level-0"
                                                        value="907" {{ in_array('907', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Regina, SK
                                                </option>
                                                <option class="level-0"
                                                        value="923" {{ in_array('923', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Whitby, ON
                                                </option>
                                                <option class="level-0"
                                                        value="939" {{ in_array('939', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Red Deer, AB
                                                </option>
                                                <option class="level-0"
                                                        value="955" {{ in_array('955', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Prince George, BC
                                                </option>
                                                <option class="level-0"
                                                        value="971" {{ in_array('971', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Aurora, ON
                                                </option>
                                                <option class="level-0"
                                                        value="987" {{ in_array('987', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Rimouski, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1003" {{ in_array('1003', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Salaberry-de-Valleyfield, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1019" {{ in_array('1019', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Orangeville, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1035" {{ in_array('1035', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Alma, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1051" {{ in_array('1051', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    La Prairie, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1067" {{ in_array('1067', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Amherstburg, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1083" {{ in_array('1083', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Uxbridge, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1099" {{ in_array('1099', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Augustin-de-Desmaures, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1115" {{ in_array('1115', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Middlesex Centre, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1131" {{ in_array('1131', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Central Saanich, BC
                                                </option>
                                                <option class="level-0"
                                                        value="1147" {{ in_array('1147', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Greater Napanee, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1163" {{ in_array('1163', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    St. Clair, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1179" {{ in_array('1179', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Grand Falls, NL
                                                </option>
                                                <option class="level-0"
                                                        value="1195" {{ in_array('1195', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    South Glengarry, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1211" {{ in_array('1211', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    North Saanich, BC
                                                </option>
                                                <option class="level-0"
                                                        value="1227" {{ in_array('1227', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Brock, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1243" {{ in_array('1243', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Ladysmith, BC
                                                </option>
                                                <option class="level-0"
                                                        value="1259" {{ in_array('1259', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Rawdon, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1275" {{ in_array('1275', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Castlegar, BC
                                                </option>
                                                <option class="level-0"
                                                        value="1291" {{ in_array('1291', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Smiths Falls, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1307" {{ in_array('1307', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Labrador City, NL
                                                </option>
                                                <option class="level-0"
                                                        value="1323" {{ in_array('1323', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Shediac, NB
                                                </option>
                                                <option class="level-0"
                                                        value="1339" {{ in_array('1339', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Zorra, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1355" {{ in_array('1355', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Innisfail, AB
                                                </option>
                                                <option class="level-0"
                                                        value="1371" {{ in_array('1371', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Philippe, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1387" {{ in_array('1387', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Drayton Valley, AB
                                                </option>
                                                <option class="level-0"
                                                        value="1403" {{ in_array('1403', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Whitewater Region, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1419" {{ in_array('1419', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Rocky Mountain House, AB
                                                </option>
                                                <option class="level-0"
                                                        value="1435" {{ in_array('1435', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Kent, BC
                                                </option>
                                                <option class="level-0"
                                                        value="1451" {{ in_array('1451', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Niverville, MB
                                                </option>
                                                <option class="level-0"
                                                        value="1467" {{ in_array('1467', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Princeville, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1483" {{ in_array('1483', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Ashfield-Colborne-Wawanosh, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1499" {{ in_array('1499', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Didsbury, AB
                                                </option>

                                                <option class="level-0"
                                                        value="1515" {{ in_array('1515', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Stonewall, MB
                                                </option>
                                                <option class="level-0"
                                                        value="1531" {{ in_array('1531', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Southwold, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1547" {{ in_array('1547', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Kindersley, SK
                                                </option>
                                                <option class="level-0"
                                                        value="1563" {{ in_array('1563', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Vanderhoof, BC
                                                </option>
                                                <option class="level-0"
                                                        value="1579" {{ in_array('1579', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Altona, MB
                                                </option>
                                                <option class="level-0"
                                                        value="1595" {{ in_array('1595', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Carstairs, AB
                                                </option>
                                                <option class="level-0"
                                                        value="1611" {{ in_array('1611', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Raymond, AB
                                                </option>
                                                <option class="level-0"
                                                        value="1627" {{ in_array('1627', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    East Angus, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1643" {{ in_array('1643', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Fruitvale, BC
                                                </option>
                                                <option class="level-0"
                                                        value="1659" {{ in_array('1659', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Havre-Saint-Pierre, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1675" {{ in_array('1675', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Sainte-Anne-des-Lacs, QC
                                                </option>

                                                <option class="level-0"
                                                        value="1691" {{ in_array('1691', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Forestville, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1707" {{ in_array('1707', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Portneuf, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1723" {{ in_array('1723', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Mont-Saint-Gregoire, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1739" {{ in_array('1739', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Adelaide-Metcalfe, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1755" {{ in_array('1755', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    North Algona Wilberforce, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1771" {{ in_array('1771', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Princeton, BC
                                                </option>
                                                <option class="level-0"
                                                        value="1787" {{ in_array('1787', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Kuujjuaq, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1803" {{ in_array('1803', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Black Diamond, AB
                                                </option>
                                                <option class="level-0"
                                                        value="1819" {{ in_array('1819', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Notre-Dame-de-Lourdes, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1835" {{ in_array('1835', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Damase, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1851" {{ in_array('1851', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Sainte-Catherine-de-Hatley, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1867" {{ in_array('1867', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Victor, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1883" {{ in_array('1883', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Sainte-Genevieve-de-Berthier, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1899" {{ in_array('1899', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Burin, NL
                                                </option>

                                                <option class="level-0"
                                                        value="1915" {{ in_array('1915', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Maskinonge, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1931" {{ in_array('1931', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Twillingate, NL
                                                </option>
                                                <option class="level-0"
                                                        value="1947" {{ in_array('1947', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Bernard, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1963" {{ in_array('1963', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Glovertown, NL
                                                </option>
                                                <option class="level-0"
                                                        value="1979" {{ in_array('1979', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Mandeville, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1995" {{ in_array('1995', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Lorne, MB
                                                </option>
                                                <option class="level-0"
                                                        value="2011" {{ in_array('2011', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Glenboro-South Cypress, MB
                                                </option>
                                                <option class="level-0"
                                                        value="2027" {{ in_array('2027', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    One Hundred Mile House, BC
                                                </option>
                                                <option class="level-0"
                                                        value="2043" {{ in_array('2043', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Vallee-Jonction, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2059" {{ in_array('2059', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Lac-Superieur, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2075" {{ in_array('2075', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Sainte-Beatrix, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2091" {{ in_array('2091', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Champlain, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2107" {{ in_array('2107', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Pointe-des-Cascades, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2123" {{ in_array('2123', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Warfield, BC
                                                </option>
                                                <option class="level-0"
                                                        value="2139" {{ in_array('2139', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Notre-Dame-du-Bon-Conseil, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2155" {{ in_array('2155', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Rosedale, MB
                                                </option>

                                                <option class="level-0"
                                                        value="2171" {{ in_array('2171', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Sainte-Helene-de-Bagot, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2187" {{ in_array('2187', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Cleveland, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2203" {{ in_array('2203', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Lambton, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2219" {{ in_array('2219', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Guillaume, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2235" {{ in_array('2235', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Langham, SK
                                                </option>
                                                <option class="level-0"
                                                        value="2251" {{ in_array('2251', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Salluit, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2267" {{ in_array('2267', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Odilon-de-Cranbourne, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2283" {{ in_array('2283', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Scott, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2299" {{ in_array('2299', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Lions Bay, BC
                                                </option>
                                                <option class="level-0"
                                                        value="2315" {{ in_array('2315', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Upham, NB
                                                </option>
                                                <option class="level-0"
                                                        value="2331" {{ in_array('2331', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Smooth Rock Falls, ON
                                                </option>

                                                <option class="level-0"
                                                        value="2347" {{ in_array('2347', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Edouard, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2363" {{ in_array('2363', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Sainte-Anne-du-Sault, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2379" {{ in_array('2379', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Roxton Falls, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2395" {{ in_array('2395', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    St. Joseph, ON
                                                </option>
                                                <option class="level-0"
                                                        value="2411" {{ in_array('2411', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    L'Anse-Saint-Jean, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2427" {{ in_array('2427', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Kaleden, BC
                                                </option>
                                                <option class="level-0"
                                                        value="2443" {{ in_array('2443', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Joachim-de-Shefford, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2459" {{ in_array('2459', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Centreville-Wareham-Trinity, NL
                                                </option>
                                                <option class="level-0"
                                                        value="2475" {{ in_array('2475', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Hensall, ON
                                                </option>
                                                <option class="level-0"
                                                        value="2491" {{ in_array('2491', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Waldheim, SK
                                                </option>
                                                <option class="level-0"
                                                        value="2507" {{ in_array('2507', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    South Algonquin, ON
                                                </option>
                                                <option class="level-0"
                                                        value="2523" {{ in_array('2523', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Durham, NB
                                                </option>
                                                <option class="level-0"
                                                        value="2539" {{ in_array('2539', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Havelock, NB
                                                </option>

                                                <option class="level-0"
                                                        value="2555" {{ in_array('2555', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    La Macaza, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2571" {{ in_array('2571', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Argyle, MB
                                                </option>
                                                <option class="level-0"
                                                        value="2587" {{ in_array('2587', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Oyen, AB
                                                </option>
                                                <option class="level-0"
                                                        value="2603" {{ in_array('2603', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Gillam, MB
                                                </option>
                                                <option class="level-0"
                                                        value="3042" {{ in_array('3042', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    BC
                                                </option>
                                                <option class="level-0"
                                                        value="116" {{ in_array('116', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Victoria, BC
                                                </option>
                                                <option class="level-0"
                                                        value="371" {{ in_array('371', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Ottawa
                                                </option>
                                                <option class="level-0"
                                                        value="387" {{ in_array('387', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Jacksonville
                                                </option>
                                                <option class="level-0"
                                                        value="892" {{ in_array('892', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Brampton, ON
                                                </option>
                                                <option class="level-0"
                                                        value="908" {{ in_array('908', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Oakville, ON
                                                </option>
                                                <option class="level-0"
                                                        value="924" {{ in_array('924', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Cambridge, ON
                                                </option>
                                                <option class="level-0"
                                                        value="940" {{ in_array('940', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Pickering, ON
                                                </option>
                                                <option class="level-0"
                                                        value="956" {{ in_array('956', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Caledon, ON
                                                </option>
                                                <option class="level-0"
                                                        value="972" {{ in_array('972', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Port Coquitlam, BC
                                                </option>
                                                <option class="level-0"
                                                        value="988" {{ in_array('988', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Courtenay, BC
                                                </option>
                                                <option class="level-0"
                                                        value="1004" {{ in_array('1004', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Rouyn-Noranda, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1020" {{ in_array('1020', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Leduc, AB
                                                </option>
                                                <option class="level-0"
                                                        value="1036" {{ in_array('1036', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Sainte-Julie, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1052" {{ in_array('1052', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Bruno-de-Montarville, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1068" {{ in_array('1068', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    L'Assomption, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1084" {{ in_array('1084', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Fort St. John, BC
                                                </option>

                                                <option class="level-0"
                                                        value="1100" {{ in_array('1100', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Huntsville, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1116" {{ in_array('1116', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Mont-Saint-Hilaire, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1132" {{ in_array('1132', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Sainte-Catherine, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1148" {{ in_array('1148', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Lake Country, BC
                                                </option>
                                                <option class="level-0"
                                                        value="1164" {{ in_array('1164', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Terrace, BC
                                                </option>
                                                <option class="level-0"
                                                        value="1180" {{ in_array('1180', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    North Battleford, SK
                                                </option>
                                                <option class="level-0"
                                                        value="1196" {{ in_array('1196', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Sainte-Marie, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1212" {{ in_array('1212', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Prevost, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1228" {{ in_array('1228', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    L'Ile-Perrot, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1244" {{ in_array('1244', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Coldstream, BC
                                                </option>
                                                <option class="level-0"
                                                        value="1260" {{ in_array('1260', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Morinville, AB
                                                </option>
                                                <option class="level-0"
                                                        value="1276" {{ in_array('1276', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Cavan Monaghan, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1292" {{ in_array('1292', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Lorraine, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1308" {{ in_array('1308', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Shelburne, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1324" {{ in_array('1324', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Otterburn Park, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1340" {{ in_array('1340', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Kitimat, BC
                                                </option>
                                                <option class="level-0"
                                                        value="1356" {{ in_array('1356', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Nicolet, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1372" {{ in_array('1372', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    McNab/Braeside, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1388" {{ in_array('1388', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Ponoka, AB
                                                </option>
                                                <option class="level-0"
                                                        value="1404" {{ in_array('1404', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Edwardsburgh/Cardinal, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1420" {{ in_array('1420', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Muskoka Falls, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1436" {{ in_array('1436', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Clarenville, NL
                                                </option>
                                                <option class="level-0"
                                                        value="1452" {{ in_array('1452', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    McMasterville, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1468" {{ in_array('1468', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Cesaire, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1484" {{ in_array('1484', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Trent Lakes, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1500" {{ in_array('1500', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Deer Lake, NL
                                                </option>
                                                <option class="level-0"
                                                        value="1516" {{ in_array('1516', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Memramcook, NB
                                                </option>
                                                <option class="level-0"
                                                        value="1532" {{ in_array('1532', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Chertsey, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1548" {{ in_array('1548', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Denis-de-Brompton, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1564" {{ in_array('1564', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Chateau-Richer, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1580" {{ in_array('1580', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Roxton Pond, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1596" {{ in_array('1596', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Danville, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1612" {{ in_array('1612', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Morin-Heights, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1628" {{ in_array('1628', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Rossland, BC
                                                </option>
                                                <option class="level-0"
                                                        value="1644" {{ in_array('1644', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Ambroise, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1660" {{ in_array('1660', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Anselme, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1676" {{ in_array('1676', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Sulpice, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1692" {{ in_array('1692', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Compton, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1708" {{ in_array('1708', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Pictou, NS
                                                </option>
                                                <option class="level-0"
                                                        value="1724" {{ in_array('1724', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Thurso, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1740" {{ in_array('1740', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Melancthon, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1756" {{ in_array('1756', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Errington, BC
                                                </option>
                                                <option class="level-0"
                                                        value="1772" {{ in_array('1772', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    La Loche, SK
                                                </option>
                                                <option class="level-0"
                                                        value="1788" {{ in_array('1788', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Atikokan, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1804" {{ in_array('1804', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Pamphile, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1820" {{ in_array('1820', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Ville-Marie, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1836" {{ in_array('1836', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Disraeli, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1852" {{ in_array('1852', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Basile, QC
                                                </option>

                                                <option class="level-0"
                                                        value="1868" {{ in_array('1868', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Sicamous, BC
                                                </option>
                                                <option class="level-0"
                                                        value="1884" {{ in_array('1884', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Logy Bay-Middle Cove-Outer Cove, NL
                                                </option>
                                                <option class="level-0"
                                                        value="1900" {{ in_array('1900', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Grand Bank, NL
                                                </option>
                                                <option class="level-0"
                                                        value="1916" {{ in_array('1916', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Charles-de-Bellechasse, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1932" {{ in_array('1932', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Quentin, NB
                                                </option>
                                                <option class="level-0"
                                                        value="1948" {{ in_array('1948', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Sainte-Cecile-de-Milton, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1964" {{ in_array('1964', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Tofield, AB
                                                </option>
                                                <option class="level-0"
                                                        value="1980" {{ in_array('1980', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Caplan, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1996" {{ in_array('1996', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Yellowhead, MB
                                                </option>
                                                <option class="level-0"
                                                        value="2012" {{ in_array('2012', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    North Norfolk, MB
                                                </option>
                                                <option class="level-0"
                                                        value="2028" {{ in_array('2028', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Liguori, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2044" {{ in_array('2044', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Manitouwadge, ON
                                                </option>
                                                <option class="level-0"
                                                        value="2060" {{ in_array('2060', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Les Escoumins, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2076" {{ in_array('2076', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Georges-de-Cacouna, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2092" {{ in_array('2092', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Sacre-Coeur-Saguenay, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2108" {{ in_array('2108', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Deseronto, ON
                                                </option>
                                                <option class="level-0"
                                                        value="2124" {{ in_array('2124', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Zacharie, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2140" {{ in_array('2140', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Fisher, MB
                                                </option>
                                                <option class="level-0"
                                                        value="2156" {{ in_array('2156', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Jacques-le-Mineur, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2172" {{ in_array('2172', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Franklin Centre, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2188" {{ in_array('2188', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Messines, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2204" {{ in_array('2204', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Flavien, QC
                                                </option>

                                                <option class="level-0"
                                                        value="2220" {{ in_array('2220', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Venise-en-Quebec, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2236" {{ in_array('2236', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    St. George, NB
                                                </option>
                                                <option class="level-0"
                                                        value="2252" {{ in_array('2252', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Pangnirtung, NU
                                                </option>
                                                <option class="level-0"
                                                        value="2268" {{ in_array('2268', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Pipestone, MB
                                                </option>
                                                <option class="level-0"
                                                        value="2284" {{ in_array('2284', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Godmanchester, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2300" {{ in_array('2300', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    New Carlisle, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2316" {{ in_array('2316', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    St.-Charles, ON
                                                </option>
                                                <option class="level-0"
                                                        value="2332" {{ in_array('2332', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Bruederheim, AB
                                                </option>
                                                <option class="level-0"
                                                        value="2348" {{ in_array('2348', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Charlo, NB
                                                </option>
                                                <option class="level-0"
                                                        value="2364" {{ in_array('2364', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    La Conception, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2380" {{ in_array('2380', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Montcalm, MB
                                                </option>
                                                <option class="level-0"
                                                        value="2396" {{ in_array('2396', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Queensbury, NB
                                                </option>
                                                <option class="level-0"
                                                        value="2412" {{ in_array('2412', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Moose Jaw No. 161, SK
                                                </option>
                                                <option class="level-0"
                                                        value="2428" {{ in_array('2428', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint James, NB
                                                </option>
                                                <option class="level-0"
                                                        value="2444" {{ in_array('2444', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Grand-Remous, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2460" {{ in_array('2460', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Alberton, PE
                                                </option>
                                                <option class="level-0"
                                                        value="2476" {{ in_array('2476', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Carnduff, SK
                                                </option>
                                                <option class="level-0"
                                                        value="2492" {{ in_array('2492', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    McKellar, ON
                                                </option>
                                                <option class="level-0"
                                                        value="2508" {{ in_array('2508', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Upton, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2524" {{ in_array('2524', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Sainte-Marthe, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2540" {{ in_array('2540', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Eston, SK
                                                </option>
                                                <option class="level-0"
                                                        value="2556" {{ in_array('2556', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Souris, PE
                                                </option>
                                                <option class="level-0"
                                                        value="2572" {{ in_array('2572', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Delisle, SK
                                                </option>
                                                <option class="level-0"
                                                        value="2588" {{ in_array('2588', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Gravelbourg, SK
                                                </option>
                                                <option class="level-0"
                                                        value="2604" {{ in_array('2604', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Grand View, MB
                                                </option>
                                                <option class="level-0"
                                                        value="3061" {{ in_array('3061', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Virtual
                                                </option>
                                                <option class="level-0"
                                                        value="117" {{ in_array('117', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Victoria, TX
                                                </option>
                                                <option class="level-0"
                                                        value="372" {{ in_array('372', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saskatoon
                                                </option>
                                                <option class="level-0"
                                                        value="388" {{ in_array('388', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    San Francisco
                                                </option>
                                                <option class="level-0"
                                                        value="893" {{ in_array('893', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Surrey, BC
                                                </option>
                                                <option class="level-0"
                                                        value="909" {{ in_array('909', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Richmond, BC
                                                </option>
                                                <option class="level-0"
                                                        value="925" {{ in_array('925', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Milton, ON
                                                </option>
                                                <option class="level-0"
                                                        value="941" {{ in_array('941', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Lethbridge, AB
                                                </option>
                                                <option class="level-0"
                                                        value="957" {{ in_array('957', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Chateauguay, QC
                                                </option>
                                                <option class="level-0"
                                                        value="973" {{ in_array('973', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Mirabel, QC
                                                </option>
                                                <option class="level-0"
                                                        value="989" {{ in_array('989', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Dollard-des-Ormeaux, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1005" {{ in_array('1005', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Boucherville, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1021" {{ in_array('1021', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Moose Jaw, SK
                                                </option>
                                                <option class="level-0"
                                                        value="1037" {{ in_array('1037', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Constant, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1053" {{ in_array('1053', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Midland, ON
                                                </option>

                                                <option class="level-0"
                                                        value="1069" {{ in_array('1069', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Tecumseh, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1085" {{ in_array('1085', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Wilmot, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1101" {{ in_array('1101', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Sainte-Marthe-sur-le-Lac, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1117" {{ in_array('1117', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Camrose, AB
                                                </option>
                                                <option class="level-0"
                                                        value="1133" {{ in_array('1133', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Port Hope, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1149" {{ in_array('1149', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Hanover, MB
                                                </option>
                                                <option class="level-0"
                                                        value="1165" {{ in_array('1165', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Mercier, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1181" {{ in_array('1181', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Mont-Laurier, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1197" {{ in_array('1197', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    North Perth, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1213" {{ in_array('1213', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Sainte-Adele, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1229" {{ in_array('1229', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Summerland, BC
                                                </option>
                                                <option class="level-0"
                                                        value="1245" {{ in_array('1245', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Georgian Bluffs, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1261" {{ in_array('1261', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Blackfalds, AB
                                                </option>
                                                <option class="level-0"
                                                        value="1277" {{ in_array('1277', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Morden, MB
                                                </option>
                                                <option class="level-0"
                                                        value="1293" {{ in_array('1293', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Ramara, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1309" {{ in_array('1309', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Stanley, MB
                                                </option>
                                                <option class="level-0"
                                                        value="1325" {{ in_array('1325', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Sainte-Brigitte-de-Laval, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1341" {{ in_array('1341', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Macdonald, MB
                                                </option>
                                                <option class="level-0"
                                                        value="1357" {{ in_array('1357', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Rockwood, MB
                                                </option>
                                                <option class="level-0"
                                                        value="1373" {{ in_array('1373', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Central Huron, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1389" {{ in_array('1389', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Southgate, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1405" {{ in_array('1405', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Sainte-Anne-des-Monts, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1421" {{ in_array('1421', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Cornwall, PE
                                                </option>
                                                <option class="level-0"
                                                        value="1437" {{ in_array('1437', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Mont-Joli, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1453" {{ in_array('1453', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Douglas, NB
                                                </option>
                                                <option class="level-0"
                                                        value="1469" {{ in_array('1469', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Tay Valley, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1485" {{ in_array('1485', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Northern Rockies, BC
                                                </option>
                                                <option class="level-0"
                                                        value="1501" {{ in_array('1501', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Woodstock, NB
                                                </option>
                                                <option class="level-0"
                                                        value="1517" {{ in_array('1517', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Sainte-Anne-de-Bellevue, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1533" {{ in_array('1533', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Shippagan, NB
                                                </option>
                                                <option class="level-0"
                                                        value="1549" {{ in_array('1549', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Jasper, AB
                                                </option>
                                                <option class="level-0"
                                                        value="1565" {{ in_array('1565', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint Stephen, NB
                                                </option>
                                                <option class="level-0"
                                                        value="1581" {{ in_array('1581', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Etienne-des-Gres, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1597" {{ in_array('1597', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Channel-Port aux Basques, NL
                                                </option>
                                                <option class="level-0"
                                                        value="1613" {{ in_array('1613', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Dundas, NB
                                                </option>
                                                <option class="level-0"
                                                        value="1629" {{ in_array('1629', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Mackenzie, BC
                                                </option>
                                                <option class="level-0"
                                                        value="1645" {{ in_array('1645', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Westville, NS
                                                </option>
                                                <option class="level-0"
                                                        value="1661" {{ in_array('1661', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Trois-Pistoles, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1677" {{ in_array('1677', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Penhold, AB
                                                </option>

                                                <option class="level-0"
                                                        value="1693" {{ in_array('1693', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Shuniah, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1709" {{ in_array('1709', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Tisdale, SK
                                                </option>
                                                <option class="level-0"
                                                        value="1725" {{ in_array('1725', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Wellington, NB
                                                </option>
                                                <option class="level-0"
                                                        value="1741" {{ in_array('1741', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Cap Sante, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1757" {{ in_array('1757', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Wawa, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1773" {{ in_array('1773', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Ferme-Neuve, QC
                                                </option>

                                                <option class="level-0"
                                                        value="1789" {{ in_array('1789', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Grenville-sur-la-Rouge, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1805" {{ in_array('1805', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Bedford, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1821" {{ in_array('1821', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Wickham, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1837" {{ in_array('1837', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Meadow Lake No. 588, SK
                                                </option>
                                                <option class="level-0"
                                                        value="1853" {{ in_array('1853', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Raphael, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1869" {{ in_array('1869', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Cap Pele, NB
                                                </option>
                                                <option class="level-0"
                                                        value="1885" {{ in_array('1885', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Buctouche, NB
                                                </option>
                                                <option class="level-0"
                                                        value="1901" {{ in_array('1901', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Waterville, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1917" {{ in_array('1917', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Fogo Island, NL
                                                </option>
                                                <option class="level-0"
                                                        value="1933" {{ in_array('1933', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Lebel-sur-Quevillon, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1949" {{ in_array('1949', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Roch-de-Richelieu, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1965" {{ in_array('1965', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Madoc, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1981" {{ in_array('1981', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Allardville, NB
                                                </option>
                                                <option class="level-0"
                                                        value="1997" {{ in_array('1997', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Swan Valley West, MB
                                                </option>
                                                <option class="level-0"
                                                        value="2013" {{ in_array('2013', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Reinland, MB
                                                </option>
                                                <option class="level-0"
                                                        value="2029" {{ in_array('2029', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint Mary, NB
                                                </option>
                                                <option class="level-0"
                                                        value="2045" {{ in_array('2045', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Wellington, ON
                                                </option>
                                                <option class="level-0"
                                                        value="2061" {{ in_array('2061', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Richibucto, NB
                                                </option>
                                                <option class="level-0"
                                                        value="2077" {{ in_array('2077', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Lakeview, BC
                                                </option>
                                                <option class="level-0"
                                                        value="2093" {{ in_array('2093', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Louis, NB
                                                </option>
                                                <option class="level-0"
                                                        value="2109" {{ in_array('2109', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Lamont, AB
                                                </option>
                                                <option class="level-0"
                                                        value="2125" {{ in_array('2125', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Hemmingford, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2141" {{ in_array('2141', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Sainte-Clotilde, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2157" {{ in_array('2157', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Coombs, BC
                                                </option>
                                                <option class="level-0"
                                                        value="2173" {{ in_array('2173', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Harbour Breton, NL
                                                </option>
                                                <option class="level-0"
                                                        value="2189" {{ in_array('2189', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Laurent-de-l'Ile-d'Orleans, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2205" {{ in_array('2205', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Boissevain, MB
                                                </option>
                                                <option class="level-0"
                                                        value="2221" {{ in_array('2221', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Gambo, NL
                                                </option>
                                                <option class="level-0"
                                                        value="2237" {{ in_array('2237', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Wembley, AB
                                                </option>
                                                <option class="level-0"
                                                        value="2253" {{ in_array('2253', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Louis-de-Gonzague, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2269" {{ in_array('2269', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    La Dore, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2285" {{ in_array('2285', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Macklin, SK
                                                </option>
                                                <option class="level-0"
                                                        value="2301" {{ in_array('2301', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Laird No. 404, SK
                                                </option>
                                                <option class="level-0"
                                                        value="2317" {{ in_array('2317', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Cardwell, NB
                                                </option>
                                                <option class="level-0"
                                                        value="2333" {{ in_array('2333', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Oxbow, SK
                                                </option>
                                                <option class="level-0"
                                                        value="2349" {{ in_array('2349', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Sorrento, BC
                                                </option>
                                                <option class="level-0"
                                                        value="2365" {{ in_array('2365', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Vauxhall, AB
                                                </option>
                                                <option class="level-0"
                                                        value="2381" {{ in_array('2381', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Irishtown-Summerside, NL
                                                </option>
                                                <option class="level-0"
                                                        value="2397" {{ in_array('2397', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Hubert-de-Riviere-du-Loup, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2413" {{ in_array('2413', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Bassano, AB
                                                </option>
                                                <option class="level-0"
                                                        value="2429" {{ in_array('2429', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Norbert-d'Arthabaska, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2445" {{ in_array('2445', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Gabriel-de-Rimouski, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2461" {{ in_array('2461', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Winnipeg Beach, MB
                                                </option>
                                                <option class="level-0"
                                                        value="2477" {{ in_array('2477', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Greenwich, NB
                                                </option>
                                                <option class="level-0"
                                                        value="2493" {{ in_array('2493', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Buffalo Narrows, SK
                                                </option>
                                                <option class="level-0"
                                                        value="2509" {{ in_array('2509', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Narcisse-de-Beaurivage, QC
                                                </option>

                                                <option class="level-0"
                                                        value="2525" {{ in_array('2525', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Notre-Dame-du-Nord, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2541" {{ in_array('2541', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Sainte-Genevieve-de-Batiscan, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2557" {{ in_array('2557', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Kindersley No. 290, SK
                                                </option>
                                                <option class="level-0"
                                                        value="2573" {{ in_array('2573', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Plaster Rock, NB
                                                </option>
                                                <option class="level-0"
                                                        value="2589" {{ in_array('2589', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Lajord No. 128, SK
                                                </option>
                                                <option class="level-0"
                                                        value="2605" {{ in_array('2605', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Dildo, NL
                                                </option>
                                                <option class="level-0"
                                                        value="3308" {{ in_array('3308', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Mississauga
                                                </option>
                                                <option class="level-0"
                                                        value="118" {{ in_array('118', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Montreal, QE
                                                </option>
                                                <option class="level-0"
                                                        value="373" {{ in_array('373', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Halifax
                                                </option>
                                                <option class="level-0"
                                                        value="389" {{ in_array('389', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Indianapolis
                                                </option>
                                                <option class="level-0"
                                                        value="894" {{ in_array('894', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Kitchener, ON
                                                </option>
                                                <option class="level-0"
                                                        value="910" {{ in_array('910', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Richmond Hill, ON
                                                </option>
                                                <option class="level-0"
                                                        value="926" {{ in_array('926', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Ajax, ON
                                                </option>
                                                <option class="level-0"
                                                        value="942" {{ in_array('942', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Kamloops, BC
                                                </option>
                                                <option class="level-0"
                                                        value="958" {{ in_array('958', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Belleville, ON
                                                </option>
                                                <option class="level-0"
                                                        value="974" {{ in_array('974', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Blainville, QC
                                                </option>
                                                <option class="level-0"
                                                        value="990" {{ in_array('990', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Cornwall, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1006" {{ in_array('1006', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Mission, BC
                                                </option>
                                                <option class="level-0"
                                                        value="1022" {{ in_array('1022', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Port Moody, BC
                                                </option>
                                                <option class="level-0"
                                                        value="1038" {{ in_array('1038', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Langley, BC
                                                </option>
                                                <option class="level-0"
                                                        value="1054" {{ in_array('1054', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Thetford Mines, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1070" {{ in_array('1070', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Candiac, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1086" {{ in_array('1086', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Essex, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1102" {{ in_array('1102', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Lloydminster, AB
                                                </option>
                                                <option class="level-0"
                                                        value="1118" {{ in_array('1118', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Selwyn, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1134" {{ in_array('1134', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Inverness, NS
                                                </option>
                                                <option class="level-0"
                                                        value="1150" {{ in_array('1150', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Winkler, MB
                                                </option>
                                                <option class="level-0"
                                                        value="1166" {{ in_array('1166', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    West Lincoln, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1182" {{ in_array('1182', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Central Elgin, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1198" {{ in_array('1198', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Thompson, MB
                                                </option>

                                                <option class="level-0"
                                                        value="1214" {{ in_array('1214', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Sainte-Agathe-des-Monts, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1230" {{ in_array('1230', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    St. Clements, MB
                                                </option>
                                                <option class="level-0"
                                                        value="1246" {{ in_array('1246', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Weyburn, SK
                                                </option>
                                                <option class="level-0"
                                                        value="1262" {{ in_array('1262', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Chester, NS
                                                </option>
                                                <option class="level-0"
                                                        value="1278" {{ in_array('1278', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Temiskaming Shores, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1294" {{ in_array('1294', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Notre-Dame-des-Prairies, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1310" {{ in_array('1310', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Taber, AB
                                                </option>
                                                <option class="level-0"
                                                        value="1326" {{ in_array('1326', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Sainte-Catherine-de-la-Jacques-Cartier, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1342" {{ in_array('1342', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Happy Valley, NL
                                                </option>
                                                <option class="level-0"
                                                        value="1358" {{ in_array('1358', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Drummond/North Elmsley, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1374" {{ in_array('1374', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Rigaud, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1390" {{ in_array('1390', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Les Cedres, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1406" {{ in_array('1406', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Bay Roberts, NL
                                                </option>
                                                <option class="level-0"
                                                        value="1422" {{ in_array('1422', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Paul, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1438" {{ in_array('1438', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Pointe-Calumet, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1454" {{ in_array('1454', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Calixte, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1470" {{ in_array('1470', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    South Bruce, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1486" {{ in_array('1486', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Gananoque, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1502" {{ in_array('1502', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Flin Flon, SK
                                                </option>
                                                <option class="level-0"
                                                        value="1518" {{ in_array('1518', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Stirling-Rawdon, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1534" {{ in_array('1534', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Lanoraie, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1550" {{ in_array('1550', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Barrhead, AB
                                                </option>
                                                <option class="level-0"
                                                        value="1566" {{ in_array('1566', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Nipawin, SK
                                                </option>
                                                <option class="level-0"
                                                        value="1582" {{ in_array('1582', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Grand Forks, BC
                                                </option>
                                                <option class="level-0"
                                                        value="1598" {{ in_array('1598', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Lac-Etchemin, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1614" {{ in_array('1614', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Simonds, NB
                                                </option>
                                                <option class="level-0"
                                                        value="1630" {{ in_array('1630', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Golden, BC
                                                </option>
                                                <option class="level-0"
                                                        value="1646" {{ in_array('1646', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Hay River, NT
                                                </option>
                                                <option class="level-0"
                                                        value="1662" {{ in_array('1662', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Grande-Riviere, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1678" {{ in_array('1678', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Powassan, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1694" {{ in_array('1694', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Inuvik, NT
                                                </option>
                                                <option class="level-0"
                                                        value="1710" {{ in_array('1710', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Lake of Bays, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1726" {{ in_array('1726', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Cedar, BC
                                                </option>
                                                <option class="level-0"
                                                        value="1742" {{ in_array('1742', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-David-de-Falardeau, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1758" {{ in_array('1758', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Sainte-Melanie, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1774" {{ in_array('1774', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Yamachiche, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1790" {{ in_array('1790', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    North Cypress-Langford, MB
                                                </option>
                                                <option class="level-0"
                                                        value="1806" {{ in_array('1806', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Weedon-Centre, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1822" {{ in_array('1822', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Shippegan, NB
                                                </option>

                                                <option class="level-0"
                                                        value="1838" {{ in_array('1838', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Elkford, BC
                                                </option>
                                                <option class="level-0"
                                                        value="1854" {{ in_array('1854', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Martin, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1870" {{ in_array('1870', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Kelsey, MB
                                                </option>
                                                <option class="level-0"
                                                        value="1886" {{ in_array('1886', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Grand Manan, NB
                                                </option>
                                                <option class="level-0"
                                                        value="1902" {{ in_array('1902', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Minto, NB
                                                </option>
                                                <option class="level-0"
                                                        value="1918" {{ in_array('1918', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Neebing, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1934" {{ in_array('1934', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Calmar, AB
                                                </option>
                                                <option class="level-0"
                                                        value="1950" {{ in_array('1950', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Burns Lake, BC
                                                </option>
                                                <option class="level-0"
                                                        value="1966" {{ in_array('1966', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Sainte-Anne-de-Sabrevois, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1982" {{ in_array('1982', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Damien, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1998" {{ in_array('1998', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Grey, MB
                                                </option>
                                                <option class="level-0"
                                                        value="2014" {{ in_array('2014', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Minitonas-Bowsman, MB
                                                </option>
                                                <option class="level-0"
                                                        value="2030" {{ in_array('2030', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Patrice-de-Sherrington, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2046" {{ in_array('2046', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Frontenac Islands, ON
                                                </option>
                                                <option class="level-0"
                                                        value="2062" {{ in_array('2062', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Terrasse-Vaudreuil, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2078" {{ in_array('2078', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Sainte-Justine, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2094" {{ in_array('2094', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Lucien, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2110" {{ in_array('2110', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Chambord, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2126" {{ in_array('2126', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Pierre-de-l'Ile-d'Orleans, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2142" {{ in_array('2142', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Lantz, NS
                                                </option>
                                                <option class="level-0"
                                                        value="2158" {{ in_array('2158', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Val-Joli, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2174" {{ in_array('2174', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Mille-Isles, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2190" {{ in_array('2190', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Jean-de-Dieu, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2206" {{ in_array('2206', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Sainte-Marcelline-de-Kildare, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2222" {{ in_array('2222', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Nauwigewauk, NB
                                                </option>
                                                <option class="level-0"
                                                        value="2238" {{ in_array('2238', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Macdonald, Meredith and Aberdeen Additional, ON
                                                </option>

                                                <option class="level-0"
                                                        value="2254" {{ in_array('2254', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Moosonee, ON
                                                </option>
                                                <option class="level-0"
                                                        value="2270" {{ in_array('2270', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Lac-au-Saumon, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2286" {{ in_array('2286', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Armour, ON
                                                </option>
                                                <option class="level-0"
                                                        value="2302" {{ in_array('2302', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Majorique-de-Grantham, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2318" {{ in_array('2318', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Amulet, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2334" {{ in_array('2334', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Telkwa, BC
                                                </option>
                                                <option class="level-0"
                                                        value="2350" {{ in_array('2350', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Burgeo, NL
                                                </option>

                                                <option class="level-0"
                                                        value="2366" {{ in_array('2366', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Lameque, NB
                                                </option>
                                                <option class="level-0"
                                                        value="2382" {{ in_array('2382', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Clarendon, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2398" {{ in_array('2398', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Jude, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2414" {{ in_array('2414', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Parrsboro, NS
                                                </option>
                                                <option class="level-0"
                                                        value="2430" {{ in_array('2430', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Manning, AB
                                                </option>
                                                <option class="level-0"
                                                        value="2446" {{ in_array('2446', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Armstrong, ON
                                                </option>
                                                <option class="level-0"
                                                        value="2462" {{ in_array('2462', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Sainte-Agathe-de-Lotbiniere, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2478" {{ in_array('2478', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Carling, ON
                                                </option>
                                                <option class="level-0"
                                                        value="2494" {{ in_array('2494', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Ayer's Cliff, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2510" {{ in_array('2510', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Plaisance, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2526" {{ in_array('2526', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Beachburg, ON
                                                </option>
                                                <option class="level-0"
                                                        value="2542" {{ in_array('2542', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Justin, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2558" {{ in_array('2558', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Falher, AB
                                                </option>
                                                <option class="level-0"
                                                        value="2574" {{ in_array('2574', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Wilmot, NB
                                                </option>
                                                <option class="level-0"
                                                        value="2590" {{ in_array('2590', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Hebertville, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2606" {{ in_array('2606', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Laurierville, QC
                                                </option>
                                                <option class="level-0"
                                                        value="3307" {{ in_array('3307', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    ON
                                                </option>
                                                <option class="level-0"
                                                        value="884" {{ in_array('884', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Vancouver, BC
                                                </option>
                                                <option class="level-0"
                                                        value="374" {{ in_array('374', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Winnipeg
                                                </option>
                                                <option class="level-0"
                                                        value="390" {{ in_array('390', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Columbus
                                                </option>
                                                <option class="level-0"
                                                        value="895" {{ in_array('895', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Halifax, NS
                                                </option>
                                                <option class="level-0"
                                                        value="911" {{ in_array('911', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Burlington, ON
                                                </option>
                                                <option class="level-0"
                                                        value="927" {{ in_array('927', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Waterloo, ON
                                                </option>
                                                <option class="level-0"
                                                        value="943" {{ in_array('943', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Jean-sur-Richelieu, QC
                                                </option>
                                                <option class="level-0"
                                                        value="959" {{ in_array('959', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Airdrie, AB
                                                </option>
                                                <option class="level-0"
                                                        value="975" {{ in_array('975', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Lac-Brome, QC
                                                </option>
                                                <option class="level-0"
                                                        value="991" {{ in_array('991', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Victoriaville, QC
                                                </option>

                                                <option class="level-0"
                                                        value="1007" {{ in_array('1007', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Timmins, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1023" {{ in_array('1023', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Pointe-Claire, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1039" {{ in_array('1039', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Grimsby, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1055" {{ in_array('1055', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Lincoln, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1071" {{ in_array('1071', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Essa, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1087" {{ in_array('1087', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Varennes, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1103" {{ in_array('1103', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Westmount, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1119" {{ in_array('1119', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Tillsonburg, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1135" {{ in_array('1135', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Basile-le-Grand, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1151" {{ in_array('1151', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Charles-Borromee, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1167" {{ in_array('1167', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Lavaltrie, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1183" {{ in_array('1183', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Mistassini, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1199" {{ in_array('1199', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Trent Hills, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1215" {{ in_array('1215', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Quesnel, BC
                                                </option>
                                                <option class="level-0"
                                                        value="1231" {{ in_array('1231', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    View Royal, BC
                                                </option>
                                                <option class="level-0"
                                                        value="1247" {{ in_array('1247', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    La Tuque, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1263" {{ in_array('1263', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Queens, NS
                                                </option>
                                                <option class="level-0"
                                                        value="1279" {{ in_array('1279', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Hinton, AB
                                                </option>
                                                <option class="level-0"
                                                        value="1295" {{ in_array('1295', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Leeds and the Thousand Islands, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1311" {{ in_array('1311', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Donnacona, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1327" {{ in_array('1327', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    South Bruce Peninsula, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1343" {{ in_array('1343', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Hippolyte, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1359" {{ in_array('1359', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Contrecoeur, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1375" {{ in_array('1375', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Louiseville, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1391" {{ in_array('1391', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Baie-Saint-Paul, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1407" {{ in_array('1407', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Wainfleet, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1423" {{ in_array('1423', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Devon, AB
                                                </option>
                                                <option class="level-0"
                                                        value="1439" {{ in_array('1439', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Dysart et al, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1455" {{ in_array('1455', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Lac-Megantic, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1471" {{ in_array('1471', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Antigonish, NS
                                                </option>

                                                <option class="level-0"
                                                        value="1487" {{ in_array('1487', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Windsor, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1503" {{ in_array('1503', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Brokenhead, MB
                                                </option>
                                                <option class="level-0"
                                                        value="1519" {{ in_array('1519', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Mont-Orford, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1535" {{ in_array('1535', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Centre Hastings, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1551" {{ in_array('1551', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Melville, SK
                                                </option>
                                                <option class="level-0"
                                                        value="1567" {{ in_array('1567', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Battleford, SK
                                                </option>
                                                <option class="level-0"
                                                        value="1583" {{ in_array('1583', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    New Maryland, NB
                                                </option>
                                                <option class="level-0"
                                                        value="1599" {{ in_array('1599', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Jacques, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1615" {{ in_array('1615', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Crabtree, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1631" {{ in_array('1631', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Adolphe-d'Howard, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1647" {{ in_array('1647', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Pasadena, NL
                                                </option>
                                                <option class="level-0"
                                                        value="1663" {{ in_array('1663', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Malartic, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1679" {{ in_array('1679', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Highlands East, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1695" {{ in_array('1695', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Richmond, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1711" {{ in_array('1711', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Bishops Falls, NL
                                                </option>
                                                <option class="level-0"
                                                        value="1727" {{ in_array('1727', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Gabriel, QC
                                                </option>

                                                <option class="level-0"
                                                        value="1743" {{ in_array('1743', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Harbour Grace, NL
                                                </option>
                                                <option class="level-0"
                                                        value="1759" {{ in_array('1759', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Horton, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1775" {{ in_array('1775', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Adstock, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1791" {{ in_array('1791', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Dominique, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1807" {{ in_array('1807', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Lacolle, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1823" {{ in_array('1823', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    East Garafraxa, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1839" {{ in_array('1839', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Georgian Bay, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1855" {{ in_array('1855', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Causapscal, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1871" {{ in_array('1871', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Killaloe, Hagarty and Richards, ON
                                                </option>
                                                <option class="level-0"
                                                        value="1887" {{ in_array('1887', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Sainte-Madeleine, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1903" {{ in_array('1903', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Rosthern No. 403, SK
                                                </option>
                                                <option class="level-0"
                                                        value="1919" {{ in_array('1919', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Port McNeill, BC
                                                </option>
                                                <option class="level-0"
                                                        value="1935" {{ in_array('1935', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Nanton, AB
                                                </option>
                                                <option class="level-0"
                                                        value="1951" {{ in_array('1951', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Redwater, AB
                                                </option>
                                                <option class="level-0"
                                                        value="1967" {{ in_array('1967', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Sainte-Anne-de-la-Perade, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1983" {{ in_array('1983', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Lac-Nominingue, QC
                                                </option>
                                                <option class="level-0"
                                                        value="1999" {{ in_array('1999', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Gilbert Plains, MB
                                                </option>
                                                <option class="level-0"
                                                        value="2015" {{ in_array('2015', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Kippens, NL
                                                </option>
                                                <option class="level-0"
                                                        value="2031" {{ in_array('2031', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Fox Creek, AB
                                                </option>
                                                <option class="level-0"
                                                        value="2047" {{ in_array('2047', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Point Edward, ON
                                                </option>
                                                <option class="level-0"
                                                        value="2063" {{ in_array('2063', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Riviere-Beaudette, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2079" {{ in_array('2079', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Valerien-de-Milton, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2095" {{ in_array('2095', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Victoria, NL
                                                </option>
                                                <option class="level-0"
                                                        value="2111" {{ in_array('2111', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Maugerville, NB
                                                </option>
                                                <option class="level-0"
                                                        value="2127" {{ in_array('2127', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Kensington, PE
                                                </option>
                                                <option class="level-0"
                                                        value="2143" {{ in_array('2143', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Wicklow, NB
                                                </option>
                                                <option class="level-0"
                                                        value="2159" {{ in_array('2159', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Southesk, NB
                                                </option>
                                                <option class="level-0"
                                                        value="2175" {{ in_array('2175', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Naramata, BC
                                                </option>
                                                <option class="level-0"
                                                        value="2191" {{ in_array('2191', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Massey Drive, NL
                                                </option>
                                                <option class="level-0"
                                                        value="2207" {{ in_array('2207', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Riviere-Blanche, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2223" {{ in_array('2223', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Humbermouth, NL
                                                </option>
                                                <option class="level-0"
                                                        value="2239" {{ in_array('2239', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Pinawa, MB
                                                </option>
                                                <option class="level-0"
                                                        value="2255" {{ in_array('2255', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Englehart, ON
                                                </option>
                                                <option class="level-0"
                                                        value="2271" {{ in_array('2271', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Wotton, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2287" {{ in_array('2287', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Saint-Simon, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2303" {{ in_array('2303', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Petitcodiac, NB
                                                </option>
                                                <option class="level-0"
                                                        value="2319" {{ in_array('2319', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    L'Avenir, QC
                                                </option>
                                                <option class="level-0"
                                                        value="2335" {{ in_array('2335', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Landmark, MB
                                                </option>
                                                <option class="level-0"
                                                        value="2335" {{ in_array('2335', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Washington,DC
                                                </option>
                                                <option class="level-0"
                                                        value="2335" {{ in_array('2335', (array) json_decode($user->location)) ? 'selected' : '' }}>
                                                    Washington,DC
                                                </option>
                                            </select>
                                        </div>
                                        <label for="type">Tags</label>
                                        <p style="text-align: start;">These are keywords used to help identify more
                                            specific
                                            versions of something. For example, a good tag for a massage could be "Deep
                                            Tissue".</p>
                                        <select name="tags[]" multiple="multiple" class="form-select select2">
                                        @foreach($practitionerTag as $term)
                                            <option value="{{$term->id}}"  >{{$term->name}}</option>
                                        @endforeach
                                        </select>
                                        <div class="mb-4 mt-4">
                                            <label for="media">Media</label>
                                            <label class="add-media-btn" for="media-upload">
                                                <i class="fas fa-plus"></i>
                                                Add media
                                            </label>
                                            <input type="file" id="media-upload" name="media_images[]" class="hidden"
                                                   accept="image/*" multiple>

                                            <div class="media-container" id="media-container">
                                                @if(count($mediaImages) > 0)
                                                    @foreach ($mediaImages as $image)
                                                        <div class="media-item">
                                                            <img
                                                                src="{{ asset(env('media_path') . '/practitioners/' . $userDetails->id . '/media/' . $image) }}"
                                                                alt="Practitioner Image"
                                                                style="width: 100px; height: 100px; object-fit: cover; display: block;">
                                                            <i class="fas fa-times text-danger" style="cursor: pointer;"
                                                               data-image="{{ $image }}"
                                                               data-user-id="{{ $userDetails->id }}"
                                                               onclick="removeImage(this);"></i>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <p>No images available</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="floatingTextarea">About Me</label>
                                            <p>Maximum length of 500 words</p>
                                            <textarea class="form-control" name="about_me" placeholder=""
                                                      id="floatingTextarea">{{$userDetails->about_me ?? ''}}</textarea>
                                        </div>
                                        <div class="mb-4">
                                            <label for="IHelpWith" class="fw-bold">I help with:</label>
                                            <div class="row align-items-center">
                                                <div class="col-md-6">
                                                    <select id="IHelpWith" name="IHelpWith[]"
                                                            class="form-select select2"
                                                            multiple>
                                                        @php
                                                            $selectedTerms = explode(',', $userDetails->IHelpWith ?? '');
                                                        @endphp
                                                        @foreach($IHelpWith as $term)
                                                            <option
                                                                value="{{$term->id}}" {{ in_array($term->id, $selectedTerms) ? 'selected' : '' }} >{{$term->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <button class="update-btn mb-2 addterm" data-type="IHelpWith">Add
                                                        New Term
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                        <div id="IHelpWith-container">

                                        </div>
                                        <!-- <div class="mb-4">
                                            <label for="type" class="fw-bold">I help with:</label>
                                            <select id="term" name="term" class="form-select select2"
                                                    multiple="multiple">
                                                <option>Select</option>
                                                @foreach($HowIHelp as $term)
                                            <option value="{{$term->id}}">{{$term->name}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                    <hr>
                                    <button class="update-btn mb-2">Add New Term</button> -->
                                        <div class="mb-4">
                                            <label for="type" class="fw-bold">How I help:</label>

                                            <div class="row align-items-center">
                                                <div class="col-md-6">
                                                    <select id="HowIHelp" name="HowIHelp[]" class="form-select select2"
                                                            multiple>
                                                        @php
                                                            $selectedTerms = explode(',', $userDetails->HowIHelp ?? '');
                                                        @endphp
                                                        @foreach($HowIHelp as $term)
                                                            <option
                                                                value="{{$term->id}}" {{ in_array($term->id, $selectedTerms) ? 'selected' : '' }} >{{$term->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <button class="update-btn mb-2 addterm" data-type="HowIHelp">Add New Term
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="HowIHelp-container">

                                        </div>

                                        <div class="mb-4">
                                            <label for="specialities" class="fw-bold">Categories</label>
                                            <select id="specialities" class="form-control form-select select2"
                                                    multiple="multiple"
                                                    name="specialities[]">
                                                @foreach($Categories as $term)
                                                    <option
                                                        value="{{$term->id}}" {{ (isset($userDetails->specialities) && in_array($term->id, json_decode($userDetails->specialities))) ? 'selected' : '' }}>{{$term->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-4">

                                            <label class="form-check-label" for="amentities">Amentities</label>
                                            <select id="amentities" class="form-control form-select select2"
                                                    name="amentities" multiple="multiple">
                                                <option>Select</option>
                                                <option>Neurolinguistic Programming</option>
                                            </select>

                                        </div>
                                        <div class="mb-4">
                                            <label for="certifications" class="fw-bold">Certifications</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <select id="certifications" class="form-select select2" name="certifications[]" multiple>
                                                    @php
                                                            $selectedTerms = explode(',', $userDetails->certifications ?? '');
                                                        @endphp
                                                        @foreach($certifications as $term)
                                                            <option
                                                                value="{{$term->id}}" {{ in_array($term->id, $selectedTerms) ? 'selected' : '' }} >{{$term->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <button class="update-btn mb-2 addterm" data-type="certifications">Add New Term</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="certifications-container">

                                        </div>


                                        <div class="mb-4">
                                            <label for="endorsements" class="fw-bold">Endorsements</label>
                                            <select id="endorsements" name="endorsements" class="form-select">
                                                <option>Select</option>
                                                @foreach($users as $user)
                                                    <option
                                                        value="{{$user->id}}" {{ $userDetails->endorsements == $user->id ? 'selected' : '' }}>{{$user->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label for="timezone" class="fw-bold">Timezone</label>
                                            <select id="timezone" name="timezone" class="form-select">
                                                <option>Select</option>
                                            </select>
                                            <p style="text-align: start;">select your timezone</p>
                                        </div>
                                        <div class="mb-4">
                                            <div class="form-check offering-check">
                                                <input type="checkbox" class="form-check-input" id="is_opening_hours"
                                                       name="is_opening_hours">
                                                <label class="form-check-label" for="is_opening_hours">Enable opening
                                                    hours</label>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <div class="form-check offering-check">
                                                <input type="checkbox" class="form-check-input" id="is_notice"
                                                       name="is_notice">
                                                <label class="form-check-label" for="is_notice">Enable notice</label>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <div class="form-check offering-check">
                                                <input type="checkbox" class="form-check-input" id="is_google_analytics"
                                                       name="is_google_analytics">
                                                <label class="form-check-label" for="is_google_analytics">Enable Google
                                                    Analytics</label>
                                            </div>
                                        </div>
                                        <div class="d-flex" style="gap: 20px;">

                                            <button type="submit" class="update-btn">Save Changes</button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Availability Tab Content -->
                                <div class="tab-pane fade" id="availability" role="tabpanel"
                                     aria-labelledby="availability-tab">
                                    <div class="container-fluid calendar-integration practitioner-profil">
                                        <div class="integration-wrrpr">
                                            <h4 class="stripe-text m-2">Connect with Stripe</h4>
                                            <h5 class="stripe-label m-2">{{($stripeAccount && $stripeAccount->stripe_access_token && $stripeAccount->stripe_refresh_token) ?'Successfully authenticated.': 'Your account is not yet connected
                                                with Stripe.'}}</h5>
                                            <div class="border-1 border-bottom"></div>
                                            <div class="integration-header">
                                                <h4>Authorization</h4>
                                                <div class="form-group flex-column d-flex align-items-start">
                                                    @if($stripeAccount && $stripeAccount->stripe_access_token && $stripeAccount->stripe_refresh_token)
                                                        <a href="{{ route('disconnect_to_stripe') }}"
                                                           class="export-btn">Disconnect</a>
                                                    @else
                                                        <a href="{{ route('stripe_connect') }}" class="export-btn">Connect</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Costs Tab Content -->
                                <div class="tab-pane fade" id="costs" role="tabpanel" aria-labelledby="costs-tab">
                                    <div class="container-fluid calendar-integration practitioner-profil">
                                        <div class="integration-wrrpr">
                                            <h4 class="stripe-text m-2">Connect with Google Account</h4>
                                            <h5 class="stripe-label m-2">{{($googleAccount && $googleAccount->access_token && $googleAccount->refresh_token) ? 'Successfully authenticated.': 'Your account is not yet connected
                                                with Google.'}}</h5>
                                            <div class="border-1 border-bottom"></div>
                                            <div class="integration-header">
                                                <h4>Authorization</h4>
                                                <div class="form-group flex-column d-flex align-items-start">
                                                    @if($googleAccount && $googleAccount->access_token && $googleAccount->refresh_token)
                                                        <a href="{{ route('disconnect_to_google') }}"
                                                           class="export-btn">Disconnect</a>
                                                    @else
                                                        <a href="{{ route('redirect_to_google') }}" class="export-btn">Connect</a>
                                                    @endif
                                                </div>
                                            </div>

                                            {{--                                            <div class="form-group">--}}
                                            {{--                                                <div>--}}
                                            {{--                                                    <label>Calendar</label>--}}
                                            {{--                                                    <p>Enter with your Calendar.</p>--}}
                                            {{--                                                </div>--}}
                                            {{--                                                <select>--}}
                                            {{--                                                    <option>mohitmmv02@gmail.com</option>--}}
                                            {{--                                                </select>--}}
                                            {{--                                            </div>--}}
                                            {{--                                            <div class="form-group" style="border: none;">--}}
                                            {{--                                                <div>--}}
                                            {{--                                                    <label>Sync Preference <i--}}
                                            {{--                                                            class="fas fa-question-circle icon"></i></label>--}}
                                            {{--                                                    <p>Manage the sync flow between your Store calendar and Google--}}
                                            {{--                                                        calendar.</p>--}}
                                            {{--                                                </div>--}}
                                            {{--                                                <select>--}}
                                            {{--                                                    <option>Sync both ways - between Store and Google calendar--}}
                                            {{--                                                    </option>--}}
                                            {{--                                                </select>--}}
                                            {{--                                            </div>--}}
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="client" role="tabpanel" aria-labelledby="clint-tab">
                                    <form method="post" action="{{ route('update_client_policy') }}">
                                        <div class="mb-3">
                                            <label for="floatingTextarea">Privacy Policy</label>
                                            <textarea class="form-control" placeholder="" name="privacy_policy"
                                                      id="floatingTextarea">{{ $userDetails->privacy_policy ?? '' }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="floatingTextarea">Terms & Condition</label>
                                            <textarea class="form-control" name="terms_condition" placeholder=""
                                                      id="floatingTextarea">{{ $userDetails->terms_condition ?? '' }}</textarea>
                                        </div>
                                        <input type="hidden" name="id" value="{{ $user->id ?? '' }}">
                                        <div class="d-flex" style="gap: 20px;">
                                            <button class="update-btn m-0">Add Offering</button>
                                            <button class="update-btn">Save Draft</button>
                                        </div>
                                        @csrf
                                    </form>

                                </div>
                            </div>
                        </div>
                        {{--                        <div class="d-flex" style="gap: 20px;">--}}
                        {{--                            <button class="update-btn m-0">Add Offering</button>--}}
                        {{--                            <button class="update-btn">Save Draft</button>--}}
                        {{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $('.addterm').on('click', function (e) {
            e.preventDefault();
            var termType = $(this).data('type'); // Get the data-type attribute value

            $.ajax({
                url: '{{route("add_term")}}', // Change this to your server-side script
                type: 'POST',
                data: {
                    type: termType,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        $('#' + termType + '-container').html(response.inputField);
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        });

        $(document).on('click', '.save_term', function (e) {
            e.preventDefault();
            var termType = $(this).data('type'); // Get the data-type attribute value
            var name = $('.' + termType + '_term').val();
            $.ajax({
                url: '{{route("save_term")}}', // Change this to your server-side script
                type: 'POST',
                data: {
                    type: termType,
                    name: name,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        var selectElement = $("#" + termType);

                        // Append the new option
                        var newOption = `<option value="${response.term.id}" selected>${response.term.name}</option>`;
                        selectElement.append(newOption);

                        // Get previously selected values and add the new one
                        var selectedValues = selectElement.val() || [];
                        selectedValues.push(response.term.id);

                        // Reapply selected values
                        selectElement.val(selectedValues).trigger('change');
                        alert('Term added successfully');
                    } else {
                        alert('Error: ' + response.message);
                    }
                    $('#' + termType + '-container').html('');
                },
                /*  success: function (response) {
                     if (response.success) {
                         $('#' + termType + '-container').html('');
                         var newOption = `<option value="${response.term.id}" selected>${response.term.name}</option>`;
                         $("#" + termType).append(newOption).trigger('change');
                         alert('term add sucessfully');

                     } else {
                         alert('Error: ' + response.message);
                     }
                 }, */
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        });

        /*** media upload */
        document.getElementById('media-upload').addEventListener('change', function (event) {
            const container = document.getElementById('media-container');
            const files = event.target.files;

            for (let file of files) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    const div = document.createElement('div');
                    div.classList.add('media-item');

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = "100px";
                    img.style.height = "100px";
                    img.style.objectFit = "cover";
                    img.style.display = "block";

                    const removeBtn = document.createElement('i');
                    removeBtn.classList.add('fas', 'fa-times');
                    removeBtn.style.cursor = "pointer";

                    removeBtn.addEventListener('click', function () {
                        div.remove();
                    });

                    div.appendChild(img);
                    div.appendChild(removeBtn);
                    container.appendChild(div);
                };

                reader.readAsDataURL(file);
            }
        });

        function removeImage(element) {
            const imageName = $(element).data('image');
            const userId = $(element).data('user-id');
            const profileImage = $(element).data('profile-image');

            $.ajax({
                url: '/delete/image',
                type: 'POST',
                data: {
                    image: imageName,
                    user_id: userId,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    // Check if the profile image is being deleted
                    if (profileImage) {
                        // Remove the existing image preview
                        $('#imagePreview').remove();

                        // Add the new label for image upload
                        const uploadLabel = `
                    <label onclick="document.getElementById('fileInput').click();" class="image-preview" id="imagePreview" style="border-radius: 50%;">
                        <span>+</span>
                    </label>
                `;

                        $('#imageDiv').append(uploadLabel);
                    } else {
                        $(element).parent().remove();
                    }

                    console.log('Image removed successfully', response);
                },
                error: function (xhr, status, error) {
                    // Handle error
                    console.error('Error removing image:', error);
                }
            });

        }


    </script>
@endsection

