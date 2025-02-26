@extends('layouts.app')
@section('content')
    <section class="practitioner-profile">
        <div class="container">
            @include('layouts.partitioner_sidebar')
            <div class="row">
                @include('layouts.partitioner_nav')
                <h3 class="no-request-text mb-4">Add Offering</h3>
                <p style="text-align: start;">Remember, when creating services, you must create separate
                    services for
                    virtual and in-person. This will allow ease for YOU and your potential clients. Feel
                    free to “copy
                    and paste” descriptions from each service offering.</p>
                <div class="add-offering-dv">
                    <form method="POST" action="{{ route('store_offering') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" id="exampleInputEmail1"
                                   aria-describedby="emailHelp" placeholder="" value="{{ $offering->name}}">
                        </div>
                        <div class="mb-3">
                            <label for="floatingTextarea">Description</label>
                            <textarea class="form-control" name="long_description"
                                      placeholder="please add a full description here"
                                      id="floatingTextarea">{{ $offering->long_description}}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="floatingTextarea">Short Description</label>
                            <textarea class="form-control" name="short_description"
                                      placeholder="please add a full description here"
                                      id="floatingTextarea">{{ $offering->short_description}}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Location</label>
                            <select name="location" multiple="multiple" class="form-control select2">
                                <option class="level-0"
                                        value="370" {{ in_array('370', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Montreal
                                </option>
                                <option class="level-0"
                                        value="386" {{ in_array('386', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Austin
                                </option>
                                <option class="level-0"
                                        value="891" {{ in_array('891', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Mississauga, ON
                                </option>
                                <option class="level-0"
                                        value="907" {{ in_array('907', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Regina, SK
                                </option>
                                <option class="level-0"
                                        value="923" {{ in_array('923', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Whitby, ON
                                </option>
                                <option class="level-0"
                                        value="939" {{ in_array('939', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Red Deer, AB
                                </option>
                                <option class="level-0"
                                        value="955" {{ in_array('955', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Prince George, BC
                                </option>
                                <option class="level-0"
                                        value="971" {{ in_array('971', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Aurora, ON
                                </option>
                                <option class="level-0"
                                        value="987" {{ in_array('987', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Rimouski, QC
                                </option>
                                <option class="level-0"
                                        value="1003" {{ in_array('1003', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Salaberry-de-Valleyfield, QC
                                </option>
                                <option class="level-0"
                                        value="1019" {{ in_array('1019', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Orangeville, ON
                                </option>
                                <option class="level-0"
                                        value="1035" {{ in_array('1035', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Alma, QC
                                </option>
                                <option class="level-0"
                                        value="1051" {{ in_array('1051', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    La Prairie, QC
                                </option>
                                <option class="level-0"
                                        value="1067" {{ in_array('1067', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Amherstburg, ON
                                </option>
                                <option class="level-0"
                                        value="1083" {{ in_array('1083', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Uxbridge, ON
                                </option>
                                <option class="level-0"
                                        value="1099" {{ in_array('1099', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Augustin-de-Desmaures, QC
                                </option>
                                <option class="level-0"
                                        value="1115" {{ in_array('1115', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Middlesex Centre, ON
                                </option>
                                <option class="level-0"
                                        value="1131" {{ in_array('1131', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Central Saanich, BC
                                </option>
                                <option class="level-0"
                                        value="1147" {{ in_array('1147', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Greater Napanee, ON
                                </option>
                                <option class="level-0"
                                        value="1163" {{ in_array('1163', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    St. Clair, ON
                                </option>
                                <option class="level-0"
                                        value="1179" {{ in_array('1179', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Grand Falls, NL
                                </option>
                                <option class="level-0"
                                        value="1195" {{ in_array('1195', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    South Glengarry, ON
                                </option>
                                <option class="level-0"
                                        value="1211" {{ in_array('1211', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    North Saanich, BC
                                </option>
                                <option class="level-0"
                                        value="1227" {{ in_array('1227', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Brock, ON
                                </option>
                                <option class="level-0"
                                        value="1243" {{ in_array('1243', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Ladysmith, BC
                                </option>
                                <option class="level-0"
                                        value="1259" {{ in_array('1259', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Rawdon, QC
                                </option>
                                <option class="level-0"
                                        value="1275" {{ in_array('1275', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Castlegar, BC
                                </option>
                                <option class="level-0"
                                        value="1291" {{ in_array('1291', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Smiths Falls, ON
                                </option>
                                <option class="level-0"
                                        value="1307" {{ in_array('1307', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Labrador City, NL
                                </option>
                                <option class="level-0"
                                        value="1323" {{ in_array('1323', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Shediac, NB
                                </option>
                                <option class="level-0"
                                        value="1339" {{ in_array('1339', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Zorra, ON
                                </option>
                                <option class="level-0"
                                        value="1355" {{ in_array('1355', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Innisfail, AB
                                </option>
                                <option class="level-0"
                                        value="1371" {{ in_array('1371', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Philippe, QC
                                </option>
                                <option class="level-0"
                                        value="1387" {{ in_array('1387', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Drayton Valley, AB
                                </option>
                                <option class="level-0"
                                        value="1403" {{ in_array('1403', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Whitewater Region, ON
                                </option>
                                <option class="level-0"
                                        value="1419" {{ in_array('1419', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Rocky Mountain House, AB
                                </option>
                                <option class="level-0"
                                        value="1435" {{ in_array('1435', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Kent, BC
                                </option>
                                <option class="level-0"
                                        value="1451" {{ in_array('1451', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Niverville, MB
                                </option>
                                <option class="level-0"
                                        value="1467" {{ in_array('1467', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Princeville, QC
                                </option>
                                <option class="level-0"
                                        value="1483" {{ in_array('1483', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Ashfield-Colborne-Wawanosh, ON
                                </option>
                                <option class="level-0"
                                        value="1499" {{ in_array('1499', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Didsbury, AB
                                </option>

                                <option class="level-0"
                                        value="1515" {{ in_array('1515', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Stonewall, MB
                                </option>
                                <option class="level-0"
                                        value="1531" {{ in_array('1531', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Southwold, ON
                                </option>
                                <option class="level-0"
                                        value="1547" {{ in_array('1547', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Kindersley, SK
                                </option>
                                <option class="level-0"
                                        value="1563" {{ in_array('1563', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Vanderhoof, BC
                                </option>
                                <option class="level-0"
                                        value="1579" {{ in_array('1579', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Altona, MB
                                </option>
                                <option class="level-0"
                                        value="1595" {{ in_array('1595', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Carstairs, AB
                                </option>
                                <option class="level-0"
                                        value="1611" {{ in_array('1611', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Raymond, AB
                                </option>
                                <option class="level-0"
                                        value="1627" {{ in_array('1627', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    East Angus, QC
                                </option>
                                <option class="level-0"
                                        value="1643" {{ in_array('1643', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Fruitvale, BC
                                </option>
                                <option class="level-0"
                                        value="1659" {{ in_array('1659', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Havre-Saint-Pierre, QC
                                </option>
                                <option class="level-0"
                                        value="1675" {{ in_array('1675', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Sainte-Anne-des-Lacs, QC
                                </option>

                                <option class="level-0"
                                        value="1691" {{ in_array('1691', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Forestville, QC
                                </option>
                                <option class="level-0"
                                        value="1707" {{ in_array('1707', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Portneuf, QC
                                </option>
                                <option class="level-0"
                                        value="1723" {{ in_array('1723', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Mont-Saint-Gregoire, QC
                                </option>
                                <option class="level-0"
                                        value="1739" {{ in_array('1739', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Adelaide-Metcalfe, ON
                                </option>
                                <option class="level-0"
                                        value="1755" {{ in_array('1755', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    North Algona Wilberforce, ON
                                </option>
                                <option class="level-0"
                                        value="1771" {{ in_array('1771', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Princeton, BC
                                </option>
                                <option class="level-0"
                                        value="1787" {{ in_array('1787', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Kuujjuaq, QC
                                </option>
                                <option class="level-0"
                                        value="1803" {{ in_array('1803', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Black Diamond, AB
                                </option>
                                <option class="level-0"
                                        value="1819" {{ in_array('1819', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Notre-Dame-de-Lourdes, QC
                                </option>
                                <option class="level-0"
                                        value="1835" {{ in_array('1835', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Damase, QC
                                </option>
                                <option class="level-0"
                                        value="1851" {{ in_array('1851', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Sainte-Catherine-de-Hatley, QC
                                </option>
                                <option class="level-0"
                                        value="1867" {{ in_array('1867', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Victor, QC
                                </option>
                                <option class="level-0"
                                        value="1883" {{ in_array('1883', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Sainte-Genevieve-de-Berthier, QC
                                </option>
                                <option class="level-0"
                                        value="1899" {{ in_array('1899', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Burin, NL
                                </option>

                                <option class="level-0"
                                        value="1915" {{ in_array('1915', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Maskinonge, QC
                                </option>
                                <option class="level-0"
                                        value="1931" {{ in_array('1931', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Twillingate, NL
                                </option>
                                <option class="level-0"
                                        value="1947" {{ in_array('1947', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Bernard, QC
                                </option>
                                <option class="level-0"
                                        value="1963" {{ in_array('1963', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Glovertown, NL
                                </option>
                                <option class="level-0"
                                        value="1979" {{ in_array('1979', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Mandeville, QC
                                </option>
                                <option class="level-0"
                                        value="1995" {{ in_array('1995', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Lorne, MB
                                </option>
                                <option class="level-0"
                                        value="2011" {{ in_array('2011', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Glenboro-South Cypress, MB
                                </option>
                                <option class="level-0"
                                        value="2027" {{ in_array('2027', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    One Hundred Mile House, BC
                                </option>
                                <option class="level-0"
                                        value="2043" {{ in_array('2043', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Vallee-Jonction, QC
                                </option>
                                <option class="level-0"
                                        value="2059" {{ in_array('2059', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Lac-Superieur, QC
                                </option>
                                <option class="level-0"
                                        value="2075" {{ in_array('2075', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Sainte-Beatrix, QC
                                </option>
                                <option class="level-0"
                                        value="2091" {{ in_array('2091', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Champlain, QC
                                </option>
                                <option class="level-0"
                                        value="2107" {{ in_array('2107', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Pointe-des-Cascades, QC
                                </option>
                                <option class="level-0"
                                        value="2123" {{ in_array('2123', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Warfield, BC
                                </option>
                                <option class="level-0"
                                        value="2139" {{ in_array('2139', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Notre-Dame-du-Bon-Conseil, QC
                                </option>
                                <option class="level-0"
                                        value="2155" {{ in_array('2155', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Rosedale, MB
                                </option>

                                <option class="level-0"
                                        value="2171" {{ in_array('2171', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Sainte-Helene-de-Bagot, QC
                                </option>
                                <option class="level-0"
                                        value="2187" {{ in_array('2187', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Cleveland, QC
                                </option>
                                <option class="level-0"
                                        value="2203" {{ in_array('2203', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Lambton, QC
                                </option>
                                <option class="level-0"
                                        value="2219" {{ in_array('2219', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Guillaume, QC
                                </option>
                                <option class="level-0"
                                        value="2235" {{ in_array('2235', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Langham, SK
                                </option>
                                <option class="level-0"
                                        value="2251" {{ in_array('2251', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Salluit, QC
                                </option>
                                <option class="level-0"
                                        value="2267" {{ in_array('2267', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Odilon-de-Cranbourne, QC
                                </option>
                                <option class="level-0"
                                        value="2283" {{ in_array('2283', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Scott, QC
                                </option>
                                <option class="level-0"
                                        value="2299" {{ in_array('2299', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Lions Bay, BC
                                </option>
                                <option class="level-0"
                                        value="2315" {{ in_array('2315', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Upham, NB
                                </option>
                                <option class="level-0"
                                        value="2331" {{ in_array('2331', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Smooth Rock Falls, ON
                                </option>

                                <option class="level-0"
                                        value="2347" {{ in_array('2347', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Edouard, QC
                                </option>
                                <option class="level-0"
                                        value="2363" {{ in_array('2363', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Sainte-Anne-du-Sault, QC
                                </option>
                                <option class="level-0"
                                        value="2379" {{ in_array('2379', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Roxton Falls, QC
                                </option>
                                <option class="level-0"
                                        value="2395" {{ in_array('2395', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    St. Joseph, ON
                                </option>
                                <option class="level-0"
                                        value="2411" {{ in_array('2411', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    L'Anse-Saint-Jean, QC
                                </option>
                                <option class="level-0"
                                        value="2427" {{ in_array('2427', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Kaleden, BC
                                </option>
                                <option class="level-0"
                                        value="2443" {{ in_array('2443', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Joachim-de-Shefford, QC
                                </option>
                                <option class="level-0"
                                        value="2459" {{ in_array('2459', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Centreville-Wareham-Trinity, NL
                                </option>
                                <option class="level-0"
                                        value="2475" {{ in_array('2475', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Hensall, ON
                                </option>
                                <option class="level-0"
                                        value="2491" {{ in_array('2491', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Waldheim, SK
                                </option>
                                <option class="level-0"
                                        value="2507" {{ in_array('2507', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    South Algonquin, ON
                                </option>
                                <option class="level-0"
                                        value="2523" {{ in_array('2523', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Durham, NB
                                </option>
                                <option class="level-0"
                                        value="2539" {{ in_array('2539', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Havelock, NB
                                </option>

                                <option class="level-0"
                                        value="2555" {{ in_array('2555', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    La Macaza, QC
                                </option>
                                <option class="level-0"
                                        value="2571" {{ in_array('2571', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Argyle, MB
                                </option>
                                <option class="level-0"
                                        value="2587" {{ in_array('2587', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Oyen, AB
                                </option>
                                <option class="level-0"
                                        value="2603" {{ in_array('2603', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Gillam, MB
                                </option>
                                <option class="level-0"
                                        value="3042" {{ in_array('3042', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    BC
                                </option>
                                <option class="level-0"
                                        value="116" {{ in_array('116', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Victoria, BC
                                </option>
                                <option class="level-0"
                                        value="371" {{ in_array('371', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Ottawa
                                </option>
                                <option class="level-0"
                                        value="387" {{ in_array('387', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Jacksonville
                                </option>
                                <option class="level-0"
                                        value="892" {{ in_array('892', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Brampton, ON
                                </option>
                                <option class="level-0"
                                        value="908" {{ in_array('908', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Oakville, ON
                                </option>
                                <option class="level-0"
                                        value="924" {{ in_array('924', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Cambridge, ON
                                </option>
                                <option class="level-0"
                                        value="940" {{ in_array('940', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Pickering, ON
                                </option>
                                <option class="level-0"
                                        value="956" {{ in_array('956', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Caledon, ON
                                </option>
                                <option class="level-0"
                                        value="972" {{ in_array('972', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Port Coquitlam, BC
                                </option>
                                <option class="level-0"
                                        value="988" {{ in_array('988', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Courtenay, BC
                                </option>
                                <option class="level-0"
                                        value="1004" {{ in_array('1004', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Rouyn-Noranda, QC
                                </option>
                                <option class="level-0"
                                        value="1020" {{ in_array('1020', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Leduc, AB
                                </option>
                                <option class="level-0"
                                        value="1036" {{ in_array('1036', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Sainte-Julie, QC
                                </option>
                                <option class="level-0"
                                        value="1052" {{ in_array('1052', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Bruno-de-Montarville, QC
                                </option>
                                <option class="level-0"
                                        value="1068" {{ in_array('1068', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    L'Assomption, QC
                                </option>
                                <option class="level-0"
                                        value="1084" {{ in_array('1084', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Fort St. John, BC
                                </option>

                                <option class="level-0"
                                        value="1100" {{ in_array('1100', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Huntsville, ON
                                </option>
                                <option class="level-0"
                                        value="1116" {{ in_array('1116', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Mont-Saint-Hilaire, QC
                                </option>
                                <option class="level-0"
                                        value="1132" {{ in_array('1132', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Sainte-Catherine, QC
                                </option>
                                <option class="level-0"
                                        value="1148" {{ in_array('1148', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Lake Country, BC
                                </option>
                                <option class="level-0"
                                        value="1164" {{ in_array('1164', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Terrace, BC
                                </option>
                                <option class="level-0"
                                        value="1180" {{ in_array('1180', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    North Battleford, SK
                                </option>
                                <option class="level-0"
                                        value="1196" {{ in_array('1196', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Sainte-Marie, QC
                                </option>
                                <option class="level-0"
                                        value="1212" {{ in_array('1212', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Prevost, QC
                                </option>
                                <option class="level-0"
                                        value="1228" {{ in_array('1228', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    L'Ile-Perrot, QC
                                </option>
                                <option class="level-0"
                                        value="1244" {{ in_array('1244', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Coldstream, BC
                                </option>
                                <option class="level-0"
                                        value="1260" {{ in_array('1260', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Morinville, AB
                                </option>
                                <option class="level-0"
                                        value="1276" {{ in_array('1276', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Cavan Monaghan, ON
                                </option>
                                <option class="level-0"
                                        value="1292" {{ in_array('1292', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Lorraine, QC
                                </option>
                                <option class="level-0"
                                        value="1308" {{ in_array('1308', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Shelburne, ON
                                </option>
                                <option class="level-0"
                                        value="1324" {{ in_array('1324', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Otterburn Park, QC
                                </option>
                                <option class="level-0"
                                        value="1340" {{ in_array('1340', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Kitimat, BC
                                </option>
                                <option class="level-0"
                                        value="1356" {{ in_array('1356', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Nicolet, QC
                                </option>
                                <option class="level-0"
                                        value="1372" {{ in_array('1372', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    McNab/Braeside, ON
                                </option>
                                <option class="level-0"
                                        value="1388" {{ in_array('1388', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Ponoka, AB
                                </option>
                                <option class="level-0"
                                        value="1404" {{ in_array('1404', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Edwardsburgh/Cardinal, ON
                                </option>
                                <option class="level-0"
                                        value="1420" {{ in_array('1420', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Muskoka Falls, ON
                                </option>
                                <option class="level-0"
                                        value="1436" {{ in_array('1436', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Clarenville, NL
                                </option>
                                <option class="level-0"
                                        value="1452" {{ in_array('1452', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    McMasterville, QC
                                </option>
                                <option class="level-0"
                                        value="1468" {{ in_array('1468', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Cesaire, QC
                                </option>
                                <option class="level-0"
                                        value="1484" {{ in_array('1484', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Trent Lakes, ON
                                </option>
                                <option class="level-0"
                                        value="1500" {{ in_array('1500', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Deer Lake, NL
                                </option>
                                <option class="level-0"
                                        value="1516" {{ in_array('1516', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Memramcook, NB
                                </option>
                                <option class="level-0"
                                        value="1532" {{ in_array('1532', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Chertsey, QC
                                </option>
                                <option class="level-0"
                                        value="1548" {{ in_array('1548', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Denis-de-Brompton, QC
                                </option>
                                <option class="level-0"
                                        value="1564" {{ in_array('1564', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Chateau-Richer, QC
                                </option>
                                <option class="level-0"
                                        value="1580" {{ in_array('1580', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Roxton Pond, QC
                                </option>
                                <option class="level-0"
                                        value="1596" {{ in_array('1596', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Danville, QC
                                </option>
                                <option class="level-0"
                                        value="1612" {{ in_array('1612', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Morin-Heights, QC
                                </option>
                                <option class="level-0"
                                        value="1628" {{ in_array('1628', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Rossland, BC
                                </option>
                                <option class="level-0"
                                        value="1644" {{ in_array('1644', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Ambroise, QC
                                </option>
                                <option class="level-0"
                                        value="1660" {{ in_array('1660', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Anselme, QC
                                </option>
                                <option class="level-0"
                                        value="1676" {{ in_array('1676', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Sulpice, QC
                                </option>
                                <option class="level-0"
                                        value="1692" {{ in_array('1692', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Compton, QC
                                </option>
                                <option class="level-0"
                                        value="1708" {{ in_array('1708', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Pictou, NS
                                </option>
                                <option class="level-0"
                                        value="1724" {{ in_array('1724', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Thurso, QC
                                </option>
                                <option class="level-0"
                                        value="1740" {{ in_array('1740', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Melancthon, ON
                                </option>
                                <option class="level-0"
                                        value="1756" {{ in_array('1756', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Errington, BC
                                </option>
                                <option class="level-0"
                                        value="1772" {{ in_array('1772', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    La Loche, SK
                                </option>
                                <option class="level-0"
                                        value="1788" {{ in_array('1788', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Atikokan, ON
                                </option>
                                <option class="level-0"
                                        value="1804" {{ in_array('1804', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Pamphile, QC
                                </option>
                                <option class="level-0"
                                        value="1820" {{ in_array('1820', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Ville-Marie, QC
                                </option>
                                <option class="level-0"
                                        value="1836" {{ in_array('1836', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Disraeli, QC
                                </option>
                                <option class="level-0"
                                        value="1852" {{ in_array('1852', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Basile, QC
                                </option>

                                <option class="level-0"
                                        value="1868" {{ in_array('1868', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Sicamous, BC
                                </option>
                                <option class="level-0"
                                        value="1884" {{ in_array('1884', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Logy Bay-Middle Cove-Outer Cove, NL
                                </option>
                                <option class="level-0"
                                        value="1900" {{ in_array('1900', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Grand Bank, NL
                                </option>
                                <option class="level-0"
                                        value="1916" {{ in_array('1916', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Charles-de-Bellechasse, QC
                                </option>
                                <option class="level-0"
                                        value="1932" {{ in_array('1932', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Quentin, NB
                                </option>
                                <option class="level-0"
                                        value="1948" {{ in_array('1948', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Sainte-Cecile-de-Milton, QC
                                </option>
                                <option class="level-0"
                                        value="1964" {{ in_array('1964', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Tofield, AB
                                </option>
                                <option class="level-0"
                                        value="1980" {{ in_array('1980', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Caplan, QC
                                </option>
                                <option class="level-0"
                                        value="1996" {{ in_array('1996', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Yellowhead, MB
                                </option>
                                <option class="level-0"
                                        value="2012" {{ in_array('2012', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    North Norfolk, MB
                                </option>
                                <option class="level-0"
                                        value="2028" {{ in_array('2028', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Liguori, QC
                                </option>
                                <option class="level-0"
                                        value="2044" {{ in_array('2044', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Manitouwadge, ON
                                </option>
                                <option class="level-0"
                                        value="2060" {{ in_array('2060', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Les Escoumins, QC
                                </option>
                                <option class="level-0"
                                        value="2076" {{ in_array('2076', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Georges-de-Cacouna, QC
                                </option>
                                <option class="level-0"
                                        value="2092" {{ in_array('2092', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Sacre-Coeur-Saguenay, QC
                                </option>
                                <option class="level-0"
                                        value="2108" {{ in_array('2108', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Deseronto, ON
                                </option>
                                <option class="level-0"
                                        value="2124" {{ in_array('2124', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Zacharie, QC
                                </option>
                                <option class="level-0"
                                        value="2140" {{ in_array('2140', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Fisher, MB
                                </option>
                                <option class="level-0"
                                        value="2156" {{ in_array('2156', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Jacques-le-Mineur, QC
                                </option>
                                <option class="level-0"
                                        value="2172" {{ in_array('2172', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Franklin Centre, QC
                                </option>
                                <option class="level-0"
                                        value="2188" {{ in_array('2188', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Messines, QC
                                </option>
                                <option class="level-0"
                                        value="2204" {{ in_array('2204', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Flavien, QC
                                </option>

                                <option class="level-0"
                                        value="2220" {{ in_array('2220', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Venise-en-Quebec, QC
                                </option>
                                <option class="level-0"
                                        value="2236" {{ in_array('2236', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    St. George, NB
                                </option>
                                <option class="level-0"
                                        value="2252" {{ in_array('2252', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Pangnirtung, NU
                                </option>
                                <option class="level-0"
                                        value="2268" {{ in_array('2268', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Pipestone, MB
                                </option>
                                <option class="level-0"
                                        value="2284" {{ in_array('2284', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Godmanchester, QC
                                </option>
                                <option class="level-0"
                                        value="2300" {{ in_array('2300', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    New Carlisle, QC
                                </option>
                                <option class="level-0"
                                        value="2316" {{ in_array('2316', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    St.-Charles, ON
                                </option>
                                <option class="level-0"
                                        value="2332" {{ in_array('2332', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Bruederheim, AB
                                </option>
                                <option class="level-0"
                                        value="2348" {{ in_array('2348', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Charlo, NB
                                </option>
                                <option class="level-0"
                                        value="2364" {{ in_array('2364', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    La Conception, QC
                                </option>
                                <option class="level-0"
                                        value="2380" {{ in_array('2380', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Montcalm, MB
                                </option>
                                <option class="level-0"
                                        value="2396" {{ in_array('2396', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Queensbury, NB
                                </option>
                                <option class="level-0"
                                        value="2412" {{ in_array('2412', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Moose Jaw No. 161, SK
                                </option>
                                <option class="level-0"
                                        value="2428" {{ in_array('2428', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint James, NB
                                </option>
                                <option class="level-0"
                                        value="2444" {{ in_array('2444', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Grand-Remous, QC
                                </option>
                                <option class="level-0"
                                        value="2460" {{ in_array('2460', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Alberton, PE
                                </option>
                                <option class="level-0"
                                        value="2476" {{ in_array('2476', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Carnduff, SK
                                </option>
                                <option class="level-0"
                                        value="2492" {{ in_array('2492', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    McKellar, ON
                                </option>
                                <option class="level-0"
                                        value="2508" {{ in_array('2508', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Upton, QC
                                </option>
                                <option class="level-0"
                                        value="2524" {{ in_array('2524', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Sainte-Marthe, QC
                                </option>
                                <option class="level-0"
                                        value="2540" {{ in_array('2540', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Eston, SK
                                </option>
                                <option class="level-0"
                                        value="2556" {{ in_array('2556', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Souris, PE
                                </option>
                                <option class="level-0"
                                        value="2572" {{ in_array('2572', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Delisle, SK
                                </option>
                                <option class="level-0"
                                        value="2588" {{ in_array('2588', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Gravelbourg, SK
                                </option>
                                <option class="level-0"
                                        value="2604" {{ in_array('2604', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Grand View, MB
                                </option>
                                <option class="level-0"
                                        value="3061" {{ in_array('3061', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Virtual
                                </option>
                                <option class="level-0"
                                        value="117" {{ in_array('117', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Victoria, TX
                                </option>
                                <option class="level-0"
                                        value="372" {{ in_array('372', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saskatoon
                                </option>
                                <option class="level-0"
                                        value="388" {{ in_array('388', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    San Francisco
                                </option>
                                <option class="level-0"
                                        value="893" {{ in_array('893', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Surrey, BC
                                </option>
                                <option class="level-0"
                                        value="909" {{ in_array('909', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Richmond, BC
                                </option>
                                <option class="level-0"
                                        value="925" {{ in_array('925', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Milton, ON
                                </option>
                                <option class="level-0"
                                        value="941" {{ in_array('941', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Lethbridge, AB
                                </option>
                                <option class="level-0"
                                        value="957" {{ in_array('957', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Chateauguay, QC
                                </option>
                                <option class="level-0"
                                        value="973" {{ in_array('973', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Mirabel, QC
                                </option>
                                <option class="level-0"
                                        value="989" {{ in_array('989', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Dollard-des-Ormeaux, QC
                                </option>
                                <option class="level-0"
                                        value="1005" {{ in_array('1005', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Boucherville, QC
                                </option>
                                <option class="level-0"
                                        value="1021" {{ in_array('1021', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Moose Jaw, SK
                                </option>
                                <option class="level-0"
                                        value="1037" {{ in_array('1037', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Constant, QC
                                </option>
                                <option class="level-0"
                                        value="1053" {{ in_array('1053', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Midland, ON
                                </option>

                                <option class="level-0"
                                        value="1069" {{ in_array('1069', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Tecumseh, ON
                                </option>
                                <option class="level-0"
                                        value="1085" {{ in_array('1085', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Wilmot, ON
                                </option>
                                <option class="level-0"
                                        value="1101" {{ in_array('1101', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Sainte-Marthe-sur-le-Lac, QC
                                </option>
                                <option class="level-0"
                                        value="1117" {{ in_array('1117', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Camrose, AB
                                </option>
                                <option class="level-0"
                                        value="1133" {{ in_array('1133', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Port Hope, ON
                                </option>
                                <option class="level-0"
                                        value="1149" {{ in_array('1149', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Hanover, MB
                                </option>
                                <option class="level-0"
                                        value="1165" {{ in_array('1165', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Mercier, QC
                                </option>
                                <option class="level-0"
                                        value="1181" {{ in_array('1181', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Mont-Laurier, QC
                                </option>
                                <option class="level-0"
                                        value="1197" {{ in_array('1197', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    North Perth, ON
                                </option>
                                <option class="level-0"
                                        value="1213" {{ in_array('1213', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Sainte-Adele, QC
                                </option>
                                <option class="level-0"
                                        value="1229" {{ in_array('1229', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Summerland, BC
                                </option>
                                <option class="level-0"
                                        value="1245" {{ in_array('1245', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Georgian Bluffs, ON
                                </option>
                                <option class="level-0"
                                        value="1261" {{ in_array('1261', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Blackfalds, AB
                                </option>
                                <option class="level-0"
                                        value="1277" {{ in_array('1277', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Morden, MB
                                </option>
                                <option class="level-0"
                                        value="1293" {{ in_array('1293', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Ramara, ON
                                </option>
                                <option class="level-0"
                                        value="1309" {{ in_array('1309', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Stanley, MB
                                </option>
                                <option class="level-0"
                                        value="1325" {{ in_array('1325', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Sainte-Brigitte-de-Laval, QC
                                </option>
                                <option class="level-0"
                                        value="1341" {{ in_array('1341', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Macdonald, MB
                                </option>
                                <option class="level-0"
                                        value="1357" {{ in_array('1357', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Rockwood, MB
                                </option>
                                <option class="level-0"
                                        value="1373" {{ in_array('1373', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Central Huron, ON
                                </option>
                                <option class="level-0"
                                        value="1389" {{ in_array('1389', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Southgate, ON
                                </option>
                                <option class="level-0"
                                        value="1405" {{ in_array('1405', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Sainte-Anne-des-Monts, QC
                                </option>
                                <option class="level-0"
                                        value="1421" {{ in_array('1421', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Cornwall, PE
                                </option>
                                <option class="level-0"
                                        value="1437" {{ in_array('1437', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Mont-Joli, QC
                                </option>
                                <option class="level-0"
                                        value="1453" {{ in_array('1453', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Douglas, NB
                                </option>
                                <option class="level-0"
                                        value="1469" {{ in_array('1469', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Tay Valley, ON
                                </option>
                                <option class="level-0"
                                        value="1485" {{ in_array('1485', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Northern Rockies, BC
                                </option>
                                <option class="level-0"
                                        value="1501" {{ in_array('1501', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Woodstock, NB
                                </option>
                                <option class="level-0"
                                        value="1517" {{ in_array('1517', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Sainte-Anne-de-Bellevue, QC
                                </option>
                                <option class="level-0"
                                        value="1533" {{ in_array('1533', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Shippagan, NB
                                </option>
                                <option class="level-0"
                                        value="1549" {{ in_array('1549', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Jasper, AB
                                </option>
                                <option class="level-0"
                                        value="1565" {{ in_array('1565', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint Stephen, NB
                                </option>
                                <option class="level-0"
                                        value="1581" {{ in_array('1581', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Etienne-des-Gres, QC
                                </option>
                                <option class="level-0"
                                        value="1597" {{ in_array('1597', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Channel-Port aux Basques, NL
                                </option>
                                <option class="level-0"
                                        value="1613" {{ in_array('1613', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Dundas, NB
                                </option>
                                <option class="level-0"
                                        value="1629" {{ in_array('1629', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Mackenzie, BC
                                </option>
                                <option class="level-0"
                                        value="1645" {{ in_array('1645', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Westville, NS
                                </option>
                                <option class="level-0"
                                        value="1661" {{ in_array('1661', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Trois-Pistoles, QC
                                </option>
                                <option class="level-0"
                                        value="1677" {{ in_array('1677', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Penhold, AB
                                </option>

                                <option class="level-0"
                                        value="1693" {{ in_array('1693', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Shuniah, ON
                                </option>
                                <option class="level-0"
                                        value="1709" {{ in_array('1709', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Tisdale, SK
                                </option>
                                <option class="level-0"
                                        value="1725" {{ in_array('1725', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Wellington, NB
                                </option>
                                <option class="level-0"
                                        value="1741" {{ in_array('1741', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Cap Sante, QC
                                </option>
                                <option class="level-0"
                                        value="1757" {{ in_array('1757', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Wawa, ON
                                </option>
                                <option class="level-0"
                                        value="1773" {{ in_array('1773', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Ferme-Neuve, QC
                                </option>

                                <option class="level-0"
                                        value="1789" {{ in_array('1789', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Grenville-sur-la-Rouge, QC
                                </option>
                                <option class="level-0"
                                        value="1805" {{ in_array('1805', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Bedford, QC
                                </option>
                                <option class="level-0"
                                        value="1821" {{ in_array('1821', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Wickham, QC
                                </option>
                                <option class="level-0"
                                        value="1837" {{ in_array('1837', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Meadow Lake No. 588, SK
                                </option>
                                <option class="level-0"
                                        value="1853" {{ in_array('1853', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Raphael, QC
                                </option>
                                <option class="level-0"
                                        value="1869" {{ in_array('1869', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Cap Pele, NB
                                </option>
                                <option class="level-0"
                                        value="1885" {{ in_array('1885', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Buctouche, NB
                                </option>
                                <option class="level-0"
                                        value="1901" {{ in_array('1901', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Waterville, QC
                                </option>
                                <option class="level-0"
                                        value="1917" {{ in_array('1917', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Fogo Island, NL
                                </option>
                                <option class="level-0"
                                        value="1933" {{ in_array('1933', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Lebel-sur-Quevillon, QC
                                </option>
                                <option class="level-0"
                                        value="1949" {{ in_array('1949', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Roch-de-Richelieu, QC
                                </option>
                                <option class="level-0"
                                        value="1965" {{ in_array('1965', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Madoc, ON
                                </option>
                                <option class="level-0"
                                        value="1981" {{ in_array('1981', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Allardville, NB
                                </option>
                                <option class="level-0"
                                        value="1997" {{ in_array('1997', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Swan Valley West, MB
                                </option>
                                <option class="level-0"
                                        value="2013" {{ in_array('2013', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Reinland, MB
                                </option>
                                <option class="level-0"
                                        value="2029" {{ in_array('2029', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint Mary, NB
                                </option>
                                <option class="level-0"
                                        value="2045" {{ in_array('2045', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Wellington, ON
                                </option>
                                <option class="level-0"
                                        value="2061" {{ in_array('2061', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Richibucto, NB
                                </option>
                                <option class="level-0"
                                        value="2077" {{ in_array('2077', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Lakeview, BC
                                </option>
                                <option class="level-0"
                                        value="2093" {{ in_array('2093', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Louis, NB
                                </option>
                                <option class="level-0"
                                        value="2109" {{ in_array('2109', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Lamont, AB
                                </option>
                                <option class="level-0"
                                        value="2125" {{ in_array('2125', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Hemmingford, QC
                                </option>
                                <option class="level-0"
                                        value="2141" {{ in_array('2141', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Sainte-Clotilde, QC
                                </option>
                                <option class="level-0"
                                        value="2157" {{ in_array('2157', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Coombs, BC
                                </option>
                                <option class="level-0"
                                        value="2173" {{ in_array('2173', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Harbour Breton, NL
                                </option>
                                <option class="level-0"
                                        value="2189" {{ in_array('2189', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Laurent-de-l'Ile-d'Orleans, QC
                                </option>
                                <option class="level-0"
                                        value="2205" {{ in_array('2205', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Boissevain, MB
                                </option>
                                <option class="level-0"
                                        value="2221" {{ in_array('2221', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Gambo, NL
                                </option>
                                <option class="level-0"
                                        value="2237" {{ in_array('2237', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Wembley, AB
                                </option>
                                <option class="level-0"
                                        value="2253" {{ in_array('2253', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Louis-de-Gonzague, QC
                                </option>
                                <option class="level-0"
                                        value="2269" {{ in_array('2269', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    La Dore, QC
                                </option>
                                <option class="level-0"
                                        value="2285" {{ in_array('2285', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Macklin, SK
                                </option>
                                <option class="level-0"
                                        value="2301" {{ in_array('2301', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Laird No. 404, SK
                                </option>
                                <option class="level-0"
                                        value="2317" {{ in_array('2317', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Cardwell, NB
                                </option>
                                <option class="level-0"
                                        value="2333" {{ in_array('2333', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Oxbow, SK
                                </option>
                                <option class="level-0"
                                        value="2349" {{ in_array('2349', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Sorrento, BC
                                </option>
                                <option class="level-0"
                                        value="2365" {{ in_array('2365', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Vauxhall, AB
                                </option>
                                <option class="level-0"
                                        value="2381" {{ in_array('2381', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Irishtown-Summerside, NL
                                </option>
                                <option class="level-0"
                                        value="2397" {{ in_array('2397', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Hubert-de-Riviere-du-Loup, QC
                                </option>
                                <option class="level-0"
                                        value="2413" {{ in_array('2413', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Bassano, AB
                                </option>
                                <option class="level-0"
                                        value="2429" {{ in_array('2429', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Norbert-d'Arthabaska, QC
                                </option>
                                <option class="level-0"
                                        value="2445" {{ in_array('2445', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Gabriel-de-Rimouski, QC
                                </option>
                                <option class="level-0"
                                        value="2461" {{ in_array('2461', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Winnipeg Beach, MB
                                </option>
                                <option class="level-0"
                                        value="2477" {{ in_array('2477', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Greenwich, NB
                                </option>
                                <option class="level-0"
                                        value="2493" {{ in_array('2493', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Buffalo Narrows, SK
                                </option>
                                <option class="level-0"
                                        value="2509" {{ in_array('2509', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Narcisse-de-Beaurivage, QC
                                </option>

                                <option class="level-0"
                                        value="2525" {{ in_array('2525', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Notre-Dame-du-Nord, QC
                                </option>
                                <option class="level-0"
                                        value="2541" {{ in_array('2541', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Sainte-Genevieve-de-Batiscan, QC
                                </option>
                                <option class="level-0"
                                        value="2557" {{ in_array('2557', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Kindersley No. 290, SK
                                </option>
                                <option class="level-0"
                                        value="2573" {{ in_array('2573', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Plaster Rock, NB
                                </option>
                                <option class="level-0"
                                        value="2589" {{ in_array('2589', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Lajord No. 128, SK
                                </option>
                                <option class="level-0"
                                        value="2605" {{ in_array('2605', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Dildo, NL
                                </option>
                                <option class="level-0"
                                        value="3308" {{ in_array('3308', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Mississauga
                                </option>
                                <option class="level-0"
                                        value="118" {{ in_array('118', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Montreal, QE
                                </option>
                                <option class="level-0"
                                        value="373" {{ in_array('373', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Halifax
                                </option>
                                <option class="level-0"
                                        value="389" {{ in_array('389', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Indianapolis
                                </option>
                                <option class="level-0"
                                        value="894" {{ in_array('894', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Kitchener, ON
                                </option>
                                <option class="level-0"
                                        value="910" {{ in_array('910', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Richmond Hill, ON
                                </option>
                                <option class="level-0"
                                        value="926" {{ in_array('926', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Ajax, ON
                                </option>
                                <option class="level-0"
                                        value="942" {{ in_array('942', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Kamloops, BC
                                </option>
                                <option class="level-0"
                                        value="958" {{ in_array('958', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Belleville, ON
                                </option>
                                <option class="level-0"
                                        value="974" {{ in_array('974', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Blainville, QC
                                </option>
                                <option class="level-0"
                                        value="990" {{ in_array('990', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Cornwall, ON
                                </option>
                                <option class="level-0"
                                        value="1006" {{ in_array('1006', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Mission, BC
                                </option>
                                <option class="level-0"
                                        value="1022" {{ in_array('1022', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Port Moody, BC
                                </option>
                                <option class="level-0"
                                        value="1038" {{ in_array('1038', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Langley, BC
                                </option>
                                <option class="level-0"
                                        value="1054" {{ in_array('1054', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Thetford Mines, QC
                                </option>
                                <option class="level-0"
                                        value="1070" {{ in_array('1070', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Candiac, QC
                                </option>
                                <option class="level-0"
                                        value="1086" {{ in_array('1086', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Essex, ON
                                </option>
                                <option class="level-0"
                                        value="1102" {{ in_array('1102', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Lloydminster, AB
                                </option>
                                <option class="level-0"
                                        value="1118" {{ in_array('1118', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Selwyn, ON
                                </option>
                                <option class="level-0"
                                        value="1134" {{ in_array('1134', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Inverness, NS
                                </option>
                                <option class="level-0"
                                        value="1150" {{ in_array('1150', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Winkler, MB
                                </option>
                                <option class="level-0"
                                        value="1166" {{ in_array('1166', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    West Lincoln, ON
                                </option>
                                <option class="level-0"
                                        value="1182" {{ in_array('1182', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Central Elgin, ON
                                </option>
                                <option class="level-0"
                                        value="1198" {{ in_array('1198', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Thompson, MB
                                </option>

                                <option class="level-0"
                                        value="1214" {{ in_array('1214', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Sainte-Agathe-des-Monts, QC
                                </option>
                                <option class="level-0"
                                        value="1230" {{ in_array('1230', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    St. Clements, MB
                                </option>
                                <option class="level-0"
                                        value="1246" {{ in_array('1246', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Weyburn, SK
                                </option>
                                <option class="level-0"
                                        value="1262" {{ in_array('1262', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Chester, NS
                                </option>
                                <option class="level-0"
                                        value="1278" {{ in_array('1278', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Temiskaming Shores, ON
                                </option>
                                <option class="level-0"
                                        value="1294" {{ in_array('1294', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Notre-Dame-des-Prairies, QC
                                </option>
                                <option class="level-0"
                                        value="1310" {{ in_array('1310', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Taber, AB
                                </option>
                                <option class="level-0"
                                        value="1326" {{ in_array('1326', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Sainte-Catherine-de-la-Jacques-Cartier, QC
                                </option>
                                <option class="level-0"
                                        value="1342" {{ in_array('1342', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Happy Valley, NL
                                </option>
                                <option class="level-0"
                                        value="1358" {{ in_array('1358', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Drummond/North Elmsley, ON
                                </option>
                                <option class="level-0"
                                        value="1374" {{ in_array('1374', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Rigaud, QC
                                </option>
                                <option class="level-0"
                                        value="1390" {{ in_array('1390', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Les Cedres, QC
                                </option>
                                <option class="level-0"
                                        value="1406" {{ in_array('1406', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Bay Roberts, NL
                                </option>
                                <option class="level-0"
                                        value="1422" {{ in_array('1422', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Paul, QC
                                </option>
                                <option class="level-0"
                                        value="1438" {{ in_array('1438', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Pointe-Calumet, QC
                                </option>
                                <option class="level-0"
                                        value="1454" {{ in_array('1454', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Calixte, QC
                                </option>
                                <option class="level-0"
                                        value="1470" {{ in_array('1470', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    South Bruce, ON
                                </option>
                                <option class="level-0"
                                        value="1486" {{ in_array('1486', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Gananoque, ON
                                </option>
                                <option class="level-0"
                                        value="1502" {{ in_array('1502', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Flin Flon, SK
                                </option>
                                <option class="level-0"
                                        value="1518" {{ in_array('1518', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Stirling-Rawdon, ON
                                </option>
                                <option class="level-0"
                                        value="1534" {{ in_array('1534', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Lanoraie, QC
                                </option>
                                <option class="level-0"
                                        value="1550" {{ in_array('1550', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Barrhead, AB
                                </option>
                                <option class="level-0"
                                        value="1566" {{ in_array('1566', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Nipawin, SK
                                </option>
                                <option class="level-0"
                                        value="1582" {{ in_array('1582', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Grand Forks, BC
                                </option>
                                <option class="level-0"
                                        value="1598" {{ in_array('1598', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Lac-Etchemin, QC
                                </option>
                                <option class="level-0"
                                        value="1614" {{ in_array('1614', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Simonds, NB
                                </option>
                                <option class="level-0"
                                        value="1630" {{ in_array('1630', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Golden, BC
                                </option>
                                <option class="level-0"
                                        value="1646" {{ in_array('1646', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Hay River, NT
                                </option>
                                <option class="level-0"
                                        value="1662" {{ in_array('1662', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Grande-Riviere, QC
                                </option>
                                <option class="level-0"
                                        value="1678" {{ in_array('1678', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Powassan, ON
                                </option>
                                <option class="level-0"
                                        value="1694" {{ in_array('1694', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Inuvik, NT
                                </option>
                                <option class="level-0"
                                        value="1710" {{ in_array('1710', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Lake of Bays, ON
                                </option>
                                <option class="level-0"
                                        value="1726" {{ in_array('1726', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Cedar, BC
                                </option>
                                <option class="level-0"
                                        value="1742" {{ in_array('1742', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-David-de-Falardeau, QC
                                </option>
                                <option class="level-0"
                                        value="1758" {{ in_array('1758', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Sainte-Melanie, QC
                                </option>
                                <option class="level-0"
                                        value="1774" {{ in_array('1774', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Yamachiche, QC
                                </option>
                                <option class="level-0"
                                        value="1790" {{ in_array('1790', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    North Cypress-Langford, MB
                                </option>
                                <option class="level-0"
                                        value="1806" {{ in_array('1806', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Weedon-Centre, QC
                                </option>
                                <option class="level-0"
                                        value="1822" {{ in_array('1822', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Shippegan, NB
                                </option>

                                <option class="level-0"
                                        value="1838" {{ in_array('1838', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Elkford, BC
                                </option>
                                <option class="level-0"
                                        value="1854" {{ in_array('1854', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Martin, QC
                                </option>
                                <option class="level-0"
                                        value="1870" {{ in_array('1870', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Kelsey, MB
                                </option>
                                <option class="level-0"
                                        value="1886" {{ in_array('1886', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Grand Manan, NB
                                </option>
                                <option class="level-0"
                                        value="1902" {{ in_array('1902', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Minto, NB
                                </option>
                                <option class="level-0"
                                        value="1918" {{ in_array('1918', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Neebing, ON
                                </option>
                                <option class="level-0"
                                        value="1934" {{ in_array('1934', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Calmar, AB
                                </option>
                                <option class="level-0"
                                        value="1950" {{ in_array('1950', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Burns Lake, BC
                                </option>
                                <option class="level-0"
                                        value="1966" {{ in_array('1966', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Sainte-Anne-de-Sabrevois, QC
                                </option>
                                <option class="level-0"
                                        value="1982" {{ in_array('1982', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Damien, QC
                                </option>
                                <option class="level-0"
                                        value="1998" {{ in_array('1998', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Grey, MB
                                </option>
                                <option class="level-0"
                                        value="2014" {{ in_array('2014', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Minitonas-Bowsman, MB
                                </option>
                                <option class="level-0"
                                        value="2030" {{ in_array('2030', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Patrice-de-Sherrington, QC
                                </option>
                                <option class="level-0"
                                        value="2046" {{ in_array('2046', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Frontenac Islands, ON
                                </option>
                                <option class="level-0"
                                        value="2062" {{ in_array('2062', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Terrasse-Vaudreuil, QC
                                </option>
                                <option class="level-0"
                                        value="2078" {{ in_array('2078', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Sainte-Justine, QC
                                </option>
                                <option class="level-0"
                                        value="2094" {{ in_array('2094', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Lucien, QC
                                </option>
                                <option class="level-0"
                                        value="2110" {{ in_array('2110', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Chambord, QC
                                </option>
                                <option class="level-0"
                                        value="2126" {{ in_array('2126', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Pierre-de-l'Ile-d'Orleans, QC
                                </option>
                                <option class="level-0"
                                        value="2142" {{ in_array('2142', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Lantz, NS
                                </option>
                                <option class="level-0"
                                        value="2158" {{ in_array('2158', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Val-Joli, QC
                                </option>
                                <option class="level-0"
                                        value="2174" {{ in_array('2174', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Mille-Isles, QC
                                </option>
                                <option class="level-0"
                                        value="2190" {{ in_array('2190', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Jean-de-Dieu, QC
                                </option>
                                <option class="level-0"
                                        value="2206" {{ in_array('2206', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Sainte-Marcelline-de-Kildare, QC
                                </option>
                                <option class="level-0"
                                        value="2222" {{ in_array('2222', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Nauwigewauk, NB
                                </option>
                                <option class="level-0"
                                        value="2238" {{ in_array('2238', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Macdonald, Meredith and Aberdeen Additional, ON
                                </option>

                                <option class="level-0"
                                        value="2254" {{ in_array('2254', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Moosonee, ON
                                </option>
                                <option class="level-0"
                                        value="2270" {{ in_array('2270', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Lac-au-Saumon, QC
                                </option>
                                <option class="level-0"
                                        value="2286" {{ in_array('2286', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Armour, ON
                                </option>
                                <option class="level-0"
                                        value="2302" {{ in_array('2302', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Majorique-de-Grantham, QC
                                </option>
                                <option class="level-0"
                                        value="2318" {{ in_array('2318', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Amulet, QC
                                </option>
                                <option class="level-0"
                                        value="2334" {{ in_array('2334', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Telkwa, BC
                                </option>
                                <option class="level-0"
                                        value="2350" {{ in_array('2350', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Burgeo, NL
                                </option>

                                <option class="level-0"
                                        value="2366" {{ in_array('2366', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Lameque, NB
                                </option>
                                <option class="level-0"
                                        value="2382" {{ in_array('2382', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Clarendon, QC
                                </option>
                                <option class="level-0"
                                        value="2398" {{ in_array('2398', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Jude, QC
                                </option>
                                <option class="level-0"
                                        value="2414" {{ in_array('2414', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Parrsboro, NS
                                </option>
                                <option class="level-0"
                                        value="2430" {{ in_array('2430', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Manning, AB
                                </option>
                                <option class="level-0"
                                        value="2446" {{ in_array('2446', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Armstrong, ON
                                </option>
                                <option class="level-0"
                                        value="2462" {{ in_array('2462', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Sainte-Agathe-de-Lotbiniere, QC
                                </option>
                                <option class="level-0"
                                        value="2478" {{ in_array('2478', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Carling, ON
                                </option>
                                <option class="level-0"
                                        value="2494" {{ in_array('2494', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Ayer's Cliff, QC
                                </option>
                                <option class="level-0"
                                        value="2510" {{ in_array('2510', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Plaisance, QC
                                </option>
                                <option class="level-0"
                                        value="2526" {{ in_array('2526', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Beachburg, ON
                                </option>
                                <option class="level-0"
                                        value="2542" {{ in_array('2542', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Justin, QC
                                </option>
                                <option class="level-0"
                                        value="2558" {{ in_array('2558', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Falher, AB
                                </option>
                                <option class="level-0"
                                        value="2574" {{ in_array('2574', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Wilmot, NB
                                </option>
                                <option class="level-0"
                                        value="2590" {{ in_array('2590', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Hebertville, QC
                                </option>
                                <option class="level-0"
                                        value="2606" {{ in_array('2606', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Laurierville, QC
                                </option>
                                <option class="level-0"
                                        value="3307" {{ in_array('3307', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    ON
                                </option>
                                <option class="level-0"
                                        value="884" {{ in_array('884', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Vancouver, BC
                                </option>
                                <option class="level-0"
                                        value="374" {{ in_array('374', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Winnipeg
                                </option>
                                <option class="level-0"
                                        value="390" {{ in_array('390', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Columbus
                                </option>
                                <option class="level-0"
                                        value="895" {{ in_array('895', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Halifax, NS
                                </option>
                                <option class="level-0"
                                        value="911" {{ in_array('911', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Burlington, ON
                                </option>
                                <option class="level-0"
                                        value="927" {{ in_array('927', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Waterloo, ON
                                </option>
                                <option class="level-0"
                                        value="943" {{ in_array('943', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Jean-sur-Richelieu, QC
                                </option>
                                <option class="level-0"
                                        value="959" {{ in_array('959', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Airdrie, AB
                                </option>
                                <option class="level-0"
                                        value="975" {{ in_array('975', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Lac-Brome, QC
                                </option>
                                <option class="level-0"
                                        value="991" {{ in_array('991', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Victoriaville, QC
                                </option>

                                <option class="level-0"
                                        value="1007" {{ in_array('1007', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Timmins, ON
                                </option>
                                <option class="level-0"
                                        value="1023" {{ in_array('1023', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Pointe-Claire, QC
                                </option>
                                <option class="level-0"
                                        value="1039" {{ in_array('1039', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Grimsby, ON
                                </option>
                                <option class="level-0"
                                        value="1055" {{ in_array('1055', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Lincoln, ON
                                </option>
                                <option class="level-0"
                                        value="1071" {{ in_array('1071', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Essa, ON
                                </option>
                                <option class="level-0"
                                        value="1087" {{ in_array('1087', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Varennes, QC
                                </option>
                                <option class="level-0"
                                        value="1103" {{ in_array('1103', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Westmount, QC
                                </option>
                                <option class="level-0"
                                        value="1119" {{ in_array('1119', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Tillsonburg, ON
                                </option>
                                <option class="level-0"
                                        value="1135" {{ in_array('1135', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Basile-le-Grand, QC
                                </option>
                                <option class="level-0"
                                        value="1151" {{ in_array('1151', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Charles-Borromee, QC
                                </option>
                                <option class="level-0"
                                        value="1167" {{ in_array('1167', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Lavaltrie, QC
                                </option>
                                <option class="level-0"
                                        value="1183" {{ in_array('1183', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Mistassini, QC
                                </option>
                                <option class="level-0"
                                        value="1199" {{ in_array('1199', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Trent Hills, ON
                                </option>
                                <option class="level-0"
                                        value="1215" {{ in_array('1215', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Quesnel, BC
                                </option>
                                <option class="level-0"
                                        value="1231" {{ in_array('1231', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    View Royal, BC
                                </option>
                                <option class="level-0"
                                        value="1247" {{ in_array('1247', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    La Tuque, QC
                                </option>
                                <option class="level-0"
                                        value="1263" {{ in_array('1263', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Queens, NS
                                </option>
                                <option class="level-0"
                                        value="1279" {{ in_array('1279', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Hinton, AB
                                </option>
                                <option class="level-0"
                                        value="1295" {{ in_array('1295', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Leeds and the Thousand Islands, ON
                                </option>
                                <option class="level-0"
                                        value="1311" {{ in_array('1311', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Donnacona, QC
                                </option>
                                <option class="level-0"
                                        value="1327" {{ in_array('1327', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    South Bruce Peninsula, ON
                                </option>
                                <option class="level-0"
                                        value="1343" {{ in_array('1343', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Hippolyte, QC
                                </option>
                                <option class="level-0"
                                        value="1359" {{ in_array('1359', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Contrecoeur, QC
                                </option>
                                <option class="level-0"
                                        value="1375" {{ in_array('1375', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Louiseville, QC
                                </option>
                                <option class="level-0"
                                        value="1391" {{ in_array('1391', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Baie-Saint-Paul, QC
                                </option>
                                <option class="level-0"
                                        value="1407" {{ in_array('1407', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Wainfleet, ON
                                </option>
                                <option class="level-0"
                                        value="1423" {{ in_array('1423', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Devon, AB
                                </option>
                                <option class="level-0"
                                        value="1439" {{ in_array('1439', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Dysart et al, ON
                                </option>
                                <option class="level-0"
                                        value="1455" {{ in_array('1455', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Lac-Megantic, QC
                                </option>
                                <option class="level-0"
                                        value="1471" {{ in_array('1471', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Antigonish, NS
                                </option>

                                <option class="level-0"
                                        value="1487" {{ in_array('1487', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Windsor, QC
                                </option>
                                <option class="level-0"
                                        value="1503" {{ in_array('1503', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Brokenhead, MB
                                </option>
                                <option class="level-0"
                                        value="1519" {{ in_array('1519', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Mont-Orford, QC
                                </option>
                                <option class="level-0"
                                        value="1535" {{ in_array('1535', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Centre Hastings, ON
                                </option>
                                <option class="level-0"
                                        value="1551" {{ in_array('1551', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Melville, SK
                                </option>
                                <option class="level-0"
                                        value="1567" {{ in_array('1567', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Battleford, SK
                                </option>
                                <option class="level-0"
                                        value="1583" {{ in_array('1583', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    New Maryland, NB
                                </option>
                                <option class="level-0"
                                        value="1599" {{ in_array('1599', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Jacques, QC
                                </option>
                                <option class="level-0"
                                        value="1615" {{ in_array('1615', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Crabtree, QC
                                </option>
                                <option class="level-0"
                                        value="1631" {{ in_array('1631', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Adolphe-d'Howard, QC
                                </option>
                                <option class="level-0"
                                        value="1647" {{ in_array('1647', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Pasadena, NL
                                </option>
                                <option class="level-0"
                                        value="1663" {{ in_array('1663', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Malartic, QC
                                </option>
                                <option class="level-0"
                                        value="1679" {{ in_array('1679', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Highlands East, ON
                                </option>
                                <option class="level-0"
                                        value="1695" {{ in_array('1695', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Richmond, QC
                                </option>
                                <option class="level-0"
                                        value="1711" {{ in_array('1711', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Bishops Falls, NL
                                </option>
                                <option class="level-0"
                                        value="1727" {{ in_array('1727', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Gabriel, QC
                                </option>

                                <option class="level-0"
                                        value="1743" {{ in_array('1743', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Harbour Grace, NL
                                </option>
                                <option class="level-0"
                                        value="1759" {{ in_array('1759', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Horton, ON
                                </option>
                                <option class="level-0"
                                        value="1775" {{ in_array('1775', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Adstock, QC
                                </option>
                                <option class="level-0"
                                        value="1791" {{ in_array('1791', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Dominique, QC
                                </option>
                                <option class="level-0"
                                        value="1807" {{ in_array('1807', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Lacolle, QC
                                </option>
                                <option class="level-0"
                                        value="1823" {{ in_array('1823', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    East Garafraxa, ON
                                </option>
                                <option class="level-0"
                                        value="1839" {{ in_array('1839', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Georgian Bay, ON
                                </option>
                                <option class="level-0"
                                        value="1855" {{ in_array('1855', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Causapscal, QC
                                </option>
                                <option class="level-0"
                                        value="1871" {{ in_array('1871', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Killaloe, Hagarty and Richards, ON
                                </option>
                                <option class="level-0"
                                        value="1887" {{ in_array('1887', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Sainte-Madeleine, QC
                                </option>
                                <option class="level-0"
                                        value="1903" {{ in_array('1903', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Rosthern No. 403, SK
                                </option>
                                <option class="level-0"
                                        value="1919" {{ in_array('1919', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Port McNeill, BC
                                </option>
                                <option class="level-0"
                                        value="1935" {{ in_array('1935', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Nanton, AB
                                </option>
                                <option class="level-0"
                                        value="1951" {{ in_array('1951', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Redwater, AB
                                </option>
                                <option class="level-0"
                                        value="1967" {{ in_array('1967', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Sainte-Anne-de-la-Perade, QC
                                </option>
                                <option class="level-0"
                                        value="1983" {{ in_array('1983', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Lac-Nominingue, QC
                                </option>
                                <option class="level-0"
                                        value="1999" {{ in_array('1999', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Gilbert Plains, MB
                                </option>
                                <option class="level-0"
                                        value="2015" {{ in_array('2015', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Kippens, NL
                                </option>
                                <option class="level-0"
                                        value="2031" {{ in_array('2031', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Fox Creek, AB
                                </option>
                                <option class="level-0"
                                        value="2047" {{ in_array('2047', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Point Edward, ON
                                </option>
                                <option class="level-0"
                                        value="2063" {{ in_array('2063', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Riviere-Beaudette, QC
                                </option>
                                <option class="level-0"
                                        value="2079" {{ in_array('2079', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Valerien-de-Milton, QC
                                </option>
                                <option class="level-0"
                                        value="2095" {{ in_array('2095', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Victoria, NL
                                </option>
                                <option class="level-0"
                                        value="2111" {{ in_array('2111', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Maugerville, NB
                                </option>
                                <option class="level-0"
                                        value="2127" {{ in_array('2127', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Kensington, PE
                                </option>
                                <option class="level-0"
                                        value="2143" {{ in_array('2143', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Wicklow, NB
                                </option>
                                <option class="level-0"
                                        value="2159" {{ in_array('2159', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Southesk, NB
                                </option>
                                <option class="level-0"
                                        value="2175" {{ in_array('2175', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Naramata, BC
                                </option>
                                <option class="level-0"
                                        value="2191" {{ in_array('2191', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Massey Drive, NL
                                </option>
                                <option class="level-0"
                                        value="2207" {{ in_array('2207', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Riviere-Blanche, QC
                                </option>
                                <option class="level-0"
                                        value="2223" {{ in_array('2223', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Humbermouth, NL
                                </option>
                                <option class="level-0"
                                        value="2239" {{ in_array('2239', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Pinawa, MB
                                </option>
                                <option class="level-0"
                                        value="2255" {{ in_array('2255', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Englehart, ON
                                </option>
                                <option class="level-0"
                                        value="2271" {{ in_array('2271', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Wotton, QC
                                </option>
                                <option class="level-0"
                                        value="2287" {{ in_array('2287', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Saint-Simon, QC
                                </option>
                                <option class="level-0"
                                        value="2303" {{ in_array('2303', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Petitcodiac, NB
                                </option>
                                <option class="level-0"
                                        value="2319" {{ in_array('2319', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    L'Avenir, QC
                                </option>
                                <option class="level-0"
                                        value="2335" {{ in_array('2335', (array) json_decode($offering->location)) ? 'selected' : '' }}>
                                    Landmark, MB
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">I help with:</label>

                            <select name="help" multiple="multiple" class="form-control select2">
                                <option class="level-0"
                                        value="255" {{ in_array('255', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Anemia in pregnancy
                                </option>
                                <option class="level-0"
                                        value="271" {{ in_array('271', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Depression
                                </option>
                                <option class="level-0"
                                        value="287" {{ in_array('287', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Hormonal birth control transition
                                </option>
                                <option class="level-0"
                                        value="303" {{ in_array('303', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Multiple sclerosis
                                </option>
                                <option class="level-0"
                                        value="396" {{ in_array('396', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Example Ailment
                                </option>
                                <option class="level-0"
                                        value="2663" {{ in_array('2663', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Behavioral issues
                                </option>
                                <option class="level-0"
                                        value="2679" {{ in_array('2679', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Headaches
                                </option>
                                <option class="level-0"
                                        value="2703" {{ in_array('2703', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Pregnancy Loss
                                </option>
                                <option class="level-0"
                                        value="2720" {{ in_array('2720', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Restlessness
                                </option>

                                <option class="level-0"
                                        value="2880" {{ in_array('2880', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Frustration
                                </option>
                                <option class="level-0"
                                        value="3104" {{ in_array('3104', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Hot Flashes and Night sweast
                                </option>
                                <option class="level-0"
                                        value="3148" {{ in_array('3148', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Persistent Postural Perceptual Dizziness (PPPD)
                                </option>
                                <option class="level-0"
                                        value="3297" {{ in_array('3297', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    pityriasis Alba
                                </option>
                                <option class="level-0"
                                        value="123" {{ in_array('123', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Dropsy
                                </option>
                                <option class="level-0"
                                        value="256" {{ in_array('256', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Ankylosing Spondylitis
                                </option>
                                <option class="level-0"
                                        value="272" {{ in_array('272', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Digestive issues
                                </option>
                                <option class="level-0"
                                        value="288" {{ in_array('282', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Hormone health
                                </option>
                                <option class="level-0"
                                        value="304" {{ in_array('304', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Nervous system dysregulation
                                </option>
                                <option class="level-0"
                                        value="2623" {{ in_array('2623', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Liver health
                                </option>
                                <option class="level-0"
                                        value="2664" {{ in_array('2664', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Birth trauma
                                </option>
                                <option class="level-0"
                                        value="2680" {{ in_array('2680', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Hemorrhoids
                                </option>
                                <option class="level-0"
                                        value="2704" {{ in_array('2704', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Pregnancy
                                </option>
                                <option class="level-0"
                                        value="2721" {{ in_array('2721', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Reflux (GERD)
                                </option>
                                <option class="level-0"
                                        value="2737" {{ in_array('2737', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Morning Sickness
                                </option>
                                <option class="level-0"
                                        value="2881" {{ in_array('2881', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Mood
                                </option>
                                <option class="level-0"
                                        value="3111" {{ in_array('3111', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Exhaustion
                                </option>
                                <option class="level-0"
                                        value="3149" {{ in_array('3149', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Repetitive Strain
                                </option>
                                <option class="level-0"
                                        value="3298" {{ in_array('3298', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    weight loss
                                </option>
                                <option class="level-0"
                                        value="125" {{ in_array('125', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Tremors
                                </option>
                                <option class="level-0"
                                        value="257" {{ in_array('257', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Anxieties
                                </option>
                                <option class="level-0"
                                        value="273" {{ in_array('273', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Disconnection
                                </option>
                                <option class="level-0"
                                        value="289" {{ in_array('289', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Insomnia
                                </option>
                                <option class="level-0"
                                        value="305" {{ in_array('305', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Nervous system regulation
                                </option>
                                <option class="level-0"
                                        value="2627" {{ in_array('2627', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    bloating
                                </option>
                                <option class="level-0"
                                        value="2665" {{ in_array('2665', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Breech
                                </option>
                                <option class="level-0"
                                        value="2681" {{ in_array('2681', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    High blood pressure
                                </option>
                                <option class="level-0"
                                        value="2705" {{ in_array('2705', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Neurological tics
                                </option>
                                <option class="level-0"
                                        value="2722" {{ in_array('2722', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Separation anxiety
                                </option>
                                <option class="level-0"
                                        value="2747" {{ in_array('2747', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Menopause
                                </option>
                                <option class="level-0"
                                        value="2882" {{ in_array('2882', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Relationships
                                </option>
                                <option class="level-0"
                                        value="3112" {{ in_array('3112', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Perfectionism
                                </option>
                                <option class="level-0"
                                        value="3150" {{ in_array('3150', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    neck pain
                                </option>
                                <option class="level-0"
                                        value="3299" {{ in_array('3299', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Pityriasis folliculitis (Malassezia) Weight loss
                                </option>
                                <option class="level-0"
                                        value="134" {{ in_array('134', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Nervous System Reset
                                </option>
                                <option class="level-0"
                                        value="258" {{ in_array('258', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Anxiety
                                </option>
                                <option class="level-0"
                                        value="274" {{ in_array('274', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Emotional balance and release
                                </option>
                                <option class="level-0"
                                        value="290" {{ in_array('290', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Joint pain
                                </option>
                                <option class="level-0"
                                        value="306" {{ in_array('306', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Overwhelm
                                </option>
                                <option class="level-0"
                                        value="2628" {{ in_array('2628', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Fatty liver
                                </option>
                                <option class="level-0"
                                        value="2666" {{ in_array('2720', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Colic
                                </option>
                                <option class="level-0"
                                        value="2682" {{ in_array('2682', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Hyperactivity
                                </option>
                                <option class="level-0"
                                        value="2706" {{ in_array('2706', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Nightmares
                                </option>
                                <option class="level-0"
                                        value="2723" {{ in_array('2723', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Seizures
                                </option>
                                <option class="level-0"
                                        value="2750" {{ in_array('2750', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Stress
                                </option>
                                <option class="level-0"
                                        value="2883" {{ in_array('2883', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Sleep
                                </option>
                                <option class="level-0"
                                        value="3113" {{ in_array('3113', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Leadership skills
                                </option>
                                <option class="level-0"
                                        value="3151" {{ in_array('3151', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Scoliosis
                                </option>
                                <option class="level-0"
                                        value="3300" {{ in_array('3300', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    coaching
                                </option>
                                <option class="level-0"
                                        value="135" {{ in_array('135', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Concussion Recovery
                                </option>
                                <option class="level-0"
                                        value="259" {{ in_array('259', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Body image
                                </option>
                                <option class="level-0"
                                        value="275" {{ in_array('275', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Emotional blocks
                                </option>
                                <option class="level-0"
                                        value="291" {{ in_array('291', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Lack of clarity
                                </option>
                                <option class="level-0"
                                        value="307" {{ in_array('307', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    PCOS (Polycystic Ovary Syndrome)
                                </option>
                                <option class="level-0"
                                        value="2648" {{ in_array('2648', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Muscle Tension
                                </option>
                                <option class="level-0"
                                        value="2667" {{ in_array('2667', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Developmental delays
                                </option>
                                <option class="level-0"
                                        value="2683" {{ in_array('2683', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Immune deficiencies
                                </option>
                                <option class="level-0"
                                        value="2707" {{ in_array('2707', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Night Terrors
                                </option>
                                <option class="level-0"
                                        value="2724" {{ in_array('2724', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Sensory issues
                                </option>
                                <option class="level-0"
                                        value="2751" {{ in_array('2751', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    migraines
                                </option>
                                <option class="level-0"
                                        value="2884" {{ in_array('2884', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Work
                                </option>
                                <option class="level-0"
                                        value="3114" {{ in_array('3114', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Money mindset
                                </option>
                                <option class="level-0"
                                        value="3152" {{ in_array('3152', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Skin Issues
                                </option>
                                <option class="level-0"
                                        value="3301" {{ in_array('3301', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    health coaching
                                </option>
                                <option class="level-0"
                                        value="136" {{ in_array('136', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Trauma Recovery
                                </option>
                                <option class="level-0"
                                        value="260" {{ in_array('260', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Burnout
                                </option>
                                <option class="level-0"
                                        value="276" {{ in_array('276', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Emotional distress
                                </option>
                                <option class="level-0"
                                        value="292" {{ in_array('292', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Lack of confidence
                                </option>
                                <option class="level-0"
                                        value="308" {{ in_array('308', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Perimenopause
                                </option>
                                <option class="level-0"
                                        value="2649" {{ in_array('2649', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Limited Mobility
                                </option>
                                <option class="level-0"
                                        value="2668" {{ in_array('2668', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Eczema
                                </option>
                                <option class="level-0"
                                        value="2692" {{ in_array('2692', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Infertility
                                </option>
                                <option class="level-0"
                                        value="2708" {{ in_array('2708', (array) json_decode($offering->help)) ? 'selected' : '' }}>
                                    Ovarian cysts
                                </option>
                            </select>

                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Categories - Specifies the
                                type of
                                service/offering you're providing (e.g. massage is the category and a
                                specific treatment
                                would be Ayuvedic massage and hot stone massage)
                                Practitioner Offerings
                            </label>
                            <select name="categories" multiple="multiple" class="form-control select2" id="">
                                <option class="level-0"
                                        value="100" {{ in_array('100', (array) json_decode($offering->categories)) ? 'selected' : '' }}>
                                    Practitioner Offerings
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Tags - Used to highlight
                                specific
                                features of a service/offering and help get found in search, e.g., [related
                                to services
                                of massage as the category] Ayuvedic, hot stone, back ache, back pain,
                                muscle tension
                            </label>
                        </div>
                        <div class="form-group">
                            <select name="tags" multiple="multiple" class="form-control select2" id="">
                                <option
                                    value="156" {{ in_array('156', (array) json_decode($offering->tags)) ? 'selected' : '' }}>
                                    energybalancing
                                </option>
                                <option
                                    value="2991" {{ in_array('2991', (array) json_decode($offering->tags)) ? 'selected' : '' }}>
                                    ASD
                                </option>
                            </select>

                        </div>

                        <h4 class="mb-4 featured-image-tag">Featured Image</h4>
                        <div class="mb-3">
                            <input type="file" id="fileInput" name="featured_image" class="hidden" accept="image/*"
                                   onchange="previewImage(event)" style="display: none;">
                            @if(isset($offering->featured_image))
                                @php
                                    $imageUrl = asset(env('media_path') . '/practitioners/' . $userDetails->id . '/feature/'  . $offering->featured_image);
                                @endphp
                                <label class="image-preview" id="imagePreview"
                                       style="background-image: url('{{$imageUrl}}'); background-size: cover; background-position: center center;">
                                    <i class="fas fa-trash text-danger fs-3"
                                       data-image="{{ $offering->featured_image }}"
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
                            <p style="text-align: start;" class="text">Set featured image</p>
                        </div>
                        <hr>
                        <div class="container">
                            <div class="mb-4">
                                <label for="type" class="fw-bold">Type of offering</label>
                                <select id="type" name="offering_type" class="form-select ">
                                    <option value="">Select Offering Type</option>
                                    <option
                                        value="in-person" {{ $offering->offering_type  == 'in-person' ? 'selected' : ''}}>
                                        In person Offering
                                    </option>
                                    <option
                                        value="virtual" {{ $offering->offering_type  == 'virtual' ? 'selected' : ''}}>
                                        Virtual Offering
                                    </option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="offering-tab"
                                                data-bs-toggle="tab" data-bs-target="#offering" type="button" role="tab"
                                                aria-controls="offering-tab-pane" aria-selected="true">Offering
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="events-tab" data-bs-toggle="tab"
                                                data-bs-target="#events" type="button" role="tab"
                                                aria-controls="events-tab-pane" aria-selected="false">Events
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="package-offering-tab" data-bs-toggle="tab"
                                                data-bs-target="#package_offering" type="button" role="tab"
                                                aria-controls="package-offering-tab-pane" aria-selected="false">Package
                                            offering
                                        </button>
                                    </li>

                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="offering" role="tabpanel"
                                         aria-labelledby="offering-tab" tabindex="0">
                                        <div class="my-4">
                                            <label for="booking-duration" class="fw-bold">Duration of offering</label>
                                            <select id="booking-duration" name="booking_duration" class="form-select">
                                                <option value="">Select</option>
                                                <option
                                                    value="15 minutes" {{ $offering->booking_duration  == '15 minutes' ? 'selected' : ''}}>
                                                    15 minutes
                                                </option>
                                                <option
                                                    value="30 minutes" {{ $offering->booking_duration  == '30 minutes' ? 'selected' : ''}}>
                                                    30 minutes
                                                </option>
                                                <option
                                                    value="45 minutes" {{ $offering->booking_duration  == '45 minutes' ? 'selected' : ''}}>
                                                    45 minutes
                                                </option>
                                                <option
                                                    value="1 hour" {{ $offering->booking_duration  == '1 hour' ? 'selected' : ''}}>
                                                    1 hour
                                                </option>
                                                <option
                                                    value="1:15 hour" {{ $offering->booking_duration  == '1:15 hour' ? 'selected' : ''}}>
                                                    1:15 hour
                                                </option>
                                                <option
                                                    value="1:30 hour" {{ $offering->booking_duration  == '1:30 hour' ? 'selected' : ''}}>
                                                    1:30 hour
                                                </option>
                                                <option
                                                    value="1:45 hour" {{ $offering->booking_duration  == '1:45 hour' ? 'selected' : ''}}>
                                                    1:45 hour
                                                </option>
                                                <option
                                                    value="2 hour" {{ $offering->booking_duration  == '2 hour' ? 'selected' : ''}}>
                                                    2 hour
                                                </option>
                                            </select>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col">
                                                <label for="service-hours" class="fw-bold mb-4">Service hours</label>
                                                <div class="d-flex" style="gap: 20px;">
                                                    <div>
                                                        <label for="service-hours" class="fw-bold">From</label>
                                                        <input type="datetime-local" class="form-control"
                                                               name="from_date" placeholder="">
                                                    </div>
                                                    <div>
                                                        <label for="service-hours" class="fw-bold">To</label>
                                                        <input type="datetime-local" class="form-control" name="to_date"
                                                               placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-check offering-check">
                                                    <input type="checkbox" class="form-check-input" id="availability" name="availability" {{$offering->availability ? 'checked': ''}}>
                                                    <label class="form-check-label mb-3 fw-bold"
                                                           for="availability">Availability</label><br>
                                                    <select id="type" class="form-select" name="availability_type">
                                                        <option value="">Select Availability</option>
                                                        <option
                                                            value="monday" {{$offering->availability_type == 'monday'? 'selected': ''}}>
                                                            Monday
                                                        </option>
                                                        <option
                                                            value="tuesday" {{$offering->availability_type == 'tuesday'? 'selected': ''}}>
                                                            Tuesday
                                                        </option>
                                                        <option
                                                            value="wednesday" {{$offering->availability_type == 'wednesday'? 'selected': ''}}>
                                                            Wednesday
                                                        </option>
                                                        <option
                                                            value="thursday" {{$offering->availability_type == 'thursday'? 'selected': ''}}>
                                                            Thursday
                                                        </option>
                                                        <option
                                                            value="friday" {{$offering->availability_type == 'friday'? 'selected': ''}}>
                                                            Friday
                                                        </option>
                                                        <option
                                                            value="all_week_days" {{$offering->availability_type == 'all_week_days'? 'selected': ''}}>
                                                            All week days
                                                        </option>
                                                        <option
                                                            value="weekends_only" {{$offering->availability_type == 'weekends_only'? 'selected': ''}}>
                                                            Weekends only
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col mb-4">
                                                <label for="service-hours" class="fw-bold">Client price</label>
                                                <input type="text" class="form-control" placeholder=""
                                                       name="client_price" value="{{$offering->client_price}}">
                                            </div>
                                            <div class=" col mb-4">
                                                <label for="tax" class="fw-bold">what % of tax</label>
                                                <input type="text" class="form-control" placeholder="" name="tax_amount"
                                                       value="{{$offering->tax_amount}}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col mb-4">
                                                <label for="type" class="fw-bold">Scheduling window</label>
                                                <select id="type" class="form-select" name="scheduling_window">
                                                    <option value="">Select</option>
                                                    <option
                                                        value="15 minutes" {{ $offering->scheduling_window  == '15 minutes' ? 'selected' : ''}}>
                                                        15 minutes
                                                    </option>
                                                    <option
                                                        value="30 minutes" {{ $offering->scheduling_window  == '30 minutes' ? 'selected' : ''}}>
                                                        30 minutes
                                                    </option>
                                                    <option
                                                        value="45 minutes" {{ $offering->scheduling_window  == '45 minutes' ? 'selected' : ''}}>
                                                        45 minutes
                                                    </option>
                                                    <option
                                                        value="1 hour" {{ $offering->scheduling_window  == '1 hour' ? 'selected' : ''}}>
                                                        1 hour
                                                    </option>
                                                    <option
                                                        value="1:15 hour" {{ $offering->scheduling_window  == '1:15 hour' ? 'selected' : ''}}>
                                                        1:15 hour
                                                    </option>
                                                    <option
                                                        value="1:30 hour" {{ $offering->scheduling_window  == '1:30 hour' ? 'selected' : ''}}>
                                                        1:30 hour
                                                    </option>
                                                    <option
                                                        value="1:45 hour" {{ $offering->scheduling_window  == '1:45 hour' ? 'selected' : ''}}>
                                                        1:45 hour
                                                    </option>
                                                    <option
                                                        value="2 hour" {{ $offering->scheduling_window  == '2 hour' ? 'selected' : ''}}>
                                                        2 hour
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col mb-4">
                                                <label for="type" class="fw-bold">Buffer time between
                                                    appointment</label>
                                                <input type="datetime-local" class="form-control" placeholder=""
                                                       name="buffer_time" value="{{$offering->buffer_time}}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col mb-4">
                                                <label for="service-hours" class="fw-bold">Email template</label>
                                                <textarea class="form-control"
                                                          name="email_template">{{$offering->email_template}}</textarea>
                                            </div>
                                            <div class="col mb-4">
                                                <label for="service-hours" class="fw-bold">Intake form</label>
                                                <input type="text" class="form-control" name="intake_form"
                                                       placeholder="enter your link" value="{{$offering->intake_form}}">
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <div class="form-check offering-check">
                                                <input type="checkbox" class="form-check-input" id="can-be-cancelled"
                                                       data-type="hide" data-id="cancellation_time"
                                                       name="is_cancelled" {{$offering->is_cancelled ? 'checked' : ''}}>
                                                <label class="form-check-label mb-3 fw-bold"
                                                       for="can-be-cancelled">Cancellation</label>
                                            </div>
                                            <div class="col-md-6 mb-4 {{$offering->is_cancelled ? '' :'d-none'}}"
                                                 id="cancellation_time">
                                                <label class="fw-bold">Cancellation time</label>
                                                <input type="datetime-local" name="cancellation_time_slot"
                                                       class="form-control"
                                                       value="{{$offering->cancellation_time_slot}}">
                                            </div>
                                        </div>
                                        <div class="form-check offering-check">
                                            <input type="checkbox" class="form-check-input" id="can-be-cancelled"
                                                   name="is_confirmation" {{$offering->is_confirmation ? 'checked' : ''}}>
                                            <label class="form-check-label mb-3 fw-bold"
                                                   for="can-be-cancelled">Requires Confirmation</label>
                                        </div>
                                        <div class="d-flex" style="gap: 20px;">
                                            <button class="update-btn">Save</button>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="events" role="tabpanel" aria-labelledby="events-tab"
                                         tabindex="0">
                                        <h5>Coming soon</h5>
                                    </div>
                                    <div class="tab-pane fade" id="package_offering" role="tabpanel"
                                         aria-labelledby="package-offering-tab" tabindex="0">
                                        <h5>Coming soon</h5>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

