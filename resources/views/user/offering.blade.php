@extends('layouts.app')
@section('content')
<?php
    /* echo '<pre>';
    Print_r($offerings);
    echo '</pre>';
    exit(); */
?>
    <section class="practitioner-profile">
        <div class="container">
            <div class="row">
                @include('layouts.partitioner_nav')
                offering
                <div class="wcv-cols-group wcv-horizontal-gutters">
	<div class="all-100">

	<table role="grid" class="wcvendors-table wcvendors-table-product wcv-table">

		
<!-- Output the table header -->
<thead>
<tr>
							<th class="tn"><i class="wcv-icon wcv-icon-image"></i></th>
					<th class="details">Details</th>
					<th class="price"><i class="wcv-icon wcv-icon-shopping-cart"></i></th>
					<th class="status">Status</th>
	</tr>
</thead>
		
<tbody>

	
	<tr>

		
			
			
			<td class="tn">				<!-- Row Action output -->
							</td>

		
			
			<td class="details"><h4>Test my offer</h4>
					<div class="wcv_mobile_status wcv_mobile">Online</div>
					<div class="wcv_mobile_price wcv_mobile"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>0.00</bdi></span></div>
					<div class="cat_tags">Categories: <a href="" rel="tag">Practitioner Offerings</a> <br>Tags: <a href="/" rel="tag">Egg</a></div>				<!-- Row Action output -->
														
<div class="row-actions row-actions-product">
	<a href="">Edit</a><a href="">Duplicate</a><a href="" target="_blank">View</a></div>
												</td>	
			
			<td class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>0.00</bdi></span>				<!-- Row Action output -->
							</td>		
			
			<td class="status"><span class="status online">Online</span><br>
					<span class="product_type bookable-product">Bookable Product</span><br>
					<span class="product_date">January 26, 2025</span><br>
					<span class="stock_status"></span>				<!-- Row Action output -->
							</td>

		
	</tr>

</tbody>

	</table>

	</div>
	</div>
            </div>
        </div>
    </section>

@endsection
