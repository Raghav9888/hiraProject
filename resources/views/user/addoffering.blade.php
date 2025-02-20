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
                    <form method="post" action="{{route('addoffering')}}">
                    @csrf
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" id="exampleInputEmail1"
                                   aria-describedby="emailHelp"
                                   placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="floatingTextarea">Description</label>
                            <textarea class="form-control" name="long_description" placeholder="please add a full description here"
                                      id="floatingTextarea"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="floatingTextarea">Shoret Description</label>
                            <textarea class="form-control" name="short_description" placeholder="please add a full description here"
                                      id="floatingTextarea"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Location</label>
                            <select name="location" multiple="multiple"  class="form-control select2">
                            <option class="level-0" value="370">Montreal</option>
                            <option class="level-0" value="386">Austin</option>
                            <option class="level-0" value="891">Mississauga, ON</option>
                            <option class="level-0" value="907">Regina, SK</option>
                            <option class="level-0" value="923">Whitby, ON</option>
                            <option class="level-0" value="939">Red Deer, AB</option>
                            <option class="level-0" value="955">Prince George, BC</option>
                            <option class="level-0" value="971">Aurora, ON</option>
                            <option class="level-0" value="987">Rimouski, QC</option>
                            <option class="level-0" value="1003">Salaberry-de-Valleyfield, QC</option>
                            <option class="level-0" value="1019">Orangeville, ON</option>
                            <option class="level-0" value="1035">Alma, QC</option>
                            <option class="level-0" value="1051">La Prairie, QC</option>
                            <option class="level-0" value="1067">Amherstburg, ON</option>
                            <option class="level-0" value="1083">Uxbridge, ON</option>
                            <option class="level-0" value="1099">Saint-Augustin-de-Desmaures, QC</option>
                            <option class="level-0" value="1115">Middlesex Centre, ON</option>
                            <option class="level-0" value="1131">Central Saanich, BC</option>
                            <option class="level-0" value="1147">Greater Napanee, ON</option>
                            <option class="level-0" value="1163">St. Clair, ON</option>
                            <option class="level-0" value="1179">Grand Falls, NL</option>
                            <option class="level-0" value="1195">South Glengarry, ON</option>
                            <option class="level-0" value="1211">North Saanich, BC</option>
                            <option class="level-0" value="1227">Brock, ON</option>
                            <option class="level-0" value="1243">Ladysmith, BC</option>
                            <option class="level-0" value="1259">Rawdon, QC</option>
                            <option class="level-0" value="1275">Castlegar, BC</option>
                            <option class="level-0" value="1291">Smiths Falls, ON</option>
                            <option class="level-0" value="1307">Labrador City, NL</option>
                            <option class="level-0" value="1323">Shediac, NB</option>
                            <option class="level-0" value="1339">Zorra, ON</option>
                            <option class="level-0" value="1355">Innisfail, AB</option>
                            <option class="level-0" value="1371">Saint-Philippe, QC</option>
                            <option class="level-0" value="1387">Drayton Valley, AB</option>
                            <option class="level-0" value="1403">Whitewater Region, ON</option>
                            <option class="level-0" value="1419">Rocky Mountain House, AB</option>
                            <option class="level-0" value="1435">Kent, BC</option>
                            <option class="level-0" value="1451">Niverville, MB</option>
                            <option class="level-0" value="1467">Princeville, QC</option>
                            <option class="level-0" value="1483">Ashfield-Colborne-Wawanosh, ON</option>
                            <option class="level-0" value="1499">Didsbury, AB</option>
                            <option class="level-0" value="1515">Stonewall, MB</option>
                            <option class="level-0" value="1531">Southwold, ON</option>
                            <option class="level-0" value="1547">Kindersley, SK</option>
                            <option class="level-0" value="1563">Vanderhoof, BC</option>
                            <option class="level-0" value="1579">Altona, MB</option>
                            <option class="level-0" value="1595">Carstairs, AB</option>
                            <option class="level-0" value="1611">Raymond, AB</option>
                            <option class="level-0" value="1627">East Angus, QC</option>
                            <option class="level-0" value="1643">Fruitvale, BC</option>
                            <option class="level-0" value="1659">Havre-Saint-Pierre, QC</option>
                            <option class="level-0" value="1675">Sainte-Anne-des-Lacs, QC</option>
                            <option class="level-0" value="1691">Forestville, QC</option>
                            <option class="level-0" value="1707">Portneuf, QC</option>
                            <option class="level-0" value="1723">Mont-Saint-Gregoire, QC</option>
                            <option class="level-0" value="1739">Adelaide-Metcalfe, ON</option>
                            <option class="level-0" value="1755">North Algona Wilberforce, ON</option>
                            <option class="level-0" value="1771">Princeton, BC</option>
                            <option class="level-0" value="1787">Kuujjuaq, QC</option>
                            <option class="level-0" value="1803">Black Diamond, AB</option>
                            <option class="level-0" value="1819">Notre-Dame-de-Lourdes, QC</option>
                            <option class="level-0" value="1835">Saint-Damase, QC</option>
                            <option class="level-0" value="1851">Sainte-Catherine-de-Hatley, QC</option>
                            <option class="level-0" value="1867">Saint-Victor, QC</option>
                            <option class="level-0" value="1883">Sainte-Genevieve-de-Berthier, QC</option>
                            <option class="level-0" value="1899">Burin, NL</option>
                            <option class="level-0" value="1915">Maskinonge, QC</option>
                            <option class="level-0" value="1931">Twillingate, NL</option>
                            <option class="level-0" value="1947">Saint-Bernard, QC</option>
                            <option class="level-0" value="1963">Glovertown, NL</option>
                            <option class="level-0" value="1979">Mandeville, QC</option>
                            <option class="level-0" value="1995">Lorne, MB</option>
                            <option class="level-0" value="2011">Glenboro-South Cypress, MB</option>
                            <option class="level-0" value="2027">One Hundred Mile House, BC</option>
                            <option class="level-0" value="2043">Vallee-Jonction, QC</option>
                            <option class="level-0" value="2059">Lac-Superieur, QC</option>
                            <option class="level-0" value="2075">Sainte-Beatrix, QC</option>
                            <option class="level-0" value="2091">Champlain, QC</option>
                            <option class="level-0" value="2107">Pointe-des-Cascades, QC</option>
                            <option class="level-0" value="2123">Warfield, BC</option>
                            <option class="level-0" value="2139">Notre-Dame-du-Bon-Conseil, QC</option>
                            <option class="level-0" value="2155">Rosedale, MB</option>
                            <option class="level-0" value="2171">Sainte-Helene-de-Bagot, QC</option>
                            <option class="level-0" value="2187">Cleveland, QC</option>
                            <option class="level-0" value="2203">Lambton, QC</option>
                            <option class="level-0" value="2219">Saint-Guillaume, QC</option>
                            <option class="level-0" value="2235">Langham, SK</option>
                            <option class="level-0" value="2251">Salluit, QC</option>
                            <option class="level-0" value="2267">Saint-Odilon-de-Cranbourne, QC</option>
                            <option class="level-0" value="2283">Scott, QC</option>
                            <option class="level-0" value="2299">Lions Bay, BC</option>
                            <option class="level-0" value="2315">Upham, NB</option>
                            <option class="level-0" value="2331">Smooth Rock Falls, ON</option>
                            <option class="level-0" value="2347">Saint-Edouard, QC</option>
                            <option class="level-0" value="2363">Sainte-Anne-du-Sault, QC</option>
                            <option class="level-0" value="2379">Roxton Falls, QC</option>
                            <option class="level-0" value="2395">St. Joseph, ON</option>
                            <option class="level-0" value="2411">L'Anse-Saint-Jean, QC</option>
                            <option class="level-0" value="2427">Kaleden, BC</option>
                            <option class="level-0" value="2443">Saint-Joachim-de-Shefford, QC</option>
                            <option class="level-0" value="2459">Centreville-Wareham-Trinity, NL</option>
                            <option class="level-0" value="2475">Hensall, ON</option>
                            <option class="level-0" value="2491">Waldheim, SK</option>
                            <option class="level-0" value="2507">South Algonquin, ON</option>
                            <option class="level-0" value="2523">Durham, NB</option>
                            <option class="level-0" value="2539">Havelock, NB</option>
                            <option class="level-0" value="2555">La Macaza, QC</option>
                            <option class="level-0" value="2571">Argyle, MB</option>
                            <option class="level-0" value="2587">Oyen, AB</option>
                            <option class="level-0" value="2603">Gillam, MB</option>
                            <option class="level-0" value="3042">BC</option>
                            <option class="level-0" value="116">Victoria, BC</option>
                            <option class="level-0" value="371">Ottawa</option>
                            <option class="level-0" value="387">Jacksonville</option>
                            <option class="level-0" value="892">Brampton, ON</option>
                            <option class="level-0" value="908">Oakville, ON</option>
                            <option class="level-0" value="924">Cambridge, ON</option>
                            <option class="level-0" value="940">Pickering, ON</option>
                            <option class="level-0" value="956">Caledon, ON</option>
                            <option class="level-0" value="972">Port Coquitlam, BC</option>
                            <option class="level-0" value="988">Courtenay, BC</option>
                            <option class="level-0" value="1004">Rouyn-Noranda, QC</option>
                            <option class="level-0" value="1020">Leduc, AB</option>
                            <option class="level-0" value="1036">Sainte-Julie, QC</option>
                            <option class="level-0" value="1052">Saint-Bruno-de-Montarville, QC</option>
                            <option class="level-0" value="1068">L'Assomption, QC</option>
                            <option class="level-0" value="1084">Fort St. John, BC</option>
                            <option class="level-0" value="1100">Huntsville, ON</option>
                            <option class="level-0" value="1116">Mont-Saint-Hilaire, QC</option>
                            <option class="level-0" value="1132">Sainte-Catherine, QC</option>
                            <option class="level-0" value="1148">Lake Country, BC</option>
                            <option class="level-0" value="1164">Terrace, BC</option>
                            <option class="level-0" value="1180">North Battleford, SK</option>
                            <option class="level-0" value="1196">Sainte-Marie, QC</option>
                            <option class="level-0" value="1212">Prevost, QC</option>
                            <option class="level-0" value="1228">L'Ile-Perrot, QC</option>
                            <option class="level-0" value="1244">Coldstream, BC</option>
                            <option class="level-0" value="1260">Morinville, AB</option>
                            <option class="level-0" value="1276">Cavan Monaghan, ON</option>
                            <option class="level-0" value="1292">Lorraine, QC</option>
                            <option class="level-0" value="1308">Shelburne, ON</option>
                            <option class="level-0" value="1324">Otterburn Park, QC</option>
                            <option class="level-0" value="1340">Kitimat, BC</option>
                            <option class="level-0" value="1356">Nicolet, QC</option>
                            <option class="level-0" value="1372">McNab/Braeside, ON</option>
                            <option class="level-0" value="1388">Ponoka, AB</option>
                            <option class="level-0" value="1404">Edwardsburgh/Cardinal, ON</option>
                            <option class="level-0" value="1420">Muskoka Falls, ON</option>
                            <option class="level-0" value="1436">Clarenville, NL</option>
                            <option class="level-0" value="1452">McMasterville, QC</option>
                            <option class="level-0" value="1468">Saint-Cesaire, QC</option>
                            <option class="level-0" value="1484">Trent Lakes, ON</option>
                            <option class="level-0" value="1500">Deer Lake, NL</option>
                            <option class="level-0" value="1516">Memramcook, NB</option>
                            <option class="level-0" value="1532">Chertsey, QC</option>
                            <option class="level-0" value="1548">Saint-Denis-de-Brompton, QC</option>
                            <option class="level-0" value="1564">Chateau-Richer, QC</option>
                            <option class="level-0" value="1580">Roxton Pond, QC</option>
                            <option class="level-0" value="1596">Danville, QC</option>
                            <option class="level-0" value="1612">Morin-Heights, QC</option>
                            <option class="level-0" value="1628">Rossland, BC</option>
                            <option class="level-0" value="1644">Saint-Ambroise, QC</option>
                            <option class="level-0" value="1660">Saint-Anselme, QC</option>
                            <option class="level-0" value="1676">Saint-Sulpice, QC</option>
                            <option class="level-0" value="1692">Compton, QC</option>
                            <option class="level-0" value="1708">Pictou, NS</option>
                            <option class="level-0" value="1724">Thurso, QC</option>
                            <option class="level-0" value="1740">Melancthon, ON</option>
                            <option class="level-0" value="1756">Errington, BC</option>
                            <option class="level-0" value="1772">La Loche, SK</option>
                            <option class="level-0" value="1788">Atikokan, ON</option>
                            <option class="level-0" value="1804">Saint-Pamphile, QC</option>
                            <option class="level-0" value="1820">Ville-Marie, QC</option>
                            <option class="level-0" value="1836">Disraeli, QC</option>
                            <option class="level-0" value="1852">Saint-Basile, QC</option>
                            <option class="level-0" value="1868">Sicamous, BC</option>
                            <option class="level-0" value="1884">Logy Bay-Middle Cove-Outer Cove, NL</option>
                            <option class="level-0" value="1900">Grand Bank, NL</option>
                            <option class="level-0" value="1916">Saint-Charles-de-Bellechasse, QC</option>
                            <option class="level-0" value="1932">Saint-Quentin, NB</option>
                            <option class="level-0" value="1948">Sainte-Cecile-de-Milton, QC</option>
                            <option class="level-0" value="1964">Tofield, AB</option>
                            <option class="level-0" value="1980">Caplan, QC</option>
                            <option class="level-0" value="1996">Yellowhead, MB</option>
                            <option class="level-0" value="2012">North Norfolk, MB</option>
                            <option class="level-0" value="2028">Saint-Liguori, QC</option>
                            <option class="level-0" value="2044">Manitouwadge, ON</option>
                            <option class="level-0" value="2060">Les Escoumins, QC</option>
                            <option class="level-0" value="2076">Saint-Georges-de-Cacouna, QC</option>
                            <option class="level-0" value="2092">Sacre-Coeur-Saguenay, QC</option>
                            <option class="level-0" value="2108">Deseronto, ON</option>
                            <option class="level-0" value="2124">Saint-Zacharie, QC</option>
                            <option class="level-0" value="2140">Fisher, MB</option>
                            <option class="level-0" value="2156">Saint-Jacques-le-Mineur, QC</option>
                            <option class="level-0" value="2172">Franklin Centre, QC</option>
                            <option class="level-0" value="2188">Messines, QC</option>
                            <option class="level-0" value="2204">Saint-Flavien, QC</option>
                            <option class="level-0" value="2220">Venise-en-Quebec, QC</option>
                            <option class="level-0" value="2236">St. George, NB</option>
                            <option class="level-0" value="2252">Pangnirtung, NU</option>
                            <option class="level-0" value="2268">Pipestone, MB</option>
                            <option class="level-0" value="2284">Godmanchester, QC</option>
                            <option class="level-0" value="2300">New Carlisle, QC</option>
                            <option class="level-0" value="2316">St.-Charles, ON</option>
                            <option class="level-0" value="2332">Bruederheim, AB</option>
                            <option class="level-0" value="2348">Charlo, NB</option>
                            <option class="level-0" value="2364">La Conception, QC</option>
                            <option class="level-0" value="2380">Montcalm, MB</option>
                            <option class="level-0" value="2396">Queensbury, NB</option>
                            <option class="level-0" value="2412">Moose Jaw No. 161, SK</option>
                            <option class="level-0" value="2428">Saint James, NB</option>
                            <option class="level-0" value="2444">Grand-Remous, QC</option>
                            <option class="level-0" value="2460">Alberton, PE</option>
                            <option class="level-0" value="2476">Carnduff, SK</option>
                            <option class="level-0" value="2492">McKellar, ON</option>
                            <option class="level-0" value="2508">Upton, QC</option>
                            <option class="level-0" value="2524">Sainte-Marthe, QC</option>
                            <option class="level-0" value="2540">Eston, SK</option>
                            <option class="level-0" value="2556">Souris, PE</option>
                            <option class="level-0" value="2572">Delisle, SK</option>
                            <option class="level-0" value="2588">Gravelbourg, SK</option>
                            <option class="level-0" value="2604">Grand View, MB</option>
                            <option class="level-0" value="3061">Virtual</option>
                            <option class="level-0" value="117">Victoria, TX</option>
                            <option class="level-0" value="372">Saskatoon</option>
                            <option class="level-0" value="388">San Francisco</option>
                            <option class="level-0" value="893">Surrey, BC</option>
                            <option class="level-0" value="909">Richmond, BC</option>
                            <option class="level-0" value="925">Milton, ON</option>
                            <option class="level-0" value="941">Lethbridge, AB</option>
                            <option class="level-0" value="957">Chateauguay, QC</option>
                            <option class="level-0" value="973">Mirabel, QC</option>
                            <option class="level-0" value="989">Dollard-des-Ormeaux, QC</option>
                            <option class="level-0" value="1005">Boucherville, QC</option>
                            <option class="level-0" value="1021">Moose Jaw, SK</option>
                            <option class="level-0" value="1037">Saint-Constant, QC</option>
                            <option class="level-0" value="1053">Midland, ON</option>
                            <option class="level-0" value="1069">Tecumseh, ON</option>
                            <option class="level-0" value="1085">Wilmot, ON</option>
                            <option class="level-0" value="1101">Sainte-Marthe-sur-le-Lac, QC</option>
                            <option class="level-0" value="1117">Camrose, AB</option>
                            <option class="level-0" value="1133">Port Hope, ON</option>
                            <option class="level-0" value="1149">Hanover, MB</option>
                            <option class="level-0" value="1165">Mercier, QC</option>
                            <option class="level-0" value="1181">Mont-Laurier, QC</option>
                            <option class="level-0" value="1197">North Perth, ON</option>
                            <option class="level-0" value="1213">Sainte-Adele, QC</option>
                            <option class="level-0" value="1229">Summerland, BC</option>
                            <option class="level-0" value="1245">Georgian Bluffs, ON</option>
                            <option class="level-0" value="1261">Blackfalds, AB</option>
                            <option class="level-0" value="1277">Morden, MB</option>
                            <option class="level-0" value="1293">Ramara, ON</option>
                            <option class="level-0" value="1309">Stanley, MB</option>
                            <option class="level-0" value="1325">Sainte-Brigitte-de-Laval, QC</option>
                            <option class="level-0" value="1341">Macdonald, MB</option>
                            <option class="level-0" value="1357">Rockwood, MB</option>
                            <option class="level-0" value="1373">Central Huron, ON</option>
                            <option class="level-0" value="1389">Southgate, ON</option>
                            <option class="level-0" value="1405">Sainte-Anne-des-Monts, QC</option>
                            <option class="level-0" value="1421">Cornwall, PE</option>
                            <option class="level-0" value="1437">Mont-Joli, QC</option>
                            <option class="level-0" value="1453">Douglas, NB</option>
                            <option class="level-0" value="1469">Tay Valley, ON</option>
                            <option class="level-0" value="1485">Northern Rockies, BC</option>
                            <option class="level-0" value="1501">Woodstock, NB</option>
                            <option class="level-0" value="1517">Sainte-Anne-de-Bellevue, QC</option>
                            <option class="level-0" value="1533">Shippagan, NB</option>
                            <option class="level-0" value="1549">Jasper, AB</option>
                            <option class="level-0" value="1565">Saint Stephen, NB</option>
                            <option class="level-0" value="1581">Saint-Etienne-des-Gres, QC</option>
                            <option class="level-0" value="1597">Channel-Port aux Basques, NL</option>
                            <option class="level-0" value="1613">Dundas, NB</option>
                            <option class="level-0" value="1629">Mackenzie, BC</option>
                            <option class="level-0" value="1645">Westville, NS</option>
                            <option class="level-0" value="1661">Trois-Pistoles, QC</option>
                            <option class="level-0" value="1677">Penhold, AB</option>
                            <option class="level-0" value="1693">Shuniah, ON</option>
                            <option class="level-0" value="1709">Tisdale, SK</option>
                            <option class="level-0" value="1725">Wellington, NB</option>
                            <option class="level-0" value="1741">Cap Sante, QC</option>
                            <option class="level-0" value="1757">Wawa, ON</option>
                            <option class="level-0" value="1773">Ferme-Neuve, QC</option>
                            <option class="level-0" value="1789">Grenville-sur-la-Rouge, QC</option>
                            <option class="level-0" value="1805">Bedford, QC</option>
                            <option class="level-0" value="1821">Wickham, QC</option>
                            <option class="level-0" value="1837">Meadow Lake No. 588, SK</option>
                            <option class="level-0" value="1853">Saint-Raphael, QC</option>
                            <option class="level-0" value="1869">Cap Pele, NB</option>
                            <option class="level-0" value="1885">Buctouche, NB</option>
                            <option class="level-0" value="1901">Waterville, QC</option>
                            <option class="level-0" value="1917">Fogo Island, NL</option>
                            <option class="level-0" value="1933">Lebel-sur-Quevillon, QC</option>
                            <option class="level-0" value="1949">Saint-Roch-de-Richelieu, QC</option>
                            <option class="level-0" value="1965">Madoc, ON</option>
                            <option class="level-0" value="1981">Allardville, NB</option>
                            <option class="level-0" value="1997">Swan Valley West, MB</option>
                            <option class="level-0" value="2013">Reinland, MB</option>
                            <option class="level-0" value="2029">Saint Mary, NB</option>
                            <option class="level-0" value="2045">Wellington, ON</option>
                            <option class="level-0" value="2061">Richibucto, NB</option>
                            <option class="level-0" value="2077">Lakeview, BC</option>
                            <option class="level-0" value="2093">Saint-Louis, NB</option>
                            <option class="level-0" value="2109">Lamont, AB</option>
                            <option class="level-0" value="2125">Hemmingford, QC</option>
                            <option class="level-0" value="2141">Sainte-Clotilde, QC</option>
                            <option class="level-0" value="2157">Coombs, BC</option>
                            <option class="level-0" value="2173">Harbour Breton, NL</option>
                            <option class="level-0" value="2189">Saint-Laurent-de-l'Ile-d'Orleans, QC</option>
                            <option class="level-0" value="2205">Boissevain, MB</option>
                            <option class="level-0" value="2221">Gambo, NL</option>
                            <option class="level-0" value="2237">Wembley, AB</option>
                            <option class="level-0" value="2253">Saint-Louis-de-Gonzague, QC</option>
                            <option class="level-0" value="2269">La Dore, QC</option>
                            <option class="level-0" value="2285">Macklin, SK</option>
                            <option class="level-0" value="2301">Laird No. 404, SK</option>
                            <option class="level-0" value="2317">Cardwell, NB</option>
                            <option class="level-0" value="2333">Oxbow, SK</option>
                            <option class="level-0" value="2349">Sorrento, BC</option>
                            <option class="level-0" value="2365">Vauxhall, AB</option>
                            <option class="level-0" value="2381">Irishtown-Summerside, NL</option>
                            <option class="level-0" value="2397">Saint-Hubert-de-Riviere-du-Loup, QC</option>
                            <option class="level-0" value="2413">Bassano, AB</option>
                            <option class="level-0" value="2429">Saint-Norbert-d'Arthabaska, QC</option>
                            <option class="level-0" value="2445">Saint-Gabriel-de-Rimouski, QC</option>
                            <option class="level-0" value="2461">Winnipeg Beach, MB</option>
                            <option class="level-0" value="2477">Greenwich, NB</option>
                            <option class="level-0" value="2493">Buffalo Narrows, SK</option>
                            <option class="level-0" value="2509">Saint-Narcisse-de-Beaurivage, QC</option>
                            <option class="level-0" value="2525">Notre-Dame-du-Nord, QC</option>
                            <option class="level-0" value="2541">Sainte-Genevieve-de-Batiscan, QC</option>
                            <option class="level-0" value="2557">Kindersley No. 290, SK</option>
                            <option class="level-0" value="2573">Plaster Rock, NB</option>
                            <option class="level-0" value="2589">Lajord No. 128, SK</option>
                            <option class="level-0" value="2605">Dildo, NL</option>
                            <option class="level-0" value="3308">Mississauga</option>
                            <option class="level-0" value="118">Montreal, QE</option>
                            <option class="level-0" value="373">Halifax</option>
                            <option class="level-0" value="389">Indianapolis</option>
                            <option class="level-0" value="894">Kitchener, ON</option>
                            <option class="level-0" value="910">Richmond Hill, ON</option>
                            <option class="level-0" value="926">Ajax, ON</option>
                            <option class="level-0" value="942">Kamloops, BC</option>
                            <option class="level-0" value="958">Belleville, ON</option>
                            <option class="level-0" value="974">Blainville, QC</option>
                            <option class="level-0" value="990">Cornwall, ON</option>
                            <option class="level-0" value="1006">Mission, BC</option>
                            <option class="level-0" value="1022">Port Moody, BC</option>
                            <option class="level-0" value="1038">Langley, BC</option>
                            <option class="level-0" value="1054">Thetford Mines, QC</option>
                            <option class="level-0" value="1070">Candiac, QC</option>
                            <option class="level-0" value="1086">Essex, ON</option>
                            <option class="level-0" value="1102">Lloydminster, AB</option>
                            <option class="level-0" value="1118">Selwyn, ON</option>
                            <option class="level-0" value="1134">Inverness, NS</option>
                            <option class="level-0" value="1150">Winkler, MB</option>
                            <option class="level-0" value="1166">West Lincoln, ON</option>
                            <option class="level-0" value="1182">Central Elgin, ON</option>
                            <option class="level-0" value="1198">Thompson, MB</option>
                            <option class="level-0" value="1214">Sainte-Agathe-des-Monts, QC</option>
                            <option class="level-0" value="1230">St. Clements, MB</option>
                            <option class="level-0" value="1246">Weyburn, SK</option>
                            <option class="level-0" value="1262">Chester, NS</option>
                            <option class="level-0" value="1278">Temiskaming Shores, ON</option>
                            <option class="level-0" value="1294">Notre-Dame-des-Prairies, QC</option>
                            <option class="level-0" value="1310">Taber, AB</option>
                            <option class="level-0" value="1326">Sainte-Catherine-de-la-Jacques-Cartier, QC</option>
                            <option class="level-0" value="1342">Happy Valley, NL</option>
                            <option class="level-0" value="1358">Drummond/North Elmsley, ON</option>
                            <option class="level-0" value="1374">Rigaud, QC</option>
                            <option class="level-0" value="1390">Les Cedres, QC</option>
                            <option class="level-0" value="1406">Bay Roberts, NL</option>
                            <option class="level-0" value="1422">Saint-Paul, QC</option>
                            <option class="level-0" value="1438">Pointe-Calumet, QC</option>
                            <option class="level-0" value="1454">Saint-Calixte, QC</option>
                            <option class="level-0" value="1470">South Bruce, ON</option>
                            <option class="level-0" value="1486">Gananoque, ON</option>
                            <option class="level-0" value="1502">Flin Flon, SK</option>
                            <option class="level-0" value="1518">Stirling-Rawdon, ON</option>
                            <option class="level-0" value="1534">Lanoraie, QC</option>
                            <option class="level-0" value="1550">Barrhead, AB</option>
                            <option class="level-0" value="1566">Nipawin, SK</option>
                            <option class="level-0" value="1582">Grand Forks, BC</option>
                            <option class="level-0" value="1598">Lac-Etchemin, QC</option>
                            <option class="level-0" value="1614">Simonds, NB</option>
                            <option class="level-0" value="1630">Golden, BC</option>
                            <option class="level-0" value="1646">Hay River, NT</option>
                            <option class="level-0" value="1662">Grande-Riviere, QC</option>
                            <option class="level-0" value="1678">Powassan, ON</option>
                            <option class="level-0" value="1694">Inuvik, NT</option>
                            <option class="level-0" value="1710">Lake of Bays, ON</option>
                            <option class="level-0" value="1726">Cedar, BC</option>
                            <option class="level-0" value="1742">Saint-David-de-Falardeau, QC</option>
                            <option class="level-0" value="1758">Sainte-Melanie, QC</option>
                            <option class="level-0" value="1774">Yamachiche, QC</option>
                            <option class="level-0" value="1790">North Cypress-Langford, MB</option>
                            <option class="level-0" value="1806">Weedon-Centre, QC</option>
                            <option class="level-0" value="1822">Shippegan, NB</option>
                            <option class="level-0" value="1838">Elkford, BC</option>
                            <option class="level-0" value="1854">Saint-Martin, QC</option>
                            <option class="level-0" value="1870">Kelsey, MB</option>
                            <option class="level-0" value="1886">Grand Manan, NB</option>
                            <option class="level-0" value="1902">Minto, NB</option>
                            <option class="level-0" value="1918">Neebing, ON</option>
                            <option class="level-0" value="1934">Calmar, AB</option>
                            <option class="level-0" value="1950">Burns Lake, BC</option>
                            <option class="level-0" value="1966">Sainte-Anne-de-Sabrevois, QC</option>
                            <option class="level-0" value="1982">Saint-Damien, QC</option>
                            <option class="level-0" value="1998">Grey, MB</option>
                            <option class="level-0" value="2014">Minitonas-Bowsman, MB</option>
                            <option class="level-0" value="2030">Saint-Patrice-de-Sherrington, QC</option>
                            <option class="level-0" value="2046">Frontenac Islands, ON</option>
                            <option class="level-0" value="2062">Terrasse-Vaudreuil, QC</option>
                            <option class="level-0" value="2078">Sainte-Justine, QC</option>
                            <option class="level-0" value="2094">Saint-Lucien, QC</option>
                            <option class="level-0" value="2110">Chambord, QC</option>
                            <option class="level-0" value="2126">Saint-Pierre-de-l'Ile-d'Orleans, QC</option>
                            <option class="level-0" value="2142">Lantz, NS</option>
                            <option class="level-0" value="2158">Val-Joli, QC</option>
                            <option class="level-0" value="2174">Mille-Isles, QC</option>
                            <option class="level-0" value="2190">Saint-Jean-de-Dieu, QC</option>
                            <option class="level-0" value="2206">Sainte-Marcelline-de-Kildare, QC</option>
                            <option class="level-0" value="2222">Nauwigewauk, NB</option>
                            <option class="level-0" value="2238">Macdonald, Meredith and Aberdeen Additional, ON</option>
                            <option class="level-0" value="2254">Moosonee, ON</option>
                            <option class="level-0" value="2270">Lac-au-Saumon, QC</option>
                            <option class="level-0" value="2286">Armour, ON</option>
                            <option class="level-0" value="2302">Saint-Majorique-de-Grantham, QC</option>
                            <option class="level-0" value="2318">Amulet, QC</option>
                            <option class="level-0" value="2334">Telkwa, BC</option>
                            <option class="level-0" value="2350">Burgeo, NL</option>
                            <option class="level-0" value="2366">Lameque, NB</option>
                            <option class="level-0" value="2382">Clarendon, QC</option>
                            <option class="level-0" value="2398">Saint-Jude, QC</option>
                            <option class="level-0" value="2414">Parrsboro, NS</option>
                            <option class="level-0" value="2430">Manning, AB</option>
                            <option class="level-0" value="2446">Armstrong, ON</option>
                            <option class="level-0" value="2462">Sainte-Agathe-de-Lotbiniere, QC</option>
                            <option class="level-0" value="2478">Carling, ON</option>
                            <option class="level-0" value="2494">Ayer's Cliff, QC</option>
                            <option class="level-0" value="2510">Plaisance, QC</option>
                            <option class="level-0" value="2526">Beachburg, ON</option>
                            <option class="level-0" value="2542">Saint-Justin, QC</option>
                            <option class="level-0" value="2558">Falher, AB</option>
                            <option class="level-0" value="2574">Wilmot, NB</option>
                            <option class="level-0" value="2590">Hebertville, QC</option>
                            <option class="level-0" value="2606">Laurierville, QC</option>
                            <option class="level-0" value="3307">ON</option>
                            <option class="level-0" value="884">Vancouver, BC</option>
                            <option class="level-0" value="374">Winnipeg</option>
                            <option class="level-0" value="390">Columbus</option>
                            <option class="level-0" value="895">Halifax, NS</option>
                            <option class="level-0" value="911">Burlington, ON</option>
                            <option class="level-0" value="927">Waterloo, ON</option>
                            <option class="level-0" value="943">Saint-Jean-sur-Richelieu, QC</option>
                            <option class="level-0" value="959">Airdrie, AB</option>
                            <option class="level-0" value="975">Lac-Brome, QC</option>
                            <option class="level-0" value="991">Victoriaville, QC</option>
                            <option class="level-0" value="1007">Timmins, ON</option>
                            <option class="level-0" value="1023">Pointe-Claire, QC</option>
                            <option class="level-0" value="1039">Grimsby, ON</option>
                            <option class="level-0" value="1055">Lincoln, ON</option>
                            <option class="level-0" value="1071">Essa, ON</option>
                            <option class="level-0" value="1087">Varennes, QC</option>
                            <option class="level-0" value="1103">Westmount, QC</option>
                            <option class="level-0" value="1119">Tillsonburg, ON</option>
                            <option class="level-0" value="1135">Saint-Basile-le-Grand, QC</option>
                            <option class="level-0" value="1151">Saint-Charles-Borromee, QC</option>
                            <option class="level-0" value="1167">Lavaltrie, QC</option>
                            <option class="level-0" value="1183">Mistassini, QC</option>
                            <option class="level-0" value="1199">Trent Hills, ON</option>
                            <option class="level-0" value="1215">Quesnel, BC</option>
                            <option class="level-0" value="1231">View Royal, BC</option>
                            <option class="level-0" value="1247">La Tuque, QC</option>
                            <option class="level-0" value="1263">Queens, NS</option>
                            <option class="level-0" value="1279">Hinton, AB</option>
                            <option class="level-0" value="1295">Leeds and the Thousand Islands, ON</option>
                            <option class="level-0" value="1311">Donnacona, QC</option>
                            <option class="level-0" value="1327">South Bruce Peninsula, ON</option>
                            <option class="level-0" value="1343">Saint-Hippolyte, QC</option>
                            <option class="level-0" value="1359">Contrecoeur, QC</option>
                            <option class="level-0" value="1375">Louiseville, QC</option>
                            <option class="level-0" value="1391">Baie-Saint-Paul, QC</option>
                            <option class="level-0" value="1407">Wainfleet, ON</option>
                            <option class="level-0" value="1423">Devon, AB</option>
                            <option class="level-0" value="1439">Dysart et al, ON</option>
                            <option class="level-0" value="1455">Lac-Megantic, QC</option>
                            <option class="level-0" value="1471">Antigonish, NS</option>
                            <option class="level-0" value="1487">Windsor, QC</option>
                            <option class="level-0" value="1503">Brokenhead, MB</option>
                            <option class="level-0" value="1519">Mont-Orford, QC</option>
                            <option class="level-0" value="1535">Centre Hastings, ON</option>
                            <option class="level-0" value="1551">Melville, SK</option>
                            <option class="level-0" value="1567">Battleford, SK</option>
                            <option class="level-0" value="1583">New Maryland, NB</option>
                            <option class="level-0" value="1599">Saint-Jacques, QC</option>
                            <option class="level-0" value="1615">Crabtree, QC</option>
                            <option class="level-0" value="1631">Saint-Adolphe-d'Howard, QC</option>
                            <option class="level-0" value="1647">Pasadena, NL</option>
                            <option class="level-0" value="1663">Malartic, QC</option>
                            <option class="level-0" value="1679">Highlands East, ON</option>
                            <option class="level-0" value="1695">Richmond, QC</option>
                            <option class="level-0" value="1711">Bishops Falls, NL</option>
                            <option class="level-0" value="1727">Saint-Gabriel, QC</option>
                            <option class="level-0" value="1743">Harbour Grace, NL</option>
                            <option class="level-0" value="1759">Horton, ON</option>
                            <option class="level-0" value="1775">Adstock, QC</option>
                            <option class="level-0" value="1791">Saint-Dominique, QC</option>
                            <option class="level-0" value="1807">Lacolle, QC</option>
                            <option class="level-0" value="1823">East Garafraxa, ON</option>
                            <option class="level-0" value="1839">Georgian Bay, ON</option>
                            <option class="level-0" value="1855">Causapscal, QC</option>
                            <option class="level-0" value="1871">Killaloe, Hagarty and Richards, ON</option>
                            <option class="level-0" value="1887">Sainte-Madeleine, QC</option>
                            <option class="level-0" value="1903">Rosthern No. 403, SK</option>
                            <option class="level-0" value="1919">Port McNeill, BC</option>
                            <option class="level-0" value="1935">Nanton, AB</option>
                            <option class="level-0" value="1951">Redwater, AB</option>
                            <option class="level-0" value="1967">Sainte-Anne-de-la-Perade, QC</option>
                            <option class="level-0" value="1983">Lac-Nominingue, QC</option>
                            <option class="level-0" value="1999">Gilbert Plains, MB</option>
                            <option class="level-0" value="2015">Kippens, NL</option>
                            <option class="level-0" value="2031">Fox Creek, AB</option>
                            <option class="level-0" value="2047">Point Edward, ON</option>
                            <option class="level-0" value="2063">Riviere-Beaudette, QC</option>
                            <option class="level-0" value="2079">Saint-Valerien-de-Milton, QC</option>
                            <option class="level-0" value="2095">Victoria, NL</option>
                            <option class="level-0" value="2111">Maugerville, NB</option>
                            <option class="level-0" value="2127">Kensington, PE</option>
                            <option class="level-0" value="2143">Wicklow, NB</option>
                            <option class="level-0" value="2159">Southesk, NB</option>
                            <option class="level-0" value="2175">Naramata, BC</option>
                            <option class="level-0" value="2191">Massey Drive, NL</option>
                            <option class="level-0" value="2207">Riviere-Blanche, QC</option>
                            <option class="level-0" value="2223">Humbermouth, NL</option>
                            <option class="level-0" value="2239">Pinawa, MB</option>
                            <option class="level-0" value="2255">Englehart, ON</option>
                            <option class="level-0" value="2271">Wotton, QC</option>
                            <option class="level-0" value="2287">Saint-Simon, QC</option>
                            <option class="level-0" value="2303">Petitcodiac, NB</option>
                            <option class="level-0" value="2319">L'Avenir, QC</option>
                            <option class="level-0" value="2335">Landmark, MB</option>

                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">I help with:</label>

                            <select name="help" multiple="multiple" class="form-control select2">
                                <option class="level-0" value="255">Anemia in pregnancy</option>
                                <option class="level-0" value="271">Depression</option>
                                <option class="level-0" value="287">Hormonal birth control transition</option>
                                <option class="level-0" value="303">Multiple sclerosis</option>
                                <option class="level-0" value="396">Example Ailment</option>
                                <option class="level-0" value="2663">Behavioral issues</option>
                                <option class="level-0" value="2679">Headaches</option>
                                <option class="level-0" value="2703">Pregnancy Loss</option>
                                <option class="level-0" value="2720">Restlessness</option>
                                <option class="level-0" value="2736">Hyperemesis Gravidarum</option>
                                <option class="level-0" value="2880">Frustration</option>
                                <option class="level-0" value="3104">Hot Flashes and Night sweast</option>
                                <option class="level-0" value="3148">Persistent Postural Perceptual Dizziness (PPPD)</option>
                                <option class="level-0" value="3297">pityriasis Alba</option>
                                <option class="level-0" value="123">Dropsy</option>
                                <option class="level-0" value="256">Ankylosing Spondylitis</option>
                                <option class="level-0" value="272">Digestive issues</option>
                                <option class="level-0" value="288">Hormone health</option>
                                <option class="level-0" value="304">Nervous system dysregulation</option>
                                <option class="level-0" value="2623">Liver health</option>
                                <option class="level-0" value="2664">Birth trauma</option>
                                <option class="level-0" value="2680">Hemorrhoids</option>
                                <option class="level-0" value="2704">Pregnancy</option>
                                <option class="level-0" value="2721">Reflux (GERD)</option>
                                <option class="level-0" value="2737">Morning Sickness</option>
                                <option class="level-0" value="2881">Mood</option>
                                <option class="level-0" value="3111">Exhaustion</option>
                                <option class="level-0" value="3149">Repetitive Strain</option>
                                <option class="level-0" value="3298">weight loss</option>
                                <option class="level-0" value="125">Tremors</option>
                                <option class="level-0" value="257">Anxieties</option>
                                <option class="level-0" value="273">Disconnection</option>
                                <option class="level-0" value="289">Insomnia</option>
                                <option class="level-0" value="305">Nervous system regulation</option>
                                <option class="level-0" value="2627">bloating</option>
                                <option class="level-0" value="2665">Breech</option>
                                <option class="level-0" value="2681">High blood pressure</option>
                                <option class="level-0" value="2705">Neurological tics</option>
                                <option class="level-0" value="2722">Separation anxiety</option>
                                <option class="level-0" value="2747">Menopause</option>
                                <option class="level-0" value="2882">Relationships</option>
                                <option class="level-0" value="3112">Perfectionism</option>
                                <option class="level-0" value="3150">neck pain</option>
                                <option class="level-0" value="3299">Pityriasis folliculitis (Malassezia) Weight loss</option>
                                <option class="level-0" value="134">Nervous System Reset</option>
                                <option class="level-0" value="258">Anxiety</option>
                                <option class="level-0" value="274">Emotional balance and release</option>
                                <option class="level-0" value="290">Joint pain</option>
                                <option class="level-0" value="306">Overwhelm</option>
                                <option class="level-0" value="2628">Fatty liver</option>
                                <option class="level-0" value="2666">Colic</option>
                                <option class="level-0" value="2682">Hyperactivity</option>
                                <option class="level-0" value="2706">Nightmares</option>
                                <option class="level-0" value="2723">Seizures</option>
                                <option class="level-0" value="2750">Stress</option>
                                <option class="level-0" value="2883">Sleep</option>
                                <option class="level-0" value="3113">Leadership skills</option>
                                <option class="level-0" value="3151">Scoliosis</option>
                                <option class="level-0" value="3300">coaching</option>
                                <option class="level-0" value="135">Concussion Recovery</option>
                                <option class="level-0" value="259">Body image</option>
                                <option class="level-0" value="275">Emotional blocks</option>
                                <option class="level-0" value="291">Lack of clarity</option>
                                <option class="level-0" value="307">PCOS (Polycystic Ovary Syndrome)</option>
                                <option class="level-0" value="2648">Muscle Tension</option>
                                <option class="level-0" value="2667">Developmental delays</option>
                                <option class="level-0" value="2683">Immune deficiencies</option>
                                <option class="level-0" value="2707">Night Terrors</option>
                                <option class="level-0" value="2724">Sensory issues</option>
                                <option class="level-0" value="2751">migraines</option>
                                <option class="level-0" value="2884">Work</option>
                                <option class="level-0" value="3114">Money mindset</option>
                                <option class="level-0" value="3152">Skin Issues</option>
                                <option class="level-0" value="3301">health coaching</option>
                                <option class="level-0" value="136">Trauma Recovery</option>
                                <option class="level-0" value="260">Burnout</option>
                                <option class="level-0" value="276">Emotional distress</option>
                                <option class="level-0" value="292">Lack of confidence</option>
                                <option class="level-0" value="308">Perimenopause</option>
                                <option class="level-0" value="2649">Limited Mobility</option>
                                <option class="level-0" value="2668">Eczema</option>
                                <option class="level-0" value="2692">Infertility</option>
                                <option class="level-0" value="2708">Ovarian cysts</option>
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
                                <option class="level-0" value="100">Practitioner Offerings</option>
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
                                <option value="156">energybalancing</option>
                                <option value="2991">ASD</option>
                        </select>

                        </div>

                        <h4 class="mb-4 featured-image-tag">Featured Image</h4>
                        <div class="mb-3">
                            <input type="file" id="fileInput" class="hidden" accept="image/*"
                                   onchange="previewImage(event)" style="display: none;">
                            <label for="fileInput" class="image-preview" id="imagePreview">
                                <span>+</span>
                            </label>
                            <p style="text-align: start;" class="text">Set featured image</p>
                        </div>
                        <hr>
                        <div class="container">
                            <div class="mb-4">
                                <label for="type" class="fw-bold">Type</label>
                                <select id="type" name="type" class="form-select ">
                                    <option>Bookable Product</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <ul class="nav nav-tabs" id="tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="general-tab" data-bs-toggle="tab"
                                           href="#general"
                                           role="tab" aria-controls="general"
                                           aria-selected="true">General</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="availability-tab" data-bs-toggle="tab"
                                           href="#availability" role="tab" aria-controls="availability"
                                           aria-selected="false">Availability</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="costs-tab" data-bs-toggle="tab"
                                           href="#costs" role="tab"
                                           aria-controls="costs" aria-selected="false">Costs</a>
                                    </li>
                                </ul>
                                <div class="tab-content mt-3" id="myTabContent">
                                    <!-- General Tab Content -->
                                    <div class="tab-pane fade show active" id="general" role="tabpanel"
                                         aria-labelledby="general-tab">
                                        <div class="mb-4">
                                            <label for="booking-duration" class="fw-bold">Booking
                                                duration</label>
                                            <select id="booking-duration" name="booking-duration" class="form-select">
                                                <option>Fixed blocks of</option>
                                            </select>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col">
                                                <input type="text" class="form-control" name="booking-duration_time" placeholder="">
                                            </div>
                                            <div class="col">
                                                <select class="form-select" name="booking-duration_unit">
                                                    <option value="month">Month(s)</option>
                                                    <option value="day">Day(s)</option>
                                                    <option value="hour">Hour(s)</option>
                                                    <option value="minute">Minute(s)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="calendar-display-mode" class="fw-bold">Calendar
                                                display
                                                mode</label>
                                            <select id="calendar-display-mode" name="calendar-display-mode" class="form-select">
                                                <option value="" selected="selected">Display calendar on click</option>
                                                <option value="always_visible">Calendar always visible</option>
                                            </select>
                                            <small class="form-text text-muted">Choose how the calendar is
                                                displayed on
                                                the booking form.</small>
                                        </div>
                                        <div class="mb-4">
                                            <div class="form-check offering-check">
                                                <input type="checkbox" class="form-check-input" id="requires-confirmation" name="confirmation_required">
                                                <label class="form-check-label" for="requires-confirmation">Requires
                                                    confirmation?</label>
                                            </div>
                                            <small class="form-text text-muted">Check this box if the
                                                booking requires
                                                admin approval/confirmation. Payment will not be taken
                                                during
                                                checkout.</small>
                                        </div>
                                        <div class="mb-4">
                                            <div class="form-check offering-check">
                                                <input type="checkbox" class="form-check-input" id="can-be-cancelled" name="can-be-cancelled">
                                                <label class="form-check-label" for="can-be-cancelled">Can be cancelled?</label>
                                            </div>
                                            <small class="form-text text-muted">Check this box if the
                                                booking can be
                                                cancelled by the customer after it has been purchased. A
                                                refund will not
                                                be sent automatically.</small>
                                        </div>
                                    </div>

                                    <!-- Availability Tab Content -->
                                    <div class="tab-pane fade" id="availability" role="tabpanel"
                                         aria-labelledby="availability-tab">
                                        <div class="col mb-3">
                                            <label for="booking">Max bookings per block</label>
                                            <input type="number" class="form-control" placeholder="" name="max_bookings_per_block">
                                            <p style="text-align: start;">The maximum bookings allowed for
                                                each block. Can be overridden at resource level.</p>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col">
                                                <label for="minimum">Minimum block bookable</label>
                                                <input type="text" class="form-control" placeholder="" name="minimum_block_bookable">
                                            </div>
                                            <div class="col">
                                                <label for="into-future">Into the future</label>
                                                <select class="form-select" name="into_future">
                                                    <option>Month(s)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col">
                                                <label for="maximum">Maximum block bookable</label>
                                                <input type="text" class="form-control" placeholder="" name="maximum_block_bookable">
                                            </div>
                                            <div class="col">
                                                <label for="into-future">Into the future</label>
                                                <select class="form-select" name="into_future">
                                                    <option>Month(s)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col mb-3">
                                            <label for="booking">Require a buffer period between bookings</label>
                                            <input type="number" class="form-control" placeholder="" name="buffer_period">

                                        </div>
                                        <div class="col- mb-3">
                                            <label for="dates">All dates are...</label>
                                            <select class="form-select" name="all_dates">
                                                <option>available by default</option>
                                                <option>not-available by default</option>
                                                <p>This option affects how you use the rules below.</p>
                                            </select>
                                        </div>
                                        <div class="col- mb-3">
                                            <label for="dates">Check rules against...</label>
                                            <select class="form-select" name="check_rules">
                                                <option>All blocks being booked</option>
                                                <option>The sgtarting block only</option>
                                                <p>This option affects how bookings are checked for
                                                    availability.</p>
                                            </select>
                                        </div>
                                        <div class="form-check offering-check mb-3">
                                            <input type="checkbox" class="form-check-input" id="can-be-cancelled" name="can-be-cancelled">
                                            <label class="form-check-label" for="can-be-cancelled">Restrict start days?</label>
                                        </div>
                                        <div class=" mb-4">
                                            <label for="minimum">First block starts at...</label>
                                            <input type="tdateext" class="form-control" placeholder="" name="first_block_starts_at">
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Range type</th>
                                                    <th scope="col">Range</th>
                                                    <th scope="col">Bookable</th>
                                                    <th scope="col">Priority</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <button class="export-btn">
                                                            Add Range
                                                        </button>
                                                    </td>
                                                    <td colspan="3" class="bg-custom "> Rules with lower
                                                        numbers will execute first. Rules further down this
                                                        table with the same priority will also execute
                                                        first.
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Costs Tab Content -->
                                    <div class="tab-pane fade" id="costs" role="tabpanel"
                                         aria-labelledby="costs-tab">
                                        <div class="mb-3">
                                            <label for="base-cost" class="form-label">Base Cost</label>
                                            <input type="text" class="form-control" id="base-cost" name="base_cost">
                                            <div class="form-text">One-off cost for the booking as a
                                                whole.
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="block-cost" class="form-label">Block Cost</label>
                                            <input type="text" class="form-control" id="block-cost" name="block_cost">
                                            <div class="form-text">This is the cost per block booked. All
                                                other costs
                                                (for resources and persons) are added to this.
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="display-cost" class="form-label">Display
                                                Cost</label>
                                            <input type="text" class="form-control" id="display-cost" name="display_cost">
                                            <div class="form-text">The cost is displayed to the user on the
                                                frontend.
                                                Leave blank to have it calculated for you. If a booking has
                                                varying
                                                costs, this will be prefixed with the word "from:".
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Range type</th>
                                                    <th scope="col">Range</th>
                                                    <th scope="col">Base cost <i
                                                            class="fas fa-question-circle text-muted"></i>
                                                    </th>
                                                    <th scope="col">Block cost <i
                                                         w   class="fas fa-question-circle text-muted"></i>
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <button class="export-btn">
                                                            Add Range
                                                        </button>
                                                    </td>
                                                    <td colspan="3" class="bg-custom ">All matching rules
                                                        will be
                                                        applied to the booking.
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex" style="gap: 20px;">
                                <button class="update-btn m-0">Add Offering</button>
                                <button class="update-btn">Save Draft</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

